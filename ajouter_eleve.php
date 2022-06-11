<html>
<head>
  <title>ajouter eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class =" simple-div">
<?php

  //connexion
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  //recup val
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $dateNaiss = $_POST['dateNaiss'];

  //Securite: remplace les quotes, pour eviter injections sql (si user ne passe par par notre interface)
  $nom = str_replace ("'","\'",$nom);
  $prenom = str_replace ("'","\'",$prenom);
  $dateNaiss = str_replace ("'","\'",$dateNaiss);

  //Securite: secu aussi pour prevenir les faille sql
  $nom = mysqli_real_escape_string($connect, $nom);
  $prenom = mysqli_real_escape_string($connect, $prenom);
  $dateNaiss = mysqli_real_escape_string($connect, $dateNaiss);


  //Securite: pour les injection html
  $nom = htmlspecialchars ($nom);
  $prenom = htmlspecialchars ($prenom);
  $dateNaiss = htmlspecialchars ($dateNaiss);


  //test server-side, au cas ou le "required" en html n'aboutit pas
  if (empty($nom) or empty($prenom) or empty($dateNaiss)) {
    echo "<h2>🚨 Attention 🚨</h2>Il manque un champ.";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  $query = "insert into eleves values ( NULL, '$nom', '$prenom', '$dateNaiss', '$date' )";// requete SQL pour ajouter un eleve
  $result = mysqli_query($connect, $query);

  // alerte erreur obligatoire
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  //succes, et message de succés
  echo "<h2>👍 Félicitations ! </h2>Vous venez d'inscrire avec succès l'élève suivant: <br><br> <b>Mr/Mme $nom $prenom née le $dateNaiss</b><br> <br> Votre requête SQL: $query<br>";
  mysqli_close($connect);
?>

<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</div>

</body>

</html>
