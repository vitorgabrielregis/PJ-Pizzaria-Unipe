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
    const li = document.createElement("li");
    li.innerHTML = `${item.name} - R$ ${item.price.toFixed(2)} <button class="remove-btn" onclick="removeFromCart(${index})">x</button>`;
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
    mensagem += `🍕 ${item.name} - R$ ${item.price.toFixed(2)}%0A`;
  });

  const total = cart.reduce((sum, item) => sum + item.price, 0);
  mensagem += `%0ATotal: R$ ${total.toFixed(2)}`;

  const numero = "558339"; // <- seu número com DDI 
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