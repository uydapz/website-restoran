<?php
include 'connector.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Get the menu ID from URL
if (isset($_GET['id'])) {
    $menuId = (int) $_GET['id'];

    // Fetch the current data from the database
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
    $stmt->bind_param("i", $menuId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $menu = $result->fetch_assoc();
    } else {
        header('Location: fnb.php');
        exit();
    }
    $stmt->close();
} else {
    header('Location: fnb.php');
    exit();
}

$alertMessage = '';
$alertType = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_menu'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = intval($_POST['price']);
    $category = $_POST['category'];
    $stock = (int) $_POST['stock'];
    $image = $_FILES['image'];

    // Handle image upload (if provided)
    if ($image['error'] === 0) {
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
                        // Update the menu with new image
                        $stmt = $conn->prepare("UPDATE menu SET title = ?, description = ?, price = ?, category = ?, stock = ?, image = ? WHERE id = ?");
                        $stmt->bind_param("ssdsisi", $title, $description, $price, $category, $stock, $newImageName, $menuId);
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
        }
    } else {
        // Update without changing image
        $stmt = $conn->prepare("UPDATE menu SET title = ?, description = ?, price = ?, category = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("ssdsii", $title, $description, $price, $category, $stock, $menuId);
    }

    // Execute the update query
    if ($stmt->execute()) {
        $_SESSION['alertMessage'] = "Menu updated successfully!";
        $_SESSION['alertType'] = "success";
        header("Location: fnb.php");  // Redirect after success
        exit();
    } else {
        $_SESSION['alertMessage'] = "Error: " . $stmt->error;
        $_SESSION['alertType'] = "error";
    }
    $stmt->close();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/fnb.css">
</head>

<body>
    <header>
        <div class="container">
            <h1 class="logo">Edit F&B Menu</h1>
            <nav>
                <ul>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="setting.php">Settings</a></li>
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
                <li><a href="fnb.php">F&B Menu</a></li>
                <li><a href="setting.php">Settings</a></li>
            </ul>
        </aside>

        <main class="content">
            <?php if ($alertMessage): ?>
                <div class="alert <?php echo $alertType === 'success' ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo $alertMessage; ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <h2>Edit Menu</h2>
                <form action="edit_menu.php?id=<?php echo $menu['id']; ?>" method="POST" enctype="multipart/form-data">
                    <label for="title">Menu Name</label>
                    <input type="text" id="title" name="title" value="<?php echo $menu['title']; ?>" required>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?php echo $menu['description']; ?></textarea>

                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" value="<?php echo $menu['price']; ?>" required>

                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" value="<?php echo $menu['category']; ?>" required>

                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" value="<?php echo $menu['stock']; ?>" required>

                    <label for="image">Upload Image (Optional)</label>
                    <input type="file" id="image" name="image">

                    <button type="submit" name="edit_menu">Update Menu</button>
                </form>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; Copyfight 2024 Uydapz</p>
    </footer>
</body>

</html>
