<html dir="ltr" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Calendrier éléve</title>
	<link href="style.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="title-header">
		<h3>‍📔 Calendrier éléve</h3>
	</div>
	<div class="container">
  <form action="visualiser_calendrier_eleve.php" method="POST" >
		<h2>📔 Calendrier éléve</h2>
		<table>
			<tr>
			<td> <p>Choisir un éléve:</p> </td>
		</tr>
		<tr>

  <?php
  /* result = mysqli_query($connect,"SELECT * FROM `seances` INNER JOIN`themes` WHERE themes.Idtheme = seances.Idtheme and DateSeance>=$date"); */
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  $query_eleves = "SELECT * FROM `eleves`"; // on recup tt les eleves
  $result_eleves = mysqli_query($connect, $query_eleves);

  // verif/alerte erreur obligatoire
  if (!$result_eleves)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_eleves";
       exit();
      }

	echo "<td> <select name='ideleve' size='5' style='height:10em; width:15em; font-size:120%;' required>"; //select

  while ($row = mysqli_fetch_array($result_eleves, MYSQLI_NUM))
  {
  echo "<option value=".$row['0'].">".$row['1']." ".$row['2']."</option>"; // option ideleve avec nom prenom
  }
  echo "</select></td>";
  echo "</tr>";


  mysqli_close($connect);
  ?>
	<td>	<input type="submit" value="Consulter"> </td><td><input type="reset" value="Reset"></td>
		</tr>
		</table>
	</form>
</div>
</body>
</html>
