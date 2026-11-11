# UI port tests

From the repository root, obtain PHPUnit 9.6 at `tools/phpunit-9.phar` (ignored), then run:

```powershell
& C:\xampp\php\php.exe -d extension=gd tools/phpunit-9.phar -c phpunit.xml
node --test tests/js/*.test.cjs
```

The PHP tests verify the native form/CSRF/media/data contracts and grouped route map, plus unchanged review rules. JavaScript tests cover native number/date fields, inherited disabled states, record search metadata/status filters and modal keyboard focus.

## Browser integration

Use a new, empty disposable database namespace and an isolated PHP server. `prepare.php` refuses existing schemas and imports the application schema and `tests/fixtures/sample-data.sql` into the selected test database. It adds a marker and workflow fixtures, and writes a route catalog under ignored `.runtime/`.

```powershell
$env:RECYCLABLES_TEST_DB_NAME = 'recyclables_test_g21_unique_suffix'
$env:RECYCLABLES_TEST_DB_HOST = '127.0.0.1'
$env:RECYCLABLES_TEST_DB_PORT = '3306'
$env:RECYCLABLES_TEST_DB_USER = 'root'
$env:RECYCLABLES_TEST_DB_PASSWORD = ''
& C:\xampp\php\php.exe tests/prepare.php
```

In the server shell, set those same test variables, then map them to the separate application settings. Choose an unused loopback port, keep the token for the browser runner, and use an absolute session directory:

```powershell
foreach ($key in 'HOST','PORT','NAME','USER','PASSWORD') {
  [Environment]::SetEnvironmentVariable('RECYCLABLES_DB_'+$key,[Environment]::GetEnvironmentVariable('RECYCLABLES_TEST_DB_'+$key))
}
$env:RECYCLABLES_TEST_SERVER_TOKEN = [guid]::NewGuid().ToString('N')
$sessionPath = (Resolve-Path tests/.runtime).Path
& C:\xampp\php\php.exe -d extension=gd -d "session.save_path=$sessionPath" -S 127.0.0.1:8133 -t . tests/Support/server-router.php
```

Back in the runner shell, install/resolve Playwright for developer tests or provide its module path. Use its installed Chromium or set `RECYCLABLES_CHROME` to a Chrome executable. Optionally supply a local axe-core `axe.min.js`:

```powershell
$env:RECYCLABLES_BROWSER_URL = 'http://127.0.0.1:8133'
$env:RECYCLABLES_TEST_SERVER_TOKEN = '<same token as the test server>'
# Optional: RECYCLABLES_PLAYWRIGHT_MODULE, RECYCLABLES_CHROME, RECYCLABLES_AXE_PATH
node tests/browser/roles.cjs
```

The runner verifies the server token, schema and marker before submitting anything. It uses the supplied test credentials and fixture catalog, visits all 82 logical screens at two widths, and exercises the role workflows. Use a fresh schema for a clean repeat. Stop the test server afterward and retire its marked schema and uploaded fixture files.
