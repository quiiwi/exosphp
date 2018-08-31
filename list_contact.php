<?php
/*

    Sujet :
        1- Afficher dans une table HTML (avec doctype...) la liste des contacts avec les champs nom, prénom et téléphone, et un champ supplémentaire "autres infos" qui est un lien qui permet d'afficher le détail de chaque contact.

        2- Afficher sous la table HTML, le détail du contact quand on clique sur son lien "autres infos"



*/
$pdo = new PDO('mysql:host=localhost;dbname=contact', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

$contacts = $pdo->query("SELECT id_contact, nom, prenom, telephone FROM contact ORDER BY nom DESC");

 //------------------- PERSO-------------
$details = $pdo->query("SELECT annee_rencontre, email, type_contact FROM contact ORDER BY nom DESC");
 //------------------- PERSO-------------

$afficherdetails='';
$afficher= '';

 //------------------- PERSO-------------
$yolo = false;
 //------------------- PERSO-------------

$afficher .= '<table border="1">';

    $afficher .= '<tr>';

        $afficher .= '<th>Nom</th>';
        $afficher .= '<th>Prénom</th>';
        $afficher .= '<th>Téléphone</th>';
        $afficher .= '<th>Détails</th>';

        //------------------- PERSO-------------
        if(isset($_GET['id_contact'])){
            $afficher .= '<th>annee_rencontre</th>';
            $afficher .= '<th>email</th>';
            $afficher .= '<th>type_contact</th>';

        }
        //-------------------- PERSO-------------

    $afficher .= '</tr>';

while($ligne = $contacts->fetch(PDO::FETCH_ASSOC)) {

    $afficher .= '<tr>';

        $afficher .= '<td>' . $ligne['nom'] . '</td>';
        $afficher .= '<td>' . $ligne['prenom'] . '</td>';
        $afficher .= '<td>' . $ligne['telephone'] . '</td>';

        $afficher .= '<td> <a href=?id_contact=' . $ligne['id_contact'] . '">Autres Infos</a></td>';

        //------------------- PERSO-------------
        if(isset($_GET['id_contact'])){
            /*
            while($ligne2 = $details->fetch(PDO::FETCH_ASSOC)){
                $afficher .= '<td>' . $ligne2['annee_rencontre'] . '</td>';
                $afficher .= '<td>' . $ligne2['email'] . '</td>';
                $afficher .= '<td>' . $ligne2['type_contact'] . '</td>';
                if(isset($_GET['id_contact'])){
                    $afficher .= '</tr>';
                }
                break;
            }
            */

            $details = $pdo->prepare("SELECT annee_rencontre, email, type_contact FROM contact WHERE id_contact = :id_contact" );

            $details->bindParam(':id_contact', $_GET['id_contact']);

            $details->execute();


            $afficherdetails .= '<table style="" border="1">';

            while($ligne2 = $details->fetch(PDO::FETCH_ASSOC)){
            $afficherdetails .= '<tr>';

            $afficherdetails .= '<td>' . $ligne2['annee_rencontre'] . '</td>';
            $afficherdetails .= '<td>' . $ligne2['email'] . '</td>';
            $afficherdetails .= '<td>' . $ligne2['type_contact'] . '</td>';

            $afficherdetails .= '</tr>';
        }

            $afficherdetails .= '</table>';













        }
    if(!isset($_GET['id_contact'])){
        $afficher .='</tr>';
    }
    //------------------- PERSO-------------

}

$afficher .= '</table>';

//----------------2eme table--------------



if(isset($_GET['id_contact'])){ //si existe l'indice "id_contact" dans $_get, c'est que cet indice est passé dans l'url, donc que l'internaute a cliqué sur un des liens "autres infos"


  //  $_GET['id_contact'] = htmlspecialchars($_GET['id_contact', ENT_QUOTES]); // pour se prémunir des injections CSS ou JS via l'url


    $details = $pdo->prepare("SELECT annee_rencontre, email, type_contact FROM contact WHERE id_contact = :id_contact" );

    $details->bindParam(':id_contact', $_GET['id_contact']);

    $details->execute();

  //  $contact = $resultat->fetch(PDO::FETCH_ASSOC);
/*
    foreach($contact as $valeur){
        $contenu .= '<p>'.$valeur.'</p>';
    }
*/
    
    $afficherdetails .= '<table style="" border="1">';

    while($ligne2 = $details->fetch(PDO::FETCH_ASSOC)){
        $afficherdetails .= '<tr>';

            $afficherdetails .= '<td>' . $ligne2['annee_rencontre'] . '</td>';
            $afficherdetails .= '<td>' . $ligne2['email'] . '</td>';
            $afficherdetails .= '<td>' . $ligne2['type_contact'] . '</td>';

        $afficherdetails .= '</tr>';
    }

    $afficherdetails .= '</table>';
    

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Rencontres</title>

</head>
<body>
    <?php     
        echo $afficher;
        echo $afficherdetails;
    ?>
</body>



</html>
