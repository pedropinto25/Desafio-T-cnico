<?php
require_once '../controllers/ClientController.php';
require_once "../../../vendor/autoload.php";

if (isset($_GET['action']) && $_GET['action'] === 'getRandomClientId') {
    $clientController = new \App\Controllers\ClientController();
    $client_id = $clientController->getRandomClientId();
    header('Content-Type: application/json');
    echo json_encode(['client_id' => $client_id]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown</title>
    <link rel="stylesheet" href="../../public/css/styleCountdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Prepare-se para a Tarefa</h2>
        <div id="countdown">10</div>
        <div class="pause-buttons">
            <button id="pause-lunch"><i class="fas fa-utensils"></i> Pausa para Almoço</button>
            <button id="pause-wc"><i class="fas fa-toilet"></i> Pausa para WC</button>
            <button id="pause-email"><i class="fas fa-envelope"></i> Pausa para Email</button>
        </div>
    </div>
    <div id="pause-popup" class="popup">
        <div class="popup-content">
            <h3>Pausa Ativada</h3>
            <p id="pause-message"></p>
            <button id="resume-button"><i class="fas fa-play"></i> Voltar ao Trabalho</button>
            <button id="dashboard-button"><i class="fas fa-tachometer-alt"></i> Voltar ao Dashboard</button>
        </div>
    </div>
    <script>
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');
        let countdownInterval;

        function startCountdown() {
            countdownInterval = setInterval(async () => {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown === 0) {
                    clearInterval(countdownInterval);
                    const clientId = await getRandomClientId();
                    if (clientId) {
                        window.location.href = `clientDashboard.php?id=${clientId}`;
                    } else {
                        alert('Nenhum cliente encontrado.');
                    }
                }
            }, 1000);
        }

        function pauseCountdown() {
            clearInterval(countdownInterval);
            document.getElementById('pause-popup').style.display = 'flex';
        }

        function resumeCountdown() {
            document.getElementById('pause-popup').style.display = 'none';
            startCountdown();
        }

        async function getRandomClientId() {
            const response = await fetch('countdown.php?action=getRandomClientId');
            const data = await response.json();
            return data.client_id;
        }

        document.getElementById('pause-lunch').addEventListener('click', () => {
            pauseCountdown();
            document.getElementById('pause-message').textContent = 'Pausa para Almoço';
        });

        document.getElementById('pause-wc').addEventListener('click', () => {
            pauseCountdown();
            document.getElementById('pause-message').textContent = 'Pausa para WC';
        });

        document.getElementById('pause-email').addEventListener('click', () => {
            pauseCountdown();
            document.getElementById('pause-message').textContent = 'Pausa para Email';
        });

        document.getElementById('resume-button').addEventListener('click', resumeCountdown);

        document.getElementById('dashboard-button').addEventListener('click', () => {
            window.location.href = 'dashboard.php';
        });

        startCountdown();
    </script>
</body>
</html>