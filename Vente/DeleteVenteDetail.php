
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/vente.php');
$vte = new vente();

$qte=""; $produit=""; $i=""; $date=""; $client=""; $type=""; $mont="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$vte->getOne($id);
	$i=$row['ID_VENTE'];
	$client=$vte->showNomClient($row['NUM_CLI']);
	$produit=$vte->showLibelleProduit($row['CODE_PROD']);
	$date=$row['DATE_VENTE'];
	$type=$row['ETAT_TELEPHONE'];
	$qte=$row['QTE_VENTE'];
	$mont=$row['MONT_PAYE'];
}


if(isset($_POST['suppr'])){
	$code=$_POST['code'];
	$nomcli=$_POST['cli'];
	$qtebdd=$vte->showQteVendu($code);
	$idProd=$vte->showIdProduit($code);
	$message="L'utilisateur a supprimé une vente";
    $vte->delete($code);
    $vte->updateStockProdDelVte2($qtebdd,$idProd);
    $vte->AjouterSuppression($_SESSION['id'],date("Y-m-d H:i"),$message,$nomcli);

    header('location:ListeVenteDetail.php');
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
		<div class="span4"></div>
		<div class="span8">
			<h1 style="color: white;">Supprimer une vente</h1>
		</div>
	   </div>	
      <hr>
	  </div>
    </div>
    <br>

	 <div class="row-fluid sortable">
	 	<div class="span2"></div>
		<div class="box span8">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Suppression vente</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="DeleteVenteDetail.php">
						  <fieldset>
						  <div class="control-group info">
							  <div class="controls">
								<input type="hidden" class="span6" name="code" value=" <?php echo $id;?>">
							  </div>
						  </div>
						  <div class="control-group info">
							  <div class="controls">
								<input type="hidden" class="span6" name="cli" value=" <?php echo $client;?>">
							  </div>
						  </div>
						  <h2 style="color:red; ">Etes-vous sûr de vouloir supprimer cette vente?</h2>
						  <table>
							  	<tr>
							  		<td><b>Id : </b></td>
							  		<td><i><?php echo $i;?></i></td>
							  	</tr>
							  	<tr>
							  		<td><b>Client : </b></td>
							  		<td> <i><?php echo $client;?></i> </td>
							  	</tr>
							  	<tr>
							  		<td><b>Produit : </b></td>
							  		<td><i><?php echo $produit;?></i></td>
							  	</tr>
							  	<tr>
							  		<td><b>Date : </b></td>
							  		<td><i><?php echo $date;?></i></td>
							  	</tr>
							  	<tr>
							  		<td><b>Etat : </b></td>
							  		<td><i><?php echo $type;?></i></td>
							  	</tr>
							  	<tr>
							  		<td><b>Quantité : </b></td>
							  		<td><i><?php echo $qte;?></i></td>
							  	</tr>
							  	<tr>
							  		<td><b>Montant : </b></td>
							  		<td><i><?php echo $mont;?></i></td>
							  	</tr>
						  </table>	        
					  <div class="form-actions">
						  <button type="submit" name="suppr" class="btn btn-primary">Supprimer</button>
						  <a class="btn btn-info" href="ListeVenteDetail.php">Retour à la liste</a>
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