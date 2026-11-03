<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'audit-log-audit-details' => 'admin/audit-log-audit-details.php',
    'audit-log' => 'admin/audit-log.php',
    'overview' => 'admin/home.php',
    'impact-analytics' => 'admin/impact-analytics.php',
    'reports-faculty-report' => 'admin/reports-faculty-report.php',
    'reports-faculty-reports' => 'admin/reports-faculty-reports.php',
];
$page=screen_page($screens,'overview');
$page_role='admin';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'audit-log-audit-details':
page_start('Audit Log','Audit Log',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Audit Log') ?>Audit Log</h1>
          <p class="context-line">Administrator</p>
        </div>
      </div>
      <div class="stack">
        <a class="button button--outline" href="../admin/home.php?view=audit-log">All audit records</a>
        <article class="panel stack">
          <h2>Audit record</h2>
          <p class="context-line">No audit record selected</p>
          <details class="disclosure" open>
            <summary class="icon-disclosure" title="Hide audit record details">
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="m6 9 6 6 6-6"></path>
              </svg>
              <span class="disclosure-open-label visually-hidden">Hide audit record details</span>
              <span class="disclosure-collapse-label">Close details<span class="visually-hidden">: audit record details</span> </span>
            </summary>
            <dl class="detail-list">
              <div>
                <dt>Administrator</dt>
                <dd>—</dd>
              </div>
              <div>
                <dt>Participant</dt>
                <dd><?php echo e($record['full_name'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Submission</dt>
                <dd><?php echo e($record['id'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Points</dt>
                <dd>—</dd>
              </div>
              <div>
                <dt>Reason</dt>
                <dd>—</dd>
              </div>
            </dl>
          </details>
        </article>
      </div>
    <div class="dialog-content"><?php if ($record) echo '<h3>' . e($record['action']) . '</h3><p>' . e($record['details']) . '</p><p>' . e($record['created_at']) . ' · ' . e($record['full_name']) . '</p>'; ?></div></main>
  
<?php page_end(); break;
case 'audit-log':
page_start('Audit Log','Audit Log',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Audit Log') ?>Audit Log</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">A readable record of the decisions behind campus progress.</p>
        </div>
      </div>
      <div class="stack">
        <section class="panel">
          <div class="panel-heading">
            <h2>Find a recorded action</h2>
          </div>
          <div class="toolbar" role="form">
            <div class="field">
              <label for="audit-range">Date range</label>
              <select id="audit-range" name="audit-range">
                <option value="" selected>All time</option>
              </select>
            </div>
            <div class="field">
              <label for="audit-actor">Actor</label>
              <select id="audit-actor" name="audit-actor">
                <option value="" selected>All actors</option>
              </select>
            </div>
            <div class="field">
              <label for="audit-action">Action type</label>
              <select id="audit-action" name="audit-action">
                <option selected>All actions</option>
                <option>Point correction</option>
                <option>Approval</option>
                <option>Role change</option>
                <option>Account suspension</option>
              </select>
            </div>
          </div>
        </section>
        <article class="panel stack"><?php $list_kind='audit'; include __DIR__ . '/../includes/record_list.php'; ?></article>
      </div>
    </main>
  
<?php page_end(); break;
case 'overview':
page_start('Home','Home',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Home') ?>Home</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">A clear view of the platform, the people, and the progress we share.</p>
        </div>
      </div>
      <div class="stack">
        <div class="status-banner">
          <div>
            <h2>Good. Keep the campus growing.</h2>
            <p class="context-line">Platform status</p>
            <p>No point corrections are awaiting review.</p>
          </div>
          <a class="button button--lime" href="../admin/manage.php?view=leaderboard-point-corrections">Review corrections</a>
        </div>
        <div class="metric-grid">
          <article class="metric">
            <div class="metric-label">
              Total users
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Total users  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Active challenges
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Active challenges  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Submissions
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Submissions  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Active today
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Active today  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
        </div>
        <div class="grid-2">
          <section class="panel">
            <div class="panel-heading">
              <h2>People making progress</h2>
              <p class="muted">Participation appears here when records are available.</p>
            </div>
            <figure class="chart">
              <svg class="chart-svg" viewbox="0 0 493 240" role="img" aria-label="No data available">
                <text x="246.5" y="120.0" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="16">
                  No data available
                </text>
              </svg>
              <figcaption class="muted">No data available</figcaption>
              <details class="disclosure">
                <summary>View chart data</summary>
                <div class="table-wrap">
                  <table class="data-table">
                    <caption class="visually-hidden">Participant count this week data</caption>
                    <thead>
                      <tr>
                        <th scope="col">Period</th>
                        <th scope="col">Participants</th>
                      </tr>
                    </thead>
                    <tbody><?php $kind='participants-by-month'; $columns=['Period', 'Participants']; include __DIR__ . '/../includes/table.php'; ?></tbody>
                  </table>
                </div>
              </details>
            </figure>
          </section>
          <div class="stack">
            <section class="panel panel--sage">
              <div class="panel-heading">
                <h2>Review now</h2>
              </div>
              <div class="queue-row">
                <div>
                  <strong>Point corrections</strong>
                  <p class="muted">No corrections to review.</p>
                </div>
                <span class="queue-count">—</span>
              </div>
              <a class="text-link" href="../admin/manage.php?view=leaderboard-point-corrections">Open the review list <span aria-hidden="true">↗</span> </a>
            </section>
            <section class="panel">
              <div class="panel-heading">
                <h2>Sustainability impact</h2>
              </div>
              <p class="eyebrow">Reported waste collected</p>
              <p class="display-number">—</p>
              <p class="muted">Recorded from reviewed submissions and faculty reports.</p>
              <a class="text-link" href="../admin/home.php?view=impact-analytics">Explore campus impact <span aria-hidden="true">↗</span> </a>
            </section>
          </div>
        </div>
      </div>
    </main>
  
<?php page_end(); break;
case 'impact-analytics':
page_start('Impact Analytics','Impact Analytics',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Impact Analytics') ?>Impact Analytics</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Small actions, seen together. Explore the campus impact.</p>
        </div>
      </div>
      <div class="stack">
        <div class="metric-grid">
          <article class="metric">
            <div class="metric-label">
              Waste diverted
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Waste diverted  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              CO₂ avoided
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('CO₂ avoided  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Sustainable actions
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Sustainable actions  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Monthly change
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Monthly change  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
        </div>
        <div class="grid-2">
          <section class="panel">
            <div class="panel-heading">
              <h2>Monthly environmental impact</h2>
            </div>
            <figure class="chart">
              <svg class="chart-svg" viewbox="0 0 493 240" role="img" aria-label="No data available">
                <text x="246.5" y="120.0" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="16">
                  No data available
                </text>
              </svg>
              <figcaption class="muted">No data available</figcaption>
              <details class="disclosure">
                <summary>View chart data</summary>
                <div class="table-wrap">
                  <table class="data-table">
                    <caption class="visually-hidden">Reported waste diverted data</caption>
                    <thead>
                      <tr>
                        <th scope="col">Period</th>
                        <th scope="col">Kg</th>
                      </tr>
                    </thead>
                    <tbody><?php $kind='unconfigured-impact'; $columns=['Period', 'Kg']; include __DIR__ . '/../includes/table.php'; ?></tbody>
                  </table>
                </div>
              </details>
            </figure>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Impact by action type</h2>
            </div>
            <figure class="chart">
              <svg class="chart-svg" viewbox="0 0 363 240" role="img" aria-label="No data available">
                <text x="181.5" y="120.0" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="16">
                  No data available
                </text>
              </svg>
              <figcaption class="muted">No data available</figcaption>
              <details class="disclosure">
                <summary>View chart data</summary>
                <div class="table-wrap">
                  <table class="data-table">
                    <caption class="visually-hidden">Reviewed actions data</caption>
                    <thead>
                      <tr>
                        <th scope="col">Period</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody><?php $kind='actions-by-month'; $columns=['Period', 'Actions']; include __DIR__ . '/../includes/table.php'; ?></tbody>
                  </table>
                </div>
              </details>
            </figure>
          </section>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Annual campus impact target</h2>
          </div>
          <div class="progress-heading">
            <strong>—</strong>
            <span class="muted">No target configured.</span>
          </div>
          <progress max="1" value="0">
            No progress data available
          </progress>
          <p class="muted">No annual target configured.</p>
        </section>
        <section class="panel">
          <h2>Impact breakdown</h2>
          <details class="disclosure" id="impact-breakdown">
            <summary class="icon-disclosure" title="Show campus impact sources">
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="m6 9 6 6 6-6"></path>
              </svg>
              <span class="disclosure-open-label visually-hidden">Show campus impact sources</span>
              <span class="disclosure-collapse-label">Close details<span class="visually-hidden">: campus impact sources</span> </span>
            </summary>
            <div class="stack">
              <p>Waste totals use reported kilograms. Other action types remain counts; no unsupported CO₂ conversion is added.</p>
              <div class="table-wrap">
                <table class="data-table">
                  <caption class="visually-hidden">Campus impact sources</caption>
                  <thead>
                    <tr>
                      <th scope="col">Source</th>
                      <th scope="col">Recorded outcome</th>
                      <th scope="col">Period</th>
                    </tr>
                  </thead>
                  <tbody><?php $kind='unconfigured-impact'; $columns=['Source', 'Recorded outcome', 'Period']; include __DIR__ . '/../includes/table.php'; ?></tbody>
                </table>
              </div>
            </div>
          </details>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'reports-faculty-report':
page_start('Reports','Reports',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Reports') ?>Reports</h1>
          <p class="context-line">Administrator</p>
        </div>
      </div>
      <div class="stack">
        <a class="button button--outline" href="../admin/home.php?view=reports-faculty-reports">All faculty reports</a>
        <article class="panel stack">
          <h2>Faculty report</h2>
          <p class="context-line"><?php echo e($record['activity'] ?? 'Select a report from the report list.'); ?></p>
          <p class="muted"><?php echo e($record['activity'] ?? 'Select a report from the report list.'); ?></p>
          <details class="disclosure" open>
            <summary class="icon-disclosure" title="View report details">View report details</summary>
            <div class="stack">
              <section>
                <h3>Activity results</h3>
                <div class="table-wrap">
                  <table class="data-table">
                    <caption class="visually-hidden">Faculty report activity results</caption>
                    <thead>
                      <tr>
                        <th scope="col">Activity</th>
                        <th scope="col">Participants</th>
                        <th scope="col">Outcome</th>
                      </tr>
                    </thead>
                    <tbody><?php $kind='reports'; $columns=['Activity', 'Participants', 'Outcome']; include __DIR__ . '/../includes/table.php'; ?></tbody>
                  </table>
                </div>
              </section>
              <section>
                <h3>Notes</h3>
                <p><?php echo e($record['outcome'] ?? 'No report selected.'); ?></p>
              </section>
              <section>
                <h3>Attachments</h3>
                <details class="disclosure">
                  <summary class="icon-disclosure" title="View attachment">View attachment</summary>
                  <div class="attachment-paper"><?php if (!empty($record['attachment'])) echo '<a class="text-link" href="' . e($base) . '/file.php?type=report&amp;id=' . (int)$record['id'] . '">Download attachment</a>'; else echo '<p>No attachment supplied.</p>'; ?></div>
                </details>
              </section>
            </div>
          </details>
        </article>
      </div>
    <section class="panel stack"><?php if ($record) { echo '<h2>' . e($record['activity']) . '</h2><p>' . e($record['outcome']) . '</p><p>' . e($record['faculty']) . ' · ' . e($record['period']) . ' · Participants: ' . (int)$record['participants'] . '</p>'; if ($record['attachment']) echo '<a class="text-link" href="' . e($base) . '/file.php?type=report&amp;id=' . (int)$record['id'] . '">Download attachment</a>'; } ?></section></main>
  
<?php page_end(); break;
case 'reports-faculty-reports':
page_start('Reports','Reports',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Reports') ?>Reports</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">See the outcomes faculty representatives have reported.</p>
        </div>
      </div>
      <div class="stack">
        <div class="toolbar" role="search">
          <div class="field">
            <label for="search-reports">Search reports</label>
            <input id="search-reports" name="search-reports" type="search" placeholder="Search reports">
          </div>
          <div class="field">
            <label for="report-faculty">Faculty</label>
            <select id="report-faculty" name="report-faculty">
              <option selected>All faculties</option>
              <option>School of Computing</option>
              <option>School of Engineering</option>
              <option>School of Business</option>
<option>School of Media</option>
            </select>
          </div>
        </div>
        <article class="panel stack"><?php $list_kind='reports'; include __DIR__ . '/../includes/record_list.php'; ?></article>
      </div>
    </main>
  
<?php page_end(); break;
}
