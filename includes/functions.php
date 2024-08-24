<?php
session_start();
require 'config.php';

function registerUser($username, $password, $email) {
    global $pdo;
    $default_role_id = 2; // Default to 'driver' role

    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role_id, status)
                           VALUES (:username, :password, :email, :role_id, 'pending')");
    $stmt->execute([
        'username' => $username,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'email' => $email,
        'role_id' => $default_role_id
    ]);
}

function login($username, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT u.id, u.password, r.role_name FROM users u
                           JOIN roles r ON u.role_id = r.id
                           WHERE u.username = :username");
    $stmt->execute(['username' => $username]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role_name'];

            // Redirect based on role
            if ($user['role_name'] === 'admin') {
                header('Location: /admin/dashboard.php');
            } else {
                header('Location: /user/dashboard.php');
            }
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit();
    }
}

function checkPermission($required_permission) {
    global $pdo;

    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT p.permission_name
                           FROM users u
                           JOIN roles r ON u.role_id = r.id
                           JOIN role_permissions rp ON r.id = rp.role_id
                           JOIN permissions p ON rp.permission_id = p.id
                           WHERE u.id = :user_id AND p.permission_name = :permission");
    $stmt->execute(['user_id' => $user_id, 'permission' => $required_permission]);
    
    if ($stmt->rowCount() === 0) {
        echo "Access Denied";
        exit();
    }
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: /login.php');
    exit();
}
?>
