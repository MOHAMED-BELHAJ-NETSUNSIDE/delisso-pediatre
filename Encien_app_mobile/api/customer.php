<?php

// Initialize variable for database credentials
$dbhost = 'unibronertsales.mysql.db';
$dbuser = 'unibronertsales';
$dbpass = 'Momo08545547';
$dbname = 'unibronertsales';

//Create database connection
  $dblink = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

//Check connection was successful
  if ($dblink->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

//Fetch 3 rows from actor table
  $result = $dblink->query("SELECT a.idCompte,a.nom,a.prenom,a.presentoir,a.telGsm,a.id as plu ,b.date_bl FROM pm_customer as a LEFT JOIN pm_bl as b ON a.id = b.id_client");

//Initialize array variable
  $dbdata = array();

//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
	$dbdata[]=$row;
  }

//Print array in JSON format
 echo json_encode($dbdata);
 
?>