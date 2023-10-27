<!-- A partir de votre base de données biens immobilier qui se nomme normalement test

1) Créer un formulaire qui permet d'ajouter un client.
 	- sans css et sans test javascript pour savoir si le formulaire est valide ou non. Faire les tests en HTML pure

2) Faire le script Ajax + php qui permet d'ajouter un client. Le script doit vider le formulaire si le client a été ajouté et afficher le message 'Client ajouté' si erreur afficher un message contenant les champs contenant des erreurs 

Sur la même page que le défi précédent, afficher la liste de tous les clients (uniquement le nom). A côté de chaque nom, afficher un bouton voir plus.
Au clic sur le bouton voir plus, afficher l'adresse et la date de naissance du client en question.
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="main.js" defer></script>
    <style>button{margin-left: 10px;}</style>
    <title>Ajout de client</title>
</head>
<body>
    <form method="POST">
        <label for="form--name">Nom</label>
        <input type="text" id="form--name" name="name" required>
        <label for="form--firstname" >Prénom</label>
        <input type="text" id="form--firstname" name="firstname" required>
        <label for="form--address">Adresse</label>
        <input type="text" id="form--address" name="address" required>
        <label for="form--birthdate">Date de naissance</label>
        <input type="date" id="form--birthdate" name="birthdate" required>
        <input type="submit" value="Valider">
    </form>
    <p></p>
    <ul></ul>
</body>
</html>