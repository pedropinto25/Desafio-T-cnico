<?php
session_start();
require_once '../controllers/WorkSessionController.php';
require_once '../models/WorkSessionModel.php';
require_once "../../../vendor/autoload.php";

$controller = new \App\Controllers\WorkSessionController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $user_id = $_SESSION['user_id']; // ID do usuário logado

    switch ($action) {
        case 'entrada':
            $_SESSION['start_time'] = time();
            $start_time = date('Y-m-d H:i:s', $_SESSION['start_time']);
            $controller->startWorkSession($user_id, $start_time);
            $message = "Entrada registrada!";
            break;

        case 'saida':
            $activeSession = $controller->getActiveWorkSession($user_id);
            if ($activeSession) {
                $end_time = date('Y-m-d H:i:s');
                $controller->endWorkSession($activeSession['id'], $end_time);
                //unset($_SESSION['start_time']);
                $message = "Saída registrada!";
            } else {
                $message = "Nenhuma sessão ativa encontrada!";
            }
            break;

        default:
            $message = "Ação desconhecida!";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Entrada e Saída</title>
    <link rel="stylesheet" href="../../public/css/stylesDashboard.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Entrada e Saída</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="" method="POST">
            <button type="submit" name="action" value="entrada">Registrar Entrada</button>
            <button type="submit" name="action" value="saida">Registrar Saída</button>
        </form>
        <?php if (isset($_SESSION['start_time'])): ?>
            <button onclick="startCountdown()">Iniciar Tarefa</button>
        <?php endif; ?>
    </div>
    <script>
        function startCountdown() {
            window.location.href = 'countdown.php';
        }
    </script>
</body>
</html>