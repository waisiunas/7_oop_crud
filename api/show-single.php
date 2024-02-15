<?php
require_once '../core/database.php';

$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id']);

    if ($user = $database->fetch_single('users', $id)) {
        echo json_encode($user);
    } else {
        echo json_encode(['failure' => 'Something went wrong!']);
    }
}
