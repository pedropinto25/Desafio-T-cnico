<?php
session_start();
if ($_SESSION['user_role'] != 'admin') {
    header("Location: /login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../public/css/styleAdminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Bem-vindo ao Painel de Administração</h1>
            <button onclick="window.location.href='../../app/controllers/logout.php'" class="logout-button">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </header>
        <main>
            <div class="button-group">
                <button id="list-users" onclick="window.location.href='userList.php'">
                    <i class="fas fa-users"></i> Listar Utilizadores
                </button>
                <button id="add-users" onclick="window.location.href='userRegister.php'">
                    <i class="fas fa-user-plus"></i> Adicionar Utilizadores
                </button>
                <button id="list-clients" onclick="window.location.href='clientList.php'">
                    <i class="fas fa-building"></i> Listar Clientes
                </button>
                <button id="add-clients" onclick="window.location.href='addClient.php'">
                    <i class="fas fa-user-tie"></i> Adicionar Cliente
                </button>
                <button id="export-data" onclick="exportData()">
                    <i class="fas fa-file-export"></i> Exportar Dados
                </button>
                <button id="view-stats" onclick="viewStats()">
                    <i class="fas fa-chart-bar"></i> Ver Estatísticas
                </button>
            </div>
            <div id="export-result"></div>
            <div id="stats-container" style="display:none;">
                <canvas id="callHistoryChart"></canvas>
            </div>
        </main>
    </div>
    <script>
        function exportData() {
            window.location.href = '../../app/controllers/exportController.php';
        }

        function viewStats() {
            document.getElementById('stats-container').style.display = 'block';
            fetch('../../app/controllers/callHistory.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.status);
                    const counts = data.map(item => item.count);

                    const ctx = document.getElementById('callHistoryChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Número de Chamadas',
                                data: counts,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar dados:', error);
                });
        }
    </script>
</body>
</html>