<?php
session_start();
if ($_SESSION['user_role'] != 'employee' && $_SESSION['user_role'] != 'admin') {
    header("Location: /login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if (in_array($action, ['pausa_almoço', 'pausa_wc', 'pausa_emails'])) {
        $_SESSION['pause_type'] = $action;
        $_SESSION['paused_time'] = time();
        $message = "Pausa registrada: " . str_replace('_', ' ', $action) . "!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa</title>
    <link rel="stylesheet" href="../../public/css/stylesTask.css">
</head>
<body>
    <div class="container">
        <h2>Executando Tarefa</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <div id="task">60</div>
        <form action="" method="POST">
            <button type="submit" name="action" value="pausa_almoço">Pausa para Almoço</button>
            <button type="submit" name="action" value="pausa_wc">Pausa para WC</button>
            <button type="submit" name="action" value="pausa_emails">Pausa para E-mails</button>
        </form>
    </div>
    <script>
        let taskTime = 60;
        const taskElement = document.getElementById('task');
        let paused = false;

        const taskInterval = setInterval(() => {
            if (!paused) {
                taskTime--;
                taskElement.textContent = taskTime;
                if (taskTime === 0) {
                    clearInterval(taskInterval);
                    window.location.href = 'countdown.php';
                }
            }
        }, 1000);

        document.querySelectorAll('button[name="action"]').forEach(button => {
            button.addEventListener('click', () => {
                paused = true;
                clearInterval(taskInterval);
            });
        });
    </script>
</body>
</html>