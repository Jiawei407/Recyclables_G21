<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'submit-report-activity-report' => 'faculty/submit-report-activity-report.php',
    'submit-report-reports' => 'faculty/submit-report-reports.php',
    'submit-report-submit-report' => 'faculty/submit-report-submit-report.php',
];
$page=screen_page($screens,'submit-report-reports');
$page_role='faculty';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'submit-report-activity-report':
page_start('Submit Report','Submit Report',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submit Report') ?>Submit Report</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Record your activities and observed outcomes.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/reports.php?view=submit-report-reports" class="is-active" aria-current="page">Reports</a>
          <a href="../faculty/reports.php?view=submit-report-submit-report">Submit report</a>
        </nav>
        <div class="form-actions">
          <a class="button button--primary" href="../faculty/reports.php?view=submit-report-submit-report">Submit report</a>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty reports</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty report history</caption>
              <thead>
                <tr>
                  <th scope="col">Report</th>
                  <th scope="col">Period</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='reports'; $columns=['Report', 'Period', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    <section class="panel stack"><?php if ($record) { echo '<h2>' . e($record['activity']) . '</h2><p>' . e($record['outcome']) . '</p><p>' . e($record['faculty']) . ' · ' . e($record['period']) . ' · Participants: ' . (int)$record['participants'] . '</p>'; if ($record['attachment']) echo '<a class="text-link" href="' . e($base) . '/file.php?type=report&amp;id=' . (int)$record['id'] . '">Download attachment</a>'; } ?></section></main>
  
<?php page_end(); break;
case 'submit-report-reports':
page_start('Submit Report','Submit Report',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submit Report') ?>Submit Report</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Record your activities and observed outcomes.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/reports.php?view=submit-report-reports" class="is-active" aria-current="page">Reports</a>
          <a href="../faculty/reports.php?view=submit-report-submit-report">Submit report</a>
        </nav>
        <div class="form-actions">
          <a class="button button--primary" href="../faculty/reports.php?view=submit-report-submit-report">Submit report</a>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty reports</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty report history</caption>
              <thead>
                <tr>
                  <th scope="col">Report</th>
                  <th scope="col">Period</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='reports'; $columns=['Report', 'Period', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'submit-report-submit-report':
page_start('Submit Report','Submit Report',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submit Report') ?>Submit Report</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Record your activities and observed outcomes.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/reports.php?view=submit-report-reports">Reports</a>
          <a href="../faculty/reports.php?view=submit-report-submit-report" class="is-active" aria-current="page">Submit report</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Submit report</h2>
          </div>
          <div class="form-grid">
            <div class="field">
              <label for="report-activity">Activity</label>
              <input id="report-activity" name="report-activity" type="text" placeholder="Activity" form="backend-form">
            </div>
            <div class="field">
              <label for="report-period">Period</label>
              <select id="report-period" name="report-period" form="backend-form">
                <option>All time</option>
                <option>Current month</option>
                <option>Previous month</option>
              </select>
            </div>
            <div class="field">
              <label for="report-participants">Participants</label>
              <input id="report-participants" name="report-participants" type="number" placeholder="Participants" form="backend-form">
            </div>
            <div class="field">
              <label for="report-outcome">Outcomes</label>
              <input id="report-outcome" name="report-outcome" type="text" placeholder="Outcomes" form="backend-form">
            </div>
            <div class="field field-full">
              <label for="report-attachment">Attachment</label>
              <input id="report-attachment" name="report-attachment" type="file" accept="application/pdf" form="backend-form">
              <small>Select a PDF report from your device.</small>
            </div>
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit" form="backend-form">Submit report</button>
            <a class="button button--outline" href="../faculty/reports.php?view=submit-report-reports">Cancel</a>
          </div>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-report" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
}
