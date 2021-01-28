<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Ajout d'un nouveau client</title>
</head>
<body>
<?php
require("connect.php");


if(isset($_POST["submit"])){

$erreurs=array();

$telephone = $_POST["telephone"];

function numeroTelephone($telephone){

    if(preg_match("/^(0{1}[0-9]{1}([0-9]{2}){4})$/",$telephone))
    {
        return $telephone;
    }else{
        return false;
    }
}

if(filter_var($telephone, FILTER_CALLBACK, array("options"=>"numeroTelephone"))===false){
    $erreurs["telephone"]="Numéro de téléphone invalide.<br/>";
}

$adresse = $_POST["adresse"];

function adresse($adresse){

  if(preg_match("/(\d+)?,?\s?(bis|ter|quater)?,?\s?(rue|avenue|boulevard|r|av|ave|bd|bvd|square|sente|impasse|cours|bourg|allée|résidence|parc|rond-point|chemin|côte|place|cité|quai|passage|lôtissement|hameau)?\s([a-zA-Zà-ÿ0-9\s]{2,})+$/",$adresse))
    {
        return $adresse;
    }else{
        return false;
    }
}

if(filter_var($adresse, FILTER_CALLBACK, array("options"=>"adresse"))===false){
    $erreurs["adresse"]="adresse invalide.<br/>";
}


$villeClient = $_POST["ville"];

function ville($villeClient){

  if(preg_match("/^[[:alpha:]]([-' ]?[[:alpha:]])*$/",$villeClient))
    {
        return $villeClient;
    }else{
        return false;
    }
}

if(filter_var($villeClient, FILTER_CALLBACK, array("options"=>"ville"))===false){
    $erreurs["ville"]="ville invalide.<br/>";
}

$codePostalClient = $_POST["codepostal"];

function CodePostal($codePostalClient){

  if(preg_match("/^(([0-8][0-9])|(9[0-5])|(2[ab]))[0-9]{3}$/",$codePostalClient))
    {
        return $codePostalClient;
    }else{
        return false;
    }
}

if(filter_var($codePostalClient, FILTER_CALLBACK, array("options"=>"codepostal"))===false){
    $erreurs["codepostal"]="code postal invalide.<br/>";
}

$CA = $_POST["ca_client"];
$effectif =$_POST["effectif"];

function getValidateFilter($type)
    {
        switch($type){
        case "email":
        $filter=FILTER_VALIDATE_EMAIL;
        break;
        case "int":
        $filter=FILTER_VALIDATE_INT;
        break;
        case "boolean":
        $filter=FILTER_VALIDATE_BOOLEAN;
        break;
        case "ip":
        $filter=FILTER_VALIDATE_IP;
        break;
        case "url":
        $filter=FILTER_VALIDATE_URL;
        break;
        default://important!!!
        $filter=false;//Si type est faux,la validation échoue.
        }
        return $filter;
    }

    if((filter_var($CA, getValidateFilter("int"))===false)) {
       $erreurs["ca_client"]="Veuillez saisir un nombre";
    }

    
// if( filter_var($CA,FILTER_VALIDATE_INT )===false){
//   $erreurs["ca_client"]="veuillez saisir un nombre.";
// }

// if( filter_var($effectif,FILTER_VALIDATE_INT  )===false){
//   $erreurs["effectif"]="veuillez saisir un nombre.";
// }
if(empty($erreurs)){

$sql = "insert into clients (idSect,raisonSociale,codePostalClient,adresseClient,villeClient,CA,effectif,telephoneClient,typeClient,natureClient,commentaireClient) values (:idSect, :raisonSociale,:codePostalClient,:adresseClient,:villeClient,:CA,:effectif,:telephoneClient,:typeClient,:natureClient,:commentaireClient)";
$reponse = $connexion->prepare($sql);

$sect                  = $_POST["activite"];
$raisonSociale        = $_POST["raison"];
$codePostalClient    =$_POST["codepostal"];
$adresse            =$_POST["adresse"];
$villeClient         =$_POST["ville"];
$CA                  =$_POST["ca_client"];
$effectif           =$_POST["effectif"];
$telephone           =$_POST["telephone"];
$typeClient          =$_POST["type"];
$natureClient        =$_POST["nature"];
$commentaire        =$_POST["comm"];


$reponse->bindValue(":idSect", $sect, PDO::PARAM_STR);
$reponse->bindValue(":raisonSociale", $raisonSociale, PDO::PARAM_STR);
$reponse->bindValue(":codePostalClient", $codePostalClient, PDO::PARAM_STR);
$reponse->bindValue(":adresseClient", $adresse, PDO::PARAM_STR);
$reponse->bindValue(":villeClient", $villeClient, PDO::PARAM_STR);
$reponse->bindValue(":CA", $CA, PDO::PARAM_STR);
$reponse->bindValue(":effectif", $effectif, PDO::PARAM_STR);
$reponse->bindValue(":telephoneClient", $telephone, PDO::PARAM_STR);
$reponse->bindValue(":typeClient", $typeClient, PDO::PARAM_STR);
$reponse->bindValue(":natureClient", $natureClient, PDO::PARAM_STR);
$reponse->bindValue(":commentaireClient", $commentaire, PDO::PARAM_STR);
$reponse->execute();

header("location:liste.php");
}
?>


<header>
    <div class="image">
    <button type="button" class="btn btn-primary"><a class="retour" href=liste.php? id="ref_retour">Retour</a></button>
    <img class="img1" src="img/logo.png"/>
    <p><h1>Ajout d'un Nouveau Client</h1></p>
    </div>
</header>
    
<br><br>

<form action="<?php echo $_SERVER["SCRIPT_NAME"]?>" method="post">
<table class="table table-bordered table-dark">
  <tbody>
    <tr>
      <td >Raison Sociale</t>
      <td ><input type="text" name="raison" id="raison" size="20"/></td>
      <td></td>
</tr>
    <tr>
      <td >Type Client</th>
      <td ><select name="type"><option>public</option><option>prive</option></select></td>
      <td></td>
</tr>
<tr>
      <td >Telephone Client</th>
      <td ><input type="text" name="telephone" value="<?php if(!empty($_POST["telephone"])){ echo $_POST["telephone"];}?>"/></td>
      <td style="color:red"> <?php if(isset($erreurs["telephone"])){ echo $erreurs["telephone"];}?></td>
</tr>
<tr>
      <td>Adresse Client</td>
      <td><input type="text" name="adresse" value="<?php if(!empty($_POST["adresse"])){ echo $_POST["adresse"];}?>"/></td>
      <td style="color:red" > <?php if(isset($erreurs["adresse"])){ echo $erreurs["adresse"];}?></td>      
</tr>
<tr>
      <td>Ville</td>
      <td><input type="text" name="ville" value="<?php if(!empty($_POST["ville"])){ echo $_POST["ville"];}?>" /></td>
      <td style="color:red"><?php if(isset($erreurs["ville"])){ echo $erreurs["ville"];}?> </td>
</tr>
<tr>
      <td>Code Postal</td>
      <td><input type="text" name="codepostal" value="<?php if(!empty($_POST["codepostal"])){ echo $_POST["codepostal"];}?>"/></td>
      <td style="color:red"><?php if(isset($erreurs["codepostal"])){ echo $erreurs["codepostal"];}?> </td>
</tr> 
    <tr>
      <td>Activité</td>
      <td><select name="activite"><

      <?php
           $sql = "select idSect, activite from secteuractivite";
           $reponse = $connexion->prepare($sql);
           $reponse->execute(array());
           while ($donnees = $reponse->fetch()) {
          echo '<option class="option" value='. $donnees["idSect"] . '>' . $donnees["activite"] . '</option>';
          };
    ?>

      </select></td>
      <td></td>
    </tr>  
    <tr>
      <td>Nature</td>
      <td><select name="nature"><option>Principale</option><option>Secondaire</option><select></td>
      <td></td>
    </tr>
    <tr>
      <td>CA</td>
      <td><input type="text" name="ca_client" value="<?php if(!empty($_POST["ca_client"])){ echo $_POST["ca_client"];}?>"/></td>
      <td style="color:red" > <?php if(isset($erreurs["ca_client"])){ echo $erreurs["ca_client"];}?></td>
    </tr>
    <tr>
      <td>Effectif</td>
      <td><input type="text" name="effectif" value="<?php if(!empty($_POST["effectif"])){ echo $_POST["effectif"];}?>"/></td> /></td>
      <td style="color:red" ><?php if(isset($erreurs["effectif"])){ echo $erreurs["effectif"];}?>
    </td>
    </tr>
    <tr>
      <td>Commentaires Commerciaux</td>
      <td><input type="text" name="comm" id="nom" size="20"/></td>
      <td></td>
    </tr>
    <td><button   type="submit" name="submit" class="btn btn-primary">Valider</button></td>
      <td><button type="reset"class="btn btn-primary" >Annuler</button></td>
      <td></td>
    </tr>           
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
<?php
}else{

  
  ?>

  <header>
  <div class="image">
  <button type="button" class="btn btn-primary"><a class="retour" href=liste.php? id="ref_retour">Retour</a></button>
  <img class="img1" src="img/logo.png"/>
  <p><h1>Ajout d'un Nouveau Client</h1></p>
  </div>
</header>
  
<br><br>

<form action="<?php echo $_SERVER["SCRIPT_NAME"]?>" method="post">
<table class="table table-bordered table-dark">
<tbody>
  <tr>
    <td >Raison Sociale</t>
    <td ><input type="text" name="raison" id="raison" size="20"/></td>
    <td></td>
</tr>
  <tr>
    <td >Type Client</th>
    <td ><select name="type"><option>public</option><option>prive</option></select></td>
    <td></td>
</tr>
<tr>
    <td >Telephone Client</th>
    <td ><input type="text" name="telephone"/></td>
    <td> </td>
</tr>
<tr>
    <td>Adresse Client</td>
    <td><input type="text" name="adresse" id="adresse" size="20"/></td>
    <td> 
    
    </td>
</tr>
<tr>
    <td>Ville</td>
    <td><input type="text" name="ville" id="ville" size="20"/></td>
    <td>
    </td>
  </tr>
  <tr>
    <td>Code Postal</td>
    <td><input type="text" name="codepostal" id="codepostal" size="20"/></td>
    <td>
  </td>
  </tr> 
  <tr>
    <td>Activité</td>
    <td><select name="activite">

    <?php
         $sql = "select idSect, activite from secteuractivite";
         $reponse = $connexion->prepare($sql);
         $reponse->execute(array());
         while ($donnees = $reponse->fetch()) {
        echo '<option class="option" value='. $donnees["idSect"] . '>' . $donnees["activite"] . '</option>';
        };
  ?>

    </select></td>
    <td></td>
  </tr>  
  <tr>
    <td>Nature</td>
    <td><select name="nature"><option>Principale</option><option>Secondaire</option><select></td>
    <td></td>
  </tr>
  <tr>
    <td>CA</td>
    <td><input type="text" name="ca_client" id="nom" size="20"/></td>
    <td>
   
  </td>
  </tr>
  <tr>
    <td>Effectif</td>
    <td><input type="text" name="effectif" id="nom" size="20"/></td>
    <td>
  </td>
  </tr>
  <tr>
    <td>Commentaires Commerciaux</td>
    <td><input type="text" name="comm" id="nom" size="20"/></td>
    <td></td>
  </tr>
  <td><button   type="submit" name="submit" class="btn btn-primary">Valider</button></td>
    <td><button   type="reset"class="btn btn-primary" >Annuler</button></td>
    <td></td>
  </tr>           
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
<?php
}
?>
</body>
</html>