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

  $query_eleves = "SELECT * FROM `eleves`";
  $result_eleves = mysqli_query($connect, $query_eleves);
  // alerte erreur
  if (!$result_eleves)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_eleves";
       exit();
      }
  $query_seances = "SELECT * FROM `seances` INNER JOIN`themes` WHERE themes.idtheme = seances.idtheme and seances.DateSeance>='$date' and (SELECT COUNT(*) FROM inscription WHERE inscription.idseance = seances.idseance) < seances.EffMax";
  $result_seances = mysqli_query($connect, $query_seances);
  // alerte erreur
  if (!$result_seances)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_seances";
       exit();
      }
	echo "<td> <select name='ideleve' size='5' style='height:6em; width:15em; font-size:120%;' required>";

  while ($row = mysqli_fetch_array($result_eleves, MYSQLI_NUM))
  {
  echo "<option value=".$row['0'].">".$row['1']." ".$row['2']."</option>";
  }
  echo "</select></td>";

  echo "<td><select name='idseance' size='5' style='height:6em; width:15em; font-size:120%;' required>";
  while ($row2 = mysqli_fetch_array($result_seances, MYSQLI_NUM))
  {
  echo "<option value=".$row2['0'].">".$row2['1']." ".$row2['5']."</option>";
  }
  echo "</select></td></tr>";


  mysqli_close($connect);
  ?>
	<td>	<input type="submit" value="Envoyer"> </td><td><input type="reset" value="Reset"></td>
		</tr>
		</table>
	</form>
</div>
</body>
</html>
