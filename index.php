<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    
    <title>Document</title>
</head>
<body>
    
<header>
<div class="image">
     
<a  href=liste.php ><img class="img1" src="img/logo.png"/></a> 
    <p><h1>Bienvenue sur ABI.COM</h1></p>
</div>
</header>


<div class="container">
    

            <form id="form">
                <h1>Connexion</h1>
                <br>
                <br>
                <label>Login :</label>
                <input type="text" name="login" id="login" autocomplete="off">
                <br>
                <label>Mot de passe :</label>
                <input type="test" name="passe" id="password" autocomplete="off" >
                <br>
                <button   id="submit" class="btn btn-secondary">Envoyer</button>&nbsp;
                <button   name="reset" class="btn btn-secondary">Annuler</button>
                <span id="resultat"></span>
            </form>
</div>

      

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/connexion.js"></script>
</body>
</html>