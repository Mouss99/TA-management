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

function user_role_id_map($role){
    $user_roles = array(1 => "student", 2 => "professor", 3 => "ta", 4 => "admin", 5 => "sysop");
    $key = array_search($role, $user_roles);
    return($key);
}

// get file content and store them in the database
if(isset($_FILES['myfile'])){
    $file_content = file($_FILES['myfile']['tmp_name']);
    foreach($file_content as $row) {
        $items = explode(",", trim($row));
        $first_name = $items[0];
        $last_name = $items[1];
        $email = $items[2];
        $password = $items[3];
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        $account_types = explode('/', $items[4]);
        $account_types = array_map("user_role_id_map", $account_types);
        $sql = $conn->prepare("INSERT INTO user (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
        $sql->bind_param('ssss', $first_name, $last_name, $email, $hashed_pass);
        if ($sql->execute()) {
            foreach ($account_types as $account_type) {
                $user_type_sql = $conn->prepare("INSERT INTO user_userType (userId, userTypeId) VALUES (?, ?)");
                $user_type_sql->bind_param('si', $email, $account_type);
                $user_type_sql->execute();
            }
        }
    }
}
$conn->close();
header("Location: ../dashboard/dashboard_sysop.php");
exit();
?>