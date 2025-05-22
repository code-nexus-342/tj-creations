<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME');
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = getenv('SMTP_PORT');

        // Recipients
        $mail->setFrom($email);
        $mail->addAddress('infotjcreations@gmail.com');
        $mail->addReplyTo($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Newsletter Subscription';
        $mail->Body = "
            <h3>New Newsletter Subscription</h3>
            <p><strong>Email:</strong> {$email}</p>
        ";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Successfully subscribed to newsletter']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Subscription failed. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
} 