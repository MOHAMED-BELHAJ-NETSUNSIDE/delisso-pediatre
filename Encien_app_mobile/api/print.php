<!DOCTYPE html>
<html lang="en" >

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Danino - Tournée pédiatres 2019</title>
		<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
		<script src="js/jquery.js"></script>
		<script src="js/jquery.mobile-1.4.5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">



  
</head>

<body>
<?php

// Initialize variable for database credentials
$dbhost = 'createamgfdaf.mysql.db';
$dbuser = 'createamgfdaf';
$dbpass = 'Momo08545547';
$dbname = 'createamgfdaf';

//Create database connection
  $dblink = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

//Check connection was successful
  if ($dblink->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

		$query = "SELECT * FROM `pm_data_2019` ";
		$query .= "WHERE id = 34 ";


//Fetch 3 rows from actor table
  $result = $dblink->query($query);

//Initialize array variable
  $dbdata = array();

//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
	  // echo $row['image_1'] ;
	  echo "alo<img src='".$row['image_1']."' >" ;

  }

//Print array in JSON format
 // echo json_encode($dbdata);
 
?>
</body>
</html>