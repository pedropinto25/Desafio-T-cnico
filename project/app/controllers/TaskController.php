<?php
namespace App\Controllers;

use App\Models\TaskModel;

class TaskController {
    private $model;

    public function __construct() {
        $this->model = new TaskModel();
    }

    public function createTask($user_id, $task_description, $start_time) {
        return $this->model->createTask($user_id, $task_description, $start_time);
    }

    public function updateTaskStatus($id, $status) {
        return $this->model->updateTaskStatus($id, $status);
    }

    // Outros métodos para gerenciar tarefas (get, update, delete, etc.)
}
?>