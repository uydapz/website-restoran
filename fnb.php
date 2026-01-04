<?php
include 'connector.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Variabel untuk pesan alert
$alertMessage = '';
$alertType = ''; // success atau error

// Proses menambah menu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_menu'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = intval($_POST['price']);
    $category = $_POST['category'];
    $stock = (int) $_POST['stock'];

    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];

    if ($imageError === 0) {
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExt, $allowedExts)) {
            if ($imageSize < 5000000) {
                $newImageName = uniqid('', true) . "." . $imageExt;
                $imageUploadPath = __DIR__ . '/images/menu/' . $newImageName;

                if (move_uploaded_file($imageTmpName, $imageUploadPath)) {
                    $stmt = $conn->prepare("INSERT INTO menu (title, description, price, category, stock, image) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssisis", $title, $description, $price, $category, $stock, $newImageName);

                    if ($stmt->execute()) {
                        $_SESSION['alertMessage'] = "New menu added successfully!";
                        $_SESSION['alertType'] = "success";
                    } else {
                        $_SESSION['alertMessage'] = "Error: " . $stmt->error;
                        $_SESSION['alertType'] = "error";
                    }
                    $stmt->close();
                    // Redirect to avoid form re-submission on refresh
                    header('Location: fnb.php');
                    exit();
                } else {
                    $_SESSION['alertMessage'] = "Error uploading image.";
                    $_SESSION['alertType'] = "error";
                }
            } else {
                $_SESSION['alertMessage'] = "Image size is too large. Max 5MB.";
                $_SESSION['alertType'] = "error";
            }
        } else {
            $_SESSION['alertMessage'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            $_SESSION['alertType'] = "error";
        }
    } else {
        $_SESSION['alertMessage'] = "Error uploading file.";
        $_SESSION['alertType'] = "error";
    }
}

// Menampilkan data menu
$menu = "SELECT * FROM menu";
$menuc = $conn->query($menu);

if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        $_SESSION['alertMessage'] = "Menu deleted successfully!";
        $_SESSION['alertType'] = "success";
    } else {
        $_SESSION['alertMessage'] = "Error: Unable to delete menu.";
        $_SESSION['alertType'] = "error";
    }
    $stmt->close();
    // Redirect untuk mencegah penghapusan ganda
    header('Location: fnb.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu F&B</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/fnb.css">
</head>

<body>
<header>
        <div class="container">
            <h1 class="logo">Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <h3>F&B Area</h3>
            <ul>
                <li><a href="dashboard.php">Analytics</a></li>
                <li><a href="stat.php">Statistics</a></li>
                <li><a href="fnb.php" style="background-color:#d3d3d3; border-radius:12px; color:#000;">F&B Menu</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </aside>

        <main class="content">
            <?php if (isset($_SESSION['alertMessage'])): ?>
                <div class="alert <?php echo $_SESSION['alertType'] === 'success' ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo $_SESSION['alertMessage']; ?>
                </div>
                <?php unset($_SESSION['alertMessage'], $_SESSION['alertType']); ?>
            <?php endif; ?>

            <!-- Add New Menu Form -->
            <div class="card">
                <h2>Add New Menu</h2>
                <form action="fnb.php" method="POST" enctype="multipart/form-data">
                    <label for="title">Menu Name</label>
                    <input type="text" id="title" name="title" required>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>

                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" required step="1">

                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" required>

                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" required>

                    <label for="image">Upload Image</label>
                    <input type="file" id="image" name="image" required>

                    <button type="submit" name="add_menu">Add Menu</button>
                </form>
            </div>

            <!-- Menu Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($menuc->num_rows > 0) {
                            while ($row = $menuc->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['title']}</td>
                                        <td>{$row['description']}</td>
                                        <td>{$row['price']}</td>
                                        <td>{$row['category']}</td>
                                        <td>{$row['stock']}</td>
                                        <td><img src='images/menu/{$row['image']}' alt='Image' style='width: 100px; height: auto;'></td>
                                        <td>
                                            <a href='edit_menu.php?id={$row['id']}'>Edit</a> | 
                                            <a href='fnb.php?delete_id={$row['id']}'>Delete</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No menu found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; Copyfight 2024 Uydapz</p>
    </footer>
</body>

</html>
