<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown</title>
    <link rel="stylesheet" href="../../public/css/stylesCountdown.css">
</head>
<body>
    <div class="container">
        <h2>Preparando para a Tarefa</h2>
        <div id="countdown">10</div>
    </div>
    <script>
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown === 0) {
                clearInterval(countdownInterval);
                window.location.href = 'task.php';
            }
        }, 1000);
    </script>
</body>
</html>