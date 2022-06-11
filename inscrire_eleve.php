<html>
<head>
  <title>Inscrire eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="simple-div">
<?php

  //connexion
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  //recup val
  $idseance = $_POST['idseance'];
  $ideleve = $_POST['ideleve'];

  //Securite: remplace les quotes, pour eviter injections sql (si user ne passe par par notre interface)
  $idseance = str_replace ("'","\'",$idseance);
  $ideleve = str_replace ("'","\'",$ideleve);

  //Securite: remplace les injection html
  $idseance = htmlspecialchars ($idseance);
  $ideleve = htmlspecialchars ($ideleve);

  //Securite: secu aussi pour prevenir les faille sql
  $ideleve = mysqli_real_escape_string($connect, $ideleve);
  $idseance = mysqli_real_escape_string($connect, $idseance);

  //test server-side, au cas ou le "required" en html n'aboutit pas
  if (empty($ideleve) or empty($idseance)) { // test si une val est vide
    echo "<h2>🚨 Attention 🚨</h2>Il manque un champ.";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  //requete pour inscrire l'eleve
  $query = "insert into inscription values ('$idseance','$ideleve',-1)";
  $result = mysqli_query($connect, $query);

  // verif/alerte erreur obligatoire
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
  echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  //succes
  echo " <h2>👍 Félicitations !</h2>Vous venez d'ajouter un éléve à cette séance.<br><br>Votre requête SQL: $query<br>";


mysqli_close($connect);

?>

 <p onclick='history.back()' class='smallbtn'> ← Retour</p>
 </div>
</body>
</html>
