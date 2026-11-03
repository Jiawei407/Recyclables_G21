# UI port verification

Verified 4 November 2026, based on Recyclables_G21 main commit `0e0cde5c9025c8e6b8bef3e478db5edf0785d0dd`.

## Scope

The approved role UI is adapted to all 82 logical screens inside this repository's 16 physical role PHP files. The physical files and their allowed-view switches remain unchanged. This is a presentation port; backend changes from the earlier repository are not imported.

The scoped styles retain the approved paper/forest/lime palette, expressive home/profile pages, restrained functional pages and separator lines. Native-backed selectors, challenge/campaign choices, date pickers and quantity buttons preserve actual form fields. The redundant coordinator queue shortcut and administrator platform-status banner are removed as requested.

The shared rendering hook follows authentication and POST processing. It retains actual `?view=` URLs, selected IDs, CSRF tokens, form actions, submitter values, original validation, review reasons and read-only states. Dynamic records and dashboard/badge content are excluded from UI-copy replacements. Real private media continues to use the original authorized file endpoint.

## Preserved source contracts

The following are byte-identical to the upstream baseline: all 16 role files, all action handlers, routes, account/upload/review rules, data and metrics functions, badge tier code, chart/dashboard functions, database setup/configuration, private file delivery, shared layout, public homepage/login/registration, original `styles.css` and `assets/finishing.css`.

The only modified existing application files are `includes/bootstrap.php` (the role presentation hook) and `scripts/app.js` (retain searchable metadata while excluding mobile column labels; keep the modal focus trap compatible with dynamic controls). Scoped presentation assets, tests and documentation are added separately.

## Results

| Check | Result |
| --- | --- |
| PHP unit/contract tests | 19 tests; passed |
| JavaScript regression tests | 20 tests; passed |
| Role screen/browser checks | 82 screens × 320px/1440px = 164 checks; passed |
| axe-core 4.10.3 checks on representative screens | 22 page/viewport checks; zero violations |
| Live workflow assertions | 7; passed |
| PHP syntax | All source and test PHP files passed |
| Impeccable mechanical detector | No findings in changed presentation targets |

The browser pass checks successful responses, role headers, horizontal overflow, broken images, CSRF fields and absence of prototype controls or HTML-only links. It uses the teammate's full seeded setup in a new disposable schema, including badge tiers and historical chart data. Screenshots were visually inspected for home, profile editing and the review dialog.

Live workflows log in as all four roles, submit an image/quantity through the grouped evidence route, enforce an explanation for `Other`, approve evidence, verify its saved participant result, check final-review controls stay disabled, publish an announcement through the themed calendar, check the administrator role field's real form payload, and reject unauthorized access to an administrator route.

These are new-repository tests; the previous repository's PHP test count does not apply here. They do not certify every backend edge case or assistive-technology interaction. The backend, setup data and original account rules are deliberately retained.

## Running and merging

Use the existing repository installation instructions and `TEST-ACCOUNTS.md`. This UI port does not rename the configured database, reset accounts or require a SQL import on an existing compatible installation. Developer tests require PHPUnit 9, Node, Playwright/Chromium and optionally axe-core; the website itself has no new frontend build dependency.

The branch starts from this repository's main history and can be reviewed/merged here. Do not merge the old repository wholesale over the teammate's grouped implementation. Test reports, screenshots, sessions and fixture uploads are excluded from the commit.
