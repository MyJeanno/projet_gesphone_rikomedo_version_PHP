
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
} 
require_once('../classes/vente.php');
require_once('../classes/encaissement.php');
$enc = new encaissement();
$vte = new vente();

$TotJour=$enc->showTotalEncaissementJour();
$totalGros=$vte->showTotalVteGrosJour();
$totalDetail=$vte->showTotalVteDetailJour();
$gene = (int)$TotJour+(int)$totalGros+(int)$totalDetail;

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
	<!-- start: Header -->
  <?php include('../Layout/Layout.php');?>
    <div class="jumbotron" style="background-color: #191970">
	  <div class="container">
	   <hr>
	    <div class="row-fluid sortable">
		<div class="span3"></div>
		<div class="span7">
			<h1 style="color: white;">Situation globale de la journée du <?php echo date("d-m-Y"); ?></h1>
		</div>
		<div class="span2"></div>
	   </div>	
      <hr>
	  </div>
    </div><br><br>
    <table class="table table-striped table-condensed table-bordered">	
    	<tr>
    		<td style="background-color: #00FFFF;"><strong>Total encaissement</strong></td>
    		<td style="background-color: #00FFFF;"><strong> Total vente en gros</strong></td>
    		<td style="background-color: #00FFFF;"><strong>Total vente en détail</strong></td>
    		<td style="background-color: #00FFFF;"><strong>Total de la journée</strong></td>
    	</tr>
    	<tr>
    		<td><strong><?php echo strrev(wordwrap(strrev((int)$TotJour), 3, ' ', true)); ?></strong></td>
    		<td><strong><?php echo strrev(wordwrap(strrev((int)$totalGros), 3, ' ', true)); ?></strong></td>
    		<td><strong><?php echo strrev(wordwrap(strrev((int)$totalDetail), 3, ' ', true)); ?></strong></td>
    		<td><strong><?php echo strrev(wordwrap(strrev((int)$gene), 3, ' ', true)); ?></strong></td>
    	</tr>
    </table>

   	

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