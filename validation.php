<?php
require_once("function.php");
$dataErrors=array();

//validation du telephone
$telephone=filter_var($telephone,getSanitizeFilter("string"));
$dataErrors["email"]="Erreur: le téléphone est invalide.";

//validation d'adresse'
$adresse=filter_var($adresse,getSanitizeFilter("string"));
$dataErrors["email"]="Erreur: l'adresse est invalide.";


//validation ville client
$villeClient=filter_var($villeClient,getSanitizeFilter("string"));

//validation de code postal
if( filter_var($email, getValidateFilter("email") )===false){
    $dataErrors["email"]="Erreur: l'adresse mail est invalide.";
}

//validation CA
$categorie=filter_var($categorie,getSanitizeFilter("string"));



// validation effectif
?>