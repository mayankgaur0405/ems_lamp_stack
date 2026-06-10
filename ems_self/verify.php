<?php
include "includes/db.php";

if(isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Prevent SQL injection
    $token = mysqli_real_escape_string($conn, $token);

    $query = "SELECT * FROM employees WHERE verification_token='$token' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
        if($employee['status'] == 1) {
            $msg = "Account is already verified.";
        } else {
            $update_query = "UPDATE employees SET status=1, verification_token=NULL WHERE id=" . $employee['id'];
            if(mysqli_query($conn, $update_query)) {
                $msg = "Account successfully verified! You can now log in.";
            } else {
                $msg = "Failed to verify account. Please try again later.";
            }
        }
    } else {
        $msg = "Invalid verification token.";
    }
} else {
    $msg = "No token provided.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card glass-panel p-5 text-center" style="max-width: 500px;">
        <h2 class="mb-4">Account Verification</h2>
        <p class="fs-5"><?php echo $msg; ?></p>
        <a href="employee/index.php" class="btn btn-primary btn-modern mt-3">Go to Login</a>
    </div>
</body>
</html>
