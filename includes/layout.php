<?php
require_once __DIR__.'/dashboard.php';
function page_start($title,$location,$dialog=false) {
    global $user,$base,$role,$section;
?>
<!DOCTYPE html>
<html lang="en" class="workspace-page">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title) ?> — Recyclables</title>
  <link rel="icon" href="../assets/brand-mark.svg" type="image/svg+xml">
  <link rel="stylesheet" href="../styles.css">
  <link rel="stylesheet" href="../assets/finishing.css?v=tiers-1">
</head>
<body<?= $dialog ? '' : ' class="app-shell"' ?>>
<a class="skip-link" href="<?= $dialog ? '#dialog-title' : '#main-content' ?>">Skip to content</a>
<?php if ($dialog): ?><div class="app-shell" inert><?php endif; ?>
<?php switch($role) {
case 'user': ?>
<aside class="app-sidebar" aria-label="Registered User workspace">
      <a class="brand" href="../index.php">
        <img src="../assets/brand-mark.svg" alt="" width="32" height="32">
        <span>recyclables.</span>
      </a>
      <div class="sidebar-context">
        <span class="eyebrow">Your workspace</span>
        <strong>Registered User</strong>
      </div>
      <nav class="sidebar-nav" aria-label="Workspace navigation">
        <a class="sidebar-link<?= $section === 'home' ? ' is-active' : '' ?>" href="../user/home.php?view=overview">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="m3 10 9-7 9 7v10H3V10Zm6 10v-7h6v7"></path>
          </svg>
          <span>Home</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'challenges') ? ' is-active' : '' ?>" href="../user/challenges.php?view=challenges-browse">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
            <path d="m4 21 11-11"></path>
          </svg>
          <span>Challenges</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'submit') ? ' is-active' : '' ?>" href="../user/evidence.php?view=submit-evidence-new-submission">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M12 16V3m-5 5 5-5 5 5M4 16v5h16v-5"></path>
          </svg>
          <span>Submit Evidence</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'achievements') ? ' is-active' : '' ?>" href="../user/account.php?view=achievements-earned">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <circle cx="12" cy="8" r="5"></circle>
            <path d="m8 12-1 9 5-3 5 3-1-9"></path>
          </svg>
          <span>Achievements</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'leaderboard') ? ' is-active' : '' ?>" href="../user/account.php?view=leaderboard-individual-ranking">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M4 3v17h17M8 16v-4m5 4V7m5 9v-6"></path>
          </svg>
          <span>Leaderboard</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'profile') ? ' is-active' : '' ?>" href="../user/account.php?view=profile-profile">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v3m0 14v3M2 12h3m14 0h3M5 5l2 2m10 10 2 2M5 19l2-2M17 7l2-2"></path>
          </svg>
          <span>Profile</span>
        </a>
      </nav>
      <div class="sidebar-bottom">
        <a class="sidebar-back" href="../index.php">Back to public home</a>
      <form method="post"><?php echo csrf_field(); ?><input type="hidden" name="action" value="logout"><button class="button button--quiet" type="submit">Log out</button></form></div>
    </aside>
<?php break;
case 'faculty': ?>
<aside class="app-sidebar" aria-label="Faculty Representative workspace">
      <a class="brand" href="../index.php">
        <img src="../assets/brand-mark.svg" alt="" width="32" height="32">
        <span>recyclables.</span>
      </a>
      <div class="sidebar-context">
        <span class="eyebrow">Your workspace</span>
        <strong>Faculty Representative</strong>
      </div>
      <nav class="sidebar-nav" aria-label="Workspace navigation">
        <a class="sidebar-link<?= $section === 'home' ? ' is-active' : '' ?>" href="../faculty/home.php?view=overview">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="m3 10 9-7 9 7v10H3V10Zm6 10v-7h6v7"></path>
          </svg>
          <span>Home</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'participation') ? ' is-active' : '' ?>" href="../faculty/home.php?view=participation-challenge-participation">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <circle cx="9" cy="7" r="3"></circle>
            <path d="M3 20v-2a6 6 0 0 1 12 0v2M16 4a3 3 0 0 1 0 6m2 4a5 5 0 0 1 3 4v2"></path>
          </svg>
          <span>Participation</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'promote') ? ' is-active' : '' ?>" href="../faculty/challenges.php?view=promote-challenges-available-challenges">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
            <path d="m4 21 11-11"></path>
          </svg>
          <span>Promote Challenges</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'faculty') ? ' is-active' : '' ?>" href="../faculty/challenges.php?view=faculty-activities-proposed-activities">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <rect x="3" y="5" width="18" height="16" rx="3"></rect>
            <path d="M7 3v4m10-4v4M3 11h18"></path>
          </svg>
          <span>Faculty Activities</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'insights') ? ' is-active' : '' ?>" href="../faculty/home.php?view=insights-overview">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M4 3v17h17M8 16v-4m5 4V7m5 9v-6"></path>
          </svg>
          <span>Insights</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'announcements') ? ' is-active' : '' ?>" href="../faculty/announcements.php?view=announcements-announcements">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="m3 10 17-6v15L3 14v-4Zm4 5 2 6h4l-2-5"></path>
          </svg>
          <span>Announcements</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'submit') ? ' is-active' : '' ?>" href="../faculty/reports.php?view=submit-report-reports">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
          </svg>
          <span>Submit Report</span>
        </a>
      </nav>
      <div class="sidebar-bottom">
        <a class="sidebar-back" href="../index.php">Back to public home</a>
      <form method="post"><?php echo csrf_field(); ?><input type="hidden" name="action" value="logout"><button class="button button--quiet" type="submit">Log out</button></form></div>
    </aside>
<?php break;
case 'coordinator': ?>
<aside class="app-sidebar" aria-label="Sustainability Coordinator workspace">
      <a class="brand" href="../index.php">
        <img src="../assets/brand-mark.svg" alt="" width="32" height="32">
        <span>recyclables.</span>
      </a>
      <div class="sidebar-context">
        <span class="eyebrow">Your workspace</span>
        <strong>Sustainability Coordinator</strong>
      </div>
      <nav class="sidebar-nav" aria-label="Workspace navigation">
        <a class="sidebar-link<?= $section === 'home' ? ' is-active' : '' ?>" href="../coordinator/home.php?view=overview">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="m3 10 9-7 9 7v10H3V10Zm6 10v-7h6v7"></path>
          </svg>
          <span>Home</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'challenges') ? ' is-active' : '' ?>" href="../coordinator/manage.php?view=challenges-all-challenges">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4Z"></path>
            <path d="m4 21 11-11"></path>
          </svg>
          <span>Challenges</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'submissions') ? ' is-active' : '' ?>" href="../coordinator/submissions.php?view=submissions-pending">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="m5 12 4 4L19 6"></path>
          </svg>
          <span>Submissions</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'campaigns') ? ' is-active' : '' ?>" href="../coordinator/manage.php?view=campaigns-campaigns">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <rect x="3" y="5" width="18" height="16" rx="3"></rect>
            <path d="M7 3v4m10-4v4M3 11h18"></path>
          </svg>
          <span>Campaigns</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'announcements') ? ' is-active' : '' ?>" href="../coordinator/manage.php?view=announcements-all-announcements">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="m3 10 17-6v15L3 14v-4Zm4 5 2 6h4l-2-5"></path>
          </svg>
          <span>Announcements</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'analytics') ? ' is-active' : '' ?>" href="../coordinator/home.php?view=analytics">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M4 3v17h17M8 16v-4m5 4V7m5 9v-6"></path>
          </svg>
          <span>Analytics</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'profile') ? ' is-active' : '' ?>" href="../coordinator/account.php?view=profile-manage-account">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v3m0 14v3M2 12h3m14 0h3M5 5l2 2m10 10 2 2M5 19l2-2M17 7l2-2"></path>
          </svg>
          <span>Profile</span>
        </a>
      </nav>
      <div class="sidebar-bottom">
        <a class="sidebar-back" href="../index.php">Back to public home</a>
      <form method="post"><?php echo csrf_field(); ?><input type="hidden" name="action" value="logout"><button class="button button--quiet" type="submit">Log out</button></form></div>
    </aside>
<?php break;
case 'admin': ?>
<aside class="app-sidebar" aria-label="Administrator workspace">
      <a class="brand" href="../index.php">
        <img src="../assets/brand-mark.svg" alt="" width="32" height="32">
        <span>recyclables.</span>
      </a>
      <div class="sidebar-context">
        <span class="eyebrow">Your workspace</span>
        <strong>Administrator</strong>
      </div>
      <nav class="sidebar-nav" aria-label="Workspace navigation">
        <a class="sidebar-link<?= $section === 'home' ? ' is-active' : '' ?>" href="../admin/home.php?view=overview">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="m3 10 9-7 9 7v10H3V10Zm6 10v-7h6v7"></path>
          </svg>
          <span>Home</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'users') ? ' is-active' : '' ?>" href="../admin/users.php?view=users-users">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <circle cx="9" cy="7" r="3"></circle>
            <path d="M3 20v-2a6 6 0 0 1 12 0v2M16 4a3 3 0 0 1 0 6m2 4a5 5 0 0 1 3 4v2"></path>
          </svg>
          <span>Users</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'achievements') ? ' is-active' : '' ?>" href="../admin/achievements.php?view=achievements-achievements">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <circle cx="12" cy="8" r="5"></circle>
            <path d="m8 12-1 9 5-3 5 3-1-9"></path>
          </svg>
          <span>Achievements</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'leaderboard') ? ' is-active' : '' ?>" href="../admin/manage.php?view=leaderboard-view-rankings">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M4 3v17h17M8 16v-4m5 4V7m5 9v-6"></path>
          </svg>
          <span>Leaderboard</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'reports') ? ' is-active' : '' ?>" href="../admin/home.php?view=reports-faculty-reports">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8"></path>
          </svg>
          <span>Reports</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'impact') ? ' is-active' : '' ?>" href="../admin/home.php?view=impact-analytics">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M4 3v17h17M8 16v-4m5 4V7m5 9v-6"></path>
          </svg>
          <span>Impact Analytics</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'challenge') ? ' is-active' : '' ?>" href="../admin/manage.php?view=challenge-balancing">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v3m0 14v3M2 12h3m14 0h3M5 5l2 2m10 10 2 2M5 19l2-2M17 7l2-2"></path>
          </svg>
          <span>Challenge Balancing</span>
        </a>
        <a class="sidebar-link<?= str_starts_with($section, 'audit') ? ' is-active' : '' ?>" href="../admin/home.php?view=audit-log">
          <svg class="icon" aria-hidden="true" viewbox="0 0 24 24">
            <path d="M9 6h12M9 12h12M9 18h12M3 6h1m-1 6h1m-1 6h1"></path>
          </svg>
          <span>Audit Log</span>
        </a>
      </nav>
      <div class="sidebar-bottom">
        <a class="sidebar-back" href="../index.php">Back to public home</a>
      <form method="post"><?php echo csrf_field(); ?><input type="hidden" name="action" value="logout"><button class="button button--quiet" type="submit">Log out</button></form></div>
    </aside>
<?php break;
} ?>
<header class="workspace-header">
  <span class="workspace-location"><?= e($location) ?></span>
  <div class="account-chip">
    <img class="avatar" src="../assets/brand-mark.svg" alt="" width="32" height="32">
    <div><strong><?= e($user['full_name']) ?></strong><span><?= e($user['faculty']) ?></span></div>
  </div>
</header>
<?php }
function page_end() { ?>
<script src="../scripts/app.js?v=search-1" defer></script>
</body>
</html>
<?php }

function section_icon($name) {
    $paths=[
        'home'=>'m3 10 9-7 9 7v10H3V10Zm6 10v-7h6v7',
        'challenges'=>'M20 4c0 9-4 14-10 14-4 0-6-2-6-6C4 6 11 4 20 4ZM4 21l11-11',
        'submissions'=>'m5 12 4 4L19 6',
        'campaigns'=>'M3 5h18v16H3zM7 3v4m10-4v4M3 11h18',
        'reports'=>'M5 3h9l5 5v13H5V3Zm9 0v5h5M8 12h8m-8 4h8',
        'users'=>'M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM2 21v-3a7 7 0 0 1 14 0v3M17 4a4 4 0 0 1 0 8m3 9v-3',
        'achievements'=>'M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm-4-1-1 9 5-3 5 3-1-9',
        'announcements'=>'m3 10 17-6v15L3 14v-4Zm4 5 2 6h4l-2-5',
        'analytics'=>'M4 3v17h17M8 16v-4m5 4V7m5 9v-6',
        'profile'=>'M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10ZM3 22a9 9 0 0 1 18 0'
    ];
    $name=strtolower($name);
    if (str_contains($name,'evidence')) $name='submissions';
    if (str_contains($name,'leaderboard') || str_contains($name,'insights') || str_contains($name,'participation') || str_contains($name,'analytics')) $name='analytics';
    if (str_contains($name,'activit') || str_contains($name,'report') || str_contains($name,'audit')) $name='reports';
    if (str_contains($name,'challenge')) $name='challenges';
    return '<svg class="heading-icon" aria-hidden="true" viewBox="0 0 24 24"><path d="'.($paths[$name] ?? $paths['home']).'"></path></svg>';
}
