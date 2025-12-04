<?php

include_once "topo.php";

require "config.php"; // conexão com o banco

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

            header("Location: index.php");
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
    <style>
        body { font-family: Arial }
        h2 { margin: 20px }
        form { width: 45%; margin: 20px; padding: 40px 40px 40px 20px; border: 1px solid #ccc; border-radius: 8px; }
        input{
            width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 12px; resize: vertical;
        }
        button {
            background: #d32f2f;
            color: white;
            padding: 10px;
            border: none;
            width: 20%;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background: #b71c1c; }
    </style>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($erro)): ?>
        <p style="color:red;"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        Usuário:<br>
        <input type="text" name="usuario" required><br><br>

        Senha:<br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button> <a href="cadastrar.php">Fazer cadastro</a>
    </form>
</body>
</html>
