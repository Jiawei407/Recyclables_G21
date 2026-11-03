<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'users-create-user' => 'admin/users-create-user.php',
    'users-delete-user' => 'admin/users-delete-user.php',
    'users-edit-user' => 'admin/users-edit-user.php',
    'users-suspend-user' => 'admin/users-suspend-user.php',
    'users-users' => 'admin/users-users.php',
];
$page=screen_page($screens,'users-users');
$page_role='admin';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'users-create-user':
page_start('Users','Users',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Users') ?>Users</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Give a new member a clear place on the platform.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/users.php?view=users-users">Users</a>
          <a href="../admin/users.php?view=users-create-user" class="is-active" aria-current="page">Create user</a>
          <a href="../admin/users.php?view=users-edit-user">Edit user</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Create a user</h2>
            <p class="muted">Review the account details before selecting permissions.</p>
          </div>
          <div class="stack" data-native-validation="" aria-label="Create user account">
            <div class="form-grid">
              <div class="field">
                <label for="full-name">Full name</label>
                <input id="full-name" type="text" placeholder="Full name" required form="backend-form" name="full-name" value="<?php echo value('full-name','full_name',''); ?>">
              </div>
              <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" placeholder="name@example.com" required maxlength="254" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" autocomplete="email" aria-describedby="email-error" form="backend-form" name="email" value="<?php echo value('email','email',''); ?>">
                <p class="field-error" id="email-error">Enter a valid email address, for example name@example.com.</p>
              </div>
              <div class="field">
                <label for="university-id">University ID</label>
                <input id="university-id" type="text" placeholder="University ID" required form="backend-form" name="university-id" value="<?php echo value('university-id','university_id',''); ?>">
              </div>
              <div class="field">
                <label for="faculty">Faculty</label>
                <select id="faculty" form="backend-form" name="faculty">
                  <option value="" <?php echo selected('faculty','faculty','','') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="School of Computing" <?php echo selected('faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                  <option value="School of Engineering" <?php echo selected('faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                  <option value="School of Business" <?php echo selected('faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                  <option value="Campus Sustainability" <?php echo selected('faculty','faculty','Campus Sustainability','') ? 'selected' : ''; ?>>Campus Sustainability</option>
                <option value="School of Media" <?= selected('faculty','faculty','School of Media') ?>>School of Media</option>
</select>
              </div>
              <div class="field">
                <label for="designated-role">Designated role</label>
                <select id="designated-role" form="backend-form" name="designated-role">
                  <option value="" <?php echo selected('designated-role','role','','') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="user" <?php echo selected('designated-role','role','user','') ? 'selected' : ''; ?>>Registered User</option>
                  <option value="faculty" <?php echo selected('designated-role','role','faculty','') ? 'selected' : ''; ?>>Faculty Representative</option>
                  <option value="coordinator" <?php echo selected('designated-role','role','coordinator','') ? 'selected' : ''; ?>>Sustainability Coordinator</option>
                  <option value="admin" <?php echo selected('designated-role','role','admin','') ? 'selected' : ''; ?>>Administrator</option>
                </select>
              </div>
              <div class="field">
                <label for="account-status">Account status</label>
                <select id="account-status" form="backend-form" name="account-status">
                  <option value="" <?php echo selected('account-status','status','','active') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="active" <?php echo selected('account-status','status','active','active') ? 'selected' : ''; ?>>Active</option>
                  <option value="suspended" <?php echo selected('account-status','status','suspended','active') ? 'selected' : ''; ?>>Suspended</option>
                  <option value="inactive" <?php echo selected('account-status','status','inactive','active') ? 'selected' : ''; ?>>Inactive</option>
                </select>
              </div>
              <div class="field">
                <label for="new-password">Set password</label>
                <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="new-password" type="password" autocomplete="new-password" form="backend-form" name="new-password" required="">
                <small class="field-help">Enter the account details.</small>
              </div>
              <div class="field">
                <label for="confirm-password">Confirm password</label>
                <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="confirm-password" type="password" autocomplete="new-password" form="backend-form" name="confirm-password" required="">
              </div>
            </div>
            <fieldset class="check-group">
              <legend>Permissions</legend>
              <label class="check-option">
                <input type="checkbox" form="backend-form" name="can-join" value="1" <?= permission_checked('can-join','can_join') ?>>
                <span>Join challenges</span>
              </label>
              <label class="check-option">
                <input type="checkbox" form="backend-form" name="can-submit" value="1" <?= permission_checked('can-submit','can_submit') ?>>
                <span>Submit evidence</span>
              </label>
              </fieldset>
            <div class="form-actions">
              <button class="button button--primary" type="submit" form="backend-form">Create user</button>
              <a class="button button--outline" href="../admin/users.php?view=users-users">Cancel</a>
            </div>
          </div>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-user" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'users-delete-user':
page_start('Users','Users',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Users') ?>Users</h1>
            <p class="context-line">Administrator</p>
            <p class="page-description">Review the selected account’s details, role, and permissions.</p>
          </div>
          <p class="note">No record selected.</p>
        </div>
        <div class="stack">
          <nav class="page-tabs" aria-label="Section views">
            <a href="../admin/users.php?view=users-users">Users</a>
            <a href="../admin/users.php?view=users-create-user">Create user</a>
            <a href="../admin/users.php?view=users-edit-user" class="is-active" aria-current="page">Edit user</a>
          </nav>
          <section class="panel">
            <div class="panel-heading">
              <h2>Edit user</h2>
              <p class="muted">Review the account details before selecting permissions.</p>
            </div>
            <div class="stack" data-native-validation="" aria-label="Edit user account">
              <div class="form-grid">
                <div class="field">
                  <label for="full-name">Full name</label>
                  <input id="full-name" type="text" placeholder="Full name" required form="backend-form" name="full-name" value="<?php echo value('full-name','full_name',''); ?>">
                </div>
                <div class="field">
                  <label for="email">Email</label>
                  <input id="email" type="email" placeholder="name@example.com" required maxlength="254" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" autocomplete="email" aria-describedby="email-error" form="backend-form" name="email" value="<?php echo value('email','email',''); ?>">
                  <p class="field-error" id="email-error">Enter a valid email address, for example name@example.com.</p>
                </div>
                <div class="field">
                  <label for="university-id">University ID</label>
                  <input id="university-id" type="text" placeholder="University ID" required form="backend-form" name="university-id" value="<?php echo value('university-id','university_id',''); ?>">
                </div>
                <div class="field">
                  <label for="faculty">Faculty</label>
                  <select id="faculty" form="backend-form" name="faculty">
                    <option value="" <?php echo selected('faculty','faculty','','') ? 'selected' : ''; ?>>Choose an option</option>
                    <option value="School of Computing" <?php echo selected('faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                    <option value="School of Engineering" <?php echo selected('faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                    <option value="School of Business" <?php echo selected('faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                    <option value="Campus Sustainability" <?php echo selected('faculty','faculty','Campus Sustainability','') ? 'selected' : ''; ?>>Campus Sustainability</option>
                  <option value="School of Media" <?= selected('faculty','faculty','School of Media') ?>>School of Media</option>
</select>
                </div>
                <div class="field">
                  <label for="designated-role">Designated role</label>
                  <select id="designated-role" form="backend-form" name="designated-role">
                    <option value="" <?php echo selected('designated-role','role','','') ? 'selected' : ''; ?>>Choose an option</option>
                    <option value="user" <?php echo selected('designated-role','role','user','') ? 'selected' : ''; ?>>Registered User</option>
                    <option value="faculty" <?php echo selected('designated-role','role','faculty','') ? 'selected' : ''; ?>>Faculty Representative</option>
                    <option value="coordinator" <?php echo selected('designated-role','role','coordinator','') ? 'selected' : ''; ?>>Sustainability Coordinator</option>
                    <option value="admin" <?php echo selected('designated-role','role','admin','') ? 'selected' : ''; ?>>Administrator</option>
                  </select>
                </div>
                <div class="field">
                  <label for="account-status">Account status</label>
                  <select id="account-status" form="backend-form" name="account-status">
                    <option value="" <?php echo selected('account-status','status','','active') ? 'selected' : ''; ?>>Choose an option</option>
                    <option value="active" <?php echo selected('account-status','status','active','active') ? 'selected' : ''; ?>>Active</option>
                    <option value="suspended" <?php echo selected('account-status','status','suspended','active') ? 'selected' : ''; ?>>Suspended</option>
                    <option value="inactive" <?php echo selected('account-status','status','inactive','active') ? 'selected' : ''; ?>>Inactive</option>
                  </select>
                </div>
                <div class="field">
                  <label for="new-password">New password (optional)</label>
                  <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="new-password" type="password" autocomplete="new-password" form="backend-form" name="new-password">
                  <small class="field-help">Enter the account details.</small>
                </div>
                <div class="field">
                  <label for="confirm-password">Confirm password</label>
                  <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="confirm-password" type="password" autocomplete="new-password" form="backend-form" name="confirm-password">
                </div>
              </div>
              <fieldset class="check-group">
                <legend>Permissions</legend>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Join challenges</span>
                </label>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Submit evidence</span>
                </label>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Manage faculty</span>
                </label>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Review submissions</span>
                </label>
              </fieldset>
              <div class="form-actions">
                <button class="button button--primary" type="submit" form="backend-form">Save user</button>
                <a class="button button--outline" href="../admin/users.php?view=users-users">Cancel</a>
              </div>
            </div>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Account controls</h2>
            </div>
            <p class="muted">Select an account before confirming a suspension or deletion.</p>
            <div class="form-actions">
              <a class="button button--outline" href="../admin/users.php?view=users-suspend-user<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Suspend user</a>
              <a class="button button--danger" href="../admin/users.php?view=users-delete-user<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Delete user</a>
            </div>
          </section>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Delete user</h2>
            <p class="context-line">Administrator</p>
          </div>
          <a class="close-button" href="../admin/users.php?view=users-edit-user" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="stack">
            <aside class="notice notice--danger">
              <div>
                <strong>No account selected</strong>
                <p>Select an account to review access and associated records before deletion.</p>
              </div>
            </aside>
            <dl class="detail-list">
              <div>
                <dt>Account</dt>
                <dd>—</dd>
              </div>
              <div>
                <dt>Faculty</dt>
                <dd><?php echo e($record['faculty'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Current status</dt>
                <dd>—</dd>
              </div>
            </dl>
            <div class="form-actions">
              <button class="button button--danger" type="submit" form="backend-form">Delete user</button>
              <a class="button button--outline" href="../admin/users.php?view=users-edit-user">Keep this user</a>
            </div>
          </div>
        </div>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden="" data-confirm="Confirm this change?"><?php echo csrf_field(); ?><input type="hidden" name="action" value="delete-user" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
case 'users-edit-user':
page_start('Users','Users',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Users') ?>Users</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Review the selected account’s details, role, and permissions.</p>
        </div>
        <p class="note">No record selected.</p>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/users.php?view=users-users">Users</a>
          <a href="../admin/users.php?view=users-create-user">Create user</a>
          <a href="../admin/users.php?view=users-edit-user" class="is-active" aria-current="page">Edit user</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Edit user</h2>
            <p class="muted">Review the account details before selecting permissions.</p>
          </div>
          <div class="stack" data-native-validation="" aria-label="Edit user account">
            <div class="form-grid">
              <div class="field">
                <label for="full-name">Full name</label>
                <input id="full-name" type="text" placeholder="Full name" required form="backend-form" name="full-name" value="<?php echo value('full-name','full_name',''); ?>">
              </div>
              <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" placeholder="name@example.com" required maxlength="254" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" autocomplete="email" aria-describedby="email-error" form="backend-form" name="email" value="<?php echo value('email','email',''); ?>">
                <p class="field-error" id="email-error">Enter a valid email address, for example name@example.com.</p>
              </div>
              <div class="field">
                <label for="university-id">University ID</label>
                <input id="university-id" type="text" placeholder="University ID" required form="backend-form" name="university-id" value="<?php echo value('university-id','university_id',''); ?>">
              </div>
              <div class="field">
                <label for="faculty">Faculty</label>
                <select id="faculty" form="backend-form" name="faculty">
                  <option value="" <?php echo selected('faculty','faculty','','') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="School of Computing" <?php echo selected('faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                  <option value="School of Engineering" <?php echo selected('faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                  <option value="School of Business" <?php echo selected('faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                  <option value="Campus Sustainability" <?php echo selected('faculty','faculty','Campus Sustainability','') ? 'selected' : ''; ?>>Campus Sustainability</option>
                <option value="School of Media" <?= selected('faculty','faculty','School of Media') ?>>School of Media</option>
</select>
              </div>
              <div class="field">
                <label for="designated-role">Designated role</label>
                <select id="designated-role" form="backend-form" name="designated-role">
                  <option value="" <?php echo selected('designated-role','role','','') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="user" <?php echo selected('designated-role','role','user','') ? 'selected' : ''; ?>>Registered User</option>
                  <option value="faculty" <?php echo selected('designated-role','role','faculty','') ? 'selected' : ''; ?>>Faculty Representative</option>
                  <option value="coordinator" <?php echo selected('designated-role','role','coordinator','') ? 'selected' : ''; ?>>Sustainability Coordinator</option>
                  <option value="admin" <?php echo selected('designated-role','role','admin','') ? 'selected' : ''; ?>>Administrator</option>
                </select>
              </div>
              <div class="field">
                <label for="account-status">Account status</label>
                <select id="account-status" form="backend-form" name="account-status">
                  <option value="" <?php echo selected('account-status','status','','active') ? 'selected' : ''; ?>>Choose an option</option>
                  <option value="active" <?php echo selected('account-status','status','active','active') ? 'selected' : ''; ?>>Active</option>
                  <option value="suspended" <?php echo selected('account-status','status','suspended','active') ? 'selected' : ''; ?>>Suspended</option>
                  <option value="inactive" <?php echo selected('account-status','status','inactive','active') ? 'selected' : ''; ?>>Inactive</option>
                </select>
              </div>
              <div class="field">
                <label for="new-password">New password (optional)</label>
                <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="new-password" type="password" autocomplete="new-password" form="backend-form" name="new-password">
                <small class="field-help">Enter the account details.</small>
              </div>
              <div class="field">
                <label for="confirm-password">Confirm password</label>
                <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="confirm-password" type="password" autocomplete="new-password" form="backend-form" name="confirm-password">
              </div>
            </div>
            <fieldset class="check-group">
              <legend>Permissions</legend>
              <label class="check-option">
                <input type="checkbox" form="backend-form" name="can-join" value="1" <?= permission_checked('can-join','can_join') ?>>
                <span>Join challenges</span>
              </label>
              <label class="check-option">
                <input type="checkbox" form="backend-form" name="can-submit" value="1" <?= permission_checked('can-submit','can_submit') ?>>
                <span>Submit evidence</span>
              </label>
              </fieldset>
            <div class="form-actions">
              <button class="button button--primary" type="submit" form="backend-form">Save user</button>
              <a class="button button--outline" href="../admin/users.php?view=users-users">Cancel</a>
            </div>
          </div>
        </section>
        <section class="panel">
          <div class="panel-heading">
            <h2>Account controls</h2>
          </div>
          <p class="muted">Select an account before confirming a suspension or deletion.</p>
          <div class="form-actions">
            <a class="button button--outline" href="../admin/users.php?view=users-suspend-user<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Suspend user</a>
            <a class="button button--danger" href="../admin/users.php?view=users-delete-user<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Delete user</a>
          </div>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="save-user" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'users-suspend-user':
page_start('Users','Users',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Users') ?>Users</h1>
            <p class="context-line">Administrator</p>
            <p class="page-description">Review the selected account’s details, role, and permissions.</p>
          </div>
          <p class="note">No record selected.</p>
        </div>
        <div class="stack">
          <nav class="page-tabs" aria-label="Section views">
            <a href="../admin/users.php?view=users-users">Users</a>
            <a href="../admin/users.php?view=users-create-user">Create user</a>
            <a href="../admin/users.php?view=users-edit-user" class="is-active" aria-current="page">Edit user</a>
          </nav>
          <section class="panel">
            <div class="panel-heading">
              <h2>Edit user</h2>
              <p class="muted">Review the account details before selecting permissions.</p>
            </div>
            <div class="stack" data-native-validation="" aria-label="Edit user account">
              <div class="form-grid">
                <div class="field">
                  <label for="full-name">Full name</label>
                  <input id="full-name" type="text" placeholder="Full name" required form="backend-form" name="full-name" value="<?php echo value('full-name','full_name',''); ?>">
                </div>
                <div class="field">
                  <label for="email">Email</label>
                  <input id="email" type="email" placeholder="name@example.com" required maxlength="254" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" autocomplete="email" aria-describedby="email-error" form="backend-form" name="email" value="<?php echo value('email','email',''); ?>">
                  <p class="field-error" id="email-error">Enter a valid email address, for example name@example.com.</p>
                </div>
                <div class="field">
                  <label for="university-id">University ID</label>
                  <input id="university-id" type="text" placeholder="University ID" required form="backend-form" name="university-id" value="<?php echo value('university-id','university_id',''); ?>">
                </div>
                <div class="field">
                  <label for="faculty">Faculty</label>
                  <select id="faculty" form="backend-form" name="faculty">
                    <option value="" <?php echo selected('faculty','faculty','','') ? 'selected' : ''; ?>>Choose an option</option>
                    <option value="School of Computing" <?php echo selected('faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                    <option value="School of Engineering" <?php echo selected('faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                    <option value="School of Business" <?php echo selected('faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                    <option value="Campus Sustainability" <?php echo selected('faculty','faculty','Campus Sustainability','') ? 'selected' : ''; ?>>Campus Sustainability</option>
                  <option value="School of Media" <?= selected('faculty','faculty','School of Media') ?>>School of Media</option>
</select>
                </div>
                <div class="field">
                  <label for="designated-role">Designated role</label>
                  <select id="designated-role" form="backend-form" name="designated-role">
                    <option value="" <?php echo selected('designated-role','role','','') ? 'selected' : ''; ?>>Choose an option</option>
                    <option value="user" <?php echo selected('designated-role','role','user','') ? 'selected' : ''; ?>>Registered User</option>
                    <option value="faculty" <?php echo selected('designated-role','role','faculty','') ? 'selected' : ''; ?>>Faculty Representative</option>
                    <option value="coordinator" <?php echo selected('designated-role','role','coordinator','') ? 'selected' : ''; ?>>Sustainability Coordinator</option>
                    <option value="admin" <?php echo selected('designated-role','role','admin','') ? 'selected' : ''; ?>>Administrator</option>
                  </select>
                </div>
                <div class="field">
                  <label for="account-status">Account status</label>
                  <select id="account-status" form="backend-form" name="account-status">
                    <option value="" <?php echo selected('account-status','status','','active') ? 'selected' : ''; ?>>Choose an option</option>
                    <option value="active" <?php echo selected('account-status','status','active','active') ? 'selected' : ''; ?>>Active</option>
                    <option value="suspended" <?php echo selected('account-status','status','suspended','active') ? 'selected' : ''; ?>>Suspended</option>
                    <option value="inactive" <?php echo selected('account-status','status','inactive','active') ? 'selected' : ''; ?>>Inactive</option>
                  </select>
                </div>
                <div class="field">
                  <label for="new-password">New password (optional)</label>
                  <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="new-password" type="password" autocomplete="new-password" form="backend-form" name="new-password">
                  <small class="field-help">Enter the account details.</small>
                </div>
                <div class="field">
                  <label for="confirm-password">Confirm password</label>
                  <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="confirm-password" type="password" autocomplete="new-password" form="backend-form" name="confirm-password">
                </div>
              </div>
              <fieldset class="check-group">
                <legend>Permissions</legend>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Join challenges</span>
                </label>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Submit evidence</span>
                </label>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Manage faculty</span>
                </label>
                <label class="check-option">
                  <input type="checkbox" form="backend-form">
                  <span>Review submissions</span>
                </label>
              </fieldset>
              <div class="form-actions">
                <button class="button button--primary" type="submit" form="backend-form">Save user</button>
                <a class="button button--outline" href="../admin/users.php?view=users-users">Cancel</a>
              </div>
            </div>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Account controls</h2>
            </div>
            <p class="muted">Select an account before confirming a suspension or deletion.</p>
            <div class="form-actions">
              <a class="button button--outline" href="../admin/users.php?view=users-suspend-user<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Suspend user</a>
              <a class="button button--danger" href="../admin/users.php?view=users-delete-user<?php echo $id ? '&amp;id=' . (int)$id : ''; ?>">Delete user</a>
            </div>
          </section>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Suspend user</h2>
            <p class="context-line">Administrator</p>
          </div>
          <a class="close-button" href="../admin/users.php?view=users-edit-user" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="stack">
            <aside class="notice notice--warning">
              <div>
                <strong>No account selected</strong>
                <p>A suspension would pause access while preserving the account and its review history.</p>
              </div>
            </aside>
            <dl class="detail-list">
              <div>
                <dt>Account</dt>
                <dd>—</dd>
              </div>
              <div>
                <dt>Email</dt>
                <dd><?php echo e($record['email'] ?? 'Not selected'); ?></dd>
              </div>
              <div>
                <dt>Current status</dt>
                <dd>—</dd>
              </div>
            </dl>
            <div class="form-actions">
              <button class="button button--primary" type="submit" form="backend-form">Suspend user</button>
              <a class="button button--outline" href="../admin/users.php?view=users-edit-user">Keep active</a>
            </div>
          </div>
        </div>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden="" data-confirm="Confirm this change?"><?php echo csrf_field(); ?><input type="hidden" name="action" value="suspend-user" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
case 'users-users':
page_start('Users','Users',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Users') ?>Users</h1>
          <p class="context-line">Administrator</p>
          <p class="page-description">Manage people and their roles with care.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../admin/users.php?view=users-users" class="is-active" aria-current="page">Users</a>
          <a href="../admin/users.php?view=users-create-user">Create user</a>
          <a href="../admin/users.php?view=users-edit-user">Edit user</a>
        </nav>
        <div class="toolbar" role="search">
          <div class="field">
            <label for="search-users">Search users</label>
            <input id="search-users" name="search-users" type="search" placeholder="Search users">
          </div>
          <div class="field">
            <label for="filter-role">Role</label>
            <select id="filter-role" name="filter-role">
              <option selected>All roles</option>
              <option>Registered User</option>
              <option>Faculty Representative</option>
              <option>Sustainability Coordinator</option>
              <option>Administrator</option>
            </select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>People on the platform</h2>
            <p class="muted">A role defines the areas each person can access.</p>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">user accounts</caption>
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Role</th>
                  <th scope="col">Faculty</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody><?php $kind='users'; $columns=['Name', 'Role', 'Faculty', 'Status', 'Action']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
}
