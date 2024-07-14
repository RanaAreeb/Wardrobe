<?php
session_start();
$conn = new mysqli('localhost', 'root', 'Biology2', 'wardrobe');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the cart is not empty
if (!isset($_SESSION['cart']) &&  empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    // Optionally provide a link to go back to shopping or continue shopping
} else {
    // Display cart contents
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Cart</title>
        <link rel="stylesheet" href="main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <img src="logo.png" width="180px" />
                </div>
                <nav>
                    <ul>
                        <li><a href="index.html"><input class="link1" type="button" value="Home"></a></li>
                        <li><a href="index2.php"><input class="link1" type="button" value="Products"></a></li>
                        <li><a href="contacts.html"><input class="link1" type="button" value="Contacts"></a></li>
                        <li><button type="submit" class="link1" onclick="window.location.href='login.php'">Login</button></li>
                      </ul>
                    </ul>
                </nav>
                <a href="manage_cart.php" class="btn btn-outline-success">My Cart</a>
            </div>
            <div class="row">
                <div class="col-2">
                    <h1>Wear Clothes That<br />Matter!</h1>
                    <p>Fashion is the armor to survive the reality of everyday life.<br />Life is not perfect but your outfit can be.</p>
                    <a href="index2.php" class="btn">Check it out &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="image1.png" />
                </div>
            </div>
        </div>
    </div>
        <div class="container">
            <h1>My Cart</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product) {
                        $product_total = $product['price'] * $product['quantity'];
                        $total += $product_total;
                        echo "<tr>
                                <td>{$product['name']}</td>
                                <td>\${$product['price']}</td>
                                <td>{$product['quantity']}</td>
                                <td>\${$product_total}</td>
                              </tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>$<?php echo $total; ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <a href="checkout.php" class="btn btn-primary">Checkout</a>
            <!-- Optionally provide a button to clear the cart -->
        </div>
    </body>
    </html>
    <?php
}
?>
