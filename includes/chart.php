<?php

$chart_kind=$chart_kind ?? 'actions-by-month';
$chart_title=$chart_kind==='participants-by-month' ? 'Active participants by month' : 'Approved activities by month';
$series=calendar_series(page_records($chart_kind));
if (!$series) {
    echo '<svg class="line-chart" viewBox="0 0 600 190" role="img" aria-label="No approved activities"><text x="300" y="95" text-anchor="middle" fill="currentColor">No approved activities yet</text></svg>';
} else {
    $maximum=max(array_column($series,'actions')) ?: 1;
    echo '<svg class="line-chart" viewBox="0 0 600 190" role="img" aria-label="'.e($chart_title).'"><title>'.e($chart_title).'</title>';
    foreach ($series as $index=>$point) {
        $x=30+$index*(540/count($series));
        $height=120*$point['actions']/$maximum;
        echo '<rect x="' . $x . '" y="' . (145-$height) . '" width="40" height="' . $height . '" fill="currentColor" opacity="0.65"></rect>';
        echo '<text x="' . $x . '" y="170" font-size="12" fill="currentColor">' . e($point['period']) . '</text>';
        echo '<text x="' . $x . '" y="' . (135-$height) . '" font-size="12" fill="currentColor">' . (int)$point['actions'] . '</text>';
    }
    echo '</svg>';
}
