<?php 

// Nice resource for PHP & MySQL: https://phpdelusions.net/mysqli

$servername = "localhost"; // Change accordingly
$username = "root"; // Change accordingly
$password = ""; // Change accordingly
$db = "ta-management"; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$sql = $conn->prepare("SELECT * FROM User WHERE email = ?");
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
$conn->close();

if ($user) {
    // retrieve password from database 
    $hashed_pass = $user['password'];

    // check against the user input password
    $login_success = password_verify($_POST['password'], $hashed_pass);

    if ($login_success) {
        session_start();
        $_SESSION["email"] = $email;
        echo "<script>function redirect() { 
                window.location.replace('../dashboard/dashboard.php'); 
            }</script>";
    } else {
        echo '<text>Password is incorrect. Try again.</text>';
    }

} else {
    echo '<text>Username does not exist.</text>';
    return;
}
?>