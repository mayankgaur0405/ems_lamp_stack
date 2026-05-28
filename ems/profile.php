<?php
include 'includes/header.php';
include 'includes/sidebar.php';

$success = '';
$error = '';

// Handle Profile Update Post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $profile_pic = $_POST['profile_pic'];

    // Check email uniqueness (exclude current user)
    $email_check = mysqli_query($conn, "SELECT id FROM employees WHERE email = '$email' AND id != $user_id");
    if (mysqli_num_rows($email_check) > 0) {
        $error = "This email is already taken by another user.";
    } else {
        if (!empty($password)) {
            $sql = "UPDATE employees SET name = '$name', email = '$email', phone = '$phone', password = '$password', profile_pic = '$profile_pic' WHERE id = $user_id";
        } else {
            $sql = "UPDATE employees SET name = '$name', email = '$email', phone = '$phone', profile_pic = '$profile_pic' WHERE id = $user_id";
        }
        
        if (mysqli_query($conn, $sql)) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Error updating profile details.";
        }
    }
}

// Fetch the employee's full details with department name
$profile_sql = "SELECT e.*, d.name AS dept_name FROM employees e LEFT JOIN departments d ON e.department_id = d.id WHERE e.id = $user_id";
$profile_result = mysqli_query($conn, $profile_sql);
$emp = mysqli_fetch_assoc($profile_result);

$is_edit = isset($_GET['action']) && $_GET['action'] === 'edit';
?>

<div class="content-area">
    <h1 class="page-title"><?php echo $is_edit ? 'Edit Profile' : 'My Profile'; ?></h1>

    <?php if (!empty($success)): ?>
        <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:6px; margin-bottom:20px; border:1px solid #86efac;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="profile-flex">
        <div class="profile-card-left panel">
            <?php if ($is_edit): ?>
                <!-- EDIT PROFILE FORM -->
                <form method="POST" action="profile.php?user_id=<?php echo $user_id; ?>&action=edit">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" required value="<?php echo htmlspecialchars($emp['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required value="<?php echo htmlspecialchars($emp['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" required value="<?php echo htmlspecialchars($emp['phone']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password (leave blank to keep current)</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label for="profile_pic">Profile Picture URL</label>
                        <input type="url" name="profile_pic" id="profile_pic" class="form-control" placeholder="https://example.com/avatar.jpg" value="<?php echo htmlspecialchars($emp['profile_pic']); ?>">
                    </div>
                    <div style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="profile.php?user_id=<?php echo $user_id; ?>" class="btn btn-outline" style="margin-left:10px;">Cancel</a>
                    </div>
                </form>
            <?php else: ?>
                <!-- PROFILE DISPLAY -->
                <p class="profile-summary-header">Welcome, <?php echo htmlspecialchars($emp['name']); ?>! 👋</p>
                <p class="profile-summary-text">Here is your profile summary. You can keep your contact details updated by editing your profile.</p>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($emp['email']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Department:</span>
                        <span class="info-value"><?php echo $emp['dept_name'] ? htmlspecialchars($emp['dept_name']) : 'Not Assigned'; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value"><?php echo htmlspecialchars($emp['phone']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Role:</span>
                        <span class="badge <?php echo ($emp['role'] === 'admin') ? 'badge-admin' : 'badge-employee'; ?>">
                            <?php echo htmlspecialchars($emp['role']); ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Designation:</span>
                        <span class="info-value"><?php echo htmlspecialchars($emp['designation']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Joined:</span>
                        <span class="info-value"><?php echo date('d M Y', strtotime($emp['joining_date'])); ?></span>
                    </div>
                </div>

                <a href="profile.php?user_id=<?php echo $user_id; ?>&action=edit" class="btn btn-primary">✏️ Edit Profile</a>
            <?php endif; ?>
        </div>

        <div class="profile-card-right">
            <?php
            $avatar = !empty($emp['profile_pic']) ? $emp['profile_pic'] : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80';
            ?>
            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Profile" class="profile-avatar-large">
            <h3><?php echo htmlspecialchars($emp['name']); ?></h3>
            <p><?php echo htmlspecialchars($emp['designation']); ?></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
