<?php
require "../config.php";

$sql = "SELECT * FROM pizzas ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$pizzas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pizzas[] = $row;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Menu - Listar Pizzas</title>
</head>
<body>
    <h1>🍕 Listagem de Pizzas</h1>

<a href="../index.php" style="display:inline-block; padding:10px 15px; background:#0f0; color:#000; text-decoration:none; border-radius:5px; margin-bottom:20px;">
    ⬅️ Voltar para a Página Inicial
</a>

<a href="pizzas_adicionar.php">Adicionar Nova Pizza</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Imagem</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($pizzas as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>

        <!-- Miniatura da imagem -->
        <td>
            <?php if (!empty($p['imagem'])): ?>
                <img src="../img/pizzas/<?= $p['imagem'] ?>" width="80" style="border-radius:5px;">
            <?php else: ?>
                —
            <?php endif; ?>
        </td>

        <td><?= $p['nome'] ?></td>
        <td><?= $p['categoria'] ?></td>
        <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>

        <td>
            <a href="pizzas_editar.php?id=<?= $p['id'] ?>">Editar</a> |
            <a href="pizzas_excluir.php?id=<?= $p['id'] ?>" onclick="return confirm('Deseja excluir?')">🗑️ Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
