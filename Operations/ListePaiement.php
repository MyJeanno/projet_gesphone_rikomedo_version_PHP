
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/paiement.php');
$p = new paiement();
$somme=$p->ShowTotalCommission();

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
		
		<div class="span6">
			<h1 style="color: white;">Liste des commissions calculées</h1>
		</div>
		<div class="span1"></div>
		<div class="span5">
	     	<h1 style="color: yellow;">Total comm : <?php echo strrev(wordwrap(strrev((int)$somme), 3, ' ', true));?></h1>
	     </div>
	   </div>	
      <hr>
	  </div>
    </div>

   	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2 style="color:white;"><i class="halflings-icon user"></i><span class="break"></span>Paiements</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped table-condensed table-hover table-bordered bootstrap-datatable datatable">
			  <thead>
				  <tr style="background-color: cadetblue;">
				  	  <th>N°</th>
					  <th>Nom</th>
					  <th>Prénoms</th>
					  <th>Mois de :</th>
					  <th>Au mois de :</th>
					  <th>Année</th>
					  <th>Date</th>
					  <th>Commission</th>
					  <th>Etat</th>
					  <th>Actions</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php 
		          $list=$p->ListerTout();
		          foreach ($list as $value){?> 
		    	<tr>
		    		<td><?php echo $value['ID_PAIE'];?></td>
		    	    <td><?php echo $value['NOM_ACTION'];?></td>
		    		<td><?php echo $value['PRENOM_ACTION'];?></td>
		    		<td><?php echo $value['LIBELLE_MOIS'];?></td>
		    		<td><?php echo $p->ShowNextMonth($value['MOIS_FIN']);?></td>
		    		<td><?php echo $value['LIBELLE_ANNE'];?></td>
		    		<td><?php echo $value['DATE_PAIE'];?></td>
		    		<td><?php echo strrev(wordwrap(strrev((int)$value['MONTANT']), 3, ' ', true));?></td>
		    		<td><?php echo $value['ETAT_PAIEMENT'];?></td>
		    		<td>
		    		<?php if($_SESSION['niveau']=="Admin"){ ?> 
					 <a class="btn btn-info" href="EditerPaiement.php?id=<?php echo $value['ID_PAIE'];?>"><i class="halflings-icon white edit"></i></a>
					 <a class="btn btn-danger" href="DeletePaiement.php?id=<?php echo $value['ID_PAIE'];?>"><i class="halflings-icon white trash"></i></a>
					 <a class="btn btn-success" href="ImprimerPaie.php?id=<?php echo $value['ID_PAIE'];?>">Payer</i></a>
					 <?php } ?>
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