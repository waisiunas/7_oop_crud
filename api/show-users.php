<?php
require_once '../core/database.php';

// $sql = "SELECT * FROM `users`";
// $result = $conn->query($sql);
// $users = $result->fetch_all(MYSQLI_ASSOC);
$users = $database->fetch_all('users');
echo json_encode($users);
