<?php
require_once '../core/database.php';

$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $id = htmlspecialchars($_POST['id']);

    if (empty($name)) {
        echo json_encode(['nameError' => 'Provide your name from PHP!']);
    } elseif (empty($email)) {
        echo json_encode(['emailError' => 'Provide your email from PHP!']);
    } else {
        if ($database->fetch_single('users', $id)) {
            
            if (!$database->is_email_already_exists('users', $email, $id, true)) {
                $data = [
                    'name' => $name,
                    'email' => $email,
                ];

                if ($database->update('users', $data, $id)) {
                    echo json_encode(['success' => 'Magic has been spelled!']);
                } else {
                    echo json_encode(['failure' => 'Magic has become shopper!']);
                }
            } else {
                echo json_encode(['emailError' => 'Email already exists!']);
            }
        } else {
            echo json_encode(['failure' => 'Something went wrong!']);
        }
    }
}
