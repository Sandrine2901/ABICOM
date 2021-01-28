<?php
define("BASE","abicom");
define("SERVER","localhost");
define("USER","root");
define("PASSWD","");



// si on met ce code faire require (connect.php) dans tous mes autres dossiers

 // Ouverture d'une connexion sur la Base magasin du SGBD MySQL
 $dsn = "mysql:dbname=" . BASE . "; host=" . SERVER;
 try {
     $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

     $connexion = new PDO($dsn, "root", "", $option);

 } catch (PDOException $e) {
     printf("Echec connexion : %s\n", $e->getMessage());
 }
?>