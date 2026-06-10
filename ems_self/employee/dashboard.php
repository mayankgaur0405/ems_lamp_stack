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
    "SELECT e.*,
d.name AS department_name

FROM employees e

LEFT JOIN departments d
ON e.department_id = d.id

WHERE e.id='$id'";

$result =
mysqli_query($conn,$query);

$employee =
mysqli_fetch_assoc($result);

?>

<?php include "../includes/header.php"; ?>

<div class="d-flex">

    <?php include "../includes/employee_sidebar.php"; ?>

        <div class="container-fluid p-4">

<h2>
Welcome,
<?php echo $employee['name']; ?>
</h2>

<hr>

<div class="row">

<div class="col-md-3 mb-3">

<div class="card text-center">

<div class="card-body">

<h5>Email</h5>

<p>
<?php echo $employee['email']; ?>
</p>

                            </div>

                            </div>

                </div>

<div class="col-md-3 mb-3">

<div class="card text-center">

<div class="card-body">

<h5>Phone</h5>

<p>
<?php echo $employee['phone']; ?>
</p>

                    </div>

                </div>

            </div>

<div class="col-md-3 mb-3">

<div class="card text-center">

<div class="card-body">

<h5>Designation</h5>

<p>
<?php echo $employee['designation']; ?>
</p>

                                        </div>

                                        </div>

                                    </div>

<div class="col-md-3 mb-3">

<div class="card text-center">

<div class="card-body">

<h5>Department</h5>

<p>
<?php echo $employee['department_name']; ?>
</p>

                                    </div>

                                </div>

                        </div>

                        </div>

<div class="card mt-4">

<div class="card-header">

Quick Links

                </div>

<div class="card-body">

<a
href="profile.php"
class="btn btn-primary me-2">

My Profile

</a>

<a
href="top_employees.php"
class="btn btn-success me-2">

Top Employees

</a>

<a
href="change_password.php"
class="btn btn-warning">

Change Password

</a>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>

