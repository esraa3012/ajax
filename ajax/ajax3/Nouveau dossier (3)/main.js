const form = document.getElementById("add-form");
form.addEventListener("submit", function(e){
    e.preventDefault();
    addClient();
});

function addClient(){
    // Creer un objet FormData qui contiendra les données du formulaire
    // Fonctionne uniquement avec un formulaire
    const formData = new FormData(form);

    // Envoie le formData au script PHP client-add.php
    fetch('add-client.php', {
        method: "POST",
        body : formData
    })
    // Réponse du serveur (si la requête a fonctionné)
    .then(response => {
        if(!response.ok){
            throw new Error(`Error status: ${response.status}`)
        }
        // Retourne la réponse au format JSON
        return response.json();
    })
    // Réponse des données
    .then(data=> {
        // Log la réponse
        // console.log(data);
        // Reset les champs du formulaire
        form.reset();
    });
};
/*
Sur la même page que le défi précédent, afficher la liste de tous les clients (uniquement le nom). A côté de chaque nom, afficher un bouton voir plus.
Au clique du bouton voir plus, afficher l'adresse et la date de naissance du client en question.
*/
function clientList(){
    fetch('client-list.php', {method: "POST",})
    .then(response =>{return response.json()})
    .then(data =>{
        const tBody = document.querySelector('tbody');

        for (i = 0; i < data.length; i++) {
            let template = document.querySelector('#productrow');
            // Crée un clone du contenu (TD) à partir du template
            let clone = document.importNode(template.content, true);
            let td = clone.querySelectorAll("td");
            td[0].textContent = `${data[i].LastName}`;
            td[1].setAttribute('data-value', `${data[i].id}`);
            tBody.appendChild(clone);
        }
        // Show More
        const btnShowMore = document.querySelectorAll(".showMore");
        btnShowMore.forEach(btn => {
            btn.addEventListener('click', (e) =>{
                let tdParent = e.currentTarget.parentElement;
                let clientIdShow = tdParent.dataset.value;
                fetch(`show-more.php?clientToShowID=${clientIdShow}`, {
                    method: "GET"
                })
                .then(response =>{return response.json()})
                .then(data => {
                    let trTitle = document.getElementById('title');
                    let thTitle = ['FirstName','adresse','date_naissance'];
                    let data2 = Object.values(data);

                    thTitle.forEach((element, index) => {
                        let thAll = trTitle.querySelectorAll('th');
                        if (thAll.length != 4 ){
                            let th = document.createElement("TH");
                            th.textContent = element;
                            trTitle.appendChild(th);
                        }

                        let td = document.createElement('TD');
                        td.textContent = data2[index];
                        tdParent.before(td);
                        btn.remove();
                    })  
                })
            })
        })
        // Fin ShowMore

        // ** Fonction suppression ** //
        clientSup();
    });
}

function clientSup (){
    // Fonction suppression
    let btnSupp = document.querySelectorAll(".clientSup");
    btnSupp.forEach(btn => {
        btn.addEventListener('click', (e) => {
            let tdParent = e.currentTarget.parentElement;
            let clientDeleteId = tdParent.dataset.value;
            let tr = tdParent.parentElement;

            fetch(`client-delete.php?clientToDeleteID=${clientDeleteId}`, {
                method: "GET"
            })
            .then(response =>{return response.json()})
            .then(data => {
                if(data[0] == 1 ){
                    tr.remove();
                }
                console.log(data);
            })
        })
    })
}

window.addEventListener('DOMContentLoaded', () => {
    clientList();
});
