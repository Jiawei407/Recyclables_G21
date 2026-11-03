<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'submit-evidence-new-submission' => 'user/submit-evidence-new-submission.php',
    'submit-evidence-submission-details' => 'user/submit-evidence-submission-details.php',
    'submit-evidence-submission-status' => 'user/submit-evidence-submission-status.php',
    'submit-evidence-upload-failed' => 'user/submit-evidence-upload-failed.php',
    'submit-evidence-upload-photo' => 'user/submit-evidence-upload-photo.php',
];
$page=screen_page($screens,'submit-evidence-new-submission');
$page_role='user';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'submit-evidence-new-submission':
page_start('Submit Evidence','Submit Evidence',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submit Evidence') ?>Submit Evidence</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Clear evidence. A considered review.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/evidence.php?view=submit-evidence-new-submission" class="is-active" aria-current="page">New submission</a>
          <a href="../user/evidence.php?view=submit-evidence-submission-status">Submission status</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Submit evidence</h2>
          </div>
          <div class="form-grid">
            <fieldset class="challenge-choice-field field-full">
              <legend>Choose a challenge</legend>
              <div class="challenge-choice-grid"><?php include __DIR__ . '/../includes/evidence_choices.php'; ?></div>
            </fieldset>
            <div class="upload-zone field-full">
              <h3>Photo evidence</h3>
              <div class="photo-preview-empty" data-photo-preview="">
                <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                  <path d="M3 7h4l2-3h6l2 3h4v13H3Z"></path>
                  <circle cx="12" cy="13" r="4"></circle>
                </svg>
                <p>No photo selected</p>
              </div>
              <div class="form-actions">
                </div>
              <p class="field-hint">JPG or PNG.</p>
            <label class="button button--outline"><span data-file-name="backend-upload">Choose photo</span><input class="visually-hidden" type="file" id="backend-upload" form="backend-form" name="photo" accept="image/jpeg,image/png" required></label></div>
            <div class="field field-full">
              <label for="evidence-description">Description</label>
              <textarea id="evidence-description" name="evidence-description" rows="4" aria-describedby="evidence-description-hint" form="backend-form"></textarea>
              <small class="field-hint" id="evidence-description-hint">Describe what you did and where.</small>
            <label for="quantity">Number of items or actions shown</label><input id="quantity" form="backend-form" name="quantity" type="number" min="1" max="1000000" value="1" required></div>
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit" form="backend-form">Submit evidence</button>
            <a class="button button--outline" href="../user/challenges.php?view=challenges-my-challenges">Cancel</a>
          </div>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="submit-evidence" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'submit-evidence-submission-details':
page_start('Submit Evidence','Submit Evidence',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submit Evidence') ?>Submit Evidence</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Clear evidence. A considered review.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/evidence.php?view=submit-evidence-new-submission">New submission</a>
          <a href="../user/evidence.php?view=submit-evidence-submission-status" class="is-active" aria-current="page">Submission status</a>
        </nav>
        <div class="toolbar">
          <div class="field">
            <label for="submission-search">Search submissions</label>
            <input id="submission-search" name="submission-search" type="search" placeholder="Search submissions">
          </div>
          <div class="field">
            <label for="submission-search-filter">Status</label>
            <select id="submission-search-filter" name="submission-search-filter">
              <option>All statuses</option>
              <option>Pending review</option>
              <option>Needs revision</option>
              <option>Approved</option>
              <option>Rejected</option>
            </select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Your submissions</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Submission review history</caption>
              <thead>
                <tr>
                  <th scope="col">Challenge</th>
                  <th scope="col">Submitted</th>
                  <th scope="col">Status</th>
                  <th scope="col">Points</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='submissions'; $columns=['Challenge', 'Submitted', 'Status', 'Points', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    <section class="panel stack"><?php if ($record) { echo '<h2>' . e($record['title']) . '</h2><p>' . e($record['description']) . '</p>' . evidence_image($record,600,400) . '<p>Status: ' . e($record['status']) . ' · Points: ' . (int)$record['points_awarded'] . '</p><p>Reviewer notes: ' . e($record['review_notes'] ?? 'Not reviewed yet') . '</p>'; if ($record['status']==='needs-revision') echo '<a class="text-link" href="evidence.php?view=submit-evidence-new-submission&amp;challenge_id=' . (int)$record['challenge_id'] . '">Submit revised evidence</a>'; } else echo '<p>Select a submission from the list to see its evidence and review notes.</p>'; ?></section></main>
  
<?php page_end(); break;
case 'submit-evidence-submission-status':
page_start('Submit Evidence','Submit Evidence',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Submit Evidence') ?>Submit Evidence</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Clear evidence. A considered review.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/evidence.php?view=submit-evidence-new-submission">New submission</a>
          <a href="../user/evidence.php?view=submit-evidence-submission-status" class="is-active" aria-current="page">Submission status</a>
        </nav>
        <div class="toolbar">
          <div class="field">
            <label for="submission-search">Search submissions</label>
            <input id="submission-search" name="submission-search" type="search" placeholder="Search submissions">
          </div>
          <div class="field">
            <label for="submission-search-filter">Status</label>
            <select id="submission-search-filter" name="submission-search-filter">
              <option>All statuses</option>
              <option>Pending review</option>
              <option>Needs revision</option>
              <option>Approved</option>
              <option>Rejected</option>
            </select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Your submissions</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Submission review history</caption>
              <thead>
                <tr>
                  <th scope="col">Challenge</th>
                  <th scope="col">Submitted</th>
                  <th scope="col">Status</th>
                  <th scope="col">Points</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='submissions'; $columns=['Challenge', 'Submitted', 'Status', 'Points', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'submit-evidence-upload-failed':
page_start('Submit Evidence','Submit Evidence',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Submit Evidence') ?>Submit Evidence</h1>
            <p class="context-line">Registered User</p>
            <p class="page-description">Clear evidence. A considered review.</p>
          </div>
        </div>
        <div class="stack">
          <nav class="page-tabs" aria-label="Section views">
            <a href="../user/evidence.php?view=submit-evidence-new-submission" class="is-active" aria-current="page">New submission</a>
            <a href="../user/evidence.php?view=submit-evidence-submission-status">Submission status</a>
          </nav>
          <section class="panel">
            <div class="panel-heading">
              <h2>Submit evidence</h2>
            </div>
            <div class="form-grid">
              <fieldset class="challenge-choice-field field-full">
                <legend>Choose a challenge</legend>
                <div class="challenge-choice-grid"><?php include __DIR__ . '/../includes/evidence_choices.php'; ?></div>
              </fieldset>
              <div class="upload-zone field-full">
                <h3>Photo evidence</h3>
                <div class="photo-preview-empty" data-photo-preview="">
                  <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                    <path d="M3 7h4l2-3h6l2 3h4v13H3Z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                  </svg>
                  <p>No photo selected</p>
                </div>
                <div class="form-actions">
                  </div>
                <p class="field-hint">JPG or PNG.</p>
              <label class="button button--outline"><span data-file-name="backend-upload">Choose photo</span><input class="visually-hidden" type="file" id="backend-upload" form="backend-form" name="photo" accept="image/jpeg,image/png" required></label></div>
              <div class="field field-full">
                <label for="evidence-description">Description</label>
                <textarea id="evidence-description" name="evidence-description" rows="4" aria-describedby="evidence-description-hint" form="backend-form"></textarea>
                <small class="field-hint" id="evidence-description-hint">Describe what you did and where.</small>
              <label for="quantity">Number of items or actions shown</label><input id="quantity" form="backend-form" name="quantity" type="number" min="1" max="1000000" value="1" required></div>
            </div>
            <div class="form-actions">
              <button class="button button--primary" type="submit" form="backend-form">Submit evidence</button>
              <a class="button button--outline" href="../user/challenges.php?view=challenges-my-challenges">Cancel</a>
            </div>
          </section>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Upload failed</h2>
            <p class="context-line">Registered User</p>
          </div>
          <a class="close-button" href="../user/evidence.php?view=submit-evidence-new-submission" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="photo-preview-empty">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="M3 7h4l2-3h6l2 3h4v13H3Z"></path>
              <circle cx="12" cy="13" r="4"></circle>
            </svg>
            <p>No photo selected</p>
          </div>
          <p class="error-message">The photo could not be uploaded.</p>
          <p>Choose a JPG or PNG photo and try again.</p>
          <div class="form-actions">
            <a class="button button--primary" href="../user/evidence.php?view=submit-evidence-upload-photo">Try again</a>
          </div>
        </div>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="submit-evidence" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
case 'submit-evidence-upload-photo':
redirect('user/submit-evidence-new-submission.php' . (isset($_GET['id']) ? '?id=' . (int)$_GET['id'] : ''));
break;
}
