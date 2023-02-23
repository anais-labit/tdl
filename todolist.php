<?php
session_start();
require_once './includes/User_pdo.php';

$id = $_SESSION['id'];

if (isset($_POST['task'])) {
    $newTask = new User_pdo();
    $newTask->addTask($id);
    die();
}

var_dump($_POST['box']);

if (isset($_POST['box'])) {
    echo 'condition ok';
    $getTask = new User_pdo();
    $getTask->updateTask($id);
    die();
}

if (isset($_GET['delete'])) {
    $deleteTask = new User_pdo();
    $deleteTask->deleteTask((int) $_GET['delete']);
    die();
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./includes/style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
    <title>My ToDoList</title>
</head>

<body>
    <?php require_once './includes/header.php'
    ?>
    <div class="taskContainer" id="taskContainer">
        <form action="" method="post" id="addForm">
            <h1>Créer une tâche</h1>
            <input type="text" name="task" id="task" placeholder="ie : aller à la poste">
            <button type="submit" id="add">Ajouter une nouvelle tâche</button>
            <span id="adding"></span>

            <div class="lists">
                <div id="ToDoContainer" class="toDoContainer">
                    <h3>To do</h3>
                    <div id="toDo">
                        <ul name="doDolist" id="toDolist">
                            <?php
                            $displayTask = new User_pdo();
                            $displayTask->displayTask($_SESSION['id']);
                            ?>
                        </ul>
                    </div>
                </div>
                <div id="DoneContainer" class="DoneContainer">
                    <h3>Done</h3>
                    <div>
                        <ul name="doneList" id="doneList">
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script async src="./JS/task.js"></script>
    <?php require_once './includes/footer.php'; ?>
</body>

</html>