
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/client.php');
$cli = new client();

$nom=""; $contact=""; $i=""; $solde=""; $code="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$cli->getOne($id);
	$i=$row['NUM_CLI'];
	$nom=$row['NOM_CLI'];
	$prenom=$row['PRENOM_CLI'];
	$type=$row['TYPE_CLI'];
	$contact=$row['CONTACT_CLI'];
	$solde=$row['SOLDE_CLIENT'];
}


if(isset($_POST['code'])){
	$code=$_POST['code'];
    $cli->activerClient($code);
    header('location:ActiverClient.php');
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
	<!-- start: Header -->
	<hr>
	<div class="row-fluid sortable">
		<div class="span4"></div>
		<div class="span8">
			<h1>Activer un client</h1>
		</div>
	</div>	
   <hr>

	 <div class="row-fluid sortable">
	 	<div class="span2"></div>
		<div class="box span8">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Formulaires client</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="Activer.php">
						  <fieldset>
						  <div class="control-group info">
							  <div class="controls">
								<input type="hidden" class="span6" name="code" value=" <?php echo $i;?>">
							  </div>
							</div>
						  <h2 style="color:red; ">Etes-vous sûr de vouloir désactiver ce client?</h2>
						  <table>
							  	<tr>
							  		<td><b>Id : </b></td>
							  		<td><i><?php echo $i;?></i></td>
							  	</tr>
							  	<tr>
							  		<td><b>Nom : </b></td>
							  		<td> <i><?php echo $nom;?></i> </td>
							  	</tr>
							  	<tr>
							  		<td><b>Prénom : </b></td>
							  		<td> <i><?php echo $prenom;?></i> </td>
							  	</tr>
							  	<tr>
							  		<td><b>Type : </b></td>
							  		<td> <i><?php echo $type;?></i> </td>
							  	</tr>
							  	<tr>
							  		<td><b>Contact : </b></td>
							  		<td><i><?php echo $contact;?></i></td>
							  	</tr>
							  	<tr>
							  		<td><b>Solde : </b></td>
							  		<td><i><?php echo $solde;?></i></td>
							  	</tr>
						  </table>	        
					  <div class="form-actions">
						  <button type="submit" name="suppr" class="btn btn-primary">Oui</button>
						  <a class="btn btn-info" href="ListeClient.php">Non</a>
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