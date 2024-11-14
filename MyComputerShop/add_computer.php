<?php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$timeout_duration = 600;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
    session_unset();
    session_destroy();
    header("Location: login.php?message=Session expired due to inactivity.");
    exit();
}
$_SESSION['last_activity'] = time();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = htmlspecialchars($_POST['model']);
    $brand = htmlspecialchars($_POST['brand']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);

    if ($price === false || $stock === false) {
        echo "Invalid price or stock value.";
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO computers (model, brand, price, stock) VALUES (:model, :brand, :price, :stock)");
    $stmt->execute(['model' => $model, 'brand' => $brand, 'price' => $price, 'stock' => $stock]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Computer</title>
</head>
<body>
<?php include 'views/header.php'; ?>

<h2>Add New Computer</h2>
<form method="POST" action="">
    Model: <input type="text" name="model" required><br>
    Brand: <input type="text" name="brand" required><br>
    Price (USD): <input type="number" step="0.01" name="price" required><br>
    Stock: <input type="number" name="stock" required><br>
    <button type="submit">Add Computer</button>
	<button class="back-button" onclick="history.back()">Back</button>
</form>

<?php include 'views/footer.php'; ?>
</body>
</html>
