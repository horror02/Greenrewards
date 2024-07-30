<?php
    require_once('database.php');

    $message = ""; // Initialize message variable

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $productId = $_POST['productId'];

        // Connect to the database
        $db = Database::connect();

        if (isset($_POST['price'])) {
            $price = $_POST['price'];

            // Update product price in the database
            $stmt = $db->prepare("UPDATE product SET price=:price WHERE productId=:productId");
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':productId', $productId);

            if ($stmt->execute()) {
                $message = "Product price updated successfully."; // Set success message
            } else {
                $message = "Error updating product price: " . $stmt->errorInfo()[2]; // Set error message
            }
        } elseif (isset($_POST['qty'])) {
            $qty = $_POST['qty'];

            // Update product quantity in the database
            $stmt = $db->prepare("UPDATE product SET qty=:qty WHERE productId=:productId");
            $stmt->bindParam(':qty', $qty);
            $stmt->bindParam(':productId', $productId);

            if ($stmt->execute()) {
                $message = "Product quantity updated successfully."; // Set success message
            } else {
                $message = "Error updating product quantity: " . $stmt->errorInfo()[2]; // Set error message
            }
        }

        // Disconnect from the database
        Database::disconnect();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style10.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Edit Product Prices and Quantities</title>
</head>
<body>
<label>
        <div class="sidebar" id="sidebar">
            <input type="checkbox">
            <div class="toggle">
                <span class="top_line common"></span>
                <span class="middle_line common"></span>
                <span class="bottom_line common"></span>
            </div>
            <div class="slide">
                <h1>Product</h1>
                <ul>
                    <li><a href="dashboard.php"><img src="history.png" alt="Dashboard Icon">Dashboard</a></li>
                    <li><a href="users.php"><img src="user.png" alt="Users Icon">Users</a></li>
                    <li><a href="product.php"><img src="product.png" alt="Product Icon">Product</a></li>
                    <li><a href="recover.php"><img src="recovery.png" alt="Recovery Icon">Account Recovery</a></li>
                </ul>
                <button class="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
            </div>
        </div>
    </label>
    <div class="header">
        <div></div>
        <img src="logo1.jpg" alt="Logo">
    </div>
    <div class="content">
        <div class="container">
            <?php
            // Sample products, replace with actual data from your database
            $products = [
                ['id' => 1, 'name' => 'Product 1', 'image' => 'product1.png'],
                ['id' => 2, 'name' => 'Product 2', 'image' => 'product2.png'],
                ['id' => 3, 'name' => 'Product 3', 'image' => 'product3.png']
            ];

            foreach ($products as $product) {
                echo '<div class="product-container">';
                echo '<div class="product-info">';
                echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '">';
                echo '<span>Product ID: ' . $product['id'] . '</span>';
                echo '</div>';

                // Form for updating price
                echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '" class="form-container">';
                echo '<input type="hidden" name="productId" value="' . $product['id'] . '">';
                echo '<label for="price">New Price:</label>';
                echo '<input type="text" id="price" name="price" required>';
                echo '<input type="submit" value="Update Price" class="btn-update">';
                echo '</form>';

                // Form for updating quantity
                echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '" class="form-container">';
                echo '<input type="hidden" name="productId" value="' . $product['id'] . '">';
                echo '<label for="qty">New Quantity:</label>';
                echo '<input type="text" id="qty" name="qty" required>';
                echo '<input type="submit" value="Update Quantity" class="btn-update">';
                echo '</form>';

                echo '</div>';
            }
            ?>
            <div class="success-message"><?php echo $message; ?></div>
        </div>
    </div>
</body>
</html>


