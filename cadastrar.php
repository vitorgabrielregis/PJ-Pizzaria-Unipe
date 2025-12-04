<?php
require "config.php"; // conexão com o banco

include_once "topo.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = trim($_POST["usuario"]);
    $senha   = $_POST["senha"];

    // 1. VERIFICAR SE O USUÁRIO JÁ EXISTE
    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado->num_rows > 0) {
        $erro = "Este usuário já está cadastrado!";
    } else {

        // 2. GERAR HASH DA SENHA
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

        // 3. INSERIR NO BANCO
        $stmt = mysqli_prepare($conn, 
            "INSERT INTO usuarios (usuario, senha, tipo) VALUES (?, ?, 'cliente')"
        );
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $senhaHash);

        if (mysqli_stmt_execute($stmt)) {
            $sucesso = "Usuário cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar usuário.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
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
    <h2>Cadastro</h2>

    <?php if (isset($erro)): ?>
        <p style="color:red;"><?= $erro ?></p>
    <?php endif; ?>

    <?php if (isset($sucesso)): ?>
        <p style="color:green;"><?= $sucesso ?></p>
    <?php endif; ?>

    <form method="POST">
        Usuário:<br>
        <input type="text" name="usuario" required><br><br>

        Senha:<br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Cadastrar</button> <a href="login.php">Fazer login</a>
    </form>

    <br>
    
</body>
</html>
