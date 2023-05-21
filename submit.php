<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST["question"];
    $option1 = $_POST["option1"];
    $option2 = $_POST["option2"];
    $option3 = $_POST["option3"];
    $option4 = $_POST["option4"];
    $answer = $_POST["answer"];

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO questions (question, option1, option2, option3, option4, answer) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $question, $option1, $option2, $option3, $option4, $answer);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Question added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
