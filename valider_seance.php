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

	//Securite: remplace les quotes, pour eviter injections sql (si user ne passe par par notre interface)
	$idseance = str_replace ("'","\'",$idseance);

//Securite: secu aussi pour prevenir les faille sql
	$idseance = mysqli_real_escape_string($connect, $idseance);

	//Securite: pour les injection html
	$idseance = htmlspecialchars ($idseance);

	if (empty($idseance)) {// test vide server side
     echo "<br>🚨 Attention, Erreur 🚨, vous n'avez pas séléctionné de seance.";
     echo "<br>Votre requête SQL: $query_eleves_in_seances";
		  echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
     exit();
  }

	//requete pour recup inscription jointe aux eleves, correspondants à la seance choisie
  $query_eleves_in_seances = "SELECT * FROM `inscription` INNER JOIN `eleves` on inscription.ideleve = eleves.ideleve where inscription.idseance='$idseance'";
  $result_eleves_in_seances = mysqli_query($connect, $query_eleves_in_seances);
  // verif/alerte erreur obligatoire
  if (!$result_eleves_in_seances)
      {
       echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
       echo "<br>Votre requête SQL: $query_eleves_in_seances";
			 echo "	<p onclick='history.back()' class='smallbtn'> ← Retour</p>";
       exit();
      }

  if (mysqli_num_rows($result_eleves_in_seances) == 0) { // si aucun resultat, pas d'eleve inscrits/ou seance existe pas
      echo "<br>🚨 Attention, Erreur 🚨, il n'y a pas d'éléves inscrits dans cette séance.";
      echo "<br>Votre requête SQL: $query_eleves_in_seances";
			echo "	<p onclick='history.back()' class='smallbtn'> ← Retour</p>";
      exit();
  }

  while ($row_eleves = mysqli_fetch_array($result_eleves_in_seances)){ // on parcours la liste d'eleve inscrits

    echo "<tr><td><label>".$row_eleves['nom']." ".$row_eleves['prenom']."</label></td>";//affichage nom / prenom
		echo "<input type ='hidden' name='seance' value='".$idseance."'>"; // transmet id seance
		if ($row_eleves['note'] >= 0 ){ // si eleve noté
			$nbfautes = 40 - $row_eleves['note']; //on recup son ancienne note et on calc l' ancien nb de fautes
			//on affiche le precédent enregistrement + input pour changer la note
			echo "<td>Note enregistrée précedement: ".$row_eleves['note']." <input type='number' min='0' max='40' name='".$row_eleves['ideleve']."' placeholder='Nombres de fautes: ".$nbfautes."' ></input></td>	</tr>";
		}
		else { // pas encore de note dc input pour l'ajouter
			echo "<td><input type='number' min='0' max='40' name='".$row_eleves['ideleve']."' placeholder='Pas de note enregistrée' ></input></td>	</tr>";
		}


  }
  mysqli_close($connect);
?>

	<td>	<input type="submit" value="Envoyer"></td><td><input type="reset" value="Reset"></td>
		</tr>
		</table>
		<br>
		<p onclick='history.back()' class='smallbtn'> ← Retour</p>
	</form>

</div>
</body>
</html>
