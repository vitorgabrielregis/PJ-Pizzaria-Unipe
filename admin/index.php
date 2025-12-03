<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
</head>
<body>

<body>

<div class="admin-container">
<?php
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true):
?>
    <h1 class="titulo-admin">Painel Administrativo</h1>

    <div class="btn-group">
        <a class="btn-red" href="pizzas_listar.php">Gerenciar Pizzas</a>
        <a class="btn-gray" href="logout.php">Sair</a>
    </div>

<?php elseif (isset($_SESSION["usuario"])): ?>
    
    <h1 class="titulo-admin">Bem-vindo, <?= htmlspecialchars($_SESSION["usuario"]) ?>!</h1>

    <div class="btn-group">
        <a class="btn-gray" href="logout.php">Sair</a>
    </div>

<?php else: ?>
    
    <h1 class="titulo-admin">Bem-vindo ao Site!</h1>

    <div class="btn-group">
        <a class="btn-red" href="login.php">Entrar</a>
        <a class="btn-white" href="cadastrar.php">Cadastrar</a>
    </div>

<?php endif; ?>
</div>

</body>


</body>
</html>
