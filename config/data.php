<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  error_log("Database connection failed: " . $e->getMessage());
  die("Database connection error. Please try again later.");
}
?>