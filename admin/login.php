<?php
require_once '../api/config.php';
session_start();

if (isset($_POST['login'])) {
    if ($_POST['username'] === ADMIN_USER && $_POST['password'] === ADMIN_PASS) {
        $_SESSION['pz_logged'] = true;
        header("Location: index.php");
        exit;
    }
    else {
        $error = "Usuário ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Painel MySQL Clínica Pizane</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F8F5F2; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 20px 40px rgba(133, 31, 51, 0.1); width: 100%; max-width: 400px; text-align: center; border-top: 5px solid #851F33; }
        h1 { font-family: 'Cinzel', serif; color: #851F33; font-size: 24px; margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 20px; }
        label { display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6B5E62; margin-bottom: 8px; }
        input { width: 100%; padding: 12px; border: 1px solid #E0DADB; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 14px; background: #851F33; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        button:hover { background: #631424; }
        .error { color: #e74c3c; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>PIZANE ADMIN (MySQL)</h1>
        <?php if (isset($error))
    echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">Acessar Painel</button>
        </form>
    </div>
</body>
</html>
