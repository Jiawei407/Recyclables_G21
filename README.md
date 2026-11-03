# Recyclables

## Replace your project files

1. If C:\xampp\htdocs\Coding already exists, rename that folder to Coding-backup first. Keep it until the new version works.
2. Extract this ZIP. Place its new Coding folder at C:\xampp\htdocs\Coding. Start with this clean folder so old role PHP files do not remain alongside the new four-file structure.
3. If you have actual uploaded files in Coding-backup/storage/uploads, copy those files into the new Coding/storage/uploads. This package includes an empty uploads folder; imported sample records have no photos.
4. Start Apache and MySQL in XAMPP.
5. Open http://localhost/Coding/ and log in with an account in TEST-ACCOUNTS.md.

The connection in includes/config.php uses database recyclables, host 127.0.0.1, user root and an empty password. If you renamed your imported database to recyclables, no SQL import is needed. This site does not import, delete or reset your database automatically.

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

The imported 30-account test set is supported. Passwords are readable in MySQL as explicitly requested for this lecture demonstration. Student passwords use the TP number followed by 123@. The login, registration, administrator account editor and password-change handler all use the same format.

Student email must end with @mail.apu.edu.my. Student ID is uppercase TP followed by six digits. New passwords need 8-72 characters and a special character. Each faculty representative is linked to their own faculty. Representatives cannot edit another faculty's announcements or reports.

## Reviews and rewards

All three reviewer checks are required for approval. Rejection/revision requires a selected reason; Other requires an explanation. Final decisions are read-only. A participant submits new evidence for another review. Successful form actions return to the parent page and show a native popup.

Only approved submissions count toward badge rules. Badge families upgrade through Bronze, Silver and Gold, showing only the highest earned level. Each earned card shows the next target until Gold. Administrators can edit the family, level and requirements separately. Existing independent custom badges still work. A campaign bonus is awarded once per user after all its linked challenges are approved. Points and campaign awards are stored in MySQL.

## Existing sample data

The original sample set has been extended with 14 fictional Malaysian students and 111 approved historical submissions across five earlier months. The live database has 45 accounts and 211 submissions, including your manually created account. A fresh setup has 44 accounts because it excludes manually created accounts. The added activity contributes points and updates both leaderboards and badge progress. All sample activity remains labelled as synthetic.

Imported submissions are synthetic records without image files. Their detail pages show a clear placeholder. Upload a new submission to test actual photo previews and downloads. Seeded reports have no attachment; submit a new report with a file to test downloads.

Database/setup.sql is an optional full setup for a fresh database named recyclables. You already imported your test data, so keep that database and do not import again for this file replacement.
