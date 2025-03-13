<?php
require_once '../controllers/UserController.php';
require_once "../../../vendor/autoload.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $controller = new \App\Controllers\UserController();
    $result = $controller->registerUser($name, $email, $password);

    if ($result) {
        $message = "Usuário registrado com sucesso!";
    } else {
        $message = "Erro ao registrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuário</title>
    <link rel="stylesheet" href="path/to/your/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Usuário</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </ <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>