<html>
<head>
  <title>Desinscrire eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class='simple-div'>
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
  $idseance = mysqli_real_escape_string($connect, $idseance);
  $ideleve = mysqli_real_escape_string($connect, $ideleve);

  //test server-side, au cas ou le "required" en html n'aboutit pas
  if (empty($ideleve) or empty($idseance)) { // test si une val est vide
    echo "<h2>🚨 Attention 🚨</h2>Il manque un champ.";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  $query_inscription = "select * from inscription where ideleve = $ideleve and idseance = $idseance";// requete pour recuperer ligne(s) correspondants à l'eleve et la seance choisi
  $result_inscription = mysqli_query($connect, $query_inscription);
  // test obligatoire
  if (!$result_inscription)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  if (mysqli_num_rows($result_inscription) == 0) { // petite verification pour verifier si l'éleve etait inscrit
    echo "<h2>⚠️ Attention</h2>";
    echo " Cet éléve n'etait pas inscrit dans la séance !";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  else {
  //requete pour supprimer l'inscription de cet éléve dans cette seance
  $query = "DELETE FROM inscription WHERE ideleve = $ideleve AND idseance = $idseance";
  $result = mysqli_query($connect, $query);

  // test/alerte erreur obligatoire
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  // message succes pour utilisateur
  echo " <h2>👍 Félicitations !</h2>Vous venez de retirer  à cette séance.<br><br>Votre requête SQL: $query<br>";
}

mysqli_close($connect);

?>
<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</div>
</body>
</html>
