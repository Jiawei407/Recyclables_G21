<?php
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/includes/permissions.php';

final class AdminWorkflowRulesTest extends TestCase
{
    public function testExistingPermissionsDefaultToCurrentRoleRights(): void
    {
        self::assertTrue(user_has_permission(['role'=>'faculty'], 'create-activities'));
        self::assertTrue(user_has_permission(['role'=>'coordinator'], 'review-submissions'));
        self::assertTrue(user_has_permission(['role'=>'admin'], 'reverse-submission-points'));
        self::assertFalse(user_has_permission(['role'=>'faculty'], 'manage-users'));
        self::assertFalse(user_has_permission(['role'=>'user','can_join'=>0], 'join-challenges'));
        self::assertTrue(user_has_permission(['role'=>'user','can_submit'=>1], 'submit-evidence'));
    }

    public function testOnlyTheChosenPermissionsAreStoredAsDisabled(): void
    {
        $disabled = disabled_role_permissions('faculty', ['feature-challenges','publish-announcements','submit-reports']);
        self::assertSame(['create-activities'], $disabled);
        $representative = ['role'=>'faculty','disabled_permissions'=>implode(',', $disabled)];
        self::assertFalse(user_has_permission($representative, 'create-activities'));
        self::assertTrue(user_has_permission($representative, 'submit-reports'));
        self::assertSame(array_keys(role_permissions('faculty')), disabled_role_permissions('faculty', []));
    }

    public function testUnrelatedRolePermissionsCannotBeGranted(): void
    {
        $this->expectException(InvalidArgumentException::class);
        disabled_role_permissions('faculty', ['manage-users']);
    }

    public function testDelegatedAdministratorsCannotManageOtherAdministratorAccounts(): void
    {
        self::assertTrue(can_manage_admin_accounts(['role'=>'admin']));
        $delegate = ['role'=>'admin','disabled_permissions'=>'manage-achievements'];
        self::assertTrue(user_has_permission($delegate, 'manage-users'));
        self::assertFalse(can_manage_admin_accounts($delegate));
        self::assertFalse(can_manage_admin_accounts(['role'=>'coordinator']));
    }

    public function testOnlyAnApprovedSubmissionCreditCanBeReversed(): void
    {
        $award = ['status'=>'approved','points'=>18,'submission_id'=>90,'reverses_id'=>null];
        self::assertSame(18, reversible_submission_points($award));
        self::assertSame(0, reversible_submission_points(array_replace($award, ['status'=>'rejected'])));
        self::assertSame(0, reversible_submission_points(array_replace($award, ['submission_id'=>null])));
        self::assertSame(0, reversible_submission_points(array_replace($award, ['reverses_id'=>17,'points'=>-18])));
        self::assertSame(0, reversible_submission_points(array_replace($award, ['points'=>0])));
    }
}
