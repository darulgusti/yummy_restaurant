let menu = document.querySelector('#menu-bars');
let navbar = document.querySelector('.navbar');

menu.onclick = () => {
  menu.classList.toggle('fa-times');
  navbar.classList.toggle('active');
};

window.onscroll = () => {
  menu.classList.remove('fa-times');
  navbar.classList.remove('active');
};

document.querySelector('#search-icon').onclick = () => {
  document.querySelector('#search-form').classList.toggle('active');
};
document.querySelector('#close').onclick = () => {
  document.querySelector('#search-form').classList.remove('active');
};

var swiper = new Swiper(".home-slider", {
  spaceBetween: 30,
  centeredSlides: true,
  autoplay: {
    delay: 7500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  loop:true,
});

// ===== KERANJANG =====
const cart = document.getElementById("cart");
const cartOverlay = document.getElementById("cart-overlay");
const cartBtn = document.querySelector(".fa-shopping-cart");
const closeCartBtn = document.getElementById("close-cart");
const cartItems = document.getElementById("cart-items");

// Buka dan Tutup Keranjang
function toggleCart() {
  cart.classList.toggle("active");
  cartOverlay.classList.toggle("active");
}

cartBtn.addEventListener("click", toggleCart);
closeCartBtn.addEventListener("click", toggleCart);
cartOverlay.addEventListener("click", toggleCart);

// Tambah ke keranjang saat tombol "tambahkan" diklik




// contact form
document.getElementById("contact-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Mencegah reload halaman

    let nama = document.getElementById("nama").value;
    let email = document.getElementById("email").value;
    let telepon = document.getElementById("telepon").value;
    let subjek = document.getElementById("subjek").value;
    let pesan = document.getElementById("pesan").value;

    let url = `https://wa.me/6281252502902?text=
    📝 *Pesan Baru dari Website Yummy Food*%0A
    ----------------------------%0A
    👤 Nama : ${nama}%0A
    📧 Email : ${email}%0A
    📱 Telepon : ${telepon}%0A
    ✉️ Subjek : ${subjek}%0A
    🗨️ Pesan : ${pesan}`;;

    window.open(url, "_blank");
  });


// Fungsi untuk menambahkan item ke keranjang
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const item = {
            id: this.getAttribute('data-id'),
            name: this.getAttribute('data-name'),
            price: parseInt(this.getAttribute('data-price')),
            image: this.getAttribute('data-image'),
            quantity: 1
        };

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingItem = cart.find(cartItem => cartItem.id === item.id);

        if (existingItem) {
            existingItem.quantity += 1; // Tambah jumlah jika item sudah ada
        } else {
            cart.push(item); // Tambah item baru
        }

        localStorage.setItem('cart', JSON.stringify(cart)); // Simpan keranjang ke localStorage
        updateCartDisplay(); // Perbarui tampilan keranjang
    });
});



// Fungsi untuk memperbarui tampilan keranjang
function updateCartDisplay() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let cartItemsContainer = document.getElementById("cart-items");
  let totalPrice = 0;
  let totalItems = 0;

  cartItemsContainer.innerHTML = ""; // Bersihkan isi keranjang sebelumnya

  if (cart.length === 0) {
    // Tambahkan kondisi jika keranjang kosong
    cartItemsContainer.innerHTML = "<p>Keranjang Anda kosong.</p>";
    document.getElementById("checkout-btn").style.display = "none"; // Sembunyikan tombol checkout
  } else {
    document.getElementById("checkout-btn").style.display = "block"; // Tampilkan tombol checkout jika ada item
    cart.forEach((item) => {
      let itemElement = document.createElement("li");
      itemElement.innerHTML = `
              <img src="img/${item.image}" alt="${item.name}" height="50px">
              <span>${item.name} - Rp${item.price.toLocaleString(
        "id-ID"
      )}</span>
              <button onclick="changeQuantity('${
                item.id
              }', 'increase')">+</button>
              <span>${item.quantity}</span>
              <button onclick="changeQuantity('${
                item.id
              }', 'decrease')">-</button>
              <button onclick="removeItem('${item.id}')">🗑️</button>
          `;
      cartItemsContainer.appendChild(itemElement);

      totalPrice += item.price * item.quantity;
      totalItems += item.quantity;
    });
  }

  document.getElementById("total-items").innerText = totalItems;
  document.getElementById("total-price").innerText = `Rp${totalPrice.toLocaleString("id-ID")}`; // Format harga
}

// Fungsi untuk mengubah jumlah item di keranjang
function changeQuantity(itemId, action) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const item = cart.find(cartItem => cartItem.id === itemId);

    if (action === 'increase') {
        item.quantity += 1;
    } else if (action === 'decrease' && item.quantity > 1) {
        item.quantity -= 1;
    }

    localStorage.setItem('cart', JSON.stringify(cart)); // Update keranjang di localStorage
    updateCartDisplay(); // Perbarui tampilan keranjang
}

// Fungsi untuk menghapus item dari keranjang
function removeItem(itemId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(cartItem => cartItem.id !== itemId); // Hapus item
    localStorage.setItem('cart', JSON.stringify(cart)); // Update keranjang di localStorage
    updateCartDisplay(); // Perbarui tampilan keranjang
}

// Fungsi untuk menampilkan keranjang saat halaman dimuat
window.onload = updateCartDisplay;

// Tambahkan event listener untuk tombol checkout
document.getElementById('checkout-btn').addEventListener('click', function() {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  if (cart.length === 0) {
      alert("Keranjang belanja Anda kosong!");
      return;
  }

  const whatsappNumber = '6282137632016'; 
  let message = "Halo Yummy Food, saya ingin memesan:\n\n";
  let totalHarga = 0;

  cart.forEach((item, index) => {
      message += `${index + 1}. ${item.name} (${item.quantity}x) - Rp${(item.price * item.quantity).toLocaleString('id-ID')}\n`;
      totalHarga += item.price * item.quantity;
  });

  message += `\nTotal Harga: Rp${totalHarga.toLocaleString('id-ID')}`;
  message += `\n\nMohon konfirmasi pesanan saya. Terima kasih!`;

  // Encode pesan untuk URL
  const encodedMessage = encodeURIComponent(message);
  const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

  window.open(whatsappUrl, '_blank');

  // Kosongkan keranjang setelah checkout (opsional, tergantung alur yang diinginkan)
  localStorage.removeItem('cart');
  updateCartDisplay(); // Perbarui tampilan keranjang setelah dikosongkan
  toggleCart(); // Tutup keranjang setelah checkout
});


// FUNGSI UNTUK ADMIN DASHBOARD (EDIT MENU)
function showEditForm(id, name, price, image) {
  document.getElementById("editMenuFormContainer").style.display = "block";
  document.getElementById("edit-id").value = id;
  document.getElementById("edit-name").value = name;
  document.getElementById("edit-price").value = price;
  document.getElementById("edit-old-image").value = image;
  document.getElementById("current-image-preview").src = "img/" + image;
}

function hideEditForm() {
  document.getElementById("editMenuFormContainer").style.display = "none";
  // Bersihkan juga nilai input jika perlu
  document.getElementById("edit-image").value = "";
}