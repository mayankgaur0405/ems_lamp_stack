<?php

session_start();

include "../includes/db.php";
require "../includes/mail_config.php";

/* LOGIN */

if(isset($_POST['login']))
{
$email = $_POST['login_email'];
$password = $_POST['login_password'];
$captcha = $_POST['captcha'];

if($captcha != $_SESSION['captcha'])
{
    echo "<script>alert('Invalid Captcha');</script>";
}
else
{
$query = "SELECT * FROM employees 
          WHERE email='$email' 
          AND role='employee'";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 1)
{
    $employee = mysqli_fetch_assoc($result);

    if($employee['status'] == 0)
    {
        echo "<script>alert('Your Account is Inactive, Please Contact Admin !!');</script>";
    }
    elseif(password_verify($password, $employee['password']))
    {
        $_SESSION['id'] = $employee['id'];
        $_SESSION['name'] = $employee['name'];
        $_SESSION['role'] = $employee['role'];

        header("Location: dashboard.php");
        exit;
    }
    else
    {
        echo "<script>alert('Invalid Password');</script>";
    }
}
else
{
    echo "<script>alert('Invalid Email');</script>";
}

}

}


/* SIGNUP */

if(isset($_POST['signup']))
{
    $name = $_POST['name'];

    $email = $_POST['email'];

    $phone = $_POST['phone'];

    $password = $_POST['password'];

    $confirm_password =
    $_POST['confirm_password'];

    if($password != $confirm_password)
    {
        echo
        "<script>alert('Passwords Do Not Match');</script>";
    }
    else
    {
        $check_query =
        "SELECT *
        FROM employees
        WHERE email='$email'";

        $check_result =
        mysqli_query($conn,$check_query);

        if(
            mysqli_num_rows(
                $check_result
            ) > 0
        )
        {
            echo
            "<script>alert('Email Already Exists');</script>";
        }
        else
        {            $password =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $token = bin2hex(random_bytes(32));

            $insert_query =
            "INSERT INTO employees
            (
                name,
                email,
                phone,
                password,
                joining_date,
                status,
                verification_token
            )
            VALUES
            (
                '$name',
                '$email',
                '$phone',
                '$password',
                CURDATE(),
                0,
                '$token'
            )";

            if(
                mysqli_query(
                    $conn,
                    $insert_query
                )
            )
            {
                $verify_link = "http://" . $_SERVER['HTTP_HOST'] . "/php-training-pe-front/study/ems_self/verify.php?token=" . $token;
                $body = "<h3>Hello $name,</h3><p>Thank you for signing up. Please click the link below to verify your email and activate your account:</p><p><a href='$verify_link'>$verify_link</a></p>";
                send_mail($email, $name, 'Verify Your Account', $body);

                echo
                "<script>alert('Registration Successful! A verification email has been sent to your email. Please verify to login.');</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
        }
        .login-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        /* Left Panel */
        .left-panel {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            position: relative;
            overflow: hidden;
        }
        /* Right Panel */
        .right-panel {
            width: 50%;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4rem;
        }
        .form-wrapper {
            width: 100%;
            max-width: 450px;
        }
        .nav-pills-custom {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 2rem;
            display: flex;
        }
        .nav-pills-custom .nav-item {
            flex: 1;
            text-align: center;
        }
        .nav-pills-custom .nav-link {
            color: #64748b;
            font-weight: 500;
            border-radius: 6px;
            padding: 0.6rem;
            transition: all 0.2s;
            width: 100%;
        }
        .nav-pills-custom .nav-link.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 600;
        }
        .feature-badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            color: #cbd5e1;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.25rem;
        }
    </style>
</head>
<body>

<div class="login-container">
    
    <!-- Left Decorative Panel -->
    <div class="left-panel d-none d-lg-flex">
        
        <div class="mb-4" style="background: rgba(16, 185, 129, 0.1); color: #34d399; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500; border: 1px solid rgba(16, 185, 129, 0.2);">
            ✨ Build your career. Grow faster.
        </div>

        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold mb-1">Emp<span style="color: #34d399;">Manager</span></h1>
            <p style="color: #94a3b8; letter-spacing: 2px; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Employee Portal</p>
        </div>

        <p class="text-center mb-5" style="color: #cbd5e1; max-width: 400px; font-size: 1.05rem; line-height: 1.6;">
            Your <span class="text-white fw-bold">professional workspace</span> to manage your profile, track performance ratings, connect with teams, and build your career path.
        </p>

        <div class="row g-3 mb-5 w-100" style="max-width: 500px;">
            <div class="col-4">
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Colleagues</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card">
                    <div class="stat-number">4</div>
                    <div class="stat-label">Departments</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card">
                    <div class="stat-number">6</div>
                    <div class="stat-label">Countries</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-center" style="max-width: 500px;">
            <div class="feature-badge"><i class="bi bi-person-vcard text-danger"></i> Profile Manager</div>
            <div class="feature-badge"><i class="bi bi-star-fill text-warning"></i> Performance Tracker</div>
            <div class="feature-badge"><i class="bi bi-people-fill text-primary"></i> Team Finder</div>
            <div class="feature-badge"><i class="bi bi-trophy-fill text-warning"></i> Leaderboards</div>
            <div class="feature-badge"><i class="bi bi-file-earmark-text text-info"></i> Resume Upload</div>
        </div>
    </div>

    <!-- Right Login/Signup Panel -->
    <div class="right-panel w-100 w-lg-50">
        <div class="form-wrapper">
            
            <div class="mb-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; background-color: #dcfce7; color: #10b981;">
                    <i class="bi bi-person-fill fs-3"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1">Employee Portal</h3>
                <p class="text-muted" style="font-size: 0.9rem;">Sign in to your workspace or create a new account to get started.</p>
            </div>

            <!-- Custom Tabs -->
            <ul class="nav nav-pills nav-pills-custom" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active border-0" data-bs-toggle="pill" data-bs-target="#login" type="button" role="tab">Sign In</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0" data-bs-toggle="pill" data-bs-target="#signup" type="button" role="tab">Create Account</button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Login Tab -->
                <div class="tab-pane fade show active" id="login" role="tabpanel">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email Address</label>
                            <input type="email" name="login_email" class="form-control bg-light" placeholder="you@company.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Password</label>
                            <input type="password" name="login_password" class="form-control bg-light" placeholder="••••••••" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Security Verification</label>
                            <div class="d-flex align-items-center mb-2">
                                <img src="../includes/captcha.php" alt="Captcha" class="rounded" style="border: 1px solid #e2e8f0;">
                                <a href="" class="btn btn-sm btn-light ms-2 border text-primary"><i class="bi bi-arrow-clockwise"></i></a>
                            </div>
                            <input type="text" name="captcha" class="form-control bg-light" placeholder="Enter code above" required>
                        </div>
                        
                        <button type="submit" name="login" class="btn w-100 py-2 fw-bold text-white mb-4" style="background-color: #10b981; border-color: #10b981;">Sign In &rarr;</button>
                        
                        <div class="text-center text-muted mb-3" style="font-size: 0.85rem;">
                            <span class="px-2 bg-white text-muted">or</span>
                        </div>
                        
                        <div class="text-center mt-3" style="font-size: 0.85rem;">
                            <a href="../forgot_password.php" class="text-muted text-decoration-none d-block mb-3">Forgot Password?</a>
                            <span class="text-muted">Looking for <a href="../admin/index.php" class="text-decoration-none fw-semibold" style="color: #10b981;">Admin Portal</a>?</span>
                            <br><br>
                            <a href="../index.php" class="text-muted text-decoration-none">&larr; Back to Home</a>
                        </div>
                    </form>
                </div>

                <!-- Signup Tab -->
                <div class="tab-pane fade" id="signup" role="tabpanel">
                    <form method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Full Name</label>
                                <input type="text" name="name" class="form-control bg-light" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Phone Number</label>
                                <input type="text" name="phone" class="form-control bg-light" placeholder="9876543210" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email Address</label>
                            <input type="email" name="email" class="form-control bg-light" placeholder="you@company.com" required>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Password</label>
                                <input type="password" name="password" class="form-control bg-light" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control bg-light" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" name="signup" class="btn btn-primary w-100 py-2 fw-bold text-white mb-3">Create Account</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
