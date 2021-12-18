<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/vente.php');
require_once('../classes/commande.php');
$vte = new vente();
$com = new commande();

$qte=""; $produit=""; $i=""; $date=""; $client=""; $type=""; $mont="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$vte->getOne($id);
	$i=$row['ID_VENTE'];
	$client=$vte->showNomClientEdit($id);
	$produit=$vte->showLibelleProduit($row['CODE_PROD']);
	$date=$row['DATE_VENTE'];
	$type=$row['TYPE_VENTE'];
	$pr=$row['PRIX_GROS'];
	$qte=$row['QTE_VENTE'];
	$mont=$row['MONT_PAYE'];
	$idcom=$row['ID_COM'];
	//$stock=$vte->showStockProduitDetNew($row['CODE_PROD']);
}


if(isset($_POST['send'])){
	$code=$_POST['code'];
	$nomcli=$_POST['client'];
	$prod=$_POST['produit'];
	$quantite=$_POST['qtte'];
	$price=$_POST['p'];
	$montant=$_POST['montant'];
	$date=$_POST['date'];
	$numeroC=$_POST['numero'];

	$qtebdd=$vte->showQteVendu($code);
	$idProd=$vte->showIdProduit($code);
	$qteDiff=$quantite-$qtebdd;

    $NewPrice=$vte->showPriceNewProd($prod);
    $oldTotal=$vte->showOldTotal($code);
    $numvtedet=$vte->showNumVteDet($code);
    $prixDetail=$vte->showPrixDetailProduit($idProd);
    $IdMtNonNul=$vte->showMontantNotNull($numvtedet);
	$priTotal = $quantite*$price;
	$MontantDiff = $oldTotal-$priTotal;

	$idProd=$vte->showIdProduit($code);
	$prodEchange=$vte->showLibelleProduit($idProd);
	$oldPrice=$vte->showOldPriceProd($code);
	$lib=$vte->showLibelleProduit($prod);
	$message="Modification d'une vente";
	//$priTotal = $quantite*$prixDetail;
	//$priTotal2 = $quantite*$NewPrice;

	//var_dump($IdMtNonNul);
	//exit();

	$stock=$vte->showStockProduitDetNew($prod);
    if($qteDiff <= $stock ){
	    if($idProd==$prod){
	    	$vte->setIdVente($code);
		    $vte->setCodeProd($prod);
		    $vte->setQuantite($quantite);
		    $vte->setPrixGros($price);
		    $vte->setMontPayer($montant);
		    $vte->setDateVente($date); 
		    $vte->setPrixTotal($priTotal);
		    $vte->setIdCommande($numeroC); 
	        $vte->updateVenteDet2();
	        $vte->updateVenteDetMontant($IdMtNonNul,$MontantDiff);
		    $vte->updateStockProduitVte22($qteDiff,$idProd);
            $vte->AjouterSuppressionBis($_SESSION['id'],date("Y-m-d H:i"),$prodEchange,$oldPrice,$lib,
			    	$price,$message,$nomcli);
		    header('location:ModifierVenteD.php?id='.$numvtedet);
	    }else if($quantite <= $stock){
	    	$vte->setIdVente($code);
		    $vte->setCodeProd($prod);
		    $vte->setQuantite($quantite);
		    $vte->setPrixGros($price);
		    $vte->setMontPayer($montant);
		    $vte->setDateVente($date); 
		    $vte->setPrixTotal($priTotal); 
		    $vte->setIdCommande($numeroC);
	    	$vte->updateVenteDet2();
	    	$vte->updateVenteDetMontant($IdMtNonNul,$MontantDiff);
		    $test=$vte->updateStockProduitDiffVteDet($qtebdd,$idProd);
		    $vte->updateStockProduitDiffVteDet1($quantite,$prod);
            $vte->AjouterSuppressionBis($_SESSION['id'],date("Y-m-d H:i"),$prodEchange,$oldPrice,$lib,
			    	$price,$message,$nomcli);
		    header('location:ModifierVenteD.php?id='.$numvtedet);
	    }else{
	    	header('location:Error.php?qte='.$stock);
	    }
    }else{
  	   header('location:Error.php?qte='.$stock);
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
			<h1 style="color: white;">Editer une vente</h1>
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
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Formulaire vente</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="EditerVenteBis.php" style="background-color: #B0E0E6">
				  <fieldset>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" value="<?php echo $i;?>">
						</div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Client</label>
					       <div class="controls">
					        <input type="text" required="true" name="client" readonly="true" value="<?php echo $client;?>">
					       </div>
				    </div>
				    <div class="control-group info">
					  <label class="control-label">Produit</label>
					    <div class="controls">
					    <select type="text" name="produit"  required="true" id="selectError2" data-rel="chosen">
						 <option></option>
						 <?php 
	                        $l=$vte->ListerNomPhone();
				            foreach ($l as $value){
				            	if($value['CODE_PROD']==$row['CODE_PROD']){?> 
				             <option selected value="<?php echo $value['CODE_PROD'] ?>"><?php echo $value['LIBELLE_PROD'] ?></option>	
				             <?php }else{?>
							 <option value="<?php echo $value['CODE_PROD'] ?>"><?php echo $value['LIBELLE_PROD'] ?></option>
	                        <?php }}?>
						</select>
						</div>
				    </div>
				    <div class="control-group info">
					  <label class="control-label">Liste des commandes</label>
					    <div class="controls">
					    <select type="text" name="numero"  required="true" id="selectError1" data-rel="chosen">
						 <option></option>
						 <?php 
	                        $l=$com->ListerCommande();
				            foreach ($l as $value){
				            	if($value['ID_COM']==$row['ID_COM']){?> 
							 <option selected value="<?php echo $value['ID_COM'] ?>"><?php echo $value['NUM_COM']." ".$value['DATE_RECEPTION']?></option>
	                        <?php }else{?>
	                        <option value="<?php echo $value['ID_COM'] ?>"><?php echo $value['NUM_COM']."|".$value['DATE_RECEPTION']?></option>
	                        <?php }}?>	
						</select>
						</div>
				    </div> 
				     <div class="control-group info">
					    <label class="control-label">Type</label>
					       <div class="controls">
					        <input type="text" required="true" name="type" readonly="true" value="<?php echo $type;?>">
					       </div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Quantité</label>
					       <div class="controls">
					        <input type="number" min="1" required="true" name="qtte" value="<?php echo $qte;?>">
					       </div>
				    </div>
				     <div class="control-group info">
					    <label class="control-label">Prix</label>
					       <div class="controls">
					        <input type="number" min="100" required="true" name="p" value="<?php echo $pr;?>">
					       </div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Montant payé</label>
					       <div class="controls">
					        <input type="number" readonly required="true" name="montant" value="<?php echo $mont;?>">
					       </div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Date</label>
					       <div class="controls">
					        <input type="date" name="date" value="<?php echo $date;?>" required="true" >
					       </div>
				    </div>						   				    
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
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