<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $categoria = $_POST["categoria"];

    $stmt = mysqli_prepare($conn, "INSERT INTO pizzas (nome, descricao, preco, categoria) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssds", $nome, $descricao, $preco, $categoria);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: pizzas_listar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Pizza</title>
</head>
<body>
    <h1>Adicionar Pizza</h1>

    <form method="POST">
        Nome:<br>
        <input type="text" name="nome" required><br><br>

        Descrição:<br>
        <textarea name="descricao" required></textarea><br><br>

        Preço:<br>
        <input type="number" step="0.01" name="preco" required><br><br>

        Categoria:<br>
        <select name="categoria">
            <option value="tradicional">Tradicional</option>
            <option value="especial">Especial</option>
            <option value="vegana">Vegana</option>
        </select><br><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
