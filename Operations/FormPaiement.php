
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/paiement.php');
$p = new paiement();

$id=""; $lib="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$p->getOne2($id);
	$idAction=$row['ID_ACTION'];
	$nom=$row['NOM_ACTION'];
	$prenom=$row['PRENOM_ACTION'];
	$solde=$row['SOLDE_ACTION'];
	$taux=$row['TAUX'];
	//$IdMoisAdhesion=$p->ShowMoisSignature($idAction);//Mois de l'adhésion
	$LastMonth=$p->ShowLastMonth($idAction);//Dernier mois de paiement
	//var_dump($LastMonth);
	//$LastIdMonth=$p->ShowIdMonth($LastMonth);//Id du dernier mois
	//$NextMonth=$p->ShowNextMonth($LastIdMonth+1);//Mois suivant le dernier mois de paiement

	if($LastMonth==""){
	  $LastIdMonth=$p->ShowMoisSignature($idAction);
	  $NextMonth=$p->ShowNextMonth($LastIdMonth);
	}else if($LastMonth == 12){
		$LastIdMonth=1;
		$NextMonth=$p->ShowNextMonth(1);
	}else{
		 $LastIdMonth=$LastMonth+1;
         $NextMonth=$p->ShowNextMonth($LastIdMonth);
	}
}


if(isset($_POST['code'])){
	$code=$_POST['code'];
	$mois1=$_POST['mois1'];
	$mois2=$_POST['mois2'];
	$annee=$_POST['annee'];
	$date=$_POST['date'];
	$date1 = new DateTime($date);
	$date2 = $date1->format('Y-m-d');
	$taux=$_POST['taux'];
	$solde=$_POST['solde'];
	$commission=$_POST['comm'];	
	
    $p->setIdAction($code);
    $p->setMoisPaiement($mois1);
    $p->setMoisPaiementFinal($mois2);
    $p->setAnneePaiement($annee);
    $p->setDatePaiement($date2);
    $p->setMontantPaiement($commission);
    $p->setEtatpaie("Calculé");
    $p->Ajouter();
    header('location:ListePaiement.php');	
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
			<h1 style="color: white;">Formulaire paiement des commissions</h1>
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
				<h2 style="color:white;"><i class="halflings-icon edit"></i><span class="break"></span>Commissions</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" name="paie" method="POST" action="FormPaiement.php" style="background-color: #B0E0E6">
				  <fieldset>
				  	
				  	<div class="row-fluid">
	 	             <div class="span6">
	 	             	 <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" value="<?php echo $id;?>">
						</div>
				    </div>
	 	               <div class="control-group info">
						<label class="control-label">Nom</label>
						<div class="controls">
						  <input type="text" readonly="true" value="<?php echo $nom;?>">
						</div>
				       </div>
                        <div class="control-group info">
					       <label class="control-label">Solde</label>
							<div class="controls">
						  <input type="text" name="solde" readonly="true" value="<?php echo $solde;?>">
						</div>
				     </div>
				     <div class="control-group info">
					       <label class="control-label">Mois de</label>
							<div class="controls">
						  <input type="text" name="mois1" readonly="true" value="<?php echo $NextMonth;?>">
						</div>
				     </div>
				     <div class="control-group info">
					       <label class="control-label">Nombre de mois</label>
							<div class="controls">
						  <input type="text" name="totalMois" onclick="calculerNbreMois()" readonly="true">
						</div>
				     </div>
				      <div class="control-group info">
					  <label class="control-label" for="date01">Date</label>
					   <div class="controls">
						<input type="text" name="date" class=" datepicker" id="date01" required="true">
					  </div>
					</div> 
	 	             </div>
	 	             <div class="span6">
	 	             	 <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="lastId" value="<?php echo $LastIdMonth;?>">
						</div>
				       </div>
	 	             	<div class="control-group info">
						<label class="control-label">Prénom</label>
						<div class="controls">
						  <input type="text" readonly="true" value="<?php echo $prenom;?>">
						</div>
				       </div>
				        <div class="control-group info">
						  <label class="control-label">Taux</label>
						  <div class="controls">
						    <input type="text" name="taux" readonly="true" value="<?php echo $taux;?>">
						</div>
				        </div>
                        <div class="control-group info">
					  <label class="control-label">à</label>
					    <div class="controls">
					    <select type="text" name="mois2"  required="true" id="selectError1" data-rel="chosen">
						 <option></option>
						 <?php 
	                        $l=$p->ListerMois();
				            foreach ($l as $value){?> 
							 <option value="<?php echo $value['ID_MOIS'] ?>"><?php echo $value['LIBELLE_MOIS']; ?></option>
	                        <?php }?>
						</select>
						</div>
				    </div>
				        <div class="control-group info">
					    <label class="control-label">Année</label>
					    <div class="controls">
					    <select type="text" name="annee"  required="true" id="selectError2" data-rel="chosen">
						 <option></option>
						 <?php 
	                        $l=$p->ListerAnnee();
				            foreach ($l as $value){?> 
							 <option value="<?php echo $value['LIBELLE_ANNE'] ?>"><?php echo $value['LIBELLE_ANNE']; ?></option>
	                        <?php }?>
						</select>
						</div>
				    </div>
				        <div class="control-group info">
						<label class="control-label">Commission</label>
						<div class="controls">
						  <input type="text" required="true" onclick="calculerCommission()" name="comm" readonly="true">
						</div>
				       </div>
	 	             </div>
	 	            </div> 				 				
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
					  <a class="btn btn-info" href="PaiementAction.php">Retour à la liste</a>
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
				function calculerCommission(){
					var t=document.forms["paie"].elements["taux"].value;
					var p=document.forms["paie"].elements["solde"].value;
					var n=document.forms["paie"].elements["totalMois"].value;
					if(t != "" && p != "" ) { 
					   document.forms["paie"].elements["comm"].value=n*(parseInt(p)*parseInt(t))/100;
					} else {
					   document.forms["paie"].elements["comm"].value="0";
				}
			}

			function calculerNbreMois(){
					var t=document.forms["paie"].elements["mois2"].value;
					var p=document.forms["paie"].elements["lastId"].value;
					if(t != "" && p != "" ) { 
						if(t==p){
                          document.forms["paie"].elements["totalMois"].value=(parseInt(t)-parseInt(p)+1);
						}else{
							document.forms["paie"].elements["totalMois"].value=(parseInt(t)-parseInt(p)+1);
						}
					} else {
					   document.forms["paie"].elements["totalMois"].value="0";
				}
			}
		</script>
	<!-- end: JavaScript-->
</body>
</html>