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

if(isset($_POST['add_department']))
{
    $department_name = trim($_POST['department_name']);

    $check_query =
    "SELECT *
    FROM departments
    WHERE name='$department_name'";

    $check_result =
    mysqli_query($conn,$check_query);

    if(mysqli_num_rows($check_result) > 0)
    {
        echo "<script>alert('Department Already Exists');</script>";
    }
    else
    {
        $insert_query =
        "INSERT INTO departments(name)
        VALUES('$department_name')";

        if(mysqli_query($conn,$insert_query))
        {
            echo "<script>alert('Department Added Successfully');</script>";
        }
    }
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
        <h4 class="mb-4 text-dark fw-bold">Add Department</h4>
        
        <div class="card border-0 shadow-sm rounded-4" style="max-width: 500px;">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Department Name</label>
                        <input type="text" name="department_name" class="form-control" placeholder="e.g. Engineering" required>
                    </div>
                    
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" name="add_department" class="btn btn-primary px-4 py-2">Add Department</button>
                        <a href="view_department.php" class="btn btn-outline-primary px-4 py-2">View Departments</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<?php include "../../includes/footer.php"; ?>