<?php

session_start();

if(
    !isset($_SESSION['id'])
    ||
    $_SESSION['role'] != 'employee'
)
{
    header("Location: index.php");
    exit;
}

include "../includes/db.php";
require "../includes/mail_config.php";

$id = $_SESSION['id'];

$query =
"SELECT name, email
FROM employees
WHERE id='$id'";

$result =
mysqli_query($conn,$query);

$employee =
mysqli_fetch_assoc($result);

if(isset($_POST['send_message']))
{
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $emp_name = $employee['name'];
    $emp_email = $employee['email'];

    $admin_query =
    "SELECT email
    FROM employees
    WHERE role='admin'";

    $admin_result =
    mysqli_query($conn,$admin_query);

    $success_count = 0;

    while(
        $admin =
        mysqli_fetch_assoc($admin_result)
    )
    {
        $admin_email = $admin['email'];

        $mail_subject =
        "Message from Employee: $emp_name - $subject";

        $mail_body =
        "<h3>Message from Employee</h3>
        <p><b>Name:</b> $emp_name</p>
        <p><b>Email:</b> $emp_email</p>
        <hr>
        <p><b>Subject:</b> $subject</p>
        <p><b>Message:</b></p>
        <p>" . nl2br(htmlspecialchars($message)) . "</p>";

        if(
            send_mail(
                $admin_email,
                'Admin',
                $mail_subject,
                $mail_body
            )
        )
        {
            $success_count++;
        }
    }

    if($success_count > 0)
    {
        echo
        "<script>alert('Message Sent to Admin Successfully!');</script>";
    }
    else
    {
        echo
        "<script>alert('Failed to send message. Please try again later.');</script>";
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
        
        <h4 class="mb-4 text-dark fw-bold"><i class="bi bi-envelope-fill text-primary me-2"></i> Contact Admin</h4>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-5">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-chat-dots-fill text-primary fs-1"></i>
                            </div>
                            <h5 class="fw-bold">Need Help or Support?</h5>
                            <p class="text-muted" style="font-size: 0.85rem;">Send a direct message to the system administrator for assistance.</p>
                        </div>
                        
                        <form method="POST">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Your Name</label>
                                    <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($employee['name']); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Your Email</label>
                                    <input type="email" class="form-control bg-light" value="<?php echo htmlspecialchars($employee['email']); ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="Brief subject of your message" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Message Content</label>
                                <textarea name="message" class="form-control" rows="6" placeholder="Describe your issue or query in detail..." required></textarea>
                            </div>
                            
                            <button type="submit" name="send_message" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm"><i class="bi bi-send-fill me-2"></i> Send Message to Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<?php include "../includes/footer.php"; ?>
