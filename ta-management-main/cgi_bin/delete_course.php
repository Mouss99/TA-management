<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "ta-management";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$course = $_GET['course'];

// delete the course from the course database
$sql = "DELETE FROM course WHERE courseNumber = '$course'";
mysqli_query($conn, $sql);
header("Location: ../dashboard/dashboard_sysop.php");  
?>