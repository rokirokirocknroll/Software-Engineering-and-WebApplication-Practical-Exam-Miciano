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

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $computer_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM computers WHERE id = :id");
    $stmt->execute(['id' => $computer_id]);
    $computer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$computer) {
        echo "Computer not found.";
        exit();
    }
} else {
    echo "Invalid computer ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = htmlspecialchars($_POST['model']);
    $brand = htmlspecialchars($_POST['brand']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);

    if ($price === false || $stock === false) {
        echo "Invalid price or stock value.";
        exit();
    }

    $stmt = $pdo->prepare("UPDATE computers SET model = :model, brand = :brand, price = :price, stock = :stock WHERE id = :id");
    $stmt->execute(['model' => $model, 'brand' => $brand, 'price' => $price, 'stock' => $stock, 'id' => $computer_id]);

    header("Location: index.php?message=Computer updated successfully");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Computer</title>
</head>
<body>
<?php include 'views/header.php'; ?>

<h2>Edit Computer</h2>
<form method="POST" action="">
    Model: <input type="text" name="model" value="<?= htmlspecialchars($computer['model']) ?>" required><br>
    Brand: <input type="text" name="brand" value="<?= htmlspecialchars($computer['brand']) ?>" required><br>
    Price (USD): <input type="number" step="0.01" name="price" value="<?= number_format($computer['price'], 2) ?>" required><br>
    Stock: <input type="number" name="stock" value="<?= $computer['stock'] ?>" required><br>
    <button type="submit">Update Computer</button>
	<button class="back-button" onclick="history.back()">Back</button>
</form>

<?php include 'views/footer.php'; ?>
</body>
</html>
