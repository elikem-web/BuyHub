<?php require_once 'backend/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BuyHub — Your Cart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--black:#000;--gold:#c8922a;--gold-light:#e7b94f;--cream:#f3ece1;--muted:#997a3a;--card-bg:#0d0d0d;--border:#2a1f0a;--display:'Playfair Display',serif;--body:'Jost',sans-serif}
    html{scroll-behavior:smooth}
    body{background:var(--black);color:var(--gold);font-family:var(--body);font-size:16px;line-height:1.7}
    a{color:var(--gold);text-decoration:none}
    h1,h2,h3{font-family:var(--display);font-weight:600}
    p{color:var(--muted)}
    nav{display:flex;align-items:center;justify-content:space-between;padding:1rem 4%;border-bottom:1px solid var(--border);position:sticky;top:0;background:var(--black);z-index:100}
    .nav-links{display:flex;gap:2rem;list-style:none}
    .nav-links a{font-size:.78rem;letter-spacing:2px;text-transform:uppercase;color:var(--gold);transition:color .2s}
    .nav-links a:hover,.nav-links a.active{color:var(--gold-light);border-bottom:1px solid var(--gold-light)}
    .nav-icons{display:flex;gap:1.2rem;font-size:1rem;align-items:center}
    .nav-icons a{color:var(--gold);transition:color .2s;position:relative}
    .nav-icons a:hover{color:var(--gold-light)}
    .nav-user{font-size:.8rem;color:var(--gold-light);font-family:var(--display)}
    .cart-badge{position:absolute;top:-7px;right:-9px;background:var(--gold);color:var(--black);font-size:.55rem;font-weight:700;width:16px;height:16px;border-radius:50%;display:none;align-items:center;justify-content:center}
    .logo-bar{text-align:center;padding:2rem 4% 0}
    .logo-bar img{width:600px;height:110px;object-fit:contain;display:block;margin:0 auto}
    .dash-line{height:1px;width:100%;background:repeating-linear-gradient(to right,var(--gold) 0,var(--gold) 8px,transparent 8px,transparent 20px);opacity:.3;margin:2rem 0}
    .page-title{text-align:center;padding:2rem 4% 0}
    .breadcrumb{font-size:.72rem;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-bottom:.7rem}
    .breadcrumb a{color:var(--muted);transition:color .2s}
    .breadcrumb a:hover{color:var(--gold)}
    .page-title h1{font-style:italic;font-size:clamp(1.8rem,3.5vw,2.5rem)}
    .cart-wrap{max-width:1100px;margin:0 auto;padding:2rem 4% 5rem;display:grid;grid-template-columns:1fr 340px;gap:3rem;align-items:start}
    .col-head{font-size:.7rem;text-transform:uppercase;letter-spacing:2px;color:var(--muted);padding-bottom:.7rem;border-bottom:1px solid var(--border)}
    .cart-item{padding:1.6rem 0;border-bottom:1px solid var(--border);animation:fadeIn .3s ease}
    @keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
    .item-top{display:grid;grid-template-columns:90px 1fr auto;gap:1.2rem;align-items:start}
    .item-img{width:90px;height:90px;object-fit:cover;border:1px solid var(--border);display:block}
    .item-img-ph{width:90px;height:90px;background:var(--card-bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--muted)}
    .item-info h3{font-family:var(--display);font-size:1rem;color:var(--cream);margin-bottom:.2rem;line-height:1.3}
    .item-vendor{font-size:.75rem;color:var(--muted);margin-bottom:.3rem}
    .item-vendor i{color:var(--gold);font-size:.65rem}
    .item-unit{font-size:.85rem;color:var(--gold)}
    .item-right{display:flex;flex-direction:column;gap:.5rem;align-items:flex-end}
    .item-subtotal{font-family:var(--display);font-size:1.15rem;color:var(--gold)}
    .qty-box{display:flex;align-items:center;border:1px solid var(--border)}
    .qty-btn{width:32px;height:32px;line-height:32px;text-align:center;font-size:1rem;color:var(--gold);background:var(--card-bg);border:none;cursor:pointer;transition:background .2s;font-family:var(--body)}
    .qty-btn:hover{background:var(--gold);color:var(--black)}
    .qty-val{width:38px;height:32px;line-height:32px;text-align:center;font-size:.9rem;color:var(--cream);background:#0a0a0a;border-left:1px solid var(--border);border-right:1px solid var(--border)}
    .remove-btn{font-size:.68rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);cursor:pointer;border:none;background:none;font-family:var(--body);transition:color .2s;padding:0;display:flex;align-items:center;gap:.3rem}
    .remove-btn:hover{color:#e74c3c}
    .vendor-contact{margin-top:.9rem;background:#070707;border:1px solid var(--border);padding:.85rem 1rem;display:flex;flex-wrap:wrap;gap:.6rem;align-items:center}
    .vc-sold{font-size:.62rem;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-right:.3rem}
    .vc-name{font-family:var(--display);font-size:.88rem;color:var(--gold);margin-right:.8rem}
    .vc-link{display:inline-flex;align-items:center;gap:.35rem;font-size:.72rem;color:var(--muted);border:1px solid var(--border);padding:.28rem .65rem;transition:color .2s,border-color .2s;white-space:nowrap}
    .vc-link:hover{color:var(--gold);border-color:var(--gold)}
    .vc-link.wa:hover{color:#25d366;border-color:#25d366}
    .summary-box{background:var(--card-bg);border:1px solid var(--border);padding:2rem;position:sticky;top:90px}
    .summary-box h2{font-family:var(--display);font-size:1.2rem;letter-spacing:1px;margin-bottom:1.4rem;color:var(--gold)}
    .s-row{display:flex;justify-content:space-between;padding:.55rem 0;border-bottom:1px solid var(--border);font-size:.9rem;color:var(--muted)}
    .s-row span:last-child{color:var(--cream)}
    .s-total{display:flex;justify-content:space-between;padding:.9rem 0 0;margin-top:.3rem}
    .s-total span:first-child{font-family:var(--display);font-size:1.05rem;color:var(--cream)}
    .s-total span:last-child{font-family:var(--display);font-size:1.3rem;color:var(--gold)}
    .checkout-note{margin-top:1.2rem;background:#070707;border:1px solid var(--border);padding:.85rem 1rem;font-size:.78rem;color:var(--muted);line-height:1.65}
    .checkout-note i{color:var(--gold);margin-right:.3rem}
    .continue{display:block;text-align:center;margin-top:1.2rem;font-size:.72rem;text-transform:uppercase;letter-spacing:2px;color:var(--muted);transition:color .2s}
    .continue:hover{color:var(--gold)}
    .empty-state{text-align:center;padding:5rem 2rem;grid-column:1}
    .empty-state i{font-size:3.5rem;color:var(--border);display:block;margin-bottom:1.2rem}
    .empty-state h3{font-size:1.4rem;color:var(--muted);margin-bottom:.5rem}
    .empty-state p{margin-bottom:1.8rem}
    .btn{display:inline-block;font-family:var(--body);font-size:.78rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:.85rem 2rem;border:1px solid var(--gold);background:var(--gold);color:var(--black);cursor:pointer;transition:background .25s,transform .25s;border-radius:1px}
    .btn:hover{background:var(--gold-light);transform:translateY(-2px)}
    .login-prompt{text-align:center;padding:5rem 2rem;grid-column:1/-1}
    .login-prompt i{font-size:3rem;color:var(--border);display:block;margin-bottom:1rem}
    footer{padding:2.5rem 4% 2rem;text-align:center;border-top:1px solid var(--border)}
    .copy{font-size:.75rem;letter-spacing:1px;color:var(--muted)}
    @media(max-width:860px){.cart-wrap{grid-template-columns:1fr}.summary-box{position:static}}
    @media(max-width:580px){.item-top{grid-template-columns:65px 1fr}.item-right{display:none}.logo-bar img{width:100%;height:auto}}
  </style>
</head>
<body>

<nav>
  <div class="nav-links" style="display:flex">
    <li><a href="Home.php">Home</a></li>
    <li><a href="cart.php" class="active">Cart</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
    <?php if(isLoggedIn()): ?><li><a href="backend/logout.php">Logout</a></li>
    <?php else: ?><li><a href="login.php">Login</a></li><?php endif; ?>
  </div>
  <div class="nav-icons">
    <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i><span class="cart-badge">0</span></a>
    <?php if(isLoggedIn()): ?>
      <span class="nav-user"><i class="fa-solid fa-user" style="font-size:.85rem"></i> <?= userName() ?></span>
    <?php else: ?>
      <a href="login.php"><i class="fa-solid fa-user"></i></a>
    <?php endif; ?>
  </div>
</nav>

<div class="logo-bar"><img src="ogo1.jpg" alt="BuyHub" onerror="this.style.display='none'"></div>
<div class="page-title">
  <div class="breadcrumb"><a href="Home.php">Home</a> &rsaquo; Cart</div>
  <h1>Your Cart</h1>
</div>
<div class="dash-line" style="max-width:1100px;margin:1.5rem auto"></div>

<div class="cart-wrap" id="cart-wrap">
  <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--muted)">
    <i class="fa-solid fa-spinner fa-spin" style="font-size:1.5rem"></i>
  </div>
</div>

<footer>
  <hr style="border:none;border-top:1px solid var(--border);margin-bottom:1.5rem">
  <p class="copy">&copy; 2026 BuyHub. All rights reserved.</p>
</footer>

<script>
const IS_LOGGED_IN = <?= isLoggedIn() ? 'true' : 'false' ?>;
let cartItems = [];

async function loadCart() {
  const wrap = document.getElementById('cart-wrap');

  if (!IS_LOGGED_IN) {
    wrap.innerHTML = `
      <div class="login-prompt">
        <i class="fa-solid fa-lock"></i>
        <h3>Please log in to view your cart</h3>
        <p>You need an account to save and manage cart items.</p>
        <a href="login.php" class="btn">Sign In / Create Account</a>
      </div>`;
    return;
  }

  try {
    const res  = await fetch('backend/cart.php?action=fetch');
    const data = await res.json();
    cartItems  = data.items || [];
    renderCart(cartItems, data.total || 0);
  } catch(e) {
    wrap.innerHTML = `<p style="color:var(--muted);padding:3rem;text-align:center;grid-column:1/-1">Could not load cart. Please refresh.</p>`;
  }
}

function renderCart(items, total) {
  const wrap = document.getElementById('cart-wrap');

  if (!items.length) {
    wrap.innerHTML = `
      <div class="empty-state">
        <i class="fa-solid fa-bag-shopping"></i>
        <h3>Your cart is empty</h3>
        <p>Browse our vendors and add items you love.</p>
        <a href="Home.php" class="btn"><i class="fa-solid fa-arrow-left" style="font-size:.75rem"></i> &nbsp;Shop Now</a>
      </div>
      <div class="summary-box">
        <h2>Order Summary</h2>
        <div class="s-row"><span>Items</span><span>0</span></div>
        <div class="s-total"><span>Total</span><span>GH&#8373; 0.00</span></div>
        <a href="Home.php" class="continue">&#8592; Continue Shopping</a>
      </div>`;
    return;
  }

  const itemsHTML = items.map(item => {
    const waMsg = encodeURIComponent(`Hi, I found "${item.name}" on BuyHub and I'd like to purchase it. Could you assist me?`);
    return `
      <div class="cart-item" id="item-${item.cart_id}">
        <div class="item-top">
          ${item.image
            ? `<img class="item-img" src="${item.image}" alt="${item.name}" onerror="this.outerHTML='<div class=\\'item-img-ph\\'><i class=\\'fa-solid fa-shirt\\'></i></div>'">`
            : `<div class="item-img-ph"><i class="fa-solid fa-shirt"></i></div>`}
          <div class="item-info">
            <h3>${item.name}</h3>
            <div class="item-vendor"><i class="fa-solid fa-store"></i> ${item.vendor_name}</div>
            <div class="item-unit">GH&#8373; ${parseFloat(item.price).toFixed(2)} each</div>
          </div>
          <div class="item-right">
            <div class="qty-box">
              <button class="qty-btn" onclick="changeQty(${item.cart_id}, ${item.quantity - 1}, ${item.price})">&#8722;</button>
              <div class="qty-val" id="qty-${item.cart_id}">${item.quantity}</div>
              <button class="qty-btn" onclick="changeQty(${item.cart_id}, ${item.quantity + 1}, ${item.price})">&#43;</button>
            </div>
            <div class="item-subtotal" id="sub-${item.cart_id}">GH&#8373; ${parseFloat(item.subtotal).toFixed(2)}</div>
            <button class="remove-btn" onclick="removeItem(${item.cart_id})">
              <i class="fa-solid fa-trash-can" style="font-size:.65rem"></i> Remove
            </button>
          </div>
        </div>
        <div class="vendor-contact">
          <span class="vc-sold">Sold by</span>
          <span class="vc-name">${item.vendor_name}</span>
          <a class="vc-link" href="tel:${item.vendor_phone}"><i class="fa-solid fa-phone"></i> ${item.vendor_phone}</a>
          <a class="vc-link" href="mailto:${item.vendor_email}"><i class="fa-solid fa-envelope"></i> ${item.vendor_email}</a>
          <a class="vc-link wa" href="https://wa.me/${item.vendor_whatsapp}?text=${waMsg}" target="_blank">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp
          </a>
        </div>
      </div>`;
  }).join('');

  const itemCount = items.reduce((s, i) => s + i.quantity, 0);

  wrap.innerHTML = `
    <div>
      <div class="col-head">Your Items (${itemCount})</div>
      ${itemsHTML}
    </div>
    <div class="summary-box">
      <h2>Order Summary</h2>
      <div class="s-row"><span>Items</span><span>${itemCount}</span></div>
      <div class="s-row"><span>Subtotal</span><span id="s-sub">GH&#8373; ${parseFloat(total).toFixed(2)}</span></div>
      <div class="s-total"><span>Total</span><span id="s-total">GH&#8373; ${parseFloat(total).toFixed(2)}</span></div>
      <div class="checkout-note">
        <i class="fa-solid fa-circle-info"></i>
        Use the <strong style="color:var(--cream)">phone</strong>, <strong style="color:var(--cream)">email</strong>
        or <strong style="color:var(--cream)">WhatsApp</strong> on each item to contact the vendor and complete your purchase.
      </div>
      <a href="Home.php" class="continue">&#8592; Continue Shopping</a>
    </div>`;
}

async function changeQty(cartId, newQty, price) {
  const body = new FormData();
  body.append('action','update'); body.append('cart_id',cartId); body.append('quantity',newQty);
  const res  = await fetch('backend/cart.php', { method:'POST', body });
  const data = await res.json();
  if (data.removed) { loadCart(); return; }
  if (data.success) {
    const qEl = document.getElementById(`qty-${cartId}`);
    const sEl = document.getElementById(`sub-${cartId}`);
    if (qEl) qEl.textContent = newQty;
    if (sEl) sEl.textContent = `GH₵ ${(price * newQty).toFixed(2)}`;
    recalcTotal();
  }
}

async function removeItem(cartId) {
  const body = new FormData();
  body.append('action','remove'); body.append('cart_id',cartId);
  await fetch('backend/cart.php', { method:'POST', body });
  const el = document.getElementById(`item-${cartId}`);
  if (el) { el.style.transition='opacity .25s'; el.style.opacity='0'; setTimeout(loadCart, 280); }
}

function recalcTotal() {
  const items = document.querySelectorAll('.cart-item');
  let total = 0;
  items.forEach(item => {
    const sub = document.getElementById(`sub-${item.id.replace('item-','')}`);
    if (sub) total += parseFloat(sub.textContent.replace('GH₵','').replace('GH₵','').trim()) || 0;
  });
  const s = document.getElementById('s-sub');
  const t = document.getElementById('s-total');
  if (s) s.textContent = `GH₵ ${total.toFixed(2)}`;
  if (t) t.textContent = `GH₵ ${total.toFixed(2)}`;
}

loadCart();
</script>
</body>
</html>
