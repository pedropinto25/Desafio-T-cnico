<?php
namespace App\Models;

use PDO;
use Config\Database;

class ClientModel {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function beginTransaction() {
        $this->conn->beginTransaction();
    }

    public function commit() {
        $this->conn->commit();
    }

    public function rollBack() {
        $this->conn->rollBack();
    }

    public function createClient($data) {
        $query = "INSERT INTO clients (nif, company_name, cae_codes, incorporation_year, business_volume, avg_monthly_revenue, num_employees, sells_products, provides_services, products, services, ideal_client_sector, business_challenges) 
                  VALUES (:nif, :company_name, :cae_codes, :incorporation_year, :business_volume, :avg_monthly_revenue, :num_employees, :sells_products, :provides_services, :products, :services, :ideal_client_sector, :business_challenges)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nif', $data['nif']);
        $stmt->bindParam(':company_name', $data['company_name']);
        $stmt->bindParam(':cae_codes', $data['cae_codes']);
        $stmt->bindParam(':incorporation_year', $data['incorporation_year']);
        $stmt->bindParam(':business_volume', $data['business_volume']);
        $stmt->bindParam(':avg_monthly_revenue', $data['avg_monthly_revenue']);
        $stmt->bindParam(':num_employees', $data['num_employees']);
        $stmt->bindParam(':sells_products', $data['sells_products']);
        $stmt->bindParam(':provides_services', $data['provides_services']);
        $stmt->bindParam(':products', $data['products']);
        $stmt->bindParam(':services', $data['services']);
        $stmt->bindParam(':ideal_client_sector', $data['ideal_client_sector']);
        $stmt->bindParam(':business_challenges', $data['business_challenges']);
        return $stmt->execute();
    }

    public function addClientPhones($client_id, $phones) {
        $query = "INSERT INTO client_contacts (client_id, type, value) VALUES (:client_id, 'phone', :value)";
        $stmt = $this->conn->prepare($query);
        foreach (explode(',', $phones) as $phone) {
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':value', $phone);
            $stmt->execute();
        }
    }

    public function addClientEmails($client_id, $emails) {
        $query = "INSERT INTO client_contacts (client_id, type, value) VALUES (:client_id, 'email', :value)";
        $stmt = $this->conn->prepare($query);
        foreach (explode(',', $emails) as $email) {
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':value', $email);
            $stmt->execute();
        }
    }

    public function addClientAddresses($client_id, $addresses) {
        $query = "INSERT INTO client_addresses (client_id, address) VALUES (:client_id, :address)";
        $stmt = $this->conn->prepare($query);
        foreach (explode(',', $addresses) as $address) {
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':address', $address);
            $stmt->execute();
        }
    }

    public function addClientDecisionMakers($client_id, $decision_makers) {
        $query = "INSERT INTO client_decision_makers (client_id, name, position) VALUES (:client_id, :name, :position)";
        $stmt = $this->conn->prepare($query);
        foreach (explode(',', $decision_makers) as $decision_maker) {
            list($name, $position) = explode(':', $decision_maker);
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':position', $position);
            $stmt->execute();
        }
    }

    public function getClientById($id) {
        $query = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($client) {
            $client['contacts'] = $this->getClientContacts($id);
            $client['addresses'] = $this->getClientAddresses($id);
            $client['decision_makers'] = $this->getClientDecisionMakers($id);
            $client['interactions'] = $this->getClientInteractions($id);
        }
        return $client;
    }

    public function getAllClients() {
        $query = "SELECT * FROM clients";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientContacts($client_id) {
        $query = "SELECT * FROM client_contacts WHERE client_id = :client_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientAddresses($client_id) {
        $query = "SELECT * FROM client_addresses WHERE client_id = :client_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientDecisionMakers($client_id) {
        $query = "SELECT * FROM client_decision_makers WHERE client_id = :client_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientInteractions($client_id) {
        $query = "SELECT * FROM call_history WHERE client_id = :client_id ORDER BY call_time DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveCallResult($client_id, $status, $notes) {
        $query = "INSERT INTO call_history (client_id, call_time, status, notes) VALUES (:client_id, NOW(), :status, :notes)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':notes', $notes);
        return $stmt->execute();
    }

    public function getCallStatistics($client_id) {
        $query = "SELECT 
                    COUNT(*) AS total_calls, 
                    SUM(CASE WHEN status != 'Não Atendeu' THEN 1 ELSE 0 END) AS attended_calls 
                  FROM call_history 
                  WHERE client_id = :client_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLastInsertedId() {
        return $this->conn->lastInsertId();
    }

    public function searchClients($search, $searchBy) {
        $query = "SELECT * FROM clients WHERE $searchBy LIKE :search";
        $stmt = $this->conn->prepare($query);
        $search = "%$search%";
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editClient($id, $company_name, $nif, $cae_codes, $incorporation_year, $business_volume, $avg_monthly_revenue, $num_employees, $sells_products, $provides_services, $products, $services, $ideal_client_sector, $business_challenges) {
        $query = "UPDATE clients SET company_name = :company_name, nif = :nif, cae_codes = :cae_codes, incorporation_year = :incorporation_year, business_volume = :business_volume, avg_monthly_revenue = :avg_monthly_revenue, num_employees = :num_employees, sells_products = :sells_products, provides_services = :provides_services, products = :products, services = :services, ideal_client_sector = :ideal_client_sector, business_challenges = :business_challenges WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':nif', $nif);
        $stmt->bindParam(':cae_codes', $cae_codes);
        $stmt->bindParam(':incorporation_year', $incorporation_year);
        $stmt->bindParam(':business_volume', $business_volume);
        $stmt->bindParam(':avg_monthly_revenue', $avg_monthly_revenue);
        $stmt->bindParam(':num_employees', $num_employees);
        $stmt->bindParam(':sells_products', $sells_products);
        $stmt->bindParam(':provides_services', $provides_services);
        $stmt->bindParam(':products', $products);
        $stmt->bindParam(':services', $services);
        $stmt->bindParam(':ideal_client_sector', $ideal_client_sector);
        $stmt->bindParam(':business_challenges', $business_challenges);
        return $stmt->execute();
    }
}
?>