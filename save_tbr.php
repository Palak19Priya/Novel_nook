<?php
session_start();
include 'dbconn.php';

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_SESSION['username'];
    $book_title = $_POST['book_title'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO tbr_list (username, category, book_title) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $category, $book_title);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "Success";
}
?>
