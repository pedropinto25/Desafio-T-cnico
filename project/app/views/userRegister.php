<?php
require_once '../controllers/UserController.php';
require_once "../../../vendor/autoload.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $controller = new \App\Controllers\UserController();
    $result = $controller->registerUser($name, $email, $password, $role);

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
    <link rel="stylesheet" href="../../public/css/stylesRegister.css">
</head>
<body>
    <div class="container">
        <h2>Registar Novo Utilizador</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="employee">Employee</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit">Registar</button>
        </form>
    </div>
</body>
</html>