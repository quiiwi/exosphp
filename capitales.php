<?php
/* 
Vous créez un tableau PHP contenant les pays suivants :
    -France
    -Italie
    -Espagne
    -Inconnu
    -Allemagne

Vous leur associez les valeurs suivantes :
    -Paris
    -Rome
    -Madrid
    - '?'
    -Berlin

Vous parcourez ce tableau pour afficher la phroase "La capitale X se situe en Y" dans un <p>, où X remplace la capitale et Y le pays

Pour le pays "inconnu", vous affichez "La capitale de inconnu n'existe pas!" à la place de la phrase précédente.

*/

$affichage ='';

$capitalesEtLeursPays = array(
                'FRANCE'=>'PARIS',
                'ITALIE'=>'ROME',
                'ESPAGNE'=>'MADRID',
                'INCONNU'=>'INCONNU',
                'ALLEMAGNE'=>'BERLIN',);

foreach($capitalesEtLeursPays as $indice => $valeur){ 
    //$affichage .= $valeur . '<br>';
/*
    if($valeur == 'INCONNU'){
        $affichage .= '<p> La capitale de inconnu n\'existe pas ! <p>';
    } elseif($valeur == 'PARIS'){
        $affichage .= '<p>La capitale de la '.$indice. ' est ' .$valeur.'!</p>';
    } else{
        $affichage .= '<p>La capitale de l\''.$indice. ' est ' .$valeur.'!</p>';
    }
*/
    if($valeur == 'INCONNU'){
        $affichage .= '<p> La capitale de inconnu n\'existe pas ! <p>';
    } else{
        $affichage .= '<p>La capitale '.$valeur.' se situe en '.$indice.'</p>';
    }
}

?>
    <h1> Les Pays et leurs Capitales !</h1>






<?php

echo $affichage;