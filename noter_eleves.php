<html>
<head>
  <title>noter_eleve.php</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="simple-div">
<?php
include 'connexion.php';
date_default_timezone_set('Europe/Paris');
$date = date("Y-m-d");

$idseance = $_POST['seance'];

$query_inscrits_in_seances = "SELECT * FROM inscription WHERE idseance = $idseance";
$result_inscrits_in_seances = mysqli_query($connect, $query_inscrits_in_seances);

if (!$result_inscrits_in_seances)
    {
     echo "<br>🚨 Attention, Erreur 🚨".mysqli_error($connect);
     echo "<br>Votre requête SQL: $query_inscrits_in_seances";
     exit();
    }
    while ($row_eleves_notes = mysqli_fetch_array($result_inscrits_in_seances)){
      $ideleve=$row_eleves_notes['ideleve'];
      $nb_faute=$_POST[$ideleve];
      $note = 40 - $nb_faute;
      $update_note = mysqli_query($connect, "update inscription set note = $note where ideleve = $ideleve and idseance = $idseance;");
      if(!$update_note)
            {
              echo "<br> Erreur :".mysqli_error($connect);
            }

          }




mysqli_close($connect);
?>
</div>
</body>
</html>
