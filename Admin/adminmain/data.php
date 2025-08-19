<?php
// Connect to your database
$conn = new mysqli("localhost", "root", "", "rable.php");

// Get the email and password from the form
$email = $_POST['email'];
$password = $_POST['password'];

// Check if user exists in the database
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // If yes, go to welcome page
  header("Location: welcome.php");
  exit();
} else {
  // If no, show error message
  echo "Wrong email or password!";
}
?>
