<?php
// Set the session cookie lifetime to 0 so that it expires when the browser is closed.
session_set_cookie_params(0);
session_start();

$password_file = 'admin_password.txt'; // This file stores the hashed password
$error = '';
$message = '';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// --------------------- SIGN UP PROCESS ---------------------
if ($action === 'signup') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password     = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);
        
        if (empty($new_password) || empty($confirm_password)) {
            $error = "Please fill in both fields.";
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            // Hash and store the new password
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            file_put_contents($password_file, $hash);
            $message = "Sign up successful. Please log in.";
            header("Location: login.php?action=login&message=" . urlencode($message));
            exit;
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Sign Up</title>
      <style>
          body {
  margin: 0;
  padding: 20px;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  background: linear-gradient(to bottom, #023e8a, #0077b6, #0096c7);
  color: #fff;
  position: relative;
  overflow-x: hidden;
}

/* Create subtle moving wave effects using pseudo-elements */
body::before,
body::after {
  content: "";
  position: absolute;
  width: 200%;
  height: 150px;
  bottom: 0;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 100%;
  animation: wave 6s infinite linear;
}

body::after {
  bottom: -20px;
  animation: wave 8s infinite linear reverse;
}

@keyframes wave {
  from {
    transform: translateX(0) translateY(0);
  }
  to {
    transform: translateX(50%) translateY(10px);
  }
}

/* Container for the contact form with a professional look */
.container {
  width: 100%;
  max-width: 600px;
  background: rgba(255, 255, 255, 0.95);
  border-radius: 4px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  padding: 30px;
  color: #333;
  z-index: 1;
}

/* Heading styling for the container */
.container h2 {
  text-align: center;
  margin-bottom: 20px;
  font-weight: 300;
  color: #2c3e50;
}

/* Contact form styles */
form label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

form input[type="text"],
form input[type="email"],
form textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color 0.3s ease;
}

form input[type="text"]:focus,
form input[type="email"]:focus,
form textarea:focus {
  border-color: #2c3e50;
  outline: none;
}

form input[type="submit"] {
  background: #2c3e50;
  color: #fff;
  border: none;
  padding: 12px 25px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s ease;
}

form input[type="submit"]:hover {
  background: #34495e;
}

/* Message styles for errors and success notifications */
.message {
  padding: 10px;
  margin-bottom: 15px;
  text-align: center;
  border-radius: 4px;
}

.error {
  background: #fdd;
  border: 1px solid #f99;
  color: #900;
}

.success {
  background: #dfd;
  border: 1px solid #9f9;
  color: #060;
}


      </style>
    </head>
    <body>
      <div class="form-container">
          <h2>Sign Up</h2>
          <?php if (!empty($error)): ?>
              <div class="error"><?php echo $error; ?></div>
          <?php endif; ?>
          <form method="post" action="login.php?action=signup">
              <label for="new_password">New Password:</label>
              <input type="password" name="new_password" id="new_password" required>
              <label for="confirm_password">Confirm Password:</label>
              <input type="password" name="confirm_password" id="confirm_password" required>
              <input type="submit" value="Sign Up">
          </form>
          <p style="text-align:center;">Already have an account? <a href="login.php?action=login">Login here</a></p>
      </div>
    </body>
    </html>
    <?php
    exit;
}

// --------------------- LOGIN PROCESS ---------------------
if ($action === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = trim($_POST['password']);
        if (!file_exists($password_file)) {
            $error = "No account exists. Please sign up first.";
        } else {
            $stored_hash = file_get_contents($password_file);
            if (password_verify($password, $stored_hash)) {
                $_SESSION['logged_in'] = true;
                header("Location: admin.php");
                exit;
            } else {
                $error = "Incorrect password.";
            }
        }
    }
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Login</title>
      <style>
        body {
  font-family: Arial, sans-serif;
  background: #f2f2f2;
  margin: 20px;
}

.form-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
}

label {
  display: block;
  margin-top: 10px;
}

input[type="password"],
input[type="submit"] {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.message {
  text-align: center;
  margin-bottom: 10px;
  padding: 10px;
}

.error {
  background: #fdd;
  color: #d00;
}

.success {
  background: #dfd;
  color: #070;
}

a {
  color: #3498db;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

      </style>
    </head>
    <body>
      <div class="form-container">
          <h2>Login</h2>
          <?php if (!empty($message)): ?>
              <div class="message success"><?php echo htmlspecialchars($message); ?></div>
          <?php endif; ?>
          <?php if (!empty($error)): ?>
              <div class="message error"><?php echo $error; ?></div>
          <?php endif; ?>
          <form method="post" action="login.php?action=login">
              <label for="password">Password:</label>
              <input type="password" name="password" id="password" required>
              <input type="submit" value="Login">
          </form>
          <p style="text-align:center;">Don't have an account? <a href="login.php?action=signup">Sign up here</a></p>
      </div>
    </body>
    </html>
    <?php
    exit;
}
?>
