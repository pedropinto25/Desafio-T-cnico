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
        // Verificar se já existe uma sessão ativa
        $existingSession = $this->getActiveWorkSession($user_id);
        if ($existingSession) {
            return false; // Já existe uma sessão ativa, não cria uma nova
        }
    
        $query = "INSERT INTO " . $this->table_name . " (user_id, start_time, status) VALUES (:user_id, :start_time, 'active')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":start_time", $start_time);
        return $stmt->execute();
    }
    

    public function completeWorkSession($id, $end_time) {
        // Verificar se a sessão realmente existe
        $queryCheck = "SELECT * FROM " . $this->table_name . " WHERE id = :id AND status = 'active'";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->bindParam(":id", $id);
        $stmtCheck->execute();
        $session = $stmtCheck->fetch(\PDO::FETCH_ASSOC);
    
        if (!$session) {
            return false; // Nenhuma sessão ativa encontrada, não faz nada
        }
    
        $query = "UPDATE " . $this->table_name . " SET end_time = :end_time, status = 'completed' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":end_time", $end_time);
        return $stmt->execute();
    }
    
    public function getActiveWorkSession($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id AND status = 'active' LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getWorkSessionsByUser($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}