<?php require_once 'backend/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BuyHub — Shop Everything. Anywhere.</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --black:#000;--gold:#c8922a;--gold-light:#e7b94f;
      --cream:#f3ece1;--muted:#997a3a;--card-bg:#0d0d0d;--border:#2a1f0a;
      --display:'Playfair Display',serif;--body:'Jost',sans-serif;
    }
    html{scroll-behavior:smooth}
    body{background:var(--black);color:var(--gold);font-family:var(--body);font-size:16px;line-height:1.7}
    a{color:var(--gold);text-decoration:none}
    h1,h2,h3,h4{font-family:var(--display);font-weight:600}
    p{color:var(--muted)}

    /* ── NAV ── */
    nav{display:flex;align-items:center;justify-content:space-between;padding:1rem 4%;border-bottom:1px solid var(--border);position:sticky;top:0;background:var(--black);z-index:200}
    .nav-links{display:flex;gap:2rem;list-style:none}
    .nav-links a{font-size:.78rem;letter-spacing:2px;text-transform:uppercase;color:var(--gold);transition:color .2s}
    .nav-links a:hover,.nav-links a.active{color:var(--gold-light);border-bottom:1px solid var(--gold-light)}
    .nav-icons{display:flex;gap:1.2rem;font-size:1rem;align-items:center}
    .nav-icons a{color:var(--gold);transition:color .2s;position:relative}
    .nav-icons a:hover{color:var(--gold-light)}
    .nav-user{font-size:.8rem;color:var(--gold-light);font-family:var(--display);letter-spacing:1px}
    .cart-badge{position:absolute;top:-7px;right:-9px;background:var(--gold);color:var(--black);font-size:.55rem;font-weight:700;width:16px;height:16px;border-radius:50%;display:none;align-items:center;justify-content:center}

    /* ── LOGO ── */
    .logo-bar{text-align:center;padding:2rem 4% 0}
    .logo-bar img{width:600px;height:110px;object-fit:contain;display:block;margin:0 auto}
    .dash-line{height:1px;width:100%;background:repeating-linear-gradient(to right,var(--gold) 0,var(--gold) 8px,transparent 8px,transparent 20px);opacity:.35}

    /* ════════════════════════════════════════════
       HERO SECTION WITH ANIMATION
    ════════════════════════════════════════════ */
    .hero{
      position:relative;min-height:560px;
      display:grid;grid-template-columns:1fr 1fr;
      align-items:center;gap:2rem;
      padding:3rem 6%;overflow:hidden;
    }
    /* Animated gold gradient background */
    .hero::before{
      content:'';position:absolute;inset:0;
      background:radial-gradient(ellipse at 70% 50%, rgba(200,146,42,.08) 0%, transparent 65%),
                 radial-gradient(ellipse at 30% 80%, rgba(200,146,42,.05) 0%, transparent 55%);
      pointer-events:none;
    }

    /* ── Hero text side ── */
    .hero-text{position:relative;z-index:2}
    .hero-label{font-size:.7rem;letter-spacing:4px;text-transform:uppercase;color:var(--muted);margin-bottom:.8rem;opacity:0;animation:fadeUp .7s .2s forwards}
    .hero-text h1{font-size:clamp(2rem,4vw,3.2rem);font-style:italic;color:var(--gold);line-height:1.2;margin-bottom:1.1rem;opacity:0;animation:fadeUp .7s .4s forwards}
    .hero-text p{font-size:1rem;margin-bottom:2rem;max-width:420px;opacity:0;animation:fadeUp .7s .6s forwards}
    .hero-btns{display:flex;gap:1rem;flex-wrap:wrap;opacity:0;animation:fadeUp .7s .8s forwards}
    .btn{display:inline-block;font-family:var(--body);font-size:.78rem;font-weight:600;letter-spacing:2.5px;text-transform:uppercase;padding:.85rem 2rem;border:1px solid var(--gold);background:var(--gold);color:var(--black);cursor:pointer;transition:background .25s,transform .25s;border-radius:1px}
    .btn:hover{background:var(--gold-light);transform:translateY(-2px)}
    .btn-ghost{background:transparent;color:var(--gold)}
    .btn-ghost:hover{background:var(--gold);color:var(--black)}

    /* Stats row */
    .hero-stats{display:flex;gap:2rem;margin-top:2.5rem;opacity:0;animation:fadeUp .7s 1s forwards}
    .stat{text-align:left}
    .stat-num{font-family:var(--display);font-size:1.6rem;color:var(--gold);line-height:1}
    .stat-label{font-size:.65rem;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-top:.2rem}

    /* ── Hero animation side ── */
    .hero-visual{
      position:relative;z-index:2;
      height:480px;display:flex;align-items:center;justify-content:center;
    }

    /* Rotating ring */
    .hero-ring{
      position:absolute;width:380px;height:380px;border-radius:50%;
      border:1px solid rgba(200,146,42,.15);
      animation:spin 25s linear infinite;
    }
    .hero-ring-2{
      position:absolute;width:300px;height:300px;border-radius:50%;
      border:1px dashed rgba(200,146,42,.1);
      animation:spin 18s linear infinite reverse;
    }
    @keyframes spin{to{transform:rotate(360deg)}}

    /* Floating fashion cards */
    .fashion-stage{
      position:relative;width:340px;height:420px;
    }
    .f-card{
      position:absolute;border:1px solid var(--border);
      background:var(--card-bg);overflow:hidden;
      box-shadow:0 8px 32px rgba(0,0,0,.6);
      transition:transform .3s;
    }
    .f-card img{width:100%;height:100%;object-fit:cover;display:block;filter:brightness(.9)}
    .f-card-label{
      position:absolute;bottom:0;left:0;right:0;
      padding:.5rem .7rem;
      background:linear-gradient(to top, rgba(0,0,0,.85) 0%, transparent 100%);
      font-size:.68rem;letter-spacing:1.5px;text-transform:uppercase;color:var(--cream);
    }
    .f-card-price{
      position:absolute;top:.6rem;right:.6rem;
      background:var(--gold);color:var(--black);
      font-size:.65rem;font-weight:700;letter-spacing:1px;
      padding:.2rem .5rem;
    }

    /* Card 1 — centre, large */
    .f-card-1{
      width:200px;height:260px;
      left:50%;top:50%;
      transform:translate(-50%,-50%);
      z-index:4;
      animation:floatC 5s ease-in-out infinite;
    }
    /* Card 2 — top left */
    .f-card-2{
      width:140px;height:175px;
      left:0;top:20px;z-index:3;
      animation:floatL 6s ease-in-out infinite;
    }
    /* Card 3 — bottom right */
    .f-card-3{
      width:145px;height:180px;
      right:0;bottom:20px;z-index:3;
      animation:floatR 5.5s ease-in-out infinite;
    }
    /* Card 4 — top right small */
    .f-card-4{
      width:110px;height:138px;
      right:10px;top:10px;z-index:2;
      animation:floatR 7s ease-in-out infinite 1s;
      opacity:.85;
    }
    /* Card 5 — bottom left small */
    .f-card-5{
      width:115px;height:140px;
      left:5px;bottom:10px;z-index:2;
      animation:floatL 6.5s ease-in-out infinite .5s;
      opacity:.85;
    }

    @keyframes floatC{
      0%,100%{transform:translate(-50%,-50%) translateY(0) rotate(-1deg)}
      50%{transform:translate(-50%,-50%) translateY(-14px) rotate(1deg)}
    }
    @keyframes floatL{
      0%,100%{transform:translateY(0) rotate(-2deg)}
      50%{transform:translateY(-10px) rotate(1deg)}
    }
    @keyframes floatR{
      0%,100%{transform:translateY(0) rotate(2deg)}
      50%{transform:translateY(-12px) rotate(-1deg)}
    }

    /* Sliding text ticker */
    .hero-ticker{
      position:absolute;bottom:0;left:0;right:0;
      overflow:hidden;border-top:1px solid var(--border);
      background:rgba(0,0,0,.5);padding:.5rem 0;
    }
    .ticker-inner{
      display:flex;gap:3rem;white-space:nowrap;
      animation:ticker 20s linear infinite;
    }
    .ticker-inner span{font-size:.65rem;letter-spacing:3px;text-transform:uppercase;color:var(--muted)}
    .ticker-inner i{color:var(--gold);font-size:.55rem}
    @keyframes ticker{from{transform:translateX(0)}to{transform:translateX(-50%)}}

    /* Fade up animation */
    @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

    /* ── SECTION ── */
    .sec-head{text-align:center;padding:3.5rem 4% 0}
    .section-label{font-size:.72rem;letter-spacing:3px;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem}
    .sec-head h2{font-size:clamp(1.5rem,3vw,2.1rem);color:var(--gold);letter-spacing:2px;margin-bottom:.4rem}

    /* ── CATEGORY TABS ── */
    .cat-tabs{display:flex;max-width:1100px;margin:2rem auto 0;border-bottom:1px solid var(--border);padding:0 4%;overflow-x:auto;gap:0}
    .cat-tab{padding:.7rem 1.4rem;font-size:.72rem;letter-spacing:2px;text-transform:uppercase;color:var(--muted);cursor:pointer;border-bottom:2px solid transparent;white-space:nowrap;transition:color .2s,border-color .2s;font-family:var(--body);background:none;border-top:none;border-left:none;border-right:none}
    .cat-tab.active{color:var(--gold);border-bottom-color:var(--gold)}
    .cat-tab:hover{color:var(--gold-light)}

    /* ── VENDOR BLOCK ── */
    .vendor-block{max-width:1100px;margin:0 auto;padding:3rem 4% 2rem}
    .vendor-block.hidden{display:none}
    .vendor-header{display:flex;align-items:center;gap:1.4rem;margin-bottom:2rem;padding-bottom:1.2rem;border-bottom:1px solid var(--border)}
    .v-logo{width:70px;height:70px;border-radius:2px;border:1px solid var(--border);overflow:hidden;flex-shrink:0;background:var(--card-bg);display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:var(--gold)}
    .v-logo img{width:100%;height:100%;object-fit:cover}
    .v-cat-tag{display:inline-block;font-size:.6rem;letter-spacing:2px;text-transform:uppercase;color:var(--black);background:var(--gold);padding:.12rem .5rem;margin-bottom:.35rem}
    .v-meta h3{font-size:1.25rem;color:var(--gold);margin-bottom:.2rem}
    .v-meta p{font-size:.85rem;margin:0}

    /* ── PRODUCT GRID ── */
    .product-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.4rem}
    .p-card{background:var(--card-bg);border:1px solid var(--border);position:relative;overflow:hidden;transition:transform .3s,border-color .3s,box-shadow .3s}
    .p-card:hover{transform:translateY(-5px);border-color:var(--gold);box-shadow:0 12px 28px rgba(200,146,42,.12)}
    .p-card::before,.p-card::after{content:'';position:absolute;width:12px;height:12px;border:1.5px solid var(--gold);opacity:0;transition:opacity .3s;z-index:1}
    .p-card::before{top:5px;left:5px;border-right:none;border-bottom:none}
    .p-card::after{bottom:5px;right:5px;border-left:none;border-top:none}
    .p-card:hover::before,.p-card:hover::after{opacity:1}
    .p-img-wrap{width:100%;aspect-ratio:4/3;overflow:hidden;background:#111;position:relative}
    .p-img-wrap img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
    .p-card:hover .p-img-wrap img{transform:scale(1.05)}
    .p-badge{position:absolute;top:.6rem;left:.6rem;background:var(--gold);color:var(--black);font-size:.58rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:.2rem .5rem;z-index:2}
    .p-placeholder{width:100%;aspect-ratio:4/3;background:linear-gradient(135deg,#111 0%,#1a1200 100%);display:flex;align-items:center;justify-content:center;font-size:3rem;color:rgba(200,146,42,.3)}
    .p-body{padding:1rem}
    .p-body h4{font-size:.98rem;color:var(--cream);margin-bottom:.2rem;line-height:1.3}
    .p-desc{font-size:.8rem;color:var(--muted);margin-bottom:.6rem;line-height:1.45}
    .p-price{font-family:var(--display);font-size:1.15rem;color:var(--gold);font-weight:600;margin-bottom:.8rem}
    .p-price .old{font-size:.8rem;color:var(--muted);text-decoration:line-through;margin-left:.4rem;font-family:var(--body);font-weight:400}
    .add-btn{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;font-family:var(--body);font-size:.72rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:.65rem;border:1px solid var(--gold);background:transparent;color:var(--gold);cursor:pointer;transition:background .2s,color .2s}
    .add-btn:hover{background:var(--gold);color:var(--black)}
    .add-btn.added{background:var(--gold);color:var(--black)}
    .add-btn:disabled{opacity:.5;cursor:not-allowed}

    /* Loading skeleton */
    .skeleton-vendor{max-width:1100px;margin:3rem auto;padding:0 4%}
    .skel{background:linear-gradient(90deg,#0d0d0d 25%,#1a1200 50%,#0d0d0d 75%);background-size:200%;animation:shimmer 1.4s infinite;border-radius:2px}
    @keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
    .skel-header{height:70px;margin-bottom:1.5rem}
    .skel-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.4rem}
    .skel-card{height:280px}

    /* Toast */
    #bh-toast{position:fixed;bottom:2rem;right:2rem;background:var(--card-bg);border:1px solid var(--gold);color:var(--cream);padding:.85rem 1.3rem;font-size:.83rem;z-index:9999;opacity:0;transform:translateY(8px);transition:opacity .3s,transform .3s;pointer-events:none;min-width:220px;display:flex;align-items:center;gap:.6rem}
    #bh-toast.show{opacity:1;transform:translateY(0)}
    #bh-toast.err{border-color:#c0392b;color:#c0392b}

    /* Promo */
    .promo{background:var(--card-bg);border-top:1px solid var(--border);border-bottom:1px solid var(--border);text-align:center;padding:4rem 4%}
    .promo p{max-width:480px;margin:0 auto 2rem}

    /* Footer */
    footer{padding:3rem 4% 2rem;text-align:center;border-top:1px solid var(--border)}
    .footer-img{width:100%;max-height:380px;object-fit:cover;margin-bottom:2.5rem;border:1px solid var(--border);display:block}
    .footer-cols{display:grid;grid-template-columns:1fr 1fr;gap:2rem;text-align:left;max-width:800px;margin:0 auto 2rem}
    .footer-cols strong{font-family:var(--display);color:var(--gold);display:block;margin-bottom:.5rem}
    .footer-cols p{font-size:.88rem}
    .footer-hr{border:none;border-top:1px solid var(--border);margin:1.5rem 0}
    .copy{font-size:.75rem;letter-spacing:1px;color:var(--muted)}

    /* Error state */
    .db-error{text-align:center;padding:4rem 2rem;max-width:500px;margin:0 auto}
    .db-error i{font-size:2.5rem;color:var(--border);display:block;margin-bottom:1rem}
    .db-error h3{color:var(--muted);margin-bottom:.5rem}
    .db-error code{font-size:.78rem;color:#c0392b;background:#0a0000;padding:.3rem .6rem;display:inline-block;margin-top:.5rem}

    @media(max-width:900px){
      .hero{grid-template-columns:1fr;min-height:auto;padding:3rem 4%}
      .hero-visual{height:320px;width:280px;margin:0 auto}
      .hero-ring{width:280px;height:280px}
      .hero-ring-2{width:220px;height:220px}
      .f-card-1{width:150px;height:195px}
      .f-card-2,.f-card-3{width:110px;height:138px}
      .f-card-4,.f-card-5{display:none}
      .product-grid{grid-template-columns:repeat(2,1fr)}
    }
    @media(max-width:600px){
      .product-grid{grid-template-columns:1fr}
      .logo-bar img{width:100%;height:auto}
      .footer-cols{grid-template-columns:1fr;text-align:center}
      .hero-stats{gap:1.2rem}
      .vendor-header{flex-direction:column;align-items:flex-start}
    }
  </style>
</head>
<body>

<div id="bh-toast"></div>

<!-- ── NAV ── -->
<nav>
  <div class="nav-links" style="display:flex">
    <li><a href="Home.php" class="active">Home</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
    <?php if(isLoggedIn()): ?>
      <li><a href="backend/logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="login.php">Login</a></li>
    <?php endif; ?>
  </div>
  <div class="nav-icons">
    <a href="cart.php">
      <i class="fa-solid fa-bag-shopping"></i>
      <span class="cart-badge" id="cart-badge">0</span>
    </a>
    <?php if(isLoggedIn()): ?>
      <span class="nav-user"><i class="fa-solid fa-user" style="font-size:.85rem"></i> <?= userName() ?></span>
    <?php else: ?>
      <a href="login.php"><i class="fa-solid fa-user"></i></a>
    <?php endif; ?>
  </div>
</nav>

<!-- ── LOGO ── -->
<div class="logo-bar">
  <img src="ogo1.jpg" alt="BuyHub" onerror="this.style.display='none'">
</div>

<!-- ════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════ -->
<section class="hero">

  <!-- Left: text -->
  <div class="hero-text">
    <div class="hero-label">New Season 2026</div>
    <h1>Dress to Impress.<br>Shop the Latest<br>Fashion.</h1>
    <p>Discover premium fashion from trusted vendors across Ghana. Browse, add to cart, then contact the vendor directly to purchase.</p>
    <div class="hero-btns">
      <a href="#vendors" class="btn">Browse Vendors</a>
      <?php if(!isLoggedIn()): ?>
        <a href="login.php" class="btn btn-ghost">Create Account</a>
      <?php endif; ?>
    </div>
    <div class="hero-stats">
      <div class="stat">
        <div class="stat-num">4+</div>
        <div class="stat-label">Vendors</div>
      </div>
      <div class="stat">
        <div class="stat-num">12+</div>
        <div class="stat-label">Products</div>
      </div>
      <div class="stat">
        <div class="stat-num">GH&#8373;</div>
        <div class="stat-label">Best Prices</div>
      </div>
    </div>
  </div>

  <!-- Right: animated fashion cards -->
  <div class="hero-visual">
    <div class="hero-ring"></div>
    <div class="hero-ring-2"></div>

    <div class="fashion-stage">

      <!-- Card 1 — Centre (Women dress) -->
      <div class="f-card f-card-1">
        <img src="https://images.unsplash.com/photo-1612336307429-8a898d10e223?w=400&q=80"
             alt="Floral Dress"
             onerror="this.src='https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=400&q=80'">
        <div class="f-card-price">GH&#8373; 160</div>
        <div class="f-card-label">Queenz Fashion</div>
      </div>

      <!-- Card 2 — Top left (Sneakers) -->
      <div class="f-card f-card-2">
        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&q=80"
             alt="Sneakers"
             onerror="this.style.background='#111'">
        <div class="f-card-label">StepUp</div>
      </div>

      <!-- Card 3 — Bottom right (Handbag) -->
      <div class="f-card f-card-3">
        <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=300&q=80"
             alt="Handbag"
             onerror="this.style.background='#111'">
        <div class="f-card-label">Golden</div>
      </div>

      <!-- Card 4 — Top right (Men's shirt) -->
      <div class="f-card f-card-4">
        <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=250&q=80"
             alt="Shirt"
             onerror="this.style.background='#111'">
      </div>

      <!-- Card 5 — Bottom left (Heels) -->
      <div class="f-card f-card-5">
        <img src="https://images.unsplash.com/photo-1515347619252-60a4bf4fff4f?w=250&q=80"
             alt="Heels"
             onerror="this.style.background='#111'">
      </div>

    </div><!-- end fashion-stage -->
  </div><!-- end hero-visual -->

  <!-- Scrolling ticker -->
  <div class="hero-ticker">
    <div class="ticker-inner">
      <span><i class="fa-solid fa-circle-dot"></i> Men's Fashion</span>
      <span><i class="fa-solid fa-circle-dot"></i> Women's Fashion</span>
      <span><i class="fa-solid fa-circle-dot"></i> Accessories</span>
      <span><i class="fa-solid fa-circle-dot"></i> Footwear</span>
      <span><i class="fa-solid fa-circle-dot"></i> New Season 2026</span>
      <span><i class="fa-solid fa-circle-dot"></i> Trusted Vendors</span>
      <span><i class="fa-solid fa-circle-dot"></i> Made in Ghana</span>
      <span><i class="fa-solid fa-circle-dot"></i> Men's Fashion</span>
      <span><i class="fa-solid fa-circle-dot"></i> Women's Fashion</span>
      <span><i class="fa-solid fa-circle-dot"></i> Accessories</span>
      <span><i class="fa-solid fa-circle-dot"></i> Footwear</span>
      <span><i class="fa-solid fa-circle-dot"></i> New Season 2026</span>
      <span><i class="fa-solid fa-circle-dot"></i> Trusted Vendors</span>
      <span><i class="fa-solid fa-circle-dot"></i> Made in Ghana</span>
    </div>
  </div>

</section>

<div class="dash-line"></div>

<!-- ── CATEGORY TABS ── -->
<div class="sec-head">
  <div class="section-label">Collections</div>
  <h2>Shop by Vendor Category</h2>
  <p style="color:var(--muted)">Filter to find exactly what you're looking for</p>
</div>
<div class="cat-tabs">
  <button class="cat-tab active" data-cat="all">All Vendors</button>
  <button class="cat-tab" data-cat="men"><i class="fa-solid fa-person"></i> &nbsp;Men</button>
  <button class="cat-tab" data-cat="women"><i class="fa-solid fa-person-dress"></i> &nbsp;Women</button>
  <button class="cat-tab" data-cat="accessories"><i class="fa-solid fa-bag-shopping"></i> &nbsp;Accessories</button>
  <button class="cat-tab" data-cat="footwear"><i class="fa-solid fa-shoe-prints"></i> &nbsp;Footwear</button>
</div>

<div class="dash-line" style="margin-top:0;opacity:.15"></div>

<!-- ── VENDORS + PRODUCTS (loaded from DB) ── -->
<div id="vendors"></div>

<div class="dash-line"></div>

<!-- ── PROMO ── -->
<section class="promo">
  <div class="section-label">Limited Time</div>
  <h2 style="font-family:var(--display);font-size:1.8rem;margin-bottom:.5rem">Get 20% Off Your First Order</h2>
  <p>Sign up today and unlock exclusive deals from all our vendors.</p>
  <?php if(!isLoggedIn()): ?>
    <a href="login.php" class="btn btn-ghost">Create Account</a>
  <?php else: ?>
    <a href="#vendors" class="btn btn-ghost">Start Shopping</a>
  <?php endif; ?>
</section>

<!-- ── FOOTER ── -->
<footer>
  <img src="photo_2026-06-09_16-55-16.jpg" alt="BuyHub" class="footer-img" onerror="this.style.display='none'">
  <div class="footer-cols">
    <div><strong>BuyHub</strong><p>Your one-stop destination for premium fashion from trusted Ghanaian vendors.</p></div>
    <div><strong>Contact</strong><p>info@buyhub.com<br>+233 55 239 1385<br>Koforidua, Ghana</p></div>
  </div>
  <hr class="footer-hr">
  <p class="copy">&copy; 2026 BuyHub. All rights reserved.</p>
</footer>

<script>
const IS_LOGGED_IN = <?= isLoggedIn() ? 'true' : 'false' ?>;

const CAT_ICONS = {
  men:         'fa-solid fa-person',
  women:       'fa-solid fa-person-dress',
  accessories: 'fa-solid fa-bag-shopping',
  footwear:    'fa-solid fa-shoe-prints'
};

let allVendors = [];

// ════════════════════════════════════════
//  LOAD VENDORS + PRODUCTS FROM DATABASE
// ════════════════════════════════════════
async function loadVendors(cat = 'all') {
  const container = document.getElementById('vendors');

  // Show skeleton loaders
  container.innerHTML = `
    <div class="skeleton-vendor">
      <div class="skel skel-header"></div>
      <div class="skel-grid">
        <div class="skel skel-card"></div>
        <div class="skel skel-card"></div>
        <div class="skel skel-card"></div>
      </div>
    </div>`;

  try {
    // Only fetch from server if we don't have data yet
    if (!allVendors.length) {
      const res  = await fetch('backend/products.php?action=by_vendor');
      const data = await res.json();

      if (!data.success) throw new Error(data.message || 'Failed to load products.');
      allVendors = data.vendors || [];
    }

    const filtered = cat === 'all'
      ? allVendors
      : allVendors.filter(v => v.category === cat);

    if (!filtered.length) {
      container.innerHTML = `
        <div class="db-error">
          <i class="fa-solid fa-store-slash"></i>
          <h3>No vendors in this category yet</h3>
          <p>Check back soon!</p>
        </div>`;
      return;
    }

    container.innerHTML = filtered.map(vendor => `
      <div class="vendor-block" data-cat="${vendor.category}" id="v-${vendor.id}">
        <div style="max-width:1100px;margin:0 auto">
          <div class="vendor-header">
            <div class="v-logo">
              ${vendor.logo
                ? `<img src="${vendor.logo}" alt="${vendor.name}" onerror="this.parentElement.innerHTML='<i class=\\'${CAT_ICONS[vendor.category]}\\'></i>'">`
                : `<i class="${CAT_ICONS[vendor.category]}"></i>`}
            </div>
            <div class="v-meta">
              <div class="v-cat-tag">${vendor.category}</div>
              <h3>${vendor.name}</h3>
              <p>${vendor.description || ''}</p>
            </div>
          </div>

          ${vendor.products.length ? `
            <div class="product-grid">
              ${vendor.products.map(p => `
                <div class="p-card">
                  <div class="p-img-wrap">
                    ${p.badge ? `<span class="p-badge">${p.badge}</span>` : ''}
                    ${p.image
                      ? `<img src="${p.image}" alt="${p.name}"
                              loading="lazy"
                              onerror="this.parentElement.innerHTML='<div class=\\'p-placeholder\\'><i class=\\'${CAT_ICONS[vendor.category]}\\'></i></div>'">`
                      : `<div class="p-placeholder"><i class="${CAT_ICONS[vendor.category]}"></i></div>`}
                  </div>
                  <div class="p-body">
                    <h4>${p.name}</h4>
                    <p class="p-desc">${p.description || ''}</p>
                    <div class="p-price">
                      GH&#8373; ${parseFloat(p.price).toFixed(2)}
                      ${p.old_price ? `<span class="old">GH&#8373; ${parseFloat(p.old_price).toFixed(2)}</span>` : ''}
                    </div>
                    <button class="add-btn" id="btn-${p.id}"
                      onclick="addToCart(${p.id}, '${p.name.replace(/'/g,"\\'")}', ${parseFloat(p.price)}, '${(p.image||'').replace(/'/g,"\\'")}', '${vendor.name.replace(/'/g,"\\'")}', this)">
                      <i class="fa-solid fa-cart-plus"></i> Add to Cart
                    </button>
                  </div>
                </div>
              `).join('')}
            </div>
          ` : `<p style="color:var(--muted);font-size:.9rem">No products available yet.</p>`}
        </div>
      </div>
      <div class="dash-line" style="opacity:.12"></div>
    `).join('');

  } catch(err) {
    container.innerHTML = `
      <div class="db-error">
        <i class="fa-solid fa-database"></i>
        <h3>Could not load products</h3>
        <p>Make sure your MySQL server is running and the database is set up.</p>
        <code>${err.message}</code>
      </div>`;
  }
}

// ════════════════════════════════════════
//  ADD TO CART
// ════════════════════════════════════════
async function addToCart(productId, name, price, image, vendor, btn) {
  if (!IS_LOGGED_IN) {
    showToast('Please log in to add items to your cart.', true);
    setTimeout(() => window.location.href = 'login.php', 1200);
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding…';

  const body = new FormData();
  body.append('action',     'add');
  body.append('product_id', productId);
  body.append('quantity',   1);

  try {
    const res  = await fetch('backend/cart.php', { method: 'POST', body });
    const data = await res.json();

    if (data.redirect) { window.location.href = data.redirect; return; }

    if (data.success) {
      showToast(`${name} added to cart!`);
      btn.classList.add('added');
      btn.innerHTML = '<i class="fa-solid fa-check"></i> Added!';
      updateCartBadge();
      setTimeout(() => {
        btn.innerHTML = '<i class="fa-solid fa-cart-plus"></i> Add to Cart';
        btn.classList.remove('added');
        btn.disabled = false;
      }, 1800);
    } else {
      showToast(data.message, true);
      btn.innerHTML = '<i class="fa-solid fa-cart-plus"></i> Add to Cart';
      btn.disabled = false;
    }
  } catch(e) {
    showToast('Something went wrong. Try again.', true);
    btn.innerHTML = '<i class="fa-solid fa-cart-plus"></i> Add to Cart';
    btn.disabled = false;
  }
}

// ════════════════════════════════════════
//  CART BADGE (live count from DB)
// ════════════════════════════════════════
async function updateCartBadge() {
  if (!IS_LOGGED_IN) return;
  try {
    const res  = await fetch('backend/cart.php?action=fetch');
    const data = await res.json();
    const count = (data.items || []).reduce((s, i) => s + i.quantity, 0);
    const badge = document.getElementById('cart-badge');
    if (count > 0) { badge.textContent = count; badge.style.display = 'inline-flex'; }
    else badge.style.display = 'none';
  } catch(e) {}
}

// ════════════════════════════════════════
//  TOAST
// ════════════════════════════════════════
function showToast(msg, isErr = false) {
  const t = document.getElementById('bh-toast');
  t.className = isErr ? 'err' : '';
  t.innerHTML = isErr
    ? `<i class="fa-solid fa-circle-exclamation"></i> ${msg}`
    : `<i class="fa-solid fa-check" style="color:var(--gold)"></i> ${msg}`;
  t.classList.add('show');
  clearTimeout(window._toastT);
  window._toastT = setTimeout(() => t.classList.remove('show'), 2800);
}

// ════════════════════════════════════════
//  CATEGORY TABS
// ════════════════════════════════════════
document.querySelectorAll('.cat-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    loadVendors(tab.dataset.cat);
    document.getElementById('vendors').scrollIntoView({ behavior:'smooth', block:'start' });
  });
});

// ════════════════════════════════════════
//  INIT
// ════════════════════════════════════════
loadVendors();
updateCartBadge();
</script>

</body>
</html>
