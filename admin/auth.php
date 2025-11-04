<?php
require_once '../config/database.php';

function authenticate($email, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT u.*, ua.role FROM users u 
                           JOIN user_admin ua ON u.id = ua.user_id 
                           WHERE u.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            // Start session and store user info
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
    }
    return false;
}

function isAuthenticated() {
    session_start();
    return isset($_SESSION['user_id']);
}

function logout() {
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>