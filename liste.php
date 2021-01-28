<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<?php
  
require("connect.php");

if ((!isset($_GET['clic'])) || empty($_GET['clic'])) {
  
  // Récupération des personnes dans la Table membres classées par ordre alphabétique
  $sql = "select idClient, raisonSociale, codePostalClient, villeClient, CA, telephoneClient, typeClient, natureClient from clients order by raisonSociale";
  $reponse = $connexion->prepare($sql);
  $reponse->execute(array());
} else {
  $clic = htmlspecialchars($_GET['clic']);
  $reponse = $connexion->query('SELECT idClient, raisonSociale, codePostalClient, villeClient, CA, telephoneClient, typeClient, natureClient FROM clients WHERE raisonSociale LIKE "'.$clic.'%" ORDER BY idSect DESC');
  $reponse->execute(array());
};



   
?>

<body >

<header>
<div class="image">
    
<a  href=index.php ><img class="img1" src="img/logo.png"/></a> 
    <p><h1>Liste des Clients</h1></p>
    
</div>
</header>

<br>
<br>
<form method = "GET">
        <p>
            <label for="raisonsociale">Raison Sociale:</label>
            <input type = "text" name = "clic" size="20" placeholder="Veuillez saisir le nom du client" />
            <button type="submit"  class="btn btn-secondary">Rechercher</button>
        </p>
        </form>       
<br>

<form method='post'action="traitement.php">

  
<a class="ajout" href=ajout.php? id="ref_ajout">Ajouter un Nouveau Client</a>

<table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">ID Client</th>
      <th scope="col">Raison Sociale</th>
      <th scope="col">Code Postal Client</th>
      <th scope="col">Ville Client</th>
      <th scope="col">CA (€)</th>
      <th scope="col">Telephone Client</th>
      <th scope="col">Type Client</th>
      <th scope="col">Nature Client</th>
      <th scope="col">Supprimer un Client</th>
    </tr>
  </thead>
  <tbody>

  <?php 
   
   
   while ($donnees = $reponse->fetch()) {
       echo '<tr>
       <td >' . $donnees["idClient"] . '</td>
       <td ><a href=modif.php?code=' . $donnees["idClient"] .'>' . $donnees["raisonSociale"] . '</a></td>
       <td >'. $donnees["codePostalClient"] . '</td>
       <td >' . $donnees["villeClient"] .'</td>
       <td >' . $donnees["CA"] . '</td>
       <td >' . $donnees["telephoneClient"] . '</td>
       <td >' . $donnees["typeClient"] . '</td>
       <td >' . $donnees["natureClient"] . '</td>
       
       </td>' .'<td><a href=traitement_supp.php?code=' . $donnees["idClient"] . '>Supprimer</a></td>
       </tr>';
   };
   
   ?>
  </tbody>
</table>
</form>

<footer>
<div class="image1">
    <img class="img" src="img/logo.png"/>
    <p><h1>ABI.COM</h1></p>
</div>

<div class="propos">
  <h3>Qui sommes nous?</h3>
  <ul>
  <li><a href="#">Rejoignez-nous</a></li>
  <li><a href="#">Actualité</a></li>
  <li><a href="#">Contact</a></li>
  </ul>
</div>

</footer>
</body>
</html>