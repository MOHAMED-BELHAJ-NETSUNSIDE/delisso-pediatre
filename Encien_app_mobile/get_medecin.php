
<?php

// Initialize variable for database credentials
// $dbhost = 'createamgfdaf.mysql.db';
// $dbuser = 'createamgfdaf';
// $dbpass = 'Momo08545547';
// $dbname = 'createamgfdaf';

$dbhost = 'unibronertbackup.mysql.db';
$dbuser = 'unibronertbackup';
$dbpass = 'Momo08545547';
$dbname = 'unibronertbackup';


//Create database connection
  $dblink = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

  
 
$id = $_GET["id"]; 
  
//Check connection was successful
  if ($dblink->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

		$query = "SELECT * FROM `pm_pediatre` ";
		$query .= "WHERE id = ".$id;

// echo $query;
//Fetch 3 rows from actor table
  $result = $dblink->query($query);

//Initialize array variable
  // $dbdata = array();

  
 	  // $dbdata['region'] =  "" ;
	  // $dbdata['municipalite'] =  "" ;
	  // $dbdata['etab'] =  "" ;
	  // $dbdata['name_etab'] =  "" ;
	  // $dbdata['classe'] =  "" ;
	  // $dbdata['type'] =  "" ;
	  // $dbdata['fullname'] =  "" ;
	  // $dbdata['adresse'] =  "" ;
	  // $dbdata['tel'] =  "" ;
	  // $dbdata['email'] =  "" ; 
  
//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
	  $dbdata = array_map('utf8_encode', $row);
	  // $dbdata['region'] =  $row['region'] ;
	  // if(!isset($ma_variable)){
	  // $dbdata['municipalite'] =  $row['municipalite'] ;
	  // }
	  // $dbdata['etab'] =  $row['etab'] ;
	  // $dbdata['name_etab'] =  $row['name_etab'] ;
	  // $dbdata['classe'] =  $row['classe'] ;
	  // $dbdata['type'] =  $row['type'] ;
	  // $dbdata['fullname'] =  $row['fullname'] ;
	  // $dbdata['adresse'] =  $row['adresse'] ;
	  // $dbdata['tel'] =  $row['tel'] ;
	  // $dbdata['email'] =  $row['email'] ;
  }

//Print array in JSON format
 echo json_encode($dbdata);
 
?>
