# Verification

Verified against a separate temporary MariaDB instance, not the user's imported database.

- 82 original screens mapped into exactly 16 role PHP files (four per role).
- Original styles.css unchanged byte for byte; existing assets retained. Small icons and logout text treatment use assets/finishing.css.
- All page routes and rendered links checked by HTTP.
- Login, registration, readable password changes, role restrictions, permission persistence and faculty boundaries checked.
- Real PNG evidence upload and owner download checked; review reason validation, revision/resubmission, approval checks, final-decision lock and one-time rewards checked.
- Management create/edit/delete actions, announcement/activity/report creation and actual report attachment downloads, badge rules, point deductions and audit creation checked.
- Final tier/history suite passed 2322 HTTP/integration/management checks; 23 readable-password handler checks and 6 native-alert behavior checks also passed.
- Highest-tier boundaries 0/5/19/20/49/50 bottles checked; one family card replaces lower levels. Six calendar months include zero-activity gaps. Historical additions are idempotent and preserve all existing records.
- PHP syntax, JavaScript syntax, popup behavior and archive contents checked.
- Independent read-only code review completed; management findings fixed and covered by regression checks; tier review completed and zero-month chart finding fixed.

HTTP checks exercise actual PHP handlers and MySQL queries. They do not replace manual visual testing in every browser/device.
