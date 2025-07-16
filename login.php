<?php
session_start();
include 'dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM registeredusers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: home.html");
            exit();
        } else {
            echo "<script> alert('Invalid password'); window.location.href='login.html'; </script>"; 
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
