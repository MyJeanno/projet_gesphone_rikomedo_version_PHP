<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/transfert.php');
require_once('../classes/produit.php');
$prod = new produit();
$tr = new transfert();

$qte=""; $produit=""; $i=""; $type="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$tr->getOne($id);
	$i=$row['CODE_TRANSF'];
	$produit=$prod->showLibelleProduit($row['CODE_PROD']);
	$qte=$row['QTE_TRANSF'];
	$type=$row['DESTINATION'];
	$stock=$prod->showStockProduit($row['CODE_PROD']);
	$stock2=$prod->showStockProduit2($row['CODE_PROD']);
	//var_dump($stock2);
}


if(isset($_POST['send'])){
	$code=$_POST['code'];
	$quantite=$_POST['qtte'];
	$dest=$_POST['type'];

	$qtebdd=$tr->showQteTransfert($code);
	$idProd=$tr->showIdProduit($code);
	$qteDiff=$quantite-$qtebdd;
	$elt=$tr->showTypeTransfert($code);
	$qte=$tr->showQteTransfert($code);
	if($dest==$elt){
	    if($dest=='Gros'){
	        $tr->setIdTransf($code);
		    $tr->setQteTransf($quantite);
		    $tr->setDestinationTransf($dest);
		    $tr->updateTransfert();
		    $prod->updateStockProduitTranfert($qteDiff,$idProd);
		    header('location:ListeTransfert.php');	
	    }else{
	    	$tr->setIdTransf($code);
		    $tr->setQteTransf($quantite);
		    $tr->setDestinationTransf($dest);
		    $tr->updateTransfert();
		    $prod->updateStockProduitTranfert2($qteDiff,$idProd);
		    header('location:ListeTransfert.php');
	    }  
    }else{
    	if($dest=='Gros'){
	        $tr->setIdTransf($code);
		    $tr->setQteTransf($quantite);
		    $tr->setDestinationTransf($dest);
		    $tr->updateTransfert();
		    $prod->updateStockProduitDeleteTransfert2($qte,$idProd);
		    $prod->updateStockProduitTranfert($quantite,$idProd);
		    header('location:ListeTransfert.php');	
	    }else{
	    	$tr->setIdTransf($code);
		    $tr->setQteTransf($quantite);
		    $tr->setDestinationTransf($dest);
		    $tr->updateTransfert();
		    $prod->updateStockProduitDeleteTransfert($qte,$idProd);
		    $prod->updateStockProduitTranfert2($quantite,$idProd);
		    header('location:ListeTransfert.php');
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
			<h1 style="color: white;">Editer un transfert</h1>
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
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Formulaire transfert</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="EditerTransfert.php" style="background-color: #B0E0E6">
				  <fieldset>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" value="<?php echo $i;?>">
						</div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Produit</label>
					       <div class="controls">
					        <input type="text" required="true" name="produit" readonly="true" value="<?php echo $produit;?>">
					       </div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Quantité</label>
					       <div class="controls">
					        <input type="number" min="1" max="<?php if($type=="Gros"){echo $stock;}else echo $stock2;?>" required="true" name="qtte" value="<?php echo $qte;?>">
					       </div>
				    </div>
				    <div class="control-group info">
					<label class="control-label">Transférer vers :</label>
					   <div class="controls">
				        <select type="text" id="selectError1" name="type" data-rel="chosen" value=" <?php echo $type;?>">
						<?php 
				          if($type!=""){
				           switch($type){
					       case "Gros":{?>
						   <option></option>
						   <option selected>Gros</option> 
						   <option>Detail</option>
						   <?php break;}

						   default:{?>
						   <option></option>
				           <option >Gros</option> 
			               <option selected>Detail</option>
						   <?php
						   }
					     }
						}else{?>
						   <option></option>
				           <option >Gros</option> 
				           <option>Detail</option>
							 <?php
							 }
					     ?>
						</select>
						</div>
					</div> 								   				    
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
					  <a class="btn btn-info" href="ListeTransfert.php">Retour à la liste</a>
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