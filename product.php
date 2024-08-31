<?php
// require_once __DIR__ . '\backend\database.php';
// require_once __DIR__ . '\backend\products.php';

// // Initialize database and product objects
// $database = new Database();
// $connection = $database->getConnection();
$product = $products;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    // Sanitize and validate input data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $brand = filter_var($_POST['brand'], FILTER_SANITIZE_STRING);
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
        $imagesDir = __DIR__ . '\..\images\\';
        $imagePath = $imagesDir . $imageName;
        
        // Move the uploaded image to the images directory
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $imageUrl = 'http://localhost/prod/webx/images/' . $imageName; // URL to be stored in DB
        } else {
            echo "<p>Error moving uploaded file.</p>";
            exit;
        }
    } else {
        echo "<p>Error uploading file.</p>";
        exit;
    }

    // Save the product details to the database
    $result = $product->create($name, $price, $imageUrl, $brand);
    
    if ($result['error']) {
        echo "<p>Error creating product: {$result['info']}</p>";
    } else {
        echo "<p>Product added successfully!</p>";
    }
}
?>

<section id="form-details">
    <form action="" method="post" enctype="multipart/form-data">
        <span>Welcome Admin</span>
        <h2>Add a New Product</h2>
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="number" name="price" placeholder="Price" step="0.01" required>
        <input type="file" name="image" accept="image/*" required>
        <input type="text" name="brand" placeholder="Brand" required>
        <button type="submit" name="add_product" class="normal">Add Product</button>
    </form>
</section>
