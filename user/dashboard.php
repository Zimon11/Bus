<?php
require '../includes/functions.php';
checkLogin();
checkPermission('view_dashboard');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>User Dashboard</h2>
        <p>Welcome, driver!</p>
        <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
