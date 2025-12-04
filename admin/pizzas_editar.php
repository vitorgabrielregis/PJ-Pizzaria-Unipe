<?php
require "../config.php";

include_once "../topo.php";

$id = $_GET["id"];

// Buscar pizza
$stmt = mysqli_prepare($conn, "SELECT * FROM pizzas WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pizza = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$pizza) {
    die("Pizza não encontrada.");
}

$diretorio = "../img/pizzas/";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $categoria = $_POST["categoria"];
    $imagem = $pizza["imagem"]; // mantém a atual

    // Se enviou nova imagem
    if (isset($_FILES["nova_imagem"]) && $_FILES["nova_imagem"]["error"] === 0) {

        $nome_original = pathinfo($_FILES["nova_imagem"]["name"], PATHINFO_FILENAME);
        $nome_original = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nome_original);
        $ext = strtolower(pathinfo($_FILES["nova_imagem"]["name"], PATHINFO_EXTENSION));
        $novo_nome = $nome_original . "_" . time() . "." . $ext;

        move_uploaded_file($_FILES["nova_imagem"]["tmp_name"], $diretorio . $novo_nome);
        $imagem = $novo_nome;
    }

    // Atualizar no banco
    $stmt = mysqli_prepare($conn,
        "UPDATE pizzas SET nome=?, descricao=?, preco=?, categoria=?, imagem=? WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "ssdssi", $nome, $descricao, $preco, $categoria, $imagem, $id);
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
<title>Editar Pizza</title>
<style>
        body { font-family: Arial }
        h2 { margin: 20px }
        form { width: 45%; margin: 20px; padding: 40px 40px 40px 20px; border: 1px solid #ccc; border-radius: 8px; }
        select { width: 20%; padding: 10px; }
        input, textarea {
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

<h2>Editar Pizza</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?= $pizza['nome'] ?>"><br><br>

    <label>Descrição:</label>
    <textarea name="descricao"><?= $pizza['descricao'] ?></textarea><br><br>

    <label>Preço</label>
    <input type="number" step="0.01" name="preco" value="<?= $pizza['preco'] ?>"><br><br>

    <label>Categoria:</label>
    <input type="text" name="categoria" value="<?= $pizza['categoria'] ?>"><br><br>

    Imagem atual:<br>
    <img src="../img/pizzas/<?= $pizza['imagem'] ?>" width="120"><br><br>

    <label>Imagem nova:</label>
    <input type="file" name="nova_imagem"><br><br>

    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>
