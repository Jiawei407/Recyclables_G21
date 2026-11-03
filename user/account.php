<?php
require_once __DIR__.'/../includes/routes.php';
$screens=[
    'achievements-earned' => 'user/achievements-earned.php',
    'achievements-locked' => 'user/achievements-locked.php',
    'achievements-recycling-helper' => 'user/achievements-recycling-helper.php',
    'leaderboard-faculty-ranking' => 'user/leaderboard-faculty-ranking.php',
    'leaderboard-individual-ranking' => 'user/leaderboard-individual-ranking.php',
    'profile-change-password-validation' => 'user/profile-change-password-validation.php',
    'profile-change-password' => 'user/profile-change-password.php',
    'profile-edit-details' => 'user/profile-edit-details.php',
    'profile-profile' => 'user/profile-profile.php',
];
$page=screen_page($screens,'profile-profile');
$page_role='user';
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/data.php';
require __DIR__.'/../includes/metrics.php';
require __DIR__.'/../includes/layout.php';
switch($view) {
case 'achievements-earned':
page_start('Achievements','Achievements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Achievements') ?>Achievements</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Small steps worth recognising.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/account.php?view=achievements-earned" class="is-active" aria-current="page">Earned</a>
          <a href="../user/account.php?view=achievements-locked">Locked</a>
        </nav>
        <div class="metric-grid">
          <article class="metric">
            <div class="metric-label">
              Earned badges
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Earned badges')); ?></p>
          </article>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Earned badges</h2>
          </div>
          <div class="badge-grid"><?php include __DIR__ . '/../includes/achievements.php'; ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'achievements-locked':
page_start('Achievements','Achievements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Achievements') ?>Achievements</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Small steps worth recognising.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/account.php?view=achievements-earned">Earned</a>
          <a href="../user/account.php?view=achievements-locked" class="is-active" aria-current="page">Locked</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Your next milestones</h2>
          </div>
          <div class="badge-grid"><?php include __DIR__ . '/../includes/achievements.php'; ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'achievements-recycling-helper':
page_start('Achievements','Achievements',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Achievements') ?>Achievements</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Small steps worth recognising.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/account.php?view=achievements-earned" class="is-active" aria-current="page">Earned</a>
          <a href="../user/account.php?view=achievements-locked">Locked</a>
        </nav>
        <div class="metric-grid">
          <article class="metric">
            <div class="metric-label">
              Earned badges
              <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
                <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
                <path d="m4 21 11-11"></path>
              </svg>
            </div>
            <p class="metric-value"><?php echo e(metric('Earned badges')); ?></p>
          </article>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Earned badges</h2>
          </div>
          <div class="badge-grid"><?php include __DIR__ . '/../includes/achievements.php'; ?></div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
case 'leaderboard-faculty-ranking':
page_start('Leaderboard','Leaderboard',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Leaderboard') ?>Leaderboard</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Progress is better when we share it.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/account.php?view=leaderboard-individual-ranking">Individual ranking</a>
          <a href="../user/account.php?view=leaderboard-faculty-ranking" class="is-active" aria-current="page">Faculty ranking</a>
        </nav>
        <div class="toolbar">
          <div class="field">
            <label for="ranking-search">Search rankings</label>
            <input id="ranking-search" name="ranking-search" type="search" placeholder="Search rankings">
          </div>
          <div class="field">
            <label for="ranking-search-filter">Period</label>
            <select id="ranking-search-filter" name="ranking-search-filter">
              <option value="">All time</option></select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Faculty ranking</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Faculty Green Points ranking</caption>
              <thead>
                <tr>
                  <th scope="col">Rank</th>
                  <th scope="col">Faculty</th>
                  <th scope="col">Green Points</th>
                </tr>
              </thead>
              <tbody><?php $kind='faculty-rankings'; $columns=['Rank', 'Faculty', 'Green Points']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
        <p class="note">Approved actions count toward the rankings.</p>
      </div>
    </main>
  
<?php page_end(); break;
case 'leaderboard-individual-ranking':
page_start('Leaderboard','Leaderboard',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Leaderboard') ?>Leaderboard</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Progress is better when we share it.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/account.php?view=leaderboard-individual-ranking" class="is-active" aria-current="page">Individual ranking</a>
          <a href="../user/account.php?view=leaderboard-faculty-ranking">Faculty ranking</a>
        </nav>
        <div class="toolbar">
          <div class="field">
            <label for="ranking-search">Search rankings</label>
            <input id="ranking-search" name="ranking-search" type="search" placeholder="Search rankings">
          </div>
          <div class="field">
            <label for="ranking-search-filter">Period</label>
            <select id="ranking-search-filter" name="ranking-search-filter">
              <option value="">All time</option></select>
          </div>
        </div>
        <section class="panel">
          <div class="panel-heading">
            <h2>Individual ranking</h2>
          </div>
          <div class="table-wrap">
            <table class="data-table">
              <caption class="visually-hidden">Individual Green Points ranking</caption>
              <thead>
                <tr>
                  <th scope="col">Rank</th>
                  <th scope="col">Participant</th>
                  <th scope="col">Faculty</th>
                  <th scope="col">Green Points</th>
                </tr>
              </thead>
              <tbody><?php $kind='rankings'; $columns=['Rank', 'Participant', 'Faculty', 'Green Points']; include __DIR__ . '/../includes/table.php'; ?></tbody>
            </table>
          </div>
        </section>
        <p class="note">Approved actions count toward the rankings.</p>
      </div>
    </main>
  
<?php page_end(); break;
case 'profile-change-password-validation':
page_start('Profile','Profile',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Profile') ?>Profile</h1>
            <p class="context-line">Registered User</p>
            <p class="page-description">Your campus account, in one place.</p>
          </div>
        </div>
        <div class="stack">
          <nav class="page-tabs" aria-label="Section views">
            <a href="../user/account.php?view=profile-profile">Profile</a>
            <a href="../user/account.php?view=profile-edit-details" class="is-active" aria-current="page">Edit details</a>
          </nav>
          <section class="panel">
            <div class="panel-heading">
              <h2>Account details</h2>
            </div>
            <div class="stack" data-native-validation="" aria-label="Edit participant account">
              <div class="form-grid">
                <div class="field">
                  <label for="profile-name">Full name</label>
                  <input id="profile-name" type="text" placeholder="Full name" form="backend-form" name="profile-name" value="<?php echo value('profile-name','full_name',''); ?>">
                </div>
                <div class="field">
                  <label for="profile-email">Email</label>
                  <input title="Student emails must end with @mail.apu.edu.my." id="profile-email" type="email" aria-describedby="profile-email-error" required maxlength="254" pattern="[^\s@]+@mail\.apu\.edu\.my" autocomplete="email" placeholder="tp090526@mail.apu.edu.my" form="backend-form" name="profile-email" value="<?php echo value('profile-email','email',''); ?>">
                  <p class="field-error" id="profile-email-error">Use your @mail.apu.edu.my student email address.</p>
                </div>
                <div class="field">
                  <label for="profile-faculty">Faculty</label>
                  <select id="profile-faculty" form="backend-form" name="profile-faculty">
                    <option value="" <?php echo selected('profile-faculty','faculty','','') ? 'selected' : ''; ?>>Choose your faculty</option>
                    <option value="School of Computing" <?php echo selected('profile-faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                    <option value="School of Business" <?php echo selected('profile-faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                    <option value="School of Engineering" <?php echo selected('profile-faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                    <option value="School of Media" <?php echo selected('profile-faculty','faculty','School of Media','') ? 'selected' : ''; ?>>School of Media</option>
                  </select>
                </div>
                <div class="field">
                  <label for="profile-id">University ID</label>
                  <input title="TP followed by six digits, for example TP090526." maxlength="8" pattern="TP[0-9]{6}" id="profile-id" type="text" placeholder="TP090526" form="backend-form" name="profile-id" value="<?php echo value('profile-id','university_id',''); ?>">
                </div>
              </div>
              <div class="form-actions">
                <button class="button button--primary" type="submit" form="backend-form">Save changes</button>
                <a class="button button--outline" href="../user/account.php?view=profile-profile">Cancel</a>
              </div>
              <p class="note">Review your details before saving.</p>
            </div>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Account security</h2>
            </div>
            <p>Choose a password you do not use elsewhere.</p>
            <a class="button button--outline" href="../user/account.php?view=profile-change-password">Change password</a>
          </section>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Passwords do not match</h2>
            <p class="context-line">Registered User</p>
          </div>
          <a class="close-button" href="../user/account.php?view=profile-edit-details" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="form-grid">
            <div class="field">
              <label for="password-current">Current password</label>
              <input id="password-current" name="password-current" type="password" placeholder="Current password" form="backend-form">
            </div>
            <div class="field">
              <label for="password-new">New password</label>
              <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="password-new" name="password-new" type="password" placeholder="New password" form="backend-form">
            </div>
            <div class="field">
              <label for="password-confirm">Confirm password</label>
              <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="password-confirm" aria-invalid="true" aria-describedby="password-error" name="password-confirm" type="password" placeholder="Confirm password" form="backend-form">
            </div>
          </div>
          <p class="error-message" id="password-error">Passwords do not match. Enter the same new password in both fields.</p>
          <div class="form-actions">
            <a class="button button--primary" href="../user/account.php?view=profile-change-password">Edit password</a>
          </div>
        </div>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="password" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
case 'profile-change-password':
page_start('Profile','Profile',true);
?>
<main id="main-content" class="workspace-content">
        
        <div class="page-header">
          <div>
            <h1><?= section_icon('Profile') ?>Profile</h1>
            <p class="context-line">Registered User</p>
            <p class="page-description">Your campus account, in one place.</p>
          </div>
        </div>
        <div class="stack">
          <nav class="page-tabs" aria-label="Section views">
            <a href="../user/account.php?view=profile-profile">Profile</a>
            <a href="../user/account.php?view=profile-edit-details" class="is-active" aria-current="page">Edit details</a>
          </nav>
          <section class="panel">
            <div class="panel-heading">
              <h2>Account details</h2>
            </div>
            <div class="stack" data-native-validation="" aria-label="Edit participant account">
              <div class="form-grid">
                <div class="field">
                  <label for="profile-name">Full name</label>
                  <input id="profile-name" type="text" placeholder="Full name" form="backend-form" name="profile-name" value="<?php echo value('profile-name','full_name',''); ?>">
                </div>
                <div class="field">
                  <label for="profile-email">Email</label>
                  <input title="Student emails must end with @mail.apu.edu.my." id="profile-email" type="email" aria-describedby="profile-email-error" required maxlength="254" pattern="[^\s@]+@mail\.apu\.edu\.my" autocomplete="email" placeholder="tp090526@mail.apu.edu.my" form="backend-form" name="profile-email" value="<?php echo value('profile-email','email',''); ?>">
                  <p class="field-error" id="profile-email-error">Use your @mail.apu.edu.my student email address.</p>
                </div>
                <div class="field">
                  <label for="profile-faculty">Faculty</label>
                  <select id="profile-faculty" form="backend-form" name="profile-faculty">
                    <option value="" <?php echo selected('profile-faculty','faculty','','') ? 'selected' : ''; ?>>Choose your faculty</option>
                    <option value="School of Computing" <?php echo selected('profile-faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                    <option value="School of Business" <?php echo selected('profile-faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                    <option value="School of Engineering" <?php echo selected('profile-faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                    <option value="School of Media" <?php echo selected('profile-faculty','faculty','School of Media','') ? 'selected' : ''; ?>>School of Media</option>
                  </select>
                </div>
                <div class="field">
                  <label for="profile-id">University ID</label>
                  <input title="TP followed by six digits, for example TP090526." maxlength="8" pattern="TP[0-9]{6}" id="profile-id" type="text" placeholder="TP090526" form="backend-form" name="profile-id" value="<?php echo value('profile-id','university_id',''); ?>">
                </div>
              </div>
              <div class="form-actions">
                <button class="button button--primary" type="submit" form="backend-form">Save changes</button>
                <a class="button button--outline" href="../user/account.php?view=profile-profile">Cancel</a>
              </div>
              <p class="note">Review your details before saving.</p>
            </div>
          </section>
          <section class="panel">
            <div class="panel-heading">
              <h2>Account security</h2>
            </div>
            <p>Choose a password you do not use elsewhere.</p>
            <a class="button button--outline" href="../user/account.php?view=profile-change-password">Change password</a>
          </section>
        </div>
      </main>
    </div>
    <div class="dialog-overlay">
      
      <section class="action-dialog" role="dialog" aria-modal="true" aria-labelledby="dialog-title">
        <header class="dialog-header">
          <div>
            <h2 id="dialog-title">Change password</h2>
            <p class="context-line">Registered User</p>
          </div>
          <a class="close-button" href="../user/account.php?view=profile-edit-details" aria-label="Close dialog">
            <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
              <path d="m6 6 12 12M6 18 18 6"></path>
            </svg>
          </a>
        </header>
        <?php include __DIR__ . '/../includes/notices.php'; ?><div class="dialog-content">
          <div class="form-grid">
            <div class="field">
              <label for="password-current">Current password</label>
              <input id="password-current" name="password-current" type="password" placeholder="Current password" form="backend-form">
            </div>
            <div class="field">
              <label for="password-new">New password</label>
              <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="password-new" name="password-new" type="password" placeholder="New password" form="backend-form">
            </div>
            <div class="field">
              <label for="password-confirm">Confirm password</label>
              <input title="Use 8-72 characters including a special character, for example @, ! or #." maxlength="72" minlength="8" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" id="password-confirm" name="password-confirm" type="password" placeholder="Confirm password" form="backend-form">
            </div>
          </div>
          <div class="form-actions">
            <button class="button button--primary" type="submit" form="backend-form">Save password</button>
          </div>
        </div>
      <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="password" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></section>
    </div>
  
<?php page_end(); break;
case 'profile-edit-details':
page_start('Profile','Profile',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Profile') ?>Profile</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Your campus account, in one place.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/account.php?view=profile-profile">Profile</a>
          <a href="../user/account.php?view=profile-edit-details" class="is-active" aria-current="page">Edit details</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Account details</h2>
          </div>
          <div class="stack" data-native-validation="" aria-label="Edit participant account">
            <div class="form-grid">
              <div class="field">
                <label for="profile-name">Full name</label>
                <input id="profile-name" type="text" placeholder="Full name" form="backend-form" name="profile-name" value="<?php echo value('profile-name','full_name',''); ?>">
              </div>
              <div class="field">
                <label for="profile-email">Email</label>
                <input title="Student emails must end with @mail.apu.edu.my." id="profile-email" type="email" aria-describedby="profile-email-error" required maxlength="254" pattern="[^\s@]+@mail\.apu\.edu\.my" autocomplete="email" placeholder="tp090526@mail.apu.edu.my" form="backend-form" name="profile-email" value="<?php echo value('profile-email','email',''); ?>">
                <p class="field-error" id="profile-email-error">Use your @mail.apu.edu.my student email address.</p>
              </div>
              <div class="field">
                <label for="profile-faculty">Faculty</label>
                <select id="profile-faculty" form="backend-form" name="profile-faculty">
                  <option value="" <?php echo selected('profile-faculty','faculty','','') ? 'selected' : ''; ?>>Choose your faculty</option>
                  <option value="School of Computing" <?php echo selected('profile-faculty','faculty','School of Computing','') ? 'selected' : ''; ?>>School of Computing</option>
                  <option value="School of Business" <?php echo selected('profile-faculty','faculty','School of Business','') ? 'selected' : ''; ?>>School of Business</option>
                  <option value="School of Engineering" <?php echo selected('profile-faculty','faculty','School of Engineering','') ? 'selected' : ''; ?>>School of Engineering</option>
                  <option value="School of Media" <?php echo selected('profile-faculty','faculty','School of Media','') ? 'selected' : ''; ?>>School of Media</option>
                </select>
              </div>
              <div class="field">
                <label for="profile-id">University ID</label>
                <input title="TP followed by six digits, for example TP090526." maxlength="8" pattern="TP[0-9]{6}" id="profile-id" type="text" placeholder="TP090526" form="backend-form" name="profile-id" value="<?php echo value('profile-id','university_id',''); ?>">
              </div>
            </div>
            <div class="form-actions">
              <button class="button button--primary" type="submit" form="backend-form">Save changes</button>
              <a class="button button--outline" href="../user/account.php?view=profile-profile">Cancel</a>
            </div>
            <p class="note">Review your details before saving.</p>
          </div>
        </section>
        <section class="panel">
          <div class="panel-heading">
            <h2>Account security</h2>
          </div>
          <p>Choose a password you do not use elsewhere.</p>
          <a class="button button--outline" href="../user/account.php?view=profile-change-password">Change password</a>
        </section>
      </div>
    <form id="backend-form" method="post" enctype="multipart/form-data" hidden=""><?php echo csrf_field(); ?><input type="hidden" name="action" value="profile" form="backend-form"><input type="hidden" name="id" value="<?php echo (int)$id; ?>" form="backend-form"></form></main>
  
<?php page_end(); break;
case 'profile-profile':
page_start('Profile','Profile',false);
?>
<main id="main-content" class="workspace-content">
      
      <?php include __DIR__ . '/../includes/notices.php'; ?><div class="page-header">
        <div>
          <h1><?= section_icon('Profile') ?>Profile</h1>
          <p class="context-line">Registered User</p>
          <p class="page-description">Your campus account, in one place.</p>
        </div>
      </div>
      <div class="stack">
        <nav class="page-tabs" aria-label="Section views">
          <a href="../user/account.php?view=profile-profile" class="is-active" aria-current="page">Profile</a>
          <a href="../user/account.php?view=profile-edit-details">Edit details</a>
        </nav>
        <section class="panel">
          <div class="panel-heading">
            <h2>Account details</h2>
          </div>
          <div class="profile-summary">
            <span class="avatar" aria-hidden="true">—</span>
            <div>
              <h2><?php echo e($user['full_name'] ?? 'Your account'); ?></h2>
              <p class="context-line"><?php echo e($user['faculty'] ?? ''); ?></p>
              <p>A little progress, every day.</p>
            </div>
          </div>
          <dl class="detail-list">
            <div>
              <dt>Name</dt>
              <dd><?php echo e($record['full_name'] ?? 'Not selected'); ?></dd>
            </div>
            <div>
              <dt>Email</dt>
              <dd><?php echo e($record['email'] ?? 'Not selected'); ?></dd>
            </div>
            <div>
              <dt>University ID</dt>
              <dd><?php echo e($record['university_id'] ?? 'Not selected'); ?></dd>
            </div>
            <div>
              <dt>Faculty</dt>
              <dd><?php echo e($record['faculty'] ?? 'Not selected'); ?></dd>
            </div>
            <div>
              <dt>Account status</dt>
              <dd><?php echo e($record['status'] ?? 'Not selected'); ?></dd>
            </div>
          </dl>
          <div class="form-actions">
            <a class="button button--primary" href="../user/account.php?view=profile-edit-details">Edit details</a>
          </div>
        </section>
      </div>
    </main>
  
<?php page_end(); break;
}
