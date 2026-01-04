fetch("api.php")
  .then((response) => response.json())
  .then((data) => {
    const statsData = {
      labels: ["Total Menu", "Total Users"], // Label untuk grafik
      datasets: [
        {
          label: "Statistics",
          data: [data.totalMenu, data.totalUsers], // Data statistik
          backgroundColor: ["rgba(58, 58, 58, 0.6)", "rgba(58, 100, 200, 0.6)"], // Warna background bar
          borderColor: ["rgba(58, 58, 58, 1)", "rgba(58, 100, 200, 1)"], // Warna border
          borderWidth: 1,
        },
      ],
    };

    // Konfigurasi Chart.js
    const config = {
      type: "bar", // Tipe chart (bar chart)
      data: statsData,
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true, // Mulai dari 0 pada sumbu Y
          },
        },
      },
    };

    // Membuat chart
    const ctx = document.getElementById("totalMenuChart").getContext("2d");
    new Chart(ctx, config); // Render chart pada canvas
  })
  .catch((error) => {
    console.error("Error fetching data:", error);
  });
