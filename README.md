[![Build Status](https://travis-ci.com/mjducharme/drawl-website.svg?branch=master)](https://travis-ci.org/mjducharme/drawl-website)

## About WLAR - Web Linguistics Audio Recorder

WLAR is a web application designed to facilitate linguistics research projects. It takes the user through a wizard that explains the project and conducts a survey to collect data from the user. The user is then brought to a final page where they read and can record text. Their responses and recording are saved onto the server.

WLAR is developed using the Laravel framework on PHP.

### WLAR Contributors

- Dimitri Prica
- Marton Soskuthy
- Roger Lo
- Michael Ducharme

### Installation

Requires PHP 8.3 or newer (tested on PHP 8.5) with the gd, mbstring, xml, zip, pdo_sqlite and intl extensions, and Composer 2. The app runs on Laravel 13.

Needs more detail, but:

1. Fetch the repository and run "composer install" in the root to install dependencies.
2. Edit config/app.php and set wlar_languages list. Also set wlar_email_required, wlar_request_consent_publication, and wlar_additional_reading_enabled as necessary for your project.
3. Create empty file database/database.sqlite
4. Then run "php artisan migrate" to create the SQLite tables for administration interface.
5. Copy .env.example to .env and customize as necessary.
6. Run php artisan key:generate to generate key.

**WARNING** - First user to register for administration interface (/admin URL) is given admin rights, they can authorise further users from there. **AFTER DEPLOYING, REGISTER IMMEDIATELY** to prevent someone else from doing so.

Language translation files and placeholder text (which can be easily modified) can be found in resources/lang/en/messages.php and the /resources/views folder structure. The consent form submission data and questionnaire responses are saved as JSON in /storage/app/json. The audio clips are uploaded to /storage/app/audio. The default audio can be changed from wav to 320Kbps mp3 or mono WAV to save space and decrease upload times by changing the setting in /public/js/main.js.

Note: Each time you change a language file (ex. adding a new language translation, changing an existing translation) you need to rerun php artisan lang:js to re-generate the javascript version (/public/messages.js) to ensure that the javascript translations match the php translations.
