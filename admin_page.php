<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
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
        <form action="submit.php" method="post">
            <label for="question">Question:</label>
            <input type="text" name="question" id="question" required><br><br>

            <label for="option1">Option 1:</label>
            <input type="text" name="option1" id="option1" required><br>

            <label for="option2">Option 2:</label>
            <input type="text" name="option2" id="option2" required><br>

            <label for="option3">Option 3:</label>
            <input type="text" name="option3" id="option3" required><br>

            <label for="option4">Option 4:</label>
            <input type="text" name="option4" id="option4" required><br><br>

            <label for="answer">Correct Answer:</label>
            <select name="answer" id="answer" required>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
            </select><br><br>

            <input type="submit" value="Add Question">
        </form>
    </div>

</div>

</body>
</html>
