<html dir="ltr" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Ajouter une séance</title>
	<link href="style.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="title-header">
		<h3>‍❌ Desinscription d'un éléve</h3>
	</div>
	<div class="container">
  <form action="desinscrire_seance.php" method="POST" >
		<h2>‍❌ Desinscription d'un éléve</h2>
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

  $query_eleves = "SELECT * FROM `eleves`"; // recupere tout les éléves
  $result_eleves = mysqli_query($connect, $query_eleves);
  // test/alerte erreur obligatoire
  if (!$result_eleves)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_eleves";
			 echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
       exit();
      }

  $query_seances = "SELECT * FROM seances INNER JOIN themes ON themes.idtheme = seances.idtheme where seances.DateSeance>='$date'"; //recupere les séances qui n'ont pas encore eu lieux
  $result_seances = mysqli_query($connect, $query_seances);
    // test/alerte erreur obligatoire
  if (!$result_seances)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_seances";
			 echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
       exit();
      }

	// select eleve
	echo "<td> <select name='ideleve' size='7' style='height:10em; width:15em; font-size:120%;' required>";

  while ($row = mysqli_fetch_array($result_eleves))
  {
  echo "<option value=".$row['ideleve'].">".$row['nom']." ".$row['prenom']."</option>"; // boucle pour option eleve
  }
  echo "</select></td>";

	// select seances
  echo "<td><select name='idseance' size='7' style='height:10em; width:15em; font-size:120%;' required>";
  while ($row2 = mysqli_fetch_array($result_seances))
  {
  echo "<option value=".$row2['idseance'].">".$row2['nom']." ".$row2['DateSeance']."</option>";// boucle pour option seances
  }
  echo "</select></td></tr>";


  mysqli_close($connect);
  ?>
	<td>	<input type="submit" value="Desinscrire"> </td><td><input type="reset" value="Reset"></td>
		</tr>
		</table>
	</form>
</div>
</body>
</html>
