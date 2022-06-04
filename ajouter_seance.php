<html>
<head>
  <title>ajouter seance</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
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

  //Securite: remplace les injection html
  $DateSeance = htmlspecialchars ($DateSeance);
  $EffMax = htmlspecialchars ($EffMax);
  $Idtheme = htmlspecialchars ($Idtheme);




  if ($DateSeance<$date) {
    echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>Vous ne pouvez pas planifier une séance dans le passé.</div>";
    exit();
  }

  if ($EffMax<1) {
    echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>L'effectif de la maximum de la séance ne peut pas etre inférieur à 1.</div>";
    exit();
  }

  $QuerySeancesThisDate = "select `Idtheme` from `seances` where DateSeance='$DateSeance'";
  $SeancesThisDate = mysqli_query($connect, $QuerySeancesThisDate);

  if (!$SeancesThisDate)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   exit();
  }

  echo "<br>Votre requête SQL: $QuerySeancesThisDate";

  foreach ($SeancesThisDate as $values){
    foreach ($values as $value){
      if ($value==$Idtheme) {
        echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>Attention une séance sur le même thème est déja prévue à la date du $DateSeance.</div>";
        exit();
      }
    }
  }



  //requete
  $query = "insert into seances values (NULL, '$DateSeance ', '$EffMax', '$Idtheme')";
  $result = mysqli_query($connect, $query);

  // alerte erreur
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   exit();
  }

  //succes
  echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p> <div class='simple-div'><h2>👍 Félicitations !</h2>Vous venez de créer avec succès un nouvelle séance.<br><br>Votre requête SQL: $query<br></div>";
  echo "";

mysqli_close($connect);

?>
</body>
</html>
