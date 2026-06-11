<?php

session_start();

if(
    !isset($_SESSION['id'])
    ||
    $_SESSION['role'] != 'employee'
)
{
    header("Location:index.php");
    exit;
}

include "../includes/db.php";

$id = $_SESSION['id'];

$query =
    "SELECT e.*,
d.name AS department_name

FROM employees e

LEFT JOIN departments d
ON e.department_id = d.id

WHERE e.id='$id'";

$result =
mysqli_query($conn,$query);

$employee =
mysqli_fetch_assoc($result);

?>

<?php include "../includes/header.php"; ?>

<div class="d-flex">

    <?php include "../includes/employee_sidebar.php"; ?>

    <div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
        <!-- Topbar -->
        <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
            <div>
                <button class="btn btn-light d-md-none"><i class="bi bi-list"></i></button>
                <i class="bi bi-list fs-4 ms-2 d-none d-md-inline-block text-secondary"></i>
            </div>
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: 600; font-size: 0.9rem;">
                    <?php 
                    $name_parts = explode(' ', $_SESSION['name']);
                    $initials = strtoupper(substr($name_parts[0], 0, 1));
                    if (isset($name_parts[1])) {
                        $initials .= strtoupper(substr($name_parts[1], 0, 1));
                    }
                    echo $initials;
                    ?>
                </div>
                <span class="fw-medium text-secondary" style="font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid p-4">
            <h4 class="mb-4 text-dark fw-normal">Welcome, <span class="fw-bold"><?php echo htmlspecialchars($employee['name']); ?></span></h4>

            <div class="row g-4 mb-4">
                <!-- Card 1 -->
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div style="word-break: break-all;">
                                    <h6 class="text-muted fw-normal mb-1">Email</h6>
                                    <h5 class="mb-0 fw-bold fs-6 text-dark"><?php echo htmlspecialchars($employee['email']); ?></h5>
                                </div>
                                <div class="rounded p-2" style="background-color: #e0e7ff; color: #4f46e5; flex-shrink: 0;">
                                    <i class="bi bi-envelope-fill fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="text-muted fw-normal mb-1">Phone</h6>
                                    <h5 class="mb-0 fw-bold fs-6 text-dark"><?php echo htmlspecialchars($employee['phone']); ?></h5>
                                </div>
                                <div class="rounded p-2" style="background-color: #e0f2fe; color: #0284c7;">
                                    <i class="bi bi-telephone-fill fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="text-muted fw-normal mb-1">Designation</h6>
                                    <h5 class="mb-0 fw-bold fs-6 text-dark"><?php echo htmlspecialchars($employee['designation']); ?></h5>
                                </div>
                                <div class="rounded p-2" style="background-color: #fef3c7; color: #d97706;">
                                    <i class="bi bi-briefcase-fill fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="text-muted fw-normal mb-1">Department</h6>
                                    <h5 class="mb-0 fw-bold fs-6 text-dark"><?php echo htmlspecialchars($employee['department_name']); ?></h5>
                                </div>
                                <div class="rounded p-2" style="background-color: #dcfce7; color: #16a34a;">
                                    <i class="bi bi-building fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-body d-flex flex-wrap align-items-center py-3">
                    <i class="bi bi-lightning-fill text-warning me-2"></i>
                    <span class="text-secondary fw-medium me-4 mb-2 mb-md-0" style="font-size: 0.95rem;">Quick Links</span>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="profile.php" class="btn btn-primary btn-sm rounded-pill px-3"><i class="bi bi-person me-1"></i> My Profile</a>
                        <a href="top_employees.php" class="btn btn-outline-success btn-sm rounded-pill px-3"><i class="bi bi-trophy me-1"></i> Top Employees</a>
                        <a href="change_password.php" class="btn btn-outline-warning btn-sm rounded-pill px-3"><i class="bi bi-key me-1"></i> Change Password</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

