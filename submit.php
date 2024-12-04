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

if (isset($_POST['submit'])) {
    $desc = $_POST['description'];
    $amt = $_POST['amount'];

    $sql = "INSERT INTO home (description, amount) VALUES ('$desc', '$amt')";

    if ($conn->query($sql) === TRUE) {
        echo "New record added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: index.php"); // Redirect back to the index page
    exit;
}
?>
