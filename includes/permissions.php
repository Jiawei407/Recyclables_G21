<?php

function role_permissions($role) {
    return [
        'user' => [
            'join-challenges' => 'Join challenges',
            'submit-evidence' => 'Submit evidence',
        ],
        'faculty' => [
            'create-activities' => 'Create faculty activities',
            'feature-challenges' => 'Feature challenges',
            'publish-announcements' => 'Publish faculty announcements',
            'submit-reports' => 'Submit faculty reports',
        ],
        'coordinator' => [
            'manage-challenges' => 'Manage challenges',
            'manage-campaigns' => 'Manage campaigns',
            'review-submissions' => 'Review submissions',
            'publish-announcements' => 'Publish announcements',
        ],
        'admin' => [
            'manage-users' => 'Manage users and permissions',
            'manage-achievements' => 'Manage achievements',
            'manage-challenges' => 'Manage challenges',
            'review-submissions' => 'Review pending submissions',
            'reverse-submission-points' => 'Reject approved submissions and reverse points',
        ],
    ][$role] ?? [];
}

function user_has_permission($account, $permission) {
    if (!isset(role_permissions($account['role'] ?? '')[$permission])) return false;
    if ($permission === 'join-challenges') return (bool)($account['can_join'] ?? true);
    if ($permission === 'submit-evidence') return (bool)($account['can_submit'] ?? true);
    return !in_array($permission, explode(',', $account['disabled_permissions'] ?? ''), true);
}

function can_manage_admin_accounts($account) {
    if (($account['role'] ?? '') !== 'admin') return false;
    foreach (array_keys(role_permissions('admin')) as $permission) {
        if (!user_has_permission($account, $permission)) return false;
    }
    return true;
}

function disabled_role_permissions($role, $enabled) {
    $allowed = array_keys(role_permissions($role));
    if (!is_array($enabled)) throw new InvalidArgumentException('Choose valid permissions for the selected role.');
    foreach ($enabled as $permission) {
        if (!in_array($permission, $allowed, true)) throw new InvalidArgumentException('Choose valid permissions for the selected role.');
    }
    return array_values(array_diff($allowed, $enabled));
}

function require_permission($permission) {
    global $user;
    if (!user_has_permission($user, $permission)) {
        http_response_code(403);
        exit('This action is disabled for your account.');
    }
}
