<?php
require "config.php"; // conexão com o banco

// Busca todas as pizzas
$result = mysqli_query($conn, "SELECT * FROM pizzas ORDER BY id DESC");
$pizzas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pizzas[] = $row;
}
?>


<!-- SE NÃO estiver logado → mostra botão LOGIN -->
<?php if (!isset($_SESSION["admin"])): ?>
    <div style="background:#111; padding:10px; text-align:right;">
        <a href="admin/login.php" style="color:#0f0; font-size:16px; margin-right:20px;">🔐 Login</a>
    </div>
<?php endif; ?>

<!-- SE estiver logado → mostra botões de ADMIN -->
<?php if (isset($_SESSION["admin"])): ?>
    <div style="background:#222; padding:10px; text-align:center;">
        <a href="admin/pizzas_adicionar.php" style="color:#0f0; margin-right:15px;">➕ Adicionar Pizza</a>
        <a href="admin/pizzas_listar.php" style="color:#0f0; margin-right:15px;">📋 Gerenciar Pizzas</a>
        <a href="admin/logout.php" style="color:#f66;">🚪 Sair</a>
    </div>
<?php endif; ?>


<main class="container">
    <!-- Filtros-->
    <div class="barra">
        <div class="filters">
            <button class="filter active" data-category="all">Todas</button>
            <button class="filter" data-category="tradicional">Tradicional</button>
            <button class="filter" data-category="especial">Especial</button>
            <button class="filter" data-category="vegana">Vegana</button>
        </div>
        <button onclick="document.getElementById('janelaPizza').style.display='flex'" class="facavocemesmo">Faça você mesmo</button>
    </div>

    <div class="overlay" id="janelaPizza">
        <div class="janela">

            <div class="topo_janela">
                <h2>Monte sua Pizza</h2>
                <button class="fechar" onclick="cancelar()">X</button>
            </div>

            <form>
                <!-- TAMANHO -->
                <label>Tamanho:</label><br>
                <select id="tamanho" onchange="atualizarPreco()">
                    <option value="0">Selecione</option>
                    <option value="20">Pequena - R$ 20</option>
                    <option value="25">Média - R$ 25</option>
                    <option value="30">Grande - R$ 30</option>
                </select>
                <br><br>

                <!-- MASSA -->
                <label>Massa:</label><br>
                <select id="massa" onchange="atualizarPreco()">
                    <option value="0">Selecione</option>
                    <option value="6">Tradicional - R$ 6</option>
                    <option value="4">Fina - R$ 4</option>
                    <option value="5">Pan - R$ 5</option>
                </select>
                <br><br>

                <!-- INGREDIENTES -->
                <label>Ingredientes (máx. 3):</label><br>
                <div id="ingredientes_container">
                    <label><input type="checkbox" name="ing" value="queijo"> Queijo</label><br>
                    <label><input type="checkbox" name="ing" value="calabresa"> Calabresa</label><br>
                    <label><input type="checkbox" name="ing" value="bacon"> Bacon</label><br>
                    <label><input type="checkbox" name="ing" value="frango"> Frango</label><br>
                    <label><input type="checkbox" name="ing" value="tomate"> Tomate</label><br>
                    <label><input type="checkbox" name="ing" value="cebola"> Cebola</label><br>
                    <label><input type="checkbox" name="ing" value="azeitona"> Azeitona</label><br>
                    <label><input type="checkbox" name="ing" value="catupiry"> Catupiry</label><br>
                </div>
                <br>

                <!-- BORDA -->
                <label>Borda:</label><br>
                <select id="borda" onchange="mostrarRecheio()">
                    <option value="0">Nenhuma</option>
                    <option value="2">Simples</option>
                    <option value="recheada">Recheada</option>
                </select>
                <br><br>

                <!-- RECHEIO DA BORDA -->
                <div id="recheioDiv" style="display:none;">
                    <label>Recheio da Borda:</label><br>
                    <select id="recheio_borda" onchange="atualizarPreco()">
                        <option value="4">Catupiry - R$ 4</option>
                        <option value="3">Cheddar - R$ 3</option>
                    </select>
                    <br><br>
                </div>

                <h3>Preço Final: R$ <span id="preco_final">0.00</span></h3>

                <button type="button" onclick="enviarPizzaMontadaParaCarrinho()">Adicionar</button>

            </form>
        </div>
</div>

    <!-- Lista das Pizzas-->
    <div id="pizza-list" class="pizza-list">
    <?php foreach($pizzas as $p): ?>
        <div class="pizza-card" data-category="<?= $p['categoria'] ?>">
            <img src="img/pizzas/<?= $pizza['imagem'] ?>">
         alt="<?= htmlspecialchars($p['nome']) ?>" width="150">
            <h3><?= htmlspecialchars($p['nome']) ?></h3>
            <p><?= htmlspecialchars($p['descricao']) ?></p>
            <p>R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
        </div>
    <?php endforeach; ?>
</div>

    <!-- Carrinho -->
    <div id="cart" class="cart hidden">
      <h3>Carrinho</h3>
      <ul id="cart-items"></ul>
      <p id="cart-total">Total: R$ 0,00</p>

      <div class="form">
        <input type="text" id="nome" placeholder="Seu nome" required>
        <input type="text" id="endereco" placeholder="Endereço de entrega" required>
      </div>

      <button onclick="enviarPedido()" class="whatsapp-order">Enviar pedido via WhatsApp</button>
      <button onclick="toggleCart()" class="close-cart">Fechar</button>
    </div>

    <!-- Botão flutuante do carrinho-->
    <button class="floating-cart" onclick="toggleCart()">🛒</button>
</main>

<!-- Notificação-->
<div id="toast" class="toast hidden">Pizza adicionada ao carrinho! 🍕</div>

<script src="script.js"></script>
