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
"SELECT *
FROM employees
WHERE id='$id'";

$result = mysqli_query($conn,$query);
$employee = mysqli_fetch_assoc($result);

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


$department_query =
"SELECT *
FROM departments
ORDER BY name";
$department_result = mysqli_query($conn,$department_query);

$country_query =
"SELECT *
FROM countries
ORDER BY name";
$country_result = mysqli_query($conn,$country_query);

$state_query =
"SELECT *
FROM states
WHERE country_id='".$employee['country_id']."'
ORDER BY name";
$state_result = mysqli_query($conn,$state_query);

$city_query =
"SELECT *
FROM cities
WHERE state_id='".$employee['state_id']."'
ORDER BY name";
$city_result = mysqli_query($conn,$city_query);

$job_role_query =
"SELECT *
FROM job_roles
WHERE department_id='".$employee['department_id']."'
ORDER BY title";
$job_role_result = mysqli_query($conn,$job_role_query);

if(isset($_POST['update_profile']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];
    $department_id = empty($_POST['department_id']) ? "NULL" : "'" . $_POST['department_id'] . "'";
    $job_role_id = empty($_POST['job_role_id']) ? "NULL" : "'" . $_POST['job_role_id'] . "'";
    $country_id = empty($_POST['country_id']) ? "NULL" : "'" . $_POST['country_id'] . "'";
    $state_id = empty($_POST['state_id']) ? "NULL" : "'" . $_POST['state_id'] . "'";
    $city_id = empty($_POST['city_id']) ? "NULL" : "'" . $_POST['city_id'] . "'";
    $skills = isset($_POST['skills']) ? implode(',', $_POST['skills']) : '';

    $profile_pic = $employee['profile_pic'];
    $resume = $employee['resume'];

    if(!empty($_FILES['profile_pic']['name']))
    {
        $profile_pic = time() . "_" . $_FILES['profile_pic']['name'];
        move_uploaded_file(
            $_FILES['profile_pic']['tmp_name'], 
            "../uploads/profiles/" . $profile_pic
        );
    }

    if(!empty($_FILES['resume']['name']))
    {
        $resume = time() . "_" . $_FILES['resume']['name'];
        move_uploaded_file(
            $_FILES['resume']['tmp_name'],
            "../uploads/resumes/" . $resume
        );
    }

    $update_query =
    "UPDATE employees
    SET
        name='$name',
        phone='$phone',
        designation='$designation',
        department_id=$department_id,
        job_role_id=$job_role_id,
        country_id=$country_id,
        state_id=$state_id,
        city_id=$city_id,
        skills='$skills',
        profile_pic='$profile_pic',
        resume='$resume'
    WHERE id='$id'";

    if(mysqli_query($conn, $update_query))
    {
        echo "<script>
        alert('Profile Updated');
        window.location='profile.php';
        </script>";
    }
}

include "../includes/header.php";
?>

<div class="d-flex">
    <?php include "../includes/employee_sidebar.php"; ?>

    <div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
        
        <!-- Topbar -->
        <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
            <div>
                <i class="bi bi-list fs-4 ms-2 text-secondary"></i>
            </div>
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2 border" style="width: 35px; height: 35px; overflow: hidden;">
                    <?php if(!empty($employee['profile_pic'])): ?>
                        <img src="../uploads/profiles/<?php echo $employee['profile_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <i class="bi bi-person-fill text-secondary"></i>
                    <?php endif; ?>
                </div>
                <span class="fw-medium text-secondary" style="font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
            </div>
        </div>

        <div class="container-fluid p-4">
            <h4 class="mb-4 text-dark fw-bold">My Profile</h4>

            <div class="row g-4 mb-4" id="viewProfileSection">
                <!-- Left Details Card -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-md-5">
                            <h5 class="fw-bold text-primary mb-2">Welcome, <?php echo htmlspecialchars($employee['name']); ?>! 👋</h5>
                            <p class="text-muted mb-5" style="font-size: 0.9rem;">Here is your full profile summary details. Keep your contact details and documents up to date for HR communication.</p>

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

                            <div class="mb-4">
                                <div class="text-muted" style="font-size: 0.8rem; margin-bottom: 8px;">My Resume Document:</div>
                                <?php if(!empty($employee['resume'])): ?>
                                    <a href="../uploads/resumes/<?php echo $employee['resume']; ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3" style="font-size: 0.8rem; border-color: #cbd5e1; color: #3b82f6;"><i class="bi bi-file-earmark-text me-1"></i> Download/View Resume</a>
                                <?php else: ?>
                                    <span class="text-danger fw-medium" style="font-size: 0.85rem;"><i class="bi bi-x-circle me-1"></i> No Resume Uploaded</span>
                                <?php endif; ?>
                            </div>

                            <button onclick="toggleEditMode()" class="btn btn-primary rounded-pill px-4 py-2 mt-2 shadow-sm" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; font-size: 0.9rem; font-weight: 600;"><i class="bi bi-pencil-square me-1"></i> Edit Profile Details</button>
                        </div>
                    </div>
                </div>

                <!-- Right Picture Card -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mb-3" style="width: 140px; height: 140px; overflow: hidden;">
                                <?php if(!empty($employee['profile_pic'])): ?>
                                    <img src="../uploads/profiles/<?php echo $employee['profile_pic']; ?>" style="width:100%;height:100%;object-fit:cover;">
                                <?php else: ?>
                                    <i class="bi bi-person-fill text-secondary" style="font-size: 4rem;"></i>
                                <?php endif; ?>
                            </div>
                            <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($employee['name']); ?></h5>
                            <span class="text-muted" style="font-size: 0.9rem;"><?php echo htmlspecialchars($employee['designation'] ?? 'Employee'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Section (Hidden by Default) -->
            <div class="card border-0 shadow-sm rounded-4 mt-4" id="editProfileSection" style="display: none;">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Update Profile Details</h5>
                        <button onclick="toggleEditMode()" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <h6 class="text-primary fw-bold mb-3">Basic Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Name</label>
                                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email (Read Only)</label>
                                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Phone</label>
                                        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($employee['phone']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Designation</label>
                                        <input type="text" name="designation" class="form-control" value="<?php echo htmlspecialchars($employee['designation']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Department</label>
                                        <select id="department" name="department_id" class="form-select">
                                            <option value="">Select Department</option>
                                            <?php while($department = mysqli_fetch_assoc($department_result)) { ?>
                                                <option value="<?php echo $department['id']; ?>" <?php if($employee['department_id'] == $department['id']) echo "selected"; ?>><?php echo htmlspecialchars($department['name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Job Role</label>
                                        <select id="job_role" name="job_role_id" class="form-select">
                                            <option value="">Select Job Role</option>
                                            <?php while($job_role = mysqli_fetch_assoc($job_role_result)) { ?>
                                                <option value="<?php echo $job_role['id']; ?>" <?php if($employee['job_role_id'] == $job_role['id']) echo "selected"; ?>><?php echo htmlspecialchars($job_role['title']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Country</label>
                                        <select id="country" name="country_id" class="form-select">
                                            <option value="">Select Country</option>
                                            <?php while($country = mysqli_fetch_assoc($country_result)) { ?>
                                                <option value="<?php echo $country['id']; ?>" <?php if($employee['country_id'] == $country['id']) echo "selected"; ?>><?php echo htmlspecialchars($country['name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">State</label>
                                        <select id="state" name="state_id" class="form-select">
                                            <option value="">Select State</option>
                                            <?php while($state = mysqli_fetch_assoc($state_result)) { ?>
                                                <option value="<?php echo $state['id']; ?>" <?php if($employee['state_id'] == $state['id']) echo "selected"; ?>><?php echo htmlspecialchars($state['name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">City</label>
                                        <select id="city" name="city_id" class="form-select">
                                            <option value="">Select City</option>
                                            <?php while($city = mysqli_fetch_assoc($city_result)) { ?>
                                                <option value="<?php echo $city['id']; ?>" <?php if($employee['city_id'] == $city['id']) echo "selected"; ?>><?php echo htmlspecialchars($city['name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-4 mb-2">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Skills</label>
                                    <?php $emp_skills = explode(',', $employee['skills'] ?? ''); ?>
                                    <div class="d-flex flex-wrap gap-3 mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="PHP" id="s1" <?php if(in_array('PHP', $emp_skills)) echo 'checked'; ?>>
                                            <label class="form-check-label" for="s1">PHP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="MySQL" id="s2" <?php if(in_array('MySQL', $emp_skills)) echo 'checked'; ?>>
                                            <label class="form-check-label" for="s2">MySQL</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="HTML" id="s3" <?php if(in_array('HTML', $emp_skills)) echo 'checked'; ?>>
                                            <label class="form-check-label" for="s3">HTML</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="CSS" id="s4" <?php if(in_array('CSS', $emp_skills)) echo 'checked'; ?>>
                                            <label class="form-check-label" for="s4">CSS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="JavaScript" id="s5" <?php if(in_array('JavaScript', $emp_skills)) echo 'checked'; ?>>
                                            <label class="form-check-label" for="s5">JavaScript</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <h6 class="text-primary fw-bold mb-3">Documents & Media</h6>
                                <div class="mb-4 text-center p-3 rounded bg-light border">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Update Profile Picture</label>
                                    <?php if(!empty($employee['profile_pic'])) { ?>
                                        <div class="mb-3 mt-2">
                                            <img src="../uploads/profiles/<?php echo $employee['profile_pic']; ?>" class="rounded-circle shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                    <?php } ?>
                                    <input type="file" name="profile_pic" class="form-control form-control-sm" accept="image/*">
                                </div>
                                
                                <div class="mb-3 p-3 rounded bg-light border text-center">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Update Resume</label>
                                    <?php if(!empty($employee['resume'])) { ?>
                                        <div class="mb-3 mt-2">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2"><i class="bi bi-check-circle"></i> Document Uploaded</span>
                                        </div>
                                    <?php } ?>
                                    <input type="file" name="resume" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" onclick="toggleEditMode()" class="btn btn-light me-2 fw-medium">Cancel</button>
                            <button type="submit" name="update_profile" class="btn btn-primary fw-bold px-4">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function toggleEditMode() {
                    var viewSec = document.getElementById('viewProfileSection');
                    var editSec = document.getElementById('editProfileSection');
                    if (viewSec.style.display === 'none') {
                        viewSec.style.display = 'flex';
                        editSec.style.display = 'none';
                    } else {
                        viewSec.style.display = 'none';
                        editSec.style.display = 'block';
                    }
                }

                document.getElementById("country").addEventListener("change", function() {
                    let countryId = this.value;
                    fetch("../api/get_states.php?country_id=" + countryId)
                        .then(response => response.text())
                        .then(data => { document.getElementById("state").innerHTML = data; });
                });

                document.getElementById("state").addEventListener("change", function() {
                    let stateId = this.value;
                    fetch("../api/get_cities.php?state_id=" + stateId)
                        .then(response => response.text())
                        .then(data => { document.getElementById("city").innerHTML = data; });
                });

                document.getElementById("department").addEventListener("change", function() {
                    let departmentId = this.value;
                    fetch("../api/get_job_roles.php?department_id=" + departmentId)
                        .then(response => response.text())
                        .then(data => { document.getElementById("job_role").innerHTML = data; });
                });
            </script>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
