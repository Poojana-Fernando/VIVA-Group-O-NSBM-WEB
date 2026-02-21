<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password | NSBM Healthcare</title>
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

    .forgot-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 20px;
    }

    .forgot-card{
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

    .back{
      text-decoration:none;
      font-weight: 700;
      color: var(--green-dark);
      padding: 8px 12px;
      border-radius: 999px;
      border: 1px solid rgba(34,197,94,.25);
      background: rgba(34,197,94,.10);
      transition: .2s;
      font-size: 14px;
      white-space: nowrap;
    }
    .back:hover{ background: rgba(34,197,94,.16); }

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

    .btn-forgot{
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
    .btn-forgot:hover{
      background: var(--green-dark);
      transform: translateY(-1px);
    }

    .msg{
      margin-top: 14px;
      padding: 12px 14px;
      border-radius: 12px;
      font-size: 14px;
      text-align: center;
    }
    .msg.success{
      background: rgba(34,197,94,.10);
      color: var(--green-dark);
      border: 1px solid rgba(34,197,94,.25);
    }
    .msg.error{
      background: rgba(239,68,68,.08);
      color: #dc2626;
      border: 1px solid rgba(239,68,68,.2);
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

  <div class="forgot-wrap">
  <div class="forgot-card">
    <div class="top">
      <h1 class="title">Forgot Password</h1>
      <a class="back" href="doctor_login.php">← Back to Login</a>
    </div>

    <p class="subtitle">Enter your registered email address. We'll send you a link to reset your password.</p>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] === 'sent') {
            echo '<div class="msg success">If an account with that email exists, a reset link has been sent. Please check your inbox.</div>';
        } elseif ($_GET['status'] === 'error') {
            echo '<div class="msg error">Something went wrong. Please try again later.</div>';
        }
    }
    ?>

    <form action="send_reset.php" method="POST">
      <label for="email">Email Address</label>
      <input id="email" type="email" name="email" required placeholder="doctor@example.com">

      <button class="btn-forgot" type="submit">Send Reset Link</button>
    </form>

    <div class="note"><a href="doctor_login.php">← Back to Login</a></div>
  </div>
  </div>

  <?php renderFooter(); ?>
</body>
</html>
