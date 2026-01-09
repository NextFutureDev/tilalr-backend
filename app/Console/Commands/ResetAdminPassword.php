<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {email=admin@example.com} {password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        // Update the password
        $user->update([
            'password' => Hash::make($password),
        ]);

        $this->info("Password reset successfully!");
        $this->info("Email: {$email}");
        $this->info("New Password: {$password}");
        $this->warn("Please change the password after first login!");

        return 0;
    }
}
