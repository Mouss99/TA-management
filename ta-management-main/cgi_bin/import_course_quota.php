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

if(isset($_FILES['myfile'])){
    $file_content = file($_FILES['myfile']['tmp_name']);
    foreach($file_content as $row) {
        $items = explode(",", trim($row));
        $course_term = $items[0];
        $course_number = strtoupper($items[1]);

        if (mb_substr($course_number, 4,1) != " ") {
            $course_number = substr_replace($course_number, " ", 4, 0);
        }
        $course_type = $items[2];
        $course_name = $items[3];
        $instructor_name = $items[4];
        $enrollment_number = $items[5];
        $ta_quota = $items[6];

        $result = $conn->query("SELECT * FROM courses_quota WHERE (CourseNumber = '$course_number' AND TermYear = '$course_term')");
        // if course for a semester is not already in the database, insert it
        if ($result->num_rows==0) {
            $remaining_ta_positions_to_assign = $items[6];
            $sql = $conn->prepare("INSERT INTO courses_quota (TermYear, CourseNumber, CourseName, CourseType, InstructorName, EnrollmentNumber, TAQuota, PositionsToAssign) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param('sssssiii', $course_term, $course_number, $course_name, $course_type, $instructor_name, $enrollment_number, $ta_quota, $remaining_ta_positions_to_assign);
            $result = $sql->execute();
        } else {
            // else, update the fields of that course with the import
            $row = mysqli_fetch_assoc($result);
            $remaining_ta_positions_to_assign = $ta_quota - ($row['TAQuota'] - $row['PositionsToAssign']);
            $sql = "UPDATE courses_quota SET CourseName='$course_name',  CourseType='$course_type', InstructorName='$instructor_name', EnrollmentNumber=$enrollment_number, TAQuota=$ta_quota, PositionsToAssign=$remaining_ta_positions_to_assign WHERE (CourseNumber='$course_number' AND TermYear='$course_term')";
            mysqli_query($conn, $sql);
        }
    }
}
$conn->close();
header("Location: ../dashboard/dashboard_admin.php");
exit();
?>