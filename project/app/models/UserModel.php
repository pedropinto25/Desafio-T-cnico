<?php
namespace App\Models;

use Config\Database;

class UserModel {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createUser($name, $email, $password, $role) {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        
        // Atribuir o resultado de password_hash a uma variável
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $role);
        
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name, $email, $password, $role) {

        $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, role = :role WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);

        return $stmt->execute();
    }

    public function getAllUsers($search = '', $searchBy = 'name') {

        $query = "SELECT * FROM users";
        if ($search) {
            $query .= " WHERE $searchBy LIKE :search";
        }

        $stmt = $this->conn->prepare($query);
        if ($search) {
            $search = "%$search%";
            $stmt->bindParam(":search", $search);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>