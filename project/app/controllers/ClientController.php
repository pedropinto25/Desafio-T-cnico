<?php
namespace App\Controllers;

use App\Models\ClientModel;

class ClientController {
    private $model;

    public function __construct() {
        $this->model = new ClientModel();
    }

    public function createClient($data) {
        if ($this->model->createClient($data)) {
            return "Client created successfully.";
        } else {
            return "Failed to create client.";
        }
    }

    public function getClientById($id) {
        return $this->model->getClientById($id);
    }

    public function getAllClients() {
        return $this->model->getAllClients();
    }

    public function getClientContacts($client_id) {
        return $this->model->getClientContacts($client_id);
    }

    public function getClientAddresses($client_id) {
        return $this->model->getClientAddresses($client_id);
    }

    public function getClientDecisionMakers($client_id) {
        return $this->model->getClientDecisionMakers($client_id);
    }

    public function getClientInteractions($client_id) {
        return $this->model->getClientInteractions($client_id);
    }

    public function saveCallResult($client_id, $status, $notes) {
        return $this->model->saveCallResult($client_id, $status, $notes);
    }

    public function getCallStatistics($client_id) {
        return $this->model->getCallStatistics($client_id);
    }
}
?>