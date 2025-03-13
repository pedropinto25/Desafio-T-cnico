<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }
    public function registerUser($name, $email, $password, $role) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Create a new user model instance
        $userModel = new UserModel();

        // Register the user
        return $userModel->createUser($name, $email, $hashedPassword, $role);
    }

    public function loginUser($email, $password) {
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Iniciar sessão e armazenar informações do usuário
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            return true;
        }

        return false;
    }

    public function editUser($id, $name, $email, $role) {
        // Create a new user model instance
        $userModel = new UserModel();

        // Edit the user
        return $userModel->updateUser($id, $name, $email, null, $role);
    }

    public function getUserById($id) {
        // Assuming you have a User model with a method to find a user by ID
        $userModel = new UserModel();
        return $userModel->getUserById($id);
    }
}
?>