<?php
session_start();
include 'database.php';

$token = isset($_GET['token']) ? $_GET['token'] : '';
$valid = false;
$errorMsg = '';

if (!empty($token)) {
    $reset = $db->password_resets->findOne(['token' => $token]);

    if ($reset) {
        $now = new MongoDB\BSON\UTCDateTime();
        if ($reset['expires_at'] > $now) {
            $valid = true;
        } else {
            $errorMsg = 'This reset link has expired. Please request a new one.';
        }
    } else {
        $errorMsg = 'Invalid reset link. Please request a new one.';
    }
} else {
    $errorMsg = 'No reset token provided.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password | NSBM Healthcare</title>
  <link rel="stylesheet" href="styles.css" />

  <style>
    :root{
      --green:#22c55e;
      --green-dark:#16a34a;
      --text:#0f172a;
      --muted:#64748b;
      --bg:#f6f8fb;
      --card:#ffffff;
      --border:rgba(15,23,42,.10);
      --shadow: 0 12px 30px rgba(15,23,42,.10);
      --radius:16px;
    }

    *{ box-sizing:border-box; }

    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
    }

    .reset-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 20px;
    }

    .reset-card{
      width: min(420px, 94vw);
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 28px;
    }

    .top{
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 14px;
    }

    .title{
      margin:0;
      font-size: 22px;
      letter-spacing: -0.01em;
    }

    .subtitle{
      margin: 0 0 18px;
      color: var(--muted);
      font-size: 14px;
    }

    label{
      display:block;
      font-weight: 700;
      font-size: 14px;
      margin: 12px 0 6px;
    }

    input{
      width: 100%;
      padding: 11px 12px;
      border-radius: 12px;
      border: 1px solid var(--border);
      outline: none;
      font-size: 14px;
      background: #fff;
    }
    input:focus{
      border-color: rgba(34,197,94,.45);
      box-shadow: 0 0 0 4px rgba(34,197,94,.12);
    }

    .btn-reset{
      width: 100%;
      margin-top: 16px;
      padding: 11px 14px;
      border: 0;
      border-radius: 999px;
      background: var(--green);
      color: #fff;
      font-weight: 800;
      cursor: pointer;
      transition: .2s;
      box-shadow: 0 10px 20px rgba(34,197,94,.18);
    }
    .btn-reset:hover{
      background: var(--green-dark);
      transform: translateY(-1px);
    }

    .msg{
      margin-top: 0;
      margin-bottom: 18px;
      padding: 12px 14px;
      border-radius: 12px;
      font-size: 14px;
      text-align: center;
    }
    .msg.error{
      background: rgba(239,68,68,.08);
      color: #dc2626;
      border: 1px solid rgba(239,68,68,.2);
    }
    .msg.success{
      background: rgba(34,197,94,.10);
      color: var(--green-dark);
      border: 1px solid rgba(34,197,94,.25);
    }

    .note{
      margin-top: 14px;
      font-size: 13px;
      color: var(--muted);
      text-align:center;
    }
    .note a{
      color: var(--green-dark);
      text-decoration: none;
      font-weight: 600;
    }
    .note a:hover{ text-decoration: underline; }
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="reset-wrap">
  <div class="reset-card">
    <div class="top">
      <h1 class="title">Reset Password</h1>
    </div>

    <?php if ($valid): ?>
      <p class="subtitle">Enter your new password below.</p>

      <?php if (isset($_GET['error'])): ?>
        <div class="msg error">
          <?php
          if ($_GET['error'] === 'mismatch') echo 'Passwords do not match.';
          elseif ($_GET['error'] === 'short') echo 'Password must be at least 8 characters.';
          elseif ($_GET['error'] === 'invalid') echo 'Invalid or expired token. Please request a new link.';
          else echo 'An error occurred. Please try again.';
          ?>
        </div>
      <?php endif; ?>

      <form action="update_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <label for="new_pass">New Password</label>
        <input id="new_pass" type="password" name="new_password" minlength="8" required placeholder="Minimum 8 characters">

        <label for="confirm_pass">Confirm Password</label>
        <input id="confirm_pass" type="password" name="confirm_password" minlength="8" required placeholder="Re-enter your password">

        <button class="btn-reset" type="submit">Update Password</button>
      </form>

    <?php else: ?>
      <div class="msg error"><?php echo htmlspecialchars($errorMsg); ?></div>
      <div class="note"><a href="forgot_password.php">Request a new reset link →</a></div>
    <?php endif; ?>

    <div class="note"><a href="doctor_login.php">← Back to Login</a></div>
  </div>
  </div>

  <?php renderFooter(); ?>
</body>
</html>
