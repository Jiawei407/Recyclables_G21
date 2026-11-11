<?php

use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/includes/metrics.php';

final class FacultyParticipationTest extends TestCase
{
    public function testFacultyRankUsesTheFacultyLeaderboardOrder(): void
    {
        $ranking = [
            ['faculty' => 'School of Engineering', 'points' => 120],
            ['faculty' => 'School of Computing', 'points' => 80],
            ['faculty' => 'School of Business', 'points' => 75],
        ];
        self::assertSame(2, faculty_rank($ranking, 'School of Computing'));
        self::assertNull(faculty_rank($ranking, 'School of Media'));
    }

    public function testJoinPeriodHasExclusiveEndAndWorksAcrossYears(): void
    {
        $today = new DateTimeImmutable('2027-01-15');
        self::assertSame(['2027-01-01', '2027-02-01'], faculty_join_period('this-month', $today));
        self::assertSame(['2026-12-01', '2027-01-01'], faculty_join_period('last-month', $today));
        self::assertSame([null, null], faculty_join_period('all', $today));
    }

    public function testCompletionRateHandlesEmptyCohortsAndRounds(): void
    {
        self::assertSame('0%', completion_rate(0, 0));
        self::assertSame('67%', completion_rate(2, 3));
        self::assertSame('100%', completion_rate(4, 4));
    }
}
