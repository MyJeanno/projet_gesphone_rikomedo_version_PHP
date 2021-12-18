
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
} 
require_once('../classes/encaissement.php');
require_once('../classes/presence.php');
require_once('../classes/ecart.php');
$pres = new presence();
$enc = new encaissement();
$ecart = new ecart();


$id=""; $TotJour="";
if(isset($_POST['affichage'])){
    $id=$_POST['user'];
    $TotJour=$enc->showTotalEncaisseEmployeJour($id);
 }

  if(isset($_POST['valider'])){
	$employe=$_POST['util'];
    $enc->updateEtatVersement($employe);
    header('location:ValidationVersement.php');
  }

  if(isset($_POST['ecart'])){
	$user=$_POST['user'];
	$reel=$_POST['reel'];
	$physique=$_POST['phys'];
	$date=$ecart->nowDate();

	$ecartR=$reel-$physique;

	$ecart->setIdUser($user);
    $ecart->setMontantReel($reel);
	$ecart->setMontantPhysique($physique);
    $ecart->setDateEcart($date);
    $ecart->setOrigineEcart("Encaissement");
    $ecart->setMontantEcart($ecartR);
    $ecart->setAvisEcart("NON REGLE");
    $ecart->Ajouter();
    header('location:ValidationVersement.php');
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
	    <div class="row-fluid sortable">
	   <form class="form-horizontal" method="POST" action="ValidationVersement.php">	
	      <div class="span4">
	       <div class="form-group info">
			  <label class="span3"  style="color: white;">Employé</label>
			    <div class="span9">
			    <select type="text" name="user" id="selectError1" data-rel="chosen">
				 <option></option>
				 <?php 
                    $l=$pres->ListerNomUser();
		            foreach ($l as $value){?> 
					 <option value="<?php echo $value['ID_USER'] ?>"><?php echo $value['NOM_USER'].'  '.$value['PRENOM_USER'] ?></option>
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
		<div class="span3">
	      	<div class="form-group">
	      		<label style="color: yellow;" class="span5">Encaissement non versé : </label>
	      		<div style="color: yellow;" class="span7">
	                <input type="text" readonly="true" class="form-control" value="<?php echo strrev(wordwrap(strrev((int)$TotJour), 3, ' ', true));?>">
	            </div>
	         </div> 
	     </div>
	     <div class="span1">
	      	<div class="form-group">
	      		<div style="color: yellow;" class="span3">
	                <input type="hidden" name="util" class="form-control" value="<?php echo $id ;?>">
	            </div>
	         </div> 
	     </div>
	    <div class="span2">
          <div class="form-group">
            <button class="btn btn-success" name="valider">Validation par lot <i class="icon-ok icon-white"></i></button>
          </div> 
        </div>  
	 </form>
	   </div>	
      <hr>
	  </div>
    </div>

   	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2 style="color: white;"><i class="halflings-icon user"></i><span class="break"></span>Validation encaissement</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped table-hover table-condensed bootstrap-datatable datatable">
			  <thead>
				  <tr style="background-color: cadetblue;">
				  	  <th>N°</th>
					  <th>Nom client</th>
					  <th>Prénoms client</th>
					  <th>Date</th>
					  <th>Heure</th>
					  <th>Montant encaissé</th>
					  <th>Caissier</th>
					  <th>Etat encaissement</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php 
		          $list=$enc->ListerEncaissement($id);
		          foreach ($list as $value){?> 
		    	<tr>
		    	    <td><?php echo $value['ID_ENC'];?></td>
		    	    <td><?php echo $value['NOM_CLI'];?></td>
		    	    <td><?php echo $value['PRENOM_CLI'];?></td>
		    		<td> <?php echo $value['DATE_ENC'];?></td>
		    		<td> <?php echo $value['HEURE_ENC'];?></td>
		    		<td> <?php echo strrev(wordwrap(strrev($value['MONT_ENC']), 3, ' ', true));?></td>
		    		<td> <?php echo $value['PRENOM_USER'];?></td>
		    		<td> <?php echo $value['ETAT_ENCAISSE'];?></td>
		    	</tr>
		        <?php } ?>
			  </tbody>
			  </table>            
			</div>
		</div>	
	</div>

	<div class="form-group pull-right">
    	<button class="btn-setting btn btn-info" name="ecart">Gérer les écarts <i class="icon-hand-right icon-white"></i></button>
    </div>

	<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h2>Formulaire d'écart d'encaissement</h2>
	</div>
    <div class="modal-body" style="background-color: #B0E0E6">
	<form class="form-horizontal" method="POST" action="ValidationVersement.php">
	    <div class="control-group info">
		  <label class="control-label">Employé</label>
		    <div class="controls">
		    <select type="text" name="user" id="selectError2" data-rel="chosen">
			 <option></option>
			 <?php 
                $l=$pres->ListerNomUser();
	            foreach ($l as $value){?> 
				 <option value="<?php echo $value['ID_USER'] ?>"><?php echo $value['NOM_USER'].'  '.$value['PRENOM_USER'] ?></option>
                <?php }?>
			</select>
			</div>
		  </div>
		  <div class="control-group info">
			  <label class="control-label">Montant à verser</label>
			  <div class="controls">
			      <input type="number" name="reel" required="true" >
			 </div>
		  </div>
		  <div class="control-group info">
			  <label class="control-label">Montant détenu</label>
			  <div class="controls">
			      <input type="number" name="phys" required="true" >
			 </div>
		  </div>
	</div>
	<div class="modal-footer">
		<input type="submit" name="ecart" class="btn btn-primary" value="Enregistrer">
	    <button type="button" class="btn btn-default" data-dismiss="modal" area-hidden="true">Fermer</button> 
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