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
        !password_verify(
            $current_password,
            $employee['password']
        )
    )
    {
        echo
        "<script>
        alert('Current Password Incorrect');
        </script>";
    }

    else if(
        $new_password !=
        $confirm_password
    )
    {
        echo
        "<script>
        alert('New Password And Confirm Password Not Match');
        </script>";
    }

    else
    {
        $new_hash =
        password_hash(
            $new_password,
            PASSWORD_DEFAULT
        );

        $update_query =
        "UPDATE employees
        SET password='$new_hash'
        WHERE id='$id'";

        if(
            mysqli_query(
                $conn,
                $update_query
            )
        )
        {
            echo
            "<script>
            alert('Password Changed Successfully');
            window.location='dashboard.php';
            </script>";
        }
    }
}

?>

<?php include "../includes/header.php"; ?>

<div class="d-flex">

<?php include "../includes/sidebar.php"; ?>

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
        
        <h4 class="mb-4 text-dark fw-bold"><i class="bi bi-shield-lock-fill text-warning me-2"></i> Account Security</h4>
        
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-key-fill text-warning fs-1"></i>
                            </div>
                            <h5 class="fw-bold">Change Password</h5>
                            <p class="text-muted" style="font-size: 0.85rem;">Ensure your account is using a strong, secure password.</p>
                        </div>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Current Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="current_password" class="form-control border-start-0 ps-0" placeholder="Enter current password" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="new_password" class="form-control border-start-0 ps-0" placeholder="Enter new password" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="confirm_password" class="form-control border-start-0 ps-0" placeholder="Confirm new password" required>
                                </div>
                            </div>
                            
                            <button type="submit" name="change_password" class="btn btn-warning w-100 py-2 fw-bold text-dark rounded-pill shadow-sm mb-3">Update Password</button>
                            <a href="dashboard.php" class="btn btn-light w-100 py-2 fw-medium rounded-pill text-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<?php include "../includes/footer.php"; ?>