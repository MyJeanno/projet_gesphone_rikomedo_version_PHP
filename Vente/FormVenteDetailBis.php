<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/vente.php');
require_once('../classes/produit.php');
require_once('../classes/encaissement.php');
require_once('../classes/approvisionnement.php');
$vte = new vente();
$prod = new produit();
$enc = new encaissement();
$appro = new approvisionnement();

$numero = $_GET['num'];
$numCom=$appro->ShowNumCommande($numero);

$id=""; $lib=""; $prix=""; $kilo="";
$total=$vte->showTotalVteCouranteDetail($_SESSION['id']);
//$numCom=$appro->LastNumCommande();
//$IdCom=$appro->LastIdCommande();

if(isset($_GET['id'])){
	$id=$_GET['id'];
	$row=$prod->getOne($id);
	$lib=$vte->showLibelleProduit($id);
	$prixDetail=$vte->showPrixDetailProduit($id);
	$stock=$prod->showStockProduit2($id);
}

if(isset($_POST['code'])){
	$code=$_POST['code'];
	$date=$vte->nowDate();
	$heure=$vte->nowHour();
	$num=$_POST['idc'];
	$quantite=$_POST['quantite'];
	$prix=$_POST['pr'];
	$memory=$_POST['memoire'];
	$prix=$_POST['pr'];
	$color=$_POST['couleur'];
	$im=$_POST['imei'];
	$NumCli=$vte->showClientEncour();
	$civilite=$vte->showCiviliteClientEncour();
	$clientDetail=$vte->showClientDetailEncour();
	$user=$_SESSION['id'];

	$priTotal = $quantite*$prix;
	$NumVte=$vte->showNumVteDetEncour();
   
	$vte->setNumVenteDetail($NumVte);
	$vte->setIdUser($user);
	$vte->setNumClient($NumCli);
    $vte->setCodeProd($code);
    $vte->setIdCommande($num);
    $vte->setDateVente($date);
    $vte->setHeureVente($heure);
    $vte->setQuantite($quantite);
    $vte->setPrixGros($prix);
    $vte->setPrixTotal($priTotal);
    $vte->setMontPayer(0);
    $vte->setTypeVente("En detail");
    $vte->setEtatTelephone("Bon état");
    $vte->setCouleurTelephone($color);
    $vte->setMemoireTelephone($memory);
    $vte->setEtatVte("Now");
    $vte->setIMEI($im);
    $vte->setCiviliteClient($civilite);
    $vte->setClientDetail($clientDetail);
    $vte->setConfirmationVente("NON VERSE");
    $vte->Ajouter();
    $vte->updateStockProduitVteDet($quantite,$code);
    //$vte->updateClientVte($NumCli);

    header('location:VendreProduitDetailBis.php?id='.$num);
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
		<div class="span2"></div>
		<div class="span7">
			<h1 style="color: white;">Formulaire de vente de téléphones en détail</h1>
		</div>
		<div class="span3">
			<h1 style="color: red;">Total : <?php echo strrev(wordwrap(strrev((int)$total), 3, ' ', true));?></h1>
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
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Formulaires de vente de produit en détail : <em style="color: yellow">Prix de vente = <?php echo strrev(wordwrap(strrev((int)$prixDetail), 3, ' ', true)) ?></em> - Commande N° : <em><?php echo $numCom; ?></em></h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
			<form class="form-horizontal" method="POST" action="FormVenteDetailBis.php" style="background-color: #B0E0E6">
				  <fieldset>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" required="true" value="<?php echo $id;?>">
						  <input type="hidden" name="idc" value="<?php echo $numero;?>">
						</div>
				    </div>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="prix"  required="true" value="<?php echo $prixDetail;?>">
						</div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Produit</label>
					       <div class="controls">
					        <input type="text" name="prod"  readonly="true" value="<?php echo $lib;?>" required="true" >
					       </div>
				    </div>
				    <div class="control-group info">
				    <label class="control-label">Mémoire du téléphone</label>
				       <div class="controls">
				        <select id="selectError3" required="true" name="memoire" data-rel="chosen">
						    <option></option>
						    <option>1 Go</option>
						    <option>2 Go</option>
							<option>4 Go</option>
							<option>8 Go</option>
							<option>16 Go</option>
							<option>32 Go</option>
							<option>64 Go</option>
							<option>128 Go</option>
							<option>Autre</option>
						  </select>
				       </div>
			        </div>
				    <div class="control-group info">
					    <label class="control-label">Quantité</label>
					       <div class="controls">
					        <input type="number" min="1" max="<?php echo $stock;?>" required="true" name="quantite">
					       </div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Prix remise</label>
					       <div class="controls">
					        <input type="number" required="true" name="pr">
					       </div>
				    </div>
				    <div class="control-group info">
				    <label class="control-label">Couleur du téléphone</label>
				       <div class="controls">
				        <select id="selectError" required="true" name="couleur" data-rel="chosen">
						    <option></option>
						    <option>Blanc</option>
							<option>Noir</option>
							<option>Rouge</option>
							<option>Bleu</option>
							<option>Vert</option>
							<option>Orange</option>
							<option>Jaune</option>
							<option>Marron</option>
							<option>Or</option>
							<option>Argent</option>
							<option>Cafe</option>
							<option>Autre</option>
						  </select>
				       </div>
			        </div>
				    <div class="control-group info">
					    <label class="control-label">L'IMEI du téléphone</label>
					       <div class="controls">
					        <input type="number" minlength="14" required="true" name="imei">
					       </div>
				    </div>
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
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