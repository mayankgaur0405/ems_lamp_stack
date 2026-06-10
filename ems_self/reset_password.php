<?php
session_start();
include "includes/db.php";

$msg = '';
$valid_token = false;
$employee_id = null;

if(isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $query = "SELECT * FROM employees WHERE reset_token='$token' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
        if(strtotime($employee['reset_token_expiry']) > time()) {
            $valid_token = true;
            $employee_id = $employee['id'];
        } else {
            $msg = "<div class='alert alert-danger'>This reset link has expired.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid reset token.</div>";
    }
}

if(isset($_POST['submit']) && $valid_token) {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE employees SET password='$hashed_password', reset_token=NULL, reset_token_expiry=NULL WHERE id=" . $employee_id;
        
        if(mysqli_query($conn, $update_query)) {
            echo "<script>alert('Password reset successfully!'); window.location='employee/index.php';</script>";
            exit;
        } else {
            $msg = "<div class='alert alert-danger'>Failed to reset password. Please try again.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Passwords do not match.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card glass-panel p-5" style="max-width: 400px; width: 100%;">
        <h3 class="mb-4 text-center">Reset Password</h3>
        <?php echo $msg; ?>
        
        <?php if($valid_token): ?>
        <form method="POST">
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-modern w-100">Reset Password</button>
        </form>
        <?php endif; ?>
        
        <?php if(!$valid_token && empty($msg)): ?>
            <div class='alert alert-warning'>No valid token provided.</div>
        <?php endif; ?>
    </div>
</body>
</html>
