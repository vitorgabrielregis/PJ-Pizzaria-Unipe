# PJ-Pizzaria-Unipe

🍕 Descrição do Projeto:
O projeto PJ-Pizzaria-Unipe consiste em um sistema de cardápio online para uma pizzaria, desenvolvido como parte de uma avaliação acadêmica. 
O objetivo principal é proporcionar uma experiência de usuário agradável e intuitiva, 
permitindo que os clientes naveguem por um menu dinâmico e realizem pedidos de forma eficiente.
Um diferencial do sistema é a integração com o WhatsApp, para onde são enviadas as notificações dos pedidos realizados.

👥 Integrantes da Equipe:
- Vitor Gabriel Oliveira Regis
- Davi Guedes Fragoso Vieira
- Vitor Jales Ramos Diniz
- Daniel Leite
- Erick Mauricio Soares Almeida

🚀 Descrição do Sistema:
Este projeto é uma aplicação web simples, desenvolvida em PHP (com MySQL) e JavaScript, que simula o menu e o carrinho de pedidos de uma pizzaria.
Ele inclui a listagem de pizzas, filtros por categoria, um construtor de pizza personalizado (Faça Você Mesmo) e o envio de pedidos via WhatsApp. 

 

Estrutura: 

O projeto é composto pelos seguintes arquivos principais: 

Config.php: Configuração e conexão com o banco de dados MySQL (projeto_pizzaria). 

 

Index.php: Página inicial. Inclui o topo.php e o cardapio.php. 

 

Cardapio.php: Puxa e exibe as pizzas do banco de dados, filtros de categoria e a interface de "Monte sua Pizza". 

 

get_pizzas.php: API simples que retorna a lista de pizzas cadastradas no banco em formato JSON. 

 

Login.php: Interface e lógica para autenticação de usuários e detecção de admin. 

 

Cadastrar.php: Interface e lógica para cadastro de novos usuários com hashing de senha (password_hash). 

 

Logout.php: Finaliza a sessão do usuário. 

 

Style.css: Estilos da aplicação, incluindo design responsivo, cards de pizza, carrinho lateral e o modal de personalização. 

 

Script.js: Toda a lógica de frontend: carregamento de pizzas, filtros, carrinho de pedidos, cálculo de preço da pizza personalizada, e envio do pedido via WhatsApp. 

 

Pasta Admin: 

Os arquivos dentro da pasta admin são responsáveis pela gestão do conteúdo do cardápio, permitindo que o administrador adicione, liste, edite e exclua pizzas. Todos estes arquivos iniciam com uma verificação de segurança para garantir que apenas usuários com a sessão $_SESSION["admin"] ativa possam acessá-los. 

 

 

pizzas_listar.php/Read: Lista todas as pizzas do banco em uma tabela. Ponto de entrada para as ações de CRUD. 

pizzas_adicionar.php/Create: Formulário e lógica para cadastrar uma nova pizza no banco de dados. 

pizzas_editar.php/Update: Formulário e lógica para modificar os dados de uma pizza existente. 

pizzas_excluir.php/Delete: Lógica para remover uma pizza do banco de dados com base no id. 

formulario_upload.php/Gerenciamento de Mídia: Página dedicada ao upload, substituição e exclusão de arquivos de imagem no diretório ../img/pizzas/. 

 

A aplicação possui um sistema básico de autenticação para clientes e administradores: 

    Login (login.php): O sistema verifica o usuário e a senha no banco de dados. 

    As senhas são armazenadas como hashes usando password_hash($senha, PASSWORD_BCRYPT) em cadastrar.php. 

    Se o campo tipo for igual a "admin", a variável de sessão $_SESSION["admin"] é definida. 

    Controle de Acesso (cardapio.php): Se $_SESSION["admin"] estiver definida, dois botões de gerenciamento são exibidos no topo do cardápio: "➕ Adicionar Pizza" e " Gerenciar Pizzas". 

PHP 

<?php if (isset($_SESSION["admin"])): ?> 
   <?php endif; ?> 
 

Lista de pizzas: 

A lista de pizzas é carregada de duas maneiras: 

    Renderização Inicial (PHP): Em cardapio.php, as pizzas são buscadas do banco de dados e renderizadas diretamente no HTML usando um foreach loop. Isso garante que o conteúdo inicial seja carregado rapidamente. 
     

    Lógica Frontend/JS: O arquivo script.js carrega todas as pizzas via AJAX usando get_pizzas.php. 

    A função loadPizzas() busca os dados. 

    A função renderPizzas(category) filtra e exibe os cards no frontend, baseada na categoria (p.ex., tradicional, vegana ou all). 

    Os botões de filtro (.filter) em cardapio.php chamam a função renderPizzas no script.js. 

 

Monte sua pizza: A funcionalidade de "Faça Você Mesmo" é implementada por meio de um Modal/Overlay (#janelaPizza em cardapio.php) e lógica em script.js. 

    atualizarPreco: Faz a função em JavaScript de calcular o preço final somando os valores de Tamanho + Massa + Borda (ou Recheio da Borda). 

    mostrarRecheio: O campo de seleção de recheio só é exibido se a opção "Recheada" for escolhida para a borda. 

    Limite de Ingredientes: O script limita o usuário a selecionar um máximo de 3 ingredientes via um event listener nos checkboxes. 

    enviarPizzaMontadaParaCarrinho: Cria um objeto especial (pizzaMontada) com o preço calculado e um campo detalhes contendo todas as customizações. Este objeto é adicionado ao carrinho pela função addToCart(). 

 

Carrinho e envio via whatsapp: 

    Controle do Carrinho (script.js): O carrinho é gerenciado como um array de objetos (cart). 

    addToCart(pizza): Adiciona um item (pizza pré-definida ou personalizada) ao array. 

    updateCart(): Recalcula o total e re-renderiza a lista de itens no painel lateral. Ele exibe os detalhes da pizza personalizada, se existirem. 

    toggleCart(): Mostra/esconde o painel lateral do carrinho. 

    Envio via WhatsApp (enviarPedido): 

    A função coleta o nome, endereço e itera sobre todos os itens no array cart. 

    Monta uma string de texto formatada (mensagem) com todos os detalhes e o total. 

    Gera um link para a API do WhatsApp (https://wa.me/...) e abre uma nova janela/aba para o envio.
