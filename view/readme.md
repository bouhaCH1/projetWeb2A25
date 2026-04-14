# projetWeb2A25 — WorkWave

Root folder: **`Model/`**, **`View/`**, **`Controller/`** only (plus optional root `index.php` redirect).

| URL | Purpose |
|-----|---------|
| `.../Controller/index.php` | App entry |
| `.../Controller/index.php?action=admin_login` | Admin login |
| `.../Model/setup_admin.php` | One-time admin setup (delete after) |

Copy project into `htdocs/workwave`, import `Model/create_tables.sql`, set DB in `Model/Database.php`, run setup once, open `Controller/index.php`.
