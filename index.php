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

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM home WHERE id = $id";
    $conn->query($deleteQuery);
    header("Location: index.php"); // Refresh the page
    exit;
}

// Fetch records from the database
$sql = "SELECT * FROM home";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Expenditure Tracker</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #333;
        }

        h2, h3 {
            margin: 0;
            color: #444;
        }

        center {
            padding: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        form input, form button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        form input:focus {
            border-color: #007BFF;
        }

        form button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Table Styles */
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            text-align: center;
            padding: 12px 10px;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        table td {
            border-bottom: 1px solid #ddd;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        /* Links/Buttons */
        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }

        a.action {
            padding: 5px 10px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.2s;
        }

        a.action:hover {
            background-color: #007BFF;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            table, form {
                width: 100%;
            }

            form {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <center>
        <h2>Home Expenditure Tracker</h2><br><br>
        <form action="submit.php" method="POST">
            <input type="text" id="description" name="description" placeholder="Description" required>
            <input type="number" id="amount" name="amount" placeholder="Amount" required>
            <button type="submit" name="submit">add</button>
        </form><br>
        
        <h3>Expenditure Records</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= $row['amount'] ?></td>
                        <td>
                            <a href="index.php?delete=<?= $row['id'] ?>" class="action" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="action">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No records found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </center>
</body>
</html>
<?php $conn->close(); ?>
