
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/transfert.php');
require_once('../classes/produit.php');
$tr = new transfert();
$prod = new produit();

$id=""; $lib="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$prod->getOne($id);
$lib=$tr->showLibelleProduit($id);
}

if(isset($_GET['numc'])){
	$numc = $_GET['numc'];
}else{
	$numc = 1;
}

if (isset($_POST['code'])) {
	$produit = $_POST['code'];
	$numcom = $_POST['nc'];
    $quantite = $_POST['qte'];
    $type = $_POST['type'];
    $date = $tr->nowDate();
    
    $gros=$prod->showStockProduit($produit);
    $det=$prod->showStockProduit2($produit);

	$tr->setCodeProd($produit);
	$tr->setDateTransf($date);
	$tr->setQteTransf($quantite);
	$tr->setDestinationTransf($type);
	/*$v = $tr->inserrerAppro($produit,$numcom,$quantite,$type,$date,"T");
	var_dump($v);
	exit();*/
	if($type=='Gros'){
		if($det >= $quantite){
		  $tr->Ajouter();	
		  $test1 = $prod->updateStockProduitDeleteTransfert2($quantite,$produit);
		  $tr->inserrerAppro($_SESSION['id'],$produit,$numcom,$quantite,$type,$date,"T");
		  header('location:ListeTransfert.php');
		}else{
		  echo "<script type='text/javascript'>alert('Transfert impossible. Le stock détail est inférieur à la quantité saisie. Merci' ); location.href = 'Transferer.php'</script>";	
		} 
    }else if($type=='Detail') {
    	if($gros >= $quantite){
    	  $tr->Ajouter();	
    	  $test2 = $prod->updateStockProduitDeleteTransfert($quantite,$produit);
    	  $tr->inserrerAppro($_SESSION['id'],$produit,$numcom,$quantite,$type,$date,"T");
    	  header('location:ListeTransfert.php');
    	}else{
          echo "<script type='text/javascript'>alert('Transfert impossible. Le stock en gros est inférieur à la quantité saisie. Merci' ); location.href = 'Transferer.php'</script>";
    	}   
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
		<div class="span4"></div>
		<div class="span8">
			<h1 style="color: white;">Mutation de stock de produits</h1>
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
				<h2 style="color:white;"><i class="halflings-icon edit"></i><span class="break"></span>Formulaires de mutation</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="FormTransfert.php" style="background-color: #B0E0E6">
				  <fieldset>
				  <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" value="<?php echo $id;?>">
						  <input type="hidden" name="nc" value="<?php echo $numc;?>">
						</div>
				  </div>
				    <div class="control-group info">
					    <label class="control-label">Téléphone</label>
					       <div class="controls">
					        <input type="text" name="produit" readonly="true" value="<?php echo $lib;?>" required="true" >
					       </div>
				    </div>
				    <div class="control-group info">
				    <label class="control-label">Transférer vers :</label>
				       <div class="controls">
				        <select id="selectError" name="type" required="true" data-rel="chosen">
						    <option></option>
						    <option>Gros</option>
							<option>Detail</option>							
						  </select>
				       </div>
			        </div>
			        <div class="control-group info">
					    <label class="control-label">Quantité</label>
					       <div class="controls">
					        <input type="number" required="true" name="qte">
					       </div>
				    </div>
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
					  <a class="btn btn-info" href="Transferer.php">Retour à la liste</a>
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