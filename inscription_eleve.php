<html dir="ltr" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Ajouter une séance</title>
	<link href="style.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="title-header">
		<h3>‍📝 Inscrire un éléve</h3>
	</div>
	<div class="container">
  <form action="inscrire_eleve.php" method="POST" >
		<h2>‍📝 Inscrire un éléve</h2>
		<table>
			<tr>
			<td> <p>Choisir un éléve:</p> </td>
			<td> <p>Choisir une séance:</p> </td>
		</tr>
		<tr>

  <?php
  /* result = mysqli_query($connect,"SELECT * FROM `seances` INNER JOIN`themes` WHERE themes.Idtheme = seances.Idtheme and DateSeance>=$date"); */
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  $query_eleves = "SELECT * FROM `eleves`"; // on recup les éléves
  $result_eleves = mysqli_query($connect, $query_eleves);
  // test/alerte erreur obligatoire
  if (!$result_eleves)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_eleves";
       exit();
      }
	// requete qui nous permet de recuperer la liste des seances jointe aux noms des thèmes, qui n'ont pas encore eux lieux, et dont l'effectif max n'est pas dépassé
  $query_seances = "SELECT * FROM `seances` INNER JOIN`themes` WHERE themes.idtheme = seances.idtheme and seances.DateSeance>='$date' and (SELECT COUNT(*) FROM inscription WHERE inscription.idseance = seances.idseance) < seances.EffMax";
  $result_seances = mysqli_query($connect, $query_seances);
  // verif/test/alerte erreur obligatoire
  if (!$result_seances)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_seances";
       exit();
      }

	//select eleve
	echo "<td> <select name='ideleve' size='5' style='height:10em; width:15em; font-size:120%;' required>";
  while ($row = mysqli_fetch_array($result_eleves))
  {
  echo "<option value=".$row['ideleve'].">".$row['nom']." ".$row['prenom']."</option>"; //while pour options avec l'ideleve
  }
  echo "</select></td>";

	//select seance
  echo "<td><select name='idseance' size='5' style='height:10em; width:15em; font-size:120%;' required>";
  while ($row2 = mysqli_fetch_array($result_seances))
  {
  echo "<option value=".$row2['idseance'].">".$row2['nom']." ".$row2['DateSeance']."</option>";//while pour options avec l'ideleve
  }
  echo "</select></td></tr>";


  mysqli_close($connect);
  ?>
	<td>	<input type="submit" value="Inscrire"> </td><td><input type="reset" value="Reset"></td>
		</tr>
		</table>
	</form>
</div>
</body>
</html>
