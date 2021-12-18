
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/client.php');
$cli = new client();

if (isset($_POST['nom'])) {
	$numero = $cli->genererRef();
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$type = $_POST['type'];
	$contact = $_POST['contact'];

	$cli->setNumClient($numero);
	$cli->setNomClient($nom);
	$cli->setPrenomClient($prenom);
	$cli->setTypeClient($type);
	$cli->setContactClient($contact);
	$cli->setSoldeClient(0);
	$cli->setActif("Oui");
	$cli->setAutorisation("NON");			
	$cli->Ajouter();
}

if (isset($_POST['numcli'])) {
	$numeroClient = $_POST['numcli'];
	header('location:../Encaissement/AchatClient.php?num='.$numeroClient);
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
	<!-- start: Header -->
  <?php include('../Layout/Layout.php');?>
    <div class="jumbotron" style="background-color: #191970"> 	
	  <div class="container">
	   <hr>
	    <div class="row-fluid">
		<div class="span4">
		 <form class="form-horizontal" method="POST" action="ListeClient.php">
		  <table>
		  	<tr>
		  		<td><input type="text" name="numcli" placeholder="Entrer le numéro d'un client"></td>
		  		<td><input type="submit" name="ok" class="btn btn-info" value="Send"></td>
		  	</tr>
		  </table>
		</form>
		</div>
		<div class="span6">
			<h1 style="color: white;">Liste des clients abonnés</h1>
		</div>
		<div class="span2 btn-group pull-right">
          <a href="#"><button class="btn-setting btn btn-success">Nouveau client <i class="icon-plus icon-white"></i></button></a>
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
				  <tr style="background-color: cadetblue">
					  <th>N°</th>
					  <th>Nom</th>
					  <th>Prénom</th>
					  <th>Type de client</th>
					  <th>Contact</th>
					  <th>Reste à payer</th>
					  <th>Echéance</th>
					  <th>Autorisation</th>				  
					  <th>Actions</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php 
		          $list=$cli->ListerTout2();
		          foreach ($list as $value){?> 
		    	<tr>
		    	    <td><?php echo $value['NUM_CLI'];?></td>
		    		<td> <?php echo $value['NOM_CLI'];?></td>
		    		<td> <?php echo $value['PRENOM_CLI'];?></td>
		    		<td> <?php echo $value['TYPE_CLI'];?></td>	
		    		<td> <?php echo $value['CONTACT_CLI'];?></td>
		    		<td> <?php echo strrev(wordwrap(strrev((int)$value['SOLDE_CLIENT']), 3, ' ', true));?></td>
		    		<td> <?php echo $value['ECHEANCE'];?></td>
		    		<td> <?php echo $value['AUTORISATION'];?></td>    		
		    		<td>
		    		<?php if($_SESSION['niveau']=="Admin"){ ?> 
					 <a class="btn btn-info" href="EditerClient.php?id=<?php echo $value['NUM_CLI'];?>"><i class="halflings-icon white edit"></i></a>
					 <a class="btn btn-success" href="AutoriserClient.php?id=<?php echo $value['NUM_CLI'];?>"><i class="halflings-icon white ok"></i></a>
					 <a class="btn btn-danger" href="EmpecherClient.php?id=<?php echo $value['NUM_CLI'];?>"><i class="halflings-icon white remove"></i></a>
					 <?php } ?>
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
		 <h2>Ajouter un nouveau client</h2>
	</div>
    <div class="modal-body" style="background-color: #B0E0E6">
	<form class="form-horizontal" method="POST" action="ListeClient.php">
		<div class="control-group info">
			<label class="control-label">Nom client</label>
			<div class="controls">
			  <input type="text" required="true" name="nom">
			</div>
		</div>
		<div class="control-group info">
			<label class="control-label">Prénom client</label>
			<div class="controls">
			  <input type="text" required="true" name="prenom">
			</div>
		</div>
		<div class="control-group info">
		    <label class="control-label">Type de client</label>
		       <div class="controls">
		        <select id="selectError" name="type" data-rel="chosen">
				    <option></option>
					<option>Grossiste</option>
					<option>Commercial</option>
					<option>Externe</option>
				  </select>
		       </div>
	    </div>
		<div class="control-group info">
			<label class="control-label">Contact client</label>
			<div class="controls">
			  <input type="text" name="contact">
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