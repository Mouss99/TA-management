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

$input = $_POST['TA'];

$string_array = explode("|", $input);
$name = $string_array[0];
$email = $string_array[1];
$course = $string_array[2];
$term = $string_array[3];

$comment = $_POST['comment'];

// insert obtained values into the ta_performance database
$sql = $conn->prepare("INSERT INTO ta_performance (TermYear, CourseNumber, TAName, TAEmail, Comment, TimeStamp) VALUES ('$term', '$course', '$name', '$email', '$comment', CURRENT_TIME())");
$result = $sql->execute();

$conn->close();
header("Location: ../dashboard/dashboard_select_course.php");
exit();
?>