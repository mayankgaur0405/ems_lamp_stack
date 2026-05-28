<?php
include __DIR__ . '/db.php';


//to fetch from url we use $_GET['id'] and isset is used to check whether we have this in url or not and which this we are checking whether user has logged in or not

if(!isset($_GET['user_id']) || empty($_GET['user_id'])){

    header("Location: /php-training-pe-front/study/ems/login.php");
    exit();
}

$user_id = $_GET['user_id'];
$sql = "select * from employees where id = $user_id"; 

$result = mysqli_query($conn, $sql);

if($result && mysqli_num_rows($result) > 0){
   $current_user = mysqli_fetch_assoc($result);
}else{
    header("Location: /php-training-pe-front/study/ems/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EmpManager</title>
    <!-- Relative path to our CSS since some files are in subfolders -->
    <link rel="stylesheet" href="/php-training-pe-front/study/ems/assets/css/style.css">
</head>
<body>
    <!-- Main Wrapper that wraps sidebar and main content -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <button class="nav-toggle">☰</button>
            <a href="/php-training-pe-front/study/ems/profile.php?user_id=<?php echo $user_id; ?>" class="nav-profile">
                <!-- If they have a profile pic display it, otherwise display a placeholder -->
                <?php 

                //if profile exits we use it or else we set a common upstash avatar 
                $profile_img = !empty($current_user['profile_pic']) ? $current_user['profile_pic'] : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80'; 
                ?>
                <img src="<?php echo $profile_img; ?>" alt="Profile" class="nav-avatar">
                <span class="nav-username"><?php echo htmlspecialchars($current_user['name']); ?></span>
            </a>
        </header>
