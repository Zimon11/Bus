<?php
require '../includes/functions.php';
checkLogin();
checkPermission('manage_users');

if ($_POST['user_id']) {
    $stmt = $pdo->prepare("UPDATE users SET status = 'active' WHERE id = :id");
    $stmt->execute(['id' => $_POST['user_id']]);
    header('Location: dashboard.php');
}
?>
