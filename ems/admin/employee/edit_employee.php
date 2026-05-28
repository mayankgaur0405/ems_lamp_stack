<?php
include '../../includes/header.php';

if ($current_user['role'] !== 'admin') {
    header("Location: /php-training-pe-front/study/ems/dashboard.php?user_id=" . $user_id);
    exit();
}

// Get the employee ID to edit from the URL
$emp_id = $_GET['emp_id'];

// Fetch departments for dropdown
$dept_sql = "SELECT * FROM departments ORDER BY name";
$dept_result = mysqli_query($conn, $dept_sql);

// Fetch current employee data
$emp_sql = "SELECT * FROM employees WHERE id = $emp_id";
$emp_result = mysqli_query($conn, $emp_sql);
$emp = mysqli_fetch_assoc($emp_result);

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];
    $department_id = $_POST['department_id'];
    $role = $_POST['role'];
    $joining_date = $_POST['joining_date'];

    if (empty($department_id)) {
        $department_id = "NULL";
    }

    $sql = "UPDATE employees SET 
            name = '$name', 
            email = '$email', 
            phone = '$phone', 
            designation = '$designation', 
            department_id = $department_id, 
            role = '$role', 
            joining_date = '$joining_date' 
            WHERE id = $emp_id";

    if (mysqli_query($conn, $sql)) {
        $success = "Employee updated successfully!";
        // Re-fetch updated data
        $emp_result = mysqli_query($conn, "SELECT * FROM employees WHERE id = $emp_id");
        $emp = mysqli_fetch_assoc($emp_result);
    } else {
        $error = "Error updating employee.";
    }
}

include '../../includes/sidebar.php';
?>

<div class="content-area">
    <h1 class="page-title">Edit Employee</h1>

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
                <input type="text" name="name" id="name" class="form-control" required value="<?php echo $emp['name']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required value="<?php echo $emp['email']; ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" required value="<?php echo $emp['phone']; ?>">
            </div>
            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" name="designation" id="designation" class="form-control" required value="<?php echo $emp['designation']; ?>">
            </div>
            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control">
                    <option value="">-- Select Department --</option>
                    <?php
                    mysqli_data_seek($dept_result, 0);
                    while ($dept = mysqli_fetch_assoc($dept_result)):
                    ?>
                        <option value="<?php echo $dept['id']; ?>" <?php echo ($dept['id'] == $emp['department_id']) ? 'selected' : ''; ?>>
                            <?php echo $dept['name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="employee" <?php echo ($emp['role'] === 'employee') ? 'selected' : ''; ?>>Employee</option>
                    <option value="admin" <?php echo ($emp['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="joining_date">Joining Date</label>
                <input type="date" name="joining_date" id="joining_date" class="form-control" required value="<?php echo $emp['joining_date']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="view_employee.php?user_id=<?php echo $user_id; ?>" class="btn btn-outline" style="margin-left:10px;">Back to List</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
