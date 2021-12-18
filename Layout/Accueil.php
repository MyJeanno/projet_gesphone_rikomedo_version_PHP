
<?php 
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}

require_once('../classes/vente.php');
require_once('../classes/presence.php');
$vte = new vente();
$pres = new presence();

/*$totalVendu=$vte->quantiteTotalVendu();
$totalAppro=$vte->quantiteTotalApprovisionner();
$pourcent = 100-number_format(($totalVendu/$totalAppro)*100);*/

/*$etat=$pres->showEtatPresence($_SESSION['id']);

if(isset($_POST['arrive'])){
	$user=$_SESSION['id'];
	$date=$pres->nowDate();
	$arrivee=$pres->nowHour();
	
	$pres->setIdUser($user);
    $pres->setDatePresence($date);
	$pres->setHeureArrivee($arrivee);
    $pres->setFlag("yes");
    if($etat!="yes"){$pres->Ajouter();}else{} 
    header('location:ListerPresence.php'); 
}else if(isset($_POST['depart'])){
	$user=$_SESSION['id'];
	$date=$pres->nowDate();
	$depart=$pres->nowHour();

	$pres->setIdUser($user);
    $pres->setDatePresence($date);
	$pres->setHeureDepart($depart);
    $pres->updatePresence();
    header('location:ListerPresence.php');
}*/


 ?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>RIKOMEDO</title>
	<meta name="description" content="Bootstrap Metro Dashboard">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link id="bootstrap-style" href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="../css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="../css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>	
	<link rel="shortcut icon" href="../img/favicon.ico">
<html>
</head>

<body>
<?php include('Layout.php');?>
	<!-- start: Header -->
	<div class="row-fluid">
		<div class="span12">
			<form method="POST" action="accueil.php">
				<button type="submit" name="arrive" class="btn btn-info btn-lg pull-left" ><h2>Signaler son arrivée</h2></button>
                <button type="submit" name="depart" class="btn btn-success btn-lg pull-right"><h2>Signaler son départ</h2></button>
			</form>
		</div>		
	</div>
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" style="background-color: #191970;" data-original-title>
			    <h2 style="color: white;">Menu principal</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content" style="background-color:yellow; "><br><br><br><br>
			     <div class="row-fluid">
			     	<a class="span1"></a>
			     	<a href="../Produit/ListeProduit.php" class="quick-button metro blue span2">
						<img width="100" height="100" src="../images/produit.jpg">
						<p><h2 style="color: white;">Produits</h2></p>
					</a>
					<a href="../Appro/Approvisionner.php" class="quick-button metro blue span2">
						<img width="100" height="100" src="../images/depense.jpg">
						<p><h2 style="color: white;">Approvisionnement</h2></p>
					</a>
					<a href="../Vente/VendreProduit.php" class="quick-button metro blue span2">
						<img width="100" height="100" src="../images/portable.JPG">
						<p><h2 style="color: white;">Effectuer une vente</h2></p>
					</a>
			     	<a href="../Client/ListeClient.php" class="quick-button metro blue span2">
						<img width="100" height="100" src="../images/client.jpg">
						<p><h2 style="color: white;">Clients</h2></p>
					</a>	
					<a href="../Encaissement/Encaisse.php" class="quick-button metro blue span2">
						<img width="100" height="100" src="../images/fond.jpg">
						<p><h2 style="color: white;">Encaissement</h2></p>
					</a>
					<a class="span1"></a>								
			</div><br><br><!--/row--> 
			<!--<div class="row-fluid">
				<div class="span1"></div>
				<div class="span10">
					<div><h2>Pourcentage de produits restant dans le stock : <?php //echo $pourcent."%"; ?></h2></div>
					 <div class="progress progress-striped active">
			            <div  class="bar bar-success" style="width: <?php //echo $pourcent."%"; ?>;"></div>
			        </div>
		        </div>
		        <div class="span1"></div>
			</div>-->
			<br><br>  
		 </div>
	 </div><!--/span-->
	</div><!--/row-->

		<p>
		<span style="text-align:left;float:left">&copy; Ora-Tech technologie<a href="#"> Copyright 2017. Tous droits réservés.</a></span>	
		</p>

		<script src="../js/jquery-1.9.1.min.js"></script>

	    <script src="../js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="../js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="../js/jquery.ui.touch-punch.js"></script>
	
		<script src="../js/modernizr.js"></script>
	
		<script src="../js/bootstrap.min.js"></script>
	
		<script src="../js/jquery.cookie.js"></script>
	
		<script src='../js/fullcalendar.min.js'></script>
	
		<script src='../js/jquery.dataTables.min.js'></script>

		<script src="../js/excanvas.js"></script>

		<script src="../js/jquery.flot.js"></script>

		<script src="../js/jquery.flot.pie.js"></script>

		<script src="../js/jquery.flot.stack.js"></script>

		<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="../js/jquery.chosen.min.js"></script>
	
		<script src="../js/jquery.uniform.min.js"></script>
		
		<script src="../js/jquery.cleditor.min.js"></script>
	
		<script src="../js/jquery.noty.js"></script>
	
		<script src="../js/jquery.elfinder.min.js"></script>
	
		<script src="../js/jquery.raty.min.js"></script>
	
		<script src="../js/jquery.iphone.toggle.js"></script>
	
		<script src="../js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="../js/jquery.gritter.min.js"></script>
	
		<script src="../js/jquery.imagesloaded.js"></script>
	
		<script src="../js/jquery.masonry.min.js"></script>
	
		<script src="../js/jquery.knob.modified.js"></script>
	
		<script src="../js/jquery.sparkline.min.js"></script>
	
		<script src="../js/counter.js"></script>
	
		<script src="../js/retina.js"></script>

		<script src="../js/custom.js"></script>
	<!-- end: JavaScript-->
</body>
</html>