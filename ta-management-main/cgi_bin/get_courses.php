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

$sql = $conn->prepare("SELECT * FROM Course");
$sql->execute();
$result = $sql->get_result();

echo '<table>';
echo'<tr>
    <th class="red-label">Course Number</th>
    <th class="red-label">Course Name</th>
    <th class="red-label">Course Description</th>
    <th class="red-label">Course Semester</th>
    <th class="red-label">Course Year</th>
    <th class="red-label">Course Instructor</th>
    </tr>';

$counter = 0;
// get all courses and their info from the database
while ($course = $result->fetch_assoc()) {
    $counter = $counter + 1;
    $query = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $query->bind_param('s', $course['courseInstructor']);
    $query->execute();
    $res = $query->get_result();
    $user = $res->fetch_assoc();
    echo 
    '<tr>
        <td>'. $course['courseNumber'] .'</td>
        <td>'. $course['courseName'] .'</td>
        <td>'. $course['courseDesc'] .'</td>
        <td>'. $course['term'] .'</td>
        <td>'. $course['year'] .'</td>
        <td>'. $user['firstName'] . ' ' . $user['lastName'] . '</td> 
        <td>
        <button style="color:#007bff;" type="button" class="btn btn-light" data-toggle="modal" data-target="#edit-course-' . $counter . '">
        Edit
        </button>
        <div class="modal fade" id="edit-course-' . $counter .'" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="../cgi_bin/edit_course.php" method="post">
                <div class="modal-header">
                    <h3 class="modal-title">Edit course</h3>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="course-form-modal">
                    <input class="form-control" disabled type="text" name="" value="' . $course['courseNumber'] . '"/><br />
                    <input style="display:none;" class="form-control" type="text" name="course-number" value="' . $course['courseNumber'] . '"/>
                    <input class="form-control" placeholder="Please enter the course name." type="text" name="course-name" value="' . $course['courseName'] . '"/><br />
                    <input class="form-control" placeholder="Please enter the course description." type="text" name="course-description" value="' . $course['courseDesc'] . '"/><br />
                    <input class="form-control" placeholder="Please enter the course term." type="text" name="course-term" value="' . $course['term'] . '"/><br />
                    <input class="form-control" placeholder="Please enter the course year." type="number" maxlength="4" name="course-year" value="' . $course['year'] . '"/><br />
                    <input class="form-control" placeholder="Please enter the course name." type="text" name="course-instructor" value="' . $course['courseInstructor'] .'"/><br />
                    <div id="course-error-msg-cont"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-light" data-dismiss="modal" value="Cancel"/>
                    <input type="submit" class="btn btn-light" value="Save"/>
                </div>
                </form>
            </div>
            </div>
        </div>
        </td>
        <td><a href="../cgi_bin/delete_course.php?course='. $course['courseNumber'] .'">Delete</a></td>
    </tr>';
}

echo '</table>';
$conn->close();
?>