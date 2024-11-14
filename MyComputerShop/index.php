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

$computers = $pdo->query("SELECT * FROM computers")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Computers List</title>
</head>
<body>
<?php include 'views/header.php'; ?>

<h2>Computers List</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Model</th>
        <th>Brand</th>
        <th>Price (USD)</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($computers as $computer): ?>
        <tr>
            <td><?= $computer['id'] ?></td>
            <td><?= htmlspecialchars($computer['model']) ?></td>
            <td><?= htmlspecialchars($computer['brand']) ?></td>
            <td>$<?= number_format($computer['price'], 2) ?></td>
            <td><?= $computer['stock'] ?></td>
            <td>
                <a href="edit_computer.php?id=<?= $computer['id'] ?>">Edit</a> |
                <a href="delete_computer.php?id=<?= $computer['id'] ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<button class="back-button" onclick="history.back()">Back</button>

<?php include 'views/footer.php'; ?>
</body>
</html>
