<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'overview' => 'faculty/home.php',
    'insights-achievements' => 'faculty/insights-achievements.php',
    'insights-leaderboard' => 'faculty/insights-leaderboard.php',
    'insights-overview' => 'faculty/insights-overview.php',
    'insights-reports' => 'faculty/insights-reports.php',
    'participation-campus-cleanup' => 'faculty/participation-campus-cleanup.php',
    'participation-challenge-participation' => 'faculty/participation-challenge-participation.php',
    'participation-completion-rates' => 'faculty/participation-completion-rates.php',
];
$page=screen_page($screens,'overview');
$page_role='faculty';
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
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">A little progress, every day.</p>
        </div>
      </div>
      <div class="stack">
        <div class="grid-3">
          <article class="metric">
            <div class="metric-label">
              Faculty Green Points
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Faculty Green Points  No activity recorded yet.')); ?></p>
            <p class="metric-note">Based on saved records.</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Active participants
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Active participants  No activity recorded yet.')); ?></p>
            <p class="metric-note">Based on saved records.</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Participation rate
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Participation rate  No activity recorded yet.')); ?></p>
            <p class="metric-note">Based on saved records.</p>
          </article>
        </div>
        <div class="grid-2">
          <section class="panel">
            <div class="panel-heading">
              <h2>Faculty ranking</h2>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <caption class="visually-hidden">Faculty Green Points ranking</caption>
                <thead>
                  <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">Faculty</th>
                    <th scope="col">Green Points</th>
                  </tr>
                </thead>
                <tbody><?php $kind='faculty-rankings'; $columns=['Rank', 'Faculty', 'Green Points']; include __DIR__ . '/../includes/table.php'; ?></tbody>
              </table>
            </div>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Milestone progress</h2>
            </div>
            <h3>Most sustainable faculty target</h3>
            <p>Grow participation across the faculty.</p>
            <?php $participation=faculty_participation($faculty); ?>
            <div class="progress-block">
              <div class="progress-label"><span>Students participating</span><strong><?= $participation['joined'] ?> / <?= $participation['eligible'] ?></strong></div>
              <progress value="<?= $participation['joined'] ?>" max="<?= max(1,$participation['eligible']) ?>" aria-label="Faculty participation goal">Participation</progress>
              <p class="field-hint">Goal: participation from every active student in your faculty.</p>
            </div>
            <a class="text-link" href="../faculty/home.php?view=insights-achievements">See faculty achievements</a>
          </section>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty participation over time</h2>
          </div>
          <p>Monthly participants with approved activity</p>
          <div class="bar-chart"><?php $chart_kind='participants-by-month'; include __DIR__.'/../includes/chart.php'; unset($chart_kind); ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'insights-achievements':
page_start('Insights','Insights',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Insights') ?>Insights</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">A closer look at your faculty's progress.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/home.php?view=insights-overview">Overview</a>
          <a href="../faculty/home.php?view=insights-leaderboard">Leaderboard</a>
          <a href="../faculty/home.php?view=insights-achievements" class="is-active" aria-current="page">Achievements</a>
          <a href="../faculty/home.php?view=insights-reports">Reports</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty achievements</h2>
          </div>
          <div class="grid-2"><?php include __DIR__ . '/../includes/achievements.php'; ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'insights-leaderboard':
page_start('Insights','Insights',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Insights') ?>Insights</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">A closer look at your faculty's progress.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/home.php?view=insights-overview">Overview</a>
          <a href="../faculty/home.php?view=insights-leaderboard" class="is-active" aria-current="page">Leaderboard</a>
          <a href="../faculty/home.php?view=insights-achievements">Achievements</a>
          <a href="../faculty/home.php?view=insights-reports">Reports</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty leaderboard</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty Green Points ranking</caption>
              <thead>
                <tr>
                  <th scope="col">Rank</th>
                  <th scope="col">Faculty</th>
                  <th scope="col">Green Points</th>
                </tr>
              </thead>
              <tbody><?php $kind='faculty-rankings'; $columns=['Rank', 'Faculty', 'Green Points']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
        <p class="note">Every verified action helps your faculty’s progress.</p>
      </div>
    </main>
  
<?php page_end(); break;
case 'insights-overview':
page_start('Insights','Insights',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Insights') ?>Insights</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">A closer look at your faculty's progress.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/home.php?view=insights-overview" class="is-active" aria-current="page">Overview</a>
          <a href="../faculty/home.php?view=insights-leaderboard">Leaderboard</a>
          <a href="../faculty/home.php?view=insights-achievements">Achievements</a>
          <a href="../faculty/home.php?view=insights-reports">Reports</a>
        </nav>
        <div class="grid-3">
          <article class="metric">
            <div class="metric-label">
              Faculty rank
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Faculty rank  No activity recorded yet.')); ?></p>
            <p class="metric-note">Based on saved records.</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Green Points
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Green Points  No activity recorded yet.')); ?></p>
            <p class="metric-note">Based on saved records.</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Completed activities
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Completed activities  No activity recorded yet.')); ?></p>
            <p class="metric-note">Based on saved records.</p>
          </article>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty participation</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty insight participation overview</caption>
              <thead>
                <tr>
                  <th scope="col">Challenge</th>
                  <th scope="col">Joined</th>
                  <th scope="col">Completed</th>
                  <th scope="col">Completion</th>
                </tr>
              </thead>
              <tbody><?php $kind='challenges'; $columns=['Challenge', 'Joined', 'Completed', 'Completion']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'insights-reports':
page_start('Insights','Insights',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Insights') ?>Insights</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">A closer look at your faculty's progress.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/home.php?view=insights-overview">Overview</a>
          <a href="../faculty/home.php?view=insights-leaderboard">Leaderboard</a>
          <a href="../faculty/home.php?view=insights-achievements">Achievements</a>
          <a href="../faculty/home.php?view=insights-reports" class="is-active" aria-current="page">Reports</a>
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
case 'participation-campus-cleanup':
case 'participation-challenge-participation':
case 'participation-completion-rates':
$detail = $view === 'participation-campus-cleanup';
$completion = $view === 'participation-completion-rates';
$periods = ['all' => 'All time', 'this-month' => 'This month', 'last-month' => 'Last month'];
$period = $completion && is_string($_GET['period'] ?? null) && isset($periods[$_GET['period']]) ? $_GET['period'] : 'all';
$search = $completion && is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$participation = $detail && !$record ? [] : faculty_challenge_participation($faculty, $period, $detail ? $id : 0);
if ($search !== '') {
    $participation = array_values(array_filter($participation, fn($row) => stripos($row['title'], $search) !== false));
}
$joined = array_sum(array_column($participation, 'joined'));
$completed = array_sum(array_column($participation, 'completed'));
$title = $detail && $record ? $record['title'] : ($completion ? 'Completion rates' : 'Challenge participation');
page_start($title,'Participation',false);
?>
<main id="main-content" class="workspace-content">
    <?php include __DIR__ . '/../includes/notices.php'; ?>
    <div class="page-header">
        <div>
            <h1><?= e($title) ?></h1>
            <?php if ($completion): ?>
                <p class="page-description">See how many students completed a challenge among those who joined in the selected period.</p>
            <?php elseif (!$detail): ?>
                <p class="page-description">Challenges ranked by the number of students who joined from <?= e($faculty) ?>.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="stack">
        <nav class="page-tabs" aria-label="Participation views">
            <a href="?view=participation-challenge-participation"<?= !$completion && !$detail ? ' class="is-active" aria-current="page"' : '' ?>>Challenge participation</a>
            <a href="?view=participation-completion-rates"<?= $completion ? ' class="is-active" aria-current="page"' : '' ?>>Completion rates</a>
        </nav>
        <?php if ($detail): ?>
            <?php if ($record): ?>
                <section class="panel" aria-label="Participation in this challenge">
                    <dl class="detail-list">
                        <div><dt>Joined</dt><dd><?= $joined ?></dd></div>
                        <div><dt>Active</dt><dd><?= $joined - $completed ?></dd></div>
                        <div><dt>Completed</dt><dd><?= $completed ?></dd></div>
                        <div><dt>Completion rate</dt><dd><?= e(completion_rate($completed, $joined)) ?></dd></div>
                    </dl>
                </section>
            <?php endif; ?>
            <p><a class="text-link" href="?view=participation-challenge-participation">Back to challenge participation</a></p>
        <?php else: ?>
            <?php if ($completion): ?>
                <form method="get" class="form-grid">
                    <input type="hidden" name="view" value="participation-completion-rates">
                    <div class="field">
                        <label for="participation-search">Search challenges</label>
                        <input id="participation-search" name="q" type="search" value="<?= e($search) ?>">
                    </div>
                    <div class="field">
                        <label for="participation-period">Joined during</label>
                        <select id="participation-period" name="period">
                            <?php foreach ($periods as $key => $label): ?>
                                <option value="<?= e($key) ?>"<?= $period === $key ? ' selected' : '' ?>><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button class="button button--outline" type="submit">Apply filters</button>
                    </div>
                </form>
                <p><strong><?= $completed ?> of <?= $joined ?></strong> enrollments completed · <?= e(completion_rate($completed, $joined)) ?></p>
            <?php endif; ?>
            <div class="table-wrap">
                <table class="data-table">
                    <caption class="visually-hidden"><?= e($title) ?></caption>
                    <thead><tr>
                        <?php if (!$completion): ?><th scope="col">Rank</th><?php endif; ?>
                        <th scope="col">Challenge</th>
                        <th scope="col">Joined</th>
                        <?php if (!$completion): ?><th scope="col">Active</th><?php endif; ?>
                        <th scope="col">Completed</th>
                        <th scope="col"><?= $completion ? 'Rate' : 'Details' ?></th>
                    </tr></thead>
                    <tbody>
                        <?php foreach ($participation as $rank => $row): ?>
                            <tr data-record>
                                <?php if (!$completion): ?><td><?= $rank + 1 ?></td><?php endif; ?>
                                <td><?= e($row['title']) ?></td>
                                <td><?= (int)$row['joined'] ?></td>
                                <?php if (!$completion): ?><td><?= (int)$row['joined'] - (int)$row['completed'] ?></td><?php endif; ?>
                                <td><?= (int)$row['completed'] ?></td>
                                <td><?php if ($completion): ?>
                                    <?= e(completion_rate((int)$row['completed'], (int)$row['joined'])) ?>
                                <?php else: ?>
                                    <a class="text-link" href="?view=participation-campus-cleanup&amp;id=<?= (int)$row['id'] ?>">View<span class="visually-hidden"> <?= e($row['title']) ?></span></a>
                                <?php endif; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (!$participation): ?>
                            <tr><td class="empty-state" colspan="<?= $completion ? 4 : 6 ?>">No matching enrollments.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php page_end(); break;
}
