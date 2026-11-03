<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'challenge-balancing-delete-challenge' => 'admin/challenge-balancing-delete-challenge.php',
    'challenge-balancing-upload-challenge-photo' => 'admin/challenge-balancing-upload-challenge-photo.php',
    'challenge-balancing' => 'admin/challenge-balancing.php',
    'leaderboard-point-corrections' => 'admin/leaderboard-point-corrections.php',
    'leaderboard-review-user-points' => 'admin/leaderboard-review-user-points.php',
    'leaderboard-view-rankings' => 'admin/leaderboard-view-rankings.php',
];
$page=screen_page($screens,'leaderboard-view-rankings');
$page_role='admin';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'challenge-balancing-delete-challenge':
page_start('Challenge Balancing','Challenge Balancing',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Challenge Balancing') ?>Challenge Balancing</h1>
            <p class="context-line">Administrator</p>
            <p class="page-description">Review challenge performance and make considered changes.</p>
          </div>
          <p class="note">No record selected.</p>
        </div>
        <div class="stack">
          <div class="metric-grid">
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
                Low participation
                <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                  <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                  <path d="m4 21 11-11"></path>
                </svg>
              </div>
              <p class="metric-value"><?php echo e(metric('Low participation  No records available')); ?></p>
              <p class="metric-note">Based on saved records</p>
            </article>
            <article class="metric">
              <div class="metric-label">
                Low completion
                <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                  <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                  <path d="m4 21 11-11"></path>
                </svg>
              </div>
              <p class="metric-value"><?php echo e(metric('Low completion  No records available')); ?></p>
              <p class="metric-note">Based on saved records</p>
            </article>
          </div>
          <section class="panel">
            <div class="panel-heading">
              <h2>Challenge performance</h2>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <caption class="visually-hidden">Challenge participation and completion ratios</caption>
                <thead>
                  <tr>
                    <th scope="col">Challenge</th>
                    <th scope="col">Joined / eligible</th>
                    <th scope="col">Participation</th>
                    <th scope="col">Completed / joined</th>
                    <th scope="col">Completion</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody><?php $kind='challenges'; $columns=['Challenge', 'Joined / eligible', 'Participation', 'Completed / joined', 'Completion', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
              </table>
            </div>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Edit challenge</h2>
              <p class="muted">Balancing is a human edit to points, dates, content and requirements.</p>
            </div>
            <div class="stack" id="edit-challenge" role="form">
              <div class="form-grid">
                <div class="field">
                  <label for="challenge-title">Title</label>
                  <input id="challenge-title" name="challenge-title" type="text" placeholder="Title" required form="backend-form" value="<?php echo value('challenge-title','title',''); ?>">
                </div>
                <div class="field">
                  <label for="challenge-points">Green Points</label>
                  <input id="challenge-points" name="challenge-points" type="number" placeholder="Green Points" min="0" step="1" form="backend-form" value="<?php echo value('challenge-points','points','0'); ?>">
                </div>
                <div class="field">
                  <label for="challenge-end-date">End date</label>
                  <input id="challenge-end-date" name="challenge-end-date" type="date" form="backend-form" value="<?php echo value('challenge-end-date','end_date',''); ?>">
                </div>
                <div class="field">
                  <label for="challenge-status">Status</label>
                  <select id="challenge-status" name="challenge-status" form="backend-form">
                    <option value="open" <?php echo selected('challenge-status','status','open','active') ? 'selected' : ''; ?>>Open</option><option value="closed" <?php echo selected('challenge-status','status','closed','active') ? 'selected' : ''; ?>>Closed</option><option value="draft" <?php echo selected('challenge-status','status','draft','active') ? 'selected' : ''; ?>>Draft</option></select>
                </div>
                <div class="field">
                  <label for="challenge-description">Description</label>
                  <textarea id="challenge-description" name="challenge-description" rows="4" placeholder="Description" form="backend-form"><?php echo value('challenge-description','description'); ?></textarea>
                </div>
                <div class="field">
                  <label for="completion-requirement">Completion requirement</label>
                  <input id="completion-requirement" name="completion-requirement" type="text" placeholder="Completion requirement" form="backend-form" value="<?php echo value('completion-requirement','completion_requirement',''); ?>">
                </div>
              </div>
              <div class="upload-preview">
                <svg class="upload-thumbnail challenge-illustration" viewbox="0 0 600 600" width="600" height="600" role="img" aria-label="No image selected">
                  <rect width="600" height="600" fill="var(--sage)"></rect>
                  <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="24">
                    No image selected
                  </text>
                </svg>
                <div>
                  <strong>Challenge illustration</strong>
                  <a class="button button--outline" href="../admin/manage.php?view=challenge-balancing-upload-challenge-photo">Change image</a>
                </div>
              </div>
              <div class="form-actions">
                <button class="button button--primary" type="submit" form="backend-form">Save changes</button>
                <a class="button button--danger" href="../admin/manage.php?view=challenge-balancing-delete-challenge<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Delete challenge</a>
              </div>
            </div>
          </section>
          <aside class="notice">
            <div>
              <strong>Make changes with context</strong>
              <p>Compare participation and completion before adjusting a challenge. Keep instructions feasible and rewards proportionate to the task.</p>
            </div>
          </aside>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Delete challenge</h2>
            <p class="context-line">Administrator</p>
          </div>
          <a class="close-button" href="../admin/manage.php?view=challenge-balancing" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="stack">
            <aside class="notice notice--danger">
              <div>
                <strong>No challenge selected</strong>
                <p>Select a challenge to review its participants and submissions before deletion.</p>
              </div>
            </aside>
            <dl class="detail-list">
              <div>
                <dt>Challenge</dt>
                <dd><?php echo e($record['title'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Status</dt>
                <dd><?php echo e($record['status'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Joined participants</dt>
                <dd>—</dd>
              </div>
              <div>
                <dt>Green Points</dt>
                <dd>—</dd>
              </div>
            </dl>
            <div class="form-actions">
              <button class="button button--danger" type="submit" form="backend-form">Delete challenge</button>
              <a class="button button--outline" href="../admin/manage.php?view=challenge-balancing">Keep this challenge</a>
            </div>
          </div>
        </div>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden="" data-confirm="Confirm this change?"><?php echo csrf_field(); ?><input type="hidden" name="action" value="delete-challenge" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
case 'challenge-balancing-upload-challenge-photo':
redirect('admin/challenge-balancing.php' . (isset($_GET['id']) ? '?id=' . (int)$_GET['id'] : ''));
break;
case 'challenge-balancing':
page_start('Challenge Balancing','Challenge Balancing',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenge Balancing') ?>Challenge Balancing</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Review challenge performance and make considered changes.</p>
        </div>
        <p class="note">No record selected.</p>
      </div>
      <div class="stack">
        <div class="metric-grid">
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
              Low participation
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Low participation  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Low completion
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Low completion  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Challenge performance</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Challenge participation and completion ratios</caption>
              <thead>
                <tr>
                  <th scope="col">Challenge</th>
                  <th scope="col">Joined / eligible</th>
                  <th scope="col">Participation</th>
                  <th scope="col">Completed / joined</th>
                  <th scope="col">Completion</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='challenges'; $columns=['Challenge', 'Joined / eligible', 'Participation', 'Completed / joined', 'Completion', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
        <section class="panel">
          <div class="panel-heading">
            <h2>Edit challenge</h2>
            <p class="muted">Balancing is a human edit to points, dates, content and requirements.</p>
          </div>
          <div class="stack" id="edit-challenge" role="form">
            <div class="form-grid">
              <div class="field">
                <label for="challenge-title">Title</label>
                <input id="challenge-title" name="challenge-title" type="text" placeholder="Title" required form="backend-form" value="<?php echo value('challenge-title','title',''); ?>">
              </div>
              <div class="field">
                <label for="challenge-points">Green Points</label>
                <input id="challenge-points" name="challenge-points" type="number" placeholder="Green Points" min="0" step="1" form="backend-form" value="<?php echo value('challenge-points','points','0'); ?>">
              </div>
              <div class="field">
                <label for="challenge-end-date">End date</label>
                <input id="challenge-end-date" name="challenge-end-date" type="date" form="backend-form" value="<?php echo value('challenge-end-date','end_date',''); ?>">
              </div>
              <div class="field">
                <label for="challenge-status">Status</label>
                <select id="challenge-status" name="challenge-status" form="backend-form">
                  <option value="open" <?php echo selected('challenge-status','status','open','open') ? 'selected' : ''; ?>>Open</option><option value="closed" <?php echo selected('challenge-status','status','closed','open') ? 'selected' : ''; ?>>Closed</option><option value="draft" <?php echo selected('challenge-status','status','draft','open') ? 'selected' : ''; ?>>Draft</option></select>
              </div>
              <div class="field">
                <label for="challenge-description">Description</label>
                <textarea id="challenge-description" name="challenge-description" rows="4" placeholder="Description" form="backend-form"><?php echo value('challenge-description','description'); ?></textarea>
              </div>
              <div class="field">
                <label for="completion-requirement">Completion requirement</label>
                <input id="completion-requirement" name="completion-requirement" type="text" placeholder="Completion requirement" form="backend-form" value="<?php echo value('completion-requirement','completion_requirement',''); ?>">
              </div>
            </div>
            <div class="upload-preview">
              <svg class="upload-thumbnail challenge-illustration" viewbox="0 0 600 600" width="600" height="600" role="img" aria-label="No image selected">
                <rect width="600" height="600" fill="var(--sage)"></rect>
                <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="24">
                  No image selected
                </text>
              </svg>
              <div>
                <strong>Challenge illustration</strong>
                <a class="button button--outline" href="../admin/manage.php?view=challenge-balancing-upload-challenge-photo">Change image</a>
              </div>
            </div>
            <div class="form-actions">
              <button class="button button--primary" type="submit" form="backend-form">Save changes</button>
              <a class="button button--danger" href="../admin/manage.php?view=challenge-balancing-delete-challenge<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Delete challenge</a>
            </div>
          </div>
        </section>
        <aside class="notice">
          <div>
            <strong>Make changes with context</strong>
            <p>Compare participation and completion before adjusting a challenge. Keep instructions feasible and rewards proportionate to the task.</p>
          </div>
        </aside>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-challenge" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'leaderboard-point-corrections':
page_start('Leaderboard','Leaderboard',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Leaderboard') ?>Leaderboard</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Review the evidence before making a manual adjustment.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/manage.php?view=leaderboard-view-rankings">View rankings</a>
          <a href="../admin/manage.php?view=leaderboard-point-corrections" class="is-active" aria-current="page">Point corrections</a>
        </nav>
        <aside class="notice">
          <div>
            <strong>Careful review, clear reasons</strong>
            <p>Compare the evidence and the audit trail before making a manual correction. No automated fraud decision is implied.</p>
          </div>
        </aside>
        <section class="panel">
          <div class="panel-heading">
            <h2>Point corrections</h2>
            <p class="muted">No point corrections are awaiting review.</p>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Point correction review queue</caption>
              <thead>
                <tr>
                  <th scope="col">Participant</th>
                  <th scope="col">Green Points</th>
                  <th scope="col">Reason</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='rankings'; $columns=['Participant', 'Green Points', 'Reason', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'leaderboard-review-user-points':
page_start('Leaderboard','Leaderboard',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Leaderboard') ?>Leaderboard</h1>
            <p class="context-line">Administrator</p>
            <p class="page-description">Review the evidence before making a manual adjustment.</p>
          </div>
          <p class="note">No record selected.</p>
        </div>
        <div class="stack">
          <nav class="page-tabs" aria-label="Section views">
            <a href="../admin/manage.php?view=leaderboard-view-rankings">View rankings</a>
            <a href="../admin/manage.php?view=leaderboard-point-corrections" class="is-active" aria-current="page">Point corrections</a>
          </nav>
          <aside class="notice">
            <div>
              <strong>Careful review, clear reasons</strong>
              <p>Compare the evidence and the audit trail before making a manual correction. No automated fraud decision is implied.</p>
            </div>
          </aside>
          <section class="panel">
            <div class="panel-heading">
              <h2>Point corrections</h2>
              <p class="muted">No point corrections are awaiting review.</p>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <caption class="visually-hidden">Point correction review queue</caption>
                <thead>
                  <tr>
                    <th scope="col">Participant</th>
                    <th scope="col">Green Points</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody><?php $kind='rankings'; $columns=['Participant', 'Green Points', 'Reason', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
              </table>
            </div>
          </section>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Review user points</h2>
            <p class="context-line">Administrator</p>
          </div>
          <a class="close-button" href="../admin/manage.php?view=leaderboard-point-corrections" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="stack">
            <p class="dialog-subtitle"><?php echo e($record['full_name'] ?? 'Select a participant from the list.'); ?></p>
            <figure class="media-figure evidence-preview">
              <svg viewbox="0 0 900 480" width="900" height="480" role="img" aria-label="No evidence selected">
                <rect width="900" height="480" fill="var(--sage)"></rect>
                <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="24">
                  No evidence selected
                </text>
              </svg>
              <figcaption class="muted">No evidence selected</figcaption>
            </figure>
            <section>
              <h3>Audit trail</h3>
              <div class="table-wrap">
                <table class="data-table">
                  <caption class="visually-hidden">Evidence audit trail</caption>
                  <thead>
                    <tr>
                      <th scope="col">Time</th>
                      <th scope="col">Record</th>
                      <th scope="col">Activity</th>
                    </tr>
                  </thead>
                  <tbody><?php $kind='transactions'; $columns=['Time', 'Record', 'Activity']; include __DIR__ . '/../includes/table.php'; ?></tbody>
                </table>
              </div>
            </section>
            <div class="stack" role="form">
              <div class="form-grid">
                <div class="field field--full">
                  <label for="review-reason">Review reason</label>
                  <textarea id="review-reason" name="review-reason" rows="4" placeholder="Review reason" form="backend-form"></textarea>
                </div>
                <div class="field">
                  <label for="points-to-deduct">Points to deduct</label>
                  <input id="points-to-deduct" name="points-to-deduct" type="number" placeholder="Points to deduct" min="0" step="1" form="backend-form">
                  <small class="field-help">Enter the number of points to deduct after reviewing the evidence.</small>
                </div>
              </div>
              <div class="form-actions">
                <button class="button button--primary" type="submit" form="backend-form" name="decision" value="deduct">Deduct points</button>
                <button class="button button--outline" type="submit" form="backend-form" name="decision" value="approve">Approve</button>
                <button class="button button--outline" type="submit" form="backend-form" name="decision" value="deny">Deny</button>
              </div>
            </div>
          </div>
        </div>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="correct-points" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
case 'leaderboard-view-rankings':
page_start('Leaderboard','Leaderboard',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Leaderboard') ?>Leaderboard</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Celebrate participation and keep every point accountable.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/manage.php?view=leaderboard-view-rankings" class="is-active" aria-current="page">View rankings</a>
          <a href="../admin/manage.php?view=leaderboard-point-corrections">Point corrections</a>
        </nav>
        <div class="toolbar" role="search">
          <div class="field">
            <label for="search-ranking">Search rankings</label>
            <input id="search-ranking" name="search-ranking" type="search" placeholder="Search rankings">
          </div>
          <div class="field">
            <label for="ranking-period">Period</label>
            <select id="ranking-period" name="ranking-period">
              <option value="">All time</option></select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Campus rankings</h2>
            <p class="muted">Rankings appear after submissions have been reviewed.</p>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Individual rankings</caption>
              <thead>
                <tr>
                  <th scope="col">Rank</th>
                  <th scope="col">Participant</th>
                  <th scope="col">Green Points</th>
                </tr>
              </thead>
              <tbody><?php $kind='rankings'; $columns=['Rank', 'Participant', 'Green Points']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
}
