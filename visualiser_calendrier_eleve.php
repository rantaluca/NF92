<html>
<head>
  <title>Inscrire eleve</title>
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
  $ideleve = $_POST['ideleve'];

  //Securite: remplace les quotes, pour eviter injections sql (si user ne passe par par notre interface)
  $ideleve = str_replace ("'","\'",$ideleve);

  //Securite: remplace les injection html
  $ideleve = htmlspecialchars ($ideleve);

  //Securite: secu aussi pour prevenir les faille sql
  $ideleve = mysqli_real_escape_string($connect, $ideleve);

  //test server-side, au cas ou le "required" en html n'aboutit pas
  if (empty($ideleve)) {
    echo "<h2>🚨 Attention 🚨</h2>Il manque un champ.";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  $query_nom = "select * from eleves where eleves.ideleve = $ideleve"; // recup eleve correspondant à ideleve
  $result_nom = mysqli_query($connect, $query_nom);

  if (!$result_nom)
  // test/verif/alerte erreur obligatoire
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  while ($row_nom = mysqli_fetch_array($result_nom)) // parcours cette ligne pour recup nom prenom
  {
    $nom = $row_nom['nom'];
    $prenom = $row_nom['prenom'];
  }


//requete qui permet de recuperer les infos des inscriptions jointes aux seances jointes aux themes, selon les seances à venir où l'eleves été inscrit, et les trier par ordre croissant (dateNaiss)
  $query = "select inscription.idseance, inscription.ideleve, note, DateSeance, themes.nom, description from inscription inner join seances on inscription.idseance = seances.idseance inner join themes on seances.idtheme = themes.idtheme where inscription.ideleve = $ideleve and seances.DateSeance >= '$date' order by DateSeance";
  $result = mysqli_query($connect, $query);
  // test/verif/alerte erreur obligatoire
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  if (mysqli_num_rows($result) == 0){ // test si eleve est inscrit nul part
    echo "<p style='color:grey'>Pas encore de seances!</p>";
  }
  else{// sinon on affiche ses seances futures
  echo "<h2><b>Calendrier de $nom $prenom:</b></h2>";
  echo "<b>Séances à venir:</b>";
  echo "<div style='display:flex;'>";
  while ($row = mysqli_fetch_array($result)) // while parcours le resultat qu'il affiche dans des card
  {
    echo "<div class='card'>";
    echo "<h3><u>".$row['nom']."</u></h3>";
    echo "<p>📅 ".$row['DateSeance']."</p>";
    echo "<p>".$row['description']." </p>";
  echo "</div>";
  }
    echo "</div>";
  }
mysqli_close($connect);

?>


<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</div>
</div>
</body>
</html>
