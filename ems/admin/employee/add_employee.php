<?php
include '../../includes/header.php';

if ($current_user['role'] !== 'admin') {
    header("Location: /php-training-pe-front/study/ems/dashboard.php?user_id=" . $user_id);
    exit();
}

$success = '';
$error = '';

// Fetch all departments for the dropdown
$dept_sql = "SELECT * FROM departments ORDER BY name";
$dept_result = mysqli_query($conn, $dept_sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $designation = $_POST['designation'];
    $department_id = $_POST['department_id'];
    $role = $_POST['role'];
    $joining_date = $_POST['joining_date'];

    // Handle empty department
    if (empty($department_id)) {
        $department_id = "NULL";
    }

    $sql = "INSERT INTO employees (name, email, phone, password, designation, department_id, role, joining_date)
            VALUES ('$name', '$email', '$phone', '$password', '$designation', $department_id, '$role', '$joining_date')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $success = "Employee added successfully!";
    } else {
        $error = "Error adding employee. Email may already exist.";
    }
}

include '../../includes/sidebar.php';
?>

<div class="content-area">
    <h1 class="page-title">Add Employee</h1>

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
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" name="designation" id="designation" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control">
                    <option value="">-- Select Department --</option>
                    <?php
                    // Reset the result pointer so we can loop again
                    mysqli_data_seek($dept_result, 0);
                    while ($dept = mysqli_fetch_assoc($dept_result)):
                    ?>
                        <option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="employee">Employee</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="joining_date">Joining Date</label>
                <input type="date" name="joining_date" id="joining_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
