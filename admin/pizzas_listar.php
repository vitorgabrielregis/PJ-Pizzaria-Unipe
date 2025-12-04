<?php
require "../config.php";

include_once "../topo.php";

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
    <style>
        body { font-family: Poppins, Arial, sans-serif; background: #f5f5f5}
        h1 { font-weight: 700; margin-bottom: 20px; }
        a { font-family: Poppins, Arial; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0px 3px 8px rgba(0,0,0,0.15);}
        table th { background: #c72828ff; color: white; padding: 12px; text-align: left; font-size: 16px; }
        table td { padding: 12px; font-size: 15px; border-bottom: 1px solid #ddd; }
        table tr:hover { background: #ffe8dc; transition: 0.2s; }
        table img { border-radius: 8px; display: block; }
        table a { color: #ff0000ff; font-weight: 600; text-decoration: none; }
        table a:hover { text-decoration: underline; }
</style>

</head>
<body class="tabela">



<table border="1" cellpadding="10">
    <h1 style="margin: 20px 20px;">🍕 Listagem de Pizzas</h1>
    <a href="../index.php" style="display:inline-block; padding:10px 15px; margin: 0 20px 0 20px; background:#333; color:#fff; text-decoration:none; border-radius:5px; margin-bottom:20px;">
        ⬅️ Voltar para a Página Inicial
    </a>
    <a href="pizzas_adicionar.php" style="display:inline-block; padding:10px 15px; background:#f33; color:#fff; text-decoration:none; border-radius:5px; margin-bottom:20px;">
        Adicionar Nova Pizza
    </a>
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
