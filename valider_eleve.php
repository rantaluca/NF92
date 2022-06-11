<html>
<head>
  <title>Valider eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php

  //connexion
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  //recup val
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $dateNaiss = $_POST['dateNaiss'];

  //Securite: remplace les quotes, pour eviter injections sql
  $nom = str_replace ("'","\'",$nom);
  $prenom = str_replace ("'","\'",$prenom);

  //Securite: remplace les injection html
  $nom = htmlspecialchars ($nom);
  $prenom = htmlspecialchars ($prenom);

  //test server-side si tt les champs sont complete, au cas ou le "required" en html n'aboutit pas
  if (empty($nom) or empty($prenom) or empty($dateNaiss)) {
    echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>Il manque un champ.</div>";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  //Securite: verif on ne depasse pas 30 char
  if (strlen($nom)>30 or strlen($prenom)>30) {
    echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>Les champs 'Nom' et 'Prenom' doivent etre inférieurs à 30 characteres.</div>";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }

  //verif age
  if ($dateNaiss>$date) {
    echo "<div class='simple-div'><h2>🚨 Attention 🚨</h2>L'élève n'est pas née.</div>";
    echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
    exit();
  }


  $query_doublon = "select * from eleves where nom = '$nom' and prenom = '$prenom'";// requete pour recup les doublon
  $result_doublon = mysqli_query($connect, $query_doublon);
  // test obligatoir à chaque requete
  if (!$result_doublon)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<p onclick='history.back()' class='smallbtn'> ← Retour</p></div>";
   exit();
  }

  if (!empty(mysqli_fetch_array($result_doublon))){ // si le result_doublon, n'est pas vide on affiche le form doublons

    echo <<< EOT
    <div class="title-header">
      <h3>‍🚨 Attention, Doublon 🚨</h3>
    </div>
    <div class="container">
    <form action="ajouter_eleve.php" method="POST" >
      <h1>🚨 Attention, Doublon 🚨</h1>
      <p>Un éléve eponyme existe deja souhaitez vous quand-même l'ajouter?</p>
      <table>
        <tr>
          <td> Nom: $nom</td>
          <td><input type='hidden' name='nom' value=$nom></td>
        </tr>
        <tr>
          <td> Prénom: $prenom</td>
          <td><input type='hidden' name='prenom' value=$prenom></td>
        </tr>
        <tr>
          <td > Date de naissance: $dateNaiss</td>
          <td><input  type='hidden' name='dateNaiss' value=$dateNaiss></td>
        </tr>

       <tr>
    <td>	<input type="submit" value="Oui"> </td><td><p onclick='history.back()' class='smallbtn'> NON</p></td>
      </tr>
      </table>

      </form>
  </div>
  EOT;

  }

else { // sinon on affiche le form non-doublon
  echo <<< EOT
  <div class="title-header">
    <h3>‍✅ Confirmation</h3>
  </div>
  <div class="container">
  <form action="ajouter_eleve.php" method="POST" >
    <h1>✅ Confirmation</h1>
    <p>Souhaitez vous confirmer l'envoi?</p>
    <table>
      <tr>
        <td> Nom: $nom</td>
        <td><input type='hidden' name='nom' value=$nom></td>
      </tr>
      <tr>
        <td s> Prénom: $prenom</td>
        <td><input type='hidden' name='prenom' value=$prenom></td>
      </tr>
      <tr>
        <td> Date de naissance: $dateNaiss</td>
        <td><input type='hidden' name='dateNaiss' value=$dateNaiss></td>
      </tr>

     <tr>
  <td>	<input type="submit" value="Oui"> </td><td><p onclick='history.back()' class='smallbtn'> NON</p></td>
    </tr>
    </table>

    </form>
</div>
EOT;
}


mysqli_close($connect);
?>
<p onclick='history.back()' class='smallbtn'> ← Retour</p>
</body>
</html>
