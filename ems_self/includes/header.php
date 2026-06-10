<?php
ob_start();
$script = $_SERVER['SCRIPT_NAME'];
$emsPos = strpos($script, '/ems_self');
$rootBase = $emsPos !== false ? substr($script, 0, $emsPos + 9) : '';
?>
<!DOCTYPE html>
<html>
<head>

<title>EMS</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<link href="<?php echo $rootBase; ?>/assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">

</head>

<body>
