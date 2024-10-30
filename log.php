<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "youmakdo";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['passwords'];

$stmt = $conn->prepare("SELECT passwords FROM listahan WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

    $stmt->bind_result($stored_password);
    $stmt->fetch();
    
    if ($stored_password === $password) {
        echo "success";  
    } else {
        echo "invalid_password";  
    }
} else {
    echo "invalid_username";  
}

$stmt->close();
$conn->close();
?>
