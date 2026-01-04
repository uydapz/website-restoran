<?php
include 'connector.php';

$query = "SELECT * FROM menu";
$result = $conn->query($query);

// Store menu items in an array
$menuItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menuItems[] = $row;
    }
} else {
    echo "No menu items found.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eat Another - Fastfood Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <section id="intro" style="display: flex; align-items: center; justify-content: space-between; background-color: rgba(0, 0, 0, 0.5); padding: 6rem 2rem; text-align: left; color: white;">
        <div style="flex: 1; max-width: 50%; padding-right: 2rem;">
            <h1 style="font-size: 3rem; margin-bottom: 1rem;">Welcome to Eat Another</h1>
            <p style="font-size: 1.2rem; margin-bottom: 1.5rem;">Another place, Another eat.</p>
            <a href="#home" style="display: inline-block; padding: 1rem 2rem; background-color:rgb(58, 58, 58); color: white; text-decoration: none; border-radius: 5px;">SEE OUR MENU</a>
        </div>
        <div style="flex: 1; max-width: 50%; display: flex; justify-content: center;">
            <img src="images/ind.png" alt="Restaurant Image" style="max-width: 50%; height: auto; object-fit: cover; border-radius: 8px;">
        </div>
    </section>

    <header>
        <div class="container">
            <h1 class="logo">Eat Another - Fastfood Restaurant</h1>
            <nav>
                <div class="hamburger" id="hamburger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#owner">Owner</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="home" class="hero">
        <div class="slider">
            <div class="slides">
                <?php foreach ($menuItems as $item): ?>
                    <div class="slide">
                        <div class="menu-item">
                            <h3><?php echo htmlspecialchars($item['title']); ?> | <?php echo htmlspecialchars($item['category']); ?></h3>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            <img src="images/menu/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="slider-img">
                            <p>Rp. <?php echo number_format($item['price']); ?> | stock: <?php echo number_format($item['stock']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </section>


    <section id="owner" style="padding: 2rem; background-color: #f9f9f9;">
        <div class="container" style="display: flex; align-items: center; gap: 2rem;">
            <!-- Teks About Us -->
            <div style="flex: 1;">
                <h2 style="margin-bottom: 1rem;">Achmad Daffa - Owner</h2>
                <p>Setiap manusia memiliki pasangan, bahkan pasangan pun pernah berbohong tentang rasa. Namun rasa tak pernah berbohong kepada manusia.</p>
            </div>
            <!-- Gambar -->
            <div style="flex: 1; text-align: center;">
                <img src="images/dapa.jpg" alt="About Us Image" style="width: 100%; max-width: 400px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            </div>
        </div>
    </section>

    <section id="four-pillars" style="padding: 3rem 1rem; background-color: #f9f9f9;">
        <div class="container" style="text-align: center;">
            <h2 style="margin-bottom: 2rem;">Kami Mendahulukan</h2>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem;">
                <!-- Pilar 1 -->
                <div class="card" style="flex: 1; max-width: 300px; padding: 2rem; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                    <h3 style="margin-bottom: 1rem;">
                        <i class="fas fa-briefcase" style="margin-right: 10px; padding: 15px; background-color: #4CAF50; color: white; border-radius: 50%;"></i>
                    </h3>
                    <p>Berkomitmen untuk menjalankan tugas dengan kompetensi tinggi dan tanggung jawab.</p>
                </div>

                <!-- Pilar 2 -->
                <div class="card" style="flex: 1; max-width: 300px; padding: 2rem; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                    <h3 style="margin-bottom: 1rem;">
                        <i class="fas fa-handshake" style="margin-right: 10px; padding: 15px; background-color: #2196F3; color: white; border-radius: 50%;"></i>
                    </h3>
                    <p>Mengedepankan kejujuran, etika, dan prinsip moral yang kuat dalam setiap tindakan.</p>
                </div>

                <!-- Pilar 3 -->
                <div class="card" style="flex: 1; max-width: 300px; padding: 2rem; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                    <h3 style="margin-bottom: 1rem;">
                        <i class="fas fa-lightbulb" style="margin-right: 10px; padding: 15px; background-color: #FFEB3B; color: white; border-radius: 50%;"></i>
                    </h3>
                    <p>Selalu mencari cara baru dan kreatif untuk meningkatkan kualitas dan efisiensi.</p>
                </div>

                <!-- Pilar 4 -->
                <div class="card" style="flex: 1; max-width: 300px; padding: 2rem; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                    <h3 style="margin-bottom: 1rem;">
                        <i class="fas fa-headset" style="margin-right: 10px; padding: 15px; background-color: #FF5722; color: white; border-radius: 50%;"></i>
                    </h3>
                    <p>Mengutamakan kepuasan pelanggan dengan memberikan layanan terbaik.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" style="padding: 2rem;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 2rem;">
            <!-- Contact Form -->
            <div class="card" style="flex: 1; padding: 2rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <h2 style="margin-bottom: 1.5rem; text-align: center;">Contact Us</h2>
                <form id="contactForm" style="display: flex; flex-direction: column; gap: 1rem;" onsubmit="sendMessage(event)">
                    <input type="text" id="name" name="name" placeholder="Your Name" required style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                    <input type="email" id="email" name="email" placeholder="Your Email" required style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                    <textarea id="message" name="message" placeholder="Your Message" required style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                    <button type="submit" class="btn" style="padding: 0.75rem; background-color: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer;">Send Message</button>
                </form>
            </div>

            <!-- Map -->
            <div id="map" style="flex: 1; height: 400px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"></div>
        </div>
    </section>

    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script src="js/script.js"></script>
    <script src="js/sendmessage.js"></script>
    <footer>
        <p>&copy; Copyfight! Uydapzone</p>
    </footer>
</body>

</html>