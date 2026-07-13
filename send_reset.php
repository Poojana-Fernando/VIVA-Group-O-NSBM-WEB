<?php
session_start();
include 'database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Always show generic message to prevent email enumeration
    $redirectSuccess = "Location: forgot_password.php?status=sent";
    $redirectError   = "Location: forgot_password.php?status=error";

    // Check if doctor exists
    $doctor = $db->doctors->findOne(['email' => $email]);

    if ($doctor) {
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expiresAt = new MongoDB\BSON\UTCDateTime((time() + 3600) * 1000); // 1 hour

        // Delete any existing tokens for this email
        $db->password_resets->deleteMany(['email' => $email]);

        // Store new token
        $db->password_resets->insertOne([
            'email'      => $email,
            'token'      => $token,
            'expires_at' => $expiresAt
        ]);

        // Create TTL index (only needs to run once, MongoDB ignores if exists)
        $db->password_resets->createIndex(
            ['expires_at' => 1],
            ['expireAfterSeconds' => 0]
        );

        // Build reset link
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['PHP_SELF']);
        $resetLink = $protocol . '://' . $host . $path . '/reset_password.php?token=' . $token;

        // Send email via PHPMailer
        try {
            $mail = new PHPMailer(true);

            // SMTP config
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = intval($_ENV['SMTP_PORT']);

            // Sender & recipient
            $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($email, $doctor['dname']);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset - NSBM Healthcare';
            $mail->Body    = '
                <div style="font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 30px; border: 1px solid #e2e8f0; border-radius: 12px;">
                    <h2 style="color: #0f172a; margin-top: 0;">Password Reset Request</h2>
                    <p style="color: #475569;">Hello <strong>' . htmlspecialchars($doctor['dname']) . '</strong>,</p>
                    <p style="color: #475569;">We received a request to reset your password. Click the button below to set a new password:</p>
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . $resetLink . '" style="background: #22c55e; color: #fff; padding: 12px 28px; border-radius: 999px; text-decoration: none; font-weight: 700; display: inline-block;">Reset Password</a>
                    </div>
                    <p style="color: #94a3b8; font-size: 13px;">This link expires in <strong>1 hour</strong>. If you didn\'t request this, ignore this email.</p>
                    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;">
                    <p style="color: #94a3b8; font-size: 12px; text-align: center;">NSBM Healthcare E-Channeling System</p>
                </div>
            ';
            $mail->AltBody = "Hello " . $doctor['dname'] . ",\n\nReset your password: " . $resetLink . "\n\nThis link expires in 1 hour.";

            $mail->send();

            header($redirectSuccess);
            exit();

        } catch (Exception $e) {
            // Mail failed — still show generic message or show error
            header($redirectError);
            exit();
        }
    } else {
        // Doctor not found — still show generic success (security best practice)
        header($redirectSuccess);
        exit();
    }
}
?>
