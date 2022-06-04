<html dir="ltr" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Ajouter une séance</title>
	<link href="style.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="title-header">
		<h3>‍💯 Valider une séance 1/2</h3>
	</div>
	<div class="container">
  <form action="valider_seance.php" method="POST" >
		<h2>‍💯 Valider une séance 1/2</h2>
		<table>
			<tr>
			<td> <b><p style="font-size: 110%" >Choisir une seance:</p></b> </td>
		  </tr>
		<tr>

  <?php
  /* result = mysqli_query($connect,"SELECT * FROM `seances` INNER JOIN`themes` WHERE themes.Idtheme = seances.Idtheme and DateSeance>=$date"); */
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");


  $query_seances = "SELECT * FROM `seances` INNER JOIN`themes` WHERE themes.Idtheme = seances.Idtheme and seances.DateSeance < '$date'";
  $result_seances = mysqli_query($connect, $query_seances);
  // alerte erreur
  if (!$result_seances)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_seances";
       exit();
      }

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
