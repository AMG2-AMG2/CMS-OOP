<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "cms";

// Create connectie
$conn = new mysqli($servername, $username, $password);

// Check connectie
if ($conn->connect_error) {
  die("connectie mislukt: " . $conn->connect_error);
}
echo "Connetie succes vol";
?>