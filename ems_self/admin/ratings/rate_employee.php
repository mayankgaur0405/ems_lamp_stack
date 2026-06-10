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

if(isset($_POST['submit_rating']))
{
    $employee_id =
    $_POST['employee_id'];

    $rating =
    $_POST['rating'];

    $review =
    $_POST['review'];

    $rated_by =
    $_SESSION['id'];

    $insert_query =
    "INSERT INTO employee_ratings
    (
        employee_id,
        rated_by,
        rating,
        review
    )
    VALUES
    (
        '$employee_id',
        '$rated_by',
        '$rating',
        '$review'
    )";

    if(
        mysqli_query(
            $conn,
            $insert_query
        )
    )
    {
        echo
        "<script>
        alert('Rating Submitted');
        </script>";
    }
}

$employee_query =
"SELECT e.*, d.name AS department_name
FROM employees e
LEFT JOIN departments d ON e.department_id = d.id
WHERE e.role='employee'
AND e.status=1
ORDER BY e.name";

$employee_result =
mysqli_query(
$conn,
$employee_query
);

// Check if an employee is selected for evaluation
$selected_employee = null;
if(isset($_GET['emp_id'])) {
    $emp_id = $_GET['emp_id'];
    $sel_query = "SELECT e.*, d.name AS department_name FROM employees e LEFT JOIN departments d ON e.department_id = d.id WHERE e.id='$emp_id'";
    $sel_result = mysqli_query($conn, $sel_query);
    $selected_employee = mysqli_fetch_assoc($sel_result);
}

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
        
        <h4 class="mb-4 text-dark fw-normal"><i class="bi bi-star-fill text-warning me-2"></i> Performance <span class="fw-bold">Ratings & Feedback</span></h4>
        
        <div class="row g-4">
            <!-- Left: Employee List -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="text-primary fw-bold mb-3">Select Employee to Evaluate</h6>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Employee</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while($employee = mysqli_fetch_assoc($employee_result)) {
                                    ?>
                                    <tr class="<?php echo (isset($_GET['emp_id']) && $_GET['emp_id'] == $employee['id']) ? 'table-active' : ''; ?>">
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; overflow: hidden;">
                                                    <?php if(!empty($employee['profile_pic'])): ?>
                                                        <img src="../../uploads/profiles/<?php echo $employee['profile_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                                                    <?php else: ?>
                                                        <i class="bi bi-person-fill text-secondary"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <span class="fw-bold d-block" style="font-size: 0.85rem;"><?php echo htmlspecialchars($employee['name']); ?></span>
                                                    <span class="text-muted" style="font-size: 0.75rem;"><?php echo htmlspecialchars($employee['designation'] ?? 'Employee'); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted" style="font-size: 0.85rem;"><?php echo htmlspecialchars($employee['department_name'] ?? 'N/A'); ?></td>
                                        <td>
                                            <a href="rate_employee.php?emp_id=<?php echo $employee['id']; ?>" class="btn btn-primary btn-sm rounded-pill px-3" style="font-size: 0.75rem;">Evaluate</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Rating Form -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <?php if($selected_employee): ?>
                            <h6 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning me-1"></i> Evaluate: <?php echo htmlspecialchars($selected_employee['name']); ?></h6>
                            
                            <div class="d-flex align-items-center mb-4 p-3 rounded-3" style="background: #f8fafc;">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; overflow: hidden;">
                                    <?php if(!empty($selected_employee['profile_pic'])): ?>
                                        <img src="../../uploads/profiles/<?php echo $selected_employee['profile_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                                    <?php else: ?>
                                        <i class="bi bi-person-fill text-secondary fs-5"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="fw-bold d-block"><?php echo htmlspecialchars($selected_employee['name']); ?></span>
                                    <span class="text-muted" style="font-size: 0.8rem;"><?php echo htmlspecialchars($selected_employee['designation'] ?? 'Employee'); ?> • <?php echo htmlspecialchars($selected_employee['department_name'] ?? 'N/A'); ?></span>
                                </div>
                            </div>

                            <form method="POST">
                                <input type="hidden" name="employee_id" value="<?php echo $selected_employee['id']; ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size: 0.85rem;">Select Rating (1 to 5 Stars)</label>
                                    <select name="rating" class="form-select" required>
                                        <option value="">Click a star to assign rating</option>
                                        <option value="1">1 ⭐</option>
                                        <option value="2">2 ⭐⭐</option>
                                        <option value="3">3 ⭐⭐⭐</option>
                                        <option value="4">4 ⭐⭐⭐⭐</option>
                                        <option value="5">5 ⭐⭐⭐⭐⭐</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="font-size: 0.85rem;">Performance Evaluation & Feedback Comments</label>
                                    <textarea name="review" class="form-control" rows="4" placeholder="Provide constructive feedback, achievements, or milestones achieved by the employee..."></textarea>
                                </div>
                                
                                <button type="submit" name="submit_rating" class="btn btn-primary w-100 py-2 fw-bold" style="background: linear-gradient(135deg, #1c2438, #2d3a5c); border: none;">Submit Evaluation</button>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-arrow-left-circle fs-1 mb-3 d-block" style="opacity: 0.3;"></i>
                                <p>Select an employee from the list to start evaluation</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<?php include "../../includes/footer.php"; ?>