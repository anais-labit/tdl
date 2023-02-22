<?php
session_start();
require_once './includes/User_pdo.php';

// ajout à la DB pour inscription
if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])) {
    // Si les variables existent et qu'elles ne sont pas vides
    $login = htmlspecialchars($_POST['login']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);
    $newUser = new User_pdo($login, $email, $password, $password2);
    $newUser->register($login, $email, $password, $password2);
    die();
}

// comparaison pour connexion
if ((isset($_POST['login'])) && (isset($_POST['email'])) && (isset($_POST['password']))) {
    $login = htmlspecialchars($_POST['login']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $connectUser = new User_pdo($login, $email, $password);
    $connectUser->signIn($login, $email, $password);
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./includes/style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
    <title>Accueil</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="post" id="createForm">
                <h1>Inscrivez-vous</h1>
                <input type="text" id="login" name="login" placeholder="Login" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <span class="error"></span>
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <input type="password" id="password2" name="password2" placeholder="Confirmation de Mot de passe" required>
                <span class="error" id="error"></span>
                <button type="submit" id="create">Créer un compte</button>
                <span id="creation"></span>
            </form>
        </div>
        <div class="form-container login-container">
            <form action="" method="post" id="logForm">
                <h1>Bienvenue</h1>
                <input type="text" id="login" name="login" placeholder="Login" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                <span class="error" id="error"></span>
                <button type="submit" id="connect">Se connecter</button>
                <span id="connexion"></span>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bienvenue</h1>
                    <button class="ghost" id="signIn">Se connecter</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Inscrivez-vous</h1>
                    <button class="ghost" id="signUp">Créer un compte</button>
                </div>
            </div>
        </div>
    </div>
    <script async src="./JS/log.js"></script>
    <?php require_once './includes/footer.php'; ?>
</body>

</html>