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

$assignID = $_POST['chosenID'];

// get the TA info needed to delete from the database
$result2 = $conn->query("SELECT * FROM ta_assigned WHERE AssignID=$assignID");
$row_ta = mysqli_fetch_assoc($result2);
$term = $row_ta['TermYear'];
$course = $row_ta['CourseNum'];
$email = $row_ta['TAEmail'];

// update number of positions to assign in the courses_quota database
$result = mysqli_query($conn, "SELECT PositionsToAssign FROM courses_quota WHERE (CourseNumber = '$course' AND TermYear='$term')");
$row_course = mysqli_fetch_assoc($result);
$remaining_ta_positions_to_assign = $row_course['PositionsToAssign'] + 1;
$sql = "UPDATE courses_quota SET PositionsToAssign=$remaining_ta_positions_to_assign WHERE (CourseNumber='$course' AND TermYear='$term')";
mysqli_query($conn, $sql);

// delete the ta from the ta_assigned database
$sql = "DELETE FROM ta_assigned WHERE AssignID=$assignID";
mysqli_query($conn, $sql);

// delete the ta from the ta_history database
$sql = "DELETE FROM ta_history WHERE (TermYear='$term' AND TAEmail='$email' AND CourseNumber='$course')" ;
mysqli_query($conn, $sql);

$conn->close();
header("Location: ../dashboard/dashboard_admin.php");
exit();
?>