document.addEventListener('DOMContentLoaded', function() {
    const startButton = document.getElementById('start-task');
    const countdown = document.getElementById('countdown');

    startButton.addEventListener('click', function() {
        let timeLeft = 10;
        countdown.innerHTML = timeLeft;

        const timer = setInterval(function() {
            timeLeft--;
            countdown.innerHTML = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timer);
                countdown.innerHTML = "Tarefa Iniciada!";
                // Iniciar ciclo de trabalho aqui
            }
        }, 1000);
    });
});