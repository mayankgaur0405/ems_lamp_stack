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

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    if(isset($_GET['status']))
    {
        $status = $_GET['status'];

        $query =
        "UPDATE employees
        SET status='$status'
        WHERE id='$id'";

        mysqli_query($conn,$query);
    }
    elseif(isset($_GET['action']) && $_GET['action'] == 'delete')
    {
        $query = "DELETE FROM employees WHERE id='$id'";
        mysqli_query($conn, $query);
    }
}

header("Location:view_employee.php");

exit;

?>