<html>
<head>
  <title>ajouter eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php

  //connexion
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  //recup val
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $dateNaiss = $_POST['dateNaiss'];


  $query = "insert into eleves values ( NULL, '$nom', '$prenom', '$dateNaiss', '$date' )";
  $result = mysqli_query($connect, $query);

  // alerte erreur
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   exit();
  }

  //succes
  echo " <p onclick='history.back()' class='smallbtn'> ← Retour</p> <div class='simple-div'><h2>👍 Félicitations !</h2>Vous venez d'inscrire avec succès l'élève suivant: <br><br> <b>Mr/Mme $nom $prenom née le $dateNaiss</b><br> <br> Votre requête SQL: $query<br></div>";
  echo "";

mysqli_close($connect);
?>
</body>
</html>
