<?php
require 'config.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


$app->post('/savedata2','savedata2'); /* User Feeds  */
$app->post('/savedata','savedata'); /* User Feeds  */
$app->post('/newdata','newdata'); /* User Feeds  */
$app->post('/getImages', 'getImages');


$app->run();


function savedata2(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    // $user_id=$data->user_id;
	
    $id_pediatre=$data->id_pediatre;
    $gps=$data->gps;
    $classe=$data->classe;
    $nvisite=$data->nvisite;
    // $add_date2=$data->add_date;
    $add_date2= time();
	
    $region =$data->region;
    $municipalite =$data->municipalite;
    $etab =$data->etab;
    $name_etab =$data->name_etab;
    $type =$data->type;

	$fullname =$data->fullname;
    $adresse =$data->adresse;
    $tel =$data->tel;
    $email =$data->email;
    $remarque =$data->remarque;
    $remarque_1 =$data->remarque_1;
	
	
    $image_1 =$data->image_1;
    $image_2 =$data->image_2;
    $image_3 =$data->image_3;
    $image_4 =$data->image_4;
    $image_5 =$data->image_5;

	$gift_1 =$data->gift_1;
    $gift_2 =$data->gift_2;
    $gift_3 =$data->gift_3;
    $gift_4 =$data->gift_4;
    $gift_5 =$data->gift_5;
    $gift_6 =$data->gift_6;
    $gift_7 =$data->gift_7;
    $gift_8 =$data->gift_8;
	
	$gift_1_2018 =$data->gift_1_2018;
    $gift_2_2018 =$data->gift_2_2018;
    $gift_3_2018 =$data->gift_3_2018;
    $gift_4_2018 =$data->gift_4_2018;
    $gift_5_2018 =$data->gift_5_2018;
    $gift_6_2018 =$data->gift_6_2018;
    $gift_7_2018 =$data->gift_7_2018;
    $gift_8_2018 =$data->gift_8_2018;

    
    // $systemToken=apiToken($user_id);
   
    try {
         
        // if($systemToken == $token){
         
            
            $feedData = '';
            $db = getDB();
            $sql = "INSERT INTO pm_data_2021 (region,municipalite,etab,name_etab,type,fullname,adresse,tel,email,remarque,remarque_1, classe, nvisite,id_pediatre,image_1,image_2,image_3,image_4,image_5,gift_1,gift_2,gift_3,gift_4,gift_5,gift_6,gift_7,gift_8,gift_1_2018,gift_2_2018,gift_3_2018,gift_4_2018,gift_5_2018,gift_6_2018,gift_7_2018,gift_8_2018,add_date2,gps) VALUES (:region,:municipalite,:etab,:name_etab,:type,:fullname,:adresse,:tel,:email,:remarque,:remarque_1,:classe,:nvisite,:id_pediatre,:image_1,:image_2,:image_3,:image_4,:image_5,:gift_1,:gift_2,:gift_3,:gift_4,:gift_5,:gift_6,:gift_7,:gift_8,:gift_1_2018,:gift_2_2018,:gift_3_2018,:gift_4_2018,:gift_5_2018,:gift_6_2018,:gift_7_2018,:gift_8_2018,:add_date2,:gps)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("gps", $gps, PDO::PARAM_STR);
            $stmt->bindParam("classe", $classe, PDO::PARAM_STR);
            $stmt->bindParam("nvisite", $nvisite, PDO::PARAM_STR);
            $stmt->bindParam("image_1", $image_1, PDO::PARAM_LOB);
            $stmt->bindParam("image_2", $image_2, PDO::PARAM_LOB);
            $stmt->bindParam("image_3", $image_3, PDO::PARAM_LOB);
            $stmt->bindParam("image_4", $image_4, PDO::PARAM_LOB);
            $stmt->bindParam("image_5", $image_5, PDO::PARAM_LOB);
            $stmt->bindParam("gift_1", $gift_1, PDO::PARAM_INT);
            $stmt->bindParam("gift_2", $gift_2, PDO::PARAM_INT);
            $stmt->bindParam("gift_3", $gift_3, PDO::PARAM_INT);
            $stmt->bindParam("gift_4", $gift_4, PDO::PARAM_INT);
            $stmt->bindParam("gift_5", $gift_5, PDO::PARAM_INT);
            $stmt->bindParam("gift_6", $gift_6, PDO::PARAM_INT);
            $stmt->bindParam("gift_7", $gift_7, PDO::PARAM_INT);
            $stmt->bindParam("gift_8", $gift_8, PDO::PARAM_INT);
	        
			$stmt->bindParam("gift_1_2018", $gift_1_2018, PDO::PARAM_INT);
            $stmt->bindParam("gift_2_2018", $gift_2_2018, PDO::PARAM_INT);
            $stmt->bindParam("gift_3_2018", $gift_3_2018, PDO::PARAM_INT);
            $stmt->bindParam("gift_4_2018", $gift_4_2018, PDO::PARAM_INT);
            $stmt->bindParam("gift_5_2018", $gift_5_2018, PDO::PARAM_INT);
            $stmt->bindParam("gift_6_2018", $gift_6_2018, PDO::PARAM_INT);
            $stmt->bindParam("gift_7_2018", $gift_7_2018, PDO::PARAM_INT);
            $stmt->bindParam("gift_8_2018", $gift_8_2018, PDO::PARAM_INT);
			
			$stmt->bindParam("region", $region, PDO::PARAM_STR);
            $stmt->bindParam("municipalite", $municipalite, PDO::PARAM_STR);
            $stmt->bindParam("etab", $etab, PDO::PARAM_INT);
            $stmt->bindParam("name_etab", $name_etab, PDO::PARAM_STR);
            $stmt->bindParam("type", $type, PDO::PARAM_INT);
            $stmt->bindParam("fullname", $fullname, PDO::PARAM_STR);
            $stmt->bindParam("adresse", $adresse, PDO::PARAM_STR);
            $stmt->bindParam("tel", $tel, PDO::PARAM_STR);
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $stmt->bindParam("remarque", $remarque, PDO::PARAM_STR);
            $stmt->bindParam("remarque_1", $remarque_1, PDO::PARAM_STR);
			
            $stmt->bindParam("id_pediatre", $id_pediatre, PDO::PARAM_INT);
            $stmt->bindParam("add_date2", $add_date2, PDO::PARAM_INT);
            $created = time();
            // $stmt->bindParam("add_date2", $created, PDO::PARAM_INT);
            $stmt->execute();
            


            // $sql1 = "SELECT * FROM pm_data WHERE id=:id ORDER BY id DESC LIMIT 1";
            // $stmt1 = $db->prepare($sql1);
            // $stmt1->bindParam("id", $id, PDO::PARAM_INT);
            // $stmt1->execute();
            // $feedData = $stmt1->fetch(PDO::FETCH_OBJ);


            $db = null;
            echo '{"feedData": "saved !"}';
        // } else{
            // echo '{"error":{"text":"No access"}}';
        // }
       
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}


function savedata(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    // $user_id=$data->user_id;
	
    $id_pediatre=$data->id_pediatre;
    $classe=$data->classe;
    $gps=$data->gps;
    $add_date2=$data->add_date2;
	
    $image_1 =$data->image_1;
    $image_2 =$data->image_2;
    $image_3 =$data->image_3;
    $image_4 =$data->image_4;
    $image_5 =$data->image_5;

	$gift_1 =$data->gift_1;
    $gift_2 =$data->gift_2;
    $gift_3 =$data->gift_3;
    $gift_4 =$data->gift_4;
    $gift_5 =$data->gift_5;

    
    // $systemToken=apiToken($user_id);
   
    try {
         
        // if($systemToken == $token){
         
            
            $feedData = '';
            $db = getDB();
            $sql = "INSERT INTO pm_data ( classe,id_pediatre,image_1,image_2,image_3,image_4,image_5,gift_1,gift_2,gift_3,gift_4,gift_5,add_date2,gps) VALUES (:classe,:id_pediatre,:image_1,:image_2,:image_3,:image_4,:image_5,:gift_1,:gift_2,:gift_3,:gift_4,:gift_5,:add_date2,:gps)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("gps", $gps, PDO::PARAM_STR);
            $stmt->bindParam("classe", $classe, PDO::PARAM_STR);
            $stmt->bindParam("image_1", $image_1, PDO::PARAM_LOB);
            $stmt->bindParam("image_2", $image_2, PDO::PARAM_LOB);
            $stmt->bindParam("image_3", $image_3, PDO::PARAM_LOB);
            $stmt->bindParam("image_4", $image_4, PDO::PARAM_LOB);
            $stmt->bindParam("image_5", $image_5, PDO::PARAM_LOB);
            $stmt->bindParam("gift_1", $gift_1, PDO::PARAM_INT);
            $stmt->bindParam("gift_2", $gift_2, PDO::PARAM_INT);
            $stmt->bindParam("gift_3", $gift_3, PDO::PARAM_INT);
            $stmt->bindParam("gift_4", $gift_4, PDO::PARAM_INT);
            $stmt->bindParam("gift_5", $gift_5, PDO::PARAM_INT);
            $stmt->bindParam("id_pediatre", $id_pediatre, PDO::PARAM_INT);
            $stmt->bindParam("add_date2", $add_date2, PDO::PARAM_INT);
            $created = time();
            // $stmt->bindParam("add_date2", $created, PDO::PARAM_INT);
            $stmt->execute();
            


            // $sql1 = "SELECT * FROM pm_data WHERE id=:id ORDER BY id DESC LIMIT 1";
            // $stmt1 = $db->prepare($sql1);
            // $stmt1->bindParam("id", $id, PDO::PARAM_INT);
            // $stmt1->execute();
            // $feedData = $stmt1->fetch(PDO::FETCH_OBJ);


            $db = null;
            echo '{"feedData": "saved !"}';
        // } else{
            // echo '{"error":{"text":"No access"}}';
        // }
       
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

function newdata(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    // $user_id=$data->user_id;
	

    $add_date2=$data->add_date2;
	
    $region =$data->region;
    $municipalite =$data->municipalite;
    $etab =$data->etab;
    $name_etab =$data->name_etab;
    $type =$data->type;

	$fullname =$data->fullname;
    $adresse =$data->adresse;
    $tel =$data->tel;
    $email =$data->email;
    $remarque =$data->remarque;

    
    // $systemToken=apiToken($user_id);
   
    try {
         
        // if($systemToken == $token){
         
            
            $feedData = '';
            $db = getDB();
            $sql = "INSERT INTO pm_pediatre ( region,municipalite,etab,name_etab,type,fullname,adresse,tel,email,remarque,add_date2) VALUES (:region,:municipalite,:etab,:name_etab,:type,:fullname,:adresse,:tel,:email,:remarque,:add_date2)";
            $stmt = $db->prepare($sql);
       
            $stmt->bindParam("region", $region, PDO::PARAM_STR);
            $stmt->bindParam("municipalite", $municipalite, PDO::PARAM_STR);
            $stmt->bindParam("etab", $etab, PDO::PARAM_INT);
            $stmt->bindParam("name_etab", $name_etab, PDO::PARAM_STR);
            $stmt->bindParam("type", $type, PDO::PARAM_INT);
            $stmt->bindParam("fullname", $fullname, PDO::PARAM_STR);
            $stmt->bindParam("adresse", $adresse, PDO::PARAM_STR);
            $stmt->bindParam("tel", $tel, PDO::PARAM_STR);
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $stmt->bindParam("remarque", $remarque, PDO::PARAM_STR);
     
            $stmt->bindParam("add_date2", $add_date2, PDO::PARAM_INT);
            $created = time();
            // $stmt->bindParam("add_date2", $created, PDO::PARAM_INT);
            $stmt->execute();
            


            // $sql1 = "SELECT * FROM pm_data WHERE id=:id ORDER BY id DESC LIMIT 1";
            // $stmt1 = $db->prepare($sql1);
            // $stmt1->bindParam("id", $id, PDO::PARAM_INT);
            // $stmt1->execute();
            // $feedData = $stmt1->fetch(PDO::FETCH_OBJ);


            $db = null;
            echo '{"feedData": "saved !"}';
        // } else{
            // echo '{"error":{"text":"No access"}}';
        // }
       
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}


function userImage(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $user_id=$data->user_id;
    $token=$data->token;
    $imageB64=$data->imageB64;
    $systemToken=apiToken($user_id);
    try {
        if(1){
            $db = getDB();
            $sql = "INSERT INTO imagesData(b64,user_id_fk) VALUES(:b64,:user_id)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam("b64", $imageB64, PDO::PARAM_STR);
            $stmt->execute();
            $db = null;
            echo '{"success":{"status":"uploaded"}}';
        } else{
            echo '{"error":{"text":"No access"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

$app->post('/getImages', 'getImages');
function getImages(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $user_id=$data->user_id;
    $token=$data->token;
    
    $systemToken=apiToken($user_id);
    try {
        if(1){
            $db = getDB();
            $sql = "SELECT b64 FROM imagesData";
            $stmt = $db->prepare($sql);
           
            $stmt->execute();
            $imageData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"imageData": ' . json_encode($imageData) . '}';
        } else{
            echo '{"error":{"text":"No access"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
?>
