<?php
session_start();
include "includes/db.php";
require "includes/mail_config.php";

$msg = '';

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "SELECT * FROM employees WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
        
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $update_query = "UPDATE employees SET reset_token='$token', reset_token_expiry='$expiry' WHERE id=" . $employee['id'];
        if(mysqli_query($conn, $update_query)) {
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/php-training-pe-front/study/ems_self/reset_password.php?token=" . $token;
            $body = "<h3>Hello " . $employee['name'] . ",</h3><p>You requested a password reset. Click the link below to set a new password. This link is valid for 1 hour.</p><p><a href='$reset_link'>$reset_link</a></p>";
            
            if(send_mail($email, $employee['name'], 'Password Reset Request', $body)) {
                $msg = "<div class='alert alert-success'>Password reset link has been sent to your email.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Failed to send email. Please try again.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>No account found with that email address.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card glass-panel p-5" style="max-width: 400px; width: 100%;">
        <h3 class="mb-4 text-center">Forgot Password</h3>
        <?php echo $msg; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter your registered email">
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-modern w-100">Send Reset Link</button>
            <div class="mt-3 text-center">
                <a href="index.php" class="text-decoration-none">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>
