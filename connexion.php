<?php

require ("connect.php");

$loginUser="";
$passUser="";
if(isset($_POST['login']) && isset($_POST['passe']) ){ // mettre name
$loginUser= $_POST['login'];
$passUser= $_POST['passe'];
 $response = $connexion->prepare("SELECT count(*)
    FROM users
    WHERE loginUser = :loginUser and passUser = :passUser ");
    $response->execute(array(
    'loginUser' => $loginUser,
    'passUser' => $passUser
    ));
    if ($ligne = $response->fetch()) {
        if ($ligne[0] == '1'){
        echo 'Success';
        exit();
        } else {
        echo ' mot de passe erroné !';
        exit();
        }
    }
}

    ?>
   
