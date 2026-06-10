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

if(!isset($_GET['id'])) {
    header("Location: view_employee.php");
    exit;
}

$id = $_GET['id'];

$query =
"SELECT *
FROM employees
WHERE id='$id'";

$result = mysqli_query($conn,$query);
$employee = mysqli_fetch_assoc($result);

if(!$employee) {
    header("Location: view_employee.php");
    exit;
}

// Get Department name
$dept_name = 'N/A';
if(!empty($employee['department_id'])) {
    $d_res = mysqli_query($conn, "SELECT name FROM departments WHERE id='".$employee['department_id']."'");
    if($d_row = mysqli_fetch_assoc($d_res)) $dept_name = $d_row['name'];
}

// Get Job Role title
$job_title = 'N/A';
if(!empty($employee['job_role_id'])) {
    $j_res = mysqli_query($conn, "SELECT title FROM job_roles WHERE id='".$employee['job_role_id']."'");
    if($j_row = mysqli_fetch_assoc($j_res)) $job_title = $j_row['title'];
}

// Get Location Names
$country_name = 'N/A';
if(!empty($employee['country_id'])) {
    $c_res = mysqli_query($conn, "SELECT name FROM countries WHERE id='".$employee['country_id']."'");
    if($c_row = mysqli_fetch_assoc($c_res)) $country_name = $c_row['name'];
}
$state_name = 'N/A';
if(!empty($employee['state_id'])) {
    $s_res = mysqli_query($conn, "SELECT name FROM states WHERE id='".$employee['state_id']."'");
    if($s_row = mysqli_fetch_assoc($s_res)) $state_name = $s_row['name'];
}
$city_name = 'N/A';
if(!empty($employee['city_id'])) {
    $ci_res = mysqli_query($conn, "SELECT name FROM cities WHERE id='".$employee['city_id']."'");
    if($ci_row = mysqli_fetch_assoc($ci_res)) $city_name = $ci_row['name'];
}

include "../../includes/header.php";
?>

<div class="d-flex">
    <?php include "../../includes/sidebar.php"; ?>

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
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark fw-bold"><i class="bi bi-person-badge text-primary me-2"></i> Employee Profile</h4>
                <a href="view_employee.php" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
            </div>

            <div class="row g-4 mb-4">
                <!-- Left Details Card -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h5 class="fw-bold text-primary mb-1"><?php echo htmlspecialchars($employee['name']); ?></h5>
                                    <p class="text-muted" style="font-size: 0.9rem;">Full profile and contact details.</p>
                                </div>
                                <a href="edit_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-warning rounded-pill btn-sm px-3 fw-bold"><i class="bi bi-pencil-fill me-1"></i> Edit Profile</a>
                            </div>

                            <div class="row g-4 mb-5">
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">Email:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($employee['email']); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">Department:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($dept_name); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">Job Role:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($job_title); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">Phone:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($employee['phone']); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">Joined:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo date('d M Y', strtotime($employee['joining_date'])); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">Country:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($country_name); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">State:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($state_name); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 2px;">City:</div>
                                    <div class="fw-medium text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($city_name); ?></div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 8px;">Skills:</div>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php 
                                        $skills = explode(',', $employee['skills'] ?? '');
                                        foreach($skills as $skill) {
                                            if(trim($skill) != '') {
                                                echo '<span class="badge bg-light text-dark border px-3 py-2 rounded-pill">' . htmlspecialchars(trim($skill)) . '</span>';
                                            }
                                        }
                                        if(empty($skills) || trim($skills[0]) == '') echo '<span class="text-muted">No skills listed</span>';
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 8px;">Resume Document:</div>
                                    <?php if(!empty($employee['resume'])): ?>
                                        <a href="../../uploads/resumes/<?php echo $employee['resume']; ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3" style="font-size: 0.8rem; border-color: #cbd5e1; color: #3b82f6;"><i class="bi bi-file-earmark-text me-1"></i> Download/View Resume</a>
                                    <?php else: ?>
                                        <span class="text-danger fw-medium" style="font-size: 0.85rem;"><i class="bi bi-x-circle me-1"></i> No Resume Uploaded</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Picture Card -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mb-3" style="width: 140px; height: 140px; overflow: hidden;">
                                <?php if(!empty($employee['profile_pic'])): ?>
                                    <img src="../../uploads/profiles/<?php echo $employee['profile_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                                <?php else: ?>
                                    <i class="bi bi-person-fill text-secondary" style="font-size: 4rem;"></i>
                                <?php endif; ?>
                            </div>
                            <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($employee['name']); ?></h5>
                            <span class="text-muted mb-2" style="font-size: 0.9rem;"><?php echo htmlspecialchars($employee['designation'] ?? 'Employee'); ?></span>
                            
                            <?php if($employee['status'] == 1): ?>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mt-2"><i class="bi bi-check-circle-fill me-1"></i> Active Account</span>
                            <?php else: ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill mt-2"><i class="bi bi-slash-circle-fill me-1"></i> Disabled Account</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "../../includes/footer.php"; ?>
