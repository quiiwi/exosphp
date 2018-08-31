<?php
/*

Sujet :
    -Créer une fonction qui permet de convertir une date FR en date US, ou inversement.
    Cette fonction prend 2 paramètres : une date et le format de conversion "US" ou "FR".

    -Vous validez que le paramètre format de sortie est bien "US" ou "FR". La fonction retourne un message si ce n'est pas le cas.

*/

// Préambule à l'exercice :
$affichage = ';';
$aujourdhui = date('d-m-Y'); //donne la date du jour au format indiqué
echo $aujourdhui. '<br>' ;

//-----
// Convertir une date d'un format vers un autre :
$date = '2018-08-24';
echo 'La date au format US : '.$date.'<br>';
$objetDate = new DateTime($date);
echo 'La date au format FR : '.$objetDate->format('d-m-Y').'<br>'; // la méthode format() permet de convertir n objet date selon le format indiqué

echo '<hr>';

// Votre exercice :


//function convertirLaDate($dateentree){
//    if($dateentree == /*format('d-m-Y')*/){
//        $nouveaudateentree = new DateTime($dateentree);
//        echo $nouveaudateentree->format('Y-m-d');
//    } elseif($dateentree == '2000-11-22'/*format('Y-m-d')*/){
//        $nouveaudateentree = new DateTime($dateentree);
//        echo $nouveaudateentree->format('d-m-Y');
//    } else{
//        echo '<p> la date entrée n\'est pas valide </p>';
//    }
//}

//echo convertirLaDate('2000-11-22');



function convertirLaDate($dateentree, $format){

    if($format !='US' && $format != 'FR'){
        return 'Erreur sur le format !';
    }



    if($format == 'US' ){
        $nouveaudateentree = new DateTime($dateentree);
        return $nouveaudateentree->format('Y-m-d');
    }
    if($format == 'FR' ){
        $nouveaudateentree = new DateTime($dateentree);
        return $nouveaudateentree->format('d-m-Y');
    }
}

echo convertirLaDate('2000-11-22','FR').'<br>';
echo convertirLaDate('2000-11-22','US').'<br>';
echo convertirLaDate('2000-11-22','RF').'<br>';
