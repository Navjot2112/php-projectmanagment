<?php
include 'db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $users = [
        ['username' => 'navjot', 'password' => '2003', 'role' => 'Admin'],
        ['username' => 'navjot', 'password' => '21122003', 'role' => 'Faculty'],
        ['username' => 'manpreet', 'password' => '2000', 'role' => 'Student'],
        ['username' => 'manpreet', 'password' => '24012000', 'role' => 'Coordinator'],
        ['username' => 'harwinder', 'password' => '1974', 'role' => 'Student'],
        ['username' => 'karamjeet', 'password' => '1974', 'role' => 'Faculty'],
        ['username' => 'gagan', 'password' => '2002', 'role' => 'Coordinator']
    ];

    // Insert user data into the users table
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
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
        
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>

