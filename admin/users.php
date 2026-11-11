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
require __DIR__.'/../includes/layout.php';

$creating = $view === 'users-create-user';
$editing = $view === 'users-edit-user';
$confirming = in_array($view, ['users-delete-user','users-suspend-user'], true);
$deleting = $view === 'users-delete-user';
$can_manage_users = user_has_permission($user, 'manage-users');
$can_manage_admins = can_manage_admin_accounts($user);
if ($view !== 'users-users') require_permission('manage-users');
if ($editing || $confirming) {
    $selected_id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
    if (!$selected_id || !$record) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') redirect('admin/users-users.php');
        $editing = $confirming = false;
    } elseif ($record['role'] === 'admin' && !$can_manage_admins) {
        http_response_code(403);
        exit('Only an administrator with all permissions can manage administrator accounts.');
    }
}

$role_names = [
    'user'=>'Registered User',
    'faculty'=>'Faculty Representative',
    'coordinator'=>'Sustainability Coordinator',
    'admin'=>'Administrator',
];
$self = ($editing || $confirming) && (int)$record['id'] === (int)$user['id'];
$list_url = e(route_url('admin/users-users.php'));
$edit_url = ($editing || $confirming) ? e(route_url('admin/users-edit-user.php?id=' . $id)) : '';
$selected_role = post('designated-role', $editing ? $record['role'] : '');
$posted_permissions = !$self && post('permissions-role') === $selected_role ? ($_POST['permissions'] ?? []) : null;

page_start('Users','Users',false);
?>
<main id="main-content" class="workspace-content">
  <?php include __DIR__ . '/../includes/notices.php'; ?>
  <div class="page-header">
    <div><h1><?= section_icon('Users') ?>Users</h1></div>
  </div>
  <div class="stack">
    <nav class="page-tabs" aria-label="Section views">
      <a href="<?= $list_url ?>" <?= !$creating && !$editing && !$confirming ? 'class="is-active" aria-current="page"' : '' ?>>Users</a>
      <?php if ($can_manage_users): ?>
        <a href="<?= e(route_url('admin/users-create-user.php')) ?>" <?= $creating ? 'class="is-active" aria-current="page"' : '' ?>>Create user</a>
      <?php endif; ?>
      <?php if ($edit_url): ?>
        <a href="<?= $edit_url ?>" class="is-active" <?= $editing ? 'aria-current="page"' : '' ?>>Edit user</a>
      <?php endif; ?>
    </nav>

    <?php if ($creating || $editing): ?>
    <section class="panel" aria-labelledby="user-form-title">
      <div class="panel-heading">
        <h2 id="user-form-title"><?= $editing ? 'Edit user' : 'Create a user' ?></h2>
      </div>
      <form id="backend-form" class="stack" method="post" data-native-validation>
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save-user">
        <input type="hidden" name="id" value="<?= $editing ? (int)$id : 0 ?>">
        <div class="form-grid">
          <div class="field">
            <label for="full-name">Full name</label>
            <input id="full-name" name="full-name" required maxlength="100" value="<?= value('full-name','full_name') ?>">
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required maxlength="254" autocomplete="email" value="<?= value('email') ?>">
          </div>
          <div class="field">
            <label for="university-id">University ID</label>
            <input id="university-id" name="university-id" required maxlength="20" value="<?= value('university-id','university_id') ?>">
          </div>
          <div class="field">
            <label for="faculty">Faculty</label>
            <select id="faculty" name="faculty" required>
              <option value="">Choose a faculty</option>
              <?php foreach (faculties() as $school): ?>
                <option value="<?= e($school) ?>" <?= selected('faculty','faculty',$school) ?>><?= e($school) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label for="designated-role">Designated role</label>
            <select id="designated-role" name="designated-role" required>
              <option value="">Choose a role</option>
              <?php foreach ($role_names as $key => $label): ?>
                <?php if (($key === 'admin' && !$can_manage_admins) || ($self && $key !== 'admin')) continue; ?>
                <option value="<?= e($key) ?>" <?= $key === $selected_role ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label for="account-status">Account status</label>
            <select id="account-status" name="account-status" required>
              <?php foreach (['active','suspended','inactive'] as $status): ?>
                <?php if ($self && $status !== 'active') continue; ?>
                <option value="<?= e($status) ?>" <?= selected('account-status','status',$status,'active') ?>><?= e(ucfirst($status)) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label for="new-password"><?= $editing ? 'New password' : 'Set password' ?></label>
            <input id="new-password" name="new-password" type="password" minlength="8" maxlength="72" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" autocomplete="new-password" aria-describedby="password-hint" <?= $creating ? 'required' : '' ?>>
            <small class="field-help" id="password-hint"><?= $editing ? 'Leave blank to keep the current password. ' : '' ?>Use 8–72 characters with a special character.</small>
          </div>
          <div class="field">
            <label for="confirm-password">Confirm password</label>
            <input id="confirm-password" name="confirm-password" type="password" minlength="8" maxlength="72" pattern="(?=.*[^\p{L}\p{N}\s]).{8,72}" autocomplete="new-password" <?= $creating ? 'required' : '' ?>>
          </div>
        </div>

        <p class="muted" data-permission-hint <?= $selected_role ? 'hidden' : '' ?>>Choose a role to see its permissions.</p>
        <?php foreach ($role_names as $key => $label): ?>
          <?php if (($key === 'admin' && !$can_manage_admins) || ($self && $key !== 'admin')) continue; ?>
          <div data-permission-role="<?= e($key) ?>" <?= $key === $selected_role ? '' : 'hidden' ?>>
            <fieldset class="check-group" <?= $key === $selected_role ? '' : 'disabled' ?>>
              <legend><?= e($label) ?> permissions</legend>
              <input type="hidden" name="permissions-role" value="<?= e($key) ?>">
              <?php foreach (role_permissions($key) as $permission => $description): ?>
                <?php
                $current_account = $editing && $record['role'] === $key ? $record : ['role'=>$key];
                $checked = $key === $selected_role && is_array($posted_permissions)
                    ? in_array($permission, $posted_permissions, true)
                    : user_has_permission($current_account, $permission);
                ?>
                <label class="check-option">
                  <input type="checkbox" name="permissions[]" value="<?= e($permission) ?>" <?= $checked ? 'checked' : '' ?> <?= $self ? 'disabled' : '' ?>>
                  <span><?= e($description) ?></span>
                </label>
              <?php endforeach; ?>
              <?php if ($self): ?><p class="muted">Another administrator can change these permissions.</p><?php endif; ?>
            </fieldset>
          </div>
        <?php endforeach; ?>
        <div class="form-actions">
          <button class="button button--primary" type="submit"><?= $editing ? 'Save user' : 'Create user' ?></button>
          <a class="button button--outline" href="<?= $list_url ?>">Cancel</a>
        </div>
      </form>
    </section>
    <?php if ($editing && !$self): ?>
      <section class="panel">
        <h2>Account controls</h2>
        <div class="form-actions">
          <?php if ($record['status'] === 'active'): ?>
            <a class="button button--outline" href="<?= e(route_url('admin/users-suspend-user.php?id=' . $id)) ?>">Suspend user</a>
          <?php endif; ?>
          <a class="button button--danger" href="<?= e(route_url('admin/users-delete-user.php?id=' . $id)) ?>">Delete user</a>
        </div>
      </section>
    <?php endif; ?>
    <script src="<?= e($base) ?>/scripts/user-permissions.js" defer></script>
    <?php elseif ($confirming): ?>
      <section class="panel">
        <h2><?= $deleting ? 'Delete user' : 'Suspend user' ?></h2>
        <dl class="detail-list">
          <div><dt>Account</dt><dd><?= e($record['full_name']) ?></dd></div>
          <div><dt>Email</dt><dd><?= e($record['email']) ?></dd></div>
          <div><dt>Status</dt><dd><?= e(ucfirst($record['status'])) ?></dd></div>
        </dl>
        <?php if ($self): ?>
          <p>You cannot delete or suspend your own account.</p>
          <a class="button button--outline" href="<?= $edit_url ?>">Back to user</a>
        <?php else: ?>
          <p><?= $deleting ? 'Deletion permanently removes this account. Accounts with evidence or points can be suspended.' : 'Suspension pauses access and keeps the account history.' ?></p>
          <form method="post" class="form-actions">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="<?= $deleting ? 'delete-user' : 'suspend-user' ?>">
            <input type="hidden" name="id" value="<?= (int)$id ?>">
            <button class="button button--danger" type="submit"><?= $deleting ? 'Delete user' : 'Suspend user' ?></button>
            <a class="button button--outline" href="<?= $edit_url ?>">Cancel</a>
          </form>
        <?php endif; ?>
      </section>
    <?php else: ?>
      <div class="toolbar" role="search">
        <div class="field">
          <label for="search-users">Search users</label>
          <input id="search-users" name="search-users" type="search" placeholder="Search users">
        </div>
        <div class="field">
          <label for="filter-role">Role</label>
          <select id="filter-role" name="filter-role">
            <option selected>All roles</option>
            <?php foreach ($role_names as $label): ?><option><?= e($label) ?></option><?php endforeach; ?>
          </select>
        </div>
      </div>
      <section class="panel">
        <div class="panel-heading"><h2>People on the platform</h2></div>
        <div class="table-wrap">
          <table class="data-table">
            <caption class="visually-hidden">User accounts</caption>
            <thead><tr>
              <th scope="col">Name</th>
              <th scope="col">Role</th>
              <th scope="col">Faculty</th>
              <th scope="col">Status</th>
              <?php if ($can_manage_users): ?><th scope="col">Action</th><?php endif; ?>
            </tr></thead>
            <tbody><?php
              $kind='users';
              $columns=['Name','Role','Faculty','Status'];
              if ($can_manage_users) $columns[]='Action';
              include __DIR__ . '/../includes/table.php';
            ?></tbody>
          </table>
        </div>
      </section>
    <?php endif; ?>
  </div>
</main>
<?php page_end();
