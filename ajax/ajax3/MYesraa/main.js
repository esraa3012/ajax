const form = document.querySelector("form");
const p = document.querySelector("p");
form.addEventListener("submit", function(e) {
    e.preventDefault();
    let data = new FormData(form);
    fetch("add.php", { method: "POST", body: data })
        .then(response => response.json())
        .then((results) => {
            if (results.responseServer === true && results.responseDB === true) {
                p.textContent = "Client add";
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
                button.textContent = "show more";
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

                const button1 = document.createElement("button");
                button1.textContent = "delete";
                button1.setAttribute("data-value", element.id);
                button1.addEventListener("click", function(){
                    fetch("list3.php", {
                            method: "POST",
                            body: JSON.stringify(this.getAttribute("data-value")),
                            contentType: 'application/json'
                        })
                        .then(response => response.json())
                        .then(results => {
                            if(results[0] == 1 ){
                                li.remove();
                            }
                            console.log(results);
                        })
                //         .then((results) => {
                //             if (results !== true){
                //                 alert("Error, nous n'avons pas réussi à supprimer l'utilisateur");
                //             } else {
            
                //                 //selection + suppression du bon Tr
                //                 let trDelete = document.querySelector("[data='"+id+"']");
                //                 trDelete.remove();
            
                //                 //suppression du button delete
                //                 trash.remove();
                //             }
                //             //this.replaceWith(results["data"][0].id);
                //         })
                 })
                li.textContent = element.LastName;
                li.appendChild(button);
                li.appendChild(button1);
                ul.appendChild(li);
            });
        })
})