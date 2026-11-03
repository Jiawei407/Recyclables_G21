<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'announcements-all-announcements' => 'coordinator/announcements-all-announcements.php',
    'announcements-create' => 'coordinator/announcements-create.php',
    'announcements-edit' => 'coordinator/announcements-edit.php',
    'campaigns-campaigns' => 'coordinator/campaigns-campaigns.php',
    'campaigns-create' => 'coordinator/campaigns-create.php',
    'campaigns-edit' => 'coordinator/campaigns-edit.php',
    'campaigns-performance' => 'coordinator/campaigns-performance.php',
    'challenges-all-challenges' => 'coordinator/challenges-all-challenges.php',
    'challenges-create-upload-photo' => 'coordinator/challenges-create-upload-photo.php',
    'challenges-create' => 'coordinator/challenges-create.php',
    'challenges-edit-upload-photo' => 'coordinator/challenges-edit-upload-photo.php',
    'challenges-edit' => 'coordinator/challenges-edit.php',
];
$page=screen_page($screens,'challenges-all-challenges');
$page_role='coordinator';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'announcements-all-announcements':
page_start('Announcements','Announcements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Announcements') ?>Announcements</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Useful reminders, written for the people taking part.</p>
        </div>
        <div class="page-actions">
          <a class="button button--primary" href="../coordinator/manage.php?view=announcements-create">Create announcement</a>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=announcements-all-announcements" class="is-active" aria-current="page">All announcements</a>
        <a href="../coordinator/manage.php?view=announcements-create">Create</a>
        <a href="../coordinator/manage.php?view=announcements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
      </nav>
      <section class="panel stack" aria-labelledby="announcement-list-title">
        <h2 id="announcement-list-title">All announcements</h2>
        <div class="table-wrap">
          <table class="data-table">
            <caption class="visually-hidden">coordinator announcements</caption>
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Published</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody><?php $kind='announcements'; $columns=['Title', 'Published', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
          </table>
        </div>
        <p class="note">Use a short title and a useful, specific message for the campus.</p>
      </section>
    </main>
  
<?php page_end(); break;
case 'announcements-create':
page_start('Announcements','Announcements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Announcements') ?>Announcements</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Keep the message focused on what happens, where and when.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=announcements-all-announcements">All announcements</a>
        <a href="../coordinator/manage.php?view=announcements-create" class="is-active" aria-current="page">Create</a>
        <a href="../coordinator/manage.php?view=announcements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
      </nav>
      <div class="stack" aria-label="Create announcement" role="form">
        <section class="panel stack" aria-labelledby="announcement-form-title">
          <h2 id="announcement-form-title">Create an announcement</h2>
          <div class="form-grid">
            <div class="field field--full">
              <label for="announcement-title">Title</label>
              <input id="announcement-title" name="announcement-title" type="text" required placeholder="Title" form="backend-form" value="<?php echo value('announcement-title','title',''); ?>">
            </div>
            <div class="field field--full">
              <label for="announcement-message">Message</label>
              <textarea id="announcement-message" name="announcement-message" rows="6" placeholder="Message" form="backend-form"><?php echo value('announcement-message','message'); ?></textarea>
              <p class="field-hint">Include the action, place, date and any evidence instructions.</p>
            </div>
            <div class="field">
              <label for="announcement-date">Publish date</label>
              <input id="announcement-date" name="announcement-date" type="date" form="backend-form" value="<?php echo value('announcement-date','publish_date',''); ?>">
            </div>
            <div class="field">
              <label for="announcement-audience">Audience</label>
              <select id="announcement-audience" name="announcement-audience" form="backend-form">
                <option value="All users" <?php echo selected('announcement-audience','audience','All users','All users') ? 'selected' : ''; ?>>All users</option>
                <option value="Registered participants" <?php echo selected('announcement-audience','audience','Registered participants','All users') ? 'selected' : ''; ?>>Registered participants</option>
                <option value="Faculty representatives" <?php echo selected('announcement-audience','audience','Faculty representatives','All users') ? 'selected' : ''; ?>>Faculty representatives</option>
                <option value="Coordinators" <?php echo selected('announcement-audience','audience','Coordinators','All users') ? 'selected' : ''; ?>>Coordinators</option>
              </select>
            </div>
          </div>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Publish</button>
          <a class="button button--outline" href="../coordinator/manage.php?view=announcements-all-announcements">Cancel</a>
        </div>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-announcement" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'announcements-edit':
page_start('Announcements','Announcements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Announcements') ?>Announcements</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Keep the message focused on what happens, where and when.</p>
        </div>
        <p class="note">No record selected.</p>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=announcements-all-announcements">All announcements</a>
        <a href="../coordinator/manage.php?view=announcements-create">Create</a>
        <a href="../coordinator/manage.php?view=announcements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>" class="is-active" aria-current="page">Edit</a>
      </nav>
      <div class="stack" aria-label="Edit announcement" role="form">
        <section class="panel stack" aria-labelledby="announcement-form-title">
          <h2 id="announcement-form-title">Edit announcement</h2>
          <div class="form-grid">
            <div class="field field--full">
              <label for="announcement-title">Title</label>
              <input id="announcement-title" name="announcement-title" type="text" required placeholder="Title" form="backend-form" value="<?php echo value('announcement-title','title',''); ?>">
            </div>
            <div class="field field--full">
              <label for="announcement-message">Message</label>
              <textarea id="announcement-message" name="announcement-message" rows="6" placeholder="Message" form="backend-form"><?php echo value('announcement-message','message'); ?></textarea>
              <p class="field-hint">Include the action, place, date and any evidence instructions.</p>
            </div>
            <div class="field">
              <label for="announcement-date">Publish date</label>
              <input id="announcement-date" name="announcement-date" type="date" form="backend-form" value="<?php echo value('announcement-date','publish_date',''); ?>">
            </div>
            <div class="field">
              <label for="announcement-audience">Audience</label>
              <select id="announcement-audience" name="announcement-audience" form="backend-form">
                <option value="All users" <?php echo selected('announcement-audience','audience','All users','All users') ? 'selected' : ''; ?>>All users</option>
                <option value="Registered participants" <?php echo selected('announcement-audience','audience','Registered participants','All users') ? 'selected' : ''; ?>>Registered participants</option>
                <option value="Faculty representatives" <?php echo selected('announcement-audience','audience','Faculty representatives','All users') ? 'selected' : ''; ?>>Faculty representatives</option>
                <option value="Coordinators" <?php echo selected('announcement-audience','audience','Coordinators','All users') ? 'selected' : ''; ?>>Coordinators</option>
              </select>
            </div>
          </div>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Publish</button>
          <a class="button button--outline" href="../coordinator/manage.php?view=announcements-all-announcements">Cancel</a>
        </div>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-announcement" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'campaigns-campaigns':
page_start('Campaigns','Campaigns',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Campaigns') ?>Campaigns</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Connect everyday challenges to a shared campus goal.</p>
        </div>
        <div class="page-actions">
          <a class="button button--primary" href="../coordinator/manage.php?view=campaigns-create">Create campaign</a>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=campaigns-campaigns" class="is-active" aria-current="page">Campaigns</a>
        <a href="../coordinator/manage.php?view=campaigns-create">Create</a>
        <a href="../coordinator/manage.php?view=campaigns-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
        <a href="../coordinator/manage.php?view=campaigns-performance<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Performance</a>
      </nav>
      <section class="panel stack" aria-labelledby="campaign-list-title">
        <h2 id="campaign-list-title">Campaigns</h2>
        <div class="table-wrap">
          <table class="data-table">
            <caption class="visually-hidden">sustainability campaigns</caption>
            <thead>
              <tr>
                <th scope="col">Campaign</th>
                <th scope="col">Period</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody><?php $kind='campaigns'; $columns=['Campaign', 'Period', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
          </table>
        </div>
        <p class="note">Group related challenges into a manageable campus campaign.</p>
      </section>
    </main>
  
<?php page_end(); break;
case 'campaigns-create':
page_start('Campaigns','Campaigns',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Campaigns') ?>Campaigns</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Give related challenges a purpose, a period and a practical target.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=campaigns-campaigns">Campaigns</a>
        <a href="../coordinator/manage.php?view=campaigns-create" class="is-active" aria-current="page">Create</a>
        <a href="../coordinator/manage.php?view=campaigns-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
        <a href="../coordinator/manage.php?view=campaigns-performance<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Performance</a>
      </nav>
      <div class="stack" aria-label="Create campaign" role="form">
        <section class="panel stack" aria-labelledby="campaign-form-title">
          <h2 id="campaign-form-title">Create a campaign</h2>
          <div class="form-grid">
            <div class="field">
              <label for="campaign-name">Name</label>
              <input id="campaign-name" name="campaign-name" type="text" required placeholder="Name" form="backend-form" value="<?php echo value('campaign-name','name',''); ?>">
            </div>
            <div class="field">
              <label for="campaign-target">Participant target</label>
              <input id="campaign-target" name="campaign-target" type="number" min="1" placeholder="Participant target" form="backend-form" value="<?php echo value('campaign-target','participant_target',''); ?>">
              <p class="field-hint">A simple target for the campaign.</p>
            </div>
            <div class="field field--full">
              <label for="campaign-description">Description</label>
              <textarea id="campaign-description" name="campaign-description" rows="4" placeholder="Description" form="backend-form"><?php echo value('campaign-description','description'); ?></textarea>
              <p class="field-hint">Explain the shared purpose of the included challenges.</p>
            </div>
            <div class="field">
              <label for="campaign-start">Start date</label>
              <input id="campaign-start" name="campaign-start" type="date" form="backend-form" value="<?php echo value('campaign-start','start_date',''); ?>">
            </div>
            <div class="field">
              <label for="campaign-end">End date</label>
              <input id="campaign-end" name="campaign-end" type="date" form="backend-form" value="<?php echo value('campaign-end','end_date',''); ?>">
            </div>
            <div class="field">
              <label for="campaign-bonus">Bonus points</label>
              <input id="campaign-bonus" name="campaign-bonus" type="number" min="0" placeholder="Bonus points" form="backend-form" value="<?php echo value('campaign-bonus','bonus_points','0'); ?>">
              <p class="field-hint">A proposed completion bonus for coordinator review.</p>
            </div>
            <div class="field">
              <label for="campaign-badge">Achievement badge</label>
              <select id="campaign-badge" name="campaign-badge" form="backend-form"><?php echo '<option value="">No badge</option>'; foreach (rows("SELECT id,name FROM achievements WHERE status='active' OR id=?",[$record['achievement_id'] ?? 0]) as $badge) echo '<option value="' . (int)$badge['id'] . '"' . selected('campaign-badge','achievement_id',$badge['id']) . '>' . e($badge['name']) . '</option>';  ?></select>
            </div>
            <fieldset class="field field--full check-group">
              <legend>Included challenges</legend>
              <div class="check-list"><?php include __DIR__ . '/../includes/campaign_choices.php'; ?></div>
              <p class="field-hint">Select the challenges participants can complete within this campaign.</p>
            </fieldset>
          </div>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Save campaign</button>
          <a class="button button--outline" href="../coordinator/manage.php?view=campaigns-campaigns">Cancel</a>
        </div>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-campaign" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'campaigns-edit':
page_start('Campaigns','Campaigns',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Campaigns') ?>Campaigns</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Give related challenges a purpose, a period and a practical target.</p>
        </div>
        <p class="note">No record selected.</p>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=campaigns-campaigns">Campaigns</a>
        <a href="../coordinator/manage.php?view=campaigns-create">Create</a>
        <a href="../coordinator/manage.php?view=campaigns-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>" class="is-active" aria-current="page">Edit</a>
        <a href="../coordinator/manage.php?view=campaigns-performance<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Performance</a>
      </nav>
      <div class="stack" aria-label="Edit campaign" role="form">
        <section class="panel stack" aria-labelledby="campaign-form-title">
          <h2 id="campaign-form-title">Edit campaign</h2>
          <div class="form-grid">
            <div class="field">
              <label for="campaign-name">Name</label>
              <input id="campaign-name" name="campaign-name" type="text" required placeholder="Name" form="backend-form" value="<?php echo value('campaign-name','name',''); ?>">
            </div>
            <div class="field">
              <label for="campaign-target">Participant target</label>
              <input id="campaign-target" name="campaign-target" type="number" min="1" placeholder="Participant target" form="backend-form" value="<?php echo value('campaign-target','participant_target',''); ?>">
              <p class="field-hint">A simple target for the campaign.</p>
            </div>
            <div class="field field--full">
              <label for="campaign-description">Description</label>
              <textarea id="campaign-description" name="campaign-description" rows="4" placeholder="Description" form="backend-form"><?php echo value('campaign-description','description'); ?></textarea>
              <p class="field-hint">Explain the shared purpose of the included challenges.</p>
            </div>
            <div class="field">
              <label for="campaign-start">Start date</label>
              <input id="campaign-start" name="campaign-start" type="date" form="backend-form" value="<?php echo value('campaign-start','start_date',''); ?>">
            </div>
            <div class="field">
              <label for="campaign-end">End date</label>
              <input id="campaign-end" name="campaign-end" type="date" form="backend-form" value="<?php echo value('campaign-end','end_date',''); ?>">
            </div>
            <div class="field">
              <label for="campaign-bonus">Bonus points</label>
              <input id="campaign-bonus" name="campaign-bonus" type="number" min="0" placeholder="Bonus points" form="backend-form" value="<?php echo value('campaign-bonus','bonus_points','0'); ?>">
              <p class="field-hint">A proposed completion bonus for coordinator review.</p>
            </div>
            <div class="field">
              <label for="campaign-badge">Achievement badge</label>
              <select id="campaign-badge" name="campaign-badge" form="backend-form"><?php echo '<option value="">No badge</option>'; foreach (rows("SELECT id,name FROM achievements WHERE status='active' OR id=?",[$record['achievement_id'] ?? 0]) as $badge) echo '<option value="' . (int)$badge['id'] . '"' . selected('campaign-badge','achievement_id',$badge['id']) . '>' . e($badge['name']) . '</option>';  ?></select>
            </div>
            <fieldset class="field field--full check-group">
              <legend>Included challenges</legend>
              <div class="check-list"><?php include __DIR__ . '/../includes/campaign_choices.php'; ?></div>
              <p class="field-hint">Select the challenges participants can complete within this campaign.</p>
            </fieldset>
          </div>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Save campaign</button>
          <a class="button button--outline" href="../coordinator/manage.php?view=campaigns-campaigns">Cancel</a>
        </div>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-campaign" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'campaigns-performance':
page_start('Campaign performance','Campaigns',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Campaign performance') ?>Campaign performance</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">See who joined, what was completed and how the campaign is progressing.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=campaigns-campaigns">Campaigns</a>
        <a href="../coordinator/manage.php?view=campaigns-create">Create</a>
        <a href="../coordinator/manage.php?view=campaigns-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
        <a href="../coordinator/manage.php?view=campaigns-performance<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>" class="is-active" aria-current="page">Performance</a>
      </nav>
      <div class="stack">
        <div class="grid-3">
          <article class="metric">
            <div class="metric-label">
              Participants
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <circle cx="9" cy="7" r="3"></circle>
                <path d="M3 20v-2a6 6 0 0 1 12 0v2M16 4a3 3 0 0 1 0 6m2 4a5 5 0 0 1 3 4v2"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Participants  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Completed
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="m5 12 4 4L19 6"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Completed  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
          <article class="metric">
            <div class="metric-label">
              Target
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Target  No records available')); ?></p>
            <p class="metric-note">Based on saved records</p>
          </article>
        </div>
        <section class="panel stack" aria-labelledby="performance-title">
          <h2 id="performance-title">Campaign performance</h2>
          <p class="context-line">No campaign selected</p>
          <div class="progress-block">
            <div class="progress-label">
              <span>Participation target</span>
              <strong>—</strong>
            </div>
            <progress value="0" max="1" aria-label="Participation target">
              No progress data available
            </progress>
            <p class="field-hint">No progress data available.</p>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Challenge participation</caption>
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
          <details>
            <summary class="icon-disclosure" title="Show campaign performance details">
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="m6 9 6 6 6-6"></path>
              </svg>
              <span class="disclosure-open-label visually-hidden">Show campaign performance details</span>
              <span class="disclosure-collapse-label">Close details<span class="visually-hidden">: campaign performance details</span> </span>
            </summary>
            <div class="stack">
              <p>Joined counts participation records. Completed counts approved evidence records. One participant may join more than one challenge.</p>
              <a class="text-link" href="../coordinator/submissions.php?view=submissions-approved">
                View approved evidence
                <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                  <path d="M6 18 18 6M6 6h12v12"></path>
                </svg>
              </a>
            </div>
          </details>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'challenges-all-challenges':
page_start('Challenges','Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenges') ?>Challenges</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Clear tasks. Fair rewards. A manageable campus program.</p>
        </div>
        <div class="page-actions">
          <a class="button button--primary" href="../coordinator/manage.php?view=challenges-create">Create challenge</a>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=challenges-all-challenges" class="is-active" aria-current="page">All challenges</a>
        <a href="../coordinator/manage.php?view=challenges-create">Create</a>
        <a href="../coordinator/manage.php?view=challenges-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
      </nav>
      <div class="stack">
        <div class="toolbar">
          <div class="field">
            <label for="challenge-search">Search challenges</label>
            <input id="challenge-search" name="challenge-search" type="search" placeholder="Search challenges">
          </div>
          <div class="field">
            <label for="challenge-status">Challenge status</label>
            <select id="challenge-status" name="challenge-status">
              <option value="open">Open</option><option value="closed">Closed</option><option value="draft">Draft</option></select>
          </div>
        </div>
        <section class="panel stack" aria-labelledby="challenge-list-title">
          <h2 id="challenge-list-title">Challenges</h2>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">challenge management records</caption>
              <thead>
                <tr>
                  <th scope="col">Challenge</th>
                  <th scope="col">Status</th>
                  <th scope="col">Green Points</th>
                  <th scope="col">End date</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='challenges'; $columns=['Challenge', 'Status', 'Green Points', 'End date', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'challenges-create-upload-photo':
redirect('coordinator/challenges-create.php' . (isset($_GET['id']) ? '?id=' . (int)$_GET['id'] : ''));
break;
case 'challenges-create':
page_start('Challenges','Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenges') ?>Challenges</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Shape a simple action that participants can complete and reviewers can verify.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=challenges-all-challenges">All challenges</a>
        <a href="../coordinator/manage.php?view=challenges-create" class="is-active" aria-current="page">Create</a>
        <a href="../coordinator/manage.php?view=challenges-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
      </nav>
      <div class="stack" aria-label="Create challenge" role="form">
        <section class="panel stack" aria-labelledby="challenge-details-title">
          <h2 id="challenge-details-title">Create a challenge</h2>
          <p class="note">Keep the task specific, the evidence clear, and the reward easy to understand.</p>
          <div class="form-grid">
            <div class="field">
              <label for="challenge-title">Title</label>
              <input id="challenge-title" name="challenge-title" type="text" required placeholder="Title" form="backend-form" value="<?php echo value('challenge-title','title',''); ?>">
            </div>
            <div class="field">
              <label for="challenge-category">Category</label>
              <select id="challenge-category" name="challenge-category" form="backend-form">
                <option value="" <?php echo selected('challenge-category','category','','') ? 'selected' : ''; ?>>Choose an option</option>
                <option value="Cleanup" <?php echo selected('challenge-category','category','Cleanup','') ? 'selected' : ''; ?>>Cleanup</option>
                <option value="Recycling" <?php echo selected('challenge-category','category','Recycling','') ? 'selected' : ''; ?>>Recycling</option>
                <option value="Reuse" <?php echo selected('challenge-category','category','Reuse','') ? 'selected' : ''; ?>>Reuse</option>
                <option value="Everyday habits" <?php echo selected('challenge-category','category','Everyday habits','') ? 'selected' : ''; ?>>Everyday habits</option>
              </select>
            </div>
            <div class="field field--full">
              <label for="challenge-description">Description</label>
              <textarea id="challenge-description" name="challenge-description" rows="4" placeholder="Description" form="backend-form"><?php echo value('challenge-description','description'); ?></textarea>
              <p class="field-hint">Describe what participants should do and photograph.</p>
            </div>
            <div class="field">
              <label for="challenge-points">Green Points</label>
              <input id="challenge-points" name="challenge-points" type="number" min="0" max="1000" placeholder="Green Points" form="backend-form" value="<?php echo value('challenge-points','points','0'); ?>">
              <p class="field-hint">Awarded after a coordinator approves the evidence.</p>
            </div>
          <div class="field"><label for="tracked-item">Tracked item for achievements</label><select id="tracked-item" name="tracked-item" form="backend-form"><option value="Approved activity" <?php echo selected('tracked-item','tracked_item','Approved activity','Approved activity') ? 'selected' : ''; ?>>Approved activity</option><option value="Plastic bottles" <?php echo selected('tracked-item','tracked_item','Plastic bottles','Approved activity') ? 'selected' : ''; ?>>Plastic bottles</option><option value="Reusable cup" <?php echo selected('tracked-item','tracked_item','Reusable cup','Approved activity') ? 'selected' : ''; ?>>Reusable cup</option><option value="Campus cleanup" <?php echo selected('tracked-item','tracked_item','Campus cleanup','Approved activity') ? 'selected' : ''; ?>>Campus cleanup</option></select></div></div>
          <div class="upload-area">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="M12 16V3m-5 5 5-5 5 5M4 16v5h16v-5"></path>
            </svg>
            <div>
              <strong>Challenge illustration</strong>
              <p class="note">Choose a simple illustration for this challenge.</p>
            </div>
            <label class="button button--outline"><span data-file-name="backend-upload">Choose image</span><input class="visually-hidden" type="file" id="backend-upload" form="backend-form" name="image" accept="image/jpeg,image/png"></label></div>
        </section>
        <section class="panel stack" aria-labelledby="challenge-rules-title">
          <h2 id="challenge-rules-title">Rules and schedule</h2>
          <div class="form-grid">
            <div class="field">
              <label for="challenge-start">Start date</label>
              <input id="challenge-start" name="challenge-start" type="date" form="backend-form" value="<?php echo value('challenge-start','start_date',''); ?>">
            </div>
            <div class="field">
              <label for="challenge-end">End date</label>
              <input id="challenge-end" name="challenge-end" type="date" form="backend-form" value="<?php echo value('challenge-end','end_date',''); ?>">
            </div>
            <div class="field">
              <label for="challenge-evidence">Evidence type</label>
              <select id="challenge-evidence" name="challenge-evidence" form="backend-form">
                <option value="" selected>Choose an option</option>
                <option>Photo evidence</option>
              </select>
              <p class="field-hint">Evidence is reviewed manually.</p>
            </div>
            <div class="field">
              <label for="challenge-limit">Submission limit</label>
              <input id="challenge-limit" name="challenge-limit" type="number" min="1" placeholder="Submission limit" form="backend-form" value="<?php echo value('challenge-limit','submission_limit','1'); ?>">
              <p class="field-hint">Maximum approved submissions per participant.</p>
            </div>
            <div class="field">
              <label for="challenge-eligibility">Eligibility</label>
              <select id="challenge-eligibility" name="challenge-eligibility" form="backend-form">
                <option value="" <?php echo selected('challenge-eligibility','eligibility','','') ? 'selected' : ''; ?>>Choose an option</option>
                <option value="Students and staff" <?php echo selected('challenge-eligibility','eligibility','Students and staff','') ? 'selected' : ''; ?>>Students and staff</option>
                <option value="Students" <?php echo selected('challenge-eligibility','eligibility','Students','') ? 'selected' : ''; ?>>Students</option>
                <option value="Staff" <?php echo selected('challenge-eligibility','eligibility','Staff','') ? 'selected' : ''; ?>>Staff</option>
              </select>
            </div>
            <div class="field">
              <label for="challenge-completion">Completion requirement</label>
              <input id="challenge-completion" name="challenge-completion" type="text" placeholder="Completion requirement" form="backend-form" value="<?php echo value('challenge-completion','completion_requirement',''); ?>">
              <p class="field-hint">Write one clear completion rule.</p>
            </div>
          </div>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Save challenge</button>
          <a class="button button--outline" href="../coordinator/manage.php?view=challenges-all-challenges">Cancel</a>
        </div>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-challenge" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'challenges-edit-upload-photo':
redirect('coordinator/challenges-edit.php' . (isset($_GET['id']) ? '?id=' . (int)$_GET['id'] : ''));
break;
case 'challenges-edit':
page_start('Challenges','Challenges',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Challenges') ?>Challenges</h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Shape a simple action that participants can complete and reviewers can verify.</p>
        </div>
        <p class="note">No record selected.</p>
      </div>
      <nav class="page-tabs" aria-label="Section views">
        <a href="../coordinator/manage.php?view=challenges-all-challenges">All challenges</a>
        <a href="../coordinator/manage.php?view=challenges-create">Create</a>
        <a href="../coordinator/manage.php?view=challenges-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>" class="is-active" aria-current="page">Edit</a>
      </nav>
      <div class="stack" aria-label="Edit challenge" role="form">
        <section class="panel stack" aria-labelledby="challenge-details-title">
          <h2 id="challenge-details-title">Edit challenge</h2>
          <p class="note">Keep the task specific, the evidence clear, and the reward easy to understand.</p>
          <div class="form-grid">
            <div class="field">
              <label for="challenge-title">Title</label>
              <input id="challenge-title" name="challenge-title" type="text" required placeholder="Title" form="backend-form" value="<?php echo value('challenge-title','title',''); ?>">
            </div>
            <div class="field">
              <label for="challenge-category">Category</label>
              <select id="challenge-category" name="challenge-category" form="backend-form">
                <option value="" <?php echo selected('challenge-category','category','','') ? 'selected' : ''; ?>>Choose an option</option>
                <option value="Cleanup" <?php echo selected('challenge-category','category','Cleanup','') ? 'selected' : ''; ?>>Cleanup</option>
                <option value="Recycling" <?php echo selected('challenge-category','category','Recycling','') ? 'selected' : ''; ?>>Recycling</option>
                <option value="Reuse" <?php echo selected('challenge-category','category','Reuse','') ? 'selected' : ''; ?>>Reuse</option>
                <option value="Everyday habits" <?php echo selected('challenge-category','category','Everyday habits','') ? 'selected' : ''; ?>>Everyday habits</option>
              </select>
            </div>
            <div class="field field--full">
              <label for="challenge-description">Description</label>
              <textarea id="challenge-description" name="challenge-description" rows="4" placeholder="Description" form="backend-form"><?php echo value('challenge-description','description'); ?></textarea>
              <p class="field-hint">Describe what participants should do and photograph.</p>
            </div>
            <div class="field">
              <label for="challenge-points">Green Points</label>
              <input id="challenge-points" name="challenge-points" type="number" min="0" max="1000" placeholder="Green Points" form="backend-form" value="<?php echo value('challenge-points','points','0'); ?>">
              <p class="field-hint">Awarded after a coordinator approves the evidence.</p>
            </div>
          <div class="field"><label for="tracked-item">Tracked item for achievements</label><select id="tracked-item" name="tracked-item" form="backend-form"><option value="Approved activity" <?php echo selected('tracked-item','tracked_item','Approved activity','Approved activity') ? 'selected' : ''; ?>>Approved activity</option><option value="Plastic bottles" <?php echo selected('tracked-item','tracked_item','Plastic bottles','Approved activity') ? 'selected' : ''; ?>>Plastic bottles</option><option value="Reusable cup" <?php echo selected('tracked-item','tracked_item','Reusable cup','Approved activity') ? 'selected' : ''; ?>>Reusable cup</option><option value="Campus cleanup" <?php echo selected('tracked-item','tracked_item','Campus cleanup','Approved activity') ? 'selected' : ''; ?>>Campus cleanup</option></select></div></div>
          <div class="upload-area">
            <svg class="upload-thumbnail challenge-illustration" viewbox="0 0 600 600" width="600" height="600" role="img" aria-label="No image selected">
              <rect width="600" height="600" fill="var(--sage)"></rect>
              <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="40">No image selected</text>
            </svg>
            <div>
              <strong>Challenge illustration</strong>
              <p class="note">No image selected</p>
            </div>
            <label class="button button--outline"><span data-file-name="backend-upload">Choose image</span><input class="visually-hidden" type="file" id="backend-upload" form="backend-form" name="image" accept="image/jpeg,image/png"></label></div>
        </section>
        <section class="panel stack" aria-labelledby="challenge-rules-title">
          <h2 id="challenge-rules-title">Rules and schedule</h2>
          <div class="form-grid">
            <div class="field">
              <label for="challenge-start">Start date</label>
              <input id="challenge-start" name="challenge-start" type="date" form="backend-form" value="<?php echo value('challenge-start','start_date',''); ?>">
            </div>
            <div class="field">
              <label for="challenge-end">End date</label>
              <input id="challenge-end" name="challenge-end" type="date" form="backend-form" value="<?php echo value('challenge-end','end_date',''); ?>">
            </div>
            <div class="field">
              <label for="challenge-evidence">Evidence type</label>
              <select id="challenge-evidence" name="challenge-evidence" form="backend-form">
                <option value="" selected>Choose an option</option>
                <option>Photo evidence</option>
              </select>
              <p class="field-hint">Evidence is reviewed manually.</p>
            </div>
            <div class="field">
              <label for="challenge-limit">Submission limit</label>
              <input id="challenge-limit" name="challenge-limit" type="number" min="1" placeholder="Submission limit" form="backend-form" value="<?php echo value('challenge-limit','submission_limit','1'); ?>">
              <p class="field-hint">Maximum approved submissions per participant.</p>
            </div>
            <div class="field">
              <label for="challenge-eligibility">Eligibility</label>
              <select id="challenge-eligibility" name="challenge-eligibility" form="backend-form">
                <option value="" <?php echo selected('challenge-eligibility','eligibility','','') ? 'selected' : ''; ?>>Choose an option</option>
                <option value="Students and staff" <?php echo selected('challenge-eligibility','eligibility','Students and staff','') ? 'selected' : ''; ?>>Students and staff</option>
                <option value="Students" <?php echo selected('challenge-eligibility','eligibility','Students','') ? 'selected' : ''; ?>>Students</option>
                <option value="Staff" <?php echo selected('challenge-eligibility','eligibility','Staff','') ? 'selected' : ''; ?>>Staff</option>
              </select>
            </div>
            <div class="field">
              <label for="challenge-completion">Completion requirement</label>
              <input id="challenge-completion" name="challenge-completion" type="text" placeholder="Completion requirement" form="backend-form" value="<?php echo value('challenge-completion','completion_requirement',''); ?>">
              <p class="field-hint">Write one clear completion rule.</p>
            </div>
          </div>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Save challenge</button>
          <a class="button button--outline" href="../coordinator/manage.php?view=challenges-all-challenges">Cancel</a>
        </div>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-challenge" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
}
