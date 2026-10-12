<!DOCTYPE html>
<html lang="en" >

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tournée Grand Tunis / Delisso</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/select2.css">
		<script src="js/jquery.js"></script>
		<script src="js/select2.js" type="text/javascript" ></script>


<?
date_default_timezone_set("Africa/Tunis");

$datestring = date("Y-m-d H:i:s");  //Pulled in from somewhere
$date = strtotime($datestring . ' Africa/Tunis');
// echo strtotime($datestring . ' Africa/Tunis');



// Initialize variable for database credentials
$dbhost = 'unibronertbackup.mysql.db';
$dbuser = 'unibronertbackup';
$dbpass = 'Momo08545547';
$dbname = 'unibronertbackup';

//Create database connection
  $dblink = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  $dblink->set_charset("utf8");
  
 
$id = $_GET["id"]; 
  
//Check connection was successful
  if ($dblink->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }
?>

  
</head>

<body>
	<div data-role="page" class="jqm-demos" data-quicklinks="true" data-theme="a">

		<div data-role="header" class="jqm-header">
			<h2>Tournée Grand Tunis / Delisso</h2>

		</div><!-- /header -->

    <div role="main" class="ui-content jqm-content">
	
  <form action="api/savedata2" method="POST" id="example-form" class="form" enctype="multipart/form-data" autocomplete="off">
  
  
      <div class="divglob">
	  
	<input type="hidden" name="add_date" value="<?php echo $date; ?>" />	
  
  	<div class="lab">
		<label for="id_pediatre" class="select">Pédiatre / Sage-femme</label>
	</div>

	<div class="lab2">	
		<select id="id_pediatre" class="class_input" name="id_pediatre" data-native-menu="false" style="">
			<option value="">-</option>
			
			
			
<?php



		$query = "SELECT id,fullname FROM `pm_pediatre` ";


//Fetch 3 rows from actor table
  $result = $dblink->query($query);

//Initialize array variable
  // $dbdata = array();
  
//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
	  // $dbdata = array_map('utf8_encode', $row);
?>
	<option value="<? echo $row["id"]; ?>"><? echo $row["fullname"]; ?></option>
<?
  }


 
?>
			
<!-- <option value='644'>Aamer Sabiha</option>
<option value='294'>Abdelaziz amami</option>
<option value='132'>Abdelaziz bellasfar</option>
<option value='137'>Abdelaziz ben karam</option>
<option value='207'>Abdelaziz harbi</option>
<option value='488'>Abdelfettah guermazi</option>
<option value='395'>Abdelkader yedes </option>
<option value='249'>Abdellatif ben jeddou </option>
<option value='479'>Abderaouf chabchoub </option>
<option value='449'>Abderrahmen bagais </option>
<option value='405'>Abderrahmen barbouche</option>
<option value='64'>Abderrazak ben hamden ben tkhayat</option>
<option value='66'>Abdessalem ben harrathi</option>
<option value='216'>Abir bedoui ghozzi</option>
<option value='411'>Adel ben elkadhi</option>
<option value='277'>Adel debbiche </option>
<option value='231'>Adel wardani </option>
<option value='385'>Adel zouaoui</option>
<option value='274'>Afef ben salah ben hmida</option>
<option value='202'>Afef fourati ben ayed</option>
<option value='680'>Afef hentati</option>
<option value='142'>Afef mezni</option>
<option value='161'>Afef zarouk chalghoumi</option>
<option value='667'>Afif besbes </option>
<option value='62'>Afif jridi</option>
<option value='631'>Afif zouari</option>
<option value='621'>Ahlem alhara khafcha</option>
<option value='270'>Ahlem keffi</option>
<option value='67'>Ahlem ouachani ep halloumi</option>
<option value='124'>Ahmed ben abdallah</option>
<option value='368'>Ahmed ben mansour </option>
<option value='174'>Ahmed cherif</option>
<option value='151'>Ahmed gharbi</option>
<option value='608'>Ahmed maherzi</option>
<option value='180'>Ahmed ourari</option>
<option value='407'>Ahmed raboudi</option>
<option value='637'>Aicha hadj ali</option>
<option value='632'>Aissi Houcem</option>
<option value='6'>Ali bibi</option>
<option value='456'>Ali debbabi </option>
<option value='67'>Ali ghariani</option>
<option value='78'>Ali kayen</option>
<option value='361'>Alia ben jmeaa ben jmeaa</option>
<option value='65'>Alla boultskaya</option>
<option value='237'>Alya abdelali </option>
<option value='694'>Amami Abdelaziz</option>
<option value='649'>Amara Ben Ghalia Amel</option>
<option value='291'>Amel ben ghalia amara</option>
<option value='333'>Amel ben salah</option>
<option value='489'>Amel gharbi </option>
<option value='232'>Amel hamila </option>
<option value='72'>Amel naili</option>
<option value='397'>Amel selmi hamada</option>
<option value='224'>Amel tej</option>
<option value='609'>Amel triki</option>
<option value='617'>Ameni ben taieb</option>
<option value='431'>Ameni somai </option>
<option value='195'>Amer bader </option>
<option value='198'>Ameur jouirou</option>
<option value='242'>Amina ben khalifa </option>
<option value='426'>Amina jijel </option>
<option value='396'>Amine ben othman </option>
<option value='113'>Amira benzarti sakouhi</option>
<option value='43'>Amira haoua</option>
<option value='332'>Amira jridi</option>
<option value='388'>Amor mechri</option>
<option value='377'>Anas krichen </option>
<option value='399'>Anis allagui </option>
<option value='7'>Annabi sameh ep Dekhil</option>
<option value='363'>Anoir kssantini</option>
<option value='79'>Aroussi mouadeb hamrouni</option>
<option value='608'>Askri Wali Mouna</option>
<option value='295'>Asma bouaziz elabed</option>
<option value='110'>Asma hamdi achouri </option>
<option value='144'>Asma marzoug</option>
<option value='159'>Assia mahfouth</option>
<option value='652'>Assia sbouii</option>
<option value='186'>Atef ben mansour</option>
<option value='9'>Attalah charefedine </option>
<option value='452'>Ayoub kamoun </option>
<option value='697'>Azek Mazigh Saloua</option>
<option value='469'>Azza sammoud </option>
<option value='352'>Bakhta oudhali</option>
<option value='17'>Balkis ben salah somrani</option>
<option value='6'>Barrak essid</option>
<option value='321'>Basma khaldi</option>
<option value='114'>Basma khaledi</option>
<option value='214'>Basma mestiri</option>
<option value='177'>Basma tayahi karabibéne</option>
<option value='669'>Bchira brahem</option>
<option value='178'>Bechir ben ali ritha lazzem</option>
<option value='230'>Béchir bouraoui</option>
<option value='39'>Bechir mousli</option>
<option value='614'>Bel Lakhdhar Mohamed Amine</option>
<option value='606'>Bellagha El Inkichari Néjia </option>
<option value='642'>Ben Abdallah Chadly</option>
<option value='689'>Ben achour Moncef</option>
<option value='636'>Ben Ammar Bergaoui Boutheina</option>
<option value='16'>Ben boubaker zouhaier</option>
<option value='652'>Ben Fredj Fethi</option>
<option value='620'>Ben Hadj Riadh</option>
<option value='663'>Ben Hamada Larnaout Manel</option>
<option value='688'>Ben Harrath Nasri Mouna</option>
<option value='600'>Ben Jedou Abdeltif</option>
<option value='692'>Ben Jemaa Moncef </option>
<option value='658'>Ben Mansour Jamel</option>
<option value='35'>Ben mrad nigar</option>
<option value='691'>Ben ridha El ayadi Mohamed</option>
<option value='602'>Ben salah ben hmida Afef</option>
<option value='683'>Besma naouaji</option>
<option value='22'>Bessioud leila ep kourda</option>
<option value='648'>Blaïech Nôomene</option>
<option value='172'>Bochra laarouchi</option>
<option value='102'>Borhen jlizi</option>
<option value='626'>Bouaziz Asma</option>
<option value='623'>Bouguessas Samir </option>
<option value='634'>Bouraoui zone </option>
<option value='265'>Boutheina ben ammar bergaoui </option>
<option value='189'>Boutheina meatouk chemli</option>
<option value='615'>Bouzaràa Jelassi Jihène</option>
<option value='622'>Bouzaràa Jelassi Jihène</option>
<option value='111'>Brahim ben ali jmii</option>
<option value='601'>Brahim Gardabou Karima</option>
<option value='204'>Brahim ghali</option>
<option value='278'>Chadly ben abdallah</option>
<option value='152'>Chaima balhi </option>
<option value='609'>Chaker Taieb </option>
<option value='293'>Charfedine doggaz</option>
<option value='643'>Chemléli Fadhila ( Sage femme )</option>
<option value='112'>Cherif bakhti</option>
<option value='462'>Cherif nouredine</option>
<option value='63'>Chevenchella allah</option>
<option value='120'>Chiraz aloui</option>
<option value='23'>Chnayna jamel</option>
<option value='154'>Chokri ben moussa</option>
<option value='635'>Chokri tka </option>
<option value='624'>Dabebi Krifa Raja</option>
<option value='607'>Dahmen Mohamed </option>
<option value='163'>Dalel ben hassine souii</option>
<option value='485'>Dalila dey</option>
<option value='638'>Debbabi Krifa Raja</option>
<option value='647'>Debbiche Adel</option>
<option value='162'>Dhiaeddine chakroun</option>
<option value='695'>Doghri Samir</option>
<option value='254'>Donya ayed </option>
<option value='402'>Dorra racil</option>
<option value='699'>El Hakim Hmila Raouf</option>
<option value='656'>El Hbib Leila ( Sage Femme )</option>
<option value='611'>El Kefi Ahlem</option>
<option value='603'>El kilani Fatma </option>
<option value='631'>El Mabrouk Slim </option>
<option value='613'>El mokcher el Mabrouk Nabila</option>
<option value='289'>Elisabeth yacoub</option>
<option value='655'>Ellouati Ikram</option>
<option value='105'>Essia turki hammami</option>
<option value='84'>Fadhila ben amor hachani</option>
<option value='303'>Fafany ben mansour</option>
<option value='646'>Faouzi skhiri</option>
<option value='478'>Faouzia khaldi </option>
<option value='100'>Farah bel hadj rhouma </option>
<option value='153'>Farid abd fatteh snoussi</option>
<option value='287'>Farid jaafer </option>
<option value='261'>Farid mahjoub </option>
<option value='419'>Farid souibghi </option>
<option value='157'>Faten bellagha</option>
<option value='300'>Faten fedhila </option>
<option value='357'>Faten saidi</option>
<option value='316'>Faten tinsa </option>
<option value='252'>Faten zayani m'rad</option>
<option value='262'>Fathila chemlelli</option>
<option value='366'>Fatma kamoun </option>
<option value='318'>Fatma khalsi </option>
<option value='272'>Fatma kilani </option>
<option value='349'>Fatma loulou mhiri </option>
<option value='279'>Fatma marzouki </option>
<option value='329'>Fatma salhi</option>
<option value='675'>Fatma torkhani</option>
<option value='101'>Fatma zarouk </option>
<option value='443'>Faycal cherichi </option>
<option value='460'>Fayçal oubich </option>
<option value='74'>Faycel nasfi</option>
<option value='18'>Fayrouz ben rathia nsib</option>
<option value='403'>Fayrouz khalfallah</option>
<option value='108'>Fedra bennour jebali</option>
<option value='422'>Feriel limem</option>
<option value='331'>Feryel hamami</option>
<option value='441'>Feten makki</option>
<option value='655'>Fethi amri </option>
<option value='438'>Fethi ben fredj</option>
<option value='118'>Feyda ayadi</option>
<option value='190'>Fredj hassine</option>
<option value='625'>Friha Farida</option>
<option value='150'>Ftouhi dhorbani</option>
<option value='134'>Ghaith atallah</option>
<option value='650'>Ghedasmi Aicha Amira</option>
<option value='604'>Ghrairi Abdellatif leila</option>
<option value='651'>Guedhami Hamdi</option>
<option value='645'>Guermessi Lamia ( Sage femme )</option>
<option value='197'>Habib selmi</option>
<option value='623'>Habib soua</option>
<option value='227'>Habib zahouani </option>
<option value='642'>Habiba tilouche memmi</option>
<option value='20'>Hadhami ghaffari ben chaaben</option>
<option value='71'>Hadia hamrouni</option>
<option value='687'>Hadji Mouna </option>
<option value='373'>Hafeth bahloul </option>
<option value='404'>Hager dhaoui boussetta</option>
<option value='628'>Haifa bouchahda</option>
<option value='401'>Haifa chraie</option>
<option value='603'>Haifa ouerda</option>
<option value='400'>Haithem bachouch </option>
<option value='103'>Hajer ayari lachheb </option>
<option value='85'>Hajer karoui</option>
<option value='611'>Hajer sallemi </option>
<option value='614'>Hajer trabelsi</option>
<option value='344'>Hajeur aloulou</option>
<option value='99'>Hakima kebaier</option>
<option value='654'>Hamadi nsiri</option>
<option value='290'>Hamdi guedhami</option>
<option value='141'>Hamed kortas</option>
<option value='238'>Hamouda mestiri </option>
<option value='657'>Hamza berbouch</option>
<option value='632'>Hana jerbi</option>
<option value='125'>Hana tlili </option>
<option value='69'>Hanene zamzmi</option>
<option value='341'>Hasar triki </option>
<option value='630'>Hasna zkhama</option>
<option value='650'>Hassine metjamoul</option>
<option value='360'>Hatem ben amor</option>
<option value='98'>Hatem ben salem </option>
<option value='458'>Hathemi hammami</option>
<option value='41'>Hayet bourguiba</option>
<option value='379'>Hayet chaari </option>
<option value='665'>Hbib besbes </option>
<option value='625'>Hechmi ben hamouda</option>
<option value='673'>Hedia hassanine</option>
<option value='179'>Hichem ben hassen ben gara</option>
<option value='378'>Hichem feki</option>
<option value='641'>Hosni Dhouha( Sage femme )</option>
<option value='259'>Houcine aissi</option>
<option value='66'>Houcine ben ammer</option>
<option value='155'>Houcine boujemaa</option>
<option value='115'>Houda abessi</option>
<option value='320'>Houda abessi</option>
<option value='32'>Houda arjoun hammami</option>
<option value='613'>Houda ben ali sahraoui</option>
<option value='203'>Houda ben rayana khelifi</option>
<option value='146'>Houda foughali ben jazia</option>
<option value='19'>Ibtissam frikha maaloul</option>
<option value='34'>Ibtissam hafsa ep tamboura</option>
<option value='40'>Ichraf el hakim</option>
<option value='168'>Ichrak khamessi</option>
<option value='94'>Iheb attia </option>
<option value='104'>Iheb haffeni</option>
<option value='421'>Ikram louati</option>
<option value='605'>Ilhem fetni</option>
<option value='26'>Imen ayadi </option>
<option value='160'>Imen ayouni</option>
<option value='311'>Imen belhadj</option>
<option value='346'>Imen chabchoub </option>
<option value='3'>Imen hadj ahmed zarouane</option>
<option value='42'>Imen hattab</option>
<option value='256'>Imen jlassi</option>
<option value='201'>Imen khalaf athari</option>
<option value='193'>Imen lahmar ep boukadida</option>
<option value='264'>Imen riahi</option>
<option value='308'>Ines ben massoud razzag</option>
<option value='317'>Ines brini</option>
<option value='353'>Ines kalamoun </option>
<option value='365'>Ines maaloul</option>
<option value='602'>Ines selmi </option>
<option value='313'>Ines trabelsi</option>
<option value='206'>Ismail hachicha</option>
<option value='166'>Issam romthane</option>
<option value='616'>Jaafar Férid</option>
<option value='640'>Jaafer mabrouk</option>
<option value='659'>Jalel ben ali khalif</option>
<option value='37'>Jalel ben ghozia</option>
<option value='208'>Jalel chaieb </option>
<option value='420'>Jamel ben mansour </option>
<option value='77'>Jamila el ich</option>
<option value='662'>Jenhani Svitlana</option>
<option value='324'>Jihen ben zahra trad </option>
<option value='75'>Jihen jabeur</option>
<option value='492'>Jihen jebri</option>
<option value='285'>Jihen jlassi</option>
<option value='221'>Jihene bouguila </option>
<option value='442'>Jilani takrouni</option>
<option value='621'>Jlassi Marwa</option>
<option value='304'>Kalthoum kazdaghli</option>
<option value='117'>Kalthoum thefallah</option>
<option value='629'>Kamel kamoun </option>
<option value='215'>Kamel mestiri</option>
<option value='145'>Karima abidi chaieb </option>
<option value='273'>Karima brahim gardabou</option>
<option value='634'>Karoui Seifeddine</option>
<option value='628'>Kenoun Mohamed Nejib</option>
<option value='444'>Khadija bel hadj gnaîchia </option>
<option value='410'>Khadija belkaied souissi</option>
<option value='312'>Khadija bousetta</option>
<option value='495'>Khadija kouba</option>
<option value='187'>Khair eddin bouchahoua</option>
<option value='620'>Khaled becha </option>
<option value='647'>Khaled ben hlel</option>
<option value='25'>Khaled kabous</option>
<option value='641'>Khaled lajmi </option>
<option value='60'>Khaled salhi</option>
<option value='184'>Khaled sghaier</option>
<option value='640'>Khammar Hajer ( Sage femme )</option>
<option value='398'>Khaoula aissa</option>
<option value='423'>Khaouther abid </option>
<option value='661'>Khmiri Hanen ( Sage femme )</option>
<option value='11'>Ksila maha</option>
<option value='13'>Labassi aymen</option>
<option value='666'>Lamia attia saafi</option>
<option value='345'>Lamia ben mansour</option>
<option value='220'>Lamia boughamoura</option>
<option value='15'>Lamia chabchoub krichen </option>
<option value='448'>Lamia gharsallah guelmami</option>
<option value='38'>Lamia ouerfelli</option>
<option value='243'>Lamia sebai dhaoui </option>
<option value='359'>Lasaad walha</option>
<option value='440'>Latifa bouchnak</option>
<option value='467'>Latifa bouguerra </option>
<option value='133'>Latifa hadfi chahmi</option>
<option value='87'>Leila belhadj</option>
<option value='618'>Leila dabebi</option>
<option value='327'>Leila dellagi terras </option>
<option value='483'>Leila essaddem</option>
<option value='662'>Leila ghedira </option>
<option value='275'>Leila ghrairi abdellatif </option>
<option value='463'>Leila haddad meddeb</option>
<option value='182'>Leila nefzi</option>
<option value='171'>Lilia messai</option>
<option value='362'>Lilia trieki</option>
<option value='657'>Limam Ep Nguira Feriel</option>
<option value='148'>Lobna aloui kasmi</option>
<option value='677'>Lobna baatout</option>
<option value='65'>Lotfi karboul</option>
<option value='386'>Lotfi trabelsi </option>
<option value='21'>Louadedh dekhil</option>
<option value='635'>Mahjoub Férid </option>
<option value='698'>Mahjoub Souiden Mariem</option>
<option value='185'>Mahmoud arif</option>
<option value='307'>Mahmoud baraket</option>
<option value='639'>Mahmoud ben aziza </option>
<option value='92'>Makrem zenaidi</option>
<option value='383'>Malek chaabouni</option>
<option value='390'>Manel ben hamada larnout </option>
<option value='314'>Manel ben romdhane </option>
<option value='653'>Manoubi Mohamed</option>
<option value='239'>Mariem darghouth mzali </option>
<option value='253'>Mariem mahjoub souiden </option>
<option value='498'>Mariem saadalah</option>
<option value='64'>Maroua mouadeb</option>
<option value='205'>Marouane babay</option>
<option value='436'>Marwen zayani</option>
<option value='627'>Marzouk Asma</option>
<option value='637'>Marzouki Fatma </option>
<option value='4'>Med salah romthane </option>
<option value='33'>Mehrzi mohamed sofien</option>
<option value='381'>Mejda zarnit </option>
<option value='241'>Michaal gharbi</option>
<option value='196'>Miled ben daly</option>
<option value='633'>Mkadem Hend ( sage femme )</option>
<option value='610'>Mme Bouhjar Néjia ( sage femme )</option>
<option value='630'>Mme Hamdi ( sage femme )</option>
<option value='46'>Mme Karay</option>
<option value='636'>Moez hassairi</option>
<option value='376'>Mohamed ali mekki</option>
<option value='281'>Mohamed amine bel lakhdhar</option>
<option value='686'>Mohamed badissa chanoufi</option>
<option value='645'>Mohamed ben abderahmen</option>
<option value='658'>Mohamed ben abderahmen khalif</option>
<option value='358'>Mohamed ben slimen </option>
<option value='49'>Mohamed boubtan</option>
<option value='266'>Mohamed dahmen </option>
<option value='335'>Mohamed derbel </option>
<option value='95'>Mohamed douagi</option>
<option value='326'>Mohamed el bez </option>
<option value='219'>Mohamed faouzi kallel </option>
<option value='233'>Mohamed fathi arnaz </option>
<option value='633'>Mohamed fethi hamza</option>
<option value='408'>Mohamed gastli </option>
<option value='382'>Mohamed guermezi</option>
<option value='340'>Mohamed habib kchaou</option>
<option value='83'>Mohamed hedoui</option>
<option value='61'>Mohamed jameledine mestaoui</option>
<option value='439'>Mohamed manoubi</option>
<option value='44'>Mohamed megdiche</option>
<option value='465'>Mohamed mehiar harbi </option>
<option value='292'>Mohamed moncef baccar</option>
<option value='288'>Mohamed najib kanoun</option>
<option value='661'>Mohamed neji ben mariem </option>
<option value='351'>Mohamed noomen ellouz </option>
<option value='457'>Mohamed ritha akacha </option>
<option value='369'>Mohamed ritha fourati</option>
<option value='622'>Mohamed taher sfar</option>
<option value='175'>Mohamed taoufik mkadmi</option>
<option value='644'>Moheddine rathouane </option>
<option value='128'>Mohsen sarrai</option>
<option value='244'>Moncef ben achour </option>
<option value='250'>Moncef ben jemaa </option>
<option value='139'>Moncef boulares </option>
<option value='126'>Moncef kamoun </option>
<option value='416'>Moncef ksontini</option>
<option value='226'>Mondher bhouri </option>
<option value='453'>Mongi ben ammar </option>
<option value='409'>Mongi ezzili</option>
<option value='236'>Mongi mosbahi </option>
<option value='342'>Mongia hachicha </option>
<option value='656'>Monia abderahmen troudi</option>
<option value='493'>Monia barouni</option>
<option value='129'>Monia joulag</option>
<option value='681'>Monia roban</option>
<option value='671'>Monira charfi</option>
<option value='392'>Moufida chahed</option>
<option value='424'>Moufida ouali </option>
<option value='235'>Mouldi lahmar </option>
<option value='138'>Mouldi ouergui</option>
<option value='268'>Mouna askri wali</option>
<option value='93'>Mouna ben harrath nasri</option>
<option value='429'>Mouna chiha cherif </option>
<option value='674'>Mouna ezzine </option>
<option value='88'>Mouna hadji</option>
<option value='474'>Mouna hajji nouri</option>
<option value='183'>Mouna mzougui</option>
<option value='194'>Mouna trabelsi bousnina</option>
<option value='173'>Mounir abida</option>
<option value='82'>Mounir aloui</option>
<option value='170'>Mounir fersi</option>
<option value='387'>Mounir loukil </option>
<option value='371'>Mounir mallek </option>
<option value='643'>Mounira brahim ayechi</option>
<option value='487'>Mourad bouden </option>
<option value='306'>Mourad bouraoui</option>
<option value='370'>Mourad sarbaji </option>
<option value='473'>Msadek assidi</option>
<option value='428'>Mtir trabelsi </option>
<option value='80'>Mustapha abd rahim</option>
<option value='164'>Mustapha guermiz</option>
<option value='165'>Mustapha helaoui</option>
<option value='427'>Nabiha hajri</option>
<option value='338'>Nabil jribi </option>
<option value='269'>Nabila mekacher mabrouk</option>
<option value='158'>Nabila said</option>
<option value='68'>Nada bel hadj brahim boubaker</option>
<option value='121'>Nadia ben ammer</option>
<option value='445'>Nadia ben miled bayali </option>
<option value='131'>Nadia guellouz najjar</option>
<option value='97'>Nadia kasdallah</option>
<option value='482'>Nadia mahrssi</option>
<option value='62'>Nadia mofteh</option>
<option value='604'>Nadia siala </option>
<option value='283'>Nadia souaissi </option>
<option value='391'>Nahla lengliz lamine </option>
<option value='437'>Najeh barhoumi</option>
<option value='191'>Najeh ben hmida kouki</option>
<option value='347'>Najeh boujelben </option>
<option value='464'>Najeh gharam </option>
<option value='63'>Najeh smaali</option>
<option value='466'>Najib raboudi</option>
<option value='218'>Najla salem ben letaifa</option>
<option value='222'>Najla soyah</option>
<option value='328'>Najoua bouhouch</option>
<option value='167'>Najoua gandoura</option>
<option value='136'>Najoua jaziri</option>
<option value='648'>Najoua kahloul </option>
<option value='135'>Najoua naimi</option>
<option value='615'>Najoua soltani</option>
<option value='356'>Najoua zitouni</option>
<option value='107'>Narjes ben fraj tayr lil</option>
<option value='140'>Naziha guelmani</option>
<option value='374'>Naziha hamza jardak</option>
<option value='616'>Nedra ben sghaier</option>
<option value='451'>Nedra hamza kanoun</option>
<option value='234'>Neila hachicha chekir </option>
<option value='192'>Neila zemni</option>
<option value='282'>Néjia bellagha el inkichari</option>
<option value='109'>Nesria bouras</option>
<option value='668'>Nizar moulazem </option>
<option value='477'>Nizar nouaili </option>
<option value='276'>Nôomene blaîech </option>
<option value='682'>Noura ayadi</option>
<option value='47'>Noura ben salah</option>
<option value='122'>Nourchene khelil charfeddine </option>
<option value='31'>Nouredine larbi</option>
<option value='30'>Ohamed abid</option>
<option value='433'>Olfa ben mahmoud </option>
<option value='471'>Olfa bouyahia</option>
<option value='430'>Olfa farid ben hassine </option>
<option value='612'>Olfa gasmi jelassi</option>
<option value='169'>Olfa hammami</option>
<option value='414'>Olfa hichri</option>
<option value='284'>Olfa kortli </option>
<option value='651'>Olfa kraiem </option>
<option value='143'>Olfa lassoued</option>
<option value='606'>Ones azzabi</option>
<option value='255'>Ouesleti hethili </option>
<option value='48'>Rabiaa amri</option>
<option value='127'>Rachid besbes</option>
<option value='336'>Rachida arous</option>
<option value='476'>Rachida kafsi ayadi</option>
<option value='432'>Rafaa khadraoui</option>
<option value='418'>Rafiaa mustapha abdelwahed</option>
<option value='69'>Rafik farhat guerfela </option>
<option value='296'>Rafla tej dallagi</option>
<option value='484'>Rahma guedri</option>
<option value='156'>Raja abdelmoula</option>
<option value='298'>Raja dabbabi krifa </option>
<option value='468'>Raouf belhadj </option>
<option value='248'>Raouf hmila </option>
<option value='355'>Raouia selmi</option>
<option value='624'>Raoutha boussoffara</option>
<option value='149'>Rathia makni</option>
<option value='76'>Rathouane abid</option>
<option value='217'>Rathouane attia</option>
<option value='225'>Rawdha kebeili</option>
<option value='119'>Rebah ajili</option>
<option value='619'>Riahi Boukadida Imen</option>
<option value='258'>Riath ben hadj </option>
<option value='213'>Rim bouhlel khénissi</option>
<option value='475'>Ritha ayache </option>
<option value='28'>Ritha bayrem </option>
<option value='375'>Ritha marrakchi </option>
<option value='229'>Robka kassiri </option>
<option value='181'>Rym miaoui</option>
<option value='90'>Rym youssef</option>
<option value='447'>Rym zardoub achour </option>
<option value='480'>Saayda ben becheur</option>
<option value='664'>Sabeur hammami </option>
<option value='607'>Sadok zayeda</option>
<option value='393'>Sahar mouldi</option>
<option value='446'>Sahbi karoui</option>
<option value='91'>Saîd bibi</option>
<option value='610'>Saida belgacem </option>
<option value='672'>Saida hikimi</option>
<option value='434'>Saiida fray</option>
<option value='147'>Salah maaroufi</option>
<option value='81'>Salem elkhnissi</option>
<option value='412'>Salem sahli </option>
<option value='472'>Salem yahiaoui</option>
<option value='415'>Salima mhamed</option>
<option value='364'>Salma ben ameur </option>
<option value='450'>Salma hachicha</option>
<option value='627'>Salma wannes</option>
<option value='435'>Saloua abdelli</option>
<option value='246'>Saloua azek mazigh </option>
<option value='188'>Salwa forkani</option>
<option value='245'>Salwa thamri mabrouki </option>
<option value='305'>Samar rhayem</option>
<option value='212'>Sameh abdi</option>
<option value='199'>Sameh chaieb ben amor</option>
<option value='130'>Sameh chouaibi briki </option>
<option value='12'>Sameh jamoussi</option>
<option value='653'>Sameh khameri</option>
<option value='454'>Sami jebnoun</option>
<option value='325'>Sami sarrai</option>
<option value='490'>Samia bahri</option>
<option value='14'>Samia ben mbarek bouziri</option>
<option value='302'>Samia cherif</option>
<option value='211'>Samia gaaliche el afrit</option>
<option value='86'>Samia hamadi</option>
<option value='315'>Samia hamouda </option>
<option value='600'>Samia hendaoui</option>
<option value='348'>Samia kalsi betaieb</option>
<option value='257'>Samia ouerfelli </option>
<option value='116'>Samia saîdi</option>
<option value='413'>Samia taalouche turki </option>
<option value='223'>Samia tilouche </option>
<option value='638'>Samir bellazreg</option>
<option value='297'>Samir bouguessas </option>
<option value='251'>Samir doghri </option>
<option value='660'>Samir feji </option>
<option value='301'>Samir haddad</option>
<option value='73'>Samir mrabet</option>
<option value='89'>Samira lahbib</option>
<option value='319'>Samira saidi</option>
<option value='367'>Sana kmiha </option>
<option value='330'>Sana mbarki </option>
<option value='8'>Saoussen mrad zaier </option>
<option value='339'>Sarra sahnoun ayedi</option>
<option value='612'>Sdiri Sonia </option>
<option value='36'>Sdiri ziadi wafa</option>
<option value='260'>Seiffddine karoui</option>
<option value='354'>Senda abdelmoula</option>
<option value='299'>Siham barsaoui</option>
<option value='684'>Sinda naji</option>
<option value='663'>Slah chouchne</option>
<option value='618'>Slama Walid</option>
<option value='286'>Slim mabrouk</option>
<option value='240'>Slim mahrzi </option>
<option value='626'>Sobhi ghanmi</option>
<option value='123'>Sofien azaiez</option>
<option value='380'>Sondes el aich</option>
<option value='323'>Sonia attia ladhari</option>
<option value='372'>Sonia bahloul kraiti </option>
<option value='96'>Sonia blibech</option>
<option value='494'>Sonia bouali </option>
<option value='61'>Sonia bouziri</option>
<option value='670'>Sonia chebili</option>
<option value='685'>Sonia hajem </option>
<option value='334'>Sonia jmal turki</option>
<option value='417'>Sonia khanfir besbes </option>
<option value='10'>Sonia mellouch</option>
<option value='470'>Sonia mrad mazigh</option>
<option value='459'>Souad bousnina </option>
<option value='280'>Souad ezzoug</option>
<option value='60'>Souad ghanoudi selim</option>
<option value='247'>Souad souissi </option>
<option value='639'>Souaissi Nadia ( Sage femme )</option>
<option value='678'>Souha gammouni</option>
<option value='693'>Souissi Souad </option>
<option value='70'>Soumaya chaibi</option>
<option value='389'>Svitlana jenhani </option>
<option value='27'>Taher ghozzi </option>
<option value='267'>Taieb chaker </option>
<option value='654'>Takrouni Jilani</option>
<option value='210'>Taoufik jrad</option>
<option value='228'>Taoufik maalel </option>
<option value='486'>Tarek el akkad </option>
<option value='690'>Thamri Mabrouki Salwa</option>
<option value='455'>Thouraya ayari charfi</option>
<option value='499'>Thouraya cherif amara</option>
<option value='343'>Thouraya kammoun</option>
<option value='646'>Triki Siwar ( Sage femme )</option>
<option value='68'>Wafa ben romthane</option>
<option value='619'>Wafa fakraoui krichi</option>
<option value='200'>Wafa thiab ep mlih</option>
<option value='309'>Walid maamer </option>
<option value='263'>Walid slama </option>
<option value='45'>Warda jbeli</option>
<option value='322'>Warda jbeli</option>
<option value='461'>Wided hamza lariani </option>
<option value='497'>Wiem demai</option>
<option value='350'>Wiem maazoun chaker </option>
<option value='29'>Wissal hannachi ben temime</option>
<option value='384'>Wissem chaari frikha </option>
<option value='629'>Yacoub Elisabeth</option>
<option value='605'>Yacoub Lotfi </option>
<option value='337'>Yahia hammami</option>
<option value='425'>Yamen baccar</option>
<option value='659'>Yamen Baccar</option>
<option value='491'>Yasmina maaroufi</option>
<option value='496'>Yasmina thabet </option>
<option value='601'>Yosr dridi</option>
<option value='310'>Yosra arfaoui garbouj </option>
<option value='679'>Yosra ben rajeb </option>
<option value='271'>Zahra ben azza</option>
<option value='209'>Zahra ben khahla</option>
<option value='481'>Zahra fitouri</option>
<option value='649'>Zakia haboul</option>
<option value='696'>Zayane M’Rad Faten</option>
<option value='660'>Zayani Marwen</option>
<option value='617'>Zdiri Hella</option>
<option value='394'>Zeineb jenhani bacha </option>
<option value='176'>Zied boujemaa</option>
<option value='676'>Zina abdelli</option>
<option value='664'>Zneikha ben Slimane</option>
-->

			
		</select>
	</div>

<div class="separator"></div>
	  
  	<div class="lab">
		<label for="region" class="select" class="class_input" >Gouvernorat</label>
		</div>

	<div class="lab2">	
		<select name="region" id="region" class="class_input" >
			<option value="">-</option>
			
							<option value="Ariana">Ariana</option>                          
                            <option value="Ben Arous">Ben Arous</option>
							<option value="Manouba">Manouba</option>
							<option value="Tunis">Tunis</option>
							<option value="Sousse">Sousse</option>
							
							<option value="Beja">Beja</option>
                            <option value="Bizerte">Bizerte</option>
                            <option value="Gabes">Gabes</option>
                            <option value="Gafsa">Gafsa</option>
                            <option value="Jendouba">Jendouba</option>
                            <option value="Kairouan">Kairouan</option>
                            <option value="Kasserine">Kasserine</option>
                            <option value="Kef">Kef</option>
                            <option value="Mahdia">Mahdia</option>                            
                            <option value="Medenine">Medenine</option>
                            <option value="Monastir">Monastir</option>
                            <option value="Nabeul">Nabeul</option>
                            <option value="Sfax">Sfax</option>
                            <option value="Sidi Bouzid">Sidi Bouzid</option>
                            <option value="Seliana">Seliana</option>
                            
                       
					   <option value="Tataouine">Tataouine</option>                            
                            <option value="Zaghouan">Zaghouan</option>
		
		</select>
	</div>  
 

 	<div class="lab">
		<label for="municipalite" class="class_input" >Municipalité</label>
		</div>

	<div class="lab2">	
		<select name="municipalite" id="municipalite" class="class_input" >
							
							<option class="all" value="">-</option>
			
							<option value="Ariana medina" class="Ariana">Ariana medina</option>
                            <option value="Menzah 6"  class="Ariana">Menzah 6</option>
                            <option value="Menzah 7 – Ennasr II"  class="Ariana">Menzah 7 – Ennasr II</option>
                         
                            <option class="Beja" value="Zahret Medien (amdoun)">Zahret Medien (amdoun)</option>
                            <option class="Beja" value="Goubellat">Goubellat</option>
                            <option class="Beja" value="Nefza">Nefza</option>
                            <option class="Beja" value="Teboursouk">Teboursouk</option>
                            <option class="Beja" value="Testour">Testour</option>
                            <option class="Beja" value="Beja ville">Beja ville</option>
                            <option class="Beja" value="Medjez El Beb">Medjez El Beb</option>
                           

                            <option class="BenArous" value="Ezzahra">Ezzahra</option>
                            <option class="BenArous" value="Mégrine">Mégrine</option>
                            <option class="BenArous" value="Hammam Linf">Hammam Linf</option>
                            <option class="BenArous" value="MHamdia">MHamdia</option>
                            <option class="BenArous" value="Rades Milaha">Rades Milaha</option>
                            <option class="BenArous" value="Ben Arous est">Ben Arous est</option>
                            <option class="BenArous" value="EL Mourouj">El Mourouj</option>

                         

                              <option class="Bizerte" value="Joumine">Joumine</option>
                              <option class="Bizerte" value="Mateur">Mateur</option>
                              <option class="Bizerte" value="Sejnane">Sejnane</option>
                              <option class="Bizerte" value="El Alia">El Alia</option>
                              <option class="Bizerte" value="Menezl Jemil">Menezl Jemil</option>
                              <option class="Bizerte" value="Ras jebel">Ras jebel</option>
                              <option class="Bizerte" value="Bizerte">Bizerte</option>
                              <option class="Bizerte" value="Menzel Bourguiba">Menzel Bourguiba</option>
                           
                            <option class="Gabes" value="Mtorrech">Mtorrech</option>
                            <option class="Gabes" value="Gabes ville">Gabes ville</option>
                            <option class="Gabes" value="Nouvelle Matmata">Nouvelle Matmata</option>
                            <option class="Gabes" value="Ouedhref">Ouedhref</option>
                            <option class="Gabes" value="El Hamma de Gabes">El Hamma de Gabes</option>
                            <option class="Gabes" value="Mareth">Mareth</option>
                          

                            <option class="Jendouba" value="Jendouba">Jendouba</option>
                            <option class="Jendouba" value="Belkhir">Belkhir</option>
                            <option class="Jendouba" value="Jebel Mdhila">Jebel Mdhila</option>
                            <option class="Jendouba" value="Redeyef">Redeyef</option>
                            <option class="Jendouba" value="Sened">Sened</option>
                            <option class="Jendouba" value="El Guettar">El Guettar</option>
                            <option class="Jendouba" value="Moulares">Moulares</option>
                            <option class="Jendouba" value="Doualy Gafsa">Doualy Gafsa</option>
                            <option class="Jendouba" value="Metlaoui">Metlaoui</option>
                            <option class="Jendouba" value="Gafsa Cité Ennour">Gafsa Cité Ennour</option>

                        

                            <option class="Kairouan" value="Ain Draham">Ain Draham</option>
                            <option class="Kairouan" value="Bousalem">Bousalem</option>
                            <option class="Kairouan" value="Fernana">Fernana</option>
                            <option class="Kairouan" value="Ghardimaou">Ghardimaou</option>
                            <option class="Kairouan" value="Tabarka">Tabarka</option>
                            <option class="Kairouan" value="Jendouba">Jendouba</option>
                            <option class="Kairouan" value="Kairouan">Kairouan</option>

                         

                            <option class="Kasserine" value="Chebika">Chebika</option>
                            <option class="Kasserine" value="Cherarda">Cherarda</option>
                            <option class="Kasserine" value="Haffouz">Haffouz</option>
                            <option class="Kasserine" value="Hajeb el ayoun">Hajeb el ayoun</option>
                            <option class="Kasserine" value="Oueslatia">Oueslatia</option>
                            <option class="Kasserine" value="Sbikha">Sbikha</option>
                            <option class="Kasserine" value="Nasrallah">Nasrallah</option>
                            <option class="Kasserine" value="Bou Hajla">Bou Hajla</option>
                            <option class="Kasserine" value="El ala">El ala</option>
                            <option class="Kasserine" value="Kairouan">Kairouan</option>

                          

                            <option class="Kef" value="Dahmani">Dahmani</option>
                            <option class="Kef" value="Sakiet">Sakiet</option>
                            <option class="Kef" value="Tajerouine">Tajerouine</option>
                            <option class="Kef" value="Nebeur">Nebeur</option>
                            <option class="Kef" value="Ksour">Ksour</option>
                            <option class="Kef" value="Kef">Kef</option>

                        

                            <option class="Mahdia" value="Boumerdes">Boumerdes</option>
                            <option class="Mahdia" value="La chebba">La chebba</option>
                            <option class="Mahdia" value="Chorbane">Chorbane</option>
                            <option class="Mahdia" value="Hbira">Hbira</option>
                            <option class="Mahdia" value="Ksour Essef">Ksour Essef</option>
                            <option class="Mahdia" value="Melloulech">Melloulech</option>
                            <option class="Mahdia" value="Sidi alouane">Sidi alouane</option>
                            <option class="Mahdia" value="Souassi">Souassi</option>
                            <option class="Mahdia" value="Ouled chamekh">Ouled chamekh</option>
                            <option class="Mahdia" value="Mahdia">Mahdia</option>

                     

                            <option class="Manouba" value="Douar Hicher">Douar Hicher</option>
                            <option class="Manouba" value="Tebourba">Tebourba</option>
                            <option class="Manouba" value="Manouba">Manouba</option>
                            <option class="Manouba" value="Bardo">Bardo</option>


                            <option class="Medenine" value="Beni Khedache">Beni Khedache</option>
                            <option class="Medenine" value="Djerba Midoun">Djerba Midoun</option>
                            <option class="Medenine" value="Sidi Makhlouf">Sidi Makhlouf</option>
                            <option class="Medenine" value="Ben guerdane">Ben guerdane</option>
                            <option class="Medenine" value="Medenine">Medenine</option>
                            <option class="Medenine" value="Zarzis">Zarzis</option>
                            <option class="Medenine" value="Djerba Houmet Souk">Djerba Houmet Souk</option>

                      
                            <option class="Monastir" value="Monastir">Monastir</option>
                            <option class="Monastir" value="Ksar Hellal">Ksar Hellal</option>
							
                            <option class="Monastir" value="Bekalta">Bekalta</option>
                            <option class="Monastir" value="Bembla">Bembla</option>
                            <option class="Monastir" value="Beni Hassen">Beni Hassen</option>
                            <option class="Monastir" value="Jemmal">Jemmal</option>
                            <option class="Monastir" value="Ksibet el-Médiouni">Ksibet el-Médiouni</option>
                            <option class="Monastir" value="Moknine">Moknine</option>
                            <option class="Monastir" value="Ouerdanine">Ouerdanine</option>
                            <option class="Monastir" value="Sahline">Sahline</option>
                            <option class="Monastir" value="Sayada-Lamta-Bou Hajar">Sayada-Lamta-Bou Hajar</option>
                            <option class="Monastir" value="Téboulba">Téboulba</option>
                            <option class="Monastir" value="Zéramdine">Zéramdine</option>


                            <option class="Nabeul" value="Beni Khalled">Beni Khalled</option>
                            <option class="Nabeul" value="Grombalia">Grombalia</option>
                            <option class="Nabeul" value="Hammamet">Hammamet</option>
                            <option class="Nabeul" value="El Haouaria">El Haouaria</option>
                            <option class="Nabeul" value="Kelibia Ouest">Kelibia Ouest</option>
                            <option class="Nabeul" value="Korba">Korba</option>
                            <option class="Nabeul" value="Menzel Bouzelfa">Menzel Bouzelfa</option>
                            <option class="Nabeul" value="Soliman">Soliman</option>
                            <option class="Nabeul" value="Nabeul">Nabeul</option>
                            <option class="Nabeul" value="Hammam Jebli">Hammam Jebli</option>
                            <option class="Nabeul" value="Menzel Temime">Menzel Temime</option>

                         

                          <option class="Sfax" value="Agareb">Agareb</option>
                          <option class="Sfax" value="Bir Ali Ben KHelifa">Bir Ali Ben KHelifa</option>
                          <option class="Sfax" value="El hancha">El hancha</option>
                          <option class="Sfax" value="Cekhira">Cekhira</option>
                          <option class="Sfax" value="Sfax B Diwan">Sfax B Diwan</option>
                          <option class="Sfax" value="Jebeniana">Jebeniana</option>
                          <option class="Sfax" value="Mellita Kerkenah">Mellita Kerkenah</option>
                          <option class="Sfax" value="Mahares">Mahares</option>
                          <option class="Sfax" value="Sfax P C">Sfax P C</option>
                          <option class="Sfax" value="Sfax Jadida">Sfax Jadida</option>
                          <option class="Sfax" value="Sfax ville">Sfax ville</option>

                        

                            <option class="SidiBouzid" value="Ben Aoun">Ben Aoun</option>
                            <option class="SidiBouzid" value="Bir El Haffey">Bir El Haffey</option>
                            <option class="SidiBouzid" value="Jilma">Jilma</option>
                            <option class="SidiBouzid" value="Menzel Bouzaiene">Menzel Bouzaiene</option>
                            <option class="SidiBouzid" value="Mezzouna">Mezzouna</option>
                            <option class="SidiBouzid" value="Regueb">Regueb</option>
                            <option class="SidiBouzid" value="Ouled Haffouz">Ouled Haffouz</option>
                            <option class="SidiBouzid" value="Sidi Bouzid">Sidi Bouzid</option>

                            <option class="Seliana" value="Bargou ">Bargou</option>
                            <option class="Seliana" value="Bouarada">Bouarada</option>
                            <option class="Seliana" value="Gaafour">Gaafour</option>
                            <option class="Seliana" value="Kesra">Kesra</option>
                            <option class="Seliana" value="Le krib">Le krib</option>
                            <option class="Seliana" value="Makthar">Makthar</option>
                            <option class="Seliana" value="Rouhia">Rouhia</option>
                            <option class="Seliana" value="Sidi Bou Rouis">Sidi Bou Rouis</option>
                            <option class="Seliana" value="Seliana">Seliana</option>

                            <option class="Sousse" value="Bouficha">Bouficha</option>
                            <option class="Sousse" value="El kalaa Kbira">El kalaa Kbira</option>
                            <option class="Sousse" value="El kalaa Esghira">El kalaa Esghira</option>
                            <option class="Sousse" value="Sidi Bou Ali">Sidi Bou Ali</option>
                            <option class="Sousse" value="Enfidha">Enfidha</option>
                            <option class="Sousse" value="Sousse Medina">Sousse Medina</option>
                            <option class="Sousse" value="MSaken">MSaken</option>
                            <option class="Sousse" value="Hammam Sousse medina">Hammam Sousse medina</option>
                            <option class="Sousse" value="Sousse Khezama">Sousse Khezama</option>
                            <option class="Sousse" value="Sousse ville">Sousse ville</option>

                       

                            <option class="Tataouine" value="Remada">Remada</option>
                            <option class="Tataouine" value="Ghomrassen">Ghomrassen</option>
                            <option class="Tataouine" value="Tataouine Medina">Tataouine Medina</option>

                         
                            <option class="Tunis" value="La Kasbah">La Kasbah</option>
                            <option class="Tunis" value="Bab Souika">Bab Souika</option>
                            <option class="Tunis" value="La Marsa">La Marsa</option>
                            <option class="Tunis" value="Tunis Chabbi">Tunis Chabbi</option>
                            <option class="Tunis" value="Bab Menara">Bab Menara</option>
                            <option class="Tunis" value="Le Kram">Le Kram</option>
                            <option class="Tunis" value="El Manar ( I,II,III)">El Manar ( I,II,III)</option>
                            <option class="Tunis" value="Les Berges du Lac">Les Berges du Lac</option>
                            <option class="Tunis" value="Carthage Yasmina">Carthage Yasmina</option>
                            <option class="Tunis" value="Cité Mhiri">Cité Mhiri</option>
                            <option class="Tunis" value="Tunis Belvedere">Tunis Belvedere</option>
                            <option class="Tunis" value="Tunis bab menara">Tunis bab menara</option>
                            <option class="Tunis" value="El Menzah 9">El Menzah 9</option>
                            <option class="Tunis" value="Cite Mahrajene">Cite Mahrajene</option>
                            <option class="Tunis" value="La Marsa">La Marsa</option>
                            <option class="Tunis" value="Cite El Khadhra">Cite El Khadhra</option>
                            <option class="Tunis" value="Tunis république">Tunis république</option>
                            <option class="Tunis" value="Tunis Halles">Tunis Halles</option>
                            <option class="Tunis" value="Tunis El Omrane">Tunis El Omrane</option>
                            <option class="Tunis" value="Tunis Carthage-Charguia I">Tunis Carthage-Charguia I</option>
                            <option class="Tunis" value="Bardo & Khaznadar">Bardo & Khaznadar</option>


                            <option class="Zaghouan" value="El Fahs">El Fahs</option>
                            <option class="Zaghouan" value="Nadhour">Nadhour</option>
                            <option class="Zaghouan" value="Zaghouan">Zaghouan</option>
		
		</select>
	</div>  
 

 	<div class="lab">
		<label for="etab" class="select" class="class_input" >établissement</label>
		</div>

	<div class="lab2">	
		<select name="etab" id="etab" class="class_input" >
			<option value="">-</option>
				<option value="1">Hôpital</option>
				<option value="2">Clinique</option>
				<option value="3">Cabinet</option>
		
		</select>
	</div>  
 
 
 	<div class="lab">
		<label for="name_etab" class="select">Nom de l'établissement</label>
			</div>

	<div class="lab2">
		<select name="name_etab" id="name_etab" class="class_input" >
			<option value="">-</option>

<?php



		$query = "SELECT * FROM `pm_etab` ";


//Fetch 3 rows from actor table
  $result = $dblink->query($query);

//Initialize array variable
  // $dbdata = array();
  
//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
	  // $dbdata = array_map('utf8_encode', $row);
?>
	<option value="<? echo $row["id"]; ?>"><? echo $row["name"]; ?></option>
<?
  }


 
?>
			
		</select>
	</div>  
 

 	<div class="lab">
		<label for="type" class="select">Type</label>
			</div>

	<div class="lab2">
		<select name="type" id="type" class="class_input" >
			<option value="">-</option>
                <option value="1">Pediatres</option>
                <option value="2">Sage Femmes</option>
		
		</select>
	</div>  
 

 	<div class="lab">
		<label for="fullname" class="class_input" >Nom et prénom</label>
			</div>

	<div class="lab2">
		<input name="fullname" id="fullname" type="text" class="class_input"  />
	</div>  
 
 	<div class="lab">
		<label for="adresse" class="textarea">Adresse</label>
			</div>

	<div class="lab2">
		<textarea name="adresse" id="adresse" class="class_input"  ></textarea>
	</div>  
 
 	<div class="lab">
		<label for="tel" class="input" >Téléphone</label>
			</div>

	<div class="lab2">
		<input name="tel" id="tel" type="text" class="class_input"  />
	</div>  
 
 	<div class="lab">
		<label for="email" class="input">Email</label>
			</div>

	<div class="lab2">
		<input name="email" id="email" type="text" class="class_input"  />
	</div>  
 
<div class="lab">
		<label for="remarque" class="textarea">Visibilité</label>
			</div>

	<div class="lab2">
		<textarea name="remarque" id="remarque" class="class_input"  ></textarea>
	</div>
	

	<div class="lab">
		<label for="remarque_1" class="textarea">Remarque prédefini</label>
	</div>

	<div class="lab2">
		<input type="hidden" name="remarque_1" id="remarque_1" value="" />
		<select id="remarque_10" class="class_input" multiple="multiple" size="10" style="height: 100%;">
			<option value="">-</option>
              <!--  <option value="Accord du pédiatre pour la diffusion dans les cabinets des dessins animés Delisso sur clé USB">Accord du pédiatre pour la diffusion dans les cabinets des dessins animés Delisso sur clé USB</option>
                <option value="Je conseille Delisso à partir de 6 mois">Je conseille Delisso à partir de 6 mois</option>
                <option value="Je conseille Delisso à partir d’un an">Je conseille Delisso à partir d’un an </option>
                <option value="Moins de sucre/Delisso est trop sucré">Moins de sucre/Delisso est trop sucré </option>
                <option value="Moins de matière grasse">Moins de matière grasse </option>
                <option value="Pas plus de deux pots Delisso par jour">Pas plus de deux pots Delisso par jour</option>
                <option value="Plus de visites durant l’année">Plus de visites durant l’année</option>
                <option value="Proposition Delisso à boire">Proposition Delisso à boire </option>
                <option value="Quel est le ferment lactique utilisé dans la composition Delisso? ">Quel est le ferment lactique utilisé dans la composition Delisso? </option>
                <option value="Quelle est la composition de Delisso ?">Quelle est la composition de Delisso ?</option>				
				<option value="Je recommande Delisso">Je recommande Delisso</option>
                <option value="Delisso sans sucre">Delisso sans sucre</option>
                <option value="Plus de parfums">Plus de parfums</option>
				<option value="Satisfait par le produit">Satisfait par le produit</option>
                <option value="Des cadeaux pour les enfants">Des cadeaux pour les enfants</option>
                <option value="Appréciation carnet de santé">Appréciation carnet de santé</option>
                <option value="Appréciation porte abaisse langue">Appréciation porte abaisse langue</option>
                <option value="Content de notre visite">Content de notre visite</option>		
                <option value="Toujours besoin de carnets de santé">Toujours besoin de carnets de santé</option>
				
				-->
                <option value="Je conseille Délisso à partir de 1 an">Je conseille Délisso à partir de 1 an</option>
                <option value="Je conseille Délisso à partir de 8 mois">Je conseille Délisso à partir de 8 mois</option>
                <option value="Plus de visites durant l’année.">Plus de visites durant l'année</option>
                <option value="Je conseille de ne pas le faire bouillir car il contient du fer">Je conseille de ne pas le faire bouillir car il contient du fer</option>
                <option value="Je recommande Délisso">Je recommande Délisso</option>
                <!--<option value="Satisfait par le produit">Satisfait par le produit</option>
                <option value="Satisfait par les tableaux">Satisfait par les tableaux</option>-->
                <option value="Appréciation du carnet de santé">Appréciation du carnet de santé</option>
                <option value="Content de notre visite">Content de notre visite</option>
                <option value="Toujours besoin de carnets de santé">Toujours besoin de carnets de santé</option>
				
				
				
		
		</select>
	</div>
	
 
  	<div class="lab">
		<label for="classe" >Class</label>
		
	</div>
	<div class="lab2">	
		<select name="classe" id="classe"  class="class_input">
			<option value="">-</option>
			<option value="A">A</option>
			<option value="A+">A+</option>
			<option value="B">B</option>
			<option value="C">C</option>
		
		</select>
	</div>  
	
  	<div class="lab">
		<label for="nvisite" >N° visite</label>
		
	</div>
	<div class="lab2">	
		<select name="nvisite" id="nvisite"  class="class_input">
			<option value="">-</option>
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option> 
		
		</select>
	</div>  
		
	
<div style="width:100%;float:left;">
	  
    <div class="lab">
        <label for="browse" class="form__label">Images</label>
	</div>
	
	<div class="lab2">	
		<input id="browse" type="file" accept="image/*" onchange="previewFiles()" >
		<div id="preview"></div>
      </div>	

</div>
	
	<div style="float:left;border-top:solid 1px;margin-top:20px;text-align:center;width:100%">
		<h3>Cadeaux</h3>
	</div>
	
<div style="width:100%;float:left;">
<!-- 
<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2024/gel.jpg" height="150px" />
    </div>
	<div class="giftss">	


		<select name="gift_1" id="gift_1">
	<?
	 // for ($i=0; $i <=200; $i++) 
{ ?>
    <option value="<? //echo $i ; ?>"><? //echo $i ; ?></option>
// <? }
	
	?> 
	    </select>
	</div>
</div>

-->

 




 <!--
<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2024/distrubuteur.jpg" height="150px" />
    </div>
	<div class="giftss">	

		<select name="gift_7" id="gift_7">
	<?
	 //for ($i=0; $i <=200; $i++) 
//{ ?>
    <option value="<? //echo $i ; ?>"><? //echo $i ; ?></option>
<? //}
	
	?> 
	    </select>
	</div>
</div>
-->






 
<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2024/mug.png" height="150px"  />
    </div>
	<div class="giftss">	

		<select name="gift_4" id="gift_4">
	<?
	 for ($i=0; $i <=20; $i++) 
{ ?>
    <option value="<? echo $i ; ?>"><? echo $i ; ?></option>
<? }
	
	?> 
	    </select>
	</div>
</div>

 
<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2024/carnet.jpg" height="150px"  />
    </div>
	<div class="giftss">	

		<select name="gift_2" id="gift_2">

	
	<?
		for ($i=0; $i <=100; $i+=10) 
{ ?>
    <option value="<? echo $i ; ?>"><? echo $i ; ?></option>
<? }
	
	?>	
	
	    </select>
	</div>
</div>




<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2025/gift_3.png" height="150px"  />
    </div>
	<div class="giftss">	

		<select name="gift_3" id="gift_3">

	
	<?
		for ($i=0; $i <=100; $i+=1) 
{ ?>
    <option value="<? echo $i ; ?>"><? echo $i ; ?></option>
<? }
	
	?>	
	
	    </select>
	</div>
</div>



<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2025/gift_5.png" height="150px"  />
    </div>
	<div class="giftss">	

		<select name="gift_5" id="gift_5">

	
	<?
		for ($i=0; $i <=100; $i+=1) 
{ ?>
    <option value="<? echo $i ; ?>"><? echo $i ; ?></option>
<? }
	
	?>	
	
	    </select>
	</div>
</div>

 <!--
<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2025/gift_6.png" height="150px"  />
    </div>
	<div class="giftss">	

		<select name="gift_6" id="gift_6">

	
	<?
		//for ($i=0; $i <=100; $i+=1) 
///{ ?>
    <option value="<? //echo $i ; ?>"><? //echo $i ; ?></option>
<? //}
	
	?>	
	
	    </select>
	</div>
</div>
-->



 
<div class="gift_glob">
 <div class="gift">
	
    <img src="css/2018/gift_6.png" height="150px"  />
    </div>
	<div class="giftss">	

		<select name="gift_8" id="gift_8">

	
	<?
		for ($i=0; $i <=10; $i+=1) 
{ ?>
    <option value="<? echo $i ; ?>"><? echo $i ; ?></option>
<? }
	
	?>	
	
	    </select>
	</div>
</div>







</div>

<!-- Un élément HTML pour recueillir l’affichage -->
<input type="hidden" id="gps" name="gps" value="" />






<div style="width:100%;float:left;">	  
	  

  <br>
  <br>
  <br>
        <button type="submit" class="class_input" data-icon="check" id="submit">Valider</button>
        <div id="feedback" class="form__feedback" aria-live="assertive" role="alert"></div>
    <br>
  <br>
  <br>  
  <br>  
  <br>  
  <br>  
  <br>  
  <br>  
</div>
    </div>
  </form>

 
</div>
  <script src='js/axios.min.js'></script>

  

    <script  src="js/index3.js"></script>



</div>
</body>

</html>


<script>
function maPosition(position) {
  var infopos = "";
  infopos += ""+position.coords.latitude;
  infopos += ","+position.coords.longitude;
  document.getElementById("gps").value = infopos;
}

if(navigator.geolocation)
  navigator.geolocation.getCurrentPosition(maPosition);
</script>

<script>
     function previewFiles() {

  var preview = document.querySelector('#preview');
  var files   = document.querySelector('input[type=file]').files;

  function readAndPreview(file) {
	  

    // Veillez à ce que `file.name` corresponde à nos critères d’extension
    if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
      var reader = new FileReader();
	  
	  var img = $( ".imago" ).length + 1;

	  
      reader.addEventListener("load", function () {
        var image = new Image();
        image.height = 50;
        image.width  = 50;
        image.name = file.name;
        image.title = "image_"+img;
        image.src = this.result;
        preview.appendChild( image );
		
		// creat input Image base 64 
		var input = document.createElement("input");
			input.setAttribute("type", "hidden");
			input.setAttribute("class", "imago");
			input.setAttribute("name", "image_"+img);
			input.setAttribute("value", this.result);
			preview.appendChild( input );
			// img++;
      }, false);

      reader.readAsDataURL(file);
    }

  }

  if (files) {
	  var img = 1;
    [].forEach.call(files, readAndPreview, img);
  }

}


function get_data(id_client){
	
	//========== vider les champs
					$("#region").val("");
					$("#municipalite").val("");
					$("#etab").val("");
					$("#name_etab").val("");
					$("#type").val("");
					$("#fullname").val("");
					$("#adresse").val("");
					$("#tel").val("");
					$("#email").val("");
	
		
			$.ajax({
			   url: "get_medecin.php",
				type: "GET",
				data: {
					id: id_client,
				},
				dataType: "JSON",
				success: function (jsonStr) { 
					var text = JSON.stringify(jsonStr) ;
					console.log(text);
					var obj = JSON.parse(text);
					var count = Object.keys(obj).length;
					
					//================
					$("#region").val(obj.region).trigger('change');
					$("#municipalite").val(obj.municipalite).trigger('change');
					$("#etab").val(obj.etab);
					$("#name_etab").val(obj.name_etab);
					$("#type").val(obj.type);
					$("#fullname").val(obj.fullname);
					$("#adresse").val(obj.adresse);
					$("#tel").val(obj.tel);
					$("#email").val(obj.email);

		

				}
			});
}	

//============================================================

$(document).ready(function(){
	$( "select[name='id_pediatre']" ).change(function() {
	var id_client = $(this).val();	
	  get_data(id_client);
	});
});
//============================================================

$(document).ready(function(){
	$( "select[name='region']" ).change(function() {
	var region = $(this).val();	
	if(region){
		var res = region.replace(" ", "");
	}else{
		var res = "";
	}
	if(res != ""){
		$("#municipalite option[class='all']").val("");
		$("#municipalite").val("");
		$("#municipalite option").hide();
		$("#municipalite option[class='" + res + "']").show();
	}else{
		$("#municipalite").val("");
		$("#municipalite option").show();
	}
	});
});
//==============================================================



$(document).ready(function() {
    $('#id_pediatre').select2();
    $('#region').select2();
    $('#name_etab').select2();
    // $('#municipalite').select2();
	
	

$( "#remarque_10" ).change(function() {
	var selected= "";
	var x = 0 ;
	 $('#remarque_10 :selected').each(function(){
		 // selected[x]=$(this).val();
		if(x>0){ 
			selected =  selected+","+$(this).val();
		}else{
			selected =  selected+$(this).val();
		}
		x++;
	});
	$("#remarque_1").val(selected);	
	console.log(selected);
});	
	
});


</script>


<style>
.separator{
	width: 100%;
	float: left;
}
.lab2 {
    width: 60%;
}
.select2-selection {
    height: 40px !important;
}
.lab {
	margin :0px !important;
}
</style>

