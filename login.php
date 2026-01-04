<?php
include 'connector.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil input dari form
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data user
        $user = $result->fetch_assoc();

        // Verifikasi password
        if ($password == $user["password"]) {
            $_SESSION["username"] = $user["username"];
            // Redirect ke dashboard jika login berhasil
            header("Location: dashboard.php");
            exit();
        } else {
            // Redirect dengan pesan kesalahan password
            header("Location: login.php?error=password_salah");
        }
    } else {
        // Redirect dengan pesan kesalahan username
        header("Location: login.php?error=username_tidak_ditemukan");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container">
            <h1 class="logo">Eat Another - Login</h1>
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
                <input type="text" id="username" name="username" placeholder="Username" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">
                <input type="password" id="password" name="password" placeholder="Password" required style="padding: 0.75rem; background-color:rgba(255, 255, 255, 0); border:none; border-bottom:1px solid #000;">

                <!-- Menampilkan pesan error jika ada -->
                <?php if (isset($_GET['error'])): ?>
                    <div style="color: red; font-size: 1rem; margin-top: 1rem;">
                        <?php
                        if ($_GET['error'] == 'password_salah') {
                            echo "Password salah!";
                        } elseif ($_GET['error'] == 'username_tidak_ditemukan') {
                            echo "Username tidak ditemukan!";
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <div style="display: flex; gap: 1rem; margin-top: auto;">
                    <a style="display: inline-block; padding: 1rem 2rem; background-color:rgb(131, 131, 131); color: #fff; text-decoration: none; border: 5px;" href="register.php">Register!</a>
                    <button type="submit" style="display: inline-block; padding: 1rem 2rem; background-color:rgb(58, 58, 58); color: #fff; text-decoration: none; border-radius: 5px;">Login!</button>
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