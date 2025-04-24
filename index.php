<?php
    include 'protected/db.php.inc';
    try { 
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    } catch (PDOException $e){
        die( $e->getMessage() );
    }

    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        $stmt = $pdo->prepare('SELECT * FROM customeraccounts WHERE Username = ?');
        $stmt->execute([$_SESSION['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($user['ManagerID'])){
            $_SESSION['ManagerID'] = $user['ManagerID'];
            $isManager = true;
            $_SESSION['isManager'] = true;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxaCar</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <a href="index.php"> 
                    LuxaCar
                    <img src="protected/logo.png" alt="Logo">
                </a>
            </div>
            <div class="nav-links">
                <a href="about.php">About Us</a>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
                    <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                    <?php if (!isset($isManager)): ?>
                    <a href="viewRent.php">Shopping Basket</a>
                    <?php endif; ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </header>
        <div class="main-container">
            <nav class="nav">
                <?php if (isset($_SESSION['isManager'])): ?>
                    <a href="addCar.php">Add Car</a>
                    <a href="addLocation.php">Add Location</a>
                    <a href="returnCarMan.php">Return Car</a>
                    <a href="inquireCar.php">Inquire about Cars</a>
                <?php elseif (isset($_SESSION['username'])): ?>
                    <a href="returnCar.php">Return car</a>
                    <a href="viewRent.php">View Rented Cars</a>
                <?php endif; ?>
                <a href="searchCar.php">Search a Car</a>
            </nav>
            <main class="main">
                <h1>Welcome to LuxaRent</h1>
                <p>
                    LuxaRent is a car rental service that offers a wide range of cars for rent. 
                    We have a variety of cars that you can choose from, whether you need a car for a day or a month, we have you covered. 
                    Our cars are well maintained and we offer competitive prices. 
                    We also offer a delivery service, where we can deliver the car to your location. 
                    We are committed to providing the best service to our customers and we are always looking for ways to improve. 
                    If you have any questions or need assistance, please do not hesitate to contact us. 
                    Thank you for choosing LuxaRent.
                </p>
            </main>
        </div>
        <footer class="footer">
            <div>
                <img src="protected/logo.png" alt="Small Logo">
            </div>
            <div class="contact-info">
                Address: Alwakalt, Ramallah, Palestine<br>
                Email: contact@luxacar.com<br>
                Phone: +970599767544<br>
                <a href="contact.php">Contact Us</a>
            </div>
        </footer>
    </div>
</body>
</html>
