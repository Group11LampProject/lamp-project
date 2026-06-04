// index.js
// Redirect to contacts.html if user is already logged in.

const user = sessionStorage.getItem('user');
if (user) {
  window.location.href = 'contacts.html';
}
