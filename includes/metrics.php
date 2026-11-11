<?php
function metric($label) {
    global $uid,$role,$faculty;
    $label=strtolower($label);
    $where=''; $values=[];
    if ($role === 'user') { $where=' WHERE u.id=?'; $values=[$uid]; }
    if ($role === 'faculty') { $where=' WHERE u.faculty=?'; $values=[$faculty]; }
    if(str_contains($label,'participation rate')) {
        $participation=faculty_participation($faculty);
        return ($participation['eligible'] ? round(100*$participation['joined']/$participation['eligible']) : 0).'%';
    }
    if(str_contains($label,'challenges completed')) {
        return one("SELECT COUNT(DISTINCT s.challenge_id) AS total FROM submissions s WHERE s.user_id=? AND s.status='approved'",[$uid])['total'];
    }
    if (str_contains($label,'popular')) {
        $order=str_contains($label,'least') ? 'ASC' : 'DESC';
        $row=one('SELECT c.title,COUNT(uc.user_id) AS total FROM challenges c LEFT JOIN user_challenges uc ON uc.challenge_id=c.id GROUP BY c.id ORDER BY total ' . $order . ',c.id LIMIT 1');
        return $row['title'] ?? '—';
    }
    if (str_contains($label,'completion rate')) {
        $join_count=one('SELECT COUNT(*) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id' . $where,$values)['total'];
        $complete_count=one("SELECT COUNT(DISTINCT s.user_id,s.challenge_id) AS total FROM submissions s JOIN users u ON u.id=s.user_id" . $where . ($where ? ' AND' : ' WHERE') . " s.status='approved'",$values)['total'];
        return ($join_count ? round(100*$complete_count/$join_count) : 0) . '%';
    }
    if (str_contains($label,'kg') || str_contains($label,'co2') || str_contains($label,'waste') || str_contains($label,'bottle') || str_contains($label,'plastic')) return 'Not measured';
    if (str_contains($label,'rank')) {
        if ($role === 'faculty') return faculty_rank(page_records('faculty-rankings'), $faculty) ?? '—';
        $ranking=page_records('rankings');
        foreach ($ranking as $index=>$person) if ((int)$person['id'] === (int)$uid) return $index+1;
        return '—';
    }
    if (str_contains($label,'point')) return one('SELECT COALESCE(SUM(p.points),0) AS total FROM point_transactions p JOIN users u ON u.id=p.user_id' . $where,$values)['total'];
    if (str_contains($label,'facult')) return one('SELECT COUNT(DISTINCT faculty) AS total FROM users')['total'];
    if (str_contains($label,'badge') || str_contains($label,'achievement')) {
        if($role==='admin')return one("SELECT COUNT(*) AS total FROM achievements WHERE status='active'")['total'];
        return count(array_filter(badge_collection($uid,$role==='faculty' ? $faculty : null),fn($card)=>$card['earned']));
    }
    if (str_contains($label,'completed') || str_contains($label,'approved') || str_contains($label,'action')) {
        return one("SELECT COUNT(*) AS total FROM submissions s JOIN users u ON u.id=s.user_id" . $where . ($where ? ' AND' : ' WHERE') . " s.status='approved'",$values)['total'];
    }
    if (str_contains($label,'review') || str_contains($label,'pending') || str_contains($label,'submission')) {
        return one("SELECT COUNT(*) AS total FROM submissions s JOIN users u ON u.id=s.user_id" . $where . ($where ? ' AND' : ' WHERE') . " s.status='pending'",$values)['total'];
    }
    if (str_contains($label,'challenge')) {
        if ($role === 'user') return one('SELECT COUNT(*) AS total FROM user_challenges WHERE user_id=?',[$uid])['total'];
        return one("SELECT COUNT(*) AS total FROM challenges WHERE status='open' AND start_date<=CURDATE() AND end_date>=CURDATE()")['total'];
    }
    if (str_contains($label,'particip') || str_contains($label,'member') || str_contains($label,'user') || str_contains($label,'account')) return one('SELECT COUNT(*) AS total FROM users u' . $where . ($where ? ' AND' : ' WHERE') . " u.status='active' AND u.role='user'",$values)['total'];
    return '—';
}
function faculty_rank(array $ranking, string $faculty): ?int {
    foreach ($ranking as $index => $row) {
        if ($row['faculty'] === $faculty) return $index + 1;
    }
    return null;
}

function faculty_join_period(string $period, ?DateTimeImmutable $today = null): array {
    $month = ($today ?? new DateTimeImmutable('today'))->modify('first day of this month');
    if ($period === 'this-month') return [$month->format('Y-m-d'), $month->modify('+1 month')->format('Y-m-d')];
    if ($period === 'last-month') return [$month->modify('-1 month')->format('Y-m-d'), $month->format('Y-m-d')];
    return [null, null];
}

function faculty_challenge_participation(string $faculty, string $period = 'all', int $challenge_id = 0): array {
    [$start, $end] = faculty_join_period($period);
    $conditions = ["u.faculty=?", "u.role='user'"];
    $params = [$faculty];
    if ($start) {
        $conditions[] = 'uc.joined_at>=? AND uc.joined_at<?';
        array_push($params, $start, $end);
    }
    if ($challenge_id) {
        $conditions[] = 'c.id=?';
        $params[] = $challenge_id;
    }
    return rows("SELECT c.id, c.title, COUNT(*) AS joined, SUM(EXISTS(
            SELECT 1 FROM submissions s
            WHERE s.user_id=uc.user_id AND s.challenge_id=uc.challenge_id AND s.status='approved'
        )) AS completed
        FROM user_challenges uc JOIN users u ON u.id=uc.user_id JOIN challenges c ON c.id=uc.challenge_id
        WHERE " . implode(' AND ', $conditions) . '
        GROUP BY c.id,c.title ORDER BY joined DESC,completed DESC,c.title,c.id', $params);
}

function completion_rate(int $completed, int $joined): string {
    return ($joined ? round(100 * $completed / $joined) : 0) . '%';
}

function faculty_participation($faculty_name) {
    $eligible=(int)one("SELECT COUNT(*) AS total FROM users WHERE role='user' AND status='active' AND faculty=?",[$faculty_name])['total'];
    $joined=(int)one("SELECT COUNT(DISTINCT uc.user_id) AS total FROM user_challenges uc JOIN users u ON u.id=uc.user_id WHERE u.role='user' AND u.status='active' AND u.faculty=?",[$faculty_name])['total'];
    return ['eligible'=>$eligible,'joined'=>$joined];
}
function active_participants_today() {
    return (int)one("SELECT COUNT(DISTINCT s.user_id) AS total
        FROM submissions s JOIN users u ON u.id=s.user_id
        WHERE u.role='user' AND s.created_at>=CURDATE()
        AND s.created_at<DATE_ADD(CURDATE(), INTERVAL 1 DAY)")['total'];
}

function recorded_impact() {
    return one("SELECT COUNT(*) AS actions, COUNT(DISTINCT s.user_id) AS participants,
        COALESCE(SUM(CASE WHEN c.tracked_item IN (?, ?) THEN s.quantity ELSE 0 END), 0) AS recyclables
        FROM submissions s JOIN challenges c ON c.id=s.challenge_id WHERE s.status='approved'",
        ['Plastic bottles', 'Aluminum cans']);
}

function activity_monthly_change($series) {
    $before = $series[count($series) - 3]['actions'] ?? 0;
    $latest = $series[count($series) - 2]['actions'] ?? 0;
    if ($before === 0) return 'No baseline';
    $change = round(100 * ($latest - $before) / $before);
    return ($change > 0 ? '+' : '') . $change . '%';
}

function calendar_series($rows,$today=null) {
    $counts=[];
    foreach($rows as $row)$counts[$row['period']]=(int)$row['actions'];
    $month=(new DateTimeImmutable($today ?? 'today'))->modify('first day of this month')->modify('-5 months');
    $series=[];
    for($i=0;$i<6;$i++) {
        $period=$month->modify('+'.$i.' months')->format('Y-m');
        $series[]=['period'=>$period,'actions'=>$counts[$period] ?? 0];
    }
    return $series;
}
