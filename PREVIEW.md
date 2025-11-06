# Share a Preview of the Website (No Domain/Hosting)

This project is a Laravel app with a MySQL database. You can share a temporary, secure preview link in minutes without buying a domain or hosting.

Pick one method below.

---

## Option A (Recommended): Cloudflare Tunnel
- Free, stable URL, works great for demos.

### 1) Run the app locally
You need PHP 8.1+, Composer, and either SQLite (easiest for demos) or MySQL.

Quick SQLite setup (no MySQL needed):
1. Copy env file and set app key
   - Copy `.env.example` to `.env`
   - Set `APP_ENV=production`, `APP_DEBUG=false` (for demo)
   - Change DB to SQLite in `.env`:
     ```env
     DB_CONNECTION=sqlite
     DB_DATABASE=database/database.sqlite
     DB_FOREIGN_KEYS=true
     ```
2. Create the SQLite file:
   - Create an empty file at `database/database.sqlite`
3. Install and boot the app:
   - `composer install`
   - `php artisan key:generate`
   - `php artisan migrate --seed`
   - `php artisan serve` (default: http://127.0.0.1:8000)

Admin demo logins (seeded):
- Super Admin: `admin@binaadultcare.com` / `Admin@123`
- Content Editor: `editor@binaadultcare.com` / `Editor@123`

If you prefer MySQL locally, ensure `.env` has valid MySQL credentials and run the same `migrate --seed` command.

### 2) Expose it securely with Cloudflare Tunnel
1. Install Cloudflare Tunnel (cloudflared): https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/downloads/
2. In a new terminal, run:
   ```bash
   cloudflared tunnel --url http://localhost:8000
   ```
3. Copy the https URL it prints (e.g., https://blue-sun-1234.trycloudflare.com) and share with your client.

Tip: Keep the app terminal and the tunnel terminal open while the client is reviewing.

---

## Option B: ngrok
- Simple and popular; free accounts rotate URLs.

1. Download & install: https://ngrok.com/download
2. Start your Laravel app locally (see SQLite steps above).
3. Run ngrok:
   ```bash
   ngrok http 8000
   ```
4. Share the https forwarding URL shown by ngrok.

---

## Option C: Temporary Cloud Deploy (Railway/Render)
Good if you want a public URL that works even when your PC is offline.

High-level steps (Railway example):
1. Push your repo to GitHub (private is fine) if not already.
2. Create a Railway project (https://railway.app), choose Deploy from GitHub.
3. Add a MySQL plugin (managed DB) and copy its credentials.
4. Set environment variables in Railway:
   - `APP_KEY` (generate locally with `php artisan key:generate --show`)
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (from the plugin)
5. In the deploy shell or a release command, run:
   - `php artisan migrate --force --seed`
6. Open the Railway-provided URL and share it.

Notes:
- This repo includes Docker assets, but the docker-compose currently references `./backend`/`./frontend` paths that don't exist; use a single Dockerfile deploy or the plain PHP runtime template instead.

---

## Prevent accidental indexing during preview
Because the link is public, search engines could discover it. For demos, you can:
- Keep `APP_ENV=production` and `APP_DEBUG=false`.
- Add a temporary `<meta name="robots" content="noindex, nofollow">` in your public-facing layouts (remove after launch), or
- Use a robots.txt that disallows all during the demo.

---

## Troubleshooting
- If styles don't update, run `php artisan view:clear`.
- If images/uploads fail on cloud deploy, you may need a writable storage path or a persistent volume. For a demo, seed example content.
- If sessions log you out quickly, ensure `APP_KEY` is set and `SESSION_DRIVER=file` works on the server.

---

Need help picking an option? For a same-day demo, use Option A or B. For a link that works when your PC is off, use Option C.
