<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST["question"];
    $questionType = $_POST["questionType"];

    if ($questionType == "multiple_choice") {
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
            $error = "Question already exists.";
        } else {
            // Prepare and bind the statement
            $insertQuery = "INSERT INTO questions (question, option1, option2, option3, option4, answer) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssss", $question, $option1, $option2, $option3, $option4, $answer);

            // Execute the statement
            if ($stmt->execute() === TRUE) {
                $error = "Question added successfully.";
            } else {
                $error = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
        $conn->close();
    } elseif ($questionType == "true_false") {
        $answer = $_POST["answer_tf"];

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
            $error = "Question already exists.";
        } else {
            // Prepare and bind the statement
            $insertQuery = "INSERT INTO questions (question, answer) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ss", $question, $answer);

            // Execute the statement
            if ($stmt->execute() === TRUE) {
                $error = "Question added successfully.";
            } else {
                $error = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container">

    <div class="content">
        <h3>Hi, <span>Professor</span></h3>
        <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
        <p>This is a Professor page</p>

        <a href="logout.php" class="btn">Logout</a>

        <h2>Quiz Maker</h2>
        <form action="" method="post">
            <label for="question">Question:</label>
            <input type="text" name="question" id="question" required><br><br>

            <label for="questionType">Question Type:</label>
            <select name="questionType" id="questionType" required>
                <option value="multiple_choice">Multiple Choice</option>
                <option value="true_false">True/False</option>
            </select><br><br>

            <div id="multipleChoiceOptions">
                <label for="option1">Option 1:</label>
                <input type="text" name="option1" id="option1" required><br>

                <label for="option2">Option 2:</label>
                <input type="text" name="option2" id="option2" required><br>

                <label for="option3">Option 3:</label>
                <input type="text" name="option3" id="option3" required><br>

                <label for="option4">Option 4:</label>
                <input type="text" name="option4" id="option4" required><br>

                <label for="answer">Answer (Option Number):</label>
                <input type="number" name="answer" id="answer" required><br><br>
            </div>

            <div id="trueFalseOptions">
                <label for="answer_tf">Answer:</label><br>
                <input type="radio" name="answer_tf" id="true" value="True" required>
                <label for="true">True</label><br>

                <input type="radio" name="answer_tf" id="false" value="False" required>
                <label for="false">False</label><br><br>
            </div>

            <input type="submit" value="Submit" class="btn">
        </form>

        <p class="error"><?php echo $error; ?></p>

        <script>
            const questionTypeSelect = document.getElementById('questionType');
            const multipleChoiceOptions = document.getElementById('multipleChoiceOptions');
            const trueFalseOptions = document.getElementById('trueFalseOptions');

            questionTypeSelect.addEventListener('change', function() {
                if (this.value === 'multiple_choice') {
                    multipleChoiceOptions.style.display = 'block';
                    trueFalseOptions.style.display = 'none';
                } else if (this.value === 'true_false') {
                    multipleChoiceOptions.style.display = 'none';
                    trueFalseOptions.style.display = 'block';
                }
            });
        </script>
    </div>

</div>

</body>
</html>
