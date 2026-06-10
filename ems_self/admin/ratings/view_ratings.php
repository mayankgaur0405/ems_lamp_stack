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

$query =
"SELECT

r.*,

e.name AS employee_name,
e.designation AS employee_designation,
e.profile_pic AS employee_pic,

a.name AS admin_name,
a.role AS admin_role

FROM employee_ratings r

LEFT JOIN employees e
ON r.employee_id = e.id

LEFT JOIN employees a
ON r.rated_by = a.id

ORDER BY r.id DESC";

$result =
mysqli_query(
$conn,
$query
);

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
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-dark fw-bold"><i class="bi bi-clipboard-data-fill me-2" style="color: #94a3b8;"></i> Performance Reviews Log</h4>
            <a href="rate_employee.php" class="btn btn-primary rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i> Add New Rating</a>
        </div>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Rating</th>
                                <th>Evaluation Comments</th>
                                <th>Evaluated By</th>
                                <th>Date Evaluated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; overflow: hidden;">
                                            <?php if(!empty($row['employee_pic'])): ?>
                                                <img src="../../uploads/profiles/<?php echo $row['employee_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                                            <?php else: ?>
                                                <i class="bi bi-person-fill text-secondary"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block" style="font-size: 0.9rem;"><?php echo htmlspecialchars($row['employee_name']); ?></span>
                                            <span class="text-muted" style="font-size: 0.75rem;"><?php echo htmlspecialchars($row['employee_designation'] ?? 'Employee'); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php for($i=1; $i<=$row['rating']; $i++) { echo "⭐"; } ?>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 0.85rem;">
                                    <?php 
                                    if(!empty($row['review'])) {
                                        $short_review = substr($row['review'],0,100);
                                        $last_space_pos = strrpos($short_review,' ');
                                        if($last_space_pos !== false && strlen($row['review']) > 100) {
                                            echo htmlspecialchars(substr($short_review, 0, $last_space_pos).' ...');
                                        } else {
                                            echo htmlspecialchars($row['review']);
                                        }
                                    } else {
                                        echo '--';
                                    }
                                    ?>
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold d-block" style="font-size: 0.85rem;"><?php echo htmlspecialchars($row['admin_name']); ?></span>
                                        <span class="text-muted" style="font-size: 0.75rem;">System <?php echo ucfirst($row['admin_role'] ?? 'admin'); ?></span>
                                    </div>
                                </td>
                                <td class="text-muted" style="font-size: 0.85rem;"><?php echo date('d M Y h:i A', strtotime($row['rated_at'])); ?></td>
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

<?php include "../../includes/footer.php"; ?>