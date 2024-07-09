<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Data</title>
</head>
<body>
    <h2>Update User Data</h2>
    <?php
    
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "my_database";

   
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    if (isset($_POST['update_id'])) {
        $update_id = $_POST['update_id'];
        $sql_select = "SELECT email, password FROM users WHERE id = $update_id";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = htmlspecialchars($row["email"]);
            $password = htmlspecialchars($row["password"]);
        } else {
            echo "<p>User not found.</p>";
        }
    }

    
    $conn->close();
    ?>
    <form method="post" action="save_login.php">
        <label for="new_email">Email:</label><br>
        <input type="email" id="new_email" name="new_email" value="<?php echo $email; ?>" required><br><br>

        <label for="new_password">Password:</label><br>
        <input type="password" id="new_password" name="new_password" value="<?php echo $password; ?>" required><br><br>

        <input type="hidden" name="update_id" value="<?php echo $update_id; ?>">
        <input type="submit" value="Update">
    </form>
</body>
</html>
