<?php
echo"commit changes";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if (isset($_POST['expenseName'], $_POST['expenseAmount'], $_POST['expenseCategory'], $_POST['expenseDescription'], $_POST['expenseDate'])) {
        // Include your database connection code here
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "expense_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind parameters
        $stmt = $conn->prepare("INSERT INTO expenses (expenseName, expenseAmount, expenseCategory, expenseDescription, expenseDate, billImage) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $expenseName, $expenseAmount, $expenseCategory, $expenseDescription, $expenseDate, $billImage);

        // Set parameters
        $expenseName = $_POST['expenseName'];
        $expenseAmount = $_POST['expenseAmount'];
        $expenseCategory = $_POST['expenseCategory'];
        $expenseDescription = $_POST['expenseDescription'];
        $expenseDate = $_POST['expenseDate'];

        // Handle file upload for billImage
        $billImage = "";
        if ($_FILES['billImage']['size'] > 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["billImage"]["name"]);
            // if (move_uploaded_file($_FILES["billImage"]["tmp_name"], $target_file)) {
            //     $billImage = $target_file;
            // } else {
            //     echo "Error uploading file.";
            //     exit();
            // }
        }

        // Execute query
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "One or more required fields are missing.";
    }
} else {
    echo "Form not submitted.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker - Add Expense</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Expense</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="expenseName">Expense Name:</label>
            <input type="text" class="form-control" id="expenseName" name="expenseName" required>
        </div>
        <div class="form-group">
            <label for="expenseAmount">Expense Amount:</label>
            <input type="number" class="form-control" id="expenseAmount" name="expenseAmount" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="expenseCategory">Expense Category:</label>
            <select class="form-control" id="expenseCategory" name="expenseCategory" required>
                <option value="">Select Category</option>
                <option value="Food">Food</option>
                <option value="Transportation">Transportation</option>
                <option value="Housing">Housing</option>
                <option value="Utilities">Utilities</option>
                
            </select>
        </div>
        <div class="form-group">
            <label for="expenseDescription">Expense Description:</label>
            <input type="text" class="form-control" id="expenseDescription" name="expenseDescription" required>
        </div>
        <div class="form-group">
            <label for="expenseDate">Expense Date:</label>
            <input type="date" class="form-control" id="expenseDate" name="expenseDate" required>
        </div>
        <div class="form-group">
            <label for="billImage">Bill Image:</label>
            <input type="file" class="form-control-file" id="billImage" name="billImage" accept="uploads/">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>

