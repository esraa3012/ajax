const form = document.querySelector("form");
const p = document.querySelector("p");
form.addEventListener("submit", function(e) {
    e.preventDefault();
    let data = new FormData(form);
    fetch("add.php", { method: "POST", body: data })
        .then(response => response.json())
        .then((results) => {
            if (results.responseServer === true && results.responseDB === true) {
                p.textContent = "Client ajouté";
                form.reset(); //Vide le formulaire
            } else {
                let a = results.responseServer;
                
                console.log(a.lenght);
                
                a.forEach(elementa => {
                    
                console.log(elementa.name);
                });
                p.textContent = "SOS";
            }
        })
})
const ul = document.querySelector("ul");
window.addEventListener("load", function() {
    fetch("list.php")
        .then(response => response.json())
        .then((results) => {
            let resultat = results["data"];
            resultat.forEach((element) => {
                const li = document.createElement("li");
                const button = document.createElement("button");
                button.textContent = "Voir plus";
                button.setAttribute("data-value", element.id);
                button.addEventListener("click", function(){
                    fetch("list2.php", {
                            method: "POST",
                            body: JSON.stringify(this.getAttribute("data-value")),
                            contentType: 'application/json'
                        })
                        .then(response => response.json())
                        .then((results) => {
                            this.replaceWith(", " + results["data"][0].adresse + ", " + results["data"][0].date_naissance);
                        })
                })
                li.textContent = element.nom;
                li.appendChild(button);
                ul.appendChild(li);
            });
        })
})