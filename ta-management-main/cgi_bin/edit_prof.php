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

// define all fields to edit the database
$instructor_email = $_POST['email'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$course_number = $_POST['course-number'];

$course_number = strtoupper($course_number);
if (mb_substr($course_number, 4,1) != " ") {
    $course_number = substr_replace($course_number, " ", 4, 0);
}

// update the prof with the new information
$sql = "UPDATE Professor SET faculty='$faculty', department='$department', course='$course_number' WHERE professor = '$instructor_email'";
mysqli_query($conn, $sql);
$conn->close();

header("Location: ../dashboard/dashboard_sysop.php");  
?>