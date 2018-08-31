<?php
/* Sujet :

    1- Créer une base de données "contact" avec une table "contact" :
        -id_contact      PK AI INT(3)
        -nom             VARCHAR(20)
        -prenom          VARCHAR(20)
        -telephone       VARCHAR(10)
        -annee_rencontre YEAR
        -email           VARCHAR(255)
        -type_contact    ENUM('ami', 'famille', 'professionnel', 'autre')

    2- Créer un formulaire HTML (avec doctype...) afin d'ajouter des contacts dans la BDD. Le champ année est un menu déroulant de l'année en cours à 100 ans en arrière à rebours, et le type de contact est aussi un menu déroulant.

    3- Sur le formulaire, effectuer les contôles nécessaires :
        -Les champs nom et prénom contiennent 2 catactères minimim.
        -Le champ téléphone contient 10 chiffres.
        -L'année de rencontre doit être une année valide.
        -Le type de contact doit être conforme à la liste des contacts.
        -L'email doit être valide.
        En cas d'erreur de saisie, afficher les messages d'erreur au-dessus du formulaire.

    4- Ajouter les contacts à la BDD et afficher un message en cas de succès ou en cas d'échec.

*/

$pdo = new PDO('mysql:host=localhost;dbname=contact', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
   
	<title>Ma Boutique</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>

<?php

$inscription = false;

$alert='';

if(!empty($_POST)){

    if (!isset($_POST['nom']) || strlen($_POST['nom']) <2 || strlen($_POST['nom']) >20    ) $alert .= '<div class="bg-danger">Le nom doit contenir entre 4 et 20 caractères.</div>';

    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) <2 || strlen($_POST['prenom']) >20    ) $alert .= '<div class="bg-danger">Le prénom doit contenir entre 4 et 20 caractères.</div>';

    if (!isset($_POST['telephone']) || !ctype_digit($_POST['telephone']) || strlen($_POST['telephone']) != 10) $alert .= '<div class="bg-danger">Le numéro de téléphone est incorrect.</div>';

    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $alert .= '<div class="bg-danger">L\'email n\'est pas correct.</div>';// fonctionne aussi pour valider les URL

    if (!isset($_POST['type_contact']) || ($_POST['type_contact'] != 'ami' && $_POST['type_contact'] != 'famille' && $_POST['type_contact'] != 'professionnel' && $_POST['type_contact'] != 'autre')) $alert .= '<div class="bg-danger">Le type de contact n\'est pas valide.</div>';


    //autre façon de vérifier la date
    // if (!isset($_POST['annee_rencontre']) || !ctype_digit($_POST['annee_rencontre']) || $-POST['annee_rencontre'] < (date('Y')-100) || $_POST['annee_rencontre'] > date('Y')  ) $alert .= '<div class="bg-danger">La date n\'est pas valide.</div>';


    function validateDate($date, $format = 'd-m-Y') { 
		
		$d = DateTime::createFromFormat($format, $date); 

		if ($d && $d->format($format) == $date) {
			return true;
		} else {
			return false;
		}	
	}

    if (!isset($_POST['annee_rencontre']) || !validateDate($_POST['annee_rencontre'], 'Y') || $_POST['annee_rencontre'] < (date('Y')-100) || $_POST['annee_rencontre'] > date('Y')) $alert .= '<div class="bg-danger">La date n\'est pas valide.</div>';

    if (empty($alert)){

        foreach($_POST as $indice => $valeur) {
			$_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
        }
        
        $result = $pdo->prepare("INSERT INTO contact (nom, prenom, telephone, annee_rencontre, email, type_contact) VALUES (:nom, :prenom, :telephone, :annee_rencontre, :email, :type_contact) ");

		$result->bindParam(':nom', $_POST['nom']);
		$result->bindParam(':prenom', $_POST['prenom']);
		$result->bindParam(':telephone', $_POST['telephone']);
		$result->bindParam(':annee_rencontre', $_POST['annee_rencontre']);
		$result->bindParam(':email', $_POST['email']);
		$result->bindParam(':type_contact', $_POST['type_contact']);


        $req = $result->execute();

        if ($req) {
			$alert .= '<div>le contact a bien été ajouté.</div>';
		} else {
			$alert .= '<div>Une erreur est survenue lors l\'ajout du contact.</div>';
		}

    } //fin du if (empty($alert))

} //fin du if(!empty($_POST)){

echo $alert;

if(!$inscription) :

?>
    <h1 class="mt-4">Inscription</h1>

    <p>Veuillez renseigner le formulaire pour vous inscrire.</p>

    <form method="post" action="">
        <label for="nom">Nom</label><br>
        <input type="text" name="nom" id="nom" value="" place-holder="yy"><br><br>

        <label for="prenom">Prenom</label><br>
        <input type="text" name="prenom" id="prenom" value=""><br><br>

        <label for="telephone">Téléphone</label><br>
        <input type="text" name="telephone" id="telephone" value=""><br><br>

        <label for="annee_rencontre">Année de rencontre</label><br>

<?php
        $annees = '';
            $annees .= '<select name="annee_rencontre" class="custom-select col-sm-2">';
            for($i = date('Y'); $i >= date('Y')-100; $i--){ // date('Y') donne l'année en cours soit 2018.
                $annees .= "<option>". $i ."</option>";
            }
            $annees .= '</select> <br>';
        echo $annees;
?>

        <label for="email">email</label><br>
        <input type="text" name="email" id="email" value=""><br><br>

        <label for="type_contact">Le type de contact</label><br>
        <select name="type_contact" class="custom-select col-sm-2">
            <option value="ami">ami</option>
            <option value="famille">famille</option>
            <option value="professionnel">professionnel</option>
            <option value="autre">autre</option>
        </select><br><br>
        
        <input type="submit" name="inscription" value="s'inscrire" class="btn">

    </form>

<?php

endif;