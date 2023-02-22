<?php
require_once './includes/User_pdo.php';

if (isset($_GET['action']) && $_GET['action'] == 'deco') {
    $stm = new User_pdo();
    $deco = $stm->deco();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./includes/style.css" />
    <title>Header</title>
</head>

<body>
    <header>

        <nav>
            <div class="navContainer">
                <ul>
                    <?php if (isset($_SESSION['login'])) {  ?>
                        <ul>
                            <li><a id="toDoList" href="todolist.php">My ToDoList</a></li>
                            <li><a id="deconnexion" href="index.php?action=deco">Déconnexion</a></li>
                        </ul>
                    <?php } else {  ?>
                        <ul>
                            <li><a id="inscription" href="index.php">Inscription</a></li>
                            <li><a id="signIn" href="index.php">Connexion</a></li>
                        </ul>
                    <?php }; ?>

                </ul>
            </div>

        </nav>
    </header>

</body>

</html>