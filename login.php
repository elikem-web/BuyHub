<?php
require_once 'backend/session.php';
if (isLoggedIn()) { header('Location: Home.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BuyHub — Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--black:#000;--gold:#c8922a;--gold-light:#e7b94f;--cream:#f3ece1;--muted:#997a3a;--card-bg:#0d0d0d;--border:#2a1f0a;--display:'Playfair Display',serif;--body:'Jost',sans-serif}
    html{scroll-behavior:smooth;font-size:20px}
    body{background:var(--black);color:var(--cream);font-family:var(--body);font-size:1rem;line-height:1.7;min-height:100vh}
    a{color:var(--gold);text-decoration:none}
    h1,h2,h3{font-family:var(--display);font-weight:600}
    p{color:var(--muted)}
    nav{display:flex;align-items:center;justify-content:space-between;padding:1rem 4%;border-bottom:1px solid var(--border);position:sticky;top:0;background:var(--black);z-index:100}
    .nav-links{display:flex;gap:2rem;list-style:none}
    .nav-links a{font-size:.75rem;letter-spacing:2px;text-transform:uppercase;color:var(--gold);transition:color .2s}
    .nav-links a:hover,.nav-links a.active{color:var(--gold-light);border-bottom:1px solid var(--gold-light)}
    .nav-icons{display:flex;gap:1.2rem;font-size:1rem;align-items:center}
    .nav-icons a{color:var(--gold);transition:color .2s;position:relative}
    .cart-badge{position:absolute;top:-7px;right:-9px;background:var(--gold);color:var(--black);font-size:.55rem;font-weight:700;width:16px;height:16px;border-radius:50%;display:none;align-items:center;justify-content:center}
    .logo-bar{text-align:center;padding:2rem 4% 0}
    .logo-bar img{width:600px;height:110px;object-fit:contain;display:block;margin:0 auto}
    .dash-line{height:1px;width:100%;background:repeating-linear-gradient(to right,var(--gold) 0,var(--gold) 8px,transparent 8px,transparent 20px);opacity:.3;margin:2rem 0}
    .tab-bar{display:flex;max-width:960px;margin:0 auto;border-bottom:1px solid var(--border)}
    .tab-btn{flex:1;text-align:center;padding:.85rem;font-size:.7rem;letter-spacing:2px;text-transform:uppercase;color:var(--muted);cursor:pointer;border:none;border-bottom:2px solid transparent;background:none;font-family:var(--body);transition:color .2s,border-color .2s}
    .tab-btn.active{color:var(--gold);border-bottom-color:var(--gold)}
    .auth-wrap{display:none;max-width:960px;margin:0 auto 5rem;border:1px solid var(--border);border-top:none}
    .auth-wrap.visible{display:grid;grid-template-columns:1fr 1fr}
    .auth-left{background:var(--card-bg);padding:3rem 2.8rem;display:flex;flex-direction:column;justify-content:center;border-right:1px solid var(--border)}
    .auth-right{background:#060606;padding:3rem 2.8rem;display:flex;flex-direction:column;justify-content:center}
    .panel-label{font-size:.66rem;letter-spacing:3px;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem}
    .auth-left h1{font-style:italic;font-size:clamp(1.4rem,2.5vw,1.9rem);margin-bottom:.5rem}
    .auth-left>p,.auth-right>p{margin-bottom:2rem;font-size:.88rem}
    .auth-right h2{font-size:1.3rem;font-style:italic;margin-bottom:.5rem}
    .field{margin-bottom:1.2rem}
    .field label{display:block;font-size:.68rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);margin-bottom:.35rem}
    .field-inner{position:relative}
    .field-inner i.icon{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);font-size:.8rem;color:var(--muted);pointer-events:none}
    .field-inner .toggle-pw{position:absolute;right:.85rem;top:50%;transform:translateY(-50%);font-size:.8rem;color:var(--muted);cursor:pointer;transition:color .2s}
    .field-inner .toggle-pw:hover{color:var(--gold)}
    .field input{width:100%;background:#080808;border:1px solid var(--border);color:var(--cream);font-family:var(--body);font-size:.88rem;padding:.7rem .9rem .7rem 2.3rem;outline:none;transition:border-color .2s}
    .field input::placeholder{color:var(--muted)}
    .field input:focus{border-color:var(--gold)}
    .field input.field-error{border-color:#c0392b}
    .field-msg{font-size:.68rem;margin-top:.3rem;color:#c0392b;display:none}
    .field-msg.show{display:block}
    @keyframes shake{0%,100%{transform:translateX(0)}20%,60%{transform:translateX(-5px)}40%,80%{transform:translateX(5px)}}
    .shake{animation:shake .35s}
    .strength-wrap{margin-top:.4rem;display:flex;align-items:center;gap:.6rem}
    .strength-bar{flex:1;height:3px;background:var(--border);border-radius:2px;overflow:hidden}
    .strength-fill{height:100%;width:0;transition:width .3s,background .3s}
    .strength-label{font-size:.62rem;color:var(--muted);width:45px;text-align:right}
    .alert{padding:.65rem .9rem;font-size:.76rem;margin-bottom:1rem;display:none;border-left:3px solid;line-height:1.5}
    .alert.show{display:block}
    .alert.success{background:rgba(39,174,96,.1);border-color:#27ae60;color:#27ae60}
    .alert.error{background:rgba(192,57,43,.1);border-color:#c0392b;color:#c0392b}
    .btn{display:block;width:100%;text-align:center;font-family:var(--body);font-size:.76rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:.85rem;border:1px solid var(--gold);background:var(--gold);color:var(--black);cursor:pointer;transition:background .25s,transform .25s}
    .btn:hover:not(:disabled){background:var(--gold-light);transform:translateY(-2px)}
    .btn:disabled{opacity:.65;cursor:not-allowed}
    .btn-ghost{background:transparent;color:var(--gold)}
    .btn-ghost:hover{background:var(--gold);color:var(--black)}
    .forgot{font-size:.7rem;color:var(--muted);text-align:right;display:block;margin:-0.5rem 0 1.2rem;transition:color .2s}
    .forgot:hover{color:var(--gold)}
    .perks{list-style:none;margin-bottom:2rem;display:flex;flex-direction:column;gap:.7rem}
    .perks li{display:flex;align-items:center;gap:.6rem;font-size:.83rem;color:var(--muted)}
    .perks li i{color:var(--gold);font-size:.72rem;width:14px;flex-shrink:0}
    footer{padding:2rem 4%;text-align:center;border-top:1px solid var(--border)}
    .copy{font-size:.7rem;letter-spacing:1px;color:var(--muted)}
    @media(max-width:720px){.auth-wrap.visible{grid-template-columns:1fr}.auth-left{border-right:none;border-bottom:1px solid var(--border)}.logo-bar img{width:100%;height:auto}}
  </style>
</head>
<body>

<nav>
  <div class="nav-links" style="display:flex">
    <li><a href="Home.php">Home</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
    <li><a href="login.php" class="active">Login</a></li>
  </div>
  <div class="nav-icons">
    <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i><span class="cart-badge">0</span></a>
    <a href="login.php"><i class="fa-solid fa-user"></i></a>
  </div>
</nav>

<div class="logo-bar"><img src="ogo1.jpg" alt="BuyHub" onerror="this.style.display='none'"></div>
<div class="dash-line"></div>

<div class="tab-bar">
  <button class="tab-btn active" data-tab="login">Sign In</button>
  <button class="tab-btn" data-tab="register">Create Account</button>
</div>

<!-- LOGIN -->
<div class="auth-wrap visible" id="panel-login">
  <div class="auth-left">
    <div class="panel-label">Welcome Back</div>
    <h1>Sign In to BuyHub</h1>
    <p>Access your cart, orders, and exclusive deals from our vendors.</p>
    <div class="alert" id="login-alert"></div>
    <div class="field">
      <label>Email Address</label>
      <div class="field-inner">
        <i class="icon fa-solid fa-envelope"></i>
        <input type="email" id="l-email" placeholder="you@example.com" autocomplete="email">
      </div>
      <div class="field-msg" id="l-email-msg"></div>
    </div>
    <div class="field">
      <label>Password</label>
      <div class="field-inner">
        <i class="icon fa-solid fa-lock"></i>
        <input type="password" id="l-password" placeholder="••••••••" autocomplete="current-password">
        <i class="toggle-pw fa-solid fa-eye" onclick="togglePw('l-password',this)"></i>
      </div>
      <div class="field-msg" id="l-pw-msg"></div>
    </div>
    <a href="#" class="forgot">Forgot your password?</a>
    <button class="btn" id="l-btn" onclick="handleLogin()">
      Sign In &nbsp;<i class="fa-solid fa-arrow-right" style="font-size:.78rem"></i>
    </button>
  </div>
  <div class="auth-right">
    <div class="panel-label">New Here?</div>
    <h2>Join BuyHub Today</h2>
    <p>Create a free account to start shopping from our trusted vendors.</p>
    <ul class="perks">
      <li><i class="fa-solid fa-check"></i> 20% off your first order</li>
      <li><i class="fa-solid fa-check"></i> Exclusive member deals</li>
      <li><i class="fa-solid fa-check"></i> Browse all 4 vendor categories</li>
      <li><i class="fa-solid fa-check"></i> Contact vendors directly to buy</li>
    </ul>
    <button class="btn btn-ghost" onclick="switchTab('register')">Create an Account</button>
  </div>
</div>

<!-- REGISTER -->
<div class="auth-wrap" id="panel-register">
  <div class="auth-left">
    <div class="panel-label">New Account</div>
    <h1>Create Your Account</h1>
    <p>Join thousands of shoppers on BuyHub across Ghana.</p>
    <div class="alert" id="reg-alert"></div>
    <div class="field">
      <label>Full Name</label>
      <div class="field-inner">
        <i class="icon fa-solid fa-user"></i>
        <input type="text" id="r-name" placeholder="Your full name" autocomplete="name">
      </div>
      <div class="field-msg" id="r-name-msg"></div>
    </div>
    <div class="field">
      <label>Email Address</label>
      <div class="field-inner">
        <i class="icon fa-solid fa-envelope"></i>
        <input type="email" id="r-email" placeholder="you@example.com" autocomplete="email">
      </div>
      <div class="field-msg" id="r-email-msg"></div>
    </div>
    <div class="field">
      <label>Password</label>
      <div class="field-inner">
        <i class="icon fa-solid fa-lock"></i>
        <input type="password" id="r-password" placeholder="Min. 8 characters" oninput="checkStrength(this.value)" autocomplete="new-password">
        <i class="toggle-pw fa-solid fa-eye" onclick="togglePw('r-password',this)"></i>
      </div>
      <div class="strength-wrap">
        <div class="strength-bar"><div class="strength-fill" id="s-fill"></div></div>
        <div class="strength-label" id="s-label"></div>
      </div>
      <div class="field-msg" id="r-pw-msg"></div>
    </div>
    <div class="field">
      <label>Confirm Password</label>
      <div class="field-inner">
        <i class="icon fa-solid fa-lock"></i>
        <input type="password" id="r-confirm" placeholder="Repeat your password" autocomplete="new-password">
        <i class="toggle-pw fa-solid fa-eye" onclick="togglePw('r-confirm',this)"></i>
      </div>
      <div class="field-msg" id="r-conf-msg"></div>
    </div>
    <button class="btn" id="r-btn" onclick="handleRegister()">
      Create Account &nbsp;<i class="fa-solid fa-arrow-right" style="font-size:.78rem"></i>
    </button>
  </div>
  <div class="auth-right">
    <div class="panel-label">Already a Member?</div>
    <h2>Welcome Back</h2>
    <p>Sign in to access your saved cart and connect with our vendors.</p>
    <ul class="perks">
      <li><i class="fa-solid fa-check"></i> Your cart saved to your account</li>
      <li><i class="fa-solid fa-check"></i> Faster checkout every time</li>
      <li><i class="fa-solid fa-check"></i> Direct vendor WhatsApp links</li>
    </ul>
    <button class="btn btn-ghost" onclick="switchTab('login')">Sign In Instead</button>
  </div>
</div>

<footer><p class="copy">&copy; 2026 BuyHub. All rights reserved.</p></footer>

<script>
function switchTab(tab) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.auth-wrap').forEach(p => p.classList.remove('visible'));
  document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
  document.getElementById(`panel-${tab}`).classList.add('visible');
  clearAlerts();
}
document.querySelectorAll('.tab-btn').forEach(b => b.addEventListener('click', () => switchTab(b.dataset.tab)));

function showAlert(id, msg, type) {
  const el = document.getElementById(id);
  el.textContent = msg; el.className = `alert show ${type}`;
}
function clearAlerts() {
  document.querySelectorAll('.alert').forEach(a => a.className = 'alert');
  document.querySelectorAll('.field-msg').forEach(m => m.className = 'field-msg');
  document.querySelectorAll('.field input').forEach(i => i.classList.remove('field-error','shake'));
}
function fieldErr(inputId, msgId, msg) {
  const inp = document.getElementById(inputId);
  const mel = document.getElementById(msgId);
  inp.classList.add('field-error');
  inp.classList.remove('shake'); void inp.offsetWidth; inp.classList.add('shake');
  if (mel) { mel.textContent = msg; mel.className = 'field-msg show'; }
  inp.focus();
}
function togglePw(id, icon) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  icon.classList.toggle('fa-eye'); icon.classList.toggle('fa-eye-slash');
}
function checkStrength(val) {
  const fill = document.getElementById('s-fill');
  const lbl  = document.getElementById('s-label');
  let score  = 0;
  if (val.length >= 8)          score++;
  if (/[A-Z]/.test(val))        score++;
  if (/[0-9]/.test(val))        score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const colors = ['#c0392b','#e67e22','#f1c40f','#27ae60'];
  const labels = ['Weak','Fair','Good','Strong'];
  fill.style.width      = (score * 25) + '%';
  fill.style.background = score ? colors[score-1] : '';
  lbl.textContent       = score ? labels[score-1] : '';
  lbl.style.color       = score ? colors[score-1] : '';
}

// ── REAL LOGIN (hits PHP backend → MySQL) ──
async function handleLogin() {
  clearAlerts();
  const email = document.getElementById('l-email').value.trim();
  const pw    = document.getElementById('l-password').value;
  const btn   = document.getElementById('l-btn');
  let ok = true;

  if (!email)                      { fieldErr('l-email','l-email-msg','Email is required.'); ok=false; }
  else if (!/\S+@\S+\.\S+/.test(email)) { fieldErr('l-email','l-email-msg','Enter a valid email.'); ok=false; }
  if (!pw)                         { fieldErr('l-password','l-pw-msg','Password is required.'); ok=false; }
  if (!ok) return;

  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Signing in…';

  const body = new FormData();
  body.append('email', email); body.append('password', pw);

  try {
    const res  = await fetch('backend/login.php', { method:'POST', body });
    const data = await res.json();
    if (data.success) {
      showAlert('login-alert', data.message, 'success');
      setTimeout(() => window.location.href = data.redirect, 700);
    } else {
      showAlert('login-alert', data.message, 'error');
      btn.disabled = false;
      btn.innerHTML = 'Sign In &nbsp;<i class="fa-solid fa-arrow-right" style="font-size:.78rem"></i>';
    }
  } catch(e) {
    showAlert('login-alert','Network error. Make sure the server is running.','error');
    btn.disabled = false;
    btn.innerHTML = 'Sign In &nbsp;<i class="fa-solid fa-arrow-right" style="font-size:.78rem"></i>';
  }
}

// ── REAL REGISTER (hits PHP backend → MySQL) ──
async function handleRegister() {
  clearAlerts();
  const name    = document.getElementById('r-name').value.trim();
  const email   = document.getElementById('r-email').value.trim();
  const pw      = document.getElementById('r-password').value;
  const confirm = document.getElementById('r-confirm').value;
  const btn     = document.getElementById('r-btn');
  let ok = true;

  if (!name)                       { fieldErr('r-name','r-name-msg','Full name is required.'); ok=false; }
  if (!email)                      { fieldErr('r-email','r-email-msg','Email is required.'); ok=false; }
  else if (!/\S+@\S+\.\S+/.test(email)) { fieldErr('r-email','r-email-msg','Enter a valid email.'); ok=false; }
  if (pw.length < 8)               { fieldErr('r-password','r-pw-msg','Password must be at least 8 characters.'); ok=false; }
  if (pw !== confirm)              { fieldErr('r-confirm','r-conf-msg','Passwords do not match.'); ok=false; }
  if (!ok) return;

  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating account…';

  const body = new FormData();
  body.append('name',name); body.append('email',email);
  body.append('password',pw); body.append('confirm',confirm);

  try {
    const res  = await fetch('backend/register.php', { method:'POST', body });
    const data = await res.json();
    if (data.success) {
      showAlert('reg-alert', data.message, 'success');
      setTimeout(() => window.location.href = data.redirect, 700);
    } else {
      showAlert('reg-alert', data.message, 'error');
      btn.disabled = false;
      btn.innerHTML = 'Create Account &nbsp;<i class="fa-solid fa-arrow-right" style="font-size:.78rem"></i>';
    }
  } catch(e) {
    showAlert('reg-alert','Network error. Make sure the server is running.','error');
    btn.disabled = false;
    btn.innerHTML = 'Create Account &nbsp;<i class="fa-solid fa-arrow-right" style="font-size:.78rem"></i>';
  }
}

document.addEventListener('keydown', e => {
  if (e.key !== 'Enter') return;
  document.getElementById('panel-login').classList.contains('visible') ? handleLogin() : handleRegister();
});
</script>
</body>
</html>
