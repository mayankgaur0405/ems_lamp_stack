<?php

include 'includes/db.php';

$error = '';

//to check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "select * from employees where email = '$email' and password = '$password'";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            header("Location: dashboard.php?user_id=" . $row['id']);
            exit();
        } else {
            $error = "invalid email or password";
        }
    } else {
        $error = 'please fill in all fields!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Employee Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>


<body class="login-body">
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-logo">EmpManager</h1>
            <p class="login-subtitle">Sign in to manage your account</p>


            <!-- Display error message if there is one -->
            <?php if (!empty($error)): ?>
                <div class="alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>


            <!-- Login Form -->
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="mayankgaur@pefront.com">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Sign In</button>
            </form>
        </div>
    </div>
</body>


</html>