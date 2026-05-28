<?php

/** @var array current_user*/

/** @var int $user_id */
?>


<aside class="sidebar">
    <div class="sidebar-logo">EmpManager</div>
    <nav class="sidebar-menu">
        <div class="menu-section-label">Main</div>
        <a href="/php-training-pe-front/study/ems/dashboard.php?user_id=<?php echo $user_id; ?>" class="menu-item">
            <span class="menu-icon">📊</span> Dashboard
        </a>
        <a href="/php-training-pe-front/study/ems/profile.php?user_id=<?php echo $user_id; ?>" class="menu-item">
            <span class="menu-icon">👤</span> My Profile
        </a>

        <?php if ($current_user['role'] === 'admin'): ?>
            <div class="menu-section-label">Employee Management</div>
            <a href="/php-training-pe-front/study/ems/admin/employee/add_employee.php?user_id=<?php echo $user_id; ?>" class="menu-item">
                <span class="menu-icon">➕</span> Add Employee
            </a>
            <a href="/php-training-pe-front/study/ems/admin/employee/view_employee.php?user_id=<?php echo $user_id; ?>" class="menu-item">
                <span class="menu-icon">👥</span> View Employees
            </a>

            <div class="menu-section-label">Department Management</div>
            <a href="/php-training-pe-front/study/ems/admin/department/add_department.php?user_id=<?php echo $user_id; ?>" class="menu-item">
                <span class="menu-icon">➕</span> Add Department
            </a>
            <a href="/php-training-pe-front/study/ems/admin/department/view_department.php?user_id=<?php echo $user_id; ?>" class="menu-item">
                <span class="menu-icon">🏢</span> View Departments
            </a>
        <?php endif; ?>

        <div class="menu-section-label">Account</div>
        <a href="/php-training-pe-front/study/ems/logout.php" class="menu-item">
            <span class="menu-icon">🚪</span> Logout
        </a> 
    </nav>
</aside>
