<?php
include 'db.php';

if (isset($_POST['reset'])) {
    $username = $_POST['username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Update user password
    $sql = "UPDATE users SET password='$new_password' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Password reset successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="forgot_password.php" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label>New Password:</label>
        <input type="password" name="new_password" required><br><br>
        
        <input type="submit" name="reset" value="Reset Password">
    </form>
</body>
</html>
