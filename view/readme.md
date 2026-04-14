# projetWeb2A25 — WorkWave

<<<<<<< HEAD
Root folder: **`Model/`**, **`View/`**, **`Controller/`** only (plus optional root `index.php` redirect).

| URL | Purpose |
|-----|---------|
| `.../Controller/index.php` | App entry |
| `.../Controller/index.php?action=admin_login` | Admin login |
| `.../Model/setup_admin.php` | One-time admin setup (delete after) |

Copy project into `htdocs/workwave`, import `Model/create_tables.sql`, set DB in `Model/Database.php`, run setup once, open `Controller/index.php`.
=======
## Folder layout (MVC only at project root)

The **project root** must contain **only** three folders:

| Folder | Role |
|--------|------|
| **`Model/`** | PDO, SQL scripts, entities (`User`, `Job`), `Database.php`, one-time `setup_admin.php` |
| **`View/`** | Templates, assets, uploads — and this `readme.md` |
| **`Controller/`** | Controllers and **`index.php`** (front controller / entry URL) |

There are **no** `index.php`, `readme.md`, or `setup_admin.php` files at the root: they live inside MVC as above.

## URLs (example: site in `htdocs/workwave/`)

| What | Open in browser |
|------|------------------|
| Application | `http://localhost/workwave/Controller/index.php` |
| Home | `.../Controller/index.php` or `.../Controller/index.php?action=home` |
| Admin setup (once) | `http://localhost/workwave/Model/setup_admin.php` — **delete after use** |

## Run locally

1. Copy the project under your web root (e.g. `htdocs/workwave/`).
2. Import `Model/create_tables.sql` (or `Model/migration_add_jobs_table.sql`) in phpMyAdmin.
3. Edit `Model/Database.php` if your MySQL user/password differ.
4. Run `Model/setup_admin.php` once, then **delete** that file.
5. Use **`Controller/index.php`** as the main page for the site.
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b
