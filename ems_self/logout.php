<?php
session_start();
session_destroy();
if( $_SESSION['role'] == 'admin' )
{
    header("Location:../ems_self/admin/index.php");
    exit;
}else{
    header("Location:../ems_self/employee/index.php");
    exit;
}

exit;
?>