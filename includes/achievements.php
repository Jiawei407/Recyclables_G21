<?php
$is_faculty=$role==='faculty';
if($role==='admin') {
    $cards=[];
    foreach(rows('SELECT * FROM achievements ORDER BY family_key,tier,id') as $badge) {
        $progress=achievement_progress($badge['id'],$uid);
        $cards[]=['badge'=>$badge,'progress'=>$progress,'earned'=>$progress['earned'],'next_badge'=>null,'next_progress'=>null];
    }
} else {$cards=badge_collection($uid,$is_faculty ? $faculty : null);}
$shown=0;
foreach($cards as $card) {
    $badge=$card['badge'];$progress=$card['progress'];$earned=$card['earned'];
    if(str_contains($section,'earned') && !$earned)continue;
    if(str_contains($section,'locked') && $earned)continue;
    $shown++;
    $next=$card['next_badge'];
    $rules=$earned && $next ? $card['next_progress']['rules'] : $progress['rules'];
    $tier=tier_label($badge);
?>
<article class="badge-card <?= $tier ? 'tier-'.e($badge['tier']) : '' ?> <?= !$earned && $role!=='admin' ? 'is-locked' : '' ?>" data-record data-badge-family="<?= e($badge['family_key']) ?>" data-badge-tier="<?= e($badge['tier']) ?>">
  <?php if($badge['image']): ?><img src="<?= e($base) ?>/file.php?type=achievement&amp;id=<?= (int)$badge['id'] ?>" alt="" width="80" height="80"><?php else: ?><svg class="heading-icon badge-symbol" aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="8" r="5"></circle><path d="m8 12-1 9 5-3 5 3-1-9"></path></svg><?php endif; ?>
  <h3><?= e($badge['name']) ?></h3>
  <?php if($tier): ?><span class="badge-tier"><?= e($tier) ?></span><?php endif; ?>
  <?php if($is_faculty): ?><p class="field-hint">Collective student progress: <?= e($faculty) ?></p><?php endif; ?>
  <p><?= $role==='admin' ? e($badge['status']) : ($earned ? ($is_faculty ? 'Faculty target met' : 'Earned') : 'In progress') ?></p>
  <?php if($role!=='admin' && $earned && $next): ?><p class="field-hint">Next level: <?= e(tier_label($next)) ?></p><?php endif; ?>
  <?php if($role!=='admin' && $earned && !$next && $tier): ?><p class="field-hint">Highest available level reached.</p><?php endif; ?>
  <?php foreach($rules as $rule): ?>
  <p><?= e($rule['item']) ?>: <?= (int)$rule['progress'] ?> / <?= (int)$rule['required_count'] ?> (<?= e($rule['condition_name']) ?>)</p>
  <?php if($role!=='admin'): ?><progress value="<?= min((int)$rule['progress'],(int)$rule['required_count']) ?>" max="<?= max(1,(int)$rule['required_count']) ?>" aria-label="<?= e($badge['name'].' '.$rule['item']) ?>">Progress</progress><?php endif; ?>
  <?php endforeach; ?>
  <?php if($role==='admin'): ?><a class="text-link" href="<?= e($base) ?>/admin/achievements.php?view=achievements-edit&amp;id=<?= (int)$badge['id'] ?>">Edit achievement</a><?php endif; ?>
</article>
<?php }
if(!$shown)echo '<article class="badge-card"><h3>No achievements to display.</h3></article>';
