<?php
require_once __DIR__.'/../includes/routes.php';
$screens = [
    'audit-log-audit-details' => 'admin/audit-log-audit-details.php',
    'audit-log' => 'admin/audit-log.php',
    'overview' => 'admin/home.php',
    'impact-analytics' => 'admin/impact-analytics.php',
    'reports-faculty-report' => 'admin/reports-faculty-report.php',
    'reports-faculty-reports' => 'admin/reports-faculty-reports.php',
];
$page = screen_page($screens, 'overview');
$page_role = 'admin';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
require_once __DIR__.'/../includes/audit.php';

function admin_disclosure_summary($show, $hide) {
    ?>
    <summary class="disclosure-toggle button button--outline">
      <span class="disclosure-open-label"><?= e($show) ?></span>
      <span class="disclosure-collapse-label"><?= e($hide) ?></span>
      <svg class="icon" aria-hidden="true" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>
    </summary>
    <?php
}

function admin_activity_chart($chart_kind, $chart_series, $column) {
    ?>
    <figure class="chart">
      <?php include __DIR__.'/../includes/chart.php'; ?>
      <details class="disclosure">
        <?php admin_disclosure_summary('Show chart data', 'Hide chart data'); ?>
        <div class="table-wrap">
          <table class="data-table">
            <caption class="visually-hidden"><?= e($chart_title) ?></caption>
            <thead><tr><th scope="col">Month</th><th scope="col"><?= e($column) ?></th></tr></thead>
            <tbody>
              <?php foreach ($chart_series as $point): ?>
              <tr><td><?= e($point['period']) ?></td><td><?= (int)$point['actions'] ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </details>
    </figure>
    <?php
}

function admin_metric_cards($cards) {
    ?>
    <div class="metric-grid">
      <?php foreach ($cards as $card): ?>
      <article class="metric">
        <div class="metric-label"><?= e($card[0]) ?></div>
        <p class="metric-value"><?= e($card[1]) ?></p>
        <?php if (isset($card[2])): ?><p class="metric-note"><?= e($card[2]) ?></p><?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
    <?php
}

function admin_audit_fields($entry, $detail_url = '') {
    $action_text = e(audit_action_text($entry));
    ?>
    <dl class="detail-list">
      <div><dt>User</dt><dd><?= e($entry['display_name']) ?></dd></div>
      <div><dt>Role</dt><dd><?= e(audit_role_label($entry['recorded_role'])) ?></dd></div>
      <div><dt>Action taken</dt><dd>
        <?php if ($detail_url): ?><a class="text-link" href="<?= e($detail_url) ?>"><?= $action_text ?></a>
        <?php else: ?><?= $action_text ?><?php endif; ?>
      </dd></div>
      <div><dt>Date</dt><dd><time datetime="<?= e(str_replace(' ', 'T', $entry['created_at'])) ?>"><?= e($entry['created_at']) ?></time></dd></div>
    </dl>
    <?php
}

switch ($view) {
case 'audit-log-audit-details':
    $filters = array_filter(audit_filter_values($_GET), static fn($value) => $value !== '');
    $back_url = route_url('admin/audit-log.php' . ($filters ? '?' . http_build_query($filters) : ''));
    page_start('Audit Log', 'Audit Log', false);
    ?>
    <main id="main-content" class="workspace-content">
      <?php include __DIR__.'/../includes/notices.php'; ?>
      <div class="page-header"><div><h1>Audit record</h1></div></div>
      <div class="stack">
        <div><a class="button button--outline" href="<?= e($back_url) ?>">All audit records</a></div>
        <?php if ($record): ?>
        <article class="panel"><?php admin_audit_fields($record); ?></article>
        <?php elseif (!$error): ?>
        <p class="empty-state">Choose an action from the audit log.</p>
        <?php endif; ?>
      </div>
    </main>
    <?php page_end(); break;

case 'audit-log':
    $filters = audit_filter_values($_GET);
    [$actors, $actions] = audit_filter_options();
    $invalid_range = $filters['from'] && $filters['to'] && $filters['from'] > $filters['to'];
    $entries = $invalid_range ? [] : audit_records($filters);
    $filter_query = http_build_query(array_filter($filters, static fn($value) => $value !== ''));
    page_start('Audit Log', 'Audit Log', false);
    ?>
    <main id="main-content" class="workspace-content">
      <?php include __DIR__.'/../includes/notices.php'; ?>
      <div class="page-header"><div><h1>Audit Log</h1></div></div>
      <div class="stack">
        <section class="panel" aria-labelledby="audit-filter-heading">
          <h2 id="audit-filter-heading">Filter audit records</h2>
          <form class="stack" action="../admin/home.php" method="get">
            <input type="hidden" name="view" value="audit-log">
            <div class="grid-3">
              <div class="field">
                <label for="audit-from">From date</label>
                <input type="date" id="audit-from" name="from" value="<?= e($filters['from']) ?>">
              </div>
              <div class="field">
                <label for="audit-to">To date</label>
                <input type="date" id="audit-to" name="to" value="<?= e($filters['to']) ?>">
              </div>
              <div class="field">
                <label for="audit-user">User</label>
                <select id="audit-user" name="audit-user">
                  <option value="">All users</option>
                  <?php foreach ($actors as $actor => $label): ?>
                  <option value="<?= e($actor) ?>" <?= $filters['audit-user'] === $actor ? 'selected' : '' ?>><?= e($label) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label for="audit-role">Role</label>
                <select id="audit-role" name="audit-role">
                  <option value="">All roles</option>
                  <?php foreach (['user', 'faculty', 'coordinator', 'admin'] as $actor_role): ?>
                  <option value="<?= e($actor_role) ?>" <?= $filters['audit-role'] === $actor_role ? 'selected' : '' ?>><?= e(audit_role_label($actor_role)) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label for="audit-action">Action type</label>
                <select id="audit-action" name="audit-action">
                  <option value="">All actions</option>
                  <?php foreach ($actions as $action => $label): ?>
                  <option value="<?= e($action) ?>" <?= $filters['audit-action'] === $action ? 'selected' : '' ?>><?= e($label) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label for="audit-search">Search actions</label>
                <input type="search" id="audit-search" name="audit-search" maxlength="200" value="<?= e($filters['audit-search']) ?>">
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="button button--primary">Apply filters</button>
              <a class="button button--outline" href="../admin/home.php?view=audit-log">Clear filters</a>
            </div>
          </form>
        </section>
        <?php if ($invalid_range): ?>
        <p role="alert">The start date must be on or before the end date.</p>
        <?php elseif (!$entries): ?>
        <p class="empty-state">No audit records match these filters.</p>
        <?php else: ?>
        <section aria-label="Audit records">
          <?php foreach ($entries as $entry): ?>
          <article class="panel" data-record>
            <?php admin_audit_fields($entry, route_url('admin/audit-log-audit-details.php?id=' . (int)$entry['id'] . ($filter_query ? '&' . $filter_query : ''))); ?>
          </article>
          <?php endforeach; ?>
        </section>
        <?php endif; ?>
      </div>
    </main>
    <?php page_end(); break;

case 'overview':
    page_start('Home', 'Home', false);
    ?>
    <main id="main-content" class="workspace-content">
      <?php include __DIR__.'/../includes/notices.php'; ?>
      <div class="page-header"><div><h1>Home</h1></div></div>
      <div class="stack">
        <?php admin_metric_cards([
            ['Active participant accounts', metric('Total users')],
            ['Active challenges', metric('Active challenges')],
            ['Pending submissions', metric('Pending submissions')],
            ['Participants active today', active_participants_today(), 'Submitted evidence today'],
        ]); ?>
        <div class="grid-2">
          <section class="panel">
            <div class="panel-heading"><h2>Participant activity</h2></div>
            <p class="muted">Unique participants with approved evidence each month.</p>
            <?php admin_activity_chart('participants-by-month', calendar_series(page_records('participants-by-month')), 'Participants'); ?>
          </section>
          <div class="stack">
            <section class="panel">
              <div class="panel-heading"><h2>Sustainability impact</h2></div>
              <p class="display-number"><?= e(metric('Approved activities')) ?></p>
              <p>Approved activities</p>
              <a class="text-link" href="../admin/home.php?view=impact-analytics">Explore campus impact</a>
            </section>
            <section class="panel">
              <div class="panel-heading"><h2>Point corrections</h2></div>
              <a class="text-link" href="../admin/manage.php?view=leaderboard-point-corrections">Review participant points</a>
            </section>
          </div>
        </div>
      </div>
    </main>
    <?php page_end(); break;

case 'impact-analytics':
    $series = calendar_series(page_records('actions-by-month'));
    $impact = recorded_impact();
    $category_rows = rows("SELECT c.category, COUNT(*) AS actions FROM submissions s
        JOIN challenges c ON c.id=s.challenge_id WHERE s.status='approved'
        GROUP BY c.category ORDER BY actions DESC, c.category");
    page_start('Impact Analytics', 'Impact Analytics', false);
    ?>
    <main id="main-content" class="workspace-content">
      <?php include __DIR__.'/../includes/notices.php'; ?>
      <div class="page-header"><div><h1>Impact Analytics</h1></div></div>
      <div class="stack">
        <?php admin_metric_cards([
            ['Approved activities', $impact['actions']],
            ['Participants', $impact['participants'], 'Unique participants with approved evidence'],
            ['Recyclable items recorded', $impact['recyclables'], 'Plastic bottles and aluminum cans'],
            ['Monthly change', activity_monthly_change($series), 'Last two complete months'],
        ]); ?>
        <div class="grid-2">
          <section class="panel">
            <div class="panel-heading"><h2>Approved activities by month</h2></div>
            <?php admin_activity_chart('actions-by-month', $series, 'Approved activities'); ?>
          </section>
          <section class="panel">
            <div class="panel-heading"><h2>Approved activities by category</h2></div>
            <?php if ($category_rows): ?>
            <div class="table-wrap">
              <table class="data-table">
                <thead><tr><th scope="col">Category</th><th scope="col">Approved activities</th></tr></thead>
                <tbody>
                  <?php foreach ($category_rows as $category): ?>
                  <tr><td><?= e($category['category']) ?></td><td><?= (int)$category['actions'] ?></td></tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <?php else: ?>
            <p class="empty-state">No approved activities yet.</p>
            <?php endif; ?>
          </section>
        </div>
        <p class="muted">Waste weight and avoided emissions require measured quantities by weight.</p>
      </div>
    </main>
    <?php page_end(); break;

case 'reports-faculty-report':
    page_start('Reports', 'Reports', false);
    ?>
    <main id="main-content" class="workspace-content">
      <?php include __DIR__.'/../includes/notices.php'; ?>
      <div class="page-header"><div><h1>Faculty report</h1></div></div>
      <div class="stack">
        <div><a class="button button--outline" href="../admin/home.php?view=reports-faculty-reports">All faculty reports</a></div>
        <?php if ($record): ?>
        <article class="panel stack" data-record>
          <h2><?= e($record['activity']) ?></h2>
          <details class="disclosure" open>
            <?php admin_disclosure_summary('Show report details', 'Hide report details'); ?>
            <dl class="detail-list">
              <div><dt>Faculty</dt><dd><?= e($record['faculty']) ?></dd></div>
              <div><dt>Period</dt><dd><?= e($record['period']) ?></dd></div>
              <div><dt>Participants</dt><dd><?= (int)$record['participants'] ?></dd></div>
              <div><dt>Outcome</dt><dd><?= e($record['outcome']) ?></dd></div>
            </dl>
          </details>
          <?php if (!empty($record['attachment'])): ?>
          <details class="disclosure">
            <?php admin_disclosure_summary('View attachment', 'Hide attachment'); ?>
            <a class="text-link" href="<?= e($base) ?>/file.php?type=report&amp;id=<?= (int)$record['id'] ?>">Open report attachment</a>
          </details>
          <?php else: ?>
          <p class="muted">No attachment supplied.</p>
          <?php endif; ?>
        </article>
        <?php elseif (!$error): ?>
        <p class="empty-state">Choose a report from the report list.</p>
        <?php endif; ?>
      </div>
    </main>
    <?php page_end(); break;

case 'reports-faculty-reports':
    $reports = page_records('reports');
    page_start('Reports', 'Reports', false);
    ?>
    <main id="main-content" class="workspace-content">
      <?php include __DIR__.'/../includes/notices.php'; ?>
      <div class="page-header"><div><h1>Reports</h1></div></div>
      <div class="stack">
        <div class="toolbar" role="search">
          <div class="field">
            <label for="search-reports">Search reports</label>
            <input id="search-reports" name="search-reports" type="search">
          </div>
          <div class="field">
            <label for="report-faculty">Faculty</label>
            <select id="report-faculty" name="report-faculty">
              <option value="">All faculties</option>
              <?php foreach (faculties() as $report_faculty): ?>
              <option><?= e($report_faculty) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <section aria-label="Faculty reports">
          <?php if (!$reports): ?><p class="empty-state">No faculty reports available.</p><?php endif; ?>
          <?php foreach ($reports as $report): ?>
          <article class="panel stack" data-record data-status="<?= e(strtolower($report['faculty'])) ?>" data-search="<?= e($report['outcome']) ?>">
            <h2><?= e($report['activity']) ?></h2>
            <p class="muted"><?= e($report['faculty'] . ' · ' . $report['period']) ?></p>
            <a class="text-link" href="<?= e(route_url('admin/reports-faculty-report.php?id=' . (int)$report['id'])) ?>">View report details</a>
          </article>
          <?php endforeach; ?>
        </section>
      </div>
    </main>
    <?php page_end(); break;
}
