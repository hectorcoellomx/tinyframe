# AGENTS

## Fast facts (verified)
- This repo is a plain PHP microframework app (no `composer.json`, no `package.json`, no test/lint config, no CI workflow in-repo).
- Web entrypoint is `index.php`; routes are declared in `app/routes.php` and loaded via `Core\Route::loadMany(...)`.
- URL rewriting is required (`.htaccess`): requests are mapped to `index.php?route=...`, so run under Apache/XAMPP with `mod_rewrite` enabled.

## Required local setup
- Create `.env` from `env-example.txt`; `App\Config` reads only from root `.env`.
- Keep `BASE_URL` aligned with your local path (example in template is `http://localhost/tinyframe/`, but this repo path may differ).
- `STATUS_PROJECT=pro` disables displayed errors; use `dev` while developing.

## Routing, middleware, and request gotchas
- Route middleware names must match `/^[A-Z][a-zA-Z]*$/` and map to `app/middlewares/<Name>.php` with class `App\Middlewares\<Name>` and `run()`.
- For `POST|PUT|PATCH|DELETE`, CSRF is auto-enforced in `core/Route.php`; forms must include `csrf_field()` (or send `X-CSRF-TOKEN`).
- Dynamic route params like `/user/{id}` are exposed through `Request::url('id')`.

## Database driver quirk
- Runtime DB file is selected in `index.php`: only `DATABASES_DRIVER=ORACLE` loads `core/databases/DB_ORACLE.php`; any other value loads `core/databases/DB_MYSQL.php`.
- DB credentials are read from `.env` keys with prefixes like `DB_MYSQL_*` and `DB_ORACLE_*`.

## Code generation (CLI)
- Use `php create <command> <Entity[,Entity2]>` (the `create` file is not executable by default).
- Commands implemented in `core/CLI.php`: `c` (controller), `m` (model), `s` (service), `mi` (middleware), `li` (library), `full` (model+service+controller).

## High-value paths
- `app/controllers`, `app/services`, `app/models`, `app/views`: app MVC layers.
- `core/`: framework internals (`Route`, `Request`, `Controller`, `Validator`, DB adapters).
- `docs.html`: canonical usage examples for routes, validation, helpers, and CLI scaffolding.

## Verification without test suite
- There is no automated test command in this repo; verify changes by loading routes in a browser/Postman.
- Minimal smoke check after edits: `GET /`, `GET /login`, and any changed route with expected middleware/CSRF behavior.
