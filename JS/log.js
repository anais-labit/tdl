// déclaration de variables récupérées via les id
const container = document.getElementById("container");
const loginButton = document.getElementById("signIn");
const signUpButton = document.getElementById("signUp");

let create = document.querySelector("#create");
let createForm = document.querySelector("#createForm");
let log = document.querySelector("#connect");
let logForm = document.querySelector("#logForm");

// lorsque l'on clique sur inscription, tu lances la fonction qui ajoute panel active au container
signUpButton.addEventListener("click", () => {
  // ajouter
  container.classList.add("panel-active");
});

// lorsque l'on clique sur connexion, tu retires la fonction qui ajoute panel active au container
loginButton.addEventListener("click", () => {
  container.classList.remove("panel-active");
});

// lorsque l'on clique sur inscription, tu lances la fonction qui ajoute le texte de succès dans html
create.addEventListener("click", async (event) => {
  event.preventDefault();
  fetch("index.php", {
    method: "POST",
    body: new FormData(createForm),
  })
    .then((resp) => {
      return resp.text();
    })
    .then((content) => {
      let creation = document.getElementById("creation");
      //   console.log(content);
      creation.innerHTML = content;
      creation.style.color = "#639fab";
      iError.textContent = "";
    });
});

// lorsque l'on clique sur connexion, tu lances la fonction qui ajoute le texte de succès dans html
connect.addEventListener("click", async (event) => {
  event.preventDefault();
  fetch("index.php", {
    method: "POST",
    body: new FormData(logForm),
  })
    .then((resp) => {
      return resp.text();
    })
    .then((content) => {
      let connexion = document.getElementById("connexion");
      connexion.innerHTML = content;
      connexion.style.color = "#639fab";
      cError.textContent = "";
      if (content === "Connexion réussie") {
        // redirection
        setTimeout(function () {
          window.location.href = "todolist.php";
        }, 2000);
      }
    });
});

// variables pour les messages d'erreur
const emailError = document.querySelector("#email + span.error");
const iError = document.querySelector("#password2 + span.error");
const cError = document.querySelector("#password + span.error");

email.addEventListener("input", (event) => {
  // Each time the user types something, we check if the
  // form fields are valid.
  if (email.validity.valid) {
    // In case there is an error message visible, if the field
    // is valid, we remove the error message.
    emailError.textContent = ""; // Reset the content of the message
    emailError.className = "error"; // Reset the visual state of the message
  } else {
    // If there is still an error, show the correct error
    showError();
  }
});

create.addEventListener("click", async (event) => {
  // if the email field is valid, we let the form submit
  if (!email.validity.valid) {
    // If it isn't, we display an appropriate error message
    showError();
    event.preventDefault();
  } else {
    // Then we prevent the form from being sent by canceling the event
    iError.textContent = "Tous les champs sont requis";
    event.preventDefault();
  }
});

connect.addEventListener("click", async (event) => {
  // if the email field is valid, we let the form submit
  if (!email.validity.valid) {
    // If it isn't, we display an appropriate error message
    showError();
    // Then we prevent the form from being sent by canceling the event
    event.preventDefault();
  }
});

function showError() {
  if (email.validity.typeMismatch) {
    emailError.textContent = "Merci de saisir une adresse mail valide";
  } else {
    iError.textContent = "Tous les champs sont requis";
    cError.textContent = "Ce compte n'existe pas";
  }
}
