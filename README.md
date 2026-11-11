# Recyclables

## Approved UI port

The grouped role pages use the approved forest, paper and lime interface. Each role keeps its four PHP files and existing `?view=` navigation.

The presentation hook in `includes/bootstrap.php` runs after authentication and POST processing. `includes/role-presentation.php` transforms only role output, loading scoped styles from `assets/role-ui/` and progressive native-field controls from `scripts/role-controls.js` and `scripts/role-selections.js`. PHP DOM/XML is needed for the new presentation; without it, the original functional role UI remains usable. No npm build step or database re-import is required for an existing installation.

See [UI-PORT-VERIFICATION.md](UI-PORT-VERIFICATION.md) for validation and [tests/README.md](tests/README.md) for repeatable tests.

## Replace your project files

1. If C:\xampp\htdocs\Coding already exists, rename that folder to Coding-backup first. Keep it until the new version works.
2. Extract this ZIP. Place its new Coding folder at C:\xampp\htdocs\Coding. Start with this clean folder so old role PHP files do not remain alongside the new four-file structure.
3. Copy your uploaded files from Coding-backup/storage/uploads to the new Coding/storage/uploads.
4. Enable `extension=gd` in XAMPP's `php.ini` for badge uploads. For the full 5 MB upload limit, set `upload_max_filesize` to at least `5M` and `post_max_size` to at least `6M`.
5. Start Apache and MySQL in XAMPP. In phpMyAdmin, select your existing Recyclables database and import `database/upgrade-g21-bug-fixes.sql`. It adds the fields used by permissions, point reversals, achievement rules and audit history.
6. Open http://localhost/Coding/ and log in with your existing account.

The default connection in includes/config.php uses database recyclables, host 127.0.0.1, user root and an empty password. The upgrade preserves existing records. For a fresh installation, import `database/setup.sql`, register your first account and set that account's role to `admin` in the `users` table. Use the admin account to create the other staff accounts.

Do not merge the old role PHP files back into the new project. Use the new links from the homepage. Bookmark URLs have changed because the old pages are grouped into four files per role.

## Four PHP files per role

| Role | Files and responsibilities |
|---|---|
| Registered user | home.php: dashboard; challenges.php: browse/join/completed; evidence.php: upload/status/details; account.php: profile/password/badges/leaderboards |
| Faculty representative | home.php: dashboard/participation/insights; challenges.php: promotions/activities; announcements.php: faculty notices; reports.php: submit/view/download |
| Coordinator | home.php: dashboard/analytics; manage.php: challenges/campaigns/announcements; submissions.php: evidence reviews; account.php: profile/password |
| Administrator | home.php: dashboard/reports/analytics/audit; users.php: accounts/permissions; achievements.php: badges/requirements; manage.php: challenge balancing/point corrections |

Shared code is outside these role folders. Public login, registration, homepage and file downloads remain separate.

## Code to explain in your presentation

- Each role file has a list of allowed views and a switch statement selecting its screen.
- includes/layout.php supplies the shared header, navigation, logo and icons.
- includes/bootstrap.php starts the session, connects to MySQL and checks the role and form token.
- includes/functions.php supplies small MySQLi helpers, uploads, redirects and success messages.
- includes/data.php reads records and calculates badge progress; includes/metrics.php calculates dashboard values.
- actions/accounts.php handles login, registration and account changes; actions/challenges.php handles challenges, reviews and campaigns; actions/faculty.php handles faculty activities/reports; actions/admin.php handles administrative actions.
- includes/routes.php keeps shared links and redirects pointed at the new grouped pages.
- scripts/app.js adds filtering, upload previews and form checks; scripts/feedback.js displays the native success/error popup.

## Accounts and validation

The application keeps the existing coursework account rules. The disposable fixtures use the credentials in `TEST-ACCOUNTS.md`.

Student email must end with @mail.apu.edu.my. Student ID is uppercase TP followed by six digits. New passwords need 8-72 characters and a special character. Each faculty representative is linked to their own faculty. Representatives cannot edit another faculty's announcements or reports.

## Reviews and rewards

All three reviewer checks are required for approval. Rejection and revision require a selected reason. Other requires an explanation. Coordinator decisions are read-only after review. An administrator can open an approved submission from a student's points history, reject it with a reason and reverse its award once. The original ledger entry and its reversal remain visible in the points history.

Only approved submissions count toward badge rules. Badge families upgrade through Bronze, Silver and Gold, showing only the highest earned level. Each earned card shows the next target until Gold. Administrators can edit the family, level and requirements separately. Existing independent custom badges still work. A campaign bonus is awarded once per user after all its linked challenges are approved. Points and campaign awards are stored in MySQL.

Badge uploads accept JPG and PNG images from 128 × 128 through 2048 × 2048 pixels, up to 5 MB. The fixed tracked-item choices include plastic bottles, reusable cups, and aluminum cans. These item rules sum approved quantities. Activity and challenge rules count approved submissions.

## Coursework data

The site reads the records in the configured database. The former setup fixtures are now loaded by `tests/prepare.php` into a separate disposable database. Existing installations that previously imported the fixtures still retain those rows. See [tests/README.md](tests/README.md) for the fixture and test-server commands.
