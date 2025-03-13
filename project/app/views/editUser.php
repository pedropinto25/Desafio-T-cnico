<?php
require_once '../controllers/UserController.php';
require_once "../../../vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $controller = new \App\Controllers\UserController();
    $result = $controller->editUser($id, $name, $email, $role);

    if ($result) {
        $message = "Usuário atualizado com sucesso!";
    } else {
        $message = "Erro ao atualizar usuário.";
    }
} else {
    $id = $_GET['id'];
    $controller = new \App\Controllers\UserController();
    $user = $controller->getUserById($id);

    if (!$user) {
        $message = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../../public/css/stylesEdit.css">
</head>
<body>
    <div class="container">
        <h2>Editar Utilizador</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <?php if (isset($user)): ?>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="employee" <?php echo $user['role'] == 'employee' ? 'selected' : ''; ?>>Employee</option>
                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <button type="submit">Atualizar</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>