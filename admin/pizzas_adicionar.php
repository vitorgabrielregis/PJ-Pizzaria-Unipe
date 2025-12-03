<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $categoria = $_POST["categoria"];

    $imagem = null;

    // Se enviou imagem
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === 0) {
        $diretorio = "../img/pizzas/";
        $nome_original = pathinfo($_FILES["imagem"]["name"], PATHINFO_FILENAME);
        $nome_original = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nome_original);
        $ext = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));
        $novo_nome = $nome_original . "_" . time() . "." . $ext;

        move_uploaded_file($_FILES["imagem"]["tmp_name"], $diretorio . $novo_nome);
        $imagem = $novo_nome;
    }

    $stmt = mysqli_prepare($conn,
        "INSERT INTO pizzas (nome, descricao, preco, categoria, imagem)
         VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "ssdss", $nome, $descricao, $preco, $categoria, $imagem);
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

    <style>
        body { font-family: Arial; padding: 20px; }
        form { width: 350px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        input, textarea, select {
            width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 12px;
        }
        button {
            background: #d32f2f;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background: #b71c1c; }
    </style>
</head>
<body>

<h2>Adicionar Nova Pizza</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Descrição:</label>
    <textarea name="descricao" required></textarea>

    <label>Preço:</label>
    <input type="number" step="0.01" name="preco" required>

    <label>Categoria:</label>
    <select name="categoria" required>
        <option value="Tradicional">Tradicional</option>
        <option value="Especial">Especial</option>
        <option value="Premium">Premium</option>
    </select>

    <label>Imagem:</label>
    <input type="file" name="imagem" required>

    <button type="submit">Adicionar Pizza</button>
</form>

</body>
</html>
