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
$course_number = $_POST['course-number'];
$course_name = $_POST['course-name'];
$course_description = $_POST['course-description'];
$course_term = $_POST['course-term'];
$course_year = strval($_POST['course-year']);
$course_instructor = $_POST['course-instructor'];

// update the course with the new information
$sql = "UPDATE Course SET courseName='$course_name', courseDesc='$course_description', term='$course_term', year='$course_year', courseInstructor='$course_instructor' WHERE courseNumber = '$course_number'";
mysqli_query($conn, $sql);
$conn->close();

header("Location: ../dashboard/dashboard_sysop.php");  
?>