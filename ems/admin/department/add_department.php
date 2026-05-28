<?php
include '../../includes/header.php';

// Only admin can access
if ($current_user['role'] !== 'admin') {
    header("Location: /php-training-pe-front/study/ems/dashboard.php?user_id=" . $user_id);
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    if (!empty($name)) {
        $sql = "INSERT INTO departments (name) VALUES ('$name')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $success = "Department added successfully!";
        } else {
            $error = "Error: Department may already exist.";
        }
    } else {
        $error = "Please enter department name.";
    }
}

include '../../includes/sidebar.php';
?>

<div class="content-area">
    <h1 class="page-title">Add Department</h1>

    <?php if (!empty($success)): ?>
        <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:6px; margin-bottom:20px; border:1px solid #86efac;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="panel">
        <form method="POST">
            <div class="form-group">
                <label for="name">Department Name</label>
                <input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Engineering">
            </div>
            <button type="submit" class="btn btn-primary">Add Department</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>