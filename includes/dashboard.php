<?php
function show_active_challenge() {
    global $uid;
    $challenge=one("SELECT c.*,(SELECT COUNT(*) FROM submissions s WHERE s.challenge_id=c.id AND s.user_id=? AND s.status IN ('pending','approved')) AS used FROM challenges c JOIN user_challenges uc ON uc.challenge_id=c.id WHERE uc.user_id=? AND c.status='open' AND c.start_date<=CURDATE() AND c.end_date>=CURDATE() HAVING used<submission_limit ORDER BY uc.joined_at DESC,c.id DESC LIMIT 1",[$uid,$uid]);
    if(!$challenge) {echo '<p>No joined challenge is currently accepting more evidence.</p>';return;}
    echo '<h3>'.e($challenge['title']).'</h3><p>'.e($challenge['completion_requirement']).'</p><p class="field-hint">'.(int)$challenge['used'].' / '.(int)$challenge['submission_limit'].' submissions used</p>';
    echo '<a class="text-link" href="'.e(route_url('user/submit-evidence-new-submission.php?challenge_id='.$challenge['id'])).'">Submit evidence</a>';
}
function show_next_milestone() {
    global $uid;
    $targets=[];
    foreach(badge_collection($uid) as $card) {
        if(!$card['next_badge'])continue;
        $rules=$card['next_progress']['rules'];$percent=100;
        foreach($rules as $rule)$percent=min($percent,100*$rule['progress']/max(1,$rule['required_count']));
        $targets[]=['badge'=>$card['next_badge'],'rules'=>$rules,'percent'=>min(100,$percent)];
    }
    if(!$targets) {echo '<p>All currently available badge levels have been earned.</p>';return;}
    usort($targets,fn($a,$b)=>$b['percent']<=>$a['percent']);
    $target=$targets[0];
    echo '<h3>'.e($target['badge']['name'].' '.tier_label($target['badge'])).'</h3>';
    foreach($target['rules'] as $rule)echo '<p>'.e($rule['item']).': '.(int)$rule['progress'].' / '.(int)$rule['required_count'].'</p>';
    echo '<progress value="'.(int)$target['percent'].'" max="100" aria-label="Next badge level progress">Progress</progress>';
}
function show_recent_activity() {
    global $uid;
    $activities=rows('SELECT s.*,c.title FROM submissions s JOIN challenges c ON c.id=s.challenge_id WHERE s.user_id=? ORDER BY s.created_at DESC,s.id DESC LIMIT 5',[$uid]);
    if(!$activities) {echo '<li><strong>No activity recorded yet.</strong></li>';return;}
    foreach($activities as $activity) {
        echo '<li><strong>'.e($activity['title']).'</strong><p>'.e(ucfirst(str_replace('-',' ',$activity['status']))).' · '.(int)$activity['points_awarded'].' points</p><small>'.e(date('d M Y',strtotime($activity['created_at']))).'</small></li>';
    }
}
function show_activity_periods() {
    $periods=[
        'Daily'=>"SELECT DATE(created_at) AS period,COUNT(*) AS total FROM submissions WHERE status='approved' AND created_at>=DATE_SUB(CURDATE(),INTERVAL 6 DAY) GROUP BY period ORDER BY period DESC",
        'Weekly'=>"SELECT DATE_FORMAT(created_at,'%x-W%v') AS period,COUNT(*) AS total FROM submissions WHERE status='approved' AND created_at>=DATE_SUB(CURDATE(),INTERVAL 41 DAY) GROUP BY period ORDER BY period DESC"
    ];
    foreach($periods as $label=>$sql) {
        echo '<h3>'.e($label).' approved activity</h3><table class="data-table"><thead><tr><th>Period</th><th>Approved submissions</th></tr></thead><tbody>';
        $records=rows($sql);
        if(!$records)echo '<tr><td colspan="2">No approved activity in this period.</td></tr>';
        foreach($records as $record)echo '<tr><td>'.e($record['period']).'</td><td>'.(int)$record['total'].'</td></tr>';
        echo '</tbody></table>';
    }
}
