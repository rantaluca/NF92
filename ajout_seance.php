<html dir="ltr" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Ajouter une séance</title>
	<link href="style.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="title-header">
		<h3>‍📅 Ajouter une séance</h3>
	</div>
	<div class="container">
  <form action="ajouter_seance.php" method="POST" >
		<h2>📅 Ajouter une séance</h2>
		<table>
			<tr>
				<td> <p>Date de la séance :</p> </td>
				<td> <input type="date" NAME="DateSeance" required></td>
			</tr>
    <tr>
			<td><p>Effectif maximum de la séance: </p></td>
			<td><input type="number" NAME="EffMax" required></td>
		</tr>
    <tr>
			<td><p>Thème de la séance:</p></td>

  <?php
	echo "<td><select name='Idtheme' required>";
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");


  $result = mysqli_query($connect,"SELECT * FROM `themes` WHERE supprime = 0");
  while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
  {
  echo "<option value=".$row[0].">".$row[1]."</option>";
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
