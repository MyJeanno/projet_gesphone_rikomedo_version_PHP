
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/approvisionnement.php');
require_once('../classes/commande.php');
$appro = new approvisionnement();
$com = new commande();

if (isset($_POST['affichage'])) {
	$num = $_POST['comm'];
	$numero=$appro->showIdCommande($num);
    $total = $appro->TotalApproParCommande($num);
}else{
	$num="";
	$numero=$appro->showIdCommande($num);
    $total = $appro->TotalApproParCommande($num);
}

$list=$appro->ApproParCommande($num);
	//var_dump($numero);
	//exit();
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
	   <form class="form-horizontal" method="POST" action="RecapAppro.php">	
	      <div class="span4">
	       <div class="form-group info">
			  <label class="span4"  style="color: white;">Numéro de commande</label>
			    <div class="span8">
			    <select type="text" name="comm" id="selectError1" data-rel="chosen">
				 <option></option>
				 <?php 
                    $l=$com->ListerCommandeEncours();
		            foreach ($l as $value){?> 
					 <option value="<?php echo $value['ID_COM'] ?>"><?php echo $value['NUM_COM']?></option>
                    <?php }?>
				</select>
				</div>
		  </div>
		</div>
		 <div class="span2">
          <div class="form-group">
            <button class="btn btn-info" name="affichage">Afficher <i class="icon-search icon-white"></i></button>
          </div> 
        </div>
        <div class="span6">
        	<h2 style="color: white;">Numéro commande : <?php echo $numero ?> - Total : <?php echo $total." téléphones";?> </h2>
        </div>
	 </form>
	   </div>	
      <hr>
	  </div>
    </div>

   	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2 style="color:white;"><i class="halflings-icon user"></i><span class="break"></span>Récap des approvisionnements</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped table-condensed table-hover table-bordered bootstrap-datatable datatable">
			  <thead>
				  <tr style="background-color: cadetblue;">
				  	  <th>Libellé du téléphone</th>
					  <th>Total approvisionné</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php 
		          foreach ($list as $value){?> 
		    	<tr>
		    		<td><?php echo $value['LIBELLE_PROD'];?></td>
		    	    <td><?php echo $value['total'];?></td>
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