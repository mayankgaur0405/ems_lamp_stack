<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Adjust the path to PHPMailer classes relative to where mail_config.php is included.
// Often this will be included from deeper directories (e.g., admin/employee/add_employee.php).
// To be safe, use __DIR__ to get the absolute path to the includes folder.

require __DIR__ . '/PHPMailer/php mailer/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/php mailer/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/php mailer/PHPMailer/src/SMTP.php';

function send_mail($to, $to_name, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mayankgaur1504@gmail.com';
        $mail->Password   = 'qhpk ftlh choz ppwb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('mayankgaur1504@gmail.com', 'EMS System');
        $mail->addAddress($to, $to_name);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            )
        );

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
