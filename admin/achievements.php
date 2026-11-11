<?php
require_once __DIR__.'/../includes/routes.php';
$screens = [
    'achievements-achievements' => 'admin/achievements-achievements.php',
    'achievements-create-upload-badge' => 'admin/achievements-create-upload-badge.php',
    'achievements-create' => 'admin/achievements-create.php',
    'achievements-edit-upload-badge' => 'admin/achievements-edit-upload-badge.php',
    'achievements-edit' => 'admin/achievements-edit.php',
];
$page = screen_page($screens, 'achievements-achievements');
$page_role = 'admin';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/layout.php';

if ($view === 'achievements-create-upload-badge') {
    redirect('admin/achievements.php?view=achievements-create#badge-image');
}
if ($view === 'achievements-edit-upload-badge') {
    redirect('admin/achievements.php?view=achievements-edit&id=' . $id . '#badge-image');
}

$listing = $view === 'achievements-achievements';
$editing = $view === 'achievements-edit';
$editor_title = $editing ? 'Edit achievement' : 'Create achievement';
page_start('Achievements', 'Achievements', false);
?>
<main id="main-content" class="workspace-content">
  <?php include __DIR__.'/../includes/notices.php'; ?>
  <div class="page-header">
    <div>
      <h1><?= section_icon('Achievements') ?><?= $listing ? 'Achievements' : $editor_title ?></h1>
    </div>
  </div>
  <div class="stack">
    <nav class="page-tabs" aria-label="Section views">
      <a href="?view=achievements-achievements"<?= $listing ? ' class="is-active" aria-current="page"' : '' ?>>Achievements</a>
      <a href="?view=achievements-create"<?= !$listing && !$editing ? ' class="is-active" aria-current="page"' : '' ?>>Create</a>
      <?php if ($editing && $record): ?>
        <a href="?view=achievements-edit&amp;id=<?= (int)$id ?>" class="is-active" aria-current="page">Edit</a>
      <?php endif; ?>
    </nav>
    <?php if ($listing): ?>
      <div class="grid-3"><?php include __DIR__.'/../includes/achievements.php'; ?></div>
      <details class="disclosure" id="requirements">
        <summary>All achievement requirements</summary>
        <div class="stack">
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
              <tbody><?php $kind='achievement-rules'; $columns=['Achievement', 'Count', 'Item or activity', 'Condition']; include __DIR__.'/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </div>
      </details>
    <?php elseif ($editing && !$record): ?>
      <p>Choose an achievement from the list to edit it.</p>
      <p><a class="text-link" href="?view=achievements-achievements">View achievements</a></p>
    <?php else:
      $saved_rules = $editing ? rows('SELECT * FROM achievement_rules WHERE achievement_id=? ORDER BY id', [$id]) : [];
      $challenges = rows('SELECT id, title FROM challenges ORDER BY title, id');
      $measures = array_keys(achievement_measures());
      $form_posted = $_SERVER['REQUEST_METHOD'] === 'POST' && post('action') === 'save-achievement';
      $format = $form_posted ? post('badge-mode') : (($record['family_key'] ?? '') === '' ? 'standalone' : 'tiered');
      $current_image = $editing && $record['image'] ? $base . '/file.php?type=achievement&id=' . $id : '';
    ?>
      <form id="badge-editor" class="stack" method="post" enctype="multipart/form-data" action="?view=<?= e($view) ?><?= $editing ? '&amp;id=' . (int)$id : '' ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save-achievement">
        <input type="hidden" name="id" value="<?= $editing ? (int)$id : 0 ?>">
        <section class="panel stack" aria-labelledby="badge-details-heading">
          <h2 id="badge-details-heading">Badge details</h2>
          <div class="form-grid">
            <div class="field">
              <label for="achievement-name">Name</label>
              <input id="achievement-name" name="achievement-name" type="text" maxlength="120" required value="<?= value('achievement-name', 'name') ?>">
            </div>
            <div class="field">
              <label for="achievement-status">Status</label>
              <select id="achievement-status" name="achievement-status">
                <?php foreach (['draft', 'active', 'archived'] as $status): ?>
                  <option value="<?= $status ?>"<?= selected('achievement-status', 'status', $status, 'active') ?>><?= ucfirst($status) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field field--full">
              <label for="badge-mode">Badge format</label>
              <select id="badge-mode" name="badge-mode" aria-describedby="badge-format-hint">
                <option value="standalone"<?= $format === 'standalone' ? ' selected' : '' ?>>Standalone badge</option>
                <option value="tiered"<?= $format === 'tiered' ? ' selected' : '' ?>>Tier in a badge family</option>
              </select>
              <p class="field-hint" id="badge-format-hint">A standalone badge appears once, without a family or tier.</p>
            </div>
            <div class="field" data-tier-field>
              <label for="badge-family">Badge family</label>
              <input id="badge-family" name="badge-family" maxlength="80" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" placeholder="campus-recycler" value="<?= value('badge-family', 'family_key') ?>">
              <p class="field-hint">Use the same family for its Bronze, Silver and Gold badges.</p>
            </div>
            <div class="field" data-tier-field>
              <label for="badge-tier">Tier</label>
              <select id="badge-tier" name="badge-tier">
                <?php foreach (['bronze', 'silver', 'gold'] as $tier): ?>
                  <option value="<?= $tier ?>"<?= selected('badge-tier', 'tier', $tier, 'bronze') ?>><?= ucfirst($tier) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field field--full">
              <label for="badge-image">Badge image (optional)</label>
              <input id="badge-image" name="image" type="file" accept="image/jpeg,image/png" aria-describedby="badge-image-hint">
              <p class="field-hint" id="badge-image-hint">JPG or PNG up to 5 MB. Width and height must each be 128 to 2048 pixels.</p>
              <div id="badge-image-preview" data-saved-image="<?= e($current_image) ?>"<?= $current_image ? '' : ' hidden' ?>>
                <?php if ($current_image): ?>
                  <img class="upload-thumbnail" src="<?= e($current_image) ?>" alt="Badge preview" width="96" height="96">
                <?php endif; ?>
              </div>
            </div>
          </div>
        </section>
        <section class="panel stack" aria-labelledby="badge-requirements-heading">
          <h2 id="badge-requirements-heading">Requirements</h2>
          <p class="field-hint">All requirements must be met. Only approved evidence counts. Add at least one requirement before setting a badge to Active.</p>
          <div class="stack" id="badge-requirements">
            <?php for ($index = 1; $index <= 3; $index++):
              $saved = $saved_rules[$index - 1] ?? [];
              $field = 'requirement-' . $index . '-';
              $count = $form_posted ? post($field . 'count') : ($saved['required_count'] ?? '');
              $measure = $form_posted ? post($field . 'item') : (!empty($saved['challenge_id']) ? 'specific-challenge' : ($saved['item'] ?? ''));
              $condition = $form_posted ? post($field . 'condition') : ($saved['condition_name'] ?? '');
              $challenge = $form_posted ? post($field . 'challenge') : ($saved['challenge_id'] ?? '');
            ?>
              <fieldset class="requirement-row" data-requirement-row>
                <legend>Requirement <?= $index ?></legend>
                <div class="form-grid">
                  <div class="field">
                    <label for="<?= $field ?>count">Count</label>
                    <input id="<?= $field ?>count" name="<?= $field ?>count" type="number" min="1" max="1000000" step="1" value="<?= e($count) ?>">
                  </div>
                  <div class="field">
                    <label for="<?= $field ?>item">Measure</label>
                    <select id="<?= $field ?>item" name="<?= $field ?>item" data-requirement-measure>
                      <option value="">Choose a measure</option>
                      <?php foreach ($measures as $option): ?>
                        <option value="<?= e($option) ?>"<?= $measure === $option ? ' selected' : '' ?>><?= e($option === 'Approved activity' ? 'Approved submissions' : $option) ?></option>
                      <?php endforeach; ?>
                      <option value="specific-challenge"<?= $measure === 'specific-challenge' ? ' selected' : '' ?>>Approved submissions for one challenge</option>
                    </select>
                  </div>
                  <div class="field">
                    <label for="<?= $field ?>condition">Condition</label>
                    <select id="<?= $field ?>condition" name="<?= $field ?>condition">
                      <option value="">Choose a condition</option>
                      <?php foreach (['At least', 'Exactly'] as $option): ?>
                        <option value="<?= $option ?>"<?= $condition === $option ? ' selected' : '' ?>><?= $option ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="field field--full" data-requirement-challenge>
                    <label for="<?= $field ?>challenge">Challenge</label>
                    <select id="<?= $field ?>challenge" name="<?= $field ?>challenge">
                      <option value="">Choose a challenge</option>
                      <?php foreach ($challenges as $option): ?>
                        <option value="<?= (int)$option['id'] ?>"<?= (string)$challenge === (string)$option['id'] ? ' selected' : '' ?>><?= e($option['title']) ?></option>
                      <?php endforeach; ?>
                    </select>
                    <p class="field-hint">Use with the one-challenge measure.</p>
                  </div>
                </div>
                <div data-remove-requirement hidden>
                  <button class="button button--outline" type="button">Remove requirement</button>
                </div>
              </fieldset>
            <?php endfor; ?>
          </div>
          <div id="badge-add-requirement" hidden>
            <button class="button button--outline" type="button">Add requirement</button>
          </div>
        </section>
        <div class="form-actions">
          <button class="button button--primary" type="submit">Save achievement</button>
          <a class="button button--outline" href="?view=achievements-achievements">Cancel</a>
        </div>
      </form>
      <script src="../scripts/badge-editor.js" defer></script>
    <?php endif; ?>
  </div>
</main>
<?php page_end(); ?>
