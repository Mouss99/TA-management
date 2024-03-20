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

// define all fields to add to the database
$usertypes = $_POST['usertypes'];

$password = $_POST['password'];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST['email'];
$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];

$sql = $conn->prepare("SELECT * FROM User WHERE email = ?");
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<div class='error'>The username already exists.</div>";
    $conn->close();
    die();
} else {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO User (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
    $sql->bind_param('ssss', $first_name, $last_name, $email, $hashed_pass);
    if ($sql->execute()) {
        foreach ($usertypes as $usertype) {
            $usertype = intval($usertype);
            $user_type_sql = $conn->prepare("INSERT INTO user_userType (userId, userTypeId) VALUES (?, ?)");
            $user_type_sql->bind_param('si', $email, $usertype);
            $user_type_sql->execute();
        }
    }
    $conn->close();
}

if ($result) {
    echo "<p>Account created successfully!</p>";
} else {
    echo "<p>Account creation failed...</p>";
}
header("Location: ../dashboard/dashboard_sysop.php");
?>