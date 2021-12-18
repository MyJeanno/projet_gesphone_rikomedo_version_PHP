<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/operation.php');
$opera = new operation();

$id=""; $lib=""; $i="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$opera->getOne2($id);
	$act=$row['ID_ACTION'];
	$date=$row['DATE_OPE'];
	$type=$row['TYPE_OPE'];
	$mont=$row['MONTANT_OPE'];
	$nom=$opera->showNomActionnaire($act);
    $prenom=$opera->showPrenomActionnaire($act);
}


if(isset($_POST['code'])){
	$code = $_POST['code'];
	$sender = $_POST['action'];
	$date = $_POST['date'];
	$date1 = new DateTime($date);
	$date2 = $date1->format('Y-m-d');
	$type = $_POST['type'];
	$montant = $_POST['montant'];

	$lastMontant=$opera->showLastOpera($code);
	$diffMont=$montant-$lastMontant;

	$opera->setIdOperation($code);
	$opera->setIdAction($sender);
	$opera->setDateOperation($date2);
	$opera->setTypeOperation($type);
	$opera->setMontantOperation($montant);
	$test=$opera->updateOperation();
	$opera->updateSoldeActionnaire($diffMont,$sender);
    header('location:ListeOperation1.php');
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
	    <div class="row-fluid sortable">
		<div class="span3"></div>
		<div class="span7">
			<h1 style="color: white;">Mise à jour des dépôts d'actions</h1>
		</div>
		<div class="span2">
        </div>
	   </div>	
      <hr>
	  </div>
   </div><br>

	 <div class="row-fluid sortable">
	 	<div class="span2"></div>
		<div class="box span8">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Mise à jour dépôts</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="EditerOperation1.php" style="background-color: #B0E0E6">
				  <fieldset>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" value="<?php echo $id;?>">
						</div>
				    </div>	
				    <div class="control-group info">
					   <label class="control-label">Type d'opération</label>
						<div class="controls">
						  <input type="text" readonly="true" required="true" name="type" value="<?php echo $type; ?>" >
						</div>
				    </div>	
				    <div class="control-group info">
					   <label class="control-label">Nom & prénoms</label>
						<div class="controls">
						  <input type="text" readonly="true" required="true" value="<?php echo $nom.' '.$prenom ;?>" >
						</div>
				    </div>			    
				    <div class="control-group info">
					  <label class="control-label" for="date01">Date</label>
					   <div class="controls">
						<input type="text" name="date" class=" datepicker" value="<?php echo $date; ?>" id="date01" required="true">
					  </div>
					</div> 
					<div class="control-group info">
						<label class="control-label">Montant</label>
						<div class="controls">
						  <input type="number" required="true" name="montant" value="<?php echo $mont; ?>">
						</div>
					</div>
					 <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="action" value="<?php echo $act;?>">
						</div>
				    </div>	
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Modifier</button>
					  <a class="btn btn-info" href="ListeOperation1.php">Retour à la liste</a>
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