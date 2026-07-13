<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Doctor Login | NSBM Healthcare</title>
  <link rel="stylesheet" href="styles.css" />

  <style>
    .login-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 20px;
    }

    .login-card {
      width: min(420px, 94vw);
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 28px;
    }

    .login-card .top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 14px;
    }

    .login-card .title {
      margin: 0;
      font-size: 22px;
      letter-spacing: -0.01em;
    }

    .login-card .subtitle {
      margin: 0 0 18px;
      color: var(--muted);
      font-size: 14px;
    }

    .login-card label {
      display: block;
      font-weight: 700;
      font-size: 14px;
      margin: 12px 0 6px;
    }

    .login-card input {
      width: 100%;
      padding: 11px 12px;
      border-radius: 12px;
      border: 1px solid var(--border);
      outline: none;
      font-size: 14px;
      background: #fff;
    }

    .login-card input:focus {
      border-color: rgba(34, 197, 94, .45);
      box-shadow: 0 0 0 4px rgba(34, 197, 94, .12);
    }

    .btn-login {
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
      box-shadow: 0 10px 20px rgba(34, 197, 94, .18);
    }

    .btn-login:hover {
      background: var(--green-dark);
      transform: translateY(-1px);
    }

    .note {
      margin-top: 14px;
      font-size: 13px;
      color: var(--muted);
      text-align: center;
    }

    .forgot {
      display: block;
      text-align: right;
      margin-top: 8px;
      font-size: 13px;
    }

    .forgot a {
      color: var(--green-dark);
      text-decoration: none;
      font-weight: 600;
    }

    .forgot a:hover {
      text-decoration: underline;
    }

    .msg {
      margin-bottom: 16px;
      padding: 12px 14px;
      border-radius: 12px;
      font-size: 14px;
      text-align: center;
      background: rgba(34, 197, 94, .10);
      color: var(--green-dark);
      border: 1px solid rgba(34, 197, 94, .25);
      display: none;
    }
    /* Smooth scrolling for links */
    html {
      scroll-behavior: smooth;
    }
    /* Base reveal state */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.8s ease-out;
    }
    /* State when visible on screen */
    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }

  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="login-wrap reveal">
    <div class="login-card">
      <div class="top">
        <h1 class="title">Doctor Login</h1>
      </div>

      <p class="subtitle">Sign in to manage your appointments and schedule.</p>

      <div class="msg" id="resetSuccess">Your password has been reset successfully. Please login with your new password.
      </div>

      <form action="login_check.php" method="POST">
        <label for="email">Email</label>
        <input id="email" type="email" name="demail" required placeholder="doctor@example.com">

        <label for="pass">Password</label>
        <input id="pass" type="password" name="dpassword" minlength="8" required placeholder="Enter your password">

        <div class="forgot"><a href="forgot_password.php">Forgot Password?</a></div>

        <button class="btn-login" type="submit">Login</button>
      </form>

      <script>
        if (new URLSearchParams(window.location.search).get('reset') === 'success') {
          document.getElementById('resetSuccess').style.display = 'block';
        }
      </script>
      <script>
      document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
      }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
    </script>

      <div class="note">NSBM Healthcare • Doctor Portal</div>
    </div>
  </div>

  <?php renderFooter(); ?>
</body>

</html>
