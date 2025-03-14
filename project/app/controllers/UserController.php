<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }
    public function registerUser($name, $email, $password, $role, $imageBase64 = null) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        return $this->model->createUser($name, $email, $hashedPassword, $role, $imageBase64);
    }

    public function loginUser($email, $password) {
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Iniciar sessão e armazenar informações do utilizador
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            return true;
        }

        return false;
    }

    public function editUser($id, $name, $email, $role) {
        $userModel = new UserModel();

      
        return $userModel->updateUser($id, $name, $email, null, $role);
    }

    public function getUserById($id) {
        
        $userModel = new UserModel();
        return $userModel->getUserById($id);
    }
}
?>