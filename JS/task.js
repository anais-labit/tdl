// déclaration de variables récupérées via les id
let add = document.querySelector("#add");
let addForm = document.querySelector("#addForm");

add.addEventListener("click", async (event) => {
  event.preventDefault();
  fetch("todolist.php", {
    method: "POST",
    body: new FormData(addForm),
  })
    .then((resp) => {
      return resp.text();
    })
    .then((content) => {
      let adding = document.getElementById("adding");
      adding.innerHTML = content;
      adding.style.color = "#639fab";
      if (content == "Votre tâche a bien été ajoutée !") {
        // redirection
        setTimeout(function () {
          window.location.href = "todolist.php";
        }, 1500);
      }
    });
});

let boxes = document.querySelectorAll(".box");
let doneTasks = document.querySelector("#doneList");
let toDoTasks = document.querySelector("#toDolist");
// let spanDate = document.querySelector("#date");
// let spanDoneDate = document.querySelector("#doneDate");

console.log(boxes);
for (const box of boxes) {
  box.addEventListener("click", () => {
    if (box.checked === true) {
      box.checked = true;
      doneTasks.appendChild(box.parentNode);
            doneTasks.appendChild(box.parentNode);

      console.log(box.parentNode.id);
    } else if (box.checked === false) {
      toDoTasks.appendChild(box.parentNode);

      // pour supprimer la tâche
      // doneTasks.removeChild(box.parentNode);
      // doneTasks.innerHTML = "Cette tâche a été suprimée";
      // doneTasks.style.color = "#639fab";
    }
  });
}
