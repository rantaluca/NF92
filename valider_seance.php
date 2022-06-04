<html dir="ltr" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Ajouter une séance</title>
	<link href="style.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="title-header">
		<h3>‍💯 Valider une séance 2/2</h3>
	</div>
	<div class="container">
  <form action="noter_eleves.php" method="POST" >
		<h2>‍💯 Valider une séance 2/2</h2>
		<table>
			<tr>
			<td> <b><p style="font-size: 110%" >Noter les éléves (Nombre de fautes sur 40):</p></b> </td>
		  </tr>
		<tr>

<?php
  /* result = mysqli_query($connect,"SELECT * FROM `seances` INNER JOIN`themes` WHERE themes.Idtheme = seances.Idtheme and DateSeance>=$date"); */
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  $idseance=$_POST['idseance'];

  $query_eleves_in_seances = "SELECT * FROM `inscription` INNER JOIN `eleves` WHERE inscription.idseance=$idseance and inscription.ideleve = eleves.ideleve";
  $result_eleves_in_seances = mysqli_query($connect, $query_eleves_in_seances);
  // alerte erreur
  if (!$result_eleves_in_seances)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_eleves_in_seances";
       exit();
      }

  if (empty($idseance)) {
     echo "<br>🚨 Attention, Erreur 🚨, vous n'avez pas séléctionné de seance.";
     echo "<br>Votre requête SQL: $query_eleves_in_seances";
     exit();
  }

  if (mysqli_num_rows($result_eleves_in_seances) == 0) {
      echo "<br>🚨 Attention, Erreur 🚨, il n'y a pas d'éléves inscrits dans cette séance.";
      echo "<br>Votre requête SQL: $query_eleves_in_seances";
      exit();
  }

  while ($row_eleves = mysqli_fetch_array($result_eleves_in_seances)){

    echo "<tr><td><label>".$row_eleves['nom']." ".$row_eleves['prenom']."</label></td>";
		echo "<input type ='hidden' name='seance' value='".$idseance."'>";
		if ($row_eleves['note'] >= 0 ){
			$nbfautes = 40 - $row_eleves['note'];
			echo "<td>Note enregistrée précedement: ".$row_eleves['note']." <input type='number' min='0' max='40' name='".$row_eleves['ideleve']."' placeholder='Nombres de fautes: ".$nbfautes."' ></input></td>	</tr>";
		}
		else {
			echo "<td><input type='number' min='0' max='40' name='".$row_eleves['ideleve']."' placeholder='Pas de note enregistrée' ></input></td>	</tr>";
		}


  }

  mysqli_close($connect);
?>

	<td>	<input type="submit" value="Envoyer"></td><td><input type="reset" value="Reset"></td>
		</tr>
		</table>
	</form>
</div>
</body>
</html>
