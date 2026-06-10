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

if(isset($_POST['change_password']))
{
    $current_password =
    $_POST['current_password'];

    $new_password =
    $_POST['new_password'];

    $confirm_password =
    $_POST['confirm_password'];

    $query =
    "SELECT password
    FROM employees
    WHERE id='$id'";

    $result =
    mysqli_query($conn,$query);

    $employee =
    mysqli_fetch_assoc($result);

    if(
        password_verify(
            $current_password,
            $employee['password']
        )
    )
    {
        if(
            $new_password ==
            $confirm_password
        )
        {
            $hashed_password =
            password_hash(
                $new_password,
                PASSWORD_DEFAULT
            );

            $update_query =
            "UPDATE employees
            SET
            password='$hashed_password'
            WHERE id='$id'";

            if(
                mysqli_query(
                    $conn,
                    $update_query
                )
            )
            {
                echo
                "<script>alert('Password Changed Successfully');</script>";
            }
        }
        else
        {
            echo
            "<script>alert('New Passwords Do Not Match');</script>";
        }
    }
    else
    {
        echo
        "<script>alert('Incorrect Current Password');</script>";
    }
}

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
        
        <h4 class="mb-4 text-dark fw-bold"><i class="bi bi-shield-lock-fill text-warning me-2"></i> Account Security</h4>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-key-fill text-warning fs-1"></i>
                            </div>
                            <h5 class="fw-bold">Change Password</h5>
                            <p class="text-muted" style="font-size: 0.85rem;">Ensure your account is using a strong, unique password.</p>
                        </div>
                        
                        <form method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Current Password</label>
                                <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                            </div>
                            
                            <hr class="my-4 text-muted">
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                                <div class="form-text" style="font-size: 0.75rem;">Password must be at least 8 characters long.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password" required>
                            </div>
                            
                            <button type="submit" name="change_password" class="btn btn-warning w-100 py-2 fw-bold text-dark rounded-pill shadow-sm"><i class="bi bi-check-circle-fill me-2"></i> Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<?php include "../includes/footer.php"; ?>