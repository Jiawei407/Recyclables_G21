<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'analytics' => 'coordinator/analytics.php',
    'overview' => 'coordinator/home.php',
];
$page=screen_page($screens,'overview');
$page_role='coordinator';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'analytics':
page_start('Campus analytics','Analytics',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Campus analytics') ?>Campus analytics</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Use participation and completed actions to understand the program’s progress.</p>
        </div>
      </div>
      <div class="stack">
        <div class="grid-3">
          <article class="metric">
            <div class="metric-label">
              Most popular
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <circle cx="9" cy="7" r="3"></circle>
                <path d="M3 20v-2a6 6 0 0 1 12 0v2M16 4a3 3 0 0 1 0 6m2 4a5 5 0 0 1 3 4v2"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Most popular  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Least popular
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Least popular  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Completion rate
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="m5 12 4 4L19 6"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Completion rate  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
        </div>
        <div class="grid-2">
          <section class="panel stack" aria-labelledby="activity-title">
            <h2 id="activity-title">Campus activity</h2>
            <p class="note">Last six calendar months</p>
            <figure class="chart-figure">
              <figcaption>Approved activities by month</figcaption>
              <div><?php include __DIR__ . '/../includes/chart.php'; ?></div></figure>
            <details>
              <summary>Daily and weekly views</summary>
              <?php show_activity_periods(); ?>
            </details>
          </section>
          <section class="panel stack" aria-labelledby="faculty-chart-title">
            <h2 id="faculty-chart-title">Participation by faculty</h2>
            <p class="note">Students who have joined at least one challenge.</p>
            <div class="progress-block">
              <div class="progress-label">
                <span>School of Computing</span>
                <strong><?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Computing'])['total']; ?></strong>
              </div>
              <progress value="<?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Computing'])['total']; ?>" max="<?php echo max(1,(int)one('SELECT COUNT(*) AS total FROM users WHERE role=\'user\' AND status=\'active\' AND faculty=?',['School of Computing'])['total']); ?>" aria-label="School of Computing">Faculty participants</progress>
              <p class="field-hint">Members who have joined a challenge</p>
            </div>
            <div class="progress-block">
              <div class="progress-label">
                <span>School of Engineering</span>
                <strong><?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Engineering'])['total']; ?></strong>
              </div>
              <progress value="<?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Engineering'])['total']; ?>" max="<?php echo max(1,(int)one('SELECT COUNT(*) AS total FROM users WHERE role=\'user\' AND status=\'active\' AND faculty=?',['School of Engineering'])['total']); ?>" aria-label="School of Engineering">Faculty participants</progress>
              <p class="field-hint">Members who have joined a challenge</p>
            </div>
            <div class="progress-block">
              <div class="progress-label">
                <span>School of Business</span>
                <strong><?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Business'])['total']; ?></strong>
              </div>
              <progress value="<?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Business'])['total']; ?>" max="<?php echo max(1,(int)one('SELECT COUNT(*) AS total FROM users WHERE role=\'user\' AND status=\'active\' AND faculty=?',['School of Business'])['total']); ?>" aria-label="School of Business">Faculty participants</progress>
              <p class="field-hint">Members who have joined a challenge</p>
            </div>
            <div class="progress-block">
              <div class="progress-label">
                <span>School of Media</span>
                <strong><?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Media'])['total']; ?></strong>
              </div>
              <progress value="<?php echo (int)one('SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.faculty=?',['School of Media'])['total']; ?>" max="<?php echo max(1,(int)one('SELECT COUNT(*) AS total FROM users WHERE role=\'user\' AND status=\'active\' AND faculty=?',['School of Media'])['total']); ?>" aria-label="School of Media">Faculty participants</progress>
              <p class="field-hint">Members who have joined a challenge</p>
            </div>
          </section>
        </div>
        <section class="panel stack" aria-labelledby="analytics-table-title">
          <h2 id="analytics-table-title">Challenge performance</h2>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">participation and completion by challenge</caption>
              <thead>
                <tr>
                  <th scope="col">Activity</th>
                  <th scope="col">Participants</th>
                  <th scope="col">Completion</th>
                  <th scope="col">Trend</th>
                </tr>
              </thead>
              <tbody><?php $kind='challenges'; $columns=['Activity', 'Participants', 'Completion', 'Trend']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
          <details>
            <summary class="icon-disclosure" title="Show campus challenge analytics breakdown">
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="m6 9 6 6 6-6"></path>
              </svg>
              <span class="disclosure-open-label visually-hidden">Show campus challenge analytics breakdown</span>
              <span class="disclosure-collapse-label">Close details<span class="visually-hidden">: campus challenge analytics breakdown</span> </span>
            </summary>
            <div class="stack">
              <p>Participant counts describe joined challenges. Completion uses approved evidence divided by joined records. Trend compares this period with the previous period.</p>
              <dl class="detail-list">
                <div>
                  <dt>Period</dt>
                  <dd><?php echo e($record['period'] ?? 'Not selected'); ?></dd>
                </div>
                <div>
                  <dt>Evidence source</dt>
                  <dd>—</dd>
                </div>
                <div>
                  <dt>Scope</dt>
                  <dd>—</dd>
                </div>
              </dl>
            </div>
          </details>
        </section>
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
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">A clear view of your campus program and the reviews that need a human eye.</p>
        </div>
      </div>
      <div class="stack">
        <section class="panel panel--forest grid-2" aria-labelledby="program-title">
          <div class="stack">
            <h2 id="program-title">A growing campus.<br>A thoughtful review.</h2>
            <p class="context-line">Program status</p>
            <p>Create challenges and review evidence to start tracking the campus program.</p>
            <div>
              <a class="button button--primary" href="../coordinator/submissions.php?view=submissions-pending">Open review queue</a>
            </div>
          </div>
          <figure class="media-figure">
            <img class="card-media" src="../assets/nature/meadow.jpg" alt="" width="1800" height="1010" loading="lazy">
          </figure>
        </section>
        <div class="grid-2">
          <section class="panel stack" aria-labelledby="urgent-title">
            <h2 id="urgent-title">Needs your attention</h2>
            <p class="context-line">Your next priorities</p>
            <div class="table-wrap">
              <table class="data-table">
                <caption class="visually-hidden">coordinator priority queues</caption>
                <thead>
                  <tr>
                    <th scope="col">Queue</th>
                    <th scope="col">State</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody><?php $kind='submissions'; $columns=['Queue', 'State', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
              </table>
            </div>
            <p class="note">Evidence and suspected duplicates are checked by a person before a decision is made.</p>
          </section>
          <section class="panel stack" aria-labelledby="participation-title">
            <h2 id="participation-title">Participation</h2>
            <figure class="chart-figure">
              <figcaption>No data available</figcaption>
              <svg class="line-chart" viewbox="0 0 600 190" role="img" aria-label="No data available">
                <text x="300.0" y="95.0" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="16">
                  No data available
                </text>
              </svg>
            </figure>
            <a class="text-link" href="../coordinator/home.php?view=analytics">
              Explore analytics
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M6 18 18 6M6 6h12v12"></path>
              </svg>
            </a>
          </section>
        </div>
        <section class="panel stack" aria-labelledby="target-title">
          <h2 id="target-title">Monthly campaign target</h2>
          <div class="progress-block">
            <div class="progress-label">
              <span>Participants reached</span>
              <strong>—</strong>
            </div>
            <progress value="0" max="1" aria-label="Participants reached">
              No progress data available
            </progress>
            <p class="field-hint">No progress data available.</p>
          </div>
          <p class="note">Celebrate progress across faculties, then use the campaign view to see where a reminder may help.</p>
          <details class="disclosure">
            <summary class="icon-disclosure" title="Show monthly campaign performance">
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="m6 9 6 6 6-6"></path>
              </svg>
              <span class="disclosure-open-label visually-hidden">Show monthly campaign performance</span>
              <span class="disclosure-collapse-label">Close details<span class="visually-hidden">: monthly campaign performance</span> </span>
            </summary>
            <div class="stack">
              <p>No campaign selected</p>
              <dl class="detail-list">
                <div>
                  <dt>Participants</dt>
                  <dd><?php echo e($record['participants'] ?? 'Not selected'); ?></dd>
                </div>
                <div>
                  <dt>Approved actions</dt>
                  <dd>—</dd>
                </div>
                <div>
                  <dt>Campaign period</dt>
                  <dd>—</dd>
                </div>
              </dl>
            </div>
          </details>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
}
