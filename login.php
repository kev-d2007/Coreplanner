<?php
include_once 'functions.php';

$message = "";
$error_type = ""; // login of register

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $user_input = $_POST['user_input'] ?? '';
        $wachtwoord = $_POST['wachtwoord'] ?? '';
        $result = login_user($user_input, $wachtwoord);
        $message = $result['message'];
        $error_type = "login";
        
        if ($result['success']) {
            header("Location: index.php");
            exit();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
        $email = $_POST['email'] ?? '';
        $wachtwoord = $_POST['wachtwoord'] ?? '';
        $result = register_user($gebruikersnaam, $email, $wachtwoord);
        $message = $result['message'];
        $error_type = "register";
        
        if ($result['success']) {
            login_user($gebruikersnaam, $wachtwoord);
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coreplanner - Inloggen</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Coreplanner</h2>
            
            <?php if ($message): ?>
                <div class="message <?php echo strpos($message, 'Fout') !== false || strpos($message, 'niet') !== false ? 'error' : 'success'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div id="login-form" class="form-group <?php echo $error_type === 'login' || !$message ? 'active' : ''; ?>">
                <h3>Inloggen</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <input type="text" name="user_input" placeholder="Gebruikersnaam of email" autocomplete="username" required>
                    <input type="password" name="wachtwoord" placeholder="Wachtwoord" autocomplete="current-password" maxlength="50" required>
                    <button type="submit">Inloggen</button>
                </form>
                <div class="toggle-link">
                    Geen account? <a onclick="toggleForms()">Registreren</a>
                </div>
            </div>

            <div id="register-form" class="form-group <?php echo $error_type === 'register' ? 'active' : ''; ?>">
                <h3>Account aanmaken</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="register">
                    <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" autocomplete="username" maxlength="50" required>
                    <input type="email" name="email" placeholder="E-mail (optioneel)" autocomplete="email" maxlength="100">
                    <input type="password" name="wachtwoord" placeholder="Wachtwoord" autocomplete="new-password" maxlength="50" required>
                    <button type="submit">Registreren</button>
                </form>
                <div class="toggle-link">
                    Heb je al een account? <a onclick="toggleForms()">Inloggen</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleForms() {
        const messageDiv = document.querySelector('.message');
        if (messageDiv) {
            messageDiv.style.display = 'none';
        }
        
        document.getElementById('login-form').classList.toggle('active');
        document.getElementById('register-form').classList.toggle('active');
    }
    </script>
</body>
</html>
