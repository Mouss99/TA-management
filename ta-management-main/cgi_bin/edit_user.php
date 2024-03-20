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

// define all fields to edit the database
$email = $_POST['email'];
$first_name = $_POST['first-name'];
$last_name = $_POST['last-name'];
$password = $_POST['password'];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

$usertypes = $_POST['usertypes'];

// update the user with the new information
$sql = "UPDATE User SET firstName='$first_name', lastName='$last_name', password='$hashed_pass' WHERE email = '$email'";
mysqli_query($conn, $sql);

// delete all the roles of the user in the database to start over
$sql = "DELETE FROM user_usertype WHERE userId = '$email'";
mysqli_query($conn, $sql);

foreach ($usertypes as $usertype) {
    $usertype = intval($usertype);
    $user_type_sql = $conn->prepare("INSERT INTO user_userType (userId, userTypeId) VALUES (?, ?)");
    $user_type_sql->bind_param('si', $email, $usertype);
    $user_type_sql->execute();
}

$conn->close();

header("Location: ../dashboard/dashboard_sysop.php");  
?>