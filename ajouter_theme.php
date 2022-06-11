<html>
<head>
  <title>ajouter_theme.php</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="simple-div">
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

//Securite: secu aussi pour prevenir les faille sql
$nom = mysqli_real_escape_string($connect, $nom);
$description = mysqli_real_escape_string($connect, $description);


//Securite: verif on ne depasse pas 30 char
if (strlen($nom)>30) {
  echo "<h2>🚨 Attention 🚨</h2>Le 'nom de thème' doit etre inférieurs à 30 characteres.";
  echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
  exit();
}

//test server-side, au cas ou le "required" en html n'aboutit pas
if (empty($nom) or empty($description)) {
  echo "<h2>🚨 Attention 🚨</h2>Il manque un champ.";
  echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
  exit();
}

$query_theme = "select * from themes where nom = '$nom'"; // requete recup les theme eponyme à celui que l'on souhaite inscrire
$result_theme = mysqli_query($connect, $query_theme);
// alerte erreur
if (!$result_theme)
{
 echo "<br>🚨 Attention, Erreur 🚨 ".mysqli_error($connect);
 echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
 exit();
}

if (!empty(mysqli_fetch_array($result_theme))) { // si la requete precedente est non vide, il existe donc un doublon, on reactive
  $query = "update themes set supprime = '0' where themes.nom = '$nom'"; // reactivation mm si ce dernier est déja activé (pas d'incidence)
  $result = mysqli_query($connect, $query);
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨 ".mysqli_error($connect);
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }
  echo "<h2>👯‍♂️ Réactivation</h2>";// message sympa
  echo "👯‍♂️ Un thème eponyme à: <b>$nom</b>, a été récement suprimmé, il vient d'etre réactivé !";
  echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
  exit();
}


$query = "insert into themes values (NULL, '$nom', 0, '$description')"; // sinon on inscrit le nouveau theme
$result = mysqli_query($connect, $query);

// alerte erreur
if (!$result)
{
 echo "<br>🚨 Attention, Erreur 🚨 ".mysqli_error($connect);
echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
 exit();
}

//succes
else {
  echo "<h2>👍 Félicitations !</h2>Vous venez d'ajouter avec succès le thème suivant:<br><b>$nom description:$description</b><br>Votre requête SQL: $query<br>";

}

mysqli_close($connect);
?>
</div>
<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</body>
</html>
