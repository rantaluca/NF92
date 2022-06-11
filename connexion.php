<?php
$dbhost = 'tuxa.sme.utc';
$dbuser = 'nf92p004';
$dbpass = 'dx3B1EsL';
$dbname = 'nf92p004';

$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
mysqli_set_charset($connect, 'utf8');
?>
