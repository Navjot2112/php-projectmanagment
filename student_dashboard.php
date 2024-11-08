<?php
session_start();
$host = 'localhost'; // Database host
$db_name = 'user_management'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username']; // Use username instead of student_id
    $project_title = $_POST['project_title'];
    $description = $_POST['description'];
    $important_points = $_POST['important_points'];
    $folder_path = $_POST['folder_path'];
    
    // Check if there is already a submission for this user
    $checkSql = "SELECT * FROM projectsubmissions WHERE username = ? AND locked = 1";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<p>Your submission is locked. You cannot submit another project.</p>";
    } else {
        // Determine the submission status
        $status = $_POST['submit'] === 'Submit' ? 'Submitted' : 'Draft';
        $locked = ($status === 'Submitted') ? 1 : 0; // Lock if submitted

        // Insert into the database
        $sql = "INSERT INTO projectsubmissions (username, project_title, description, important_points, folder_path, status, locked)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $username, $project_title, $description, $important_points, $folder_path, $status, $locked);
        
        if ($stmt->execute()) {
            echo "<p>Project submitted successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Student Dashboard</h1>
    <form action="student_dashboard.php" method="POST">
        <label for="project_title">Project Title:</label>
        <input type="text" id="project_title" name="project_title" required><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required></textarea><br>

        <label for="important_points">Important Points:</label><br>
        <textarea id="important_points" name="important_points" rows="4" required></textarea><br>

        <label for="folder_path">Folder Path:</label>
        <input type="text" id="folder_path" name="folder_path"><br>

        <button type="submit" name="submit" value="Draft">Save Draft</button>
        <button type="submit" name="submit" value="Submit">Submit</button>
    </form>

    <h2>Submission Process Flow</h2>
    <p>Status: 
        <?php
        // Fetch submission status
        $query = "SELECT status FROM projectsubmissions WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row['status'] . " ";
            }
        } else {
            echo "No submissions found.";
        }
        ?>
    </p>
</body>
</html>
