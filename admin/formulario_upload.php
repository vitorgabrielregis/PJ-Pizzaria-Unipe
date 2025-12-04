<?php

include_once "../topo.php";

session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    exit("Acesso negado!");
}

$diretorio = "../img/pizzas/"
$mensagem = "";

// UPLOAD DE NOVA IMAGEM
if (isset($_POST['upload']) && isset($_FILES['imagem'])) {
    $arquivo = $_FILES['imagem']['name'];
    $caminho_tmp = $_FILES['imagem']['tmp_name'];
    $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));

    if (!in_array($extensao, ['jpg','jpeg','png','gif'])) {
        $mensagem = "Tipo de arquivo não permitido!";
    } else {
        if (move_uploaded_file($caminho_tmp, $diretorio . $arquivo)) {
            $mensagem = "Imagem enviada com sucesso!";
        } else {
            $mensagem = "Falha ao enviar a imagem.";
        }
    }
}

// DELETAR IMAGEM
if (isset($_GET['delete'])) {
    $arquivo = basename($_GET['delete']);
    if (file_exists($diretorio . $arquivo)) {
        unlink($diretorio . $arquivo);
        $mensagem = "Imagem deletada com sucesso!";
    }
}

// SUBSTITUIR IMAGEM
if (isset($_POST['substituir']) && isset($_FILES['nova_imagem']) && isset($_POST['antiga'])) {
    $antiga = basename($_POST['antiga']);
    $arquivo = $_FILES['nova_imagem']['name'];
    $caminho_tmp = $_FILES['nova_imagem']['tmp_name'];
    $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));

    if (!in_array($extensao, ['jpg','jpeg','png','gif'])) {
        $mensagem = "Tipo de arquivo não permitido!";
    } else {
        // Deleta a antiga e salva a nova com o mesmo nome
        unlink($diretorio . $antiga);
        if (move_uploaded_file($caminho_tmp, $diretorio . $arquivo)) {
            $mensagem = "Imagem substituída com sucesso!";
        } else {
            $mensagem = "Falha ao substituir a imagem.";
        }
    }
}

// LISTA DE IMAGENS
$imagens = glob($diretorio . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Imagens</title>
    <style>
        .botao { padding:5px 10px; background:#4CAF50; color:white; border-radius:4px; text-decoration:none; margin:2px;}
        img { margin:5px; border:1px solid #ccc; }
    </style>
</head>
<body>

<h1>Upload de Imagens</h1>

<?php if ($mensagem) echo "<p>$mensagem</p>"; ?>

<!-- FORMULÁRIO DE UPLOAD -->
<form action="" method="POST" enctype="multipart/form-data">
    Selecione nova imagem:
    <input type="file" name="imagem" required>
    <button type="submit" name="upload">Enviar</button>
</form>

<h2>Imagens existentes</h2>
<div>
    <?php foreach ($imagens as $img): 
        $nome = basename($img); ?>
        <div style="display:inline-block;text-align:center;">
            <img src="<?= $img ?>" width="120"><br>
            
            <!-- Formulário de substituição -->
            <form action="" method="POST" enctype="multipart/form-data" style="margin-top:5px;">
                <input type="file" name="nova_imagem" required>
                <input type="hidden" name="antiga" value="<?= $nome ?>">
                <button type="submit" name="substituir" class="botao">Substituir</button>
            </form>

            <!-- Link de deletar -->
            <a href="?delete=<?= $nome ?>" class="botao" style="background:red;">Deletar</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
