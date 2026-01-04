<?php
include 'connector.php';  // Menyertakan koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil input dari form
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $alamat = $_POST["alamat"];
    $notelp = $_POST["notelp"];
    $namalengkap = $_POST["namalengkap"];
    $region = $_POST["region"];

    // Cek apakah username sudah ada di database
    $sql_check = "SELECT * FROM user WHERE username = '$username'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
    } else {
        // Jika username belum ada, insert data pengguna baru ke database
        $sql_insert = "INSERT INTO user (username, password, alamat, no_telepon, nama_lengkap, region) 
                       VALUES ('$username', '$password', '$alamat', '$notelp', '$namalengkap', '$region')";
        
        if ($conn->query($sql_insert) === TRUE) {
            echo "<script>alert('Registrasi berhasil!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan, coba lagi!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Another Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container">
            <h1 class="logo">Eat Another - Register</h1>
            <nav>
                <div class="hamburger" id="hamburger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="intro" style="display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; background-color: rgba(255, 255, 255, 0); padding: 6rem 2rem; text-align: left; color: #000; margin-top: 3rem;">
        <form action="" method="POST">
            <div style="flex: 1; max-width: 100%; padding-right: 3rem; display: flex; flex-direction: column; gap: 1rem;">
                <input type="text" name="username" placeholder="Username" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">
                <input type="password" name="password" placeholder="Password" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">
                <input type="text" name="alamat" placeholder="Alamat" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">
                <input type="number" name="notelp" placeholder="No Telepon" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">
                <input type="text" name="namalengkap" placeholder="Nama Lengkap" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">
                <input type="text" name="region" placeholder="Region" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">
                
                <div style="display: flex; gap: 1rem; margin-top: auto;">
                    <a style="display: inline-block; padding: 1rem 2rem; background-color:rgb(131, 131, 131); color: #fff; text-decoration: none; border: 5px;" href="login.php">Back!</a>
                    <button type="submit" style="display: inline-block; padding: 1rem 2rem; background-color:rgb(58, 58, 58); color: #fff; text-decoration: none; border-radius: 5px;">Register!</button>
                </div>
            </div>
        </form>
        <div style="flex: 1; max-width: 50%; display: flex; justify-content: center;">
            <img src="images/ind.png" alt="Restaurant Image" style="max-width: 50%; height: auto; object-fit: cover; border-radius: 8px;">
        </div>
    </section>

    <script src="js/script.js"></script>
    <script src="js/sendmessage.js"></script>
    <footer>
        <p>&copy; Copyfight! Uydapzone</p>
    </footer>
</body>

</html>
