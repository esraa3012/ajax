const form = document.querySelector('#form');
const inputs = document.querySelectorAll('.input');

const errorFname = document.querySelector('#error_fname');
const errorLname = document.querySelector('#error_lname');
const errorAdresse = document.querySelector('#error_adresse');
const errorDate = document.querySelector('#error_date');

const validate = document.querySelector('#validate');


form.addEventListener('submit', function(e){
    // on annule le rafraichissement de la page après le submit
    e.preventDefault();

    // on lance la function ajax()
    ajax();
})

// ajout à la db du new client
function ajax(){

    // on crée un new FormData avec les info de notre form dedans
    const formData = new FormData(form);

    fetch("newClient.php", { 
        method: "POST",
        body: formData
    })

    .then(response => response.json())
    .then((result) => {
        if(result.responseMYSQL === true){
            validate.textContent = 'Vous avez bien été ajouté à notre base, merci';

            // reset du form
            inputs.forEach(input => {
                input.value = "";                
            });

            // on peut aussi faire un simple form.reset();
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

        // quand je click sur le bouton, faire :
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
                if (result !== true){
                    alert("Error, nous n'avons pas réussi à supprimer l'utilisateur");
                } else {

                    //selection + suppression du bon Tr
                    let trDelete = document.querySelector("[data-id='"+clientId+"']");
                    trDelete.remove();

                    //suppression du button delete
                    trash.remove();
                }
            })

        })
    })
}