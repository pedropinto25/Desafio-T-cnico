<?php
session_start();
require_once '../controllers/ClientController.php';
require_once "../../../vendor/autoload.php";

$clientController = new \App\Controllers\ClientController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nif' => $_POST['nif'] ?? '',
        'company_name' => $_POST['company_name'] ?? '',
        'cae_codes' => $_POST['cae_codes'] ?? '',
        'incorporation_year' => $_POST['incorporation_year'] ?? '',
        'business_volume' => $_POST['business_volume'] ?? '',
        'avg_monthly_revenue' => $_POST['avg_monthly_revenue'] ?? '',
        'num_employees' => $_POST['num_employees'] ?? '',
        'sells_products' => isset($_POST['sells_products']) ? 1 : 0,
        'provides_services' => isset($_POST['provides_services']) ? 1 : 0,
        'products' => $_POST['products'] ?? '',
        'services' => $_POST['services'] ?? '',
        'ideal_client_sector' => $_POST['ideal_client_sector'] ?? '',
        'business_challenges' => $_POST['business_challenges'] ?? '',
        'phones' => $_POST['phones'] ?? [],
        'emails' => $_POST['emails'] ?? [],
        'addresses' => $_POST['addresses'] ?? [],
        'decision_makers' => $_POST['decision_makers'] ?? []
    ];

    $client_id = $clientController->createClient($data);
    if ($client_id) {
        header("Location: clientView.php?id=" . $client_id);
        exit;
    } else {
        $error = "Failed to create client.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cliente</title>
    <link rel="stylesheet" href="../../public/css/stylesAddClient.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function validateForm() {
            const nif = document.getElementById('nif').value;
            const phones = document.getElementById('phones').value;
            const emails = document.getElementById('emails').value;
            const phonePattern = /^(\d{9},?\s*)+$/;
            const emailPattern = /^([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,},?\s*)+$/;

            if (!phonePattern.test(phones)) {
                alert('Os telefones devem conter 9 dígitos e serem separados por vírgulas.');
                return false;
            }

            if (!emailPattern.test(emails)) {
                alert('Os emails devem ser válidos e separados por vírgulas.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Adicionar Cliente</h1>
            <button onclick="window.location.href='dashboardAdmin.php'" class="back-button">
                <i class="fas fa-arrow-left"></i> Voltar à Dashboard
            </button>
        </header>
        <main>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="POST" onsubmit="return validateForm()">
                <div class="form-section">
                    <h2>Informações da Empresa</h2>
                    <div class="form-group">
                        <label for="nif"><i class="fas fa-id-card"></i> NIF</label>
                        <input type="text" id="nif" name="nif" pattern="\d{9}" title="O NIF deve conter 9 dígitos." required>
                    </div>
                    <div class="form-group">
                        <label for="company_name"><i class="fas fa-building"></i> Nome da Empresa</label>
                        <input type="text" id="company_name" name="company_name" required>
                    </div>
                    <div class="form-group">
                        <label for="cae_codes"><i class="fas fa-code"></i> CAEs</label>
                        <input type="text" id="cae_codes" name="cae_codes" required>
                    </div>
                    <div class="form-group">
                        <label for="incorporation_year"><i class="fas fa-calendar-alt"></i> Ano de Constituição</label>
                        <input type="text" id="incorporation_year" name="incorporation_year" pattern="\d{4}" title="O ano de constituição deve conter 4 dígitos." required>
                    </div>
                    <div class="form-group">
                        <label for="business_volume"><i class="fas fa-chart-line"></i> Volume de Negócios</label>
                        <input type="text" id="business_volume" name="business_volume" required>
                    </div>
                    <div class="form-group">
                        <label for="avg_monthly_revenue"><i class="fas fa-money-bill-wave"></i> Média Faturação Mensal</label>
                        <input type="text" id="avg_monthly_revenue" name="avg_monthly_revenue" required>
                    </div>
                    <div class="form-group">
                        <label for="num_employees"><i class="fas fa-users"></i> Número de Funcionários</label>
                        <input type="text" id="num_employees" name="num_employees" pattern="\d+" title="O número de funcionários deve conter apenas dígitos." required>
                    </div>
                </div>
                <div class="form-section">
                    <h2>Tipo de Negócio</h2>
                    <div class="form-group business-type-section">
                        <label for="business_type"><i class="fas fa-briefcase"></i> Tipo de Negócio</label>
                        <div>
                            <input type="checkbox" id="sells_products" name="sells_products">
                            <label for="sells_products">Vende Produtos</label>
                            <input type="checkbox" id="provides_services" name="provides_services">
                            <label for="provides_services">Presta Serviços</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="products"><i class="fas fa-box"></i> Produtos</label>
                        <textarea id="products" name="products"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="services"><i class="fas fa-concierge-bell"></i> Serviços</label>
                        <textarea id="services" name="services"></textarea>
                    </div>
                </div>
                <div class="form-section">
                    <h2>Informações Adicionais</h2>
                    <div class="form-group">
                        <label for="ideal_client_sector"><i class="fas fa-industry"></i> Setor do Cliente Ideal</label>
                        <textarea id="ideal_client_sector" name="ideal_client_sector"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="business_challenges"><i class="fas fa-tasks"></i> Principais Desafios da Empresa</label>
                        <textarea id="business_challenges" name="business_challenges"></textarea>
                    </div>
                </div>
                <div class="form-section">
                    <h2>Contactos</h2>
                    <div class="form-group">
                        <label for="phones"><i class="fas fa-phone"></i> Telefones</label>
                        <textarea id="phones" name="phones" pattern="(\d{9},?\s*)+" title="Os telefones devem conter 9 dígitos e serem separados por vírgulas." placeholder="Formato: telefone, telefone..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="emails"><i class="fas fa-envelope"></i> Emails</label>
                        <textarea id="emails" name="emails" pattern="([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,},?\s*)+" title="Os emails devem ser válidos e separados por vírgulas." placeholder="Formato: email, email..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="addresses"><i class="fas fa-map-marker-alt"></i> Moradas</label>
                        <textarea id="addresses" name="addresses" placeholder="Formato: morada, morada..."></textarea>
                    </div>
                </div>
                <div class="form-section">
                    <h2>Decisores</h2>
                    <div class="form-group">
                        <label for="decision_makers"><i class="fas fa-user-tie"></i> Decisores</label>
                        <textarea id="decision_makers" name="decision_makers" placeholder="Formato: posição:nome, posição:nome..."></textarea>
                    </div>
                </div>
                <button type="submit"><i class="fas fa-plus"></i> Adicionar Cliente</button>
            </form>
        </main>
    </div>
</body>
</html>