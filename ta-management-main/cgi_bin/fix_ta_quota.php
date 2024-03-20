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

$course_number = $_POST['course'];
$enrollment_number = $_POST['enroll'];
$ta_quota = $_POST['quota'];
$term_year = $_POST['term'];

$result = $conn->query("SELECT * FROM courses_quota WHERE (CourseNumber = '$course_number' AND TermYear = '$term_year')");
$row = mysqli_fetch_assoc($result);
$remaining_ta_positions_to_assign = $ta_quota - ($row['TAQuota'] - $row['PositionsToAssign']);

//update the number of TA positions available and enrollment number
$sql = "UPDATE courses_quota SET EnrollmentNumber=$enrollment_number, TAQuota=$ta_quota, PositionsToAssign=$remaining_ta_positions_to_assign WHERE (CourseNumber = '$course_number' AND TermYear = '$term_year')";
mysqli_query($conn, $sql);

            
$conn->close();
header("Location: ../dashboard/dashboard_admin.php");
exit();
?>