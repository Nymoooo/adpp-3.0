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

    // Check if the question already exists in the database
    $checkQuery = "SELECT * FROM questions WHERE question = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $question);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Question already exists.";
    } else {
        // Prepare and bind the statement
        $insertQuery = "INSERT INTO questions (question, option1, option2, option3, option4, answer) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssss", $question, $option1, $option2, $option3, $option4, $answer);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "Question added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
