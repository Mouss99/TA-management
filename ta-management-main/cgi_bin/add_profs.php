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
$instructor_email = $_POST['professor'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$course_number = $_POST['course'];

$course_number = strtoupper($course_number);
if (mb_substr($course_number, 4,1) != " ") {
    $course_number = substr_replace($course_number, " ", 4, 0);
}

$sql = $conn->prepare("SELECT * FROM Professor WHERE professor = ?");
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<div class='error'>The Professor already exists.</div>";
    $conn->close();
    die();
} else {
    $sql = $conn->prepare("INSERT INTO Professor (professor, faculty, department, course) VALUES (?, ?, ?, ?)");
    $sql->bind_param('ssss', $instructor_email, $faculty, $department, $course_number);
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