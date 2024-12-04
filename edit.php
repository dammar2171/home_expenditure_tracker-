<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Ensure your password is correct
$database = "testdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch record for editing
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM home WHERE id = $id";
    $result = $conn->query($sql);
    $record = $result->fetch_assoc();

    // Handle the update request
    if (isset($_POST['update'])) {
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $updateQuery = "UPDATE home SET description = ?, amount = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssi", $description, $amount, $id);
        $stmt->execute();
        header("Location: index.php"); // Redirect to the index page after update
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expenditure</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #333;
        }

        h2 {
            margin: 0;
            color: #444;
            text-align: center;
            padding: 20px;
        }

        /* Form Styles */
        .form-container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container input,
        .form-container button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            outline: none;
        }

        .form-container input:focus {
            border-color: #007BFF;
        }

        .form-container button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .form-container {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <h2>Edit Expenditure Record</h2>

    <div class="form-container">
        <form action="" method="POST">
            <label for="description">Description</label>
            <input type="text" id="description" name="description" value="<?= htmlspecialchars($record['description']) ?>" required>

            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" value="<?= htmlspecialchars($record['amount']) ?>" required>

            <button type="submit" name="update">Update</button><br>
            <!-- Back Button -->
<div class="back-button">
    <a href="index.php">
        <button type="button">Back to Home</button>
    </a>
</div>


        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
