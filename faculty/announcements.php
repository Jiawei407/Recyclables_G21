<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'announcements-announcements' => 'faculty/announcements-announcements.php',
    'announcements-create' => 'faculty/announcements-create.php',
    'announcements-edit' => 'faculty/announcements-edit.php',
];
$page=screen_page($screens,'announcements-announcements');
$page_role='faculty';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'announcements-announcements':
page_start('Announcements','Announcements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Announcements') ?>Announcements</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Keep your faculty informed.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/announcements.php?view=announcements-announcements" class="is-active" aria-current="page">Announcements</a>
          <a href="../faculty/announcements.php?view=announcements-create">Create</a>
          <a href="../faculty/announcements.php?view=announcements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
        </nav>
        <div class="form-actions">
          <a class="button button--primary" href="../faculty/announcements.php?view=announcements-create">Create announcement</a>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty announcements</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty announcements</caption>
              <thead>
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Publish date</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='announcements'; $columns=['Title', 'Publish date', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'announcements-create':
page_start('Announcements','Announcements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Announcements') ?>Announcements</h1>
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Keep your faculty informed.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/announcements.php?view=announcements-announcements">Announcements</a>
          <a href="../faculty/announcements.php?view=announcements-create" class="is-active" aria-current="page">Create</a>
          <a href="../faculty/announcements.php?view=announcements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Create announcement</h2>
          </div>
          <div class="form-grid">
            <div class="field">
              <label for="announcement-title">Title</label>
              <input id="announcement-title" name="announcement-title" type="text" placeholder="A clear, short headline" form="backend-form" value="<?php echo value('announcement-title','title',''); ?>">
            </div>
            <div class="field">
              <label for="announcement-date">Publish date</label>
              <input id="announcement-date" name="announcement-date" type="date" form="backend-form" value="<?php echo value('announcement-date','publish_date',''); ?>">
            </div>
            <div class="field field-full">
              <label for="announcement-message">Message</label>
              <textarea id="announcement-message" name="announcement-message" rows="4" form="backend-form"><?php echo value('announcement-message','message'); ?></textarea>
            </div>
            <div class="field field-full">
              <label for="announcement-audience">Audience</label>
              <select id="announcement-audience" name="announcement-audience" form="backend-form">
                <option value="My faculty" <?php echo selected('announcement-audience','audience','My faculty','All users') ? 'selected' : ''; ?>>My faculty</option></select>
            </div>
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit" form="backend-form">Publish</button>
            <a class="button button--outline" href="../faculty/announcements.php?view=announcements-announcements">Cancel</a>
          </div>
        </section>
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
          <p class="context-line">Faculty Representative</p>
          <p class="page-description">Keep your faculty informed.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../faculty/announcements.php?view=announcements-announcements">Announcements</a>
          <a href="../faculty/announcements.php?view=announcements-create">Create</a>
          <a href="../faculty/announcements.php?view=announcements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>" class="is-active" aria-current="page">Edit</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Edit announcement</h2>
          </div>
          <div class="form-grid">
            <div class="field">
              <label for="announcement-title">Title</label>
              <input id="announcement-title" name="announcement-title" type="text" placeholder="A clear, short headline" form="backend-form" value="<?php echo value('announcement-title','title',''); ?>">
            </div>
            <div class="field">
              <label for="announcement-date">Publish date</label>
              <input id="announcement-date" name="announcement-date" type="date" form="backend-form" value="<?php echo value('announcement-date','publish_date',''); ?>">
            </div>
            <div class="field field-full">
              <label for="announcement-message">Message</label>
              <textarea id="announcement-message" name="announcement-message" rows="4" form="backend-form"><?php echo value('announcement-message','message'); ?></textarea>
            </div>
            <div class="field field-full">
              <label for="announcement-audience">Audience</label>
              <select id="announcement-audience" name="announcement-audience" form="backend-form">
                <option value="My faculty" <?php echo selected('announcement-audience','audience','My faculty','All users') ? 'selected' : ''; ?>>My faculty</option></select>
            </div>
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit" form="backend-form">Publish</button>
            <a class="button button--outline" href="../faculty/announcements.php?view=announcements-announcements">Cancel</a>
          </div>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-announcement" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
}
