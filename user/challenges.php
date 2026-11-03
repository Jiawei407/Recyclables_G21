<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'challenges-browse' => 'user/challenges-browse.php',
    'challenges-completed' => 'user/challenges-completed.php',
    'challenges-my-challenges' => 'user/challenges-my-challenges.php',
    'challenges-view-challenge' => 'user/challenges-view-challenge.php',
];
$page=screen_page($screens,'challenges-browse');
$page_role='user';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'challenges-browse':
page_start('Challenges','Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenges') ?>Challenges</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Choose a small action and keep a good habit going.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/challenges.php?view=challenges-browse" class="is-active" aria-current="page">Browse</a>
          <a href="../user/challenges.php?view=challenges-my-challenges">My challenges</a>
          <a href="../user/challenges.php?view=challenges-completed">Completed</a>
        </nav>
        <div class="toolbar">
          <div class="field">
            <label for="challenge-search">Search challenges</label>
            <input id="challenge-search" name="challenge-search" type="search" placeholder="Search challenges">
          </div>
          <div class="field">
            <label for="challenge-search-filter">Category</label>
            <select id="challenge-search-filter" name="challenge-search-filter">
              <option>All categories</option>
              <option>Recycling</option>
              <option>Reuse</option>
              <option>Community</option>
            </select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Available challenges</h2>
          </div>
          <div class="grid-3"><?php include __DIR__ . '/../includes/cards.php'; ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'challenges-completed':
page_start('Challenges','Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenges') ?>Challenges</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Choose a small action and keep a good habit going.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/challenges.php?view=challenges-browse">Browse</a>
          <a href="../user/challenges.php?view=challenges-my-challenges">My challenges</a>
          <a href="../user/challenges.php?view=challenges-completed" class="is-active" aria-current="page">Completed</a>
        </nav>
        <div class="grid-2">
          <article class="metric">
            <div class="metric-label">
              Completed challenges
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Completed challenges')); ?></p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Points earned
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Points earned')); ?></p>
          </article>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Completed challenges</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Completed challenges and points earned</caption>
              <thead>
                <tr>
                  <th scope="col">Challenge</th>
                  <th scope="col">Completed</th>
                  <th scope="col">Points</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='challenges'; $columns=['Challenge', 'Completed', 'Points', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'challenges-my-challenges':
page_start('Challenges','Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenges') ?>Challenges</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Choose a small action and keep a good habit going.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/challenges.php?view=challenges-browse">Browse</a>
          <a href="../user/challenges.php?view=challenges-my-challenges" class="is-active" aria-current="page">My challenges</a>
          <a href="../user/challenges.php?view=challenges-completed">Completed</a>
        </nav>
        <div class="grid-2">
          <article class="metric">
            <div class="metric-label">
              Active challenges
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Active challenges')); ?></p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Waiting for review
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Waiting for review')); ?></p>
          </article>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Your challenges</h2>
          </div>
          <div class="grid-2"><?php include __DIR__ . '/../includes/cards.php'; ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'challenges-view-challenge':
page_start('Challenges','Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenges') ?>Challenges</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Choose a small action and keep a good habit going.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/challenges.php?view=challenges-browse" class="is-active" aria-current="page">Browse</a>
          <a href="../user/challenges.php?view=challenges-my-challenges">My challenges</a>
          <a href="../user/challenges.php?view=challenges-completed">Completed</a>
        </nav>
        <div class="toolbar">
          <div class="field">
            <label for="challenge-search">Search challenges</label>
            <input id="challenge-search" name="challenge-search" type="search" placeholder="Search challenges">
          </div>
          <div class="field">
            <label for="challenge-search-filter">Category</label>
            <select id="challenge-search-filter" name="challenge-search-filter">
              <option>All categories</option>
              <option>Recycling</option>
              <option>Reuse</option>
              <option>Community</option>
            </select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Available challenges</h2>
          </div>
          <div class="grid-3"><?php include __DIR__ . '/../includes/cards.php'; ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
}
