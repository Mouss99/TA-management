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

// define all fields to add to the database
$course_number = $_POST['course-number'];

$course_number = strtoupper($course_number);
if (mb_substr($course_number, 4,1) != " ") {
    $course_number = substr_replace($course_number, " ", 4, 0);
}

$course_name = $_POST['course-name'];
$course_description = $_POST['course-description'];
$course_term = $_POST['course-term'];
$course_year = $_POST['course-year'];
$course_instructor_email = $_POST['instructor-email'];

$sql = $conn->prepare("SELECT * FROM Course WHERE courseNumber = ?");
$sql->bind_param('s', $course_number);
$sql->execute();
$result = $sql->get_result();
$course = $result->fetch_assoc();

if ($course) {
    echo "<div class='error'>The course already exists.</div>";
    $conn->close();
    die();
} else {
    $sql = $conn->prepare("INSERT INTO Course (courseName, courseDesc, term, year, courseNumber, courseInstructor) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param('ssssss', $course_name, $course_description, $course_term, $course_year, $course_number, $course_instructor_email);
    $result = $sql->execute();
    $conn->close();
}

if ($result) {
    echo "<p>Account created successfully!</p>";
} else {
    echo "<p>Account creation failed...</p>";
}
header("Location: ../dashboard/dashboard_sysop.php"); 
?>