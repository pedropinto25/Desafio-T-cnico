<?php
require_once '../../../vendor/autoload.php';

use Config\Database;

header('Content-Type: application/json');

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT status, COUNT(*) as count FROM call_history GROUP BY status";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>