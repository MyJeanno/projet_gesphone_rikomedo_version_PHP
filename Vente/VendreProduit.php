
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/produit.php');
require_once('../classes/vente.php');
require_once('../classes/approvisionnement.php');
$prod = new produit();
$vte = new vente();
$appro = new approvisionnement();

$IdCom=$appro->LastIdCommande();

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $numCom=$appro->ShowNumCommande($id);	
}else{
  $id=$IdCom;
  $numCom=$appro->ShowNumCommande($id);	
}


$row=$vte->showLastId();
$client=$row['NUM_CLI'];
$num=$row['NUM_ID'];

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
		<div class="span2"></div>
		<div class="span8">
			<h2 style="color: white;">Vente en gros (Liste des produits de la commande N° : <?php echo $numCom;?> )</h2>
		</div>
		<div class="span2">
			<div class="form-group">
          	<a href="PayerSomme.php?numcli=<?php echo $num.''.$client;?>"><button class="btn btn-success" name="ok">Payement  <i class="icon-shopping-cart icon-white"></i></button></a>           
          </div> 
		</div>
	   </div>	
      <hr>
	  </div>
    </div>

   	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon user"></i><span class="break"></span>Produits</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
			  <thead>
				  <tr style="background-color: cadetblue;">
					  <th>N°</th>
					  <th>Désignation</th>
					  <th>Quantité en stock</th>				  				  
					  <th>Sélectionner</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php 
		          $list=$appro->ListerApproCommande($id);
		          foreach ($list as $value){?> 
		    	<tr>
		    		<td><?php echo $value['CODE_PROD'];?></td>
		    		<td> <?php echo $value['LIBELLE_PROD'];?></td>
		    		<td> <?php echo (int)$value['QTE_STOCK'];?></td>
		    		<td> 
					 <a class="btn btn-success" href="FormVente.php?id=<?php echo $value['CODE_PROD'];?>& num=<?php echo $id;?>"><i class="halflings-icon white zoom-in"></i></a>
		    		</td>
		    	</tr>
		        <?php } ?>
			  </tbody>
			  </table>            
			</div>
		</div>	
	</div>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		 <h2>Ajouter un nouveau produit</h2>
	</div>
    <div class="modal-body">
	<form class="form-horizontal" method="POST" action="VendreProduit.php">
		<div class="control-group info">
			<label class="control-label">Catégorie</label>
			<div class="controls">
			  <input type="text" required="true" name="cate">
			</div>
		</div>
		<div class="control-group info">
			<label class="control-label">Désignation</label>
			<div class="controls">
			  <input type="text" required="true" name="design">
			</div>
		</div>
		<div class="control-group info">
			<label class="control-label">Prix</label>
			<div class="controls">
			  <input type="number" required="true" name="prix">
			</div>
		</div>						
	</div>
	<div class="modal-footer">
		<input type="submit" class="btn btn-primary" value="Enregistrer">
	    <button type="button" class="btn btn-default" data-dismiss="modal" area-hidden="true">Fermer
	    </button> 
	</div>
    </form>
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