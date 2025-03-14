<?php
require_once '../controllers/UserController.php';
require_once "../../../vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Processar a imagem
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $imageBase64 = 'data:' . mime_content_type($_FILES['image']['tmp_name']) . ';base64,' . base64_encode($image);
    } else {
        $imageBase64 = null;
    }

    $controller = new \App\Controllers\UserController();
    $result = $controller->registerUser($name, $email, $password, $role, $imageBase64);

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
    <title>Registar Utilizador</title>
    <link rel="stylesheet" href="../../public/css/styleRegister.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Registar Novo Utilizador</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
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
            <div class="form-group">
                <label for="image">Imagem:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="button-group">
                <button type="submit" class="submit-button">Registar</button>
                <button type="button" onclick="window.location.href='dashboardAdmin.php'" class="back-button">
                    <i class="fas fa-arrow-left"></i> Voltar à Dashboard
                </button>
            </div>
        </form>
    </div>
</body>
</html>