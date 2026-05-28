<?php
include '../../includes/header.php';

if ($current_user['role'] !== 'admin') {
    header("Location: /php-training-pe-front/study/ems/dashboard.php?user_id=" . $user_id);
    exit();
}

include '../../includes/sidebar.php';

$sql = "SELECT * FROM departments ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="content-area">
    <h1 class="page-title">All Departments</h1>

    <div class="panel">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Department Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
