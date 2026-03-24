<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coreplanner</title>
    <link rel="stylesheet" type="text/css" href="loading-bar.css"/>
    <script type="text/javascript" src="loading-bar.js"></script>

    <script>
        // Maak ldBar instanties aan
        window.onload = function() {
            for (let i = 1; i <= 7; i++) {
                window['bar_' + i] = new ldBar("#circle_" + i);
            }
        };

        // Update cirkel live
        function updateCircle(inputElement, weekIndex) {
            const value = parseInt(inputElement.value) || 0;
            window['bar_' + weekIndex].set(value);
        }
    </script>
</head>
<body>

<?php include_once 'functions.php'; ?>

<form>
    <label>Maandag:</label>
    <input type="number" onkeyup="updateCircle(this, 1)">

    <label>Dinsdag:</label>
    <input type="number" onkeyup="updateCircle(this, 2)">

    <label>Woensdag:</label>
    <input type="number" onkeyup="updateCircle(this, 3)">

    <label>Donderdag:</label>
    <input type="number" onkeyup="updateCircle(this, 4)">

    <label>Vrijdag:</label>
    <input type="number" onkeyup="updateCircle(this, 5)">

    <label>Zaterdag:</label>
    <input type="number" onkeyup="updateCircle(this, 6)">

    <label>Zondag:</label>
    <input type="number" onkeyup="updateCircle(this, 7)">
</form>

<?php
// Genereert automatisch alle 7 cirkels
progress_bar_circle();
?>

</body>
</html>