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

if(!isset($_GET['id']))
{
    header("Location:view_employee.php");
    exit;
}

$id = $_GET['id'];

$query =
"SELECT *
FROM employees
WHERE id='$id'";

$result = mysqli_query($conn,$query);

$employee = mysqli_fetch_assoc($result);

$department_query =
"SELECT *
FROM departments
ORDER BY name";

$department_result =
mysqli_query($conn,$department_query);

$country_query =
"SELECT *
FROM countries
ORDER BY name";

$country_result =
mysqli_query($conn,$country_query);

if(isset($_POST['update_employee']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department_id = $_POST['department_id'];
    $joining_date = $_POST['joining_date'];
    
    $designation = $_POST['designation'];
    $country_id = $_POST['country_id'];
    $state_id = $_POST['state_id'];
    $city_id = $_POST['city_id'];
    $job_role_id = $_POST['job_role_id'];

    $skills = isset($_POST['skills']) ? implode(',', $_POST['skills']) : '';

    $profile_pic_query = "";
    $resume_query = "";

    if(!empty($_FILES['profile_pic']['name']))
    {
        $profile_pic = time() . "_" . $_FILES['profile_pic']['name'];
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "../../uploads/profiles/" . $profile_pic);
        $profile_pic_query = ", profile_pic='$profile_pic'";
    }

    if(!empty($_FILES['resume']['name']))
    {
        $resume = time() . "_" . $_FILES['resume']['name'];
        move_uploaded_file($_FILES['resume']['tmp_name'], "../../uploads/resumes/" . $resume);
        $resume_query = ", resume='$resume'";
    }

    $update_query =
    "UPDATE employees
    SET
    name='$name',
    email='$email',
    phone='$phone',
    department_id='$department_id',
    designation='$designation',
    country_id='$country_id',
    state_id='$state_id',
    city_id='$city_id',
    job_role_id='$job_role_id',
    skills='$skills',
    joining_date='$joining_date'
    $profile_pic_query
    $resume_query
    WHERE id='$id'";

    if(mysqli_query($conn,$update_query))
    {
        echo "<script>
        alert('Employee Updated Successfully');
        window.location='view_employee.php';
        </script>";
    }
}

?>

<?php include "../../includes/header.php"; ?>

<div class="d-flex">

<?php include "../../includes/sidebar.php"; ?>

<div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
    <!-- Topbar -->
    <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <div>
            <i class="bi bi-list fs-4 ms-2 text-secondary"></i>
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
        
        <h4 class="mb-4 text-dark fw-bold">Edit Employee</h4>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Department</label>
                                <select id="department" name="department_id" class="form-select" required>
                                    <option value="">-- Select Department --</option>
                                    <?php while($department = mysqli_fetch_assoc($department_result)) { ?>
                                        <option value="<?php echo $department['id']; ?>" <?php if($department['id'] == $employee['department_id']) echo "selected"; ?>><?php echo htmlspecialchars($department['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Country</label>
                                <select id="country" name="country_id" class="form-select">
                                    <option value="">-- Select Country --</option>
                                    <?php while($country = mysqli_fetch_assoc($country_result)) { ?>
                                        <option value="<?php echo $country['id']; ?>" <?php if($country['id'] == $employee['country_id']) echo "selected"; ?>><?php echo htmlspecialchars($country['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">City</label>
                                <!-- We populate this via AJAX usually, but to preserve selected value, we just add a placeholder and JS handles it, OR we pre-fill. For simplicity, we add a data attribute for JS to use. -->
                                <select id="city" name="city_id" class="form-select" data-selected="<?php echo $employee['city_id']; ?>">
                                    <option value="">-- Select City First --</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Update Profile Picture</label>
                                <?php if(!empty($employee['profile_pic'])): ?>
                                    <div class="mb-2">
                                        <img src="../../uploads/profiles/<?php echo $employee['profile_pic']; ?>" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="profile_pic" class="form-control" accept="image/*">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Designation</label>
                                <input type="text" name="designation" class="form-control" value="<?php echo htmlspecialchars($employee['designation']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>" required readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">System Access Role</label>
                                <select class="form-select" disabled>
                                    <option>Employee (Default)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Job Role</label>
                                <select id="job_role" name="job_role_id" class="form-select" data-selected="<?php echo $employee['job_role_id']; ?>">
                                    <option value="">-- Select Department First --</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Skills</label>
                                <?php
                                $emp_skills_string = isset($employee['skills']) ? $employee['skills'] : '';
                                $emp_skills = explode(',', $emp_skills_string);
                                ?>
                                <div class="d-flex flex-wrap gap-3 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="PHP" id="ePHP" <?php if(in_array('PHP', $emp_skills)) echo 'checked'; ?>>
                                        <label class="form-check-label" for="ePHP">PHP</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="MySQL" id="eMySQL" <?php if(in_array('MySQL', $emp_skills)) echo 'checked'; ?>>
                                        <label class="form-check-label" for="eMySQL">MySQL</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="HTML" id="eHTML" <?php if(in_array('HTML', $emp_skills)) echo 'checked'; ?>>
                                        <label class="form-check-label" for="eHTML">HTML</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="CSS" id="eCSS" <?php if(in_array('CSS', $emp_skills)) echo 'checked'; ?>>
                                        <label class="form-check-label" for="eCSS">CSS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="JavaScript" id="eJS" <?php if(in_array('JavaScript', $emp_skills)) echo 'checked'; ?>>
                                        <label class="form-check-label" for="eJS">JavaScript</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">State</label>
                                <select id="state" name="state_id" class="form-select" data-selected="<?php echo $employee['state_id']; ?>">
                                    <option value="">-- Select State First --</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Joining Date</label>
                                <input type="date" name="joining_date" class="form-control" value="<?php echo $employee['joining_date']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Update Resume</label>
                                <?php if(!empty($employee['resume'])): ?>
                                    <div class="mb-2 text-primary" style="font-size: 0.85rem;">
                                        <i class="bi bi-file-earmark-text"></i> Current Resume Uploaded
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" name="update_employee" class="btn btn-primary px-4 py-2">Update Employee</button>
                        <a href="view_employee.php" class="btn btn-outline-primary px-4 py-2">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Outputting current selected IDs for JS to auto-load dropdowns if needed -->
<script>
    window.onload = function() {
        const countrySelect = document.getElementById('country');
        const stateSelect = document.getElementById('state');
        const citySelect = document.getElementById('city');
        const deptSelect = document.getElementById('department');
        const jobRoleSelect = document.getElementById('job_role');

        const selectedState = stateSelect.getAttribute('data-selected');
        const selectedCity = citySelect.getAttribute('data-selected');
        const selectedJobRole = jobRoleSelect.getAttribute('data-selected');

        // Trigger change on country to load states
        if(countrySelect.value) {
            // Wait for JS files to load
            setTimeout(() => {
                let event = new Event('change');
                countrySelect.dispatchEvent(event);
                
                // Hack to pre-select state and trigger city load
                setTimeout(() => {
                    if(selectedState) {
                        stateSelect.value = selectedState;
                        stateSelect.dispatchEvent(new Event('change'));
                        
                        setTimeout(() => {
                            if(selectedCity) citySelect.value = selectedCity;
                        }, 500);
                    }
                }, 500);
            }, 500);
        }

        if(deptSelect.value) {
            setTimeout(() => {
                let event = new Event('change');
                deptSelect.dispatchEvent(event);

                setTimeout(() => {
                    if(selectedJobRole) jobRoleSelect.value = selectedJobRole;
                }, 500);
            }, 500);
        }
    }
</script>

<script src="../../assets/js/location.js"></script>
<script src="../../assets/js/job_roles.js"></script>

<?php include "../../includes/footer.php"; ?>