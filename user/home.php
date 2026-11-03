<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'overview' => 'user/home.php',
];
$page=screen_page($screens,'overview');
$page_role='user';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'overview':
page_start('Home','Home',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Home') ?>Home</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">A little progress, every day.</p>
        </div>
      </div>
      <div class="stack">
        <section class="panel announcement-banner">
          <div class="panel-heading">
            <h2>Around campus</h2>
          </div>
          <div><?php $list_kind='announcements'; include __DIR__ . '/../includes/record_list.php'; ?></div>
        </section>
        <div class="grid-3">
          <article class="metric">
            <div class="metric-label">
              Green Points
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Green Points')); ?></p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Current rank
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Current rank  No activity recorded yet.')); ?></p>
            <p class="metric-note">Based on saved records.</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Challenges completed
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Challenges completed')); ?></p>
          </article>
        </div>
        <div class="grid-2">
          <section class="panel panel--feature">
            <div class="panel-heading">
              <h2>Your active challenge</h2>
            </div>
            <?php show_active_challenge(); ?>
            <a class="button button--primary" href="../user/challenges.php?view=challenges-browse">Browse challenges</a>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Your next milestone</h2>
            </div>
            <a class="text-link" href="../user/account.php?view=achievements-locked">See locked achievements</a>
            <?php show_next_milestone(); ?>
          </section>
        </div>
        <div class="grid-2">
          <section class="panel">
            <div class="panel-heading">
              <h2>Recent challenges</h2>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <caption class="visually-hidden">Recent challenge status</caption>
                <thead>
                  <tr>
                    <th scope="col">Challenge</th>
                    <th scope="col">Status</th>
                    <th scope="col">Points</th>
                  </tr>
                </thead>
                <tbody><?php $kind='submissions'; $columns=['Challenge', 'Status', 'Points']; include __DIR__ . '/../includes/table.php'; ?></tbody>
              </table>
            </div>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Your activity</h2>
            </div>
            <ol class="activity-list">
              <?php show_recent_activity(); ?>
            </ol>
          </section>
        </div>
      </div>
    </main>
  
<?php page_end(); break;
}
