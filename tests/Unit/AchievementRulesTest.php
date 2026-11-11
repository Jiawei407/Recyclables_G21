<?php
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/includes/badges.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

final class AchievementRulesTest extends TestCase
{
    public function testFixedMeasuresPreserveCountingSemantics(): void
    {
        self::assertSame([
            'Approved activity' => 'submissions',
            'Plastic bottles' => 'quantity',
            'Aluminum cans' => 'quantity',
            'Reusable cup' => 'quantity',
            'Campus cleanup' => 'submissions',
        ], achievement_measures());
        self::assertSame([10, 'Aluminum cans', 'At least', null], achievement_rule('10', 'Aluminum cans', 'At least', ''));
        self::assertSame([2, 'Approved activity', 'Exactly', 27], achievement_rule('2', 'specific-challenge', 'Exactly', '27'));
        self::assertNull(achievement_rule('', '', '', ''));
        self::assertTrue(achievement_count_met('At least', 12, 10));
        self::assertTrue(achievement_count_met('Exactly', 10, 10));
        self::assertFalse(achievement_count_met('Exactly', 12, 10));
    }

    /** @dataProvider invalidRules */
    public function testInvalidRequirementsAreRejected(string $count, string $measure, string $condition, string $challenge): void
    {
        $this->expectException(InvalidArgumentException::class);
        achievement_rule($count, $measure, $condition, $challenge);
    }

    public function invalidRules(): array
    {
        return [
            ['0', 'Plastic bottles', 'At least', ''],
            ['3.5', 'Aluminum cans', 'At least', ''],
            ['2', 'Other items', 'At least', ''],
            ['2', 'Campus cleanup', 'At most', ''],
            ['2', 'specific-challenge', 'At least', ''],
            ['', '', '', '27'],
        ];
    }

    public function testStandaloneBadgeClearsFamilyAndRemainsIndependent(): void
    {
        self::assertSame(['', 'bronze'], badge_identity('standalone', 'former-family', 'gold'));
        self::assertSame(['can-recycler', 'silver'], badge_identity('tiered', 'Can-Recycler', 'silver'));
        $progress = ['earned' => true];
        $cards = highest_badges([
            ['id' => 1, 'family_key' => '', 'tier' => 'bronze', 'progress' => $progress],
            ['id' => 2, 'family_key' => 'single-1', 'tier' => 'bronze', 'progress' => $progress],
        ]);
        self::assertCount(2, $cards);
        self::assertSame('', tier_label($cards[0]['badge']));
        self::assertSame('Bronze', tier_label($cards[1]['badge']));
    }

    public function testTieredBadgeRequiresFamily(): void
    {
        $this->expectException(InvalidArgumentException::class);
        badge_identity('tiered', '', 'bronze');
    }

    public function testBadgeImageRejectsUndersizedAndCorruptFiles(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'badge-');
        try {
            file_put_contents($path, 'Invalid image contents');
            self::assertStringContainsString('valid, complete', badge_image_error($path));

            if (!extension_loaded('gd')) {
                $this->markTestSkipped('Enable GD to test full image decoding.');
            }

            imagepng(imagecreatetruecolor(127, 128), $path);
            self::assertStringContainsString('128 and 2048 pixels', badge_image_error($path));
            imagepng(imagecreatetruecolor(128, 2049), $path);
            self::assertStringContainsString('128 and 2048 pixels', badge_image_error($path));

            imagepng(imagecreatetruecolor(128, 128), $path);
            self::assertSame('', badge_image_error($path));
            $png = file_get_contents($path);
            $idat = strpos($png, 'IDAT');
            $length = unpack('N', substr($png, $idat - 4, 4))[1];
            $crc = $idat + 4 + $length;
            $png[$crc] = $png[$crc] ^ "\x01";
            file_put_contents($path, $png);
            self::assertStringContainsString('valid, complete', badge_image_error($path));

            imagejpeg(imagecreatetruecolor(128, 128), $path);
            self::assertSame('', badge_image_error($path));
            $jpeg = file_get_contents($path);
            file_put_contents($path, substr($jpeg, 0, -20) . "\xff\xd9");
            self::assertStringContainsString('valid, complete', badge_image_error($path));
        } finally {
            unlink($path);
        }
    }
}
