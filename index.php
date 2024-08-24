<?php
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
    
        // Notify admin of pending approval or direct them to the dashboard
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus</title>
</head>
<body>
    
</body>
</html>