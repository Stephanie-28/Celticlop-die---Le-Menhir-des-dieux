# Repository Guidelines

## Project Structure & Module Organization

The active application lives in `app/` and follows Symfony conventions. Domain models are in `app/src/Entity`, database access classes in `app/src/Repository`, enums in `app/src/Enum`, and HTTP controllers belong in `app/src/Controller`. Framework and service configuration is under `app/config/`; versioned Doctrine migrations are stored in `app/migrations/`; the web entry point is `app/public/index.php`. Project analysis and diagrams are kept in `docs/Dossier_De_Projet/`. Treat `old/` as legacy reference code, not a target for new features. Docker setup is defined by the root `docker-compose.yml` and `docker/php/dockerfile`.

## Build, Test, and Development Commands

Run container commands from the repository root:

- `docker compose up --build`: build the PHP/Apache image and start the app and MySQL; browse to `http://localhost:8000`.
- `docker compose exec php composer install`: install dependencies from `app/composer.lock`.
- `docker compose exec php php bin/console doctrine:migrations:migrate`: apply pending schema migrations.
- `docker compose exec php php bin/console doctrine:schema:validate`: verify that Doctrine mappings match the database.
- `docker compose exec php php bin/console cache:clear`: rebuild Symfony's cache after configuration changes.

## Coding Style & Naming Conventions

Use PHP 8.4 features and Symfony conventions. Follow PSR-4 (`App\` maps to `app/src/`) and PSR-12 formatting: four-space indentation, one class per file, and opening braces on the next line. Name classes in PascalCase, methods and properties in camelCase, and migration files using Doctrine's generated `VersionYYYYMMDDHHMMSS.php` pattern. Use typed properties, return types, PHP attributes for Doctrine metadata, and constructor injection for services. Preserve the settings in `app/.editorconfig`.

## Testing Guidelines

No automated test suite or PHPUnit dependency is currently committed. For each change, at minimum run `doctrine:schema:validate` and exercise affected routes or console commands. When adding tests, place them under `app/tests/`, mirror the `App` namespace structure, and name files `*Test.php`; add PHPUnit as a development dependency and document the test command in the pull request.

## Commit & Pull Request Guidelines

Existing history uses short, outcome-focused French commit subjects (for example, `Modélisation Doctrine terminée et base synchronisée`). Keep each commit focused and use an imperative, descriptive subject in French or the language of the surrounding work. Pull requests should explain the change, validation performed, and any migration or configuration impact. Link relevant issues and include screenshots for visible UI changes. Never commit secrets, local `.env` overrides, `app/vendor/`, or generated cache files from `app/var/`.
