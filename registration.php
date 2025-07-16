<?php
// dbconn.php should contain your DB credentials and connection logic.
include 'dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $nationality = $_POST['nationality'];

    $stmt = $conn->prepare("INSERT INTO registeredusers (fullname, username, password, email, contact, gender, birthdate, nationality) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fullname, $username, $password, $email, $contact, $gender, $birthdate, $nationality);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. Redirecting to login page.'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
