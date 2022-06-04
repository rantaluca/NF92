<html>
<head>
  <title>ajouter_theme.php</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php
include 'connexion.php';
date_default_timezone_set('Europe/Paris');
$date = date("Y-m-d");

//recup val
$nom = $_POST['nom'];
$description = $_POST['description'];

//Securite: remplace les quotes, pour eviter injections sql
$nom = str_replace ("'","\'",$nom);
$description = str_replace ("'","\'",$description);

//Securite: remplace les injection html
$nom = htmlspecialchars ($nom);
$description = htmlspecialchars ($description);

//Securite: verif on ne depasse pas 30 char
if (strlen($nom)>30) {
  echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>Le 'nom de séance' doit etre inférieurs à 30 characteres.</div>";
  exit();
}

//test server-side, au cas ou le "required" en html n'aboutit pas
if (empty($nom) or empty($description)) {
  echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>Il manque un champ.</div>";
  exit();
}

$query = "insert into themes values (NULL, '$nom', 0, '$description')";
$result = mysqli_query($connect, $query);

// alerte erreur
if (!$result)
{
 echo "<br>🚨 Attention, Erreur 🚨 ".mysqli_error($connect);
 exit();
}

//succes
else {
  echo "<div class='simple-div'><h2>👍 Félicitations !</h2>Vous venez d'ajouter avec succès le thème suivant:<br><b>$nom description:$description</b><br>Votre requête SQL: $query<br></div>";
  echo "";
}

mysqli_close($connect);
?>

</body>
</html>
