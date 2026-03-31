<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coreplanner</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php
include_once 'functions.php';


if (isset($_GET['logout'])) {
    logout_user();
}

if (is_logged_in()) {
    ?>
    <div class="dashboard">
        <button class="logout-btn" onclick="location.href='?logout=1'">Uitloggen</button>
        <?php include_once 'circles.php'; ?>
    </div>
    <?php
} else {
    include_once 'login.php';
}
?>

</body>
</html>