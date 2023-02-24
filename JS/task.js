// déclaration de variables récupérées via les id
let add = document.querySelector("#add"); // bouton "Ajouter"
let addForm = document.querySelector("#addForm"); // formulaire d'ajout

// événement d'écoute du clic sur le bouton "Ajouter"
add.addEventListener("click", async (event) => {
  event.preventDefault(); // empêche le formulaire d'être soumis
  fetch("todolist.php", {
    // envoi de la requête POST vers todolist.php
    method: "POST",
    body: new FormData(addForm), // données du formulaire
  })
    .then((resp) => {
      return resp.text(); // renvoie le contenu de la réponse
    })
    .then((content) => {
      let adding = document.getElementById("adding"); // élément HTML pour afficher un message de succès
      adding.innerHTML = content; // affiche le message de la réponse
      adding.style.color = "#639fab";

      if (content == "Votre tâche a bien été ajoutée !") {
        setTimeout(function () {
          window.location.href = "todolist.php";
        }, 1500);
      }
    });
});

let boxes = document.querySelectorAll(".box"); // toutes les cases à cocher
let doneTasks = document.querySelector("#doneList"); // élément HTML pour les tâches terminées
let toDoTasks = document.querySelector("#toDolist"); // élément HTML pour les tâches à faire

// boucle à travers toutes les cases à cocher
for (const box of boxes) {
  let idTask = box.parentNode.id; // récupère l'identifiant de la tâche à supprimer
  box.addEventListener("click", () => {
    if (box.checked === true) {
      // si la case est cochée
      box.checked = true;
      doneTasks.appendChild(box.parentNode); // déplace la tâche terminée vers l'élément HTML "doneTasks"
    } else if (box.checked === false) {
      // si la case n'est pas cochée
      toDoTasks.appendChild(box.parentNode); // déplace la tâche à faire vers l'élément HTML "toDoTasks"
    }
    checkTask(idTask);
  });
}

// fonction pour voir si une tâche est checkée
async function checkTask(idTask) {
  await fetch(`todolist.php?checked=${idTask}`).then((resp) => {
    return resp.text();
  });
}

let delBtns = document.querySelectorAll(".del"); // tous les boutons de suppression
// let tasksLists = document.querySelector("#lists"); // élément HTML pour toutes les tâches

// boucle à travers tous les boutons de suppression
for (const btn of delBtns) {
  btn.addEventListener("click", (e) => {
    // événement d'écoute du clic sur le bouton de suppression
    e.preventDefault(); // empêche le bouton d'effectuer son action par défaut
    let idTask = e.target.id; // récupère l'identifiant de la tâche à supprimer
    deleteTask(idTask); // appelle la fonction pour supprimer la tâche
    // doneTasks.remove(box.parentNode); // supprimer la tâche de 'élément HTML "toDoTasks"
    // toDoTasks.remove(box.parentNode); // supprimer la tâche de 'élément HTML "toDoTasks"
    setTimeout(function () {
      window.location.href = "todolist.php";
    }, 1000);
  });
}

// fonction pour supprimer une tâche
async function deleteTask(idTask) {
  await fetch(`todolist.php?delete=${idTask}`).then((resp) => {
    return resp.json();
  });
}
