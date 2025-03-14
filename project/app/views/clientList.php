<?php
require_once '../controllers/ClientController.php';
require_once "../../../vendor/autoload.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchBy = isset($_GET['searchBy']) ? $_GET['searchBy'] : 'company_name';

$controller = new \App\Controllers\ClientController();
if ($search) {
    $clients = $controller->searchClients($search, $searchBy);
} else {
    $clients = $controller->getAllClients();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="../../public/css/stylesList.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Clientes</h2>
        <button onclick="window.location.href='dashboardAdmin.php'" class="back-button">
                <i class="fas fa-arrow-left"></i> Voltar à Dashboard
            </button>
        <form method="GET" action="">
            <div class="form-group">
                <label for="search">Pesquisar:</label>
                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <select id="searchBy" name="searchBy">
                    <option value="id" <?php echo $searchBy == 'id' ? 'selected' : ''; ?>>ID</option>
                    <option value="company_name" <?php echo $searchBy == 'company_name' ? 'selected' : ''; ?>>Nome da Empresa</option>
                    <option value="nif" <?php echo $searchBy == 'nif' ? 'selected' : ''; ?>>NIF</option>
                </select>
                <button type="submit">Pesquisar</button>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Empresa</th>
                    <th>NIF</th>
                    <th>Ver</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo $client['id']; ?></td>
                        <td><?php echo $client['company_name']; ?></td>
                        <td><?php echo $client['nif']; ?></td>
                        <td>
                            <a href="clientView.php?id=<?php echo $client['id']; ?>">Ver</a>
                        </td>
                        <td>
                            <a href="clientEdit.php?id=<?php echo $client['id']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>