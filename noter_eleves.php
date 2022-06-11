<html>
<head>
  <title>noter_eleve.php</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="simple-div">
  <div class="title-header">
		<h3>‍✅ Séance Validée</h3>
	</div>
	<div>
		<h2>‍✅ Séance Validée</h2>

    <p><b>Récapitulatif des nouvelles notes:</b><br></p>
    <ul>

<?php
include 'connexion.php';
date_default_timezone_set('Europe/Paris');
$date = date("Y-m-d");

$idseance = $_POST['seance'];

//Securite: remplace les quotes, pour eviter injections sql (si user ne passe par par notre interface)
$idseance = str_replace ("'","\'",$idseance);

//Securite: remplace les injection html
$idseance = htmlspecialchars ($idseance);

//Securite: secu aussi pour prevenir les faille sql
$idseance = mysqli_real_escape_string($connect, $idseance);

//test server-side, au cas ou le "required" en html n'aboutit pas
if (empty($idseance)) { // test si une val est vide
  echo "<h2>🚨 Attention 🚨</h2>Il manque un champ.";
  echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
  exit();
}

//requete recupere les info de la table inscription jointe à celle eleves, pour la seance correspondante
$query_inscrits_in_seances = "SELECT * FROM inscription inner join eleves on inscription.ideleve = eleves.ideleve WHERE idseance = $idseance";
$result_inscrits_in_seances = mysqli_query($connect, $query_inscrits_in_seances);

    //test/verif obligatoire
    if (!$result_inscrits_in_seances)
    {
     echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
     echo "<br>Votre requête SQL: $query_inscrits_in_seances";
     echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
     exit();
    }

    while ($row_eleves = mysqli_fetch_array($result_inscrits_in_seances)){ // on parcours les eleves inscrits

      //infos eleves
      $ideleve=$row_eleves['ideleve'];
      $nom = $row_eleves['nom'];
      $prenom = $row_eleves['prenom'];

      $nb_fautes=$_POST[$ideleve];// on recup le nombre de fautes (à l'indice [ideleve])

      if (is_numeric($nb_fautes) and $nb_fautes<=40 and $nb_fautes>=0) {// double test:  si nb_fautes est un nombre et si il est compris en 0-40

        $note = 40 - $nb_fautes;// calcule de la note

        //requete sql pour update les note de l'eleve pour la seance correspondante
        $update_note = mysqli_query($connect, "update inscription set note = $note where ideleve = $ideleve and idseance = $idseance;");
        // verif obligatoire
        if(!$update_note)
              {
                echo "<br> Erreur :".mysqli_error($connect);
              }


        echo "<li><b>$nom $prenom</b>  $note/40<br></li>"; // recapitulatif de la note modifiée

        }
        else {
          echo "<li style='color:grey;'><b>$nom $prenom</b> Pas de nouvelle note (Champ laissé vide ou invalide)</li>"; // echo  la note n'as pas été changée
        }


          }



mysqli_close($connect);
?>
</ul>
<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</div>
</body>
</html>
