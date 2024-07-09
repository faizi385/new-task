<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entered User Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Entered User Data</h2>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $servername = "localhost"; 
            $db_username = "root";
            $db_password = ""; 
            $dbname = "my_database"; 

           
            $conn = new mysqli($servername, $db_username, $db_password, $dbname);

            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['update_id'])) {
                  
                    $email = $conn->real_escape_string($_POST['email']);
                    $password = $conn->real_escape_string($_POST['password']);

                    $sql_insert = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

                    if ($conn->query($sql_insert) === TRUE) {
                        echo "<p>Record added successfully.</p>";
                    } else {
                        echo "Error: " . $sql_insert . "<br>" . $conn->error;
                    }
                } elseif (isset($_POST['update_id']) && isset($_POST['new_email']) && isset($_POST['new_password'])) {
                 
                    $update_id = $_POST['update_id'];
                    $new_email = $conn->real_escape_string($_POST['new_email']);
                    $new_password = $conn->real_escape_string($_POST['new_password']);

                    $sql_update = "UPDATE users SET email = '$new_email', password = '$new_password' WHERE id = $update_id";

                    if ($conn->query($sql_update) === TRUE) {
                        echo "<p>Record updated successfully.</p>";
                    } else {
                        echo "Error: " . $sql_update . "<br>" . $conn->error;
                    }
                } elseif (isset($_POST['delete_id'])) {
                    
                    $delete_id = $_POST['delete_id'];
                    $sql_delete = "DELETE FROM users WHERE id = $delete_id";

                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<p>Record deleted successfully.</p>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }
            }

          
            $sql_select = "SELECT id, email, password FROM users";
            $result = $conn->query($sql_select);

            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["password"]) . "</td>";
                    echo "<td>
                            <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' onsubmit='return confirm(\"Are you sure you want to delete this record?\");' style='display:inline-block;'>
                                <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                <input type='submit' value='Delete'>
                            </form>
                            <form method='post' action='update.php' style='display:inline-block;'>
                                <input type='hidden' name='update_id' value='" . $row["id"] . "'>
                                <input type='submit' value='Update'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No users found in database</td></tr>";
            }

      
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
