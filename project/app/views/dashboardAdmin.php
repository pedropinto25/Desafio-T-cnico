<?php
session_start();
if ($_SESSION['user_role'] != 'admin') {
    header("Location: /login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../public/css/stylesAdminDashboard.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Painel de Administração</h1>
        <button id="list-users" onclick="window.location.href='userList.php'">Listar Usuários</button>
    </div>
</body>
</html>