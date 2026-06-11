<?php
$script = $_SERVER['SCRIPT_NAME'];
$empPos = strpos($script, '/employee');
$empBase = $empPos !== false ? substr($script, 0, $empPos + 9) : '';
$rootBase = $empBase ? dirname($empBase) : '';
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 vh-100 position-sticky top-0" style="width: 260px; overflow-y: auto;">
    <a href="<?php echo $empBase; ?>/dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4 fw-bold">Emp<span style="color: var(--primary-color);">Manager</span></span>
    </a>
    <hr style="border-color: #334155; margin-top: 0.5rem; margin-bottom: 1.5rem;">
    
    <ul class="nav nav-pills flex-column mb-auto">
        <div class="sidebar-heading">MAIN</div>
        
        <li class="nav-item">
            <a href="<?php echo $empBase; ?>/dashboard.php" class="nav-link <?php if($current_page == 'dashboard.php') echo 'active'; ?>">
                <i class="bi bi-grid-1x2-fill <?php if($current_page == 'dashboard.php') echo 'text-white'; else echo 'text-primary'; ?>"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?php echo $empBase; ?>/profile.php" class="nav-link <?php if($current_page == 'profile.php') echo 'active'; ?>">
                <i class="bi bi-person-fill <?php if($current_page == 'profile.php') echo 'text-white'; ?>" <?php if($current_page != 'profile.php') echo 'style="color: #c084fc;"'; ?>></i> My Profile
            </a>
        </li>

        <div class="sidebar-heading mt-4">LEADERBOARD</div>
        <li>
            <a href="<?php echo $empBase; ?>/top_employees.php" class="nav-link <?php if($current_page == 'top_employees.php') echo 'active'; ?>">
                <i class="bi bi-trophy-fill <?php if($current_page == 'top_employees.php') echo 'text-white'; else echo 'text-warning'; ?>"></i> Top Employees
            </a>
        </li>

        <div class="sidebar-heading mt-4">ACCOUNT</div>
        <li>
            <a href="<?php echo $empBase; ?>/change_password.php" class="nav-link <?php if($current_page == 'change_password.php') echo 'active'; ?>">
                <i class="bi bi-shield-lock-fill <?php if($current_page == 'change_password.php') echo 'text-white'; else echo 'text-warning'; ?>"></i> Change Password
            </a>
        </li>
        <li>
            <a href="<?php echo $empBase; ?>/contact.php" class="nav-link <?php if($current_page == 'contact.php') echo 'active'; ?>">
                <i class="bi bi-envelope-fill <?php if($current_page == 'contact.php') echo 'text-white'; else echo 'text-info'; ?>"></i> Contact Admin
            </a>
        </li>
        <li>
            <a href="<?php echo $rootBase; ?>/logout.php" class="nav-link text-danger mt-2">
                <i class="bi bi-box-arrow-right text-danger"></i> Logout
            </a>
        </li>
    </ul>
</div>
