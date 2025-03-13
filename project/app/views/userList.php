<?php
require_once '../controllers/UserController.php';
require_once "../../../vendor/autoload.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchBy = isset($_GET['searchBy']) ? $_GET['searchBy'] : 'name';

$controller = new \App\Controllers\UserController();
$userModel = new \App\Models\UserModel();
$users = $userModel->getAllUsers($search, $searchBy);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="../../public/css/stylesList.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Utilizadores</h2>
        <form method="GET" action="">
            <div class="form-group">
                <label for="search">Pesquisar:</label>
                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <select id="searchBy" name="searchBy">
                    <option value="id" <?php echo $searchBy == 'id' ? 'selected' : ''; ?>>ID</option>
                    <option value="name" <?php echo $searchBy == 'name' ? 'selected' : ''; ?>>Nome</option>
                    <option value="email" <?php echo $searchBy == 'email' ? 'selected' : ''; ?>>Email</option>
                </select>
                <button type="submit">Pesquisar</button>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="editUser.php?id=<?php echo $user['id']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>