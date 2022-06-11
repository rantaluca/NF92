<html dir="ltr" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Ajouter une séance</title>
	<link href="style.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="title-header">
		<h3>‍🚮 Supprimer thème</h3>
	</div>
	<div class="container">
  <form action="supprimer_theme.php" method="POST" >
		<h2>🚮 Supprimer thème</h2>
		<table>
    <tr>
			<td><p>Choisir un Thème:</p></td>

  <?php

  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

	$query = "select * from `themes` where supprime = '0'";// requete recup tt les themes non supp
  $result = mysqli_query($connect,$query);

	// alerte erreur obligatoire
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
	 echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

	echo "<td><select name='Idtheme' required>";
  while ($row = mysqli_fetch_array($result))
  {
  echo "<option value=".$row[0].">".$row[1]."</option>"; // options avce les idtheme
  }

  echo "</select></td></tr>";


  mysqli_close($connect);
  ?>
	<td>	<input type="submit" value="Supprimer"> </td><td><input type="reset" value="Reset"></td>
		</tr>
		</table>
	</form>
</div>
</body>
</html>
