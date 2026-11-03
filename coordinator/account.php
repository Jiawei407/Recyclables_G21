<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'profile-change-password' => 'coordinator/profile-change-password.php',
    'profile-manage-account' => 'coordinator/profile-manage-account.php',
];
$page=screen_page($screens,'profile-manage-account');
$page_role='coordinator';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'profile-change-password':
page_start('Your account','Profile',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?php echo e($user['full_name'] ?? 'Your account'); ?></h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">A straightforward place for account and password details.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Account views">
        <a href="../coordinator/account.php?view=profile-manage-account#account-summary">Profile</a>
        <a href="../coordinator/account.php?view=profile-manage-account">Manage account</a>
        <a href="../coordinator/account.php?view=profile-change-password" class="is-active" aria-current="page">Change password</a>
      </nav>
      <div class="panel stack" aria-label="Change password" role="form">
        <h2>Change password</h2>
        <p class="note">Choose a password you do not use elsewhere.</p>
        <div class="form-grid">
          <div class="field">
            <label for="current-password">Current password</label>
            <input id="current-password" name="current-password" type="password" autocomplete="current-password" placeholder="Enter current password" form="backend-form" required>
          </div>
          <div class="field">
            <label for="new-password">New password</label>
            <input title="Use 8-72 characters including a special character, for example @, ! or #." pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="new-password" name="new-password" type="password" autocomplete="new-password" placeholder="Enter new password" minlength="8" maxlength="72" form="backend-form" required>
            <p class="field-hint">Use at least eight characters.</p>
          </div>
          <div class="field">
            <label for="confirm-password">Confirm password</label>
            <input title="Use 8-72 characters including a special character, for example @, ! or #." pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="confirm-password" name="confirm-password" type="password" autocomplete="new-password" placeholder="Re-enter new password" minlength="8" maxlength="72" form="backend-form" required>
          </div>
        </div>
        <div class="form-actions">
          <button class="button button--primary" type="submit" form="backend-form">Save password</button>
          <a class="button button--outline" href="../coordinator/account.php?view=profile-manage-account">Cancel</a>
        </div>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="password" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'profile-manage-account':
page_start('Your account','Profile',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?php echo e($user['full_name'] ?? 'Your account'); ?></h1>
          <p class="context-line">Sustainability Coordinator</p>
          <p class="page-description">Manage your coordinator account details.</p>
        </div>
      </div>
      <nav class="page-tabs" aria-label="Account views">
        <a href="../coordinator/account.php?view=profile-manage-account#account-summary">Profile</a>
        <a href="../coordinator/account.php?view=profile-manage-account" class="is-active" aria-current="page">Manage account</a>
        <a href="../coordinator/account.php?view=profile-change-password">Change password</a>
      </nav>
      <div class="grid-2">
        <div class="panel stack" data-native-validation="" aria-label="Edit coordinator account">
          <h2>Account details</h2>
          <div class="form-grid">
            <div class="field">
              <label for="account-name">Full name</label>
              <input id="account-name" type="text" autocomplete="name" placeholder="Full name" form="backend-form" name="account-name" value="<?php echo value('account-name','full_name',''); ?>">
            </div>
            <div class="field">
              <label for="account-email">Email</label>
              <input id="account-email" type="email" autocomplete="email" required maxlength="254" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" aria-describedby="account-email-error" placeholder="name@example.com" form="backend-form" name="account-email" value="<?php echo value('account-email','email',''); ?>">
              <p class="field-error" id="account-email-error">Enter a valid email address, for example name@example.com.</p>
            </div>
            <div class="field">
              <label for="account-faculty">Faculty</label>
              <select id="account-faculty" form="backend-form" name="account-faculty">
                <option value="" <?php echo selected('account-faculty','faculty','','') ? 'selected' : ''; ?>>Choose an option</option>
                <option value="School of Computing" <?php echo selected('account-faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                <option value="School of Engineering" <?php echo selected('account-faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                <option value="School of Business" <?php echo selected('account-faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                <option value="School of Media" <?php echo selected('account-faculty','faculty','School of Media','') ? 'selected' : ''; ?>>School of Media</option>
              </select>
            </div>
            <div class="field">
              <label for="account-id">University ID</label>
              <input id="account-id" type="text" placeholder="University ID" form="backend-form" name="account-id" value="<?php echo value('account-id','university_id',''); ?>">
            </div>
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit" form="backend-form">Save changes</button>
            <a class="button button--outline" href="../coordinator/home.php?view=overview">Cancel</a>
          </div>
        </div>
        <section id="account-summary" class="panel panel--forest stack" aria-labelledby="account-context-title">
          <h2 id="account-context-title">Keep the program<br>moving thoughtfully.</h2>
          <p class="context-line">Coordinator profile</p>
          <dl class="detail-list">
            <div>
              <dt>Name</dt>
              <dd><?php echo e($record['full_name'] ?? 'Not selected'); ?></dd>
            </div>
            <div>
              <dt>Role</dt>
              <dd>—</dd>
            </div>
            <div>
              <dt>Account status</dt>
              <dd><?php echo e($record['status'] ?? 'Not selected'); ?></dd>
            </div>
          </dl>
          <p>Review evidence, plan campaigns and help participants understand what good progress looks like.</p>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="profile" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
}
