<?php

require("connect.php");


// Préparation de la requête de suppression avec le marqueurs nommé :code
    $sql = "delete from clients where idClient=:code";
    $reponse = $connexion->prepare($sql);

    // Récupération du code passé en GET à partir du lien hypertexte
    $code= $_GET["code"]; // récupère la valeur de la variable du index.php

    // Exécution de la requête préparée de suppression
    $reponse->execute( array(":code"=>$code));

    // Retour à la liste des articles
    header("location:liste.php");

?>