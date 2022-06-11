<html>
<head>
  <title>ajouter seance</title>
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
  $DateSeance = $_POST['DateSeance'];
  $EffMax = $_POST['EffMax'];
  $Idtheme = $_POST['Idtheme'];

  //Securite: remplace les quotes, pour eviter injections sql (si user ne passe par par notre interface)
  $DateSeance = str_replace ("'","\'",$DateSeance);
  $EffMax = str_replace ("'","\'",$EffMax);
  $Idtheme = str_replace ("'","\'",$Idtheme);

//Securite: secu aussi pour prevenir les faille sql
  $DateSeance = mysqli_real_escape_string($connect, $DateSeance);
  $EffMax = mysqli_real_escape_string($connect, $EffMax);
  $Idtheme = mysqli_real_escape_string($connect, $Idtheme);


  //Securite: pour les injection html
  $DateSeance = htmlspecialchars ($DateSeance);
  $EffMax = htmlspecialchars ($EffMax);
  $Idtheme = htmlspecialchars ($Idtheme);


  if ($DateSeance<$date) { //test date pour ne pas prgm de seance dans le passé
    echo "<h2>🚨 Attention 🚨</h2>Vous ne pouvez pas planifier une séance dans le passé.";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  if ($EffMax<1) { // test effectif max au moins une personne
    echo "<h2>🚨 Attention 🚨</h2>L'effectif de la maximum de la séance ne peut pas etre inférieur à 1.";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  //test server-side, au cas ou le "required" en html n'aboutit pas
  if (empty($DateSeance) or empty($EffMax) or empty($Idtheme)) {
    echo "<h2>🚨 Attention 🚨</h2>Il manque un champ.";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  $query_seances_date = "select `idtheme` from `seances` where DateSeance='$DateSeance'";// recupere les seance deja prevues sur ce jour
  $result_seances_date = mysqli_query($connect, $query_seances_date);

  // test et alerte erreur generique/obligatoire pour une nouvelle requete
  if (!$result_seances_date)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  while ($row = mysqli_fetch_array($result_seances_date)) {// On verifie si une seance sur ce theme n'est pas deja prevue
    if ($row[0]==$Idtheme)
    {
      echo "<h2>🚨 Attention 🚨</h2>Attention une séance sur le même thème est déja prévue à la date du $DateSeance.";
      echo "<br>Votre requête SQL: $query_seances_date";
      echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
      exit();
    }
  }
  echo "<br>Votre requête SQL: $query_seances_date";

  //requete pour l'insertion d'une nv seance dans la table seance
  $query = "insert into seances values (NULL, '$DateSeance ', '$EffMax', '$Idtheme')";
  $result = mysqli_query($connect, $query);

  // test et alerte erreur generique/obligatoire pour une nouvelle requete
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  //succes, on affiche un message de reussite
  echo "<h2>👍 Félicitations !</h2>Vous venez de créer avec succès un nouvelle séance.<br><br>Votre requête SQL: $query<br>echo ";

mysqli_close($connect);

?>
<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</div>

</body>
</html>
