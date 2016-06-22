<?
session_start();
// Page de Club-Housse

// Initialisation
include "fonctions.php";

$prof_id = 0;
$prof_nom = "";
$prof_etoiles = 0 ;
$prof_latitude = 48 ;
$prof_longitude = 2 ;
$prof_descriptif = "";
$prof_adresse = "";
$page_titre = "";
$page_code = "";
$page_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
$site_url = "http://".$_SERVER['HTTP_HOST']."/v3/";	

// categorie
if (empty($_POST["categorie"]))
	{
	$rech_categorie = "" ; 
	}
else
	{
	$rech_categorie = $_POST["categorie"] ; 
	}
// ville
if (empty($_POST["ville"]))
	{
	$rech_ville = "" ; 
	}
else
	{
	$rech_ville = $_POST["ville"] ; 
	$rech_ville = mb_strtoupper($rech_ville);
	}
// prix
if (empty($_POST["prix"]))
	{
	$rech_prix = "" ; 
	$rech_prix_min = 0 ; 
	$rech_prix_max = 0 ; 
	}
else
	{
	$rech_prix = $_POST["prix"] ; 
	$rech_prix_tranche = explode(";", $rech_prix);
	$rech_prix_min = $rech_prix_tranche[0] ; 
	$rech_prix_max = $rech_prix_tranche[1] ; 
	}
// note
if (empty($_POST["note"]))
	{
	$rech_note = 0 ; 
	}
else
	{
	$rech_note = $_POST["note"] ; 
	}
// etoile
if (empty($_POST["etoile"]))
	{
	$rech_etoile = 0 ; 
	}
else
	{
	$rech_etoile = $_POST["etoile"] ; 
	}
// rayon
if (empty($_POST["rayon"]))
	{
	$rech_rayon = 10 ; 
	}
else
	{
	$rech_rayon = $_POST["rayon"] ; 
	}

//echo $page_code ;

include_once("connexion.php");


if (isset($_SESSION["id_user"]))
	{
	$user_id = $_SESSION["id_user"] ;
	}
else
	{
	$_SESSION["id_user"] = 0 ;
	$user_id = $_SESSION["id_user"] ;
	}

// Initalitation de la langue
if (empty($langue_code))
	{
	if (empty($_SESSION["langue_code"]))
		{
		include("scripts/langues.php");
		}
	else
		{
		$langue_code = $_SESSION["langue_code"] ; 
		}
	}

$ch_code = "" ;
$ch_valeur = "" ;
$RCH_TITRE_NAV = "" ;
$RCH_TITRE_CORP = "" ;
$RCH_GGLM_MARKER = "MS" ;
$sql = "SELECT sesi_code, sesi_valeur FROM setting_site WHERE sesi_code LIKE 'RCH_%' ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$ch_code = $row["sesi_code"] ;
	$ch_valeur = $row["sesi_valeur"] ;
	
	switch ($ch_code) {
		case "RCH_TITRE_NAV":
			$CH_TITRE_NAV = $ch_valeur ;
			break;
		case "RCH_TITRE_CORP":
			$RCH_TITRE_CORP = $ch_valeur ;
			break;
		case "RCH_GGLM_MARKER":
			// MS  : marker-simple
			// MSL : marker-simple-link
			// IWS : info-window-simple
			$RCH_GGLM_MARKER = $ch_valeur ;
			break;
		}
	}
	

$text_categorie = "";
$text_ville = "";
$text_rechercher = "";
$code_note = "" ;
$code_etoile = "" ;
$code_credit = "" ;
$page_titre = "" ;
$sql = "SELECT late_text FROM langues_texts WHERE late_code like 'CODE_CATEGORIE' AND late_lang_code like '$langue_code' LIMIT 1 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$text_categorie = $row["late_text"] ;
	}
$sql = "SELECT late_text FROM langues_texts WHERE late_code like 'CODE_VILLE' AND late_lang_code like '$langue_code' LIMIT 1 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$text_ville = $row["late_text"] ;
	}
$sql = "SELECT late_text FROM langues_texts WHERE late_code like 'CODE_RECHERCHE' AND late_lang_code like '$langue_code' LIMIT 1 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$text_rechercher = $row["late_text"] ;
	}
$sql = "SELECT late_text FROM langues_texts WHERE late_code like 'CODE_NOTE' AND late_lang_code like '$langue_code' LIMIT 1 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$code_note = $row["late_text"] ;
	}
$sql = "SELECT late_text FROM langues_texts WHERE late_code like 'CODE_ETOILE' AND late_lang_code like '$langue_code' LIMIT 1 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$code_etoile = $row["late_text"] ;
	}
$sql = "SELECT late_text FROM langues_texts WHERE late_code like 'CODE_CREDIT' AND late_lang_code like '$langue_code' LIMIT 1 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$code_credit = $row["late_text"] ;
	}
$sql = "SELECT late_text FROM langues_texts WHERE late_code like 'RCH_PAGE_TITRE' AND late_lang_code like '$langue_code' LIMIT 1 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$RCH_PAGE_TITRE = $row["late_text"] ;
	$page_titre = $RCH_PAGE_TITRE ; 
	}
// cle google fluis37@gmail.com : AIzaSyAkik3rzNPG4qkbDCbjCfEQIgLlvaFPUck

// Recherche de la ville
$n = 0 ; 
$sql = "SELECT zogv_id, zogv_nom, zogv_latitude, zogv_longitude FROM zone_geo_ville WHERE zogv_nom like '".$rech_ville."' LIMIT 3 ; "; 
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$zogv_id = $row["zogv_id"] ;
	$zogv_nom = $row["zogv_nom"] ;
	$zogv_latitude = $row["zogv_latitude"] ;
	$zogv_longitude = $row["zogv_longitude"] ;
	$n ++ ;
	}
if ($n == 0)
	{
	$sql = "SELECT zogv_id, zogv_nom, zogv_latitude, zogv_longitude FROM zone_geo_ville WHERE zogv_nom like '".$rech_ville."%' LIMIT 3 ; "; 
	$result = mysqli_query($conn, $sql);
	while($row = $result->fetch_assoc()) {
		$zogv_id = $row["zogv_id"] ;
		$zogv_nom = $row["zogv_nom"] ;
		$zogv_latitude = $row["zogv_latitude"] ;
		$zogv_longitude = $row["zogv_longitude"] ;
		$n ++ ;
		}	
	}
if ($n == 0)
	{
	$zogv_id = 0 ;
	$zogv_nom = "" ;
	$zogv_latitude = 0 ;
	$zogv_longitude = 0 ;
	}
if ($n > 1)
	{
	$zogv_id = 0 ;
	$zogv_nom = "" ;
	$zogv_latitude = 0 ;
	$zogv_longitude = 0 ;
	}
if ($n == 1)
	{
	$rech_ville = $zogv_nom ;
	}

?>
<!DOCTYPE HTML>
<html>

<head>
    <title><? echo $page_titre ; ?></title>
    <meta charset="utf-8">
    <meta name="description" content="description">
	
	<link rel="stylesheet" href="./stylesheets/jslider.css" type="text/css">
	<link rel="stylesheet" href="./stylesheets/jslider.blue.css" type="text/css">
	<link rel="stylesheet" href="./stylesheets/jslider.plastic.css" type="text/css">
	<link rel="stylesheet" href="./stylesheets/jslider.round.css" type="text/css">
	<link rel="stylesheet" href="./stylesheets/jslider.round.plastic.css" type="text/css">
	<!--[if IE 6]>
    <link rel="stylesheet" href="./stylesheets/jslider.ie6.css" type="text/css" media="screen">
    <link rel="stylesheet" href="./stylesheets/jslider.blue.ie6.css" type="text/css" media="screen">
    <link rel="stylesheet" href="./stylesheets/jslider.plastic.ie6.css" type="text/css" media="screen">
    <link rel="stylesheet" href="./stylesheets/jslider.round.ie6.css" type="text/css" media="screen">
    <link rel="stylesheet" href="./stylesheets/jslider.round.plastic.ie6.css" type="text/css" media="screen">
	<![endif]-->

	<script type="text/javascript" src="./javascripts/jquery-1.4.2.js"></script>
	<script type="text/javascript" src="./javascripts/jquery.dependClass.js"></script>
	<script type="text/javascript" src="./javascripts/jquery.slider-min.js"></script>


    <style type="text/css">
		body {
			color: #000000;
			background-color: #f5f5f5 ;
			}
		nav {
			color: #000000;
			background-color: #00FF00 ;
			margin-left: auto;
			margin-right: auto;
			padingin:0px 0px 0px 0px ;
			height : 60px ; 
			width : 1010px ;
			}
		#band-droite {
			color: #000000;
			background-color: #EFFBF2 ;
			margin-left: auto;
			margin-right: auto;
			width : 200px ;
			}
		#band-gauche {
			color: #000000;
			background-color: #EFFBF2 ;
			margin-left: auto;
			margin-right: auto;
			min-height : 500px ;
			width : 200px ;
			}
		#band-milieu {
			color: #000000;
			background-color: #EFFBF2 ;
			margin-left: auto;
			margin-right: auto;
			min-height : 500px ;
			width : 600px ;
			}
		#main {
			color: #000000;
			background-color: #EFFBF2 ;
			margin-left: auto;
			margin-right: auto;
			min-height : 500px ;
			width : 1015px ;
			}
		article {
			color: #000000;
			background-color: #EFFBF2 ;
			margin-left: auto;
			margin-right: auto;
			min-height : 500px ; 
			width : 1015px ;
			}
		footer {
			color: #000000;
			background-color: #6E6E6E ;
			margin-left: auto;
			margin-right: auto;
			height : 80px ; 
			width : 1015px ;
			}
		h1 {
			color: #000000 ;
			margin: 2px ; /* H D B G */
			padingin: 2px;
			font-size: 14px;
			font-family: "Tahoma", Arial, sans-serif;
			text-align: left;
			}
		h2 {
			color: #000000 ;
			margin: 2px ; /* H D B G */
			padingin:2px;
			font-size: 12px;
			font-family: "Tahoma", Arial, sans-serif;
			text-align: left;
			}
		.centrer
			{
			display:block;
			width:auto;
			margin-left:auto;
			margin-right:auto;

			}
		#map { 
			height: 400px; 
			width : 600px ;
			margin: 0; 
			padding: 0; 
			}
		#zone-gris {
			background-color: #E6E6E6 ;
			border:1px solid #A4A4A4 ;
			margin: 10px 0px 0px 0px ; /* H D B G */
			padding : 8px 3px 8px 3px ; /* H D B G */
			border-radius: 10px;
		}
		#zone-annonce-ex {
			height: 250px ; 
			background-color: #E6E6E6 ;
			border:1px solid #A4A4A4 ;
			margin: 10px 0px 0px 0px ; /* H D B G */
			padding : 8px 3px 8px 3px ; /* H D B G */
			border-radius: 10px;
		}
		#zone-annonce-in {
			height: 200px ; 
			background-color: #F7F8E0 ;
			border:1px solid #393B0B ;
			margin: 10px 0px 0px 0px ; /* H D B G */
			padding : 8px 3px 8px 3px ; /* H D B G */
			border-radius: 10px;
		}
		#zone-contenu-droite {
			background-color: #E6F8E0 ;
			border:1px solid #298A08 ;
			margin: 0px 0px 5px 0px ; /* H D B G */
			padding : 5px 3px 5px 3px ; /* H D B G */
			border-radius: 10px;
			width : 515px ;
			min-height : 90px ;
		}
		SELECT.recherche {
			width: 190px;
		}
		INPUT.recherche {
			width: 190px;
		}
		INPUT.rrecherche {
			width: 192px;
		}

    </style> 
</head>

<body>
    <div id="page">
    <nav><!-- Nav. principale de la page -> site -->
	<table>
		<tr>
			<td><img src="img/logo_t030.png" alt="<? echo $page_titre ; ?>" >
			</td>
			<td>&nbsp; &nbsp; &nbsp; </br> &nbsp; </td>
			<td>
			<? 
			if ($CH_TITRE_NAV == "O") 
				{
				echo "<h1>" . $prof_nom . "</h1><h2>" . $prof_adresse . "</h2>" ;  
				}
			?>
			</td>
			<td>&nbsp; &nbsp; &nbsp; </br> &nbsp; </td>
			<td>
			<?
			if ($user_id > 0)
				{
				echo "&nbsp; &nbsp; <a href='index.php'><img src='img/f_home.png' ></a>";
				echo "&nbsp; &nbsp; <img src='img/f_liste.png' >";
				echo "&nbsp; &nbsp; <a href='config.php'><img src='img/f_config.png' ></a>";
				echo "&nbsp; &nbsp; <a href='logout.php'><img src='img/f_deconnect.png' ></a>";
				}
			else
				{
				echo "&nbsp; &nbsp; <a href='index.php'><img src='img/f_home.png' ></a>";
				echo "&nbsp; &nbsp; <a href='login.php'><img src='img/f_connect.png' ></a>";
				}
			?>
			</td>
		</tr>
	</table>
	</nav>   
	<article><!-- Contenu textuel de la page -->
	<div id="main">
	<table><tr>
 	<td valign="top"> <!-- Bande gauche -->
		<!-- IWS -->
		<div id="band-gauche">
		
		
		<div id="zone-gris">
			<? echo $text_categorie ; ?> </br>
			<select class="recherche" name="categorie" > 
			<?
			$text_categorie = "";
			$sql = "SELECT cate_id, cate_defaut, cate_ord, cate_nom FROM categorie WHERE cate_actif > 0 ORDER BY cate_ord, cate_nom "; 
				$result = mysqli_query($conn, $sql);
				while($row = $result->fetch_assoc()) {
					$i = $row["cate_defaut"] ;
					if ($i > 0)
						{
						echo "<option value='".$row["cate_id"]."' selected>".affiche_chaine_html(0,$row["cate_nom"])."</option> " ;
						}
					else
						{
						echo "<option value='".$row["cate_id"]."' >".affiche_chaine_html(0,$row["cate_nom"])."</option> " ;
						}
					}
			?>
			</select>  </br>
			<? echo $text_ville ; ?> </br>
			<input class="recherche" type="text" name="texte" value="<? echo $rech_ville ; ?>"/></br>
			<input class="rrecherche" type="submit" value="<? echo $text_rechercher ; ?>" />
		</div>

		<div id="zone-annonce-ex">	
			&nbsp; </br> &nbsp; </br>
		</div>	
		<div id="zone-annonce-ex">	
			&nbsp; </br> &nbsp; </br>
		</div>	
		
	</div></td>
    <td valign="top"><div id="band-milieu"><!-- Contenu textuel de la page -->
		<table>
		<tr >
			<td width=400px valign="top">
			<?
			if ($CH_TITRE_CORP == "O") 
				{
				echo "<h1>" . $prof_nom . "</h1><h2>" . $prof_adresse . "</h2>" ; 
				}
			?>
			</td>
			<td ROWSPAN=2 valign="top">
			<?
				if ($CH_STAR_CORP == "O")  
					{
					echo affiche_jauge_star($prof_etoiles,$code_etoile) ;  
					echo "&nbsp; " . $prof_etoiles . " / 5" ;  
					echo "</br>" ;  
					}
				if ($CH_COEUR_CORP == "O")  
					{
					echo affiche_jauge_coeur($prof_etoiles,$code_note) ;  
					echo "&nbsp; " . $prof_etoiles . " / 5" ;  
					echo "</br>" ;  
					}
				if ($CH_CREDIT_CORP == "O")  
					{
					echo affiche_jauge($prof_etoiles,$code_credit) ;  
					echo "&nbsp; " . $prof_etoiles . " / 10" ;  
					echo "</br>" ;  
					}
				echo $prof_descriptif ; 
				echo "</br>" ; 
			?>
			</td>
		</tr>
		<tr>
			<td>
			<a href="<? echo str_replace(".html","_img.html",$page_url); ?>" onclick="javascript:void window.open('<? echo str_replace(".html","_img.html",$page_url); ?>','1440063912578','width=1000,height=750,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">
			<?
			$sql = "SELECT prim_id, prim_ext, prim_nom FROM prof_images WHERE prim_prof_id = '$prof_id' AND prim_defaut > 0 LIMIT 1 ; "; 
			$result = mysqli_query($conn, $sql);
			while($row = $result->fetch_assoc()) {
				echo "<img class='centrer' src='upload/ch/".$prof_id."/".$row["prim_id"]."_400.".$row["prim_ext"]."' alt='".$row["prim_nom"]."' >" ; 
				}
			?>
			</a>
			
			</td>
		</tr>
		</table>
		<!-- Bande central - Annonces interne -->
		<!--- Carte --->
		
		<?
		switch ($rech_rayon) {
			case 1:
				$zoom = 12 ;
				break;
			case 5:
				$zoom = 12 ;
				break;
			case 10:
				$zoom = 12 ;
				break;
			case 25:
				$zoom = 9 ;
				break;
			case 80:
				$zoom = 8 ;
				break;
			case 120:
				$zoom = 8 ;
				break;
			case 200:
				$zoom = 7 ;
				break;
			case 300:
				$zoom = 7 ;
				break;
			}
		
		$delta = $rech_rayon * 0.008 ; 
		$delta = $delta + 0.01 ;
		$latitude_min = $zogv_latitude - $delta; 
		$latitude_max = $zogv_latitude + $delta; 
		$longitude_min = $zogv_longitude - $delta; 
		$longitude_max = $zogv_longitude + $delta; 

		?>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
			var markers = [
			<?
				$sql = "SELECT prof_id, prof_code, prof_etoiles, prof_nom, prof_descriptif, prof_latitude, prof_longitude FROM professionnel WHERE prof_actif > 0"; 
				$sql = $sql . " AND prof_latitude >= ".$latitude_min ; 
				$sql = $sql . " AND prof_latitude <= ".$latitude_max ; 
				$sql = $sql . " AND prof_longitude >= ".$longitude_min ; 
				$sql = $sql . " AND prof_longitude <= ".$longitude_max ; 
				$sql = $sql . " ; " ; 
				$i = 0 ;
				//echo $sql ."</br>" ; 
				$result = mysqli_query($conn, $sql);
				while($row = $result->fetch_assoc()) {
					$prof_id = $row["prof_id"] ;
					$prof_code = $row["prof_code"] ;
					$prof_etoiles = $row["prof_etoiles"] ;
					$prof_nom = affiche_chaine_html(0,$row["prof_nom"]) ;
					$prof_descriptif = affiche_chaine_html(0,$row["prof_descriptif"]) ;
					$prof_latitude = $row["prof_latitude"] ;
					$prof_longitude = $row["prof_longitude"] ;
					
					$i ++ ;
					if ($i > 1)
						{
						echo "			}, \r\n" ;
						}
						
					echo "			{ \r\n" ;
					echo "				'title': '".$prof_nom."', \r\n" ;
					echo "				'lat': '".$prof_latitude."', \r\n" ;
					echo "				'lng': '".$prof_longitude."', \r\n" ;
					echo "				'description': '<h1><a target=_blank href=".$site_url."page_".$prof_code."_club-house.html >".$prof_nom."</a></h1>".$prof_descriptif."</br>' \r\n" ;
					//echo "				'description': ""<h1><a href='".$site_url."page_".$prof_code."_club-house.html' >".$prof_nom."</a></h1>".$prof_descriptif."</br>"" \r\n" ;
					}
				if ($i > 0)
					{
					echo "			} \r\n" ;
					}
			?>
			];
			window.onload = function () {
				LoadMap();
			}
			function LoadMap() {
				var mapOptions = {
					center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
					zoom: <? echo $zoom ; ?>,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById("map"), mapOptions);

				//Create and open InfoWindow.
				var infoWindow = new google.maps.InfoWindow();

				for (var i = 0; i < markers.length; i++) {
					var data = markers[i];
					var myLatlng = new google.maps.LatLng(data.lat, data.lng);
					var marker = new google.maps.Marker({
						position: myLatlng,
						map: map,
						title: data.title
					});

					//Attach click event to the marker.
					(function (marker, data) {
						google.maps.event.addListener(marker, "click", function (e) {
							//Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
							infoWindow.setContent("<div style = 'width:200px;min-height:40px'>" + data.description + "</div>");
							infoWindow.open(map, marker);
						});
					})(marker, data);
				}
			}
		</script>
		<div id="map" >
		</div>


		<table>
		<tr>
			<td width=200px ><div id="zone-annonce-in">	
			&nbsp; </br> &nbsp; </br>
			</div></td>		
			<td width=200px ><div id="zone-annonce-in">		
			&nbsp; </br> &nbsp; </br>
			</div></td>		
			<td width=200px ><div id="zone-annonce-in">		
			&nbsp; </br> &nbsp; </br>
			</div></td>		
		</tr>
		</table>
		<!-- Bande central - Mur -->

	</div></td>
	<td valign="top"> <!-- Bande droite -->
		

	<div id="band-droite"></div>
		
		<div id="zone-annonce-ex">	
			&nbsp; </br> &nbsp; </br>
		</div>	
		
		<div id="zone-annonce-ex">	
			&nbsp; </br> &nbsp; </br>
		</div>	
		
		
	</td>
	</tr></table>
	</article>
	</div>
    <footer><!-- Pied-de-page de la page -> site -->
	cc
	</footer>
    </div>
</body>
</html>

<?

include_once("deconnexion.php");
?>