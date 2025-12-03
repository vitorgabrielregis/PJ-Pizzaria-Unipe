<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pyhrios Pizzaria</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
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
    <a href="#menu">Menu</a>
    <a href="#contact">Contato</a>
    <span class="phone">📞 (83) 99958-6639</span>

    <?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        // Usuário não logado
        echo '<a href="login.php" class="botao">Entrar</a>';
        echo '<a href="cadastrar.php" class="botao">Criar Conta</a>';
    } elseif (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        // Admin logado
        echo '<a href="index.php" class="botao">Painel Admin</a>';
        echo '<a href="logout.php" class="botao">Sair</a>';
    } else {
        // Usuário normal logado
        echo '<a href="logout.php" class="botao">Sair</a>';
    }
    ?>
</nav>

  </div> 

  <!-- FOTO DO PIZZAIOLO -->
  <div class="pizzaiolo-image-container">
      <img src="imagens/pizzaiolo.jpg" class="pizzaiolo-icon" alt="Pizzaiolo">
  </div>

</header>


  <section class="info-bar">
    <div class="container">
      <div><span>⏰ Aberto: 11:00 - 23:00</span></div>
      <div><span>📍 Entrega grátis na cidade</span></div>
    </div>
  </section>
