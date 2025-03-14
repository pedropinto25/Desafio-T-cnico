<?php
session_start();
require_once '../controllers/WorkSessionController.php';
require_once '../controllers/UserController.php';
require_once '../models/WorkSessionModel.php';
require_once "../../../vendor/autoload.php";

$controller = new \App\Controllers\WorkSessionController();
$userController = new \App\Controllers\UserController();

$user_id = $_SESSION['user_id']; // ID do usuário logado
$user = $userController->getUserById($user_id);

$hoursWorked = null;
if (isset($_SESSION['start_time'])) {
    $start_time = $_SESSION['start_time'];
    $current_time = time();
    $secondsWorked = $current_time - $start_time;
    $hours = floor($secondsWorked / 3600);
    $minutes = floor(($secondsWorked % 3600) / 60);
    $seconds = $secondsWorked % 60;
    $hoursWorked = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'entrada':
            $_SESSION['start_time'] = time();
            $start_time = date('Y-m-d H:i:s', $_SESSION['start_time']);
            $controller->startWorkSession($user_id, $start_time);
            $message = "Entrada Registada!";
            break;

        case 'saida':
            $activeSession = $controller->getActiveWorkSession($user_id);
            if ($activeSession) {
                $end_time = date('Y-m-d H:i:s');
                $controller->endWorkSession($activeSession['id'], $end_time);
                unset($_SESSION['start_time']);
                $message = "Saída Registada!";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="user-info">
                <img src="<?php echo htmlspecialchars($user['image'] ?? '../../public/images/user-avatar.jpg'); ?>" alt="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" class="user-avatar">
                <div class="user-details">
                    <h2><?php echo htmlspecialchars($user['name'] ?? ''); ?></h2>
                    <p><?php echo htmlspecialchars($user['role'] ?? ''); ?></p>
                </div>
            </div>
            <h2>Registo de Entrada e Saída</h2>
            <button onclick="window.location.href='../../app/controllers/logout.php'" class="logout-button">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </header>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form action="" method="POST">
            <button type="submit" name="action" value="entrada"><i class="fas fa-sign-in-alt"></i> Registar Entrada</button>
            <button type="submit" name="action" value="saida"><i class="fas fa-sign-out-alt"></i> Registar Saída</button>
        </form>
        <?php if (isset($_SESSION['start_time'])): ?>
            <p>Horas trabalhadas: <span id="hours-worked"><?php echo $hoursWorked; ?></span></p>
            <div class="task-button-container">
                <button onclick="startCountdown()"><i class="fas fa-play"></i> Iniciar Tarefa</button>
            </div>
        <?php endif; ?>
    </div>
    <script>
        function startCountdown() {
            window.location.href = 'countdown.php';
        }

        function updateHoursWorked() {
            const startTime = <?php echo $_SESSION['start_time']; ?>;
            const currentTime = Math.floor(Date.now() / 1000);
            const secondsWorked = currentTime - startTime;
            const hours = Math.floor(secondsWorked / 3600);
            const minutes = Math.floor((secondsWorked % 3600) / 60);
            const seconds = secondsWorked % 60;
            const hoursWorked = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            document.getElementById('hours-worked').textContent = hoursWorked;
        }

        <?php if (isset($_SESSION['start_time'])): ?>
        setInterval(updateHoursWorked, 1000);
        <?php endif; ?>
    </script>
</body>
</html>