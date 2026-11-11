<?php

$chart_kind=$chart_kind ?? 'actions-by-month';
$chart_title=$chart_kind==='participants-by-month' ? 'Active participants by month' : 'Approved activities by month';
$series=$chart_series ?? calendar_series(page_records($chart_kind));
if (!array_sum(array_column($series, 'actions'))) {
    echo '<svg class="line-chart" viewBox="0 0 420 170" role="img" aria-label="No approved activities"><text x="210" y="85" text-anchor="middle" fill="currentColor">No approved activities yet</text></svg>';
} else {
    $maximum=max(array_column($series,'actions')) ?: 1;
    echo '<svg class="line-chart" viewBox="0 0 420 170" role="img" aria-label="'.e($chart_title).'"><title>'.e($chart_title).'</title>';
    echo '<path d="M18 130H402" stroke="currentColor" opacity="0.35"></path>';
    foreach ($series as $index=>$point) {
        $x=18+($index+0.5)*(384/count($series));
        $height=100*$point['actions']/$maximum;
        $month=DateTimeImmutable::createFromFormat('!Y-m', $point['period'])->format('M');
        echo '<rect x="' . ($x-18) . '" y="' . (130-$height) . '" width="36" height="' . $height . '" fill="currentColor" opacity="0.65"></rect>';
        echo '<text x="' . $x . '" y="153" text-anchor="middle" font-size="17" fill="currentColor">' . e($month) . '</text>';
        echo '<text x="' . $x . '" y="' . (123-$height) . '" text-anchor="middle" font-size="17" fill="currentColor">' . (int)$point['actions'] . '</text>';
    }
    echo '</svg>';
}
