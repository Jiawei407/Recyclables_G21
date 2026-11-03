<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'faculty-activities-create-activity' => 'faculty/faculty-activities-create-activity.php',
    'faculty-activities-faculty-cleanup' => 'faculty/faculty-activities-faculty-cleanup.php',
    'faculty-activities-proposed-activities' => 'faculty/faculty-activities-proposed-activities.php',
    'promote-challenges-available-challenges' => 'faculty/promote-challenges-available-challenges.php',
    'promote-challenges-feature-challenge' => 'faculty/promote-challenges-feature-challenge.php',
    'promote-challenges-featured-for-faculty' => 'faculty/promote-challenges-featured-for-faculty.php',
];
$page=screen_page($screens,'promote-challenges-available-challenges');
$page_role='faculty';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'faculty-activities-create-activity':
page_start('Faculty Activities','Faculty Activities',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Faculty Activities') ?>Faculty Activities</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Bring people together around a shared action.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/challenges.php?view=faculty-activities-proposed-activities">Proposed activities</a>
          <a href="../faculty/challenges.php?view=faculty-activities-create-activity" class="is-active" aria-current="page">Create activity</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Create activity</h2>
          </div>
          <div class="form-grid">
            <div class="field">
              <label for="activity-name">Activity name</label>
              <input id="activity-name" name="activity-name" type="text" placeholder="A name your faculty will recognise" form="backend-form">
            </div>
            <div class="field">
              <label for="activity-date">Date and time</label>
              <input id="activity-date" name="activity-date" type="datetime-local" form="backend-form">
            </div>
            <div class="field">
              <label for="activity-location">Location</label>
              <input id="activity-location" name="activity-location" type="text" placeholder="For example, Computing foyer" form="backend-form">
            </div>
            <div class="field">
              <label for="activity-limit">Participant limit</label>
              <input id="activity-limit" name="activity-limit" type="number" aria-describedby="activity-limit-hint" placeholder="Participant limit" form="backend-form">
              <small class="field-hint" id="activity-limit-hint">Set the maximum number of participants for this activity.</small>
            </div>
            <div class="field field-full">
              <label for="activity-details">Details</label>
              <textarea id="activity-details" name="activity-details" rows="4" aria-describedby="activity-details-hint" form="backend-form"></textarea>
              <small class="field-hint" id="activity-details-hint">Describe the activity and what participants should bring.</small>
            </div>
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit" form="backend-form">Propose activity</button>
            <a class="button button--outline" href="../faculty/challenges.php?view=faculty-activities-proposed-activities">Cancel</a>
          </div>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-activity" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'faculty-activities-faculty-cleanup':
page_start('Faculty Activities','Faculty Activities',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Faculty Activities') ?>Faculty Activities</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Bring people together around a shared action.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/challenges.php?view=faculty-activities-proposed-activities" class="is-active" aria-current="page">Proposed activities</a>
          <a href="../faculty/challenges.php?view=faculty-activities-create-activity">Create activity</a>
        </nav>
        <div class="form-actions">
          <a class="button button--primary" href="../faculty/challenges.php?view=faculty-activities-create-activity">Create activity</a>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Proposed activities</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty activity proposals</caption>
              <thead>
                <tr>
                  <th scope="col">Activity</th>
                  <th scope="col">Date and time</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='activities'; $columns=['Activity', 'Date and time', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    <section class="panel stack"><?php if ($record) echo '<h2>' . e($record['name']) . '</h2><p>' . e($record['details']) . '</p><p>' . e($record['activity_date']) . ' · ' . e($record['location']) . '</p>'; ?></section></main>
  
<?php page_end(); break;
case 'faculty-activities-proposed-activities':
page_start('Faculty Activities','Faculty Activities',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Faculty Activities') ?>Faculty Activities</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Bring people together around a shared action.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/challenges.php?view=faculty-activities-proposed-activities" class="is-active" aria-current="page">Proposed activities</a>
          <a href="../faculty/challenges.php?view=faculty-activities-create-activity">Create activity</a>
        </nav>
        <div class="form-actions">
          <a class="button button--primary" href="../faculty/challenges.php?view=faculty-activities-create-activity">Create activity</a>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Proposed activities</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty activity proposals</caption>
              <thead>
                <tr>
                  <th scope="col">Activity</th>
                  <th scope="col">Date and time</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='activities'; $columns=['Activity', 'Date and time', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'promote-challenges-available-challenges':
page_start('Promote Challenges','Promote Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Promote Challenges') ?>Promote Challenges</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Help your faculty find its next good habit.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/challenges.php?view=promote-challenges-available-challenges" class="is-active" aria-current="page">Available challenges</a>
          <a href="../faculty/challenges.php?view=promote-challenges-featured-for-faculty">Featured for faculty</a>
        </nav>
        <div class="toolbar">
          <div class="field">
            <label for="promotion-search">Search challenges</label>
            <input id="promotion-search" name="promotion-search" type="search" placeholder="Search challenges">
          </div>
          <div class="field">
            <label for="promotion-search-filter">Featured state</label>
            <select id="promotion-search-filter" name="promotion-search-filter">
              <option>Not featured</option>
              <option>All challenges</option>
              <option>Featured</option>
            </select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Available challenges</h2>
          </div>
          <div class="grid-3"><?php include __DIR__ . '/../includes/cards.php'; ?></div>
        </section>
        <p class="note">Featuring a challenge is a faculty promotion choice. It does not change the challenge's points or review rules.</p>
      </div>
    </main>
  
<?php page_end(); break;
case 'promote-challenges-feature-challenge':
page_start('Promote Challenges','Promote Challenges',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Promote Challenges') ?>Promote Challenges</h1>
            <p class="context-line">Faculty Representative</p>
            <p class="page-description">Help your faculty find its next good habit.</p>
          </div>
        </div>
        <div class="stack">
          <nav class="page-tabs" aria-label="Section views">
            <a href="../faculty/challenges.php?view=promote-challenges-available-challenges" class="is-active" aria-current="page">Available challenges</a>
            <a href="../faculty/challenges.php?view=promote-challenges-featured-for-faculty">Featured for faculty</a>
          </nav>
          <div class="toolbar">
            <div class="field">
              <label for="promotion-search">Search challenges</label>
              <input id="promotion-search" name="promotion-search" type="search" placeholder="Search challenges">
            </div>
            <div class="field">
              <label for="promotion-search-filter">Featured state</label>
              <select id="promotion-search-filter" name="promotion-search-filter">
                <option>Not featured</option>
                <option>All challenges</option>
                <option>Featured</option>
              </select>
            </div>
          </div>
          <section class="panel">
            <div class="panel-heading">
              <h2>Available challenges</h2>
            </div>
            <div class="grid-3"><?php include __DIR__ . '/../includes/cards.php'; ?></div>
          </section>
          <p class="note">Featuring a challenge is a faculty promotion choice. It does not change the challenge's points or review rules.</p>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Feature challenge</h2>
            <p class="context-line">Faculty Representative</p>
          </div>
          <a class="close-button" href="../faculty/challenges.php?view=promote-challenges-available-challenges" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <h3>No challenge selected</h3>
          <p>Choose an available challenge and faculty before featuring it.</p>
          <dl class="detail-list">
            <div>
              <dt>Faculty</dt>
              <dd><?php echo e($record['faculty'] ?? 'Not selected'); ?></dd>
            </div>
            <div>
              <dt>Participants</dt>
              <dd><?php echo e($record['participants'] ?? 'Not selected'); ?></dd>
            </div>
          </dl>
          <div class="form-actions">
            <a class="button button--primary" href="../faculty/challenges.php?view=promote-challenges-available-challenges">Choose a challenge</a>
          </div>
        </div>
      </section>
    </div>
  
<?php page_end(); break;
case 'promote-challenges-featured-for-faculty':
page_start('Promote Challenges','Promote Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Promote Challenges') ?>Promote Challenges</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Help your faculty find its next good habit.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/challenges.php?view=promote-challenges-available-challenges">Available challenges</a>
          <a href="../faculty/challenges.php?view=promote-challenges-featured-for-faculty" class="is-active" aria-current="page">Featured for faculty</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Featured for your faculty</h2>
          </div>
          <div class="grid-3"><?php include __DIR__ . '/../includes/cards.php'; ?></div>
        </section>
        <p class="note">Featuring a challenge is a faculty promotion choice. It does not change the challenge's points or review rules.</p>
      </div>
    </main>
  
<?php page_end(); break;
}
