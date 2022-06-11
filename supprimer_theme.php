<html>
<head>
  <title>ajouter_theme.php</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class='simple-div'>
<?php
include 'connexion.php';
date_default_timezone_set('Europe/Paris');
$date = date("Y-m-d");

//recup val
$Idtheme = $_POST['Idtheme'];
//Securite: remplace les quotes, pour eviter injections sql
$Idtheme = str_replace ("'","\'",$Idtheme);
//Securite: remplace les injection html
$Idtheme = htmlspecialchars ($Idtheme);
//Securite: secu aussi pour prevenir les faille sql
$Idtheme = mysqli_real_escape_string($connect, $Idtheme);


//test server-side, au cas ou le "required" en html n'aboutit pas
if (empty($Idtheme)) {
  echo "<h2>🚨 Attention 🚨</h2>Pas de thème sélectionné.</div>";
  echo "	<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
  exit();
}

$theme_sup_query = "update themes set supprime = '1' where idtheme=$Idtheme"; // requete pour desactiver/supp theme
$result_sup_query = mysqli_query($connect, $theme_sup_query);

// test/alerte erreur
if (!$result_sup_query)
{
 echo "<br>🚨 Attention, Erreur 🚨 ".mysqli_error($connect);
 echo "	<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
 exit();
}

$futur_seances_query = "select themes.nom, seances.DateSeance from seances inner join themes on seances.idtheme=themes.idtheme where seances.idtheme=$Idtheme and seances.DateSeance > '$date' ";// requete pour recuperer les seances deja planifiées, sur le theme supprimé
$result_futur_seances_query = mysqli_query($connect, $futur_seances_query);

// test/alerte erreur obligatoire
if (!$result_futur_seances_query)
{
 echo "<br>🚨 Attention, Erreur 🚨 ".mysqli_error($connect);
 echo "	<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
 exit();
}


if (mysqli_num_rows($result_futur_seances_query)>0) {// si la requete sur les seance deja planifié est non vide, on previens le user
  echo "<h2>🚮 Félicitations !</h2>Vous venez de supprimer le thème!<br>";
  echo "<br>📅Attention: il reste encore <b>".mysqli_num_rows($result_futur_seances_query)."</b> séances prévues autour de ce thème!";
  echo "<br>Votre requête SQL: $theme_sup_query<br>";
}//sinon on affiche un succes
else {
  echo "<h2>🚮 Félicitations !</h2>Vous venez de supprimer le thème!";
  echo "<br>Votre requête SQL: $theme_sup_query<br>";
}


mysqli_close($connect);
?>
		<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</div>

</body>
</html>
