
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/opportunite.php');
$opp = new opportunite();

$id=""; $lib="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$opp->getOne2($id);
	$nom=$row['NOM_ACTION'];
	$prenom=$row['PRENOM_ACTION'];
	$solde=$row['SOLDE_ACTION'];
	$solde2=$row['SOLDE_OPORT'];
	$taux=$row['TAUX'];
}


if(isset($_POST['code'])){
	$code=$_POST['code'];
	$dated1=$_POST['date1'];
	$dated2 = new DateTime($dated1);
	$dated = $dated2->format('Y-m-d');
	$datef1=$_POST['date2'];
	$datef2 = new DateTime($datef1);
	$datef = $datef2->format('Y-m-d');
    $nbre=$_POST['nbre'];
	$montant=$_POST['montant'];
	$taux=$_POST['taux'];
	$commission=$_POST['comm'];	
	
    $opp->setIdAction($code);
    $opp->setDateDebut($dated);
    $opp->setDateFin($datef);
    $opp->setNbreJour($nbre);
    $opp->setMontOpportunite($montant);
    $opp->setTauxOpportunite($taux);
    $opp->setCommission($commission);
    $opp->setEtatOpportunite("Ouvert");
    $test=$opp->Ajouter();
    
    header('location:ListeOpportunite.php');	
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
		<div class="span3"></div>
		<div class="span9">
			<h1 style="color: white;">Formulaire de souscription à une opportunité</h1>
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
				<h2 style="color:white;"><i class="halflings-icon edit"></i><span class="break"></span>Opportunité</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" name="opportunite" method="POST" action="FormOpportunite.php" style="background-color: #B0E0E6">
				  <fieldset>
				  	 <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" value="<?php echo $id;?>">
						</div>
				    </div>
				  	<div class="row-fluid">
	 	             <div class="span6">
	 	               <div class="control-group info">
						<label class="control-label">Nom</label>
						<div class="controls">
						  <input type="text" readonly="true" value="<?php echo $nom;?>">
						</div>
				       </div>
                        <div class="control-group info">
					       <label class="control-label">Solde action</label>
							<div class="controls">
						  <input type="text" name="solde" readonly="true" value="<?php echo $solde;?>">
						</div>
				     </div>
				       <div class="control-group info">
					  <label class="control-label" for="date02">Date début</label>
					   <div class="controls">
						<input type="text" name="date1" class=" datepicker" id="date02" required="true">
					  </div>
					</div> 
				      <div class="control-group info">
						<label class="control-label">Nombre de jours</label>
						<div class="controls">
						  <input type="text" required="true" onclick="calculerNbreJours()" name="nbre" readonly="true">
						</div>
				       </div>
				       <div class="control-group info">
						  <label class="control-label">Commission</label>
						  <div class="controls">
						    <input type="text" name="comm" required="true">
						</div>
				        </div>				      			      
	 	             </div>
	 	             <div class="span6">
	 	             	<div class="control-group info">
						<label class="control-label">Prénom</label>
						<div class="controls">
						  <input type="text" readonly="true" value="<?php echo $prenom;?>">
						</div>
				       </div>
				       <div class="control-group info">
					       <label class="control-label">Solde opportunité</label>
							<div class="controls">
						  <input type="text" name="solde" readonly="true" value="<?php echo $solde2;?>">
						</div>
				     </div>
				      <div class="control-group info">
					  <label class="control-label" for="date01">Date fin</label>
					   <div class="controls">
						<input type="text" name="date2" class=" datepicker" id="date01" required="true">
					  </div>
					</div> 
				      <div class="control-group info">
						<label class="control-label">Montant opportunité</label>
						<div class="controls">
						  <input type="number" required="true" name="montant">
						</div>
				       </div>		        
				        <div class="control-group info">
						<label class="control-label">Taux en %</label>
						<div class="controls">
						  <input type="text" required="true" name="taux" onclick="calculerTaux()" readonly="true">
						</div>
				       </div>
	 	             </div>
	 	            </div> 				 				
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
					  <a class="btn btn-info" href="PageOpportunite.php">Retour à la liste</a>
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

		<script>
            function dayDiff(d1, d2)
			{
			  d1 = d1.getTime();
			  d2 = d2.getTime();
			  return new Number(d2 - d1).toFixed(0);
			}

			  function diffdate(d1,d2){
				var WNbJours = d2.getTime() - d1.getTime();
				return Math.ceil(WNbJours/(1000*60*60*24));
				}
				//var Date1 = new Date(2011,9,30);
				//var Date2 = new Date(2011,10,1);
				//alert(diffdate(Date1,Date2) + ' jours');


				function calculerNbreJours(){
					
					var d1=new Date(document.forms["opportunite"].elements["date1"].value);
					var d2=new Date(document.forms["opportunite"].elements["date2"].value);
					if(d1 != "" && d2 != "" ) { 
					   document.forms["opportunite"].elements["nbre"].value=diffdate(d1,d2)-1;
					} else {
					   document.forms["opportunite"].elements["nbre"].value="0";
				}
				//alert(d1);
			}

			function calculerCommission(){
					
					var taux=document.forms["opportunite"].elements["taux"].value;
					var jour=document.forms["opportunite"].elements["nbre"].value;
					var tj = taux/10;
					var mont=document.forms["opportunite"].elements["montant"].value;
					if(taux != "" && mont != "" ) { 
					   document.forms["opportunite"].elements["comm"].value=parseInt(tj*mont*jour/100);
					} else {
					   document.forms["opportunite"].elements["comm"].value="0";
				}
				//alert(taux);
			}

			function calculerTaux(){
					var com=document.forms["opportunite"].elements["comm"].value;
					var mont=document.forms["opportunite"].elements["montant"].value;
					if(com != "" && mont != "" ) { 
					   document.forms["opportunite"].elements["taux"].value=100*com/mont;
					} else {
					   document.forms["opportunite"].elements["taux"].value="0";
				}
				//alert(taux);
			}
		</script>
	<!-- end: JavaScript-->
</body>
</html>