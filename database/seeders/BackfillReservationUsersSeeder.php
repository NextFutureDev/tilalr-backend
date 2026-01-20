<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class BackfillReservationUsersSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting backfill: reservations -> user_id');

        $updated = 0;
        $skippedNoEmail = 0;
        $skippedNoUser = 0;

        Reservation::whereNull('user_id')
            ->chunkById(200, function ($reservations) use (&$updated, &$skippedNoEmail, &$skippedNoUser) {
                foreach ($reservations as $reservation) {
                    // Normalize email (trim + lowercase) for matching
                    $emailRaw = $reservation->email;
                    $email = $emailRaw ? trim(strtolower($emailRaw)) : null;

                    if (empty($email)) {
                        $skippedNoEmail++;
                        continue;
                    }

                    // Build list of email variants to try (aggressive for Gmail)
                    $emailsToTry = [$email];

                    // If gmail/googlemail, add variants: remove plus tags and dots
                    if (str_ends_with($email, '@gmail.com') || str_ends_with($email, '@googlemail.com')) {
                        [$local, $domain] = explode('@', $email, 2);
                        // remove +alias
                        $localNoPlus = preg_replace('/\+.*/', '', $local);
                        // remove dots
                        $localNoDots = str_replace('.', '', $localNoPlus);

                        $emailsToTry[] = $localNoPlus . '@gmail.com';
                        $emailsToTry[] = $localNoDots . '@gmail.com';
                    }

                    // Try each email variant sequentially
                    $user = null;
                    foreach (array_unique($emailsToTry) as $try) {
                        $user = User::whereRaw('LOWER(email) = ?', [$try])->first();
                        if ($user) break;
                    }

                    // If still no email match, try phone-based match (normalize digits only)
                    if (!$user && $reservation->phone) {
                        $phone = preg_replace('/[^0-9]/', '', $reservation->phone);
                        if (!empty($phone)) {
                            // Try exact match on digits-only phone
                            $user = User::whereRaw("REPLACE(REPLACE(REPLACE(REGEXP_REPLACE(phone, '[^0-9]', ''), ' ', ''), '-', ''), '(', '') = ?", [$phone])->first();

                            // Or fallback to contains
                            if (!$user) {
                                $user = User::whereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', '') LIKE ?", ["%$phone%"])->first();
                            }
                        }
                    }

                    if (!$user) {
                        $skippedNoUser++;
                        continue;
                    }

                    $reservation->user_id = $user->id;
                    $reservation->save();
                    $updated++;
                }
            });

        $this->command->info("Backfill complete: updated={$updated}, skipped_no_email={$skippedNoEmail}, skipped_no_user={$skippedNoUser}");
        Log::info('BackfillReservationUsersSeeder completed', compact('updated', 'skippedNoEmail', 'skippedNoUser'));
    }
}
