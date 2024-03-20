<?php
function convertAccountType($type) {
    switch ($type) {
        case "student":
            return "Student";
        case "professor":
            return "Professor";
        case "admin":
            return "TA Administrator";
        case "ta":
            return "Teaching Assistant";
        case "sysop":
            return "System Operator";
    }
}

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

$sql = $conn->prepare("SELECT * FROM User");
$sql->execute();
$result = $sql->get_result();

echo '<table>';
echo'<tr>
    <th class="red-label">Email</th>
    <th class="red-label">First Name</th>
    <th class="red-label">Last Name</th>
    <th class="red-label">User Type</th>
    </tr>';

$counter = 0;
// get all users and their info from the database
while ($user = $result->fetch_assoc()) {
    $counter = $counter + 1;
    // create comma-separated list of account types
    $query = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
                ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = ?");
    $query->bind_param('s', $user['email']);
    $query->execute();
    $res = $query->get_result();
    
    $uTypes = [];

    while ($row = $res->fetch_assoc()) {
        $uTypes[] = convertAccountType($row['userType']);
        // $acct_types = $acct_types . ", " . convertAccountType($row['userType']);
    }
    $userRoles = implode(', ', $uTypes);

    echo 
    '<tr>
        <td>'. $user['email'] .'</td>
        <td>'. $user['firstName'] .'</td>
        <td>'. $user['lastName'] .'</td>
        <td>'. $userRoles .'</td>
        <td>
        <button style="color:#007bff;" type="button" class="btn btn-light" data-toggle="modal" data-target="#edit-user-' . $counter . '">
        Edit
        </button>
        <div class="modal fade" id="edit-user-' . $counter .'" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="../cgi_bin/edit_user.php" method="post">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit user</h3>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="course-form-modal">
                        <input class="form-control" disabled type="text" name="" value="' . $user['email'] . '"/><br />
                        <input style="display:none;" class="form-control" type="text" name="email" value="' . $user['email'] . '"/>
                        <input class="form-control" placeholder="Please enter the first name of the user." type="text" name="first-name" value="' . $user['firstName'] . '"/><br />
                        <input class="form-control" placeholder="Please enter the last name of the user." type="text" name="last-name" value="' . $user['lastName'] . '"/><br />
                        <input class="form-control" placeholder="Please enter the new password of the user." type="password" name="password"/><br />
                        <div class="container">
                            <div class="flex-row">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <input type="checkbox" class="form-check-input" name="usertypes[]" value="1" /> Student
                                    </div>
                                <div>
                                    <input type="checkbox" name="usertypes[]" value="2" /> Professor
                                </div>
                            </div>
                        </div>
                        <div class="flex-row">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <input class="form-check-input" type="checkbox" name="usertypes[]" value="4"/> TA Administrator
                                </div>
                            <div>
                                <input class="form-check-input" type="checkbox" name="usertypes[]" value="3"/> Teaching Assistant
                            </div>
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="d-flex justify-content-between">
                            <div>
                                <input class="form-check-input" type="checkbox" name="usertypes[]" value="5"/> System Operator
                            </div>
                        </div>
                    </div>
                </div>
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
        <td><a href="../cgi_bin/delete_user.php?user='. $user['email'] .'">Delete</a></td>
    </tr>';
}

echo '</table>';
$conn->close();
?>