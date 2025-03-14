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

    public function createClient($data) {
        $query = "INSERT INTO clients (nif, company_name, cae_codes, incorporation_year, business_volume, avg_monthly_revenue, num_employees, sells_products, provides_services, possible_consultant, products, services, ideal_client_sector, business_challenges) 
                  VALUES (:nif, :company_name, :cae_codes, :incorporation_year, :business_volume, :avg_monthly_revenue, :num_employees, :sells_products, :provides_services, :possible_consultant, :products, :services, :ideal_client_sector, :business_challenges)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
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
}

?>