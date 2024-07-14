<?php
session_start(); // Start the session

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "Biology2";
$dbName = "wardrobe";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: index2.php"); // Redirect to index page after logout
    exit();
}

$product_query = "SELECT * FROM products";
$product_result = $conn->query($product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wardrobe.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
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
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li><a href="?logout=true"><button type="button" class="link1">Logout</button></a></li>
                    <?php } else { ?>
                        <li><a href="login.php"><button type="button" class="link1">Login</button></a></li>
                    <?php } ?>
                </ul>
            </nav>
            <a href="manage_cart.php" class="btn btn-outline-success">My Cart</a>
        </div>
        <?php if (isset($_SESSION['username'])) { ?>
            <div class="user-info">
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-2">
                <h1>Wear Clothes That<br />Matter!</h1>
                <p>Fashion is the armor to survive the reality of everyday life.<br />Life is not perfect but your outfit can be.</p>
                <a href="index3.php" class="btn">Check it out &#8594;</a>
            </div>
            <div class="col-2">
                <img src="image1.png" />
            </div>
        </div>
    </div>
</div>

<div class="categories">
    <div class="small-container">
        <div class="row">
            <div class="col-3">
                <img src="c-4.jpg" />
            </div>
            <div class="col-3">
                <img src="c5.jpg" />
            </div>
            <div class="col-3">
                <img src="c6.jpg" />
            </div>
        </div>
    </div>
</div>

<div class="small-container">
    <h2 class="title">Featured products</h2>
    <div class="row">
        <?php while ($row = $product_result->fetch_assoc()) { ?>
            <div class="col-4">
                <form action="manage_cart.php" method="POST">
                    <img src="product-<?php echo $row['id']; ?>.jpg" alt="<?php echo $row['name']; ?>" class="img-fluid">
                    <h4><?php echo $row['name']; ?></h4>
                    <p>$<?php echo $row['price']; ?></p>
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>

    <h2 class="title">Latest Products</h2>
    <div class="row">
        <?php
        $product_result->data_seek(0); // Reset the result set to fetch again
        while ($row = $product_result->fetch_assoc()) { ?>
            <div class="col-4">
                <form action="manage_cart.php" method="POST">
                    <img src="product-<?php echo $row['id']; ?>.jpg" alt="<?php echo $row['name']; ?>" class="img-fluid">
                    <h4><?php echo $row['name']; ?></h4>
                    <p>$<?php echo $row['price']; ?></p>
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</div>

<div class="footer">
    <div class="row">
        <div class="footer-col-1">
            <h3>Download our app</h3>
            <p>Download App for Android and iOS mobile phone</p>
            <div class="app-logo">
                <img src="play-store.png" />
                <img src="app-store.png" />
            </div>
        </div>
        <div class="footer-col-2">
            <p>Our purpose is to make high-quality products that can satisfy our customers.</p>
        </div>
        <div class="footer-col-3">
        <h3>Useful Links</h3>
                <ul>
                    <li>Coupons</li>
                    <li>Blog POST</li>
                    <li>Return policy</li>
                </ul>
            </div>
            <div class="footer-col-4">
                <h3>Follow us</h3>
                <ul>
                    <li><a href="https://instagram.com">Instagram</a></li>
                    <li><a href="https://facebook.com">Facebook</a></li>
                    <li><a href="https://twitter.com">Twitter</a></li>
                    <li><a href="https://mail.google.com/mail/u/0/#inbox">Gmail</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <p class="copyright">Copyright 2023 - DingDong</p>
    </div>
</body>
</html>