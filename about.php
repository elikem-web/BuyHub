<?php require_once 'backend/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BuyHub — About Us</title>
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
    .about-hero{text-align:center;padding:4rem 4% 3.5rem}
    .section-label{font-size:.72rem;letter-spacing:3px;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem}
    .about-hero h1{font-style:italic;font-size:clamp(2rem,4vw,3rem);margin-bottom:1rem}
    .about-hero p{max-width:640px;margin:0 auto;font-size:1.05rem}
    .story{max-width:820px;margin:0 auto;padding:3.5rem 4%}
    .story h2{font-size:1.6rem;color:var(--gold);margin-bottom:1rem;letter-spacing:1px}
    .story p{margin-bottom:1.2rem;line-height:1.85}
    .mission{background:var(--card-bg);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:3.5rem 4%;text-align:center}
    .mission h2{font-size:1.6rem;letter-spacing:2px;margin-bottom:1rem}
    .mission p{max-width:580px;margin:0 auto;font-size:1.05rem}
    .why{padding:4rem 4%;text-align:center}
    .why h2{font-size:1.6rem;letter-spacing:2px;margin-bottom:.5rem}
    .why .sub{margin-bottom:3rem}
    .why-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;max-width:1100px;margin:0 auto}
    .why-card{position:relative;background:var(--card-bg);border:1px solid var(--border);padding:2.2rem 1.2rem 2rem;text-align:center;transition:transform .3s,border-color .3s,box-shadow .3s}
    .why-card i{font-size:1.8rem;color:var(--gold);display:block;margin-bottom:1rem}
    .why-card h3{font-size:1rem;color:var(--cream);margin-bottom:.4rem}
    .why-card p{font-size:.87rem;margin:0}
    .why-card:hover{transform:translateY(-6px);border-color:var(--gold);box-shadow:0 10px 24px rgba(200,146,42,.1)}
    .why-card::before,.why-card::after{content:'';position:absolute;width:13px;height:13px;border:1.5px solid var(--gold);opacity:0;transition:opacity .3s}
    .why-card::before{top:5px;left:5px;border-right:none;border-bottom:none}
    .why-card::after{bottom:5px;right:5px;border-left:none;border-top:none}
    .why-card:hover::before,.why-card:hover::after{opacity:1}
    .quote-wrap{text-align:center;padding:4rem 4%}
    .quote blockquote{font-family:var(--display);font-style:italic;font-size:clamp(1.2rem,2.5vw,1.7rem);color:var(--cream);line-height:1.5;margin-bottom:1rem}
    footer{padding:2.5rem 4% 2rem;text-align:center;border-top:1px solid var(--border)}
    .footer-cols{display:grid;grid-template-columns:1fr 1fr;gap:2rem;text-align:left;max-width:700px;margin:0 auto 2rem}
    .footer-cols strong{font-family:var(--display);color:var(--gold);display:block;margin-bottom:.5rem}
    .footer-cols p{font-size:.88rem}
    .copy{font-size:.75rem;letter-spacing:1px;color:var(--muted)}
    @media(max-width:860px){.why-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:560px){.why-grid{grid-template-columns:1fr}.logo-bar img{width:100%;height:auto}.footer-cols{grid-template-columns:1fr;text-align:center}}
  </style>
</head>
<body>
<nav>
  <div class="nav-links" style="display:flex">
    <li><a href="Home.php">Home</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="about.php" class="active">About</a></li>
    <li><a href="contact.php">Contact</a></li>
    <?php if(isLoggedIn()): ?><li><a href="backend/logout.php">Logout</a></li>
    <?php else: ?><li><a href="login.php">Login</a></li><?php endif; ?>
  </div>
  <div class="nav-icons">
    <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i><span class="cart-badge">0</span></a>
    <?php if(isLoggedIn()): ?>
      <span class="nav-user"><i class="fa-solid fa-user" style="font-size:.85rem"></i> <?= userName() ?></span>
    <?php else: ?><a href="login.php"><i class="fa-solid fa-user"></i></a><?php endif; ?>
  </div>
</nav>
<div class="logo-bar"><img src="ogo1.jpg" alt="BuyHub" onerror="this.style.display='none'"></div>
<section class="about-hero">
  <div class="section-label">Our Story</div>
  <h1>Welcome to BuyHub</h1>
  <p>We are an online shopping platform connecting buyers to trusted Ghanaian vendors — making quality fashion accessible to everyone.</p>
</section>
<div class="dash-line"></div>
<div class="story">
  <h2>Who We Are</h2>
  <p>At BuyHub, we carefully select vendors that meet high standards of quality and reliability. Whether you're looking for men's fashion, women's wear, accessories or footwear, our vetted vendor network has you covered.</p>
  <p>Founded in Ghana and built with a passion for accessible fashion, BuyHub connects shoppers across the country to the best curated products from local vendors.</p>
</div>
<div class="dash-line"></div>
<section class="mission">
  <div class="section-label">Purpose</div>
  <h2>Our Mission</h2>
  <p>To provide customers with quality products from trusted vendors, with direct contact to make purchasing easy — all in one platform built for Ghana.</p>
</section>
<div class="dash-line"></div>
<section class="why">
  <div class="section-label">The BuyHub Difference</div>
  <h2>Why Choose Us?</h2>
  <p class="sub">Here is what makes us stand out</p>
  <div class="why-grid">
    <div class="why-card"><i class="fa-solid fa-tag"></i><h3>Affordable Prices</h3><p>Premium quality without the premium price tag — always.</p></div>
    <div class="why-card"><i class="fa-solid fa-store"></i><h3>Trusted Vendors</h3><p>Every vendor is vetted to ensure quality and reliability.</p></div>
    <div class="why-card"><i class="fa-brands fa-whatsapp"></i><h3>Direct Contact</h3><p>Call, email or WhatsApp vendors directly to complete your purchase.</p></div>
    <div class="why-card"><i class="fa-solid fa-map-location-dot"></i><h3>Ghana-Based</h3><p>Local vendors, local knowledge, serving shoppers nationwide.</p></div>
  </div>
</section>
<div class="dash-line"></div>
<div class="quote-wrap">
  <div class="quote">
    <blockquote>"Fashion is for everyone. At BuyHub, we make sure no one is left out."</blockquote>
  </div>
</div>
<footer>
  <hr style="border:none;border-top:1px solid var(--border);margin-bottom:2rem">
  <div class="footer-cols">
    <div><strong>BuyHub</strong><p>Your one-stop destination for premium fashion from trusted Ghanaian vendors.</p></div>
    <div><strong>Contact</strong><p>info@buyhub.com<br>+233 55 239 1385<br>Koforidua, Ghana</p></div>
  </div>
  <hr style="border:none;border-top:1px solid var(--border);margin-bottom:1.5rem">
  <p class="copy">&copy; 2026 BuyHub. All rights reserved.</p>
</footer>
</body>
</html>
