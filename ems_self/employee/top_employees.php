<?php

session_start();

if(
    !isset($_SESSION['id'])
    ||
    $_SESSION['role'] != 'employee'
)
{
    header("Location: index.php");
    exit;
}

include "../includes/db.php";

$query =
"SELECT
e.id,
e.name,
e.email,
e.designation,
e.profile_pic,
d.name AS department_name,
AVG(r.rating) AS avg_rating,
COUNT(r.id) AS total_reviews
FROM employees e
LEFT JOIN employee_ratings r ON e.id = r.employee_id
LEFT JOIN departments d ON e.department_id = d.id
WHERE e.role='employee'
GROUP BY e.id
ORDER BY avg_rating DESC
LIMIT 10";

$result = mysqli_query($conn, $query);

?>

<?php include "../includes/header.php"; ?>

<div class="d-flex">

<?php include "../includes/employee_sidebar.php"; ?>

<div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
    <!-- Topbar -->
    <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <div>
            <i class="bi bi-list fs-4 ms-2 text-secondary"></i>
        </div>
        <div class="d-flex align-items-center">
            <span class="fw-medium text-secondary me-3" style="font-size: 0.9rem;">
                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['name']); ?>
            </span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid p-4">
        
        <div class="mb-4">
            <h4 class="mb-1 text-dark fw-bold"><i class="bi bi-trophy-fill me-2" style="color: #f59e0b;"></i> Top Employees Leaderboard</h4>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">Here are our highest-rated employees based on performance evaluations by HR and Management. Keep up the amazing work!</p>
        </div>
        
        <div class="mt-4">
            <?php
            $rank = 1;
            while($row = mysqli_fetch_assoc($result)) {
                
                $bg_color = "#ffffff";
                $border_color = "#e2e8f0";
                
                if($rank == 1) {
                    $bg_color = "#fef08a"; // Gold
                    $border_color = "#facc15";
                } else if($rank == 2) {
                    $bg_color = "#e2e8f0"; // Silver
                    $border_color = "#cbd5e1";
                } else if($rank == 3) {
                    $bg_color = "#fed7aa"; // Bronze
                    $border_color = "#fdba74";
                }
            ?>
            <div class="card mb-3 shadow-sm border" style="background-color: <?php echo $bg_color; ?>; border-color: <?php echo $border_color; ?> !important; border-radius: 12px;">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    
                    <div class="d-flex align-items-center">
                        <div class="me-4 fs-5 fw-bold text-center" style="width: 30px; color: #475569;">
                            <?php
                            if($rank == 1) echo "🥇";
                            else if($rank == 2) echo "🥈";
                            else if($rank == 3) echo "🥉";
                            else echo "#" . $rank;
                            ?>
                        </div>
                        
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3 shadow-sm border" style="width: 45px; height: 45px; overflow: hidden; border-color: <?php echo $border_color; ?> !important;">
                            <?php if(!empty($row['profile_pic'])): ?>
                                <img src="../uploads/profiles/<?php echo $row['profile_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                            <?php else: ?>
                                <i class="bi bi-person-fill text-secondary fs-4"></i>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <span class="fw-bold text-dark d-block" style="font-size: 1rem;"><?php echo htmlspecialchars($row['name']); ?></span>
                            <span class="text-muted" style="font-size: 0.75rem;"><?php echo htmlspecialchars($row['designation'] ?? 'Employee'); ?> • <?php echo htmlspecialchars($row['department_name'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <div class="fw-bold fs-5 text-dark mb-0 line-height-1">
                            <?php echo $row['avg_rating'] ? round($row['avg_rating'], 1) : "0"; ?> <span style="color: #f59e0b; font-size: 1.1rem;">⭐</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.7rem;"><?php echo $row['total_reviews']; ?> HR review<?php echo $row['total_reviews'] != 1 ? 's' : ''; ?></div>
                    </div>
                    
                </div>
            </div>
            <?php
            $rank++;
            }
            ?>
        </div>

    </div>
</div>
</div>

<?php include "../includes/footer.php"; ?>