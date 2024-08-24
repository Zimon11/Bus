<?php
require '../includes/functions.php';
checkLogin();
checkPermission('manage_users');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, admin!</p>
        <a href="../logout.php" class="btn btn-danger">Logout</a>

        <h3>Pending User Approvals</h3>
        <?php
        $stmt = $pdo->query("SELECT * FROM users WHERE status = 'pending'");
        $pendingUsers = $stmt->fetchAll();

        foreach ($pendingUsers as $user) {
            echo $user['username'] . " - " . $user['email'];
            echo "<form method='post' action='approve_user.php'>";
            echo "<input type='hidden' name='user_id' value='" . $user['id'] . "'>";
            echo "<button type='submit' class='btn btn-success'>Approve</button>";
            echo "</form>";
        }
        ?>
    </div>
</body>
</html>
