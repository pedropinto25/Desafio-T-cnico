<?php
require_once '../controllers/UserController.php';
require_once "../../../vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $controller = new \App\Controllers\UserController();
    $result = $controller->loginUser($email, $password);

    if ($result) {
        session_start();
        $role = $_SESSION['user_role'];

        if ($role == 'admin') {
            header("Location: dashboardAdmin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $message = "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/stylesLogin.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>