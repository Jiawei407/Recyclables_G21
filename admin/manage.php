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
require __DIR__.'/../includes/layout.php';

switch($view) {
case 'challenge-balancing-upload-challenge-photo':
    redirect('admin/challenge-balancing.php' . ($record ? '?id=' . $id . '#edit-challenge' : ''));
    break;

case 'challenge-balancing-delete-challenge':
    require_permission('manage-challenges');
    if (!$record) redirect('admin/challenge-balancing.php');
    $editor_url = e(route_url('admin/challenge-balancing.php?id=' . $id . '#edit-challenge'));
    page_start('Delete challenge','Challenge Balancing');
?>
<main id="main-content" class="workspace-content">
  <?php include __DIR__ . '/../includes/notices.php'; ?>
  <div class="page-header"><div><h1>Delete challenge</h1></div></div>
  <section class="panel">
    <h2><?= e($record['title']) ?></h2>
    <p>Challenges with submitted evidence or linked achievement requirements can be closed to preserve their history.</p>
    <form method="post" class="form-actions">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="delete-challenge">
      <input type="hidden" name="id" value="<?= (int)$id ?>">
      <button class="button button--danger" type="submit">Delete challenge</button>
      <a class="button button--outline" href="<?= $editor_url ?>">Cancel</a>
    </form>
  </section>
</main>
<?php page_end(); break;

case 'challenge-balancing':
    $can_edit = user_has_permission($user, 'manage-challenges');
    page_start('Challenge Balancing','Challenge Balancing');
?>
<main id="main-content" class="workspace-content">
  <?php include __DIR__ . '/../includes/notices.php'; ?>
  <div class="page-header"><div><h1><?= section_icon('Challenge Balancing') ?>Challenge Balancing</h1></div></div>
  <div class="stack">
    <section class="panel">
      <div class="panel-heading"><h2>Challenge performance</h2></div>
      <div class="table-wrap">
        <table class="data-table">
          <caption class="visually-hidden">Challenge participation and completion</caption>
          <thead><tr>
            <th scope="col">Challenge</th>
            <th scope="col">Joined</th>
            <th scope="col">Completed / joined</th>
            <th scope="col">Completion</th>
            <th scope="col">Action</th>
          </tr></thead>
          <tbody><?php
            $kind='challenges'; $columns=['Challenge','Joined','Completed / joined','Completion','Action'];
            include __DIR__ . '/../includes/table.php';
          ?></tbody>
        </table>
      </div>
    </section>

    <?php if ($record): ?>
    <section class="panel" id="edit-challenge" tabindex="-1" aria-labelledby="challenge-editor-heading">
      <div class="panel-heading">
        <h2 id="challenge-editor-heading"><?= $can_edit ? 'Edit challenge' : 'Challenge details' ?></h2>
      </div>
      <?php if (!$can_edit): ?>
        <dl class="detail-list">
          <div><dt>Challenge</dt><dd><?= e($record['title']) ?></dd></div>
          <div><dt>Description</dt><dd><?= e($record['description']) ?></dd></div>
          <div><dt>Green Points</dt><dd><?= (int)$record['points'] ?></dd></div>
          <div><dt>Status</dt><dd><?= e(ucfirst($record['status'])) ?></dd></div>
        </dl>
      <?php else: ?>
        <form class="stack" id="backend-form" method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="save-challenge">
          <input type="hidden" name="id" value="<?= (int)$id ?>">
          <div class="form-grid">
            <div class="field">
              <label for="challenge-title">Title</label>
              <input id="challenge-title" name="challenge-title" required maxlength="180" value="<?= value('challenge-title','title') ?>">
            </div>
            <div class="field">
              <label for="challenge-points">Green Points</label>
              <input id="challenge-points" name="challenge-points" type="number" min="0" max="1000" step="1" required value="<?= value('challenge-points','points') ?>">
            </div>
            <div class="field">
              <label for="challenge-end-date">End date</label>
              <input id="challenge-end-date" name="challenge-end-date" type="date" required value="<?= value('challenge-end-date','end_date') ?>">
            </div>
            <div class="field">
              <label for="challenge-status">Status</label>
              <select id="challenge-status" name="challenge-status">
                <?php foreach (['open','closed','draft'] as $status): ?>
                  <option value="<?= e($status) ?>" <?= selected('challenge-status','status',$status) ?>><?= e(ucfirst($status)) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field field--full">
              <label for="challenge-description">Description</label>
              <textarea id="challenge-description" name="challenge-description" rows="4" required><?= value('challenge-description','description') ?></textarea>
            </div>
            <div class="field field--full">
              <label for="completion-requirement">Completion requirement</label>
              <input id="completion-requirement" name="completion-requirement" maxlength="255" value="<?= value('completion-requirement','completion_requirement') ?>">
            </div>
          </div>
          <div class="field">
            <label for="challenge-image">Challenge image</label>
            <div class="media-figure" data-photo-preview>
              <?php if ($record['image']): ?>
                <img class="preview-image" width="400" src="<?= e($base) ?>/file.php?type=challenge&amp;id=<?= (int)$id ?>" alt="Current challenge image">
              <?php endif; ?>
            </div>
            <input id="challenge-image" name="image" type="file" accept="image/jpeg,image/png">
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit">Save changes</button>
            <a class="button button--danger" href="<?= e(route_url('admin/challenge-balancing-delete-challenge.php?id=' . $id)) ?>">Delete challenge</a>
          </div>
        </form>
      <?php endif; ?>
    </section>
    <?php endif; ?>
  </div>
</main>
<?php page_end(); break;

case 'leaderboard-point-corrections':
case 'leaderboard-review-user-points':
    $reviewing = $view === 'leaderboard-review-user-points' && ($record['role'] ?? '') === 'user';
    if ($view === 'leaderboard-review-user-points' && !$reviewing && $_SERVER['REQUEST_METHOD'] === 'GET') {
        redirect('admin/leaderboard-point-corrections.php');
    }
    $activities = $reviewing ? page_records('transactions') : [];
    $activity = null;
    $activity_id = filter_var($_GET['transaction'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
    if ($reviewing && isset($_GET['transaction'])) {
        foreach ($activities as $entry) {
            if ((int)$entry['id'] === $activity_id) {
                $activity = $entry;
                break;
            }
        }
        if (!$activity) {
            http_response_code(404);
            $error = 'This activity is unavailable for the selected participant.';
        }
    }
    $reversible_points = reversible_submission_points($activity ?? []);
    $can_reject = $reversible_points && user_has_permission($user, 'reverse-submission-points');
    page_start('Leaderboard','Leaderboard');
?>
<main id="main-content" class="workspace-content">
  <?php include __DIR__ . '/../includes/notices.php'; ?>
  <div class="page-header"><div><h1><?= section_icon('Leaderboard') ?>Leaderboard</h1></div></div>
  <div class="stack">
    <nav class="page-tabs" aria-label="Section views">
      <a href="<?= e(route_url('admin/leaderboard-view-rankings.php')) ?>">View rankings</a>
      <a href="<?= e(route_url('admin/leaderboard-point-corrections.php')) ?>" class="is-active" <?= $reviewing ? '' : 'aria-current="page"' ?>>Point corrections</a>
    </nav>

    <?php if (!$reviewing): ?>
      <section class="panel">
        <div class="panel-heading">
          <h2>Point corrections</h2>
          <p class="muted">Select a participant to review the activity that earned their points.</p>
        </div>
        <div class="table-wrap">
          <table class="data-table">
            <caption class="visually-hidden">Participants and points</caption>
            <thead><tr><th scope="col">Participant</th><th scope="col">Green Points</th><th scope="col">Action</th></tr></thead>
            <tbody><?php $kind='rankings'; $columns=['Participant','Green Points','Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
          </table>
        </div>
      </section>
    <?php else: ?>
      <section class="panel">
        <div class="panel-heading"><h2><?= e($record['full_name']) ?></h2></div>
        <h3>Points audit trail</h3>
        <div class="table-wrap">
          <table class="data-table">
            <caption class="visually-hidden">Point activity for <?= e($record['full_name']) ?></caption>
            <thead><tr><th scope="col">Date</th><th scope="col">Activity</th><th scope="col">Green Points</th><th scope="col">Details</th></tr></thead>
            <tbody>
            <?php if (!$activities): ?><tr><td colspan="4">No points activity recorded.</td></tr><?php endif; ?>
            <?php foreach ($activities as $entry): ?>
              <?php
              $activity_label = 'View activity #' . $entry['id'];
              if ($entry['submission_id']) {
                  $activity_label = ($entry['reverses_id'] ? 'View reversal for submission #' : 'View submission #') . $entry['submission_id'];
              }
              ?>
              <tr data-record>
                <td><?= e($entry['created_at']) ?></td>
                <td><?= e($entry['reason']) ?></td>
                <td><?= (int)$entry['points'] ?></td>
                <td><a class="text-link" <?= $activity && $activity['id'] === $entry['id'] ? 'aria-current="true"' : '' ?> href="<?= e(route_url('admin/leaderboard-review-user-points.php?id=' . $id . '&transaction=' . $entry['id'] . '#activity-details')) ?>"><?= e($activity_label) ?></a></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
      <?php if ($activity): ?>
        <section class="panel stack" id="activity-details" tabindex="-1" aria-labelledby="activity-details-heading">
          <div class="panel-heading"><h2 id="activity-details-heading"><?= $activity['submission_id'] ? 'Submission #' . (int)$activity['submission_id'] : 'Activity details' ?></h2></div>
          <dl class="detail-list">
            <div><dt>Activity</dt><dd><?= e($activity['reason']) ?></dd></div>
            <?php if ($activity['submission_id']): ?>
              <div><dt>Challenge</dt><dd><?= e($activity['title']) ?></dd></div>
              <div><dt>Status</dt><dd><?= e(ucfirst(str_replace('-', ' ', $activity['status']))) ?></dd></div>
              <div><dt>Submitted</dt><dd><?= e($activity['submitted_at']) ?></dd></div>
              <div><dt>Quantity</dt><dd><?= (int)$activity['quantity'] ?></dd></div>
              <div><dt>Participant description</dt><dd><?= e($activity['description']) ?></dd></div>
              <?php if ($activity['review_notes']): ?>
                <div><dt>Review notes</dt><dd><?= e($activity['review_notes']) ?></dd></div>
              <?php endif; ?>
            <?php else: ?>
              <div><dt>Date</dt><dd><?= e($activity['created_at']) ?></dd></div>
              <div><dt>Green Points</dt><dd><?= (int)$activity['points'] ?></dd></div>
            <?php endif; ?>
          </dl>
          <?php if ($activity['submission_id']): ?>
            <div class="media-figure">
              <?php if ($activity['photo']): ?>
                <?= evidence_image(['id'=>$activity['submission_id'],'photo'=>$activity['photo']]) ?>
              <?php else: ?>
                <p class="muted">No photo attached.</p>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if ($can_reject): ?>
            <form method="post" class="stack">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="reject-approved-submission">
              <input type="hidden" name="id" value="<?= (int)$id ?>">
              <input type="hidden" name="transaction-id" value="<?= (int)$activity['id'] ?>">
              <div class="field">
                <label for="review-reason">Rejection reason</label>
                <textarea id="review-reason" name="review-reason" rows="3" maxlength="2000" required aria-describedby="rejection-hint"><?= e(post('review-reason')) ?></textarea>
                <small class="field-help" id="rejection-hint">The participant will see this reason. Rejecting this submission reverses <?= (int)$reversible_points ?> Green Points.</small>
              </div>
              <div class="form-actions"><button class="button button--danger" type="submit">Reject submission</button></div>
            </form>
          <?php endif; ?>
        </section>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</main>
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
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='rankings'; $columns=['Rank', 'Participant', 'Green Points', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
<?php page_end(); break;
}
