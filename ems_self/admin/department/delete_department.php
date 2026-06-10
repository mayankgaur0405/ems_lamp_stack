<?php include "../../includes/header.php"; ?>

<div class="d-flex">

<?php include "../../includes/sidebar.php"; ?>

<div class="container-fluid p-4">

<div class="d-flex justify-content-between align-items-center">
    
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

    $query =
    "DELETE FROM departments
    WHERE id='$id'";

    mysqli_query($conn,$query);
}

header("Location:view_department.php");

exit;

?>