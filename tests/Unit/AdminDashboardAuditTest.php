<?php

use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/includes/audit.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/includes/metrics.php';

final class AdminDashboardAuditTest extends TestCase
{
    public function testMonthlyChartFillsGapsAndReportsZeroAsAnEmptyChart(): void
    {
        $chart_kind = 'participants-by-month';
        $chart_series = calendar_series([['period' => '2026-09', 'actions' => '4']], '2026-11-11');
        self::assertSame(['2026-06', '2026-07', '2026-08', '2026-09', '2026-10', '2026-11'], array_column($chart_series, 'period'));
        self::assertSame([0, 0, 0, 4, 0, 0], array_column($chart_series, 'actions'));

        ob_start();
        include dirname(__DIR__, 2) . '/includes/chart.php';
        $chart = ob_get_clean();
        self::assertStringContainsString('Active participants by month', $chart);
        self::assertStringContainsString('>4</text>', $chart);

        $chart_series = calendar_series([], '2026-11-11');
        ob_start();
        include dirname(__DIR__, 2) . '/includes/chart.php';
        self::assertStringContainsString('No approved activities yet', ob_get_clean());
    }

    public function testMonthlyChangeUsesCompleteMonthsAndRecognizesMissingBaseline(): void
    {
        $months = [['period'=>'2026-09', 'actions'=>4], ['period'=>'2026-10', 'actions'=>6], ['period'=>'2026-11', 'actions'=>1]];
        self::assertSame('+50%', activity_monthly_change(calendar_series($months, '2026-11-11')));
        self::assertSame('No baseline', activity_monthly_change(calendar_series(array_slice($months, 1), '2026-11-11')));
        self::assertSame('-100%', activity_monthly_change(calendar_series(array_slice($months, 0, 1), '2026-11-11')));
        self::assertSame('No baseline', activity_monthly_change(calendar_series([], '2026-11-11')));
    }

    public function testAuditFiltersCombineBoundValuesAndIncludeTheEndDate(): void
    {
        $filters = audit_filter_values([
            'from'=>'2026-11-03', 'to'=>'2026-11-11', 'audit-user'=>"name:O'Neil",
            'audit-role'=>'admin', 'audit-action'=>'user-suspended', 'audit-search'=>'account',
        ]);
        [$where, $params] = audit_where($filters, 'a.actor_name', 'a.actor_role');
        self::assertStringContainsString("a.action NOT LIKE 'test-%'", $where);
        self::assertStringContainsString('a.created_at >= ? AND a.created_at < DATE_ADD(?, INTERVAL 1 DAY)', $where);
        self::assertStringContainsString('a.actor_id IS NULL AND a.actor_name = ? AND a.actor_role = ? AND a.action IN (?,?)', $where);
        self::assertStringNotContainsString("O'Neil", $where);
        self::assertSame(['2026-11-03', '2026-11-11', "O'Neil", 'admin', 'user-suspended', 'suspend-user', 'account', 'account', 'account'], $params);
    }

    public function testAuditUserOptionsDistinguishLiveAccountsWithTheSameName(): void
    {
        $options = audit_user_options([
            ['actor_id'=>21, 'display_name'=>'Alex'],
            ['actor_id'=>38, 'display_name'=>'Alex'],
            ['actor_id'=>null, 'display_name'=>'Alex'],
        ]);
        self::assertSame(['id:21'=>'Alex (user #21)', 'id:38'=>'Alex (user #38)', 'name:Alex'=>'Alex (former user)'], $options);
        [$where, $params] = audit_where(audit_filter_values(['audit-user'=>'id:38']), 'a.actor_name', 'a.actor_role');
        self::assertStringContainsString('a.actor_id = ?', $where);
        self::assertSame(['38'], $params);
    }

    public function testAuditFiltersDiscardMalformedDateAndRoleInputs(): void
    {
        $filters = audit_filter_values(['from'=>'2026-02-31', 'to'=>['2026-03-01'], 'audit-role'=>'deleted']);
        self::assertSame('', $filters['from']);
        self::assertSame('', $filters['to']);
        self::assertSame('', $filters['audit-role']);
        [$where, $params] = audit_where($filters, 'a.actor_name', 'a.actor_role');
        self::assertSame("a.action NOT LIKE 'test-%'", $where);
        self::assertSame([], $params);
    }

    public function testAuditSentencesTranslateLegacyDetailsAndKeepNewSentences(): void
    {
        self::assertSame('Deducted 18 Green Points from user #7.', audit_action_text([
            'action'=>'points-deduct', 'details'=>'User #7; deducted=18; Review note',
        ]));
        self::assertSame('Approved submission #21 and awarded 12 Green Points.', audit_action_text([
            'action'=>'evidence-approved', 'details'=>'Submission #21; 12 points. Approval note',
        ]));
        $rejection = 'Rejected submission #21 for Alex and deducted 12 Green Points.';
        self::assertSame($rejection, audit_action_text(['action'=>'submission-rejected', 'details'=>$rejection]));
        self::assertSame('Not recorded', audit_role_label(''));
    }
}
