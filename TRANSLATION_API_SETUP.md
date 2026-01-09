# Translation feature removed

The automatic translation feature (Google Translate integration) has been **removed** from the codebase per request.

What changed:
- `app/Filament/Resources/OfferResource.php` now reverts to copying English fields to Arabic without calling any external API.
- `config/services.php` no longer contains the Google Translate key entry.
- `.env` no longer requires `GOOGLE_TRANSLATE_API_KEY`.
- `app/Services/TranslationService.php` has been deprecated and retained for reference.

If you want to re-enable automatic translation later, follow the original setup steps in the project's Git history or ask me to re-add the integration.
