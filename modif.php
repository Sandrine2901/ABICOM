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

$sql = "select * from clients where idClient = :code";
$reponse = $connexion->prepare($sql);
$reponse->execute(array(":code" => $_GET["code"]));
$data = $reponse->fetch();

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
  
      if(empty($erreurs)){


$sql = "update clients set idSect=:idSect, raisonSociale=:raisonSociale,codePostalClient=:codePostalClient,adresseClient=:adresseClient,villeClient=:villeClient,CA=:CA,effectif=:effectif,
telephoneClient=:telephoneClient,typeClient=:typeClient,natureClient=:natureClient,commentaireClient=:commentaireClient where idClient=:code";
$reponse = $connexion->prepare($sql);
var_dump($_POST);



$sect                  = $_POST["activite"];
$raisonSociale        = $_POST["raison"];
$typeClient          =$_POST["type"];
$natureClient        =$_POST["nature"];
$commentaire        =$_POST["comm"];
$code                = $_POST["code"];




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
$reponse->bindValue(":code", $code, PDO::PARAM_STR);
$reponse->execute();

header("location:liste.php");
 
      }



?>
<header>
    <div class="image">
    <button type="button" class="btn btn-primary" ><a class="retour" href=liste.php? id="ref_retour">Retour</a></button>
    <img class="img1" src="img/logo.png"/>
    <p><h1>Modification du Client</h1></p>
    </div>
</header>    
<br><br>
<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"]."?code=".$_GET["code"]?>" >

<p>
<input type="hidden" name="code" id="code" value="<?=$data['idClient'] ?>">
</p>
<table class="table table-bordered table-dark">
  <tbody>
    <tr>
      <td >Raison Sociale</t>
      <td ><input type="text" name="raison" id="raison" size="20" value="<?=$data['raisonSociale'] ?>"/></td>
      <td></td>
    </tr>
    <tr>
      <td >Type Client</th>
      <td ><select name="type">
      <?php
      $sql = "select distinct typeClient from clients order by 1";
     $reponse = $connexion->prepare($sql);
     $reponse->execute();
     
      ?>
     
     <?php 
     while ($data1 = $reponse->fetch()) {

      if($data1['typeClient'] == $data['typeClient']) {
           echo '<option class="option" value='. $data1["typeClient"] . ' selected>' . $data1["typeClient"] . '</option>';
      } else {
          echo '<option class="option" value='. $data1["typeClient"] . '>' . $data1["typeClient"] . '</option>';
      }
  };
     ?>
      </select></td>
      <td></td>
</tr>
<tr>
      <td >Telephone Client</th>
      <td ><input type="text" name="telephone" value="<?php if(!empty($_POST["telephone"])){ echo $_POST["telephone"];}?>" /></td>
      <td style="color:red"> <?php if(isset($erreurs["telephone"])){ echo $erreurs["telephone"];}?></td>
</tr>
<tr>
      <td>Adresse Client</td>
      <td><input type="text" name="adresse"  value="<?php if(!empty($_POST["adresse"])){ echo $_POST["adresse"];}?>"/></td>
      <td style="color:red" > <?php if(isset($erreurs["adresse"])){ echo $erreurs["adresse"];}?></td>
      
</tr>
<tr>
      <td>Ville</td>
      <td><input type="text" name="ville" value="<?php if(!empty($_POST["ville"])){ echo $_POST["ville"];}?>"/>
      <td style="color:red"><?php if(isset($erreurs["ville"])){ echo $erreurs["ville"];}?> </td>
      
    </tr>
    <tr>
      <td>Code Postal</td>
      <td><input type="text" name="codepostal" id="codepostal" size="20"value="<?=$data['codePostalClient'] ?>" /></td>
      </td><?php if(!empty($_POST["codepostal"])){ echo $_POST["codepostal"];}?></td>
    </tr> 
    <tr>
      <td>Activité</td>
      <td><select name="activite">
      <?php
           $sql = "select idSect, activite from secteuractivite";
           $reponse = $connexion->prepare($sql);
           $reponse->execute(array());
           while ($data3 = $reponse->fetch()) {
            if($data3['idSect'] == $data['idSect']) {
              echo '<option class="option" value='. $data3["idSect"] . ' selected>' . $data3["activite"] . '</option>';
         } else {
             echo '<option class="option" value='. $data3["idSect"] . '>' . $data3["activite"] . '</option>';
         }
          };
    ?>
   </select></td>
   <td></td>
    </tr>  
    <tr>
      <td>Nature Client</td>
      <td><select name="nature" >
      <?php
      $sql = "select distinct natureClient from clients order by 1";
     $reponse = $connexion->prepare($sql);
     $reponse->execute();
     while ($data2 = $reponse->fetch()) {

      if($data2['natureClient'] == $data['natureClient']) {
           echo '<option class="option" value='. $data2["natureClient"] . ' selected>' . $data2["natureClient"] . '</option>';
      } else {
          echo '<option class="option" value='. $data2["natureClient"] . '>' . $data2["natureClient"] . '</option>';
      }
  };
     ?>
     <select> </td>
     <td></td>
    </tr>
    <tr>
      <td>CA</td>
      <td><input type="text" name="ca_client" id="nom" size="20"value= "<?php if(!empty($_POST["ca_client"])){ echo $_POST["ca_client"];}?>"/></td>
      <td style="color:red" > <?php if(isset($erreurs["ca_client"])){ echo $erreurs["ca_client"];}?></td> 
    </tr>
    <tr>
      <td>Effectif</td>
      <td><input type="text" name="effectif" id="nom" size="20" value="<?php if(!empty($_POST["effectif"])){ echo $_POST["effectif"];}?>" /></td>
      <td style="color:red" ><?php if(isset($erreurs["effectif"])){ echo $erreurs["effectif"];}?></td>
    </tr>
    <tr>
      <td>Commentaires Commerciaux</td>
      <td><input type="text" name="comm" id="nom" size="20" value="<?=$data['commentaireClient'] ?>"/></td>
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
  else
{

?>

<header>
    <div class="image">
    <button type="button" class="btn btn-primary" ><a class="retour" href=liste.php? id="ref_retour">Retour</a></button>
    <img class="img1" src="img/logo.png"/>
    <p><h1>Modification du Client</h1></p>
    </div>
</header>
    
<br><br>

<form method="post"  action="<?php echo $_SERVER["SCRIPT_NAME"]."?code=".$_GET["code"]?>">

<p>
<input type="hidden" name="code" id="code" value="<?=$data['idClient'] ?>">
</p>
<table class="table table-bordered table-dark">
  <tbody>
    <tr>
      <td >Raison Sociale</t>
      <td ><input type="text" name="raison" id="raison" size="20" value="<?=$data['raisonSociale'] ?>"/></td>
      <td></td>
</tr>
    <tr>
      <td >Type Client</th>
      <td ><select name="type">
      <?php
      $sql = "select distinct typeClient from clients order by 1";
     $reponse = $connexion->prepare($sql);
     $reponse->execute();
     
      ?>
     
     <?php 
     while ($data1 = $reponse->fetch()) {

      if($data1['typeClient'] == $data['typeClient']) {
           echo '<option class="option" value='. $data1["typeClient"] . ' selected>' . $data1["typeClient"] . '</option>';
      } else {
          echo '<option class="option" value='. $data1["typeClient"] . '>' . $data1["typeClient"] . '</option>';
      }
  };
     ?>
      </select></td>
      <td></td>
</tr>
<tr>
      <td >Telephone Client</th>
      <td ><input type="text" name="telephone" id="telephone" size="20"value="<?=$data['telephoneClient'] ?>" /></td>
      <td></td>
</tr>
<tr>
      <td>Adresse Client</td>
      <td><input type="text" name="adresse" id="adresse" size="20" value="<?=$data['adresseClient'] ?>"/></td>
      <td></td>
</tr>
<tr>
      <td>Ville</td>
      <td><input type="text" name="ville" id="ville" size="20"value="<?=$data['villeClient'] ?>" /></td>
      <td></td>
    </tr>
    <tr>
      <td>Code Postal</td>
      <td><input type="text" name="codepostal" id="codepostal" size="20"value="<?=$data['codePostalClient'] ?>" /></td>
      <td></td>
    </tr> 
    <tr>
      <td>Activité</td>
      <td><select name="activite">
      <?php
           $sql = "select idSect, activite from secteuractivite";
           $reponse = $connexion->prepare($sql);
           $reponse->execute(array());
           while ($data3 = $reponse->fetch()) {
            if($data3['idSect'] == $data['idSect']) {
              echo '<option class="option" value='. $data3["idSect"] . ' selected>' . $data3["activite"] . '</option>';
         } else {
             echo '<option class="option" value='. $data3["idSect"] . '>' . $data3["activite"] . '</option>';
         }
          };
    ?>

      </select></td>
      <td></td>
    </tr>  
    <tr>
      <td>Nature Client</td>
      <td><select name="nature" >
      <?php
      $sql = "select distinct natureClient from clients order by 1";
     $reponse = $connexion->prepare($sql);
     $reponse->execute();
     
    
     while ($data2 = $reponse->fetch()) {

      if($data2['natureClient'] == $data['natureClient']) {
           echo '<option class="option" value='. $data2["natureClient"] . ' selected>' . $data2["natureClient"] . '</option>';
      } else {
          echo '<option class="option" value='. $data2["natureClient"] . '>' . $data2["natureClient"] . '</option>';
      }
  };
     ?>
     <select> </td>
     <td></td>
    </tr>
    <tr>
      <td>CA</td>
      <td><input type="text" name="ca_client" id="nom" size="20"value="<?=$data['CA'] ?>" /></td>
      <td></td>
    </tr>
    <tr>
      <td>Effectif</td>
      <td><input type="text" name="effectif" id="nom" size="20" value="<?=$data['effectif'] ?>" /></td>
      <td></td>
    </tr>
    <tr>
      <td>Commentaires Commerciaux</td>
      <td><input type="text" name="comm" id="nom" size="20" value="<?=$data['commentaireClient'] ?>"/></td>
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