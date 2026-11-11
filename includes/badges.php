<?php
function badge_rank($tier) {
    return ['bronze'=>1,'silver'=>2,'gold'=>3][$tier] ?? 0;
}
function highest_badges($badges) {
    $families=[];
    foreach($badges as $badge) {
        $key=$badge['family_key'] === '' ? 'badge:'.$badge['id'] : 'family:'.$badge['family_key'];
        $families[$key][]=$badge;
    }
    $cards=[];
    foreach($families as $levels) {
        usort($levels,fn($a,$b)=>badge_rank($a['tier'])<=>badge_rank($b['tier']) ?: $a['id']<=>$b['id']);
        $chosen=0;$earned=false;
        foreach($levels as $index=>$level) {
            if($level['progress']['earned']) {$chosen=$index;$earned=true;}
        }
        $next=$earned ? ($levels[$chosen+1] ?? null) : $levels[0];
        $cards[]=['badge'=>$levels[$chosen],'progress'=>$levels[$chosen]['progress'],'earned'=>$earned,'next_badge'=>$next,'next_progress'=>$next['progress'] ?? null];
    }
    return $cards;
}
function badge_collection($user_id,$faculty_name=null) {
    $badges=rows("SELECT * FROM achievements WHERE status='active' ORDER BY id");
    foreach($badges as &$badge) {
        $badge['progress']=achievement_progress($badge['id'],$user_id,$faculty_name);
    }
    unset($badge);
    return highest_badges($badges);
}
function tier_label($badge) {
    return $badge['family_key'] === '' ? '' : ucfirst($badge['tier']);
}
