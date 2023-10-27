const formlaire = document.querySelector("form");
formlaire.addEventListener('submit',(e) =>{
    e.preventDefault();
    const formData = new FormData(formlaire);
    fetch("ajax_create.php",{
        method:"post",
        body: formData,
    }).then((Response) =>{
        console.log(Response)
        formlaire.reset();
        return Response.json();

    }).then((data) =>{
        console.log(data)
    })
})