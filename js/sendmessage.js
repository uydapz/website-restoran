function sendMessage(event) {
  event.preventDefault(); // Mencegah form submit biasa

  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const message = document.getElementById("message").value;

  // Membuat pesan yang akan dikirim
  const waMessage = `Name: ${name}\nEmail: ${email}\nMessage: ${message}`;

  // URL WhatsApp API untuk mengirim pesan
  const phoneNumber = "6282141331105";
  const waURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(
    waMessage
  )}`;

  // Redirect ke URL WhatsApp
  window.location.href = waURL;
}
