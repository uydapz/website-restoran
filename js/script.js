const slides = document.querySelector(".slides");
const slide = document.querySelectorAll(".slide");
const prev = document.querySelector(".prev");
const next = document.querySelector(".next");

let index = 0;

function showSlide(i) {
  index = (i + slide.length) % slide.length; // Loop slides
  slides.style.transform = `translateX(${-index * 100}%)`;
}

prev.addEventListener("click", () => showSlide(index - 1));
next.addEventListener("click", () => showSlide(index + 1));

//leaflet
var map = L.map("map").setView([-7.973170, 112.618338], 16); 

// Add Tile Layer
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 18,
  attribution: "© OpenStreetMap contributors",
}).addTo(map);

// Add Marker
var marker = L.marker([-7.973170, 112.618338]).addTo(map); 
marker.bindPopup("<b>Eat Another</b>").openPopup();

function toggleMenu() {
  const menu = document.querySelector('nav ul');
  menu.classList.toggle('active');
}


