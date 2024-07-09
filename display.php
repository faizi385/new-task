<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>User Data</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming database connection details
            $servername = "localhost";
            $username = "your_username";
            $password = "your_password";
            $dbname = "my_database";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from database
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            // Display data in table rows
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["email"]."</td>
                        <td>".$row["password"]."</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No users found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
