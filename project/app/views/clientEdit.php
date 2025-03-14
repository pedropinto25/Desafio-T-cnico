<?php
require_once '../controllers/ClientController.php';
require_once "../../../vendor/autoload.php";

$clientController = new \App\Controllers\ClientController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $company_name = $_POST['company_name'];
    $nif = $_POST['nif'];
    $cae_codes = $_POST['cae_codes'];
    $incorporation_year = $_POST['incorporation_year'];
    $business_volume = $_POST['business_volume'];
    $avg_monthly_revenue = $_POST['avg_monthly_revenue'];
    $num_employees = $_POST['num_employees'];
    $sells_products = isset($_POST['sells_products']) ? 1 : 0;
    $provides_services = isset($_POST['provides_services']) ? 1 : 0;
    $products = $_POST['products'];
    $services = $_POST['services'];
    $ideal_client_sector = $_POST['ideal_client_sector'];
    $business_challenges = $_POST['business_challenges'];

    $result = $clientController->editClient($id, $company_name, $nif, $cae_codes, $incorporation_year, $business_volume, $avg_monthly_revenue, $num_employees, $sells_products, $provides_services, $products, $services, $ideal_client_sector, $business_challenges);

    if ($result) {
        $message = "Cliente atualizado com sucesso!";
    } else {
        $message = "Erro ao atualizar cliente.";
    }
} else {
    $id = $_GET['id'];
    $client = $clientController->getClientById($id);

    if (!$client) {
        $message = "Cliente não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../../public/css/stylesClientEdit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Editar Cliente</h1>
            <button onclick="window.location.href='dashboardAdmin.php'" class="back-button">
                <i class="fas fa-arrow-left"></i> Voltar à Dashboard
            </button>
        </header>
        <main>
            <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
            <?php if (isset($client)): ?>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
                <div class="form-section">
                    <h2>Informações da Empresa</h2>
                    <div class="form-group">
                        <label for="company_name"><i class="fas fa-building"></i> Nome da Empresa</label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($client['company_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nif"><i class="fas fa-id-card"></i> NIF</label>
                        <input type="text" id="nif" name="nif" value="<?php echo htmlspecialchars($client['nif']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cae_codes"><i class="fas fa-code"></i> CAEs</label>
                        <input type="text" id="cae_codes" name="cae_codes" value="<?php echo htmlspecialchars($client['cae_codes']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="incorporation_year"><i class="fas fa-calendar-alt"></i> Ano de Constituição</label>
                        <input type="text" id="incorporation_year" name="incorporation_year" value="<?php echo htmlspecialchars($client['incorporation_year']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="business_volume"><i class="fas fa-chart-line"></i> Volume de Negócios</label>
                        <input type="text" id="business_volume" name="business_volume" value="<?php echo htmlspecialchars($client['business_volume']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="avg_monthly_revenue"><i class="fas fa-money-bill-wave"></i> Média Faturação Mensal</label>
                        <input type="text" id="avg_monthly_revenue" name="avg_monthly_revenue" value="<?php echo htmlspecialchars($client['avg_monthly_revenue']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="num_employees"><i class="fas fa-users"></i> Número de Funcionários</label>
                        <input type="text" id="num_employees" name="num_employees" value="<?php echo htmlspecialchars($client['num_employees']); ?>" required>
                    </div>
                </div>
                <div class="form-section">
                    <h2>Tipo de Negócio</h2>
                    <div class="form-group business-type-section">
                        <label for="business_type"><i class="fas fa-briefcase"></i> Tipo de Negócio</label>
                        <div>
                            <input type="checkbox" id="sells_products" name="sells_products" <?php echo isset($client['sells_products']) && $client['sells_products'] ? 'checked' : ''; ?>>
                            <label for="sells_products">Vende Produtos</label>
                            <input type="checkbox" id="provides_services" name="provides_services" <?php echo isset($client['provides_services']) && $client['provides_services'] ? 'checked' : ''; ?>>
                            <label for="provides_services">Presta Serviços</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="products"><i class="fas fa-box"></i> Produtos</label>
                        <textarea id="products" name="products" required><?php echo htmlspecialchars($client['products']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="services"><i class="fas fa-concierge-bell"></i> Serviços</label>
                        <textarea id="services" name="services" required><?php echo htmlspecialchars($client['services']); ?></textarea>
                    </div>
                </div>
                <div class="form-section">
                    <h2>Informações Adicionais</h2>
                    <div class="form-group">
                        <label for="ideal_client_sector"><i class="fas fa-industry"></i> Setor do Cliente Ideal</label>
                        <textarea id="ideal_client_sector" name="ideal_client_sector" required><?php echo htmlspecialchars($client['ideal_client_sector']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="business_challenges"><i class="fas fa-tasks"></i> Principais Desafios da Empresa</label>
                        <textarea id="business_challenges" name="business_challenges" required><?php echo htmlspecialchars($client['business_challenges']); ?></textarea>
                    </div>
                </div>
                <button type="submit"><i class="fas fa-save"></i> Atualizar Cliente</button>
            </form>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>