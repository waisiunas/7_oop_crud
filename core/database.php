<?php
class Database
{
    private $conn;

    private const DB_HOST = "localhost";
    private const DB_USER = "root";
    private const DB_PASS = "";
    private const DB_NAME = "7_oop_crud";


    public function __construct()
    {
        $this->conn = new mysqli(static::DB_HOST, static::DB_USER, static::DB_PASS, static::DB_NAME);

        if (!$this->conn) {
            die('Failed to connect');
        }
    }

    public function fetch_all($table)
    {
        $sql = "SELECT * FROM `$table`";
        $result = $this->conn->query($sql);
        $records = $result->fetch_all(MYSQLI_ASSOC);
        return $records ? $records : false;
    }

    public function fetch_single($table, $id)
    {
        $sql = "SELECT * FROM `$table` WHERE `id` = $id LIMIT 1";
        $result = $this->conn->query($sql);
        $record = $result->fetch_assoc();
        return $result->num_rows === 1 ? $record : false;
    }

    public function is_email_already_exists($table, $email, $id = null, $update = false)
    {
        if ($update) {
            $sql = "SELECT * FROM `$table` WHERE `email` = '$email' AND `id` != $id LIMIT 1";
        } else {
            $sql = "SELECT * FROM `$table` WHERE `email` = '$email' LIMIT 1";
        }

        $result = $this->conn->query($sql);
        return $result->num_rows === 1 ? true : false;
    }

    public function create($table, $data)
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $columns = implode("`, `", $keys);
        $values = implode("', '", $values);
        $sql = "INSERT INTO `$table`(`$columns`) VALUES ('$values')";
        $result = $this->conn->query($sql);
        return $result ? true : false;
    }

    public function update($table, $data, $id)
    {
        $pairs = [];
        foreach ($data as $key => $value) {
            $pair = "`$key` = '$value'";
            array_push($pairs, $pair);
        }
        $pairs = implode(", ", $pairs);
        $sql = "UPDATE `$table` SET $pairs WHERE `id` = $id";
        $result = $this->conn->query($sql);
        return $result ? true : false;
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM `$table` WHERE `id` = $id";
        $result = $this->conn->query($sql);
        return $result ? true : false;
    }
}

$database = new Database();
