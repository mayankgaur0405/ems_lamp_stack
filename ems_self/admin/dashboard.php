<?php

session_start();

if(
    !isset($_SESSION['id'])
    ||
    $_SESSION['role'] != 'admin'
)
{
    header("Location:index.php");
    exit;
}

include "../includes/db.php";

?>

<?php include "../includes/header.php"; ?>

<div class="d-flex">

<?php include "../includes/sidebar.php"; ?>

<div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
    <!-- Topbar -->
    <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <div>
            <button class="btn btn-light d-md-none"><i class="bi bi-list"></i></button>
            <i class="bi bi-list fs-4 ms-2 d-none d-md-inline-block text-secondary"></i>
        </div>
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: 600; font-size: 0.9rem;">
                SA
            </div>
            <span class="fw-medium text-secondary" style="font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid p-4">
        
        <h4 class="mb-4 text-dark fw-normal">Admin <span class="fw-bold">Dashboard</span></h4>
        
        <div class="row g-4 mb-4">
            <!-- Card 1 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Total Employees</h6>
                                <?php
                                $query = "SELECT COUNT(*) AS total FROM employees WHERE role='employee'";
                                $result = mysqli_query($conn,$query);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h2 class="mb-0 fw-bold"><?php echo $row['total']; ?></h2>
                            </div>
                            <div class="rounded p-2" style="background-color: #e0e7ff; color: #4f46e5;">
                                <i class="bi bi-people-fill fs-5"></i>
                            </div>
                        </div>
                        <a href="employee/view_employee.php" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 500; color: #3b82f6;">View All &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Departments</h6>
                                <?php
                                $query = "SELECT COUNT(*) AS total FROM departments";
                                $result = mysqli_query($conn,$query);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h2 class="mb-0 fw-bold"><?php echo $row['total']; ?></h2>
                            </div>
                            <div class="rounded p-2" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="bi bi-building fs-5"></i>
                            </div>
                        </div>
                        <a href="department/view_department.php" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 500; color: #3b82f6;">View All &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Active Employees</h6>
                                <?php
                                $query = "SELECT COUNT(*) AS total FROM employees WHERE role='employee' AND status=1";
                                $result = mysqli_query($conn,$query);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h2 class="mb-0 fw-bold"><?php echo $row['total']; ?></h2>
                            </div>
                            <div class="rounded p-2" style="background-color: #dcfce7; color: #16a34a;">
                                <i class="bi bi-person-check-fill fs-5"></i>
                            </div>
                        </div>
                        <a href="employee/view_employee.php" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 500; color: #3b82f6;">View All &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Total Ratings</h6>
                                <?php
                                $query = "SELECT COUNT(*) AS total FROM employee_ratings";
                                $result = mysqli_query($conn,$query);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h2 class="mb-0 fw-bold"><?php echo $row['total']; ?></h2>
                            </div>
                            <div class="rounded p-2" style="background-color: #fef3c7; color: #d97706;">
                                <i class="bi bi-star-fill fs-5"></i>
                            </div>
                        </div>
                        <a href="ratings/view_ratings.php" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 500; color: #3b82f6;">View Ratings &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center py-3">
                <i class="bi bi-shield-fill text-primary me-2"></i>
                <span class="text-secondary fw-medium me-4" style="font-size: 0.95rem;">Administrative Quick Actions</span>
                <div class="d-flex gap-2">
                    <a href="employee/add_employee.php" class="btn btn-primary btn-sm rounded-pill px-3"><i class="bi bi-plus-lg"></i> Add New Employee</a>
                    <a href="department/add_department.php" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="bi bi-building"></i> Create Department</a>
                    <a href="teams/view_teams.php" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="bi bi-people"></i> Department Teams</a>
                    <a href="ratings/rate_employee.php" class="btn btn-outline-warning btn-sm rounded-pill px-3"><i class="bi bi-star"></i> Rate an Employee</a>
                </div>
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="card">
            <div class="card-header border-0 bg-white pt-4 pb-2">
                <h6 class="text-secondary fw-semibold mb-0">Recent Registrations</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT e.*, d.name AS department_name FROM employees e LEFT JOIN departments d ON e.department_id = d.id WHERE e.role='employee' ORDER BY e.id DESC LIMIT 5";
                            $result = mysqli_query($conn,$query);
                            while($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; overflow: hidden;">
                                            <?php if(!empty($row['profile_pic'])): ?>
                                                <img src="../uploads/profiles/<?php echo $row['profile_pic']; ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <i class="bi bi-person-fill text-secondary"></i>
                                            <?php endif; ?>
                                        </div>
                                        <span class="text-dark fw-medium" style="font-size: 0.95rem;"><?php echo htmlspecialchars($row['name']); ?></span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['department_name'] ?? 'Not Assigned'); ?></td>
                                <td><span class="badge-role employee">employee</span></td>
                                <td><?php echo date('d M Y', strtotime($row['joining_date'] ?? $row['created_at'])); ?></td>
                                <td>
                                    <?php if($row['status']==1): ?>
                                        <span class="text-success" style="font-size: 0.85rem; font-weight: 500;"><i class="bi bi-circle-fill me-1" style="font-size: 0.4rem; vertical-align: middle;"></i> Active</span>
                                    <?php else: ?>
                                        <span class="text-danger" style="font-size: 0.85rem; font-weight: 500;"><i class="bi bi-circle-fill me-1" style="font-size: 0.4rem; vertical-align: middle;"></i> Inactive</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<?php include "../includes/footer.php"; ?>

