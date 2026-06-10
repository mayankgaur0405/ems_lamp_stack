<?php
// Root index.php - Home page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EmpManager - Modern Employee Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/php-training-pe-front/study/ems_self/assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #e1e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .hero-section {
            text-align: center;
            margin-bottom: 3rem;
        }
        .hero-title {
            font-weight: 700;
            color: #1e293b;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .hero-title span {
            color: var(--primary-color);
        }
        .hero-subtitle {
            font-size: 1.1rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .hero-desc {
            color: #475569;
            max-width: 500px;
            margin: 0 auto;
        }
        .portal-card {
            border: none;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .portal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .portal-icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .admin-icon-bg {
            background-color: #e0f2fe;
            color: #0284c7;
        }
        .emp-icon-bg {
            background-color: #f3e8ff;
            color: #9333ea;
        }
        .portal-icon-wrapper i {
            font-size: 2.5rem;
        }
        .portal-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        .portal-desc {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            flex-grow: 1;
        }
        .btn-portal {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            background-color: #f8fafc;
            color: #3b82f6;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }
        .btn-portal:hover {
            background-color: #3b82f6;
            color: #fff;
            border-color: #3b82f6;
        }
        .footer-text {
            margin-top: 3rem;
            color: #94a3b8;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="hero-section">
        <h1 class="hero-title">Emp<span>Manager</span></h1>
        <div class="hero-subtitle">Modern Employee Management System</div>
        <p class="hero-desc">Manage your workforce efficiently — employees, departments, teams, ratings, and more.</p>
    </div>

    <div class="row justify-content-center g-4 max-w-4xl mx-auto" style="max-width: 800px;">
        <div class="col-md-6">
            <div class="portal-card glass-panel">
                <div class="portal-icon-wrapper admin-icon-bg">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3 class="portal-title">Admin Portal</h3>
                <p class="portal-desc">Manage employees, departments, teams, and performance ratings.</p>
                <a href="admin/index.php" class="btn btn-portal w-100">Admin Login &rarr;</a>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="portal-card glass-panel">
                <div class="portal-icon-wrapper emp-icon-bg">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h3 class="portal-title">Employee Portal</h3>
                <p class="portal-desc">View your profile, check ratings, and explore the leaderboard.</p>
                <a href="employee/index.php" class="btn btn-portal w-100">Employee Login / Sign Up &rarr;</a>
            </div>
        </div>
    </div>
    
    <div class="text-center footer-text">
        Employee Management System &copy; 2026
    </div>
</div>

</body>
</html>
