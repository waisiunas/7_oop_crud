<?php
require_once '../core/database.php';

$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id']);

    if ($database->fetch_single('users', $id)) {
        
        if ($database->delete('users', $id)) {
            echo json_encode(['success' => 'Magic has been spelled!']);
        } else {
            echo json_encode(['failure' => 'Magic has become shopper!']);
        }
    } else {
        echo json_encode(['failure' => 'Something went wrong!']);
    }
}
