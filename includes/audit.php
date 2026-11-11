<?php

function audit_role_label($role) {
    return [
        'user' => 'Registered user',
        'faculty' => 'Faculty representative',
        'coordinator' => 'Sustainability coordinator',
        'admin' => 'Administrator',
    ][$role] ?? 'Not recorded';
}

function audit_action_aliases() {
    return ['delete-user' => 'user-deleted', 'suspend-user' => 'user-suspended'];
}

function audit_action_label($action) {
    return [
        'user-created' => 'User created',
        'user-updated' => 'User updated',
        'user-saved' => 'User saved',
        'user-deleted' => 'User deleted',
        'user-suspended' => 'User suspended',
        'points-deduct' => 'Points deducted',
        'points-approve' => 'Points review approved',
        'points-deny' => 'Points review denied',
        'submission-rejected' => 'Approved submission rejected',
        'achievement-saved' => 'Achievement saved',
        'challenge-saved' => 'Challenge saved',
        'challenge-deleted' => 'Challenge deleted',
        'evidence-approved' => 'Evidence approved',
        'evidence-rejected' => 'Evidence rejected',
        'evidence-needs-revision' => 'Evidence sent for revision',
    ][$action] ?? ucfirst(str_replace('-', ' ', $action));
}

function audit_action_text($record) {
    $action = $record['action'];
    $details = trim($record['details']);
    if ($action === 'user-saved' && preg_match('/^User #(\d+); role=([^;]+); status=([^;]+)$/D', $details, $parts)) {
        return 'Saved user #' . $parts[1] . ' as ' . audit_role_label($parts[2]) . ' with ' . $parts[3] . ' status.';
    }
    if ($action === 'points-deduct' && preg_match('/^User #(\d+); deducted=(\d+);/', $details, $parts)) {
        return 'Deducted ' . $parts[2] . ' Green Points from user #' . $parts[1] . '.';
    }
    if (str_starts_with($action, 'evidence-') && preg_match('/^Submission #(\d+); (\d+) points\./', $details, $parts)) {
        return match ($action) {
            'evidence-approved' => 'Approved submission #' . $parts[1] . ' and awarded ' . $parts[2] . ' Green Points.',
            'evidence-rejected' => 'Rejected submission #' . $parts[1] . '.',
            'evidence-needs-revision' => 'Requested revision of submission #' . $parts[1] . '.',
            default => audit_action_label($action),
        };
    }
    $legacy_verbs = [
        'delete-user' => 'Deleted ',
        'suspend-user' => 'Suspended ',
        'challenge-saved' => 'Saved ',
        'challenge-deleted' => 'Deleted ',
        'achievement-saved' => 'Saved ',
    ];
    if (isset($legacy_verbs[$action]) && preg_match('/^(User|Challenge|Achievement) #\d+/', $details)) {
        return rtrim($legacy_verbs[$action] . lcfirst($details), '.') . '.';
    }
    if (in_array($action, ['points-approve', 'points-deny'], true) && preg_match('/^User #(\d+);/', $details, $parts)) {
        return ($action === 'points-approve' ? 'Approved' : 'Denied') . ' a points review for user #' . $parts[1] . '.';
    }
    return $details ?: audit_action_label($action) . '.';
}

function audit_filter_values($input) {
    $filters = [];
    foreach (['from', 'to', 'audit-user', 'audit-role', 'audit-action', 'audit-search'] as $field) {
        $filters[$field] = is_string($input[$field] ?? null) ? trim($input[$field]) : '';
    }
    foreach (['from', 'to'] as $field) {
        $date = preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/D', $filters[$field])
            ? DateTimeImmutable::createFromFormat('!Y-m-d', $filters[$field])
            : false;
        if (!$date || $date->format('Y-m-d') !== $filters[$field]) $filters[$field] = '';
    }
    if (!valid_role($filters['audit-role'])) $filters['audit-role'] = '';
    return $filters;
}

function audit_where($filters, $name, $role) {
    $conditions = ["a.action NOT LIKE 'test-%'"];
    $params = [];
    if ($filters['from'] !== '') {
        $conditions[] = 'a.created_at >= ?';
        $params[] = $filters['from'];
    }
    if ($filters['to'] !== '') {
        $conditions[] = 'a.created_at < DATE_ADD(?, INTERVAL 1 DAY)';
        $params[] = $filters['to'];
    }
    if (preg_match('/^id:[1-9][0-9]{0,9}$/D', $filters['audit-user'])) {
        $conditions[] = 'a.actor_id = ?';
        $params[] = substr($filters['audit-user'], 3);
    } elseif (str_starts_with($filters['audit-user'], 'name:')) {
        $conditions[] = 'a.actor_id IS NULL AND ' . $name . ' = ?';
        $params[] = substr($filters['audit-user'], 5);
    }
    if ($filters['audit-role'] !== '') {
        $conditions[] = $role . ' = ?';
        $params[] = $filters['audit-role'];
    }
    if ($filters['audit-action'] !== '') {
        $actions = array_merge([$filters['audit-action']], array_keys(audit_action_aliases(), $filters['audit-action'], true));
        $conditions[] = 'a.action IN (' . implode(',', array_fill(0, count($actions), '?')) . ')';
        array_push($params, ...$actions);
    }
    if ($filters['audit-search'] !== '') {
        $conditions[] = "(LOCATE(?, a.details) > 0 OR LOCATE(?, REPLACE(a.action, '-', ' ')) > 0 OR LOCATE(?, " . $name . ') > 0)';
        array_push($params, $filters['audit-search'], $filters['audit-search'], $filters['audit-search']);
    }
    return [implode(' AND ', $conditions), $params];
}

function audit_actor_expressions() {
    return ["COALESCE(NULLIF(a.actor_name,''), u.full_name, 'Unknown user')", "COALESCE(a.actor_role, '')"];
}

function audit_record($id) {
    [$name, $role] = audit_actor_expressions();
    return one("SELECT a.*, $name AS display_name, $role AS recorded_role
        FROM audit_logs a LEFT JOIN users u ON u.id=a.actor_id
        WHERE a.id=? AND a.action NOT LIKE 'test-%'", [$id]);
}

function audit_records($filters) {
    [$name, $role] = audit_actor_expressions();
    [$where, $params] = audit_where($filters, $name, $role);
    return rows("SELECT a.*, $name AS display_name, $role AS recorded_role
        FROM audit_logs a LEFT JOIN users u ON u.id=a.actor_id
        WHERE $where ORDER BY a.created_at DESC, a.id DESC LIMIT 500", $params);
}

function audit_filter_options() {
    [$name] = audit_actor_expressions();
    $actors = rows("SELECT DISTINCT a.actor_id, COALESCE(u.full_name, $name) AS display_name FROM audit_logs a
        LEFT JOIN users u ON u.id=a.actor_id WHERE a.action NOT LIKE 'test-%' ORDER BY display_name");
    $actions = rows("SELECT DISTINCT action FROM audit_logs WHERE action NOT LIKE 'test-%'");
    $aliases = audit_action_aliases();
    $options = [];
    foreach ($actions as $record) {
        $action = $aliases[$record['action']] ?? $record['action'];
        $options[$action] = audit_action_label($action);
    }
    asort($options);
    return [audit_user_options($actors), $options];
}

function audit_user_options($actors) {
    $duplicates = array_count_values(array_column($actors, 'display_name'));
    $options = [];
    foreach ($actors as $actor) {
        $name = $actor['display_name'];
        if ($actor['actor_id'] === null) {
            $options['name:' . $name] = $name === 'Unknown user' ? $name : $name . ' (former user)';
        } else {
            $id = (int)$actor['actor_id'];
            $options['id:' . $id] = $duplicates[$name] > 1 ? $name . ' (user #' . $id . ')' : $name;
        }
    }
    return $options;
}
