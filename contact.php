<?php require_once 'backend/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BuyHub — Contact Us</title>
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
    .page-hero{text-align:center;padding:3.5rem 4% 3rem}
    .section-label{font-size:.72rem;letter-spacing:3px;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem}
    .page-hero h1{font-style:italic;font-size:clamp(2rem,4vw,3rem);margin-bottom:.8rem}
    .page-hero p{max-width:520px;margin:0 auto}
    .contact-wrap{display:grid;grid-template-columns:5fr 4fr;gap:3rem;max-width:1050px;margin:0 auto;padding:0 4% 5rem;align-items:start}
    .form-box{background:var(--card-bg);border:1px solid var(--border);padding:2.5rem}
    .form-box h2{font-size:1.3rem;letter-spacing:1px;margin-bottom:1.8rem}
    .field{margin-bottom:1.3rem}
    .field label{display:block;font-size:.73rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);margin-bottom:.4rem}
    .field-inner{position:relative}
    .field-inner i{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);font-size:.82rem;color:var(--muted);pointer-events:none}
    .field-inner.area i{top:.85rem;transform:none}
    .field input,.field select,.field textarea{width:100%;background:#080808;border:1px solid var(--border);color:var(--cream);font-family:var(--body);font-size:.93rem;padding:.72rem .9rem .72rem 2.3rem;outline:none;transition:border-color .2s;appearance:none}
    .field textarea{padding-left:2.3rem;resize:vertical;min-height:120px}
    .field input::placeholder,.field textarea::placeholder{color:var(--muted)}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--gold)}
    .field input.err,.field select.err,.field textarea.err{border-color:#c0392b}
    .field select{color:var(--muted);cursor:pointer}
    .field select.filled{color:var(--cream)}
    .field select option{background:#111;color:var(--cream)}
    .field-msg{font-size:.7rem;color:#c0392b;margin-top:.3rem;display:none}
    .field-msg.show{display:block}
    @keyframes shake{0%,100%{transform:translateX(0)}20%,60%{transform:translateX(-5px)}40%,80%{transform:translateX(5px)}}
    .shake{animation:shake .35s}
    .alert{padding:.75rem 1rem;font-size:.82rem;margin-bottom:1.2rem;display:none;border-left:3px solid;line-height:1.55}
    .alert.show{display:flex;align-items:center;gap:.6rem}
    .alert.success{background:rgba(39,174,96,.1);border-color:#27ae60;color:#27ae60}
    .alert.error{background:rgba(192,57,43,.1);border-color:#c0392b;color:#c0392b}
    .btn{display:block;width:100%;text-align:center;font-family:var(--body);font-size:.82rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:.9rem;border:1px solid var(--gold);background:var(--gold);color:var(--black);cursor:pointer;margin-top:.5rem;transition:background .25s,transform .25s}
    .btn:hover:not(:disabled){background:var(--gold-light);transform:translateY(-2px)}
    .btn:disabled{opacity:.65;cursor:not-allowed}
    .info-box{display:flex;flex-direction:column;gap:0}
    .info-card{background:var(--card-bg);border:1px solid var(--border);border-bottom:none;padding:1.6rem 1.5rem;display:flex;gap:1.1rem;align-items:flex-start;transition:border-color .2s}
    .info-card:last-child{border-bottom:1px solid var(--border)}
    .info-card:hover{border-color:var(--gold)}
    .info-card i{font-size:1.1rem;color:var(--gold);margin-top:.2rem;min-width:20px}
    .info-card h3{font-family:var(--display);font-size:1rem;color:var(--cream);margin-bottom:.25rem}
    .info-card p{font-size:.87rem;margin:0}
    .info-card a{color:var(--muted);font-size:.87rem;transition:color .2s}
    .info-card a:hover{color:var(--gold)}
    .info-card a.wa:hover{color:#25d366}
    .hours-box{background:var(--card-bg);border:1px solid var(--border);padding:1.4rem 1.5rem;margin-top:1.2rem}
    .hours-box h3{font-family:var(--display);font-size:1rem;color:var(--cream);margin-bottom:.8rem}
    .hour-row{display:flex;justify-content:space-between;font-size:.85rem;padding:.28rem 0;border-bottom:1px solid var(--border);color:var(--muted)}
    .hour-row:last-child{border-bottom:none}
    .hour-row span:last-child{color:var(--cream)}
    footer{padding:2.5rem 4% 2rem;text-align:center;border-top:1px solid var(--border)}
    .footer-cols{display:grid;grid-template-columns:1fr 1fr;gap:2rem;text-align:left;max-width:700px;margin:0 auto 2rem}
    .footer-cols strong{font-family:var(--display);color:var(--gold);display:block;margin-bottom:.5rem}
    .footer-cols p{font-size:.88rem}
    .copy{font-size:.75rem;letter-spacing:1px;color:var(--muted)}
    @media(max-width:820px){.contact-wrap{grid-template-columns:1fr}}
    @media(max-width:560px){.logo-bar img{width:100%;height:auto}.footer-cols{grid-template-columns:1fr;text-align:center}}
  </style>
</head>
<body>

<nav>
  <div class="nav-links" style="display:flex">
    <li><a href="Home.php">Home</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php" class="active">Contact</a></li>
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

<section class="page-hero">
  <div class="section-label">Get in Touch</div>
  <h1>Contact Us</h1>
  <p>Have a question about a vendor, an order, or BuyHub in general? We're always happy to hear from you.</p>
</section>

<div class="dash-line"></div>

<div class="contact-wrap">

  <div class="form-box">
    <h2>Send Us a Message</h2>
    <div class="alert" id="form-alert"></div>

    <?php if(isLoggedIn()): ?>
    <!-- Pre-fill if logged in -->
    <script>
      window._prefillName  = "<?= userName() ?>";
      window._prefillEmail = "<?= userEmail() ?>";
    </script>
    <?php endif; ?>

    <div class="field">
      <label>Full Name</label>
      <div class="field-inner">
        <i class="fa-solid fa-user"></i>
        <input type="text" id="c-name" placeholder="Your full name">
      </div>
      <div class="field-msg" id="msg-name"></div>
    </div>

    <div class="field">
      <label>Email Address</label>
      <div class="field-inner">
        <i class="fa-solid fa-envelope"></i>
        <input type="email" id="c-email" placeholder="you@example.com">
      </div>
      <div class="field-msg" id="msg-email"></div>
    </div>

    <div class="field">
      <label>Phone (optional)</label>
      <div class="field-inner">
        <i class="fa-solid fa-phone"></i>
        <input type="tel" id="c-phone" placeholder="+233 XX XXX XXXX">
      </div>
    </div>

    <div class="field">
      <label>Subject</label>
      <div class="field-inner">
        <i class="fa-solid fa-tag"></i>
        <select id="c-subject" onchange="this.classList.add('filled')">
          <option value="" disabled selected>Select a topic</option>
          <option>Order Inquiry</option>
          <option>Vendor Question</option>
          <option>Returns &amp; Refunds</option>
          <option>Product Question</option>
          <option>Delivery Issue</option>
          <option>Account Help</option>
          <option>Become a Vendor</option>
          <option>Other</option>
        </select>
      </div>
      <div class="field-msg" id="msg-subject"></div>
    </div>

    <div class="field">
      <label>Message</label>
      <div class="field-inner area">
        <i class="fa-solid fa-comment"></i>
        <textarea id="c-message" placeholder="Tell us how we can help…"></textarea>
      </div>
      <div class="field-msg" id="msg-message"></div>
    </div>

    <button class="btn" id="send-btn" onclick="sendMessage()">
      Send Message &nbsp;<i class="fa-solid fa-paper-plane" style="font-size:.75rem"></i>
    </button>
  </div>

  <div>
    <div class="info-box">
      <div class="info-card">
        <i class="fa-solid fa-envelope"></i>
        <div><h3>Email</h3><a href="mailto:info@buyhub.com">info@buyhub.com</a></div>
      </div>
      <div class="info-card">
        <i class="fa-solid fa-phone"></i>
        <div><h3>Phone</h3><a href="tel:+233552391385">+233 55 239 1385</a></div>
      </div>
      <div class="info-card">
        <i class="fa-brands fa-whatsapp"></i>
        <div><h3>WhatsApp</h3>
          <a class="wa" href="https://wa.me/233552391385?text=Hi BuyHub, I have a question." target="_blank">Chat with us</a>
        </div>
      </div>
      <div class="info-card">
        <i class="fa-solid fa-location-dot"></i>
        <div><h3>Location</h3><p>Koforidua, Eastern Region<br>Ghana</p></div>
      </div>
      <div class="info-card">
        <i class="fa-solid fa-share-nodes"></i>
        <div><h3>Follow Us</h3>
          <p><a href="#">Facebook</a> &nbsp;·&nbsp; <a href="#">Instagram</a> &nbsp;·&nbsp; <a href="#">Twitter</a></p>
        </div>
      </div>
    </div>

    <div class="hours-box">
      <h3>Business Hours</h3>
      <div class="hour-row"><span>Monday – Friday</span><span>8:00 am – 6:00 pm</span></div>
      <div class="hour-row"><span>Saturday</span><span>9:00 am – 4:00 pm</span></div>
      <div class="hour-row"><span>Sunday</span><span>Closed</span></div>
    </div>
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

<script>
// Pre-fill if logged in
window.addEventListener('DOMContentLoaded', () => {
  if (window._prefillName)  document.getElementById('c-name').value  = window._prefillName;
  if (window._prefillEmail) document.getElementById('c-email').value = window._prefillEmail;
});

function setErr(inputId, msgId, msg) {
  const el = document.getElementById(inputId);
  const m  = document.getElementById(msgId);
  el.classList.add('err','shake');
  el.addEventListener('animationend', () => el.classList.remove('shake'), { once:true });
  if (m) { m.textContent = msg; m.className = 'field-msg show'; }
}
function clearErrs() {
  document.querySelectorAll('.field input,.field select,.field textarea').forEach(el => el.classList.remove('err'));
  document.querySelectorAll('.field-msg').forEach(m => m.className = 'field-msg');
  document.getElementById('form-alert').className = 'alert';
}
function showAlert(msg, type, icon) {
  const el = document.getElementById('form-alert');
  el.innerHTML = `<i class="fa-solid ${icon}"></i> ${msg}`;
  el.className = `alert show ${type}`;
  el.scrollIntoView({ behavior:'smooth', block:'nearest' });
}

// ── Send message → saves to MySQL via backend ──
async function sendMessage() {
  clearErrs();
  const name    = document.getElementById('c-name').value.trim();
  const email   = document.getElementById('c-email').value.trim();
  const subject = document.getElementById('c-subject').value;
  const message = document.getElementById('c-message').value.trim();
  const btn     = document.getElementById('send-btn');
  let valid     = true;

  if (!name)    { setErr('c-name','msg-name','Please enter your full name.'); valid=false; }
  if (!email)   { setErr('c-email','msg-email','Email address is required.'); valid=false; }
  else if (!/\S+@\S+\.\S+/.test(email)) { setErr('c-email','msg-email','Enter a valid email address.'); valid=false; }
  if (!subject) { setErr('c-subject','msg-subject','Please select a subject.'); valid=false; }
  if (message.length < 10) { setErr('c-message','msg-message','Message is too short — please add more detail.'); valid=false; }

  if (!valid) {
    showAlert('Please fix the errors above before sending.','error','fa-circle-exclamation');
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending…';

  const body = new FormData();
  body.append('name', name);
  body.append('email', email);
  body.append('subject', subject);
  body.append('message', message);

  try {
    const res  = await fetch('backend/contact.php', { method:'POST', body });
    const data = await res.json();

    if (data.success) {
      showAlert(data.message, 'success', 'fa-circle-check');
      // Reset form
      document.getElementById('c-name').value    = '';
      document.getElementById('c-email').value   = '';
      document.getElementById('c-phone').value   = '';
      document.getElementById('c-subject').selectedIndex = 0;
      document.getElementById('c-subject').classList.remove('filled');
      document.getElementById('c-message').value = '';
    } else {
      showAlert(data.message, 'error', 'fa-circle-exclamation');
    }
  } catch(e) {
    showAlert('Network error. Make sure the server is running.', 'error', 'fa-circle-exclamation');
  }

  btn.disabled = false;
  btn.innerHTML = 'Send Message &nbsp;<i class="fa-solid fa-paper-plane" style="font-size:.75rem"></i>';
}

document.querySelectorAll('.field input, .field select').forEach(el => {
  el.addEventListener('keydown', e => { if (e.key === 'Enter') sendMessage(); });
});
</script>
</body>
</html>
