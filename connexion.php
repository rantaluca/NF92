<?php
$dbhost = 'tuxa.sme.utc';
$dbuser = 'XXXXXXXXX'; //username 
$dbpass = 'XXXXXXXXX'; //password 
$dbname = 'XXXXXXXXX'; //* 

$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
mysqli_set_charset($connect, 'utf8');
?>
