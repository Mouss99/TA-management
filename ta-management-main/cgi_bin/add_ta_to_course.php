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

$email = $_POST['chosenTA'];
$course = $_POST['chosenCourse'];
$term_year = $_POST['term'];

$result = mysqli_query($conn, "SELECT PositionsToAssign, TermYear FROM courses_quota WHERE (CourseNumber = '$course' AND TermYear='$term_year')");
$row_course = mysqli_fetch_assoc($result);
$remaining_ta_positions_to_assign = $row_course['PositionsToAssign'] - 1;

// update number of positions to assign
$sql = "UPDATE courses_quota SET PositionsToAssign=$remaining_ta_positions_to_assign WHERE (CourseNumber = '$course' AND TermYear='$term_year')";
mysqli_query($conn, $sql);


// get the TA info needed for the new databases
$result2 = $conn->query("SELECT * FROM ta_cohort WHERE (Email = '$email' AND TermYear='$term_year')");
$row_ta = mysqli_fetch_assoc($result2);
$studentID = $row_ta['StudentID'];
$assigned_hours = $row_ta['NumberHours'];
$name = $row_ta['TAName'];

// insert obtained values into the ta_assigned database
$sql = $conn->prepare("INSERT INTO ta_assigned (TermYear, CourseNum, TAName, StudentID, TAEmail, AssignedHours) VALUES (?, ?, ?, ?, ?, ?)");
$sql->bind_param('sssssi', $term_year, $course, $name, $studentID, $email, $assigned_hours);
$result = $sql->execute();

// insert obtained values into the ta_history database
$sql = $conn->prepare("INSERT INTO ta_history (TermYear, TAName, TAEmail, CourseNumber) VALUES (?, ?, ?, ?)");
$sql->bind_param('ssss', $term_year, $name, $email, $course);
$result = $sql->execute();

$conn->close();
header("Location: ../dashboard/dashboard_admin.php");
exit();
?>