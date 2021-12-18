<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/vente.php');
require_once('../classes/produit.php');
require_once('../classes/encaissement.php');
require_once('../classes/Constante.php');
$vte = new vente();
$prod = new produit();
$enc = new encaissement();

$IdVente=""; $client=""; $codePr=""; $date="";

if(isset($_GET['numcli'] )){
$NumVte=$_GET['vente'];
$numcl=$_GET['numcli']; 
$total=(int)$vte->showTotalVteCouranteCli($_SESSION['id'],$numcl);
$solde=$enc->showSoldeClient($numcl);
}else{
	$numcl="";$NumVte="";
}

if(isset($_POST['send'])){
	$montant=$_POST['montant'];
	$client=$_POST['cli'];
	$tot=$_POST['tot'];
	$NumVte=$_POST['vent'];
	if($_SESSION['niveau']=='Admin'){
		$avis = $_POST['avis'];
	}
	$reste=$tot-$montant;
	$solde=$vte->showSoldeBisVente($client)-$montant;
	$IdVente=$vte->showLastIdvte($NumVte);
	$date=$vte->nowDate();
	$nbjour = Constante::NOMBRE_JOUR_ECHEANCE;
	$echeance=date('Y-m-d', strtotime($date.' +'.$nbjour.'days'));
	
	if($montant >= $tot || $avis == 'Oui'){
		$vte->setMontPayer($montant);
	    $vte->updateVtePaiement($solde,$montant,$IdVente);
	    $vte->updateEtatVte($NumVte);
	    $enc->updateSoldeCliVte($client,$reste,$echeance);
	    header('location:RecuEncourClient.php');
	}else{
		echo "<script type='text/javascript'>alert('Impossible de terminer la vente. Le montant payé est inférieur au total achat. Merci' ); location.href = 'PayerSomme.php?vente=$NumVte&numcli=$client'</script>";
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
		<div class="span4">
		 <h1 style="color: yellow;">Solde client : <?php echo strrev(wordwrap(strrev((int)$solde), 3, ' ', true));?> </h1>
		</div>
		<div class="span5">
			<h1 style="color: white;">Payer le montant des achats</h1>
		</div>
		<div class="span3">
			<h1 style="color: white;">Total : <?php echo strrev(wordwrap(strrev($total), 3, ' ', true));?> </h1>
		</div>
	   </div>	
      <hr>
	  </div>
    </div>
    <div class="row-fluid">
    	<div class="span3"></div>
    	<div class="span6">
    		<h1 style="color: red; background-color: pink; text-align: center;"><strong>Montant total à payer : <?php echo strrev(wordwrap(strrev((int)$solde+(int)$total), 3, ' ', true));?></strong> </h1>
    	</div>
    	<div class="span3"></div>
    </div>
   
	 <div class="row-fluid sortable">
	 	<div class="span2"></div>
		<div class="box span8">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Formulaires de vente</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="PayerSomme.php" style="background-color: #B0E0E6">
				  <fieldset>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="tot"  required="true" value="<?php echo $total;?>">
						  <input type="hidden" name="vent"  required="true" value="<?php echo $NumVte;?>">
						</div>
				    </div>
				    <?php if($_SESSION['niveau']=='Admin'){ ?>
				    <div class="control-group">
					<label class="control-label">Avis</label>
					<div class="controls">
					  <label class="radio">
						<input type="radio" name="avis" id="avis1" value="Oui">Oui
					  </label>
					  <div style="clear:both"></div>
					  <label class="radio">
						<input type="radio" name="avis" id="avis2" value="Non" checked="">
						Non
					  </label>
					</div>
				  </div>
				  <?php } ?>
				    <div class="control-group info">
					    <label class="control-label">Montant payé</label>
					       <div class="controls">
					        <input type="number" required="true" name="montant">
					       </div>
				    </div>
				
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="cli" required="true" value="<?php echo $numcl;?>">
						</div>
				    </div>
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
					  <button type="reset" name="annuler" class="btn btn-default">Annuler</button>
					</div>
					</fieldset>
					</form>   
					</div>
				</div>
				<div class="span2"></div>
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