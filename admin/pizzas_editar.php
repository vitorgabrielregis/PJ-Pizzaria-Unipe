<?php
require "../config.php";

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
</head>
<body>

<h1>Editar Pizza</h1>

<form method="POST" enctype="multipart/form-data">
    Nome:<br>
    <input type="text" name="nome" value="<?= $pizza['nome'] ?>"><br><br>

    Descrição:<br>
    <textarea name="descricao"><?= $pizza['descricao'] ?></textarea><br><br>

    Preço:<br>
    <input type="number" step="0.01" name="preco" value="<?= $pizza['preco'] ?>"><br><br>

    Categoria:<br>
    <input type="text" name="categoria" value="<?= $pizza['categoria'] ?>"><br><br>

    Imagem atual:<br>
    <img src="../img/pizzas/<?= $pizza['imagem'] ?>" width="120"><br><br>

    Nova imagem (opcional):<br>
    <input type="file" name="nova_imagem"><br><br>

    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>
