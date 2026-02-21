<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token           = $_POST['token'];
    $newPassword     = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate passwords match
    if ($newPassword !== $confirmPassword) {
        header("Location: reset_password.php?token=" . urlencode($token) . "&error=mismatch");
        exit();
    }

    // Validate minimum length
    if (strlen($newPassword) < 8) {
        header("Location: reset_password.php?token=" . urlencode($token) . "&error=short");
        exit();
    }

    // Find and validate token
    $reset = $db->password_resets->findOne(['token' => $token]);

    if (!$reset) {
        header("Location: reset_password.php?token=" . urlencode($token) . "&error=invalid");
        exit();
    }

    // Check if token has expired
    $now = new MongoDB\BSON\UTCDateTime();
    if ($reset['expires_at'] <= $now) {
        // Clean up expired token
        $db->password_resets->deleteOne(['token' => $token]);
        header("Location: reset_password.php?token=" . urlencode($token) . "&error=invalid");
        exit();
    }

    // Update the doctor's password
    $result = $db->doctors->updateOne(
        ['email' => $reset['email']],
        ['$set' => ['password' => $newPassword]]
    );

    if ($result->getModifiedCount() > 0 || $result->getMatchedCount() > 0) {
        // Delete the used token
        $db->password_resets->deleteOne(['token' => $token]);

        // Redirect to login with success message
        header("Location: doctor_login.php?reset=success");
        exit();
    } else {
        header("Location: reset_password.php?token=" . urlencode($token) . "&error=failed");
        exit();
    }
}
?>
