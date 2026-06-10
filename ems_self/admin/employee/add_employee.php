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
require "../../includes/mail_config.php";

if(isset($_POST['add_employee']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $department_id = $_POST['department_id'];
    $joining_date = $_POST['joining_date'];


    $designation = $_POST['designation'];


    $country_id = $_POST['country_id'];

    $state_id = $_POST['state_id'];

    $city_id = $_POST['city_id'];

    $job_role_id = $_POST['job_role_id'];

   $skills = isset($_POST['skills']) ? implode(',', $_POST['skills']) : '';
   //    exit();

    $profile_pic = "";

    $resume = "";


    if(!empty($_FILES['profile_pic']['name']))
{
    $profile_pic =
    time() . "_" .
    $_FILES['profile_pic']['name'];

    move_uploaded_file(
        $_FILES['profile_pic']['tmp_name'],
        "../../uploads/profiles/" . $profile_pic
    );
}

if(!empty($_FILES['resume']['name']))
{
    $resume =
    time() . "_" .
    $_FILES['resume']['name'];

    move_uploaded_file(
        $_FILES['resume']['tmp_name'],
        "../../uploads/resumes/" . $resume
    );
}

    $check_query =
    "SELECT *
    FROM employees
    WHERE email='$email'";

    $check_result =
    mysqli_query($conn,$check_query);

    if(mysqli_num_rows($check_result) > 0)
    {
        echo "<script>alert('Email Already Exists');</script>";
    }
    else
    {
        $token = bin2hex(random_bytes(32));

        $insert_query =
        "INSERT INTO employees
        (
            name,
            email,
            phone,
            password,
            department_id,
            designation,
            country_id,
            state_id,
            city_id,
            job_role_id,
            skills,
            profile_pic,
            resume,
            joining_date,
            status,
            verification_token
        )
        VALUES
        (
            '$name',
            '$email',
            '$phone',
            '$password',
           '$department_id',
            '$designation',
            '$country_id',
            '$state_id',
            '$city_id',
            '$job_role_id',
            '$skills',
            '$profile_pic',
            '$resume',
            '$joining_date',
            0,
            '$token'
        )";

        if(mysqli_query($conn,$insert_query))
        {
            $verify_link = "http://" . $_SERVER['HTTP_HOST'] . "/php-training-pe-front/study/ems_self/verify.php?token=" . $token;
            $body = "<h3>Hello $name,</h3><p>Your account has been created. Please click the link below to verify your email and activate your account:</p><p><a href='$verify_link'>$verify_link</a></p>";
            send_mail($email, $name, 'Verify Your Account', $body);

            echo "<script>alert('Employee Added. Verification email sent.');</script>";
        }
    }
}

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

?>

<?php include "../../includes/header.php"; ?>

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
        
        <h4 class="mb-4 text-dark fw-bold">Add Employee</h4>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="9876543210" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Department</label>
                                <select id="department" name="department_id" class="form-select" required>
                                    <option value="">-- Select Department --</option>
                                    <?php while($department = mysqli_fetch_assoc($department_result)) { ?>
                                        <option value="<?php echo $department['id']; ?>"><?php echo htmlspecialchars($department['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">System Access Role</label>
                                <select class="form-select" disabled>
                                    <option>Employee (Default)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Country</label>
                                <select id="country" name="country_id" class="form-select">
                                    <option value="">-- Select Country --</option>
                                    <?php while($country = mysqli_fetch_assoc($country_result)) { ?>
                                        <option value="<?php echo $country['id']; ?>"><?php echo htmlspecialchars($country['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">City</label>
                                <select id="city" name="city_id" class="form-select">
                                    <option value="">-- Select City First --</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Upload Profile Picture</label>
                                <input type="file" name="profile_pic" class="form-control" accept="image/*">
                            </div>
                            
                            <!-- Hidden Designation field mapped to Job Role for consistency, but if they want Designation we can keep it as is. Current code has both Designation and Job Role -->
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Designation</label>
                                <input type="text" name="designation" class="form-control" placeholder="Software Engineer" required>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="john@company.com" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Job Role</label>
                                <select id="job_role" name="job_role_id" class="form-select">
                                    <option value="">-- Select Department First --</option>
                                </select>
                            </div>
                            
                            <!-- Skills Checkboxes (Preserved functionality not in mockup) -->
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Skills (Retained functionality)</label>
                                <div class="d-flex flex-wrap gap-3 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="PHP" id="skillPHP">
                                        <label class="form-check-label" for="skillPHP">PHP</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="MySQL" id="skillMySQL">
                                        <label class="form-check-label" for="skillMySQL">MySQL</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="HTML" id="skillHTML">
                                        <label class="form-check-label" for="skillHTML">HTML</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="CSS" id="skillCSS">
                                        <label class="form-check-label" for="skillCSS">CSS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="JavaScript" id="skillJS">
                                        <label class="form-check-label" for="skillJS">JavaScript</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">State</label>
                                <select id="state" name="state_id" class="form-select">
                                    <option value="">-- Select State First --</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Joining Date</label>
                                <input type="date" name="joining_date" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Upload Resume</label>
                                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" name="add_employee" class="btn btn-primary px-4 py-2">Add Employee</button>
                        <a href="view_employee.php" class="btn btn-outline-primary px-4 py-2">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script src="../../assets/js/location.js"></script>
<script src="../../assets/js/job_roles.js"></script>

<?php include "../../includes/footer.php"; ?>
</body>
</html>