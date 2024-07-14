<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', 'Biology2', 'wardrobe');

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'add_to_cart' form is submitted
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = 1; // Default quantity

    $query = $conn->prepare("SELECT * FROM cart WHERE product_id = ?");
    $query->bind_param("i", $product_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $update_query = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ?");
        $update_query->bind_param("i", $product_id);
        $update_query->execute();
        $update_query->close();
    } else {
        $insert_query = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $insert_query->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
        $insert_query->execute();
        $insert_query->close();
    }
    $query->close();
}

// Handle update cart form submission
if (isset($_POST['update_cart'])) {
    $product_ids = isset($_POST['product_id']) ? (array)$_POST['product_id'] : array();
    $quantities = isset($_POST['quantity']) ? (array)$_POST['quantity'] : array();

    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $quantity = $quantities[$i];
        if ($quantity < 1) {
            $quantity = 1;
        }

        $update_query = $conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ?");
        $update_query->bind_param("ii", $quantity, $product_id);
        $update_query->execute();
    }
}

// Handle remove from cart form submission
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];

    $remove_query = $conn->prepare("DELETE FROM cart WHERE product_id = ?");
    $remove_query->bind_param("i", $product_id);
    $remove_query->execute();
}

// Handle order submission
if (isset($_POST['submit_order'])) {
    $user_id = $_SESSION['user_id'];
    $total_amount = $_POST['total_amount'];

    $insert_order = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $insert_order->bind_param("id", $user_id, $total_amount);
    $insert_order->execute();
    $insert_order->close();

    $conn->query("DELETE FROM cart WHERE user_id = $user_id");
}

// Retrieve cart items from the database
$cart_query = "SELECT products.id, products.name, products.price, cart.quantity 
               FROM cart 
               JOIN products ON cart.product_id = products.id";
$cart_result = $conn->query($cart_query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>MY Cart</title>
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
                    <li><a href="index2.php"><input class="link1" type="button" value="Home"></a></li>
                    <li><a href="index3.php"><input class="link1" type="button" value="Products"></a></li>
                    <li><a href="contacts.html"><input class="link1" type="button" value="Contacts"></a></li>
                    <li><button type="submit" class="link1" onclick="window.location.href='login.php'">Login</button></li>
                </ul>
            </nav>
            <a href="manage_cart.php" class="btn btn-outline-success">My Cart</a>
        </div>
    </div>
</div>
<div class="container">
    <h1>My Cart</h1>
    <?php if ($cart_result->num_rows === 0) : ?>
        <p>Your cart is empty!</p>
    <?php else : ?>
        <form action="" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    while ($row = $cart_result->fetch_assoc()) {
                        $product_total = $row['price'] * $row['quantity'];
                        $total += $product_total;
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>\${$row['price']}</td>
                                <td>
                                    <input type='number' name='quantity[]' value='{$row['quantity']}' min='1'>
                                    <input type='hidden' name='product_id[]' value='{$row['id']}'>
                                </td>
                                <td>\${$product_total}</td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='hidden' name='product_id' value='{$row['id']}'>
                                        <button type='submit' name='remove_from_cart' class='btn btn-danger'>Remove</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>$<?php echo $total; ?></strong></td>
                        <td></td>
                    </tr>
                    </tbody>
            </table>
            <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
            <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
            <button type="submit" name="submit_order" class="btn btn-success">Submit Order</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

