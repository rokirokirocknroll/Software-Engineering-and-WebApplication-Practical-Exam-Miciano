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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
</head>
<body>
<?php include 'views/header.php'; ?>

<h2>Welcome to the Computer Shop Management System</h2>
<p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>

<?php include 'views/footer.php'; ?>
</body>
</html>
