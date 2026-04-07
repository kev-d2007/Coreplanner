<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include_once 'db.php';

function register_user($gebruikersnaam, $email, $wachtwoord) {
    $conn = db_connect();
    if ($conn === null) return ["success" => false, "message" => "Er is iets fout gegaan tijdens het verbinden met de database"];
    
    try {
        $stmt = $conn->prepare("SELECT id FROM users WHERE gebruikersnaam = ?");
        $stmt->execute([$gebruikersnaam]);
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Gebruikersnaam bestaat al"];
        }
        
        if (!empty($email)) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                return ["success" => false, "message" => "Email bestaat al"];
            }
        }
        
        $hashed_password = password_hash($wachtwoord, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (gebruikersnaam, email, wachtwoord) VALUES (?, ?, ?)");
        $stmt->execute([$gebruikersnaam, $email ?: null, $hashed_password]);
        
        return ["success" => true, "message" => "Account aangemaakt! Inloggen..."];
    } catch(PDOException $e) {
        return ["success" => false, "message" => "Fout: " . $e->getMessage()];
    }
}

function login_user($user_input, $wachtwoord) {
    $conn = db_connect();
    if ($conn === null) return ["success" => false, "message" => "Er is iets fout gegaan tijdens het verbinden met de database"];
    
    try {
        $stmt = $conn->prepare("SELECT id, gebruikersnaam, wachtwoord FROM users WHERE gebruikersnaam = ? OR email = ? LIMIT 1");
        $stmt->execute([$user_input, $user_input]);
        
        if ($stmt->rowCount() === 0) {
            return ["success" => false, "message" => "Gebruiker niet gevonden"];
        }
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!password_verify($wachtwoord, $user['wachtwoord'])) {
            return ["success" => false, "message" => "Wachtwoord incorrect"];
        }
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['gebruikersnaam'] = $user['gebruikersnaam'];
        
        return ["success" => true, "message" => "Ingelogd!"];
    } catch(PDOException $e) {
        return ["success" => false, "message" => "Fout: " . $e->getMessage()];
    }
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function logout_user() {
    session_destroy();
    header("Location: index.php");
    exit();
}

function progress_bar_circle($week1 = 0, $week2 = 0, $week3 = 0, $week4 = 0, $week5 = 0, $week6 = 0, $week7 = 0) {
    $values = [$week1, $week2, $week3, $week4, $week5, $week6, $week7];

    foreach ($values as $index => $value) {
        $circleIndex = $index + 1;
        echo '<div data-preset="circle" class="progress_bar" id="circle_' . $circleIndex . '" data-value="' . intval($value) . '"></div>';
    }
}
?>