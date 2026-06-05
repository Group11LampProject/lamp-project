// login.js
// Handles login form, register form, and toggling between them.

const API = '/LAMPAPI'; // base path for all PHP endpoints

// --- Section toggle ---
const sectionLogin    = document.getElementById('section-login');
const sectionRegister = document.getElementById('section-register');

document.getElementById('link-show-register').addEventListener('click', (e) => {
  e.preventDefault();
  sectionLogin.classList.add('hidden');
  sectionRegister.classList.remove('hidden');
});

document.getElementById('link-show-login').addEventListener('click', (e) => {
  e.preventDefault();
  sectionRegister.classList.add('hidden');
  sectionLogin.classList.remove('hidden');
});

// If page loaded with #register hash, show register section
if (window.location.hash === '#register') {
  sectionLogin.classList.add('hidden');
  sectionRegister.classList.remove('hidden');
}

// --- Login ---
document.getElementById('btn-login').addEventListener('click', async () => {
  const email    = document.getElementById('login-email').value.trim();
  const password = document.getElementById('login-password').value;
  const errorEl  = document.getElementById('login-error');
  errorEl.classList.add('hidden');

  // TODO: replace with real fetch
  const response = await fetch(`${API}/Login.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ login: email, password: password })
  });
  const data = await response.json();

  if (data.error !== '') {
    errorEl.classList.remove('hidden');
    return;
  }

  // Store user info and redirect
  sessionStorage.setItem('user', JSON.stringify(data));
  window.location.href = 'contacts.html';
});

// --- Register ---
document.getElementById('btn-register').addEventListener('click', async () => {
  const firstName = document.getElementById('reg-firstname').value.trim();
  const lastName  = document.getElementById('reg-lastname').value.trim();
  const email     = document.getElementById('reg-email').value.trim();
  const password  = document.getElementById('reg-password').value;
  const confirm   = document.getElementById('reg-confirm').value;
  const matchErr  = document.getElementById('reg-match-error');
  const errorEl   = document.getElementById('register-error');
  const successEl = document.getElementById('register-success');

  matchErr.classList.add('hidden');
  errorEl.classList.add('hidden');
  successEl.classList.add('hidden');

  if (password !== confirm) {
    matchErr.classList.remove('hidden');
    return;
  }

  // TODO: replace with real fetch
  const response = await fetch(`${API}/Register.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ firstName, lastName, login: email, password })
  });
  const data = await response.json();

  if (data.error !== '') {
    errorEl.textContent = data.error;
    errorEl.classList.remove('hidden');
    return;
  }

  successEl.classList.remove('hidden');
  setTimeout(() => {
    sectionRegister.classList.add('hidden');
    sectionLogin.classList.remove('hidden');
  }, 1500);
});
