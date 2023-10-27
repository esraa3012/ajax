const form = document.querySelector('#form');
const inputs = document.querySelectorAll('.input');

const errorFname = document.querySelector('#error_fname');
const errorLname = document.querySelector('#error_lname');
const errorAdresse = document.querySelector('#error_adresse');
const errorDate = document.querySelector('#error_date');

const validate = document.querySelector('#validate');
const compteur = document.querySelector('#compteur');
const labelSubmit = document.querySelector('#label_submit');
const submit = document.querySelector('#submit');

const fname = document.querySelector("#fname");
const lname = document.querySelector('#lname');
const adresse = document.querySelector('#adresse');
const date = document.querySelector('#date');

//Au submit du formulaire :
form.addEventListener('submit', function(e){
    // on annule le rafraichissement de la page après le submit
    e.preventDefault();

    //si c'est un ajout d'un nouveau client on lance newClient, sinon maj
    if(compteur.value === "0"){
        // on lance la function ajax()
        newClient();
    } else {
        maj();
    }
})

// ajout à la db du new client
function newClient(){

    // on crée un new FormData avec les info de notre form dedans
    let formData = new FormData(form);

    fetch("newClient.php", { 
        method: "POST",
        body: formData
    })

    .then(response => response.json())
    .then((result) => {
        if(result.responseMYSQL === true){
            validate.textContent = 'Vous avez bien été ajouté à notre base, merci';

            // reset du form
            form.reset();
        }
    })
}

//Mise à jour d'un client
function maj(){

    // Récupération de l'id du client à MAJ
    clientId = submit.dataset.id;

    let majData = new FormData(form);
    majData.append("clientId", clientId);

    fetch("MajClient.php", { 
        method: "POST",
        body: majData
    })

    .then(response => response.json())
    .then((result) => {
        // On vérifie si la maj c'est bien passé sinon msg d'erreur
        if(result.responseMYSQL === true){
            // Si la maj est bien faite, on reset
            submit.value = "Valider";
            labelSubmit.textContent = "Valider :";
            form.reset();
            compteur.value = "0";
            alert("Mise à jour effectuée");
        } else {
            alert("Une erreur durant la mise à jour de profil est survenue", result.codeError);
        }
    })
}

// afficher les clients
window.addEventListener("DOMContentLoaded", () => {
    ListMail();
})

// Demande des nom et Id dans la base SQL
function ListMail(){

    // Création d'un new formData
    let typeListMail = new FormData();
    typeListMail.append("type", 'simple');
    typeListMail.append("where", 'none');

    // execute listMail.php avec les info de ton formData = typeListMail
    fetch ('listMail.php',{
        method: "POST",
        body: typeListMail
    })

    // Réponse du php en Ajax, donc on le traduit avec .json
    .then(response => response.json())

    // Avec le résultat, faire :
    .then((result) => {

        //lancement de la function createTable avec les info récup de notre DataBase
        createTable(result);
    })
}

function createTable(result){
    const tbodyTable = document.querySelector('tbody');
    
    // Pour chaque client
    result.forEach( client => { 

        // on crée une ligne (tr)
        let newRowElement = document.createElement('tr');
        newRowElement.dataset.id = client['id'];
        tbodyTable.appendChild(newRowElement);
        
        // on ajoute le nom du client dans un td
        let newColumn = document.createElement('td');
        newRowElement.appendChild(newColumn);
        let newValueColumn = document.createTextNode(client['LastName']);
        newColumn.appendChild(newValueColumn);

        // on ajoute le prenom du client dans un td
        let newColumn2 = document.createElement('td');
        newRowElement.appendChild(newColumn2);
        let newValueColumn2 = document.createTextNode(client['FirstName']);
        newColumn2.appendChild(newValueColumn2);

        // on ajoute un bouton pour voir plus
        let showMore = document.createElement('button');
        // je stock l'id du client (récupéré par le php de notre database)
        showMore.dataset.id = client['id'];
        showMore.textContent = "Show More";
        newRowElement.appendChild(showMore);

        // au clic du bouton voir plus, faire :
        showMore.addEventListener("click", function(e){
            showMore.remove();
            
            // Je récupère le dataset id que j'ai stocker à la création du button
            let clientId = e.target.dataset.id;
            
            // je fais une autre request php où je demande le reste des info pour le client selectionné
            let typeListMail = new FormData();
            typeListMail.append("type", "more");
            typeListMail.append("where", clientId);
        
            fetch ('listMail.php',{
                method: "POST",
                body: typeListMail
            })

            .then(response => response.json())
            .then((result) => {
                
                // Pour le client sélectionné, on crée deux td avec les infos (adresse + date)
                result.forEach( client => {

                    let newColumn2 = document.createElement('td');
                    newRowElement.appendChild(newColumn2);
                    let newValueColumn2 = document.createTextNode(client['adresse']);
                    newColumn2.appendChild(newValueColumn2);
                    
                    let newColumn3 = document.createElement('td');
                    newRowElement.appendChild(newColumn3);
                    let newValueColumn3 = document.createTextNode(client["date_naissance"]);
                    newColumn3.appendChild(newValueColumn3);
                })
            })
        })

        // Création du button trash
        let trash = document.createElement('button');
        // On ajoute l'id du client lié à ce bouton
        trash.dataset.id = client['id'];
        trash.textContent = "Delete";
        newRowElement.appendChild(trash);

        // quand je click sur le bouton trash, faire :
        trash.addEventListener("click", function(e){

            // Je récupère le dataset id que j'ai stocker à la création du button
            let clientId = e.target.dataset.id;

            // je fais une request avec l'id du client sélectionné pour le delete lui
            let typeDelete = new FormData();
            typeDelete.append("where", clientId);
        
            fetch ('deleteClient.php',{
                method: "POST",
                body: typeDelete
            })

            .then(response => response.json())
            .then((result) => {

                // On vérifie si la request à bien marché sinon message d'error
                if (result!== true){
                    alert("Error, nous n'avons pas réussi à supprimer l'utilisateur");
                } else {

                    //selection + suppression du bon Tr (soit le parent du bouton delete)
                    let trDelete = e.target.parentNode;
                    trDelete.remove();

                    //suppression du button delete
                    trash.remove();
                }
            })

        })

        // Création du button maj
        let maj = document.createElement('button');
        // On ajoute l'id du client lié à ce bouton
        maj.dataset.id = client['id'];
        maj.textContent = "MAJ";
        newRowElement.appendChild(maj);
        
        maj.addEventListener("click", function(e){
            // Je récupère le dataset id que j'ai stocker à la création du button
            let clientId = e.target.dataset.id;
            //Incrémentation du compteur
            compteur.value = "1";

            // je fais une request avec touute les info utiles pour cet id en particulier
            let majData = new FormData();
            majData.append("type", "all");
            majData.append("where", clientId);
        
            fetch ('listMail.php',{
                method: "POST",
                body: majData
            })

            .then(response => response.json())
            .then((result) => {

                // On vérifie si la request à bien marché sinon message d'error
                if (result == true){
                    alert("Error, nous n'avons pas réussi à trouver l'utilisateur");
                } else {
                    fname.value = result[0].LastName;
                    lname.value = result[0].FirstName;
                    adresse.value = result[0].adresse;
                    date.value = result[0].date_naissance;

                    labelSubmit.textContent = "Modifier :";
                    submit.value = "Modifier";
                    submit.dataset.id = clientId;
                }
            })
        })
    })
}