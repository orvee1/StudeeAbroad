StudeeAbroad cPanel upload package

1. Extract studeeabroad-app.zip in your account home directory. It creates /home/CPANEL_USER/studeeabroad.
2. Extract public_html.zip into /home/CPANEL_USER/public_html.
3. Create /home/CPANEL_USER/studeeabroad/.env from .env.example. Set APP_ENV=production, APP_DEBUG=false, APP_URL, APP_KEY and the cPanel database credentials. Never put .env in public_html.
4. The public package expects the private app folder beside public_html and named studeeabroad. If your host uses another layout, update the two private paths in public_html/index.php.
5. Import the database through phpMyAdmin, or ask the provider to run php artisan migrate --force from the private app folder. Do not run db:seed; the project seeder creates demo accounts and fetches university data online.
6. public_html.zip includes current storage/app/public images in public_html/storage for hosts without symlink support. The private app also contains storage/app/public; keep it writable for future uploads.
7. Set storage and bootstrap/cache writable by PHP (ask the host; 775 is a common starting point). Do not use 777.

The archives exclude .env, .git, node_modules and tests. Composer dependencies are installed without dev packages; compiled Vite assets and current uploaded images are included.
