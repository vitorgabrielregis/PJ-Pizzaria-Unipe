<?php
require "../config.php";

$id = $_GET["id"];

$stmt = mysqli_prepare($conn, "SELECT * FROM pizzas WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pizza = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$pizza) {
    die("Pizza não encontrada.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $categoria = $_POST["categoria"];

    $stmt = mysqli_prepare($conn, "UPDATE pizzas SET nome=?, descricao=?, preco=?, categoria=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssdsi", $nome, $descricao, $preco, $categoria, $id);
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

    <form method="POST">
        Nome:<br>
        <input type="text" name="nome" value="<?= $pizza['nome'] ?>" required><br><br>

        Descrição:<br>
        <textarea name="descricao" required><?= $pizza['descricao'] ?></textarea><br><br>

        Preço:<br>
        <input type="number" step="0.01" name="preco" value="<?= $pizza['preco'] ?>" required><br><br>

        Categoria:<br>
        <select name="categoria">
            <option value="tradicional" <?= $pizza['categoria']=="tradicional"?"selected":"" ?>>Tradicional</option>
            <option value="especial" <?= $pizza['categoria']=="especial"?"selected":"" ?>>Especial</option>
            <option value="vegana" <?= $pizza['categoria']=="vegana"?"selected":"" ?>>Vegana</option>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
