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

// get file content and store them in the database
if(isset($_FILES['myfile'])){
    $file_content = file($_FILES['myfile']['tmp_name']);
    foreach($file_content as $row) {
        $items = explode(",", trim($row));
        $term_year = $items[0];
        $course_term = substr($term_year, 0, -5);
        $course_year = substr($term_year, -4);
        
        $course_number = strtoupper($items[1]);
        if (mb_substr($course_number, 4,1) != " ") {
            $course_number = substr_replace($course_number, " ", 4, 0);
        }

        $course_name = $items[2];
        $course_description = $items[3];
        $course_instructor_email = $items[4];

        $sql = $conn->prepare("INSERT INTO Course (courseName, courseDesc, term, year, courseNumber, courseInstructor) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->bind_param('ssssss', $course_name, $course_description, $course_term, $course_year, $course_number, $course_instructor_email);
        $result = $sql->execute();
    }
}
$conn->close();
header("Location: ../dashboard/dashboard_sysop.php");
exit();
?>