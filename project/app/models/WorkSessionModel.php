<?php
namespace App\Models;

use Config\Database;

class WorkSessionModel {
    private $conn;
    private $table_name = "work_sessions";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createWorkSession($user_id, $start_time) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, start_time, status) VALUES (:user_id, :start_time, 'active')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":start_time", $start_time);
        return $stmt->execute();
    }

    public function endWorkSession($id, $end_time) {
        $query = "UPDATE " . $this->table_name . " SET end_time = :end_time, status = 'completed' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Outros métodos para interagir com a tabela work_sessions (get, update, delete, etc.)
}
?>