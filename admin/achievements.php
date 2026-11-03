<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'achievements-achievements' => 'admin/achievements-achievements.php',
    'achievements-create-upload-badge' => 'admin/achievements-create-upload-badge.php',
    'achievements-create' => 'admin/achievements-create.php',
    'achievements-edit-upload-badge' => 'admin/achievements-edit-upload-badge.php',
    'achievements-edit' => 'admin/achievements-edit.php',
];
$page=screen_page($screens,'achievements-achievements');
$page_role='admin';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'achievements-achievements':
page_start('Achievements','Achievements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Achievements') ?>Achievements</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Recognise the small habits that become lasting change.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/achievements.php?view=achievements-achievements" class="is-active" aria-current="page">Achievements</a>
          <a href="../admin/achievements.php?view=achievements-create">Create</a>
          <a href="../admin/achievements.php?view=achievements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
        </nav>
        <div class="section-header">
          <p class="muted">Recognise the habits that make a difference.</p>
          <a class="button button--primary" href="../admin/achievements.php?view=achievements-create">Create achievement</a>
        </div>
        <div class="grid-3"><?php include __DIR__ . '/../includes/achievements.php'; ?></div>
        <details class="disclosure" id="requirements">
          <summary>Requirements</summary>
          <div class="stack">
            <p>Every achievement is evaluated against all of its configured requirements after evidence has been reviewed.</p>
            <div class="table-wrap">
              <table class="data-table">
                <caption class="visually-hidden">Achievement requirements</caption>
                <thead>
                  <tr>
                    <th scope="col">Achievement</th>
                    <th scope="col">Count</th>
                    <th scope="col">Item or activity</th>
                    <th scope="col">Condition</th>
                  </tr>
                </thead>
                <tbody><?php $kind='achievement-rules'; $columns=['Achievement', 'Count', 'Item or activity', 'Condition']; include __DIR__ . '/../includes/table.php'; ?></tbody>
              </table>
            </div>
            <p class="muted">Badge approval requires a human review.</p>
          </div>
        </details>
      </div>
    </main>
  
<?php page_end(); break;
case 'achievements-create-upload-badge':
redirect('admin/achievements-create.php' . (isset($_GET['id']) ? '?id=' . (int)$_GET['id'] : ''));
break;
case 'achievements-create':
$saved_rules=$id ? rows('SELECT * FROM achievement_rules WHERE achievement_id=? ORDER BY id',[$id]) : [];
page_start('Achievements','Achievements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Achievements') ?>Achievements</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Define a badge and the steps needed to earn it.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/achievements.php?view=achievements-achievements">Achievements</a>
          <a href="../admin/achievements.php?view=achievements-create" class="is-active" aria-current="page">Create</a>
          <a href="../admin/achievements.php?view=achievements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Edit</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Create achievement</h2>
          </div>
          <div class="stack" role="form">
            <div class="form-grid">
              <div class="field">
                <label for="achievement-name">Name</label>
                <input id="achievement-name" name="achievement-name" type="text" placeholder="Name" required form="backend-form" value="<?php echo value('achievement-name','name',''); ?>">
              </div>
              <div class="field">
                <label for="badge-family">Badge family</label>
                <input id="badge-family" name="badge-family" maxlength="80" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" placeholder="For example: bottle-recycler" form="backend-form" value="<?= value('badge-family','family_key') ?>">
                <p class="field-hint">Use the same family for Bronze, Silver and Gold. Leave empty for an independent badge.</p>
              </div>
              <div class="field">
                <label for="badge-tier">Level</label>
                <select id="badge-tier" name="badge-tier" form="backend-form">
                  <?php foreach(['bronze','silver','gold'] as $level): ?>
                  <option value="<?= e($level) ?>" <?= selected('badge-tier','tier',$level,'bronze') ?>><?= e(ucfirst($level)) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label for="achievement-status">Status</label>
                <select id="achievement-status" name="achievement-status" form="backend-form">
                  <option value="choose an option" <?php echo selected('achievement-status','status','choose an option','active') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="draft" <?php echo selected('achievement-status','status','draft','active') ? 'selected' : ''; ?>>Draft</option>
                  <option value="active" <?php echo selected('achievement-status','status','active','active') ? 'selected' : ''; ?>>Active</option>
                  <option value="archived" <?php echo selected('achievement-status','status','archived','active') ? 'selected' : ''; ?>>Archived</option>
                </select>
              </div>
            </div>
            <div class="upload-preview">
              <svg class="achievement-icon" viewbox="0 0 96 96" width="96" height="96" role="img" aria-label="No image selected">
                <rect width="96" height="96" fill="var(--sage)"></rect>
                <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="10.666666666666666">
                  No image selected
                </text>
              </svg>
              <div>
                <strong>No badge selected</strong>
                <p class="muted">Use a simple badge that remains legible at small sizes.</p>
                <a class="button button--outline" href="../admin/achievements.php?view=achievements-create-upload-badge">Upload badge</a>
              </div>
            </div>
          </div>
        </section>
        <section class="panel">
          <div class="panel-heading">
            <h2>Requirements</h2>
          </div>
          <p class="muted">Complete all requirements. Each row combines a count, an item or activity, and a condition.</p>
          <fieldset class="requirement-row">
            <legend>Requirement 1</legend>
            <div class="form-grid">
              <div class="field">
                <label for="requirement-1-count">Count</label>
                <input id="requirement-1-count" name="requirement-1-count" type="number" placeholder="Count" min="1" step="1" form="backend-form" value="<?php echo e($saved_rules[0]['required_count'] ?? ''); ?>">
              </div>
              <div class="field">
                <label for="requirement-1-item">Item or activity</label>
                <select id="requirement-1-item" name="requirement-1-item" form="backend-form">
                  <option value="" <?php echo ($saved_rules[0]['item'] ?? '') === '' ? 'selected' : ''; ?>>Choose an item</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Plastic bottles' ? 'selected' : ''; ?>>Plastic bottles</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Approved activity' ? 'selected' : ''; ?>>Approved activity</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Reusable cup' ? 'selected' : ''; ?>>Reusable cup</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Campus cleanup' ? 'selected' : ''; ?>>Campus cleanup</option>
                </select>
              </div>
              <div class="field">
                <label for="requirement-1-condition">Condition</label>
                <select id="requirement-1-condition" name="requirement-1-condition" form="backend-form">
                  <option value="" <?php echo ($saved_rules[0]['condition_name'] ?? '') === '' ? 'selected' : ''; ?>>Choose a condition</option>
                  <option <?php echo ($saved_rules[0]['condition_name'] ?? '') === 'At least' ? 'selected' : ''; ?>>At least</option>
                  <option <?php echo ($saved_rules[0]['condition_name'] ?? '') === 'Exactly' ? 'selected' : ''; ?>>Exactly</option>
                </select>
              </div>
            </div>
            <label class="check-option">
              <input type="checkbox" name="exclude-1" form="backend-form">
              <span>Exclude this requirement in your draft</span>
            </label>
          </fieldset>
          <fieldset class="requirement-row">
            <legend>Requirement 2</legend>
            <div class="form-grid">
              <div class="field">
                <label for="requirement-2-count">Count</label>
                <input id="requirement-2-count" name="requirement-2-count" type="number" placeholder="Count" min="1" step="1" form="backend-form" value="<?php echo e($saved_rules[1]['required_count'] ?? ''); ?>">
              </div>
              <div class="field">
                <label for="requirement-2-item">Item or activity</label>
                <select id="requirement-2-item" name="requirement-2-item" form="backend-form">
                  <option value="" <?php echo ($saved_rules[1]['item'] ?? '') === '' ? 'selected' : ''; ?>>Choose an item</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Plastic bottles' ? 'selected' : ''; ?>>Plastic bottles</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Approved activity' ? 'selected' : ''; ?>>Approved activity</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Reusable cup' ? 'selected' : ''; ?>>Reusable cup</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Campus cleanup' ? 'selected' : ''; ?>>Campus cleanup</option>
                </select>
              </div>
              <div class="field">
                <label for="requirement-2-condition">Condition</label>
                <select id="requirement-2-condition" name="requirement-2-condition" form="backend-form">
                  <option value="" <?php echo ($saved_rules[1]['condition_name'] ?? '') === '' ? 'selected' : ''; ?>>Choose a condition</option>
                  <option <?php echo ($saved_rules[1]['condition_name'] ?? '') === 'At least' ? 'selected' : ''; ?>>At least</option>
                  <option <?php echo ($saved_rules[1]['condition_name'] ?? '') === 'Exactly' ? 'selected' : ''; ?>>Exactly</option>
                </select>
              </div>
            </div>
            <label class="check-option">
              <input type="checkbox" name="exclude-2" form="backend-form">
              <span>Exclude this requirement in your draft</span>
            </label>
          </fieldset>
          
          <details class="disclosure">
            <summary>Add requirement</summary>
            <div class="stack">
              <fieldset class="requirement-row">
                <legend>Requirement 3</legend>
                <div class="form-grid">
                  <div class="field">
                    <label for="requirement-3-count">Count</label>
                    <input id="requirement-3-count" name="requirement-3-count" type="number" placeholder="Count" min="1" step="1" form="backend-form" value="<?php echo e($saved_rules[2]['required_count'] ?? ''); ?>">
                  </div>
                  <div class="field">
                    <label for="requirement-3-item">Item or activity</label>
                    <select id="requirement-3-item" name="requirement-3-item" form="backend-form">
                      <option value="" <?php echo ($saved_rules[2]['item'] ?? '') === '' ? 'selected' : ''; ?>>Choose an item</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Plastic bottles' ? 'selected' : ''; ?>>Plastic bottles</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Approved activity' ? 'selected' : ''; ?>>Approved activity</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Reusable cup' ? 'selected' : ''; ?>>Reusable cup</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Campus cleanup' ? 'selected' : ''; ?>>Campus cleanup</option>
                    </select>
                  </div>
                  <div class="field">
                    <label for="requirement-3-condition">Condition</label>
                    <select id="requirement-3-condition" name="requirement-3-condition" form="backend-form">
                      <option value="" <?php echo ($saved_rules[2]['condition_name'] ?? '') === '' ? 'selected' : ''; ?>>Choose a condition</option>
                      <option <?php echo ($saved_rules[2]['condition_name'] ?? '') === 'At least' ? 'selected' : ''; ?>>At least</option>
                      <option <?php echo ($saved_rules[2]['condition_name'] ?? '') === 'Exactly' ? 'selected' : ''; ?>>Exactly</option>
                    </select>
                  </div>
                </div>
                <label class="check-option">
                  <input type="checkbox" name="exclude-3" form="backend-form">
                  <span>Exclude this requirement in your draft</span>
                </label>
              </fieldset>
            </div>
          </details>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Save achievement</button>
          <a class="button button--outline" href="../admin/achievements.php?view=achievements-achievements">Cancel</a>
        </div>
        <aside class="notice">
          <div>
            <strong>Achievement requirements</strong>
            <p>Open Add requirement to enter another requirement. Mark a row to exclude it from the draft.</p>
          </div>
        </aside>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-achievement" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'achievements-edit-upload-badge':
redirect('admin/achievements-edit.php' . (isset($_GET['id']) ? '?id=' . (int)$_GET['id'] : ''));
break;
case 'achievements-edit':
$saved_rules=$id ? rows('SELECT * FROM achievement_rules WHERE achievement_id=? ORDER BY id',[$id]) : [];
page_start('Achievements','Achievements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Achievements') ?>Achievements</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Keep achievement requirements clear and meaningful.</p>
        </div>
        <p class="note">No record selected.</p>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/achievements.php?view=achievements-achievements">Achievements</a>
          <a href="../admin/achievements.php?view=achievements-create">Create</a>
          <a href="../admin/achievements.php?view=achievements-edit<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>" class="is-active" aria-current="page">Edit</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Edit achievement</h2>
          </div>
          <div class="stack" role="form">
            <div class="form-grid">
              <div class="field">
                <label for="achievement-name">Name</label>
                <input id="achievement-name" name="achievement-name" type="text" placeholder="Name" required form="backend-form" value="<?php echo value('achievement-name','name',''); ?>">
              </div>
              <div class="field">
                <label for="badge-family">Badge family</label>
                <input id="badge-family" name="badge-family" maxlength="80" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" placeholder="For example: bottle-recycler" form="backend-form" value="<?= value('badge-family','family_key') ?>">
                <p class="field-hint">Use the same family for Bronze, Silver and Gold. Leave empty for an independent badge.</p>
              </div>
              <div class="field">
                <label for="badge-tier">Level</label>
                <select id="badge-tier" name="badge-tier" form="backend-form">
                  <?php foreach(['bronze','silver','gold'] as $level): ?>
                  <option value="<?= e($level) ?>" <?= selected('badge-tier','tier',$level,'bronze') ?>><?= e(ucfirst($level)) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label for="achievement-status">Status</label>
                <select id="achievement-status" name="achievement-status" form="backend-form">
                  <option value="choose an option" <?php echo selected('achievement-status','status','choose an option','active') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="draft" <?php echo selected('achievement-status','status','draft','active') ? 'selected' : ''; ?>>Draft</option>
                  <option value="active" <?php echo selected('achievement-status','status','active','active') ? 'selected' : ''; ?>>Active</option>
                  <option value="archived" <?php echo selected('achievement-status','status','archived','active') ? 'selected' : ''; ?>>Archived</option>
                </select>
              </div>
            </div>
            <div class="upload-preview">
              <svg class="achievement-icon" viewbox="0 0 96 96" width="96" height="96" role="img" aria-label="No image selected">
                <rect width="96" height="96" fill="var(--sage)"></rect>
                <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="currentColor" font-size="10.666666666666666">
                  No image selected
                </text>
              </svg>
              <div>
                <strong>No badge selected</strong>
                <p class="muted">Use a simple badge that remains legible at small sizes.</p>
                <a class="button button--outline" href="../admin/achievements.php?view=achievements-edit-upload-badge">Upload badge</a>
              </div>
            </div>
          </div>
        </section>
        <section class="panel">
          <div class="panel-heading">
            <h2>Requirements</h2>
          </div>
          <p class="muted">Complete all requirements. Each row combines a count, an item or activity, and a condition.</p>
          <fieldset class="requirement-row">
            <legend>Requirement 1</legend>
            <div class="form-grid">
              <div class="field">
                <label for="requirement-1-count">Count</label>
                <input id="requirement-1-count" name="requirement-1-count" type="number" placeholder="Count" min="1" step="1" form="backend-form" value="<?php echo e($saved_rules[0]['required_count'] ?? ''); ?>">
              </div>
              <div class="field">
                <label for="requirement-1-item">Item or activity</label>
                <select id="requirement-1-item" name="requirement-1-item" form="backend-form">
                  <option value="" <?php echo ($saved_rules[0]['item'] ?? '') === '' ? 'selected' : ''; ?>>Choose an item</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Plastic bottles' ? 'selected' : ''; ?>>Plastic bottles</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Approved activity' ? 'selected' : ''; ?>>Approved activity</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Reusable cup' ? 'selected' : ''; ?>>Reusable cup</option>
                  <option <?php echo ($saved_rules[0]['item'] ?? '') === 'Campus cleanup' ? 'selected' : ''; ?>>Campus cleanup</option>
                </select>
              </div>
              <div class="field">
                <label for="requirement-1-condition">Condition</label>
                <select id="requirement-1-condition" name="requirement-1-condition" form="backend-form">
                  <option value="" <?php echo ($saved_rules[0]['condition_name'] ?? '') === '' ? 'selected' : ''; ?>>Choose a condition</option>
                  <option <?php echo ($saved_rules[0]['condition_name'] ?? '') === 'At least' ? 'selected' : ''; ?>>At least</option>
                  <option <?php echo ($saved_rules[0]['condition_name'] ?? '') === 'Exactly' ? 'selected' : ''; ?>>Exactly</option>
                </select>
              </div>
            </div>
            <label class="check-option">
              <input type="checkbox" name="exclude-1" form="backend-form">
              <span>Exclude this requirement in your draft</span>
            </label>
          </fieldset>
          <fieldset class="requirement-row">
            <legend>Requirement 2</legend>
            <div class="form-grid">
              <div class="field">
                <label for="requirement-2-count">Count</label>
                <input id="requirement-2-count" name="requirement-2-count" type="number" placeholder="Count" min="1" step="1" form="backend-form" value="<?php echo e($saved_rules[1]['required_count'] ?? ''); ?>">
              </div>
              <div class="field">
                <label for="requirement-2-item">Item or activity</label>
                <select id="requirement-2-item" name="requirement-2-item" form="backend-form">
                  <option value="" <?php echo ($saved_rules[1]['item'] ?? '') === '' ? 'selected' : ''; ?>>Choose an item</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Plastic bottles' ? 'selected' : ''; ?>>Plastic bottles</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Approved activity' ? 'selected' : ''; ?>>Approved activity</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Reusable cup' ? 'selected' : ''; ?>>Reusable cup</option>
                  <option <?php echo ($saved_rules[1]['item'] ?? '') === 'Campus cleanup' ? 'selected' : ''; ?>>Campus cleanup</option>
                </select>
              </div>
              <div class="field">
                <label for="requirement-2-condition">Condition</label>
                <select id="requirement-2-condition" name="requirement-2-condition" form="backend-form">
                  <option value="" <?php echo ($saved_rules[1]['condition_name'] ?? '') === '' ? 'selected' : ''; ?>>Choose a condition</option>
                  <option <?php echo ($saved_rules[1]['condition_name'] ?? '') === 'At least' ? 'selected' : ''; ?>>At least</option>
                  <option <?php echo ($saved_rules[1]['condition_name'] ?? '') === 'Exactly' ? 'selected' : ''; ?>>Exactly</option>
                </select>
              </div>
            </div>
            <label class="check-option">
              <input type="checkbox" name="exclude-2" form="backend-form">
              <span>Exclude this requirement in your draft</span>
            </label>
          </fieldset>
          
          <details class="disclosure">
            <summary>Add requirement</summary>
            <div class="stack">
              <fieldset class="requirement-row">
                <legend>Requirement 3</legend>
                <div class="form-grid">
                  <div class="field">
                    <label for="requirement-3-count">Count</label>
                    <input id="requirement-3-count" name="requirement-3-count" type="number" placeholder="Count" min="1" step="1" form="backend-form" value="<?php echo e($saved_rules[2]['required_count'] ?? ''); ?>">
                  </div>
                  <div class="field">
                    <label for="requirement-3-item">Item or activity</label>
                    <select id="requirement-3-item" name="requirement-3-item" form="backend-form">
                      <option value="" <?php echo ($saved_rules[2]['item'] ?? '') === '' ? 'selected' : ''; ?>>Choose an item</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Plastic bottles' ? 'selected' : ''; ?>>Plastic bottles</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Approved activity' ? 'selected' : ''; ?>>Approved activity</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Reusable cup' ? 'selected' : ''; ?>>Reusable cup</option>
                      <option <?php echo ($saved_rules[2]['item'] ?? '') === 'Campus cleanup' ? 'selected' : ''; ?>>Campus cleanup</option>
                    </select>
                  </div>
                  <div class="field">
                    <label for="requirement-3-condition">Condition</label>
                    <select id="requirement-3-condition" name="requirement-3-condition" form="backend-form">
                      <option value="" <?php echo ($saved_rules[2]['condition_name'] ?? '') === '' ? 'selected' : ''; ?>>Choose a condition</option>
                      <option <?php echo ($saved_rules[2]['condition_name'] ?? '') === 'At least' ? 'selected' : ''; ?>>At least</option>
                      <option <?php echo ($saved_rules[2]['condition_name'] ?? '') === 'Exactly' ? 'selected' : ''; ?>>Exactly</option>
                    </select>
                  </div>
                </div>
                <label class="check-option">
                  <input type="checkbox" name="exclude-3" form="backend-form">
                  <span>Exclude this requirement in your draft</span>
                </label>
              </fieldset>
            </div>
          </details>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Save achievement</button>
          <a class="button button--outline" href="../admin/achievements.php?view=achievements-achievements">Cancel</a>
        </div>
        <aside class="notice">
          <div>
            <strong>Achievement requirements</strong>
            <p>Open Add requirement to enter another requirement. Mark a row to exclude it from the draft.</p>
          </div>
        </aside>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-achievement" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
}
