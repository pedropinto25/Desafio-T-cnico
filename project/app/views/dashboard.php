<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'entrada') {
        $_SESSION['start_time'] = time();
        $message = "Entrada registrada!";
    } elseif ($action == 'saida') {
        unset($_SESSION['start_time']);
        $message = "Saída registrada!";
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