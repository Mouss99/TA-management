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

$sql = $conn->prepare("SELECT * FROM Professor");
$sql->execute();
$result = $sql->get_result();

echo '<table>';
echo'<tr>
    <th class="red-label">Email</th>
    <th class="red-label">First name</th>
    <th class="red-label">Last name</th>
    <th class="red-label">Faculty</th>
    <th class="red-label">Department</th>
    <th class="red-label">Courses</th>
    </tr>';

$counter = 0;

// get all profs and their info from the database
while ($prof = $result->fetch_assoc()) {
    $counter = $counter + 1;
    $query = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $query->bind_param('s', $prof['professor']);
    $query->execute();
    $res = $query->get_result();
    $user = $res->fetch_assoc();
    echo 
    '<tr>
        <td>'. $prof['professor'] .'</td>
        <td>'. $user['firstName'] .'</td>
        <td>'. $user['lastName'] .'</td>
        <td>'. $prof['faculty'] .'</td>
        <td>'. $prof['department'] .'</td>
        <td>'. $prof['course'] .'</td>
        <td>
        <button style="color:#007bff;" type="button" class="btn btn-light" data-toggle="modal" data-target="#edit-prof-' . $counter . '">
        Edit
        </button>
        <div class="modal fade" id="edit-prof-' . $counter .'" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="../cgi_bin/edit_prof.php" method="post">
                <div class="modal-header">
                    <h3 class="modal-title">Edit prof</h3>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="course-form-modal">
                    <input class="form-control" disabled type="text" name="" value="' . $prof['professor'] . '"/><br />
                    <input style="display:none;" class="form-control" type="text" name="email" value="' . $prof['professor'] . '"/>
                    <select class="form-control" name="faculty">
                        <option value="" selected disabled> Select a Faculty...</option>
                        <option value="Science">Science</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Arts">Arts</option>
                    </select><br />
                  <select class="form-control" name="department">
                    <option value="" selected disabled> Select a Department...</option>
                    <option value="Computer Science"> Computer Science</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Physics">Physics</option></select><br />
                    <input class="form-control" placeholder="Please enter the course number." type="text" name="course-number" value="' . $prof['course'] . '"/><br />
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
        <td><a href="../cgi_bin/delete_prof.php?prof='. $prof['professor'] .'">Delete</a></td>
    </tr>';
}
echo '</table>';

$conn->close();
?>