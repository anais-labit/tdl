<?php

class User_pdo
{
    private $PDO;
    private ?int $id = null;
    private ?string $login = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $password2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): User_pdo
    {
        $this->id = $id;
        return $this;
    }
    public function getLogin(): ?string
    {
        return $this->login;
    }
    public function setLogin(?string $login): User_pdo
    {
        $this->login = $login;
        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(?string $email): User_pdo
    {
        $this->email = $email;
        return $this;
    }
    public function getPwd(): ?string
    {
        return $this->password;
    }
    public function setPwd(?string $password): User_pdo
    {
        $this->password = $password;
        return $this;
    }
    public function getPwd2(): ?string
    {
        return $this->password2;
    }
    public function setPwd2(?string $password2): User_pdo
    {
        $this->password2 = $password2;
        return $this;
    }

    public function __construct()
    {
        $DB_DSN = 'mysql:host=localhost; dbname=tdl';
        $DB_USER = 'root';
        $DB_PASS = '';

        try {
            $this->PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);
            // echo 'Connexion établie';
            return TRUE;
        } catch (PDOException $e) {
            die('ERREUR :' . $e->getMessage());
        }
    }

    public function register(string $login, string $email, string $password, string $password2)
    {
        $this->PDO;
        // On vérifie si l'utilisateur existe en DB
        $check = $this->PDO->prepare('SELECT * FROM utilisateurs WHERE login = ?');
        $check->execute(array(
            $login,
        ));
        $row = $check->rowCount();

        //s'il n'existe pas, que les pwd matchent, on créé l'user 
        if (($row === 0) && (!empty($_POST))) {
            if ($password === $password2) {
                $password = password_hash($password, PASSWORD_BCRYPT);
                $insert = $this->PDO->prepare('INSERT INTO utilisateurs(login, email, password) VALUES(:login, :email, :password)');
                $insert->execute(array(
                    ':login' => $login,
                    ':email' => $email,
                    ':password' => $password,
                ));
                // et on affiche le message d'inscription
                echo 'Inscription réussie';
            }
        }
    }
    public function signIn(string $login, string $email, string $password)
    {
        $this->PDO;
        // On vérifie si l'utilisateur existe
        $check = $this->PDO->prepare('SELECT id, login, email, password FROM utilisateurs WHERE login = ?');
        $check->execute(array(
            $login,
        ));
        $data = $check->fetch();
        $row = $check->rowCount();
        // s'il existe, on retransforme son pwd et on fait afficher le message de succès de connexion
        if ((($row === 1) && $email === $data['email']) && (!empty($_POST))) {
            $hashedPassword = $data['password'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['login'] = $login;
                $_SESSION['id'] = $data[0];
                $_SESSION['password'] = $password;
                echo 'Connexion réussie';
            }
        }
    }
    public function deco()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
        header('refresh:3; url= index.php');
    }

    public function addTask($id)
    {
        $this->PDO;
        // On va chercher les infos de l'utilisateur 
        $check = $this->PDO->prepare('SELECT login, password FROM utilisateurs WHERE id = ?');
        $check->execute([$id]);

        // definir le format de la date compatible avec la DB
        $date = date('Y-m-d H:i:s');
        // création de la variable commentaire issue du POST en le formatant de telle sorte à ce que l'on puisse mettre des ' et caractères spéciaux dans le post
        if (!empty($_POST['task'])) {
            $task = htmlspecialchars($_POST["task"]);
        } else {
            die();
        }

        // requête d'ajout de tâche
        $add = $this->PDO->prepare("INSERT INTO tasks (task, id_utilisateur, date) VALUES (:task, :id_utilisateur, :date)");
        $add->execute([
            'task' => $task,
            'id_utilisateur' => $id,
            'date' => $date,
        ]);
        echo "Votre tâche a bien été ajoutée !";
    }

    public function displayTask($user_id)
    {
        $this->PDO;
        // On va chercher les tâches de l'utilisateur connecté 
        $check = $this->PDO->prepare("SELECT DATE_FORMAT(tasks.date, '%d/%m/%Y'), DATE_FORMAT(tasks.done_date, '%d/%m/%Y'), tasks.id, utilisateurs.login, tasks.task FROM tasks INNER JOIN utilisateurs ON tasks.id_utilisateur=utilisateurs.id WHERE tasks.id_utilisateur=:user_id ORDER BY date DESC ");
        $check->execute(['user_id' => $user_id]);
        $displayTask = $check->fetchAll();

        $i = -1;
        // boucle 1 qui parcourt les différents tableaux de commentaire
        foreach ($displayTask as $ligne) {
            // boucle 2 qui parcourt les cases du tableau
            foreach ($ligne as $value) {
                $i++;
                // $result = ucfirst($displayTask[$i][4]) . " " . '(ajout le ' . $displayTask[$i][0] . ')<br>';
                $result = ucfirst($displayTask[$i][4]) . '<br> (ajout le : ' . $displayTask[$i][0] . ' & fait le : ' . $displayTask[$i][1] . ')<br>';
                $id = $displayTask[$i][2];
                echo '<li id="' . $id . '" >
                        <input type="checkbox" class="box" id="box" name="box" value="todo">' . $result . ' 
                        <button type="submit" class="del" id="' . $id . '">
                            <a class="delete" href="todolist.php?delete=' . $id . '"><i class="fa-solid fa-trash"></i></a>
                        </button>
                    </li>';
                // arrêter lorsqu'il n'y a plus de valeur à parcourir
                break;
            }
        }
    }

    public function updateTask($user_id)
    {
        $this->PDO;
        $getTask = $this->PDO->prepare("SELECT * FROM tasks WHERE id_utilisateur=:user_id");
        $getTask->execute(['user_id' => $user_id]);
        $getTaskInfos = $getTask->fetchAll();

        var_dump($getTaskInfos);

        $done_date = date('Y-m-d H:i:s');

        $upTask = $this->PDO->prepare("UPDATE tasks SET done_date =:done_date, status=1 WHERE id_utilisateur=:user_id");
        $upTask->execute([
            'user_id' => $user_id,
            'done_date' => $done_date,
        ]);
    }

    public function deleteTask(int $task_id)
    {
        $this->PDO;
        $delTask = $this->PDO->prepare("DELETE FROM tasks WHERE tasks.id=:task_id");
        $delTask->execute(['task_id' => $task_id]);

        // $deleteTask = $this->PDO->prepare("DELETE FROM tasks WHERE ")

    }


    // }
}
