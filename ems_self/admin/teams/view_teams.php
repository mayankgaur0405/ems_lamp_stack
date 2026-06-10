<?php

session_start();

if(
    !isset($_SESSION['id'])
    ||
    $_SESSION['role'] != 'admin'
)
{
    header("Location: ../index.php");
    exit;
}

include "../../includes/db.php";

$department_query =
"SELECT *
FROM departments
ORDER BY name";

$department_result =
mysqli_query(
$conn,
$department_query
);

// Also get unassigned employees
$unassigned_query = "SELECT e.*, 
COALESCE((SELECT ROUND(AVG(r.rating),1) FROM employee_ratings r WHERE r.employee_id = e.id), 0) as avg_rating
FROM employees e WHERE e.department_id IS NULL OR e.department_id = 0 AND e.role='employee' AND e.status=1 ORDER BY e.name";
$unassigned_result = mysqli_query($conn, $unassigned_query);

?>

<?php include "../../includes/header.php"; ?>

<div class="d-flex">

<?php include "../../includes/sidebar.php"; ?>

<div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <div><i class="bi bi-list fs-4 ms-2 text-secondary"></i></div>
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: 600; font-size: 0.9rem;">SA</div>
            <span class="fw-medium text-secondary" style="font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
        </div>
    </div>

    <div class="container-fluid p-4">
        
        <div class="mb-4">
            <h4 class="text-dark fw-bold mb-1"><i class="bi bi-diagram-3-fill me-2" style="color: #f59e0b;"></i> Department Teams</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">View and filter employee team members grouped by their departments.</p>
        </div>

        <?php
        while(
        $department =
        mysqli_fetch_assoc(
        $department_result
        ))
        {
            $employee_query =
            "SELECT e.*,
            COALESCE((SELECT ROUND(AVG(r.rating),1) FROM employee_ratings r WHERE r.employee_id = e.id), 0) as avg_rating
            FROM employees e
            WHERE department_id='".$department['id']."'
            AND role='employee'
            AND status=1
            ORDER BY name";

            $employee_result =
            mysqli_query(
            $conn,
            $employee_query
            );
            
            $emp_count = mysqli_num_rows($employee_result);
        ?>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-building me-2" style="color: #38bdf8;"></i> <?php echo htmlspecialchars($department['name']); ?> Department</h6>
                    <span class="text-primary" style="font-size: 0.85rem; font-weight: 500;"><?php echo $emp_count; ?> Member<?php echo $emp_count != 1 ? 's' : ''; ?></span>
                </div>

                <?php if($emp_count > 0) { ?>
                <div class="row g-3">
                    <?php while($employee = mysqli_fetch_assoc($employee_result)) { ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 border" style="border-radius: 12px;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; overflow: hidden;">
                                        <?php if(!empty($employee['profile_pic'])): ?>
                                            <img src="../../uploads/profiles/<?php echo $employee['profile_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                                        <?php else: ?>
                                            <i class="bi bi-person-fill text-secondary"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;"><?php echo htmlspecialchars($employee['name']); ?></span>
                                        <span class="text-primary" style="font-size: 0.75rem;"><?php echo htmlspecialchars($employee['designation'] ?? 'Employee'); ?></span>
                                    </div>
                                </div>
                                <div style="font-size: 0.8rem;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">HR PERFORMANCE:</span>
                                        <span class="fw-bold"><?php echo $employee['avg_rating']; ?> ⭐</span>
                                    </div>
                                    <div class="text-muted"><i class="bi bi-envelope me-1"></i> <?php echo htmlspecialchars($employee['email']); ?></div>
                                    <div class="text-muted"><i class="bi bi-telephone me-1"></i> <?php echo htmlspecialchars($employee['phone']); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } else { ?>
                    <p class="text-muted mb-0">No Employees Assigned</p>
                <?php } ?>
            </div>
        </div>

        <?php } ?>

    </div>
</div>
</div>

<?php include "../../includes/footer.php"; ?>