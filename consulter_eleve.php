<html>
<head>
  <title>Inscrire eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <div class="title-header">
    <h3>‍👤 Consultation éléve</h3>
  </div>
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

  $query_nom = "select * from eleves where eleves.ideleve = $ideleve"; // requete pour recuperer ligne(s) avec l'id l'eleve chosi
  $result_nom = mysqli_query($connect, $query_nom);

  // requete obligatoire
  if (!$result_nom)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  while ($row_nom = mysqli_fetch_array($result_nom)) // parcours le resultat de la requete query_nom pour definir les variables
  {
    $nom = $row_nom['nom'];
    $prenom = $row_nom['prenom'];
    $dateNaiss = $row_nom['dateNaiss'];
    $dateInscritpion = $row_nom['dateInscritpion'];
  }

  //requete qui permet de recuperer les infos des seances passé où l'eleves été inscrit, et les trier par ordre croissant
  $query = "select inscription.idseance, inscription.ideleve, note, DateSeance, themes.nom, description from inscription inner join seances on inscription.idseance = seances.idseance inner join themes on seances.idtheme = themes.idtheme where inscription.ideleve = $ideleve and seances.DateSeance <'$date' order by DateSeance";
  $result = mysqli_query($connect, $query);

  // test/alerte erreur obligatoire
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p>";
   exit();
  }


  // affichages des infos
  echo "<h2><b>Dossier de $nom $prenom:</b></h2>";
  echo "Née le <b>$dateNaiss</b><br>";
  echo "Inscrit le <b>$dateInscritpion</b> <br> <br>";
  echo "<b>Séances antérieures:</b>";
  echo "<div style='display:flex; flex-direction:row;'>";

  if (mysqli_num_rows($result) == 0){ // test si eleve etait inscrit nul part
    echo "<p style='color:grey'>Pas encore de seances!</p>";
  }
  else{// sinon on affiche ses seances anterieure
    while ($row = mysqli_fetch_array($result))
    {
      echo "<div class='card'>";
      echo "<h3><u>".$row['nom']."</u></h3>";
      echo "<p>📅 ".$row['DateSeance']."</p>";
      echo "<p>".$row['description']." </p>";
      if ($row['note']<0) // test pour affichage: si eleve noté
        {
          echo "<p style='color:grey'>Pas encore noté</p>";
        }
      else {
          echo "<p style='color:red'>Note: ".$row['note']."</p>";
        }

      echo "</div>";
      }
    }

  echo "</div>";


mysqli_close($connect);

?>



<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</div>
</body>
</html>
