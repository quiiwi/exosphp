<?php
/*
    Sujet :
        1- Créer une BDD "restaurant" avec une table "restaurant" :
            id_restaurant       PK AI INT(3)
            nom                 VARCHAR(100)
            adresse             VARCHAR(255)
            telephone           VARCHAR(10)
            type                ENUM('gastronomique','brasserie','pizzeria','autre')
            note                INT(1)
            avis                TEXT

        2- Créer un formulaire HTML (avec doctype....) afin d'ajouter un restaurant en bdd. Les champs type et note (de 1 à 5) sont des menus déroulants.

        3- Effectuer les vérifications nécessaires :
            Le champ nom contient 2 caractères minimum
            Le champ adresse ne doit pas être vide
            Le téléphone doit contenir 10 chiffres
            Le type doit être conforme à la liste des types de la BDD
            La note est un entier entre 0 et 5
            L'avis ne doit pas être vide.
            En cas d'erreur de saisie, afficher un message au-dessus du formulaire.

        4- Ajouter un ou plusieurs restaurant à la BDD et afficher un message de succès ou d'échec lors de l'enregistrement.

*/
$pdo = new PDO('mysql:host=localhost;dbname=restaurant', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

$alert='';

if(!empty($_POST)){

    if (!isset($_POST['nom']) || strlen($_POST['nom']) <2 || strlen($_POST['nom']) >100    ) $alert .= '<div class="bg-danger">Le nom du restaurant doit contenir entre 2 et 100 caractères.</div>';

    if (!isset($_POST['adresse']) || strlen($_POST['adresse']) <2 || strlen($_POST['adresse']) >255    ) $alert .= '<div class="bg-danger">L\'adresse du restaurant doit contenir entre 2 et 100 caractères.</div>';

    if (!isset($_POST['note']) || strlen($_POST['note']) != 1  || $_POST['note'] < 0 || $_POST['note'] > 5 ) $alert .= '<div class="bg-danger">Il y a une erreur dans la note.</div>';

    if (!isset($_POST['telephone']) || !ctype_digit($_POST['telephone']) || strlen($_POST['telephone']) != 10) $alert .= '<div class="bg-danger">Le numéro de téléphone est incorrect.</div>';

    if (!isset($_POST['type']) || ($_POST['type'] != 'gastronomique' && $_POST['type'] != 'brasserie'  && $_POST['type'] != 'pizzeria' && $_POST['type'] != 'grec' && $_POST['type'] != 'fastfood' && $_POST['type'] != 'autre' )) $alert .= '<div class="bg-danger">Le type entré est invalide</div>';

    if (!isset($_POST['avis']) || strlen($_POST['avis']) < 2 || strlen($_POST['avis']) > 255) $alert .= '<div class="bg-danger">Donnez nous votre avis !</div>';

    if (empty($alert)){

        foreach($_POST as $indice => $valeur) {
			$_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
        }

        $result = $pdo->prepare("INSERT INTO restaurant (nom, adresse, telephone, type, note, avis) VALUES (:nom, :adresse, :telephone, :type, :note, :avis) ");

		$result->bindParam(':nom', $_POST['nom']);
		$result->bindParam(':adresse', $_POST['adresse']);
		$result->bindParam(':telephone', $_POST['telephone']);
		$result->bindParam(':type', $_POST['type']);
		$result->bindParam(':note', $_POST['note']);
		$result->bindParam(':avis', $_POST['avis']);


        $req = $result->execute();

        if ($req) {
			$alert .= '<div>Le restaurant a bien été ajouté.</div>';
		} else {
			$alert .= '<div>Une erreur est survenue lors l\'ajout du restaurant.</div>';
		}




    } //fin du if (empty($alert)){





} //fin du if(!empty($_POST)){


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap Core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <title>Restaurant</title>
</head>
<body>

    <?php echo $alert; ?>

    <form method="post" action="">
            <label for="nom">Nom du restaurant</label><br>
            <input type="text" name="nom" id="nom"><br><br>
    
            <label for="type">Le type de restaurant</label><br>
            <select name="type">
                <option value="gastronomique">gastronomique</option>
                <option value="brasserie">brasserie</option>
                <option value="pizzeria">pizzeria</option>
                <option value="grec">grec</option>
                <option value="fastfood">fastfood</option>
                <option value="autre">autre</option>
            </select><br><br>
    
            <label for="adresse">Adresse du restaurant</label><br>
            <input type="text" name="adresse" id="adresse"><br><br>
    
            <label for="telephone">Téléphone du restaurant</label><br>
            <input type="text" name="telephone" id="telephone"><br><br>

            <label for="note">Note du restaurant</label><br>
            <select name="note">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br><br>

            <label for="avis">Avis du restaurant</label><br>
            <input type="text" name="avis" id="avis"><br><br>

            <input type="submit" name="inscription" value="Notez" class="btn">
    
    
    </form>







</body>
</html>


<?php