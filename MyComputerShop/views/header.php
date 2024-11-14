<!DOCTYPE html>
<html>
<head>
    <title>Computer Shop Management System</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>🖥️Computer Shop Management System🖥️</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
        <nav>
            <a href="menu.php">Main Menu</a> |
            <a href="index.php">View Computers</a> |
            <a href="add_computer.php">Add Computer</a> |
            <a href="logout.php">Logout</a>
        </nav>
    <?php else: ?>
        <nav>
            <a href="login.php">Login</a> |
            <a href="register.php">Register</a>
        </nav>
    <?php endif; ?>
    <hr>
</header>
