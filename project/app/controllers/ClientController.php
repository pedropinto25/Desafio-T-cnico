<?php
namespace App\Controllers;

use App\Models\ClientModel;

class ClientController {
    private $model;

    public function __construct() {
        $this->model = new ClientModel();
    }

    public function createClient($data) {
        $this->model->beginTransaction();
        try {
            if ($this->model->createClient($data)) {
                $client_id = $this->model->getLastInsertedId();
                $this->model->addClientPhones($client_id, $data['phones']);
                $this->model->addClientEmails($client_id, $data['emails']);
                $this->model->addClientAddresses($client_id, $data['addresses']);
                $this->model->addClientDecisionMakers($client_id, $data['decision_makers']);
                $this->model->commit();
                return $client_id; 
            } else {
                $this->model->rollBack();
                return false;
            }
        } catch (\Exception $e) {
            $this->model->rollBack();
            return false;
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

    public function getLastInsertedId() {
        return $this->model->getLastInsertedId();
    }

    public function getRandomClientId() {
        $clients = $this->model->getAllClients();
        if (count($clients) > 0) {
            $randomIndex = array_rand($clients);
            return $clients[$randomIndex]['id'];
        }
        return null;
    }
    public function searchClients($search, $searchBy) {
        return $this->model->searchClients($search, $searchBy);
    }

    public function editClient($id, $company_name, $nif, $cae_codes, $incorporation_year, $business_volume, $avg_monthly_revenue, $num_employees, $sells_products, $provides_services, $products, $services, $ideal_client_sector, $business_challenges) {
        return $this->model->editClient($id, $company_name, $nif, $cae_codes, $incorporation_year, $business_volume, $avg_monthly_revenue, $num_employees, $sells_products, $provides_services, $products, $services, $ideal_client_sector, $business_challenges);
    }
}
?>