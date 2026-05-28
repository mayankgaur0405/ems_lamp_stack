<?php
include 'includes/db.php';

$success = '';
$error = '';

// Fetch departments for dropdown
$dept_sql = "SELECT * FROM departments ORDER BY name";
$dept_result = mysqli_query($conn, $dept_sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $designation = $_POST['designation'];
    $department_id = $_POST['department_id'];
    $joining_date = $_POST['joining_date'];

    if (empty($department_id)) {
        $department_id = "NULL";
    }

    // Check if email already exists
    $check_sql = "SELECT id FROM employees WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "This email is already registered!";
    } else {
        $sql = "INSERT INTO employees (name, email, phone, password, designation, department_id, role, joining_date)
                VALUES ('$name', '$email', '$phone', '$password', '$designation', $department_id, 'employee', '$joining_date')";

        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful! You can now login.";
        } else {
            $error = "Error during registration. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Employee Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card" style="max-width: 500px;">
            <h1 class="login-logo">EmpManager</h1>
            <p class="login-subtitle">Create your employee account</p>

            <?php if (!empty($success)): ?>
                <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:6px; margin-bottom:20px; border:1px solid #86efac;">
                    <?php echo $success; ?>
                    <br><a href="login.php" style="color:#166534; font-weight:600;">Go to Login →</a>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="john@company.com">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" required placeholder="9876543210">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" name="designation" id="designation" class="form-control" required placeholder="e.g. SDE, Manager">
                </div>
                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select name="department_id" id="department_id" class="form-control">
                        <option value="">-- Select Department --</option>
                        <?php
                        mysqli_data_seek($dept_result, 0);
                        while ($dept = mysqli_fetch_assoc($dept_result)):
                        ?>
                            <option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="joining_date">Joining Date</label>
                    <input type="date" name="joining_date" id="joining_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Register</button>
            </form>

            <p style="text-align:center; margin-top:20px; font-size:14px; color:var(--text-muted);">
                Already have an account? <a href="login.php" style="color:var(--primary-color); font-weight:500;">Sign In</a>
            </p>
        </div>
    </div>
</body>
</html>
