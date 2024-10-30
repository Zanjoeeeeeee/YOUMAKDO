<?php
$servername = "localhost";
$dbusername = "root"; 
$dbpassword = ""; 
$dbname = "youmakdo";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['names'];
    $contact = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['passwords'];

    if (!filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (strlen($password) < 8 || strlen($password) > 20) {
        die("Error: Password must be between 8 and 20 characters.");
    }

    $stmt = $conn->prepare("SELECT * FROM listahan WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "exists";  
    } else {
        $stmt = $conn->prepare("SELECT * FROM listahan WHERE email = ?");
        $stmt->bind_param("s", $contact);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "email_exists";  
        } else {
            $stmt = $conn->prepare("INSERT INTO listahan (names, email, username, passwords) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $contact, $username, $password);

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
    $stmt->close();
}
$conn->close();
?>
