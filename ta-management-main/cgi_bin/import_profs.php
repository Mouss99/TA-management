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
        $email = $items[0];
        $faculty = $items[1];
        $department = $items[2];

        $course_number = strtoupper($items[3]);
        if (mb_substr($course_number, 4,1) != " ") {
            $course_number = substr_replace($course_number, " ", 4, 0);
        }

        $sql = $conn->prepare("INSERT INTO Professor (professor, faculty, department, course) VALUES (?, ?, ?, ?)");
        $sql->bind_param('ssss', $email, $faculty, $department, $course_number);
        $result = $sql->execute();
    }
}

$conn->close();
header("Location: ../dashboard/dashboard_sysop.php");
exit();
?>