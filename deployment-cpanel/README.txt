StudeeAbroad cPanel upload package

1. Extract studeeabroad-app.zip in your account home directory. It creates /home/CPANEL_USER/studeeabroad.
2. Extract public_html.zip into /home/CPANEL_USER/public_html.
3. Create /home/CPANEL_USER/studeeabroad/.env from .env.example. Set APP_ENV=production, APP_DEBUG=false, APP_URL, APP_KEY and the cPanel database credentials. Never put .env in public_html.
4. The public package expects the private app folder beside public_html and named studeeabroad. If your host uses another layout, update the two private paths in public_html/index.php.
5. Import the database through phpMyAdmin, or ask the provider to run php artisan migrate --force from the private app folder. Do not run db:seed; the project seeder creates demo accounts and fetches university data online.
6. If public_html/storage is a real folder rather than a symlink to the private app's storage/app/public, set PUBLIC_STORAGE_PATH=/home/CPANEL_USER/public_html/storage in the private app's .env. This makes new public uploads appear in cPanel's public_html/storage folder and serve from /storage URLs. Leave it unset when public_html/storage is a symlink.
7. After changing .env, clear Laravel's cached config from the private app folder with php artisan config:clear. Ensure public_html/storage, storage, and bootstrap/cache are writable by PHP (ask the host; 775 is a common starting point). Do not use 777.

The archives exclude .env, .git, node_modules and tests. Composer dependencies are installed without dev packages; compiled Vite assets and current uploaded images are included.
