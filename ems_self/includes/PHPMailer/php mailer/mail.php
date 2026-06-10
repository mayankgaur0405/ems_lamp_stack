<?php

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'mayankgaur1504@gmail.com';
    $mail->Password   = 'qhpk ftlh choz ppwb';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('mayankgaur1504@gmail.com', 'Mayank');
    $mail->addAddress('gsudhanshu511@gmail.com','sudhanshu');

    $mail->isHTML(true);
    $mail->Subject = 'Test Mail date 4/6/2026 hello ';
    $mail->Body    = '<h2>Hello sudhanshu</h2>';

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        )
    );

    $mail->send();

    echo "Mail Sent Successfully";

} catch (Exception $e) {
    echo "Error: " . $mail->ErrorInfo;
}
?>