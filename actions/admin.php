<?php
if ($action === 'save-user') {
    require_role('admin');
    require_permission('manage-users');
    $editing = ($page ?? '') === 'admin/users-edit-user.php';
    $creating = ($page ?? '') === 'admin/users-create-user.php';
    $id = $editing ? number_value('id', 1, 2147483647) : 0;
    $selected_id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
    need($creating || ($editing && $id === $selected_id), 'Select a user before saving changes.');
    $name = post('full-name'); $email = strtolower(post('email')); $university_id = post('university-id');
    $faculty = post('faculty'); $role = post('designated-role'); $status = strtolower(post('account-status','active'));
    $password = raw_password('new-password'); $confirm = raw_password('confirm-password');
    $problem = account_error($name,$email,$university_id,$faculty,$password,$confirm,!$id,$role);
    need($problem === '',$problem);
    need(valid_role($role) && in_array($status,['active','suspended','inactive'],true), 'Choose a role and account status.');
    mysqli_begin_transaction($conn);
    $old = $editing ? one('SELECT * FROM users WHERE id=? FOR UPDATE', [$id]) : null;
    need(!$editing || $old, 'Select an existing user.');
    if ($role === 'admin' || ($old['role'] ?? '') === 'admin') {
        need(can_manage_admin_accounts($user), 'Only an administrator with all permissions can manage administrator accounts.');
    }
    $editing_self = $id === (int)$user['id'];
    need(!$editing_self || ($role === 'admin' && $status === 'active'), 'Keep your own administrator account active.');
    $enabled = array_keys(role_permissions($role));
    if (post('permissions-role') === $role) $enabled = $_POST['permissions'] ?? [];
    if ($editing_self || (post('permissions-role') !== $role && ($old['role'] ?? '') === $role)) {
        $enabled = array_filter(array_keys(role_permissions($role)), fn($permission) => user_has_permission($old, $permission));
    }
    $disabled = disabled_role_permissions($role, $enabled);
    $join = (int)!in_array('join-challenges', $disabled, true);
    $submit = (int)!in_array('submit-evidence', $disabled, true);
    $overrides = $role === 'user' ? '' : implode(',', $disabled);
    if ($id) {
        query('UPDATE users SET full_name=?,email=?,university_id=?,faculty=?,role=?,status=?,can_join=?,can_submit=?,disabled_permissions=? WHERE id=?',[$name,$email,$university_id,$faculty,$role,$status,$join,$submit,$overrides,$id]);
        if ($password !== '') query('UPDATE users SET password=? WHERE id=?',[$password,$id]);
    } else {
        query('INSERT INTO users (full_name,email,university_id,faculty,role,status,password,can_join,can_submit,disabled_permissions) VALUES (?,?,?,?,?,?,?,?,?,?)',[$name,$email,$university_id,$faculty,$role,$status,$password,$join,$submit,$overrides]);
        $id = mysqli_insert_id($conn);
    }
    $role_names = ['user'=>'registered user', 'faculty'=>'faculty representative', 'coordinator'=>'sustainability coordinator', 'admin'=>'administrator'];
    $permission_change = '';
    if ($editing && $old['role'] === $role) {
        $changed = [];
        foreach (role_permissions($role) as $permission => $label) {
            $allowed = !in_array($permission, $disabled, true);
            if ($allowed !== user_has_permission($old, $permission)) $changed[] = ($allowed ? 'enabled ' : 'disabled ') . strtolower($label);
        }
        if ($changed) $permission_change = ' ' . ucfirst(implode(', ', $changed)) . '.';
    }
    audit($editing ? 'user-updated' : 'user-created', ($editing ? 'Updated ' : 'Created ') . $name . ' as ' . $role_names[$role] . ' (' . $status . ').' . $permission_change);
    mysqli_commit($conn);
    action_success('User', $editing ? 'updated' : 'created', 'admin/users-users.php', $name);
}
if (in_array($action,['delete-user','suspend-user'],true)) {
    require_role('admin');
    require_permission('manage-users');
    $id = number_value('id', 1, 2147483647);
    need($id !== (int)$user['id'], 'You cannot delete or suspend your own account.');
    mysqli_begin_transaction($conn);
    $selected = one('SELECT full_name,role FROM users WHERE id=? FOR UPDATE', [$id]);
    need($selected, 'Select a user.');
    need($selected['role'] !== 'admin' || can_manage_admin_accounts($user), 'Only an administrator with all permissions can manage administrator accounts.');
    if ($action === 'delete-user') {
        need(!one('SELECT id FROM submissions WHERE user_id=? LIMIT 1',[$id]) && !one('SELECT id FROM point_transactions WHERE user_id=? LIMIT 1',[$id]), 'This user has evidence or points. Suspend the account to preserve the records.');
        query('DELETE FROM users WHERE id=?',[$id]);
    } else { query("UPDATE users SET status='suspended' WHERE id=?",[$id]); }
    audit($action === 'delete-user' ? 'user-deleted' : 'user-suspended', ($action === 'delete-user' ? 'Deleted ' : 'Suspended ') . $selected['full_name'] . '.');
    mysqli_commit($conn);
    action_success('Account', $action === 'delete-user' ? 'deleted' : 'suspended', 'admin/users-users.php');
}
if ($action === 'reject-approved-submission') {
    require_role('admin');
    require_permission('reverse-submission-points');
    $participant_id = number_value('id', 1, 2147483647);
    $transaction_id = number_value('transaction-id', 1, 2147483647);
    $reason = review_note('rejected', 'Other', post('review-reason'));
    mysqli_begin_transaction($conn);
    $award = one('SELECT p.points,p.reverses_id,s.id AS submission_id,s.status,u.full_name
        FROM point_transactions p
        JOIN submissions s ON s.id=p.submission_id AND s.user_id=p.user_id
        JOIN users u ON u.id=s.user_id
        WHERE p.id=? AND p.user_id=? FOR UPDATE', [$transaction_id,$participant_id]);
    $points = reversible_submission_points($award ?? []);
    need($points > 0, 'Only an approved submission with an active point award can be rejected.');
    $submission_id = (int)$award['submission_id'];
    query("UPDATE submissions SET status='rejected',review_notes=?,reviewer_id=?,reviewed_at=NOW(),points_awarded=0 WHERE id=?",
        [$reason,$user['id'],$submission_id]);
    query('INSERT INTO point_transactions (user_id,reverses_id,points,reason,actor_id) VALUES (?,?,?,?,?)',
        [$participant_id,$transaction_id,-$points,'Reversed points for submission #' . $submission_id,$user['id']]);
    audit('submission-rejected', 'Rejected submission #' . $submission_id . ' for ' . $award['full_name'] . ' and deducted ' . $points . ' Green Points.');
    mysqli_commit($conn);
    action_success('Submission #' . $submission_id, 'rejected',
        'admin/leaderboard-review-user-points.php?id=' . $participant_id . '&transaction=' . $transaction_id . '#activity-details',
        '', $points . ' Green Points reversed.');
}
if ($action === 'save-achievement') {
    require_role('admin');
    require_permission('manage-achievements');
    $editing = ($page ?? '') === 'admin/achievements-edit.php';
    $id = $editing ? number_value('id', 1, 2147483647) : 0;
    $selected = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
    need(($page ?? '') === 'admin/achievements-create.php' || ($editing && $id === $selected), 'Select an achievement before saving changes.');
    $name = post('achievement-name');
    $status = strtolower(post('achievement-status','draft'));
    need($name !== '' && strlen($name)<=120, 'Enter an achievement name of up to 120 characters.');
    need(in_array($status,['draft','active','archived'],true), 'Choose a valid achievement status.');
    $old = $id ? one('SELECT * FROM achievements WHERE id=?',[$id]) : null;
    need(!$id || $old, 'Select an achievement.');
    $family = post('badge-family', $old['family_key'] ?? '');
    [$family, $tier] = badge_identity(
        post('badge-mode', $family === '' ? 'standalone' : 'tiered'),
        $family,
        post('badge-tier', $old['tier'] ?? 'bronze')
    );
    $rules = [];
    for ($i = 1; $i <= 3; $i++) {
        $field = 'requirement-' . $i . '-';
        $rule = achievement_rule(post($field . 'count'), post($field . 'item'), post($field . 'condition'), post($field . 'challenge'));
        if ($rule === null) continue;
        if ($rule[3] !== null) need(one('SELECT id FROM challenges WHERE id=?', [$rule[3]]), 'Choose an existing challenge.');
        $rules[] = $rule;
    }
    need($status !== 'active' || $rules, 'An active achievement needs at least one requirement.');
    $upload = save_upload('image', badge: true);
    mysqli_begin_transaction($conn);
    $current = $id ? one('SELECT image FROM achievements WHERE id=? FOR UPDATE', [$id]) : null;
    need(!$id || $current, 'Select an achievement.');
    $image = $upload ?: ($current['image'] ?? '');
    if ($family !== '') {
        need(!one('SELECT id FROM achievements WHERE family_key=? AND tier=? AND id<>? LIMIT 1 FOR UPDATE', [$family,$tier,$id]), 'This family already has that badge level. Edit the existing level instead.');
    }
    if ($id) { query('UPDATE achievements SET name=?,status=?,image=?,family_key=?,tier=? WHERE id=?',[$name,$status,$image,$family,$tier,$id]); }
    else { query('INSERT INTO achievements (name,status,image,family_key,tier) VALUES (?,?,?,?,?)',[$name,$status,$image,$family,$tier]); $id = mysqli_insert_id($conn); }
    query('DELETE FROM achievement_rules WHERE achievement_id=?',[$id]);
    foreach ($rules as $rule) {
        query('INSERT INTO achievement_rules (achievement_id,required_count,item,condition_name,challenge_id) VALUES (?,?,?,?,?)', [$id, ...$rule]);
    }
    audit('achievement-saved','Achievement #' . $id);
    mysqli_commit($conn);
    action_success('Achievement', $editing ? 'updated' : 'created', 'admin/achievements-achievements.php', $name);
}
