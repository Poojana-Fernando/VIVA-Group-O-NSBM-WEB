<?php
session_start();
include 'database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['doctor_id'])) {
    exit("Unauthorized access.");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $appointment_id = (int)$_GET['id'];
    $new_status = $_GET['status'];
    $doctor_id = $_SESSION['doctor_id'];

    // Only allow Confirmed or Cancelled
    if (!in_array($new_status, ['Confirmed', 'Cancelled'])) {
        header("Location: doctor_dashboard.php?msg=Invalid status.");
        exit();
    }

    // Update the appointment status
    $result = $db->appointments->updateOne(
        ['id' => $appointment_id, 'did' => $doctor_id],
        ['$set' => ['appoint_status' => $new_status]]
    );

    if ($result->getModifiedCount() > 0 || $result->getMatchedCount() > 0) {

        // Fetch appointment details
        $appointment = $db->appointments->findOne(['id' => $appointment_id]);

        if ($appointment) {
            // Fetch patient details
            $patient = $db->patients->findOne(['pid' => $appointment['pid']]);
            // Fetch doctor details
            $doctor = $db->doctors->findOne(['did' => $appointment['did']]);

            if ($patient && $doctor && !empty($patient['email'])) {
                $patientName = $patient['pname'] ?? 'Patient';
                $patientEmail = $patient['email'];
                $doctorName = $doctor['dname'] ?? 'Doctor';
                $appointDate = $appointment['appoint_date'] ?? 'N/A';
                $appointTime = $appointment['appoint_time'] ?? 'N/A';

                // Format the date nicely
                $formattedDate = date('l, M d, Y', strtotime($appointDate));

                try {
                    $mail = new PHPMailer(true);

                    // SMTP config (reuse from .env)
                    $mail->isSMTP();
                    $mail->Host       = $_ENV['SMTP_HOST'];
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $_ENV['SMTP_USER'];
                    $mail->Password   = $_ENV['SMTP_PASS'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = intval($_ENV['SMTP_PORT']);

                    // Sender & recipient
                    $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
                    $mail->addAddress($patientEmail, $patientName);

                    $mail->isHTML(true);

                    if ($new_status === 'Confirmed') {
                        // ===== APPROVAL EMAIL =====
                        $mail->Subject = 'Appointment Confirmed - NSBM Healthcare';
                        $mail->Body = '
                        <div style="font-family: Arial, sans-serif; max-width: 520px; margin: 0 auto; padding: 30px; border: 1px solid #e2e8f0; border-radius: 12px;">
                            <div style="text-align: center; margin-bottom: 20px;">
                                <div style="width: 60px; height: 60px; background: #dcfce7; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 28px;">&#10004;</div>
                            </div>
                            <h2 style="color: #0f172a; margin-top: 0; text-align: center;">Appointment Confirmed!</h2>
                            <p style="color: #475569;">Hello <strong>' . htmlspecialchars($patientName) . '</strong>,</p>
                            <p style="color: #475569;">Great news! Your appointment has been approved by <strong>Dr. ' . htmlspecialchars($doctorName) . '</strong>. Here are your appointment details:</p>

                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 18px; margin: 20px 0;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr><td style="padding: 6px 0; color: #64748b; font-size: 14px;">Doctor</td><td style="padding: 6px 0; font-weight: 700; text-align: right;">Dr. ' . htmlspecialchars($doctorName) . '</td></tr>
                                    <tr><td style="padding: 6px 0; color: #64748b; font-size: 14px;">Date</td><td style="padding: 6px 0; font-weight: 700; text-align: right;">' . $formattedDate . '</td></tr>
                                    <tr><td style="padding: 6px 0; color: #64748b; font-size: 14px;">Time</td><td style="padding: 6px 0; font-weight: 700; text-align: right; color: #16a34a;">' . htmlspecialchars($appointTime) . '</td></tr>
                                </table>
                            </div>

                            <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px; margin: 16px 0;">
                                <p style="margin: 0; color: #92400e; font-size: 14px;"><strong>&#9888; Important:</strong> Please bring your booking receipt when you visit. Arrive at least 15 minutes before your scheduled time.</p>
                            </div>

                            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;">
                            <p style="color: #94a3b8; font-size: 12px; text-align: center;">NSBM Healthcare E-Channeling System</p>
                        </div>';

                        $mail->AltBody = "Hello $patientName,\n\nYour appointment with Dr. $doctorName on $formattedDate at $appointTime has been CONFIRMED.\n\nPlease bring your booking receipt and arrive 15 minutes early.\n\nNSBM Healthcare";

                    } else {
                        // ===== CANCELLATION EMAIL =====
                        $mail->Subject = 'Appointment Cancelled - NSBM Healthcare';
                        $mail->Body = '
                        <div style="font-family: Arial, sans-serif; max-width: 520px; margin: 0 auto; padding: 30px; border: 1px solid #e2e8f0; border-radius: 12px;">
                            <div style="text-align: center; margin-bottom: 20px;">
                                <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 28px;">&#10006;</div>
                            </div>
                            <h2 style="color: #0f172a; margin-top: 0; text-align: center;">Appointment Cancelled</h2>
                            <p style="color: #475569;">Hello <strong>' . htmlspecialchars($patientName) . '</strong>,</p>
                            <p style="color: #475569;">We regret to inform you that your appointment with <strong>Dr. ' . htmlspecialchars($doctorName) . '</strong> has been unfortunately cancelled.</p>

                            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 18px; margin: 20px 0;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr><td style="padding: 6px 0; color: #64748b; font-size: 14px;">Doctor</td><td style="padding: 6px 0; font-weight: 700; text-align: right;">Dr. ' . htmlspecialchars($doctorName) . '</td></tr>
                                    <tr><td style="padding: 6px 0; color: #64748b; font-size: 14px;">Date</td><td style="padding: 6px 0; font-weight: 700; text-align: right;">' . $formattedDate . '</td></tr>
                                    <tr><td style="padding: 6px 0; color: #64748b; font-size: 14px;">Time</td><td style="padding: 6px 0; font-weight: 700; text-align: right; color: #dc2626;">' . htmlspecialchars($appointTime) . '</td></tr>
                                </table>
                            </div>

                            <p style="color: #475569;">We sincerely apologize for the inconvenience. Please feel free to book a new appointment at your convenience.</p>

                            <div style="text-align: center; margin: 24px 0;">
                                <a href="' . ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/book_now.php" style="background: #22c55e; color: #fff; padding: 12px 28px; border-radius: 999px; text-decoration: none; font-weight: 700; display: inline-block;">Book New Appointment</a>
                            </div>

                            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;">
                            <p style="color: #94a3b8; font-size: 12px; text-align: center;">NSBM Healthcare E-Channeling System</p>
                        </div>';

                        $mail->AltBody = "Hello $patientName,\n\nWe are sorry to inform you that your appointment with Dr. $doctorName on $formattedDate at $appointTime has been cancelled.\n\nWe apologize for the inconvenience. Please book a new appointment at your convenience.\n\nNSBM Healthcare";
                    }

                    $mail->send();

                } catch (Exception $e) {
                    // Email failed — still redirect but note the error
                    header("Location: doctor_dashboard.php?msg=Appointment " . $new_status . " but email notification failed.");
                    exit();
                }
            }
        }

        header("Location: doctor_dashboard.php?msg=Appointment " . $new_status . " successfully! Patient has been notified via email.");
        exit();
    } else {
        echo "Error: Appointment not found or not authorized.";
    }
}
?>