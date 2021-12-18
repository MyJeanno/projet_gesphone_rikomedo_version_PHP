
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/encaissement.php');
require_once('../classes/vente.php');
require_once('../classes/client.php');
$cli = new client();
$enc = new encaissement();
$vte = new vente();

if(isset($_POST['send'])){
	$montant=$_POST['mont'];
	$client=$_POST['cli'];
	$date=$enc->nowDate();
	$heure=$enc->nowHour();
	$user=$_SESSION['id'];



	$solde=$enc->showSoldeClient($client)-$montant;
	
    $enc->setNumClient($client);
    $enc->setIdUser($user);
    $enc->setMontEncaisser($montant);
    $enc->setDateEncaisser($date);
    $enc->setHeureEncaisser($heure);
    $enc->setSoldeEncaisse($solde);
    $enc->setEtatEncaisse("NON VERSE");
    if($montant < $enc->showSoldeClient($client)){
    $test=$enc->Ajouter2();
    $enc->updateSoldeCli($client,$montant);
    header('location:ListEncaissement.php');
	}else{
		header('location:Error.php');
	}
}


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
<?php include('../Layout/Layout.php');?>
	<div class="jumbotron" style="background-color: #191970"> 	
	  <div class="container">
	   <hr>
	    <div class="row-fluid">
		<div class="span3"></div>
		<div class="span9">
			<h1 style="color: white;">Sélectionner un client pour l'encaissement</h1>
		</div>
	   </div>	
      <hr>
	  </div>
    </div>
    <br>

    <div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon user"></i><span class="break"></span>Sélectionner un encaissement</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped table-condensed bootstrap-datatable datatable">
			  <thead>
				  <tr style="background-color: cadetblue">
					  <th>N°</th>
					  <th>Nom & prenom du client</th>
					  <th>Contact</th>
					  <th>Reste à payer</th>
					  <th>Sélectionner</th>				  
				  </tr>
			  </thead>   
			  <tbody>
				<?php 
		          $list=$cli->ListerTout2();
		          foreach ($list as $value){?> 
		    	<tr>
		    	    <td><?php echo $value['NUM_CLI'];?></td>
		    		<td> <?php echo $value['NOM_CLI']." ".$value['PRENOM_CLI'];?></td>
		    		<td> <?php echo $value['CONTACT_CLI'];?></td>
		    		<td> <?php echo strrev(wordwrap(strrev($value['SOLDE_CLIENT']), 3, ' ', true));?></td> 
		    		<td> 
					 <a class="btn btn-info" href="FormEncaisser.php?id=<?php echo $value['NUM_CLI'];?>">Encaisser <i class="icon-plus icon-white"></i></a>
		    		</td>   		
		    	</tr>
		        <?php } ?>
			  </tbody>
			  </table>            
			</div>
		</div>	
	</div>
	

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