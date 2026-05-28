<?php
include '../../includes/header.php';

if ($current_user['role'] !== 'admin') {
    header("Location: /php-training-pe-front/study/ems/dashboard.php?user_id=" . $user_id);
    exit();
}

include '../../includes/sidebar.php';

$sql = "SELECT e.*, d.name as dept_name FROM employees e LEFT JOIN departments d ON e.department_id = d.id ORDER BY e.id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="content-area">
    <h1 class="page-title">All Employees</h1>

    <div class="panel">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
                    <td>
                        <a href="edit_employee.php?user_id=<?php echo $user_id; ?>&emp_id=<?php echo $row['id']; ?>" class="btn btn-outline" style="padding: 4px 8px; font-size: 12px; display: inline-block;">✏️ Edit</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
