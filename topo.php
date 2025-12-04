<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pyhrios Pizzaria</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../style.css">

</head>

<body>

<header class="header">

  <div class="header-modern">

      <!-- LOGO + NOME -->
      <div class="logo-area">
          <img src="https://instadelivery-public.nyc3.cdn.digitaloceanspaces.com/groups/1715602418664203f28e75f.jpeg" 
               class="logo-img">
          <span class="logo-text">Pyhrios Pizza</span>
      </div>

      <!-- MENU -->
      <nav class="nav-menu">

        <a href="index.php">Menu</a>
        <a href="https://wa.me/5583999586639">Contato</a>

        <?php
        if (!isset($_SESSION["usuario"])) {

            // Usuário não logado
            echo '<a href="login.php" class="botao">Entrar</a>';
            echo '<a href="cadastrar.php" class="botao">Criar Conta</a>';

        } else {
            echo '<a href="logout.php" class="botao">Sair</a>';
        }
        ?>
      </nav>

  </div> 

  <!-- FOTO DO PIZZAIOLO -->
  <div class="pizzaiolo-image-container">
      <img src="https://i.ibb.co/wX7F1Jy/pizzaiolo.jpg" class="pizzaiolo-icon" alt="Pizzaiolo">
  </div>

</header>

<section class="info-bar">
    <div class="container">
      <div><span>⏰ Aberto: 11:00 - 23:00</span></div>
      <div><span>📍 Entrega grátis na cidade</span></div>
    </div>
</section>
