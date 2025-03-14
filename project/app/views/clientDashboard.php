<?php
session_start();
require_once '../controllers/ClientController.php';
require_once "../../../vendor/autoload.php";

$clientController = new \App\Controllers\ClientController();
$client_id = $_GET['id'] ?? null;
$client = null;

if ($client_id) {
    $client = $clientController->getClientById($client_id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $_POST['call_result'] ?? '';
    $observations = $_POST['observations'] ?? '';
    $clientController->saveCallResult($client_id, $result, $observations);
    // Redirecionar para evitar reenvio do formulário
    header("Location: clientDashboard.php?id=$client_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha do Cliente</title>
    <link rel="stylesheet" href="../../public/css/stylesClientDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function validateForm(event) {
            const observations = document.querySelector('textarea[name="observations"]').value.trim();
            const callResult = event.target.value;

            if ((callResult === 'Chamada Agendada' || callResult === 'Marcar Reunião') && observations === '') {
                event.preventDefault();
                alert('Por favor, preencha as observações antes de agendar uma chamada ou marcar uma reunião.');
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Ficha do Cliente</h1>
            <div class="user-info">
                <img src="../../public/images/user-avatar.jpg" alt="João Silva">
                <div>
                    <h2>João Silva</h2>
                    <p>WC | Almoço | E Mails | Pausa</p>
                </div>
            </div>
        </header>
        <main>
            <section class="client-info">
                <h2>Informações do Cliente</h2>
                <form>
                    <div class="form-group">
                        <label for="nif">NIF</label>
                        <input type="text" id="nif" name="nif" value="<?php echo htmlspecialchars($client['nif'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="company_name">Nome da Empresa</label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($client['company_name'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="caes">CAEs</label>
                        <input type="text" id="caes" name="caes" value="<?php echo htmlspecialchars($client['cae_codes'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="incorporation_year">Ano de Constituição</label>
                        <input type="text" id="incorporation_year" name="incorporation_year" value="<?php echo htmlspecialchars($client['incorporation_year'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="business_volume">Volume de Negócios</label>
                        <input type="text" id="business_volume" name="business_volume" value="<?php echo htmlspecialchars($client['business_volume'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="avg_monthly_revenue">Média Faturação Mensal</label>
                        <input type="text" id="avg_monthly_revenue" name="avg_monthly_revenue" value="<?php echo htmlspecialchars($client['avg_monthly_revenue'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="num_employees">Número de Funcionários</label>
                        <input type="text" id="num_employees" name="num_employees" value="<?php echo htmlspecialchars($client['num_employees'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group business-type-section">
                        <label for="business_type">Tipo de Negócio</label>
                        <div>
                            <input type="checkbox" id="sells_products" name="sells_products" <?php echo isset($client['sells_products']) && $client['sells_products'] ? 'checked' : ''; ?> disabled>
                            <label for="sells_products">Vende Produtos</label>
                            <input type="checkbox" id="provides_services" name="provides_services" <?php echo isset($client['provides_services']) && $client['provides_services'] ? 'checked' : ''; ?> disabled>
                            <label for="provides_services">Presta Serviços</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="products">Produtos</label>
                        <textarea id="products" name="products" readonly><?php echo htmlspecialchars($client['products'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="services">Serviços</label>
                        <textarea id="services" name="services" readonly><?php echo htmlspecialchars($client['services'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ideal_client_sector">Setor do Cliente Ideal</label>
                        <textarea id="ideal_client_sector" name="ideal_client_sector" readonly><?php echo htmlspecialchars($client['ideal_client_sector'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="business_challenges">Principais Desafios da Empresa</label>
                        <textarea id="business_challenges" name="business_challenges" readonly><?php echo htmlspecialchars($client['business_challenges'] ?? ''); ?></textarea>
                    </div>
                </form>
            </section>
            <section class="client-contacts">
                <h2>Contactos do Cliente</h2>
                <div class="contacts">
                    <div class="contact">
                        <h3>Telefones</h3>
                        <ul>
                            <?php if (isset($client['contacts'])): ?>
                                <?php foreach ($client['contacts'] as $contact): ?>
                                    <?php if ($contact['type'] == 'phone'): ?>
                                        <li><?php echo htmlspecialchars($contact['value']); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="contact">
                        <h3>Emails</h3>
                        <ul>
                            <?php if (isset($client['contacts'])): ?>
                                <?php foreach ($client['contacts'] as $contact): ?>
                                    <?php if ($contact['type'] == 'email'): ?>
                                        <li><?php echo htmlspecialchars($contact['value']); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="contact">
                        <h3>Moradas</h3>
                        <ul>
                            <?php if (isset($client['addresses'])): ?>
                                <?php foreach ($client['addresses'] as $address): ?>
                                    <li><?php echo htmlspecialchars($address['address']); ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="contact">
                        <h3>Decisores</h3>
                        <ul>
                            <?php if (isset($client['decision_makers'])): ?>
                                <?php foreach ($client['decision_makers'] as $decision_maker): ?>
                                    <li><?php echo htmlspecialchars($decision_maker['name']) . ' - ' . htmlspecialchars($decision_maker['position']); ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </section>
            <section class="call-result">
                <h2>Resultado da Chamada</h2>
                <form method="POST">
                    <textarea name="observations" placeholder="Observações..."></textarea>
                    <div class="buttons">
                        <button class="btn red" name="call_result" value="Não Atendido"><i class="fas fa-phone-slash"></i> Não Atendido</button>
                        <button class="btn yellow" name="call_result" value="Não Aderiu"><i class="fas fa-times-circle"></i> Não Aderiu</button>
                        <button class="btn blue" name="call_result" value="Chamada Agendada" onclick="validateForm(event)"><i class="fas fa-calendar-alt"></i> Agendar Chamada</button>
                        <button class="btn green" name="call_result" value="Marcar Reunião" onclick="validateForm(event)"><i class="fas fa-handshake"></i> Marcar Reunião</button>
                    </div>
                </form>
            </section>
            <section class="interaction-history">
                <h2>Histórico de Interações</h2>
                <ul>
                    <?php if (isset($client['interactions'])): ?>
                        <?php foreach ($client['interactions'] as $interaction): ?>
                            <li>
                                <span><?php echo date('d M Y, H:i', strtotime($interaction['call_time'])); ?></span>
                                <span><?php echo htmlspecialchars($interaction['status']); ?></span>
                                <p><?php echo htmlspecialchars($interaction['notes']); ?></p>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </section>
        </main>
    </div>
</body>
</html>