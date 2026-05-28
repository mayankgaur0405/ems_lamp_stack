<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content-area">

<?php if ($current_user['role'] === 'employee'): ?>
    <!-- EMPLOYEE DASHBOARD -->
    <?php
    $emp_sql = "SELECT e.*, d.name AS dept_name FROM employees e LEFT JOIN departments d ON e.department_id = d.id WHERE e.id = $user_id";
    $emp_result = mysqli_query($conn, $emp_sql);
    $emp = mysqli_fetch_assoc($emp_result);
    ?>

    <h1 class="page-title"><span>Employee</span> Dashboard</h1>

    <div class="profile-flex">
        <div class="profile-card-left panel">
            <p class="profile-summary-header">Welcome, <?php echo $emp['name']; ?>! 👋</p>
            <p class="profile-summary-text">Here is your profile summary. You can update your profile from the Profile page.</p>

            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo $emp['email']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Department:</span>
                    <span class="info-value"><?php echo $emp['dept_name'] ? $emp['dept_name'] : 'Not Assigned'; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span class="info-value"><?php echo $emp['phone']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Role:</span>
                    <span class="badge badge-employee"><?php echo $emp['role']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Designation:</span>
                    <span class="info-value"><?php echo $emp['designation']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Joined:</span>
                    <span class="info-value"><?php echo date('d M Y', strtotime($emp['joining_date'])); ?></span>
                </div>
            </div>

            <a href="profile.php?user_id=<?php echo $user_id; ?>&action=edit" class="btn btn-primary">✏️ Edit Profile</a>
        </div>

        <div class="profile-card-right">
            <?php
            $avatar = !empty($emp['profile_pic']) ? $emp['profile_pic'] : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80';
            ?>
            <img src="<?php echo $avatar; ?>" alt="Profile" class="profile-avatar-large">
            <h3><?php echo $emp['name']; ?></h3>
            <p><?php echo $emp['designation']; ?></p>
        </div>
    </div>

<?php else: ?>
    <!-- ADMIN DASHBOARD -->
    <?php
    $total_emp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM employees"))['total'];
    $total_dept = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM departments"))['total'];
    $total_admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM employees WHERE role = 'admin'"))['total'];

    $recent_sql = "SELECT e.*, d.name as dept_name FROM employees e LEFT JOIN departments d ON e.department_id = d.id ORDER BY e.id DESC LIMIT 5";
    $recent_result = mysqli_query($conn, $recent_sql);
    ?>

    <h1 class="page-title"><span>Admin</span> Dashboard</h1>

    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Total Employees</h3>
                <div class="stat-number"><?php echo $total_emp; ?></div>
                <a href="admin/employee/view_employee.php?user_id=<?php echo $user_id; ?>">View All →</a>
            </div>
            <div class="stat-icon">👥</div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>Departments</h3>
                <div class="stat-number"><?php echo $total_dept; ?></div>
                <a href="admin/department/view_department.php?user_id=<?php echo $user_id; ?>">View All →</a>
            </div>
            <div class="stat-icon dept-icon">🏢</div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>Admin Users</h3>
                <div class="stat-number"><?php echo $total_admin; ?></div>
                <p style="font-size:12px; color: var(--text-muted); margin-top:10px;">System Administrators</p>
            </div>
            <div class="stat-icon admin-icon">🛡️</div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>Quick Actions</h3>
                <div class="quick-actions-btns">
                    <a href="admin/employee/add_employee.php?user_id=<?php echo $user_id; ?>" class="btn btn-primary">+ Employee</a>
                    <a href="admin/department/add_department.php?user_id=<?php echo $user_id; ?>" class="btn btn-outline">+ Department</a>
                </div>
            </div>
            <div class="stat-icon actions-icon">⚡</div>
        </div>
    </div>

    <div class="panel">
        <h3 class="panel-title">Recent Employees</h3>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($recent_result)): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['dept_name'] ? $row['dept_name'] : 'Not Assigned'; ?></td>
                    <td>
                        <span class="badge <?php echo ($row['role'] === 'admin') ? 'badge-admin' : 'badge-employee'; ?>">
                            <?php echo $row['role']; ?>
                        </span>
                    </td>
                    <td><?php echo date('d M Y', strtotime($row['joining_date'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
