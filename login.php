<?php
include 'db.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Retrieve user from the database
    $sql = "SELECT * FROM users WHERE username='$username' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Update last_login timestamp
            $current_time = date('Y-m-d H:i:s');
            $update_sql = "UPDATE users SET last_login = '$current_time' WHERE username = '$username' AND role = '$role'";
            $conn->query($update_sql);

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found or role mismatch.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        
        <label>Role:</label>
        <select name="role" required>
            <option value="Admin">Admin</option>
            <option value="Faculty">Faculty</option>
            <option value="Coordinator">Coordinator</option>
            <option value="Student">Student</option>
        </select><br><br>
        
        <input type="submit" name="login" value="Login">
        <a href="forgot_password.php">Forgot Password?</a>
    </form>
</body>
</html>
