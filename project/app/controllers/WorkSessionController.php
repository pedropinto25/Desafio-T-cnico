<?php
namespace App\Controllers;

use App\Models\WorkSessionModel;

class WorkSessionController {
    private $model;

    public function __construct() {
        $this->model = new WorkSessionModel();
    }

    public function startWorkSession($user_id, $start_time) {
        return $this->model->createWorkSession($user_id, $start_time);
    }

    public function endWorkSession($id, $end_time) {
        return $this->model->completeWorkSession($id, $end_time);
    }

    public function getActiveWorkSession($user_id) {
        return $this->model->getActiveWorkSession($user_id);
    }

    public function getWorkSessionsByUser($user_id) {
        return $this->model->getWorkSessionsByUser($user_id);
    }
}