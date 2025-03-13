<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function registerUser($name, $email, $password) {
        return $this->model->createUser($name, $email, $password);
    }

    public function loginUser($email, $password) {
        $user = $this->model->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            // Iniciar sessão do utilizador
            return true;
        }
        return false;
    }

    // Outros métodos para gerir utilizadores (update, delete, etc.)
}
?>