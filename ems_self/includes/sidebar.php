<?php
$script = $_SERVER['SCRIPT_NAME'];
$adminPos = strpos($script, '/admin');
$adminBase = $adminPos !== false ? substr($script, 0, $adminPos + 6) : '';
$rootBase = $adminBase ? dirname($adminBase) : '';
?>

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 vh-100" style="width: 310px; overflow-y: auto;">
    <a href="<?php echo $adminBase; ?>/dashboard.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">
        <span class="fs-4 fw-bold ms-2">Emp<span style="color: #3b82f6;">Manager</span></span>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="sidebar-heading">MAIN</li>
        
        <li class="nav-item">
            <a href="<?php echo $adminBase; ?>/dashboard.php" class="nav-link <?php echo strpos($script, 'dashboard.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-grid-1x2-fill text-primary" style="opacity: 0.8;"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?php echo $adminBase; ?>/profile.php" class="nav-link <?php echo strpos($script, 'profile.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-person-fill text-purple" style="color: #a855f7; opacity: 0.8;"></i> My Profile
            </a>
        </li>

        <li class="sidebar-heading">EMPLOYEE MANAGEMENT</li>
        
        <li>
            <a href="<?php echo $adminBase; ?>/employee/add_employee.php" class="nav-link <?php echo strpos($script, 'add_employee.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-plus-lg text-primary"></i> Add Employee
            </a>
        </li>
        <li>
            <a href="<?php echo $adminBase; ?>/employee/view_employee.php" class="nav-link <?php echo strpos($script, 'view_employee.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-people-fill text-purple" style="color: #a855f7;"></i> View Employees
            </a>
        </li>

        <li class="sidebar-heading">DEPARTMENT MANAGEMENT</li>
        
        <li>
            <a href="<?php echo $adminBase; ?>/department/add_department.php" class="nav-link <?php echo strpos($script, 'add_department.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-plus-lg text-primary"></i> Add Department
            </a>
        </li>
        <li>
            <a href="<?php echo $adminBase; ?>/department/view_department.php" class="nav-link <?php echo strpos($script, 'view_department.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-building text-info" style="color: #38bdf8;"></i> View Departments
            </a>
        </li>

        <li class="sidebar-heading">TEAM MANAGEMENT</li>
        
        <li>
            <a href="<?php echo $adminBase; ?>/teams/view_teams.php" class="nav-link <?php echo strpos($script, 'view_teams.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-diagram-3-fill text-warning"></i> View by Department
            </a>
        </li>

        <li class="sidebar-heading">RATINGS</li>
        
        <li>
            <a href="<?php echo $adminBase; ?>/ratings/rate_employee.php" class="nav-link <?php echo strpos($script, 'rate_employee.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-star-fill text-warning"></i> Rate Employee
            </a>
        </li>
        <li>
            <a href="<?php echo $adminBase; ?>/ratings/view_ratings.php" class="nav-link <?php echo strpos($script, 'view_ratings.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-clipboard-data-fill text-info" style="color: #94a3b8;"></i> View Ratings
            </a>
        </li>
        <li>
            <a href="<?php echo $adminBase; ?>/ratings/top_employees.php" class="nav-link <?php echo strpos($script, 'top_employees.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-trophy-fill text-danger"></i> Top Employees
            </a>
        </li>

        <li class="sidebar-heading">ACCOUNT</li>
        
        <li>
            <a href="<?php echo $adminBase; ?>/change_password.php" class="nav-link <?php echo strpos($script, 'change_password.php') !== false ? 'active' : ''; ?>">
                <i class="bi bi-shield-lock-fill text-warning" style="color: #fb923c;"></i> Change Password
            </a>
        </li>
        <li>
            <a href="<?php echo $rootBase; ?>/logout.php" class="nav-link">
                <i class="bi bi-box-arrow-right text-danger"></i> Logout
            </a>
        </li>
    </ul>
</div>
