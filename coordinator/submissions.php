<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'submissions-approved' => 'coordinator/submissions-approved.php',
    'submissions-needs-revision' => 'coordinator/submissions-needs-revision.php',
    'submissions-pending' => 'coordinator/submissions-pending.php',
    'submissions-rejected' => 'coordinator/submissions-rejected.php',
    'submissions-review-submission' => 'coordinator/submissions-review-submission.php',
];
$page=screen_page($screens,'submissions-pending');
$page_role='coordinator';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'submissions-approved':
page_start('Submissions','Submissions',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submissions') ?>Submissions</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Every submission gets a clear status and a considered review.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/submissions.php?view=submissions-pending">Pending</a>
        <a href="../coordinator/submissions.php?view=submissions-needs-revision">Needs revision</a>
        <a href="../coordinator/submissions.php?view=submissions-approved" class="is-active" aria-current="page">Approved</a>
        <a href="../coordinator/submissions.php?view=submissions-rejected">Rejected</a>
      </nav>
      <div class="stack">
        <div class="toolbar">
          <div class="field">
            <label for="submission-search">Search submissions</label>
            <input id="submission-search" name="submission-search" type="search" placeholder="Search submissions">
          </div>
          <div class="field">
            <label for="submission-challenge">Challenge</label>
            <select id="submission-challenge" name="submission-challenge">
              <option value="" selected>All challenges</option>
            </select>
          </div>
        </div>
        <section class="panel stack" aria-labelledby="submissions-title">
          <h2 id="submissions-title">Approved submissions</h2>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">approved submission queue</caption>
              <thead>
                <tr>
                  <th scope="col">Submission</th>
                  <th scope="col">Participant</th>
                  <th scope="col">Challenge</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='submissions'; $columns=['Submission', 'Participant', 'Challenge', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
          <p class="note">A recorded decision keeps the participant and reviewer informed.</p>
        </section>
        <div class="notice notice--info">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
          </svg>
          <p>No automatic fraud decisions. A coordinator reviews the evidence and records a clear reason for revision or rejection.</p>
        </div>
      </div>
    </main>
  
<?php page_end(); break;
case 'submissions-needs-revision':
page_start('Submissions','Submissions',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submissions') ?>Submissions</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Every submission gets a clear status and a considered review.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/submissions.php?view=submissions-pending">Pending</a>
        <a href="../coordinator/submissions.php?view=submissions-needs-revision" class="is-active" aria-current="page">Needs revision</a>
        <a href="../coordinator/submissions.php?view=submissions-approved">Approved</a>
        <a href="../coordinator/submissions.php?view=submissions-rejected">Rejected</a>
      </nav>
      <div class="stack">
        <div class="toolbar">
          <div class="field">
            <label for="submission-search">Search submissions</label>
            <input id="submission-search" name="submission-search" type="search" placeholder="Search submissions">
          </div>
          <div class="field">
            <label for="submission-challenge">Challenge</label>
            <select id="submission-challenge" name="submission-challenge">
              <option value="" selected>All challenges</option>
            </select>
          </div>
        </div>
        <section class="panel stack" aria-labelledby="submissions-title">
          <h2 id="submissions-title">Needs revision submissions</h2>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">needs revision submission queue</caption>
              <thead>
                <tr>
                  <th scope="col">Submission</th>
                  <th scope="col">Participant</th>
                  <th scope="col">Challenge</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='submissions'; $columns=['Submission', 'Participant', 'Challenge', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
          <p class="note">A recorded decision keeps the participant and reviewer informed.</p>
        </section>
        <div class="notice notice--info">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
          </svg>
          <p>No automatic fraud decisions. A coordinator reviews the evidence and records a clear reason for revision or rejection.</p>
        </div>
      </div>
    </main>
  
<?php page_end(); break;
case 'submissions-pending':
page_start('Submissions','Submissions',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submissions') ?>Submissions</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Every submission gets a clear status and a considered review.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/submissions.php?view=submissions-pending" class="is-active" aria-current="page">Pending</a>
        <a href="../coordinator/submissions.php?view=submissions-needs-revision">Needs revision</a>
        <a href="../coordinator/submissions.php?view=submissions-approved">Approved</a>
        <a href="../coordinator/submissions.php?view=submissions-rejected">Rejected</a>
      </nav>
      <div class="stack">
        <div class="toolbar">
          <div class="field">
            <label for="submission-search">Search submissions</label>
            <input id="submission-search" name="submission-search" type="search" placeholder="Search submissions">
          </div>
          <div class="field">
            <label for="submission-challenge">Challenge</label>
            <select id="submission-challenge" name="submission-challenge">
              <option value="" selected>All challenges</option>
            </select>
          </div>
        </div>
        <section class="panel stack" aria-labelledby="submissions-title">
          <h2 id="submissions-title">Pending submissions</h2>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">pending submission queue</caption>
              <thead>
                <tr>
                  <th scope="col">Submission</th>
                  <th scope="col">Participant</th>
                  <th scope="col">Challenge</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='submissions'; $columns=['Submission', 'Participant', 'Challenge', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
          <p class="note">Open a submission to check its photo, item count and possible duplicates by hand.</p>
        </section>
        <div class="notice notice--info">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
          </svg>
          <p>No automatic fraud decisions. A coordinator reviews the evidence and records a clear reason for revision or rejection.</p>
        </div>
      </div>
    </main>
  
<?php page_end(); break;
case 'submissions-rejected':
page_start('Submissions','Submissions',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submissions') ?>Submissions</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Every submission gets a clear status and a considered review.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/submissions.php?view=submissions-pending">Pending</a>
        <a href="../coordinator/submissions.php?view=submissions-needs-revision">Needs revision</a>
        <a href="../coordinator/submissions.php?view=submissions-approved">Approved</a>
        <a href="../coordinator/submissions.php?view=submissions-rejected" class="is-active" aria-current="page">Rejected</a>
      </nav>
      <div class="stack">
        <div class="toolbar">
          <div class="field">
            <label for="submission-search">Search submissions</label>
            <input id="submission-search" name="submission-search" type="search" placeholder="Search submissions">
          </div>
          <div class="field">
            <label for="submission-challenge">Challenge</label>
            <select id="submission-challenge" name="submission-challenge">
              <option value="" selected>All challenges</option>
            </select>
          </div>
        </div>
        <section class="panel stack" aria-labelledby="submissions-title">
          <h2 id="submissions-title">Rejected submissions</h2>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">rejected submission queue</caption>
              <thead>
                <tr>
                  <th scope="col">Submission</th>
                  <th scope="col">Participant</th>
                  <th scope="col">Challenge</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='submissions'; $columns=['Submission', 'Participant', 'Challenge', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
          <p class="note">A recorded decision keeps the participant and reviewer informed.</p>
        </section>
        <div class="notice notice--info">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
          </svg>
          <p>No automatic fraud decisions. A coordinator reviews the evidence and records a clear reason for revision or rejection.</p>
        </div>
      </div>
    </main>
  
<?php page_end(); break;
case 'submissions-review-submission':
$can_decide = !empty($record) && $record['status'] === 'pending';
$status_label = $record ? ucfirst(str_replace('-', ' ', $record['status'])) : 'Not selected';
$return_page = 'submissions-' . ($record['status'] ?? 'pending') . '.php';
page_start('Submissions','Submissions',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Submissions') ?>Submissions</h1>
            <p class="context-line">Sustainability Coordinator</p>
            <p class="page-description">Pending evidence awaiting a human review.</p>
          </div>
          <p class="note">No record selected.</p>
        </div>
        <nav class="page-tabs" aria-label="Section views">
          <a href="../coordinator/submissions.php?view=submissions-pending" class="is-active" aria-current="page">Pending</a>
          <a href="../coordinator/submissions.php?view=submissions-needs-revision">Needs revision</a>
          <a href="../coordinator/submissions.php?view=submissions-approved">Approved</a>
          <a href="../coordinator/submissions.php?view=submissions-rejected">Rejected</a>
        </nav>
        <div class="stack">
          <div class="toolbar">
            <div class="field">
              <label for="submission-search">Search submissions</label>
              <input id="submission-search" name="submission-search" type="search" placeholder="Search submissions" form="backend-form">
            </div>
            <div class="field">
              <label for="submission-challenge">Challenge</label>
              <select id="submission-challenge" name="submission-challenge" form="backend-form">
                <option value="" selected>All challenges</option>
              </select>
            </div>
          </div>
          <section class="panel stack" aria-labelledby="submissions-title">
            <h2 id="submissions-title">Pending submissions</h2>
            <div class="table-wrap">
              <table class="data-table">
                <caption class="visually-hidden">pending submission queue</caption>
                <thead>
                  <tr>
                    <th scope="col">Submission</th>
                    <th scope="col">Participant</th>
                    <th scope="col">Challenge</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody><?php $kind='submissions'; $columns=['Submission', 'Participant', 'Challenge', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
              </table>
            </div>
            <p class="note">Open a submission to check its photo, item count and possible duplicates by hand.</p>
          </section>
          <div class="notice notice--info">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
            </svg>
            <p>No automatic fraud decisions. A coordinator reviews the evidence and records a clear reason for revision or rejection.</p>
          </div>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title"><?= $can_decide ? 'Review submission' : 'Submission details' ?></h2>
            <p class="context-line">Sustainability Coordinator</p>
          </div>
          <a class="close-button" href="<?= e(route_url('coordinator/'.$return_page)) ?>" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="stack">
            <dl class="detail-list">
              <div>
                <dt>Participant</dt>
                <dd><?php echo e($record['full_name'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Challenge</dt>
                <dd><?php echo e($record['title'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Submission</dt>
                <dd><?php echo e($record['id'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Current status</dt>
                <dd><?= e($status_label) ?></dd>
              </div>
            </dl>
            <figure class="media-figure"><?php if ($record) { echo evidence_image($record); echo '<figcaption>' . e($record['description']) . ' · Quantity: ' . (int)$record['quantity'] . '</figcaption>'; } else echo 'Select a submission from the list.'; ?></figure>
            <blockquote><?php echo '<p>' . e($record['description'] ?? '') . '</p><p>Reviewer notes: ' . e($record['review_notes'] ?? 'Not reviewed') . '</p>'; ?></blockquote>
            <div class="stack" aria-label="Manual submission review" role="form">
              <fieldset class="check-group" <?= $can_decide ? '' : 'disabled' ?>>
                <legend>Reviewer checks</legend>
                <div class="check-list">
                  <label class="check-option" for="review-matches">
                    <input id="review-matches" name="review-matches" type="checkbox" form="backend-form">
                    <span>Photo matches the challenge</span>
                  </label>
                  <label class="check-option" for="review-count">
                    <input id="review-count" name="review-count" type="checkbox" form="backend-form">
                    <span>Item count checked</span>
                  </label>
                  <label class="check-option" for="review-duplicate">
                    <input id="review-duplicate" name="review-duplicate" type="checkbox" form="backend-form">
                    <span>Possible duplicate evidence checked by hand</span>
                  </label>
                </div>
              </fieldset>
              <div class="field field--full">
                <label for="review-reason">Reason for rejection or revision</label>
                <select id="review-reason" name="review-reason" form="backend-form" <?= $can_decide ? '' : 'disabled' ?>>
                  <option value="">Choose a reason</option>
                  <?php foreach (review_reasons() as $reason): ?>
                  <option value="<?= e($reason) ?>" <?= post('review-reason') === $reason ? 'selected' : '' ?>><?= e($reason) ?></option>
                  <?php endforeach; ?>
                </select>
                <p class="field-hint">Select a reason for rejection or revision. Choose Other to write your own.</p>
              </div>
              <div class="field field--full">
                <label for="review-notes">Additional description</label>
                <textarea id="review-notes" name="review-notes" rows="3" maxlength="2000" placeholder="Add details if needed" form="backend-form" <?= $can_decide ? '' : 'disabled' ?>><?= e(isset($_POST['review-notes']) && is_string($_POST['review-notes']) ? $_POST['review-notes'] : '') ?></textarea>
                <p class="field-hint">Optional, except when the selected reason is Other.</p>
              </div>
            </div>
            <div class="notice notice--info">
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
              </svg>
              <p><?php if ($can_decide): ?>Complete all three checks before approving. Choose a reason when rejecting evidence or requesting revision.<?php elseif ($record): ?>This submission is already <?= e(strtolower($status_label)) ?>. Its decision is read-only. The participant must send a new submission before you can review the evidence again.<?php else: ?>Select a pending submission from the list before recording a decision.<?php endif; ?></p>
            </div>
          </div>
        </div>
        <footer class="dialog-actions">
          <button class="button button--primary" type="submit" form="backend-form" name="decision" value="approved" <?= $can_decide ? '' : 'disabled' ?>>Approve</button>
          <button class="button button--outline" type="submit" form="backend-form" name="decision" value="needs-revision" <?= $can_decide ? '' : 'disabled' ?>>Needs revision</button>
          <button class="button button--danger" type="submit" form="backend-form" name="decision" value="rejected" <?= $can_decide ? '' : 'disabled' ?>>Reject</button>
        </footer>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="review" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
}
