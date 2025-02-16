<?php
// Enable error reporting (development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Replace these placeholders with your actual database credentials
$dbHost     = "localhost";
$dbUsername = "root"; // e.g., "john_doe"
$dbPassword = ""; // e.g., "secret123"
$dbName     = "contact_us";           // Ensure this database exists

// Create a connection to the database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and trim form data
    $name    = trim($_POST["name"]);
    $email   = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Prepare and bind the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            $success = "Thank you for contacting us!";
        } else {
            $error = "There was an error submitting your message. Please try again later.";
        }
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <style>
       /* Underwater background with flowing wave animations */
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

/* Additional styling for overall text */
h2 {
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
}


    </style>
</head>
<body>
  <section class="main">
    <h2>Contact Us</h2>
    

    <?php if (isset($error)) : ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5" required></textarea>
    
        <input type="submit" value="Send Message">
    </form>
  </section>
</body>
</html>
