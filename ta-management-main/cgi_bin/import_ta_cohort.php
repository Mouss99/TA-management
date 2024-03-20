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
        $ta_name = $items[1];
        $student_id = $items[2];
        $legal_name = $items[3];
        $email = $items[4];
        $grad_ugrad = $items[5];
        $supervisor_name = $items[6];
        $priority = $items[7];
        $hours = $items[8];
        $date_applied = $items[9];
        $location = $items[10];
        $phone = $items[11];
        $degree = $items[12];
        $courses_applied = $items[13];
        $open_to_other_courses = $items[14];
        $notes = $items[15];

        $result = $conn->query("SELECT * FROM ta_cohort WHERE (Email = '$email' AND TermYear='$course_term')");
        $num = $result->num_rows;
        // if TA for a semester is not already in the database, insert it
        if ($result->num_rows==0) {
            $sql = $conn->prepare("INSERT INTO ta_cohort (TermYear, TAName, StudentID, 	LegalName, Email, GradUgrad, SupervisorName, Priority, NumberHours, DateApplied, TheLocation, Phone, Degree, CoursesApplied, OpenToOtherCourses, Notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param('ssisssssississss', $course_term, $ta_name, $student_id, $legal_name, $email, $grad_ugrad, $supervisor_name, $priority, $hours, $date_applied, $location, $phone, $degree, $courses_applied, $open_to_other_courses, $notes);
            $result = $sql->execute();
        } else {
        // else, update the fields of that TA with the import
            $sql = "UPDATE ta_cohort SET TAName='$ta_name', StudentID='$student_id', LegalName='$legal_name', GradUgrad='$grad_ugrad', SupervisorName='$supervisor_name', Priority='$priority', NumberHours=$hours, DateApplied='$date_applied', TheLocation='$location', Phone='$phone', Degree='$degree', CoursesApplied='$courses_applied', OpenToOtherCourses='$open_to_other_courses', Notes='$notes' WHERE (Email='$email' AND TermYear='$course_term')";
            mysqli_query($conn, $sql);
        }
    }
}
$conn->close();
header("Location: ../dashboard/dashboard_admin.php");
exit();

?>
