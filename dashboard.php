<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];

echo "<h2>Welcome, " . htmlspecialchars($username) . "! You are logged in as " . htmlspecialchars($role) . ".</h2>";

// Display role-based content
switch ($role) {
    case 'Admin':
        echo "<p>Admin dashboard content goes here.</p>";
        break;
    case 'Faculty':
        echo "<p>Faculty dashboard content goes here.</p>";
        break;
    case 'Coordinator':
        echo "<p>Coordinator dashboard content goes here.</p>";
        break;
        case 'Student':
            echo '<a href="student_dashboard.php">Go to Student Dashboard</a>';
            echo "<p>Student dashboard content goes here.</p>";
            break;
        
    default:
        echo "<p>Role not recognized.</p>";
}

echo '<br><a href="logout.php">Logout</a>';
?>

