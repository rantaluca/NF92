<html>
<head>
  <title>Inscrire eleve</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php

  //connexion
  include 'connexion.php';
  date_default_timezone_set('Europe/Paris');
  $date = date("Y-m-d");

  //recup val
  $ideleve = $_POST['ideleve'];

  //Securite: remplace les quotes, pour eviter injections sql (si user ne passe par par notre interface)

  $ideleve = str_replace ("'","\'",$ideleve);

  //Securite: remplace les injection html
  $ideleve = htmlspecialchars ($ideleve);

  //requete
  $query = "select * from inscription inner join seances where inscription.idseance = seances.idseance and inscription.ideleve = $ideleve";
  $result = mysqli_query($connect, $query);

  // alerte erreur
  if (!$result)
  {
   echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
   echo "<br>Votre requête SQL: $query";
   exit();
  }
  echo "<br>Nous sommes le: $date";
  //succes
  while ($row = mysqli_fetch_array($result))
  {
  echo "<p>note:".$row['note']." Date: ".$row['DateSeance']."</p>";
  }

mysqli_close($connect);

?>
</body>
</html>
