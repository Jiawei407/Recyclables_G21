<?php
function screen_routes() {
    return [
        'user/achievements-earned.php' => 'user/account.php?view=achievements-earned',
        'user/achievements-locked.php' => 'user/account.php?view=achievements-locked',
        'user/achievements-recycling-helper.php' => 'user/account.php?view=achievements-recycling-helper',
        'user/challenges-browse.php' => 'user/challenges.php?view=challenges-browse',
        'user/challenges-completed.php' => 'user/challenges.php?view=challenges-completed',
        'user/challenges-my-challenges.php' => 'user/challenges.php?view=challenges-my-challenges',
        'user/challenges-view-challenge.php' => 'user/challenges.php?view=challenges-view-challenge',
        'user/home.php' => 'user/home.php?view=overview',
        'user/leaderboard-faculty-ranking.php' => 'user/account.php?view=leaderboard-faculty-ranking',
        'user/leaderboard-individual-ranking.php' => 'user/account.php?view=leaderboard-individual-ranking',
        'user/profile-change-password-validation.php' => 'user/account.php?view=profile-change-password-validation',
        'user/profile-change-password.php' => 'user/account.php?view=profile-change-password',
        'user/profile-edit-details.php' => 'user/account.php?view=profile-edit-details',
        'user/profile-profile.php' => 'user/account.php?view=profile-profile',
        'user/submit-evidence-new-submission.php' => 'user/evidence.php?view=submit-evidence-new-submission',
        'user/submit-evidence-submission-details.php' => 'user/evidence.php?view=submit-evidence-submission-details',
        'user/submit-evidence-submission-status.php' => 'user/evidence.php?view=submit-evidence-submission-status',
        'user/submit-evidence-upload-failed.php' => 'user/evidence.php?view=submit-evidence-upload-failed',
        'user/submit-evidence-upload-photo.php' => 'user/evidence.php?view=submit-evidence-upload-photo',
        'faculty/announcements-announcements.php' => 'faculty/announcements.php?view=announcements-announcements',
        'faculty/announcements-create.php' => 'faculty/announcements.php?view=announcements-create',
        'faculty/announcements-edit.php' => 'faculty/announcements.php?view=announcements-edit',
        'faculty/faculty-activities-create-activity.php' => 'faculty/challenges.php?view=faculty-activities-create-activity',
        'faculty/faculty-activities-faculty-cleanup.php' => 'faculty/challenges.php?view=faculty-activities-faculty-cleanup',
        'faculty/faculty-activities-proposed-activities.php' => 'faculty/challenges.php?view=faculty-activities-proposed-activities',
        'faculty/home.php' => 'faculty/home.php?view=overview',
        'faculty/insights-achievements.php' => 'faculty/home.php?view=insights-achievements',
        'faculty/insights-leaderboard.php' => 'faculty/home.php?view=insights-leaderboard',
        'faculty/insights-overview.php' => 'faculty/home.php?view=insights-overview',
        'faculty/insights-reports.php' => 'faculty/home.php?view=insights-reports',
        'faculty/participation-campus-cleanup.php' => 'faculty/home.php?view=participation-campus-cleanup',
        'faculty/participation-challenge-participation.php' => 'faculty/home.php?view=participation-challenge-participation',
        'faculty/participation-completion-rates.php' => 'faculty/home.php?view=participation-completion-rates',
        'faculty/promote-challenges-available-challenges.php' => 'faculty/challenges.php?view=promote-challenges-available-challenges',
        'faculty/promote-challenges-feature-challenge.php' => 'faculty/challenges.php?view=promote-challenges-feature-challenge',
        'faculty/promote-challenges-featured-for-faculty.php' => 'faculty/challenges.php?view=promote-challenges-featured-for-faculty',
        'faculty/submit-report-activity-report.php' => 'faculty/reports.php?view=submit-report-activity-report',
        'faculty/submit-report-reports.php' => 'faculty/reports.php?view=submit-report-reports',
        'faculty/submit-report-submit-report.php' => 'faculty/reports.php?view=submit-report-submit-report',
        'coordinator/analytics.php' => 'coordinator/home.php?view=analytics',
        'coordinator/announcements-all-announcements.php' => 'coordinator/manage.php?view=announcements-all-announcements',
        'coordinator/announcements-create.php' => 'coordinator/manage.php?view=announcements-create',
        'coordinator/announcements-edit.php' => 'coordinator/manage.php?view=announcements-edit',
        'coordinator/campaigns-campaigns.php' => 'coordinator/manage.php?view=campaigns-campaigns',
        'coordinator/campaigns-create.php' => 'coordinator/manage.php?view=campaigns-create',
        'coordinator/campaigns-edit.php' => 'coordinator/manage.php?view=campaigns-edit',
        'coordinator/campaigns-performance.php' => 'coordinator/manage.php?view=campaigns-performance',
        'coordinator/challenges-all-challenges.php' => 'coordinator/manage.php?view=challenges-all-challenges',
        'coordinator/challenges-create-upload-photo.php' => 'coordinator/manage.php?view=challenges-create-upload-photo',
        'coordinator/challenges-create.php' => 'coordinator/manage.php?view=challenges-create',
        'coordinator/challenges-edit-upload-photo.php' => 'coordinator/manage.php?view=challenges-edit-upload-photo',
        'coordinator/challenges-edit.php' => 'coordinator/manage.php?view=challenges-edit',
        'coordinator/home.php' => 'coordinator/home.php?view=overview',
        'coordinator/profile-change-password.php' => 'coordinator/account.php?view=profile-change-password',
        'coordinator/profile-manage-account.php' => 'coordinator/account.php?view=profile-manage-account',
        'coordinator/submissions-approved.php' => 'coordinator/submissions.php?view=submissions-approved',
        'coordinator/submissions-needs-revision.php' => 'coordinator/submissions.php?view=submissions-needs-revision',
        'coordinator/submissions-pending.php' => 'coordinator/submissions.php?view=submissions-pending',
        'coordinator/submissions-rejected.php' => 'coordinator/submissions.php?view=submissions-rejected',
        'coordinator/submissions-review-submission.php' => 'coordinator/submissions.php?view=submissions-review-submission',
        'admin/achievements-achievements.php' => 'admin/achievements.php?view=achievements-achievements',
        'admin/achievements-create-upload-badge.php' => 'admin/achievements.php?view=achievements-create-upload-badge',
        'admin/achievements-create.php' => 'admin/achievements.php?view=achievements-create',
        'admin/achievements-edit-upload-badge.php' => 'admin/achievements.php?view=achievements-edit-upload-badge',
        'admin/achievements-edit.php' => 'admin/achievements.php?view=achievements-edit',
        'admin/audit-log-audit-details.php' => 'admin/home.php?view=audit-log-audit-details',
        'admin/audit-log.php' => 'admin/home.php?view=audit-log',
        'admin/challenge-balancing-delete-challenge.php' => 'admin/manage.php?view=challenge-balancing-delete-challenge',
        'admin/challenge-balancing-upload-challenge-photo.php' => 'admin/manage.php?view=challenge-balancing-upload-challenge-photo',
        'admin/challenge-balancing.php' => 'admin/manage.php?view=challenge-balancing',
        'admin/home.php' => 'admin/home.php?view=overview',
        'admin/impact-analytics.php' => 'admin/home.php?view=impact-analytics',
        'admin/leaderboard-point-corrections.php' => 'admin/manage.php?view=leaderboard-point-corrections',
        'admin/leaderboard-review-user-points.php' => 'admin/manage.php?view=leaderboard-review-user-points',
        'admin/leaderboard-view-rankings.php' => 'admin/manage.php?view=leaderboard-view-rankings',
        'admin/reports-faculty-report.php' => 'admin/home.php?view=reports-faculty-report',
        'admin/reports-faculty-reports.php' => 'admin/home.php?view=reports-faculty-reports',
        'admin/users-create-user.php' => 'admin/users.php?view=users-create-user',
        'admin/users-delete-user.php' => 'admin/users.php?view=users-delete-user',
        'admin/users-edit-user.php' => 'admin/users.php?view=users-edit-user',
        'admin/users-suspend-user.php' => 'admin/users.php?view=users-suspend-user',
        'admin/users-users.php' => 'admin/users.php?view=users-users',
    ];
}
function route_url($path) {
    global $base;
    $parts=explode('?',ltrim($path,'/'),2);
    $routes=screen_routes();
    $target=$routes[$parts[0]] ?? $parts[0];
    if (!empty($parts[1])) $target.=(str_contains($target,'?') ? '&' : '?').$parts[1];
    return $base.'/'.$target;
}
function screen_page($screens,$default) {
    $view=$_GET['view'] ?? $default;
    if (!is_string($view) || !isset($screens[$view])) {
        http_response_code(404);
        exit('Page not found.');
    }
    $GLOBALS['view']=$view;
    return $screens[$view];
}
