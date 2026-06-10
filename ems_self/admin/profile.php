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

$id = $_SESSION['id'];

$query =
"SELECT *
FROM employees
WHERE id='$id'";

$result = mysqli_query($conn,$query);
$admin = mysqli_fetch_assoc($result);

if(isset($_POST['update_profile']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];

    $update_query =
    "UPDATE employees
    SET
        name='$name',
        phone='$phone',
        designation='$designation'
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
    <?php include "../includes/sidebar.php"; ?>

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
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark fw-bold"><i class="bi bi-person-badge text-primary me-2"></i> Admin Profile</h4>
                <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Back to Dashboard</a>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8 col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-5">
                            
                            <div class="d-flex align-items-center mb-5">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px;">
                                    <i class="bi bi-person-fill fs-1"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($admin['name']); ?></h5>
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="bi bi-shield-lock-fill me-1"></i> System Administrator</span>
                                </div>
                            </div>
                            
                            <form method="POST">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Full Name</label>
                                        <input type="text" name="name" class="form-control bg-light" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email Address</label>
                                        <input type="email" class="form-control bg-light text-muted" value="<?php echo htmlspecialchars($admin['email']); ?>" readonly>
                                        <div class="form-text" style="font-size: 0.75rem;">Email address cannot be changed.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Phone Number</label>
                                        <input type="text" name="phone" class="form-control bg-light" value="<?php echo htmlspecialchars($admin['phone']); ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Designation</label>
                                        <input type="text" name="designation" class="form-control bg-light" value="<?php echo htmlspecialchars($admin['designation']); ?>">
                                    </div>
                                </div>

                                <div class="mt-5 text-end">
                                    <button type="submit" name="update_profile" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow-sm"><i class="bi bi-check2-circle me-1"></i> Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
