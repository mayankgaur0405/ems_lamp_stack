<?php

session_start();

include "../includes/db.php";

//login

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    if($captcha != $_SESSION['captcha'])
    {
        echo "<script>alert('Invalid Captcha');</script>";
    }
    else
    {
        $query = "SELECT * FROM employees
                  WHERE email='$email'
                  AND role='admin'
                  AND status=1";

        $result = mysqli_query($conn,$query);

        if(mysqli_num_rows($result) == 1)
        {
            $admin = mysqli_fetch_assoc($result);

            if(password_verify($password,$admin['password']))
            {
                $_SESSION['id'] = $admin['id'];
                $_SESSION['name'] = $admin['name'];
                $_SESSION['role'] = $admin['role'];

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EmpManager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: #fff;
        }
        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .login-left {
            flex: 1;
            background-color: #1a233a;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        /* Decorative background elements */
        .login-left::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50%;
            height: 50%;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50%;
            filter: blur(80px);
        }
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 50%;
            height: 50%;
            background: rgba(147, 51, 234, 0.1);
            border-radius: 50%;
            filter: blur(80px);
        }
        .brand-badge {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .brand-badge i {
            color: #3b82f6;
        }
        .login-left h1 {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 0.5rem;
            z-index: 1;
        }
        .login-left h1 span {
            color: #3b82f6;
        }
        .login-left h4 {
            color: #94a3b8;
            font-weight: 600;
            letter-spacing: 2px;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            z-index: 1;
        }
        .login-left p {
            color: #cbd5e1;
            text-align: center;
            max-width: 400px;
            margin-bottom: 3rem;
            line-height: 1.6;
            z-index: 1;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            width: 100%;
            max-width: 450px;
            z-index: 1;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem 1rem;
            text-align: center;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #fff;
        }
        .stat-label {
            font-size: 0.75rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .features-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
            max-width: 450px;
            z-index: 1;
        }
        .feature-badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Right Side Form */
        .login-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background: #fff;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
        }
        .form-icon {
            width: 60px;
            height: 60px;
            background-color: #fee2e2;
            color: #ef4444;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        .form-icon.blue {
            background-color: #e0f2fe;
            color: #3b82f6;
        }
        .login-right h2 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        .login-right p.desc {
            color: #64748b;
            margin-bottom: 2.5rem;
            font-size: 0.95rem;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-submit {
            background-color: #ef4444;
            color: #fff;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 1rem;
            transition: all 0.2s;
        }
        .btn-submit:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            margin: 2rem 0;
            font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider:not(:empty)::before { margin-right: 1rem; }
        .divider:not(:empty)::after { margin-left: 1rem; }
        
        .links {
            text-align: center;
            font-size: 0.9rem;
            color: #64748b;
        }
        .links a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .captcha-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            background: #f8fafc;
            padding: 0.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .captcha-wrapper img {
            border-radius: 4px;
        }
        
        @media (max-width: 991.98px) {
            .login-wrapper { flex-direction: column; }
            .login-left { display: none; } /* Hide left side on smaller screens for simplicity */
            .login-right { padding: 2rem; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- Left Side -->
    <div class="login-left">
        <div class="brand-badge">
            <i class="bi bi-shield-check"></i> Secure Administration Portal
        </div>
        
        <h1>Emp<span>Manager</span></h1>
        <h4>ADMIN CONTROL CENTER</h4>
        
        <p>Your <strong>complete command center</strong> for managing employees, departments, teams, and performance — all from one powerful dashboard.</p>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">5</div>
                <div class="stat-label">Employees</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">5</div>
                <div class="stat-label">Departments</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">0</div>
                <div class="stat-label">Teams</div>
            </div>
        </div>
        
        <div class="features-grid">
            <div class="feature-badge"><i class="bi bi-bar-chart-fill text-success"></i> Performance Ratings</div>
            <div class="feature-badge"><i class="bi bi-people-fill text-primary"></i> Team Builder</div>
            <div class="feature-badge"><i class="bi bi-building text-info"></i> Departments</div>
            <div class="feature-badge"><i class="bi bi-file-earmark-text text-secondary"></i> Resume Vault</div>
            <div class="feature-badge"><i class="bi bi-trophy-fill text-warning"></i> Leaderboards</div>
        </div>
    </div>

    <!-- Right Side -->
    <div class="login-right">
        <div class="form-container">
            <div class="form-icon blue">
                <i class="bi bi-shield-lock"></i>
            </div>
            
            <h2>Admin Sign In</h2>
            <p class="desc">Enter your admin credentials to access the management dashboard.</p>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@company.com" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Security Verification</label>
                    <div class="captcha-wrapper">
                        <img src="../includes/captcha.php" alt="Captcha" class="border">
                        <a href="" class="btn btn-sm btn-outline-secondary" title="Refresh Captcha">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                    <input type="text" name="captcha" class="form-control" placeholder="Enter characters shown above" required>
                </div>
                
                <button type="submit" name="login" class="btn btn-submit w-100">
                    Sign In to Dashboard &rarr;
                </button>
            </form>
            
            <div class="divider">or</div>
            
            <div class="links mb-4">
                Looking for <a href="../employee/index.php">Employee Portal</a>?
            </div>
            
            <div class="links">
                <a href="../index.php" class="text-muted"><i class="bi bi-arrow-left"></i> Back to Home</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>