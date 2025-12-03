<?php
session_start();
require "../config.php"; // conexão com o banco

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    // BUSCAR USUÁRIO NO BANCO DE DADOS
    $stmt = mysqli_prepare($conn, "SELECT id, usuario, senha, tipo FROM usuarios WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado->num_rows === 1) {

        $dados = $resultado->fetch_assoc();

        // VERIFICA A SENHA
        if (password_verify($senha, $dados["senha"])) {

            // SALVA DADOS NA SESSÃO
            $_SESSION["id"]    = $dados["id"];
            $_SESSION["usuario"] = $dados["usuario"];

            // SE FOR ADMIN, ATIVA O MODO ADMIN
            if ($dados["tipo"] === "admin") {
                $_SESSION["admin"] = true;
            }

            header("Location: ../index.php");
            exit;

        } else {
            $erro = "Senha incorreta!";
        }

    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($erro)): ?>
        <p style="color:red;"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        Usuário:<br>
        <input type="text" name="usuario" required><br><br>

        Senha:<br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
