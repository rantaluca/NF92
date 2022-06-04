<html>
<head>
  <title>Inscrire eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
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

  //requete
  $query = "insert into inscription values ('$idseance','$ideleve',-1)";
  $result = mysqli_query($connect, $query);

  // alerte erreur
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   exit();
  }

  //succes
  echo " <div class='simple-div'><h2>👍 Félicitations !</h2>Vous venez d'ajouter un éléve à cette séance.<br><br>Votre requête SQL: $query<br></div><p onclick='history.back()' class='smallbtn'> ← Retour</p>";
  echo "";

mysqli_close($connect);

?>
</body>
</html>
