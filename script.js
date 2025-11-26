const menuToggle = document.getElementById('menu-toggle');
const nav = document.getElementById('nav');

menuToggle.addEventListener('click', () => {
  nav.style.display = nav.style.display === 'block' ? 'none' : 'block';
});

const pizzas = [
  { name: "Margherita", category: "tradicional", price: 32, img: "https://instadelivery-public.nyc3.cdn.digitaloceanspaces.com/groups/1715602418664203f28e75f.jpeg" },
  { name: "Pepperoni", category: "tradicional", price: 36, img: "https://blog.duogourmet.com.br/wp-content/uploads/2019/07/41-Duo-Gourmet-pizza.jpg" },
  { name: "Vegana Supreme", category: "vegana", price: 39, img: "https://blog.novasafra.com.br/wp-content/uploads/2019/09/receitas-de-pizza-vegana-3-1280x720.jpg" },
  { name: "Calabresa Especial", category: "especial", price: 42, img: "https://blog.duogourmet.com.br/wp-content/uploads/2019/07/41-Duo-Gourmet-pizza.jpg" }
];

const list = document.getElementById('pizza-list');
const cart = [];
const cartItems = document.getElementById('cart-items');
const cartTotal = document.getElementById('cart-total');

function renderPizzas(category = 'all') {
  list.innerHTML = "";
  pizzas.filter(p => category === 'all' || p.category === category)
    .forEach(pizza => {
      const card = document.createElement("div");
      card.className = "pizza-card";
      card.innerHTML = `
        <img src="${pizza.img}" alt="${pizza.name}">
        <div class="details">
          <h4>${pizza.name}</h4>
          <p>R$ ${pizza.price.toFixed(2)}</p>
          <button onclick='addToCart(${JSON.stringify(pizza)})'>Adicionar</button>
        </div>`;
      list.appendChild(card);
    });
}

document.querySelectorAll(".filter").forEach(btn => {
  btn.addEventListener("click", () => {
    document.querySelectorAll(".filter").forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
    renderPizzas(btn.dataset.category);
  });
});

function addToCart(pizza) {
  cart.push(pizza);
  updateCart();
  showToast(`🍕 ${pizza.name} adicionada ao carrinho!`);
}

function removeFromCart(index) {
  cart.splice(index, 1);
  updateCart();
}

function updateCart() {
  cartItems.innerHTML = "";
  let total = 0;

  cart.forEach((item, index) => {
    total += item.price;

    // Montar texto dos detalhes caso existam
    let detalhesTxt = "";
    if (item.detalhes) {
      detalhesTxt = `
        <br>
        <small>
        ${item.detalhes.tamanho ? "Tamanho: " + item.detalhes.tamanho : ""}
        ${item.detalhes.massa ? " | Massa: " + item.detalhes.massa : ""}
        ${item.detalhes.borda ? " | Borda: " + item.detalhes.borda : ""}
        ${item.detalhes.recheio ? " | Recheio: " + item.detalhes.recheio : ""}
        ${item.detalhes.ingredientes?.length ? " | Ing: " + item.detalhes.ingredientes.join(", ") : ""}
        </small>
      `;
    }

    const li = document.createElement("li");
    li.innerHTML = `
      ${item.name} - R$ ${item.price.toFixed(2)}
      <button class="remove-btn" onclick="removeFromCart(${index})">x</button>
      ${detalhesTxt}
    `;
    cartItems.appendChild(li);
  });

  cartTotal.textContent = `Total: R$ ${total.toFixed(2)}`;
}


function toggleCart() {
  document.getElementById("cart").classList.toggle("hidden");
}

function enviarPedido() {
  const nome = document.getElementById("nome").value.trim();
  const endereco = document.getElementById("endereco").value.trim();

  if (!nome || !endereco) {
    alert("Por favor, preencha seu nome e endereço.");
    return;
  }

  if (cart.length === 0) {
    alert("Seu carrinho está vazio.");
    return;
  }

  let mensagem = `Olá! Gostaria de fazer um pedido:%0A`;
  mensagem += `👤 Nome: ${nome}%0A📍 Endereço: ${endereco}%0A%0A`;

  cart.forEach((item) => {
    mensagem += `🍕 ${item.name} - R$ ${item.price.toFixed(2)}`;

    // se tiver detalhes, enviar também
    if (item.detalhes) {
      mensagem += `%0A  • ${item.detalhes.tamanho}`;
      mensagem += ` | ${item.detalhes.massa}`;
      mensagem += ` | ${item.detalhes.borda}`;
      if (item.detalhes.recheio) mensagem += ` | ${item.detalhes.recheio}`;
      if (item.detalhes.ingredientes?.length)
        mensagem += ` | Ing: ${item.detalhes.ingredientes.join(", ")}`;
    }

    mensagem += `%0A%0A`;
  });

  const total = cart.reduce((sum, item) => sum + item.price, 0);
  mensagem += `Total: R$ ${total.toFixed(2)}`;

  const numero = "558339"; 
  const link = `https://wa.me/${numero}?text=${mensagem}`;

  window.open(link, "_blank");
}

// Função para mostrar a notificação (toast)
function showToast(message = "Pizza adicionada ao carrinho!") {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.remove("hidden");
  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => toast.classList.add("hidden"), 300);
  }, 2000);
}

renderPizzas();

// FECHAR JANELA
function cancelar() {
    document.getElementById("janelaPizza").style.display = "none";
}

// MOSTRAR RECHEIO DA BORDA
function mostrarRecheio() {
    const borda = document.getElementById("borda").value;
    const div = document.getElementById("recheioDiv");

    if (borda === "recheada") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }

    atualizarPreco();
}

// LIMITAR INGREDIENTES (3)
document.querySelectorAll('input[name="ing"]').forEach(chk => {
    chk.addEventListener("change", () => {
        let marcados = document.querySelectorAll('input[name="ing"]:checked');

        if (marcados.length > 3) {
            chk.checked = false;
            alert("Máximo de 3 ingredientes.");
        }
    });
});

// CALCULAR PREÇO FINAL
function atualizarPreco() {
    let tamanho = Number(document.getElementById("tamanho").value);
    let massa = Number(document.getElementById("massa").value);
    let borda = document.getElementById("borda").value;
    let recheioBorda = Number(document.getElementById("recheio_borda").value);

    let total = 0;

    // SOMAR TAMANHO
    total += tamanho;

    // SOMAR MASSA
    total += massa;

    // SOMAR BORDA
    if (borda !== "recheada") {
        total += Number(borda); // 0 ou 1
    } else {
        // SOMAR RECHEIO DA BORDA
        total += recheioBorda;
    }

    // ATUALIZAR TELA
    document.getElementById("preco_final").innerText = total.toFixed(2);
}

function enviarPizzaMontadaParaCarrinho() {

    const tamanhoSelect = document.getElementById("tamanho");
    const massaSelect = document.getElementById("massa");
    const bordaSelect = document.getElementById("borda");
    const recheioSelect = document.getElementById("recheio_borda");

    const tamanhoTxt = tamanhoSelect.options[tamanhoSelect.selectedIndex].text;
    const massaTxt = massaSelect.options[massaSelect.selectedIndex].text;
    const bordaTxt = bordaSelect.options[bordaSelect.selectedIndex].text;

    const preco = Number(document.getElementById("preco_final").innerText);

    const ingredientes = Array.from(document.querySelectorAll('input[name="ing"]:checked'))
        .map(i => i.value);

    let recheioTxt = "";
    if (bordaSelect.value === "recheada") {
        recheioTxt = recheioSelect.options[recheioSelect.selectedIndex].text;
    }

    const pizzaMontada = {
        name: `Pizza Personalizada (${tamanhoTxt})`,
        price: preco,
        img: "https://cdn-icons-png.flaticon.com/512/3595/3595455.png",
        category: "custom",
        detalhes: {
            tamanho: tamanhoTxt,
            massa: massaTxt,
            borda: bordaTxt,
            recheio: recheioTxt,
            ingredientes: ingredientes
        }
    };

    addToCart(pizzaMontada);
    cancelar();
}
