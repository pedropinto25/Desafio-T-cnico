<?php
namespace App\Models;

use Config\Database;

class TaskModel {
    private $conn;
    private $table_name = "tasks";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createTask($user_id, $task_description, $start_time) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, task_description, start_time, status) VALUES (:user_id, :task_description, :start_time, 'pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":task_description", $task_description);
        $stmt->bindParam(":start_time", $start_time);
        return $stmt->execute();
    }

    public function updateTaskStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Outros métodos para interagir com a tabela tasks (get, update, delete, etc.)
}
?>