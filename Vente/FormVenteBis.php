<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/vente.php');
require_once('../classes/produit.php');
require_once('../classes/encaissement.php');
require_once('../classes/approvisionnement.php');
require_once('../classes/commande.php');
$vte = new vente();
$prod = new produit();
$enc = new encaissement();
$appro = new approvisionnement();
$com = new commande();

$numero = $_GET['numero'];
$numCom=$appro->ShowNumCommande($numero);
$dateR=$appro->ShowDateCommande($numero);

$id=""; $lib="";

/*function first(){ 
if(isset($_GET['pif']))	{ 
$lg = strlen($_GET['pif']);
$cpt = 0;	
for($i = 0; $i < $lg; $i++){	
	if(substr($_GET['pif'], $i, 1)=='C'){
      break;
	}
	$cpt++;
  }
  return $cpt;
  }

}*/

if(isset($_GET['prod']))	{ 
$NumVte = $_GET['vente'];
$clien = $_GET['client'];
$id = $_GET['prod'];

/*$NumVte=substr($_GET['pif'], 0, first());
$clien=substr($_GET['pif'], first(),7);
$id=substr($_GET['pif'], first()+7);*/

$total=$vte->showTotalVteCouranteCli($_SESSION['id'],$clien);

$row=$prod->getOne($id);
$lib=$vte->showLibelleProduit($id);
$prixDetail=$vte->showPrixDetailProduit($id);
$stock=$prod->showStockProduit($id);
$soldeEncours=$enc->showSoldeClient($clien);


/*if(isset($_GET['pif']))	{ 
$NumVte=substr($_GET['pif'], 0, first());
$clien=substr($_GET['pif'], first(),7);
$id=substr($_GET['pif'], first()+7);

$total=$vte->showTotalVteCouranteCli($clien);
$row=$prod->getOne($id);
$lib=$vte->showLibelleProduit($id);
$prixDetail=$vte->showPrixDetailProduit($id);
$stock=$prod->showStockProduit($id);
$soldeEncours=$enc->showSoldeClient($clien);*/

}

//$numCom=$appro->LastNumCommande();
//$IdCom=$appro->LastIdCommande();

if(isset($_POST['send'])){	
	$code=$_POST['code'];
	$date=$vte->nowDate();
	$heure=$vte->nowHour();
	$num=$_POST['idc'];
	$quantite=$_POST['quantite'];
	$prix=$_POST['prix'];
	$type=$_POST['type'];
	$client=$_POST['cli'];
	$NumVte=$_POST['vente'];
	$user=$_SESSION['id']; 

	$solde=$vte->showSoldeBisVente($client);

	$priTotal = $quantite*$prix;
   
    $vte->setNumVente($NumVte);
    $vte->setIdUser($user);
	$vte->setNumClient($client);
    $vte->setCodeProd($code);
    $vte->setIdCommande($num);	
    $vte->setDateVente($date);
    $vte->setHeureVente($heure);
    $vte->setPrixGros($prix);
    $vte->setQuantite($quantite);
    $vte->setPrixTotal($priTotal);
    $vte->setMontPayer(0);
    $vte->setTypeVente("En gros");
    $vte->setEtatTelephone($type);
    $vte->setEtatVte("Now");
    $vte->setSoldeVente($solde+$priTotal);
    $vte->setConfirmationVente("NON VERSE");
    $vte->Ajouter();
    $vte->updateStockProduitVte($quantite,$code);
    header('location:ChoixCommandeBis.php?client='.$client.'&vente='.$NumVte.'&numero='.$num);
	
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
			<h1 style="color: white;">Formulaire de vente de téléphones en gros</h1>
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
				<h2><i class="halflings-icon edit"></i><span class="break"></span><strong><em style="color: yellow;">Prix de vente en détail = <?php echo strrev(wordwrap(strrev((int)$prixDetail), 3, ' ', true)) ?> </em></strong>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong><em style="color: blue;">Solde du client = <?php echo strrev(wordwrap(strrev((int)$soldeEncours), 3, ' ', true)) ?> </em></strong>

				</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" action="FormVenteBis.php" style="background-color: #B0E0E6">
				  <fieldset>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="code" required="true" value="<?php echo $id;?>">
						  <input type="hidden" name="vente" required="true" value="<?php echo $NumVte;?>">
						  <input type="hidden" name="idc" value="<?php echo $numero;?>">
						</div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Produit</label>
					       <div class="controls">
					        <input type="text" name="prod"  readonly="true" value="<?php echo $lib;?>" required="true" >
					       </div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Numéro commande</label>
					       <div class="controls">
					        <input type="text" readonly="true" value="<?php echo $numCom.' '.$dateR;?>" required="true" >
					       </div>
				    </div>
				    <div class="control-group info">
				    <label class="control-label">Etat du téléphone</label>
				       <div class="controls">
				        <select id="selectError" required="true" name="type" data-rel="chosen">
						    <option></option>
						    <option>BON ETAT</option>
							<option>ECRAN CASSE</option>
							<option>SANS BAT</option>
							<option>SANS COUVERCLE</option>
							<option>NI BAT NI COUV</option>
							<option>VIT CAM CASSEE</option>
							<option>BOUT CHARGE DEF</option>
							<option>TOUCHE ALL DEF</option>
							<option>CAM DEF</option>
							<option>TOUCHE VOL DEF</option>
							<option>COQ ARR CAB</option>
							<option>CHAS FIS</option>
							<option>WIFI BLUET ABS</option>
							<option>RESEAU ABSENT</option>
							<option>TACTILE CASSE</option>
							<option>COUVERCLE FIS</option>
							<option>DEFECTUEUX</option>
							<option>ECRAN TACH</option>
						  </select>
				       </div>
			        </div>
			        <div class="control-group info">
					    <label class="control-label">Prix</label>
					       <div class="controls">
					        <input type="number" required="true" name="prix">
					       </div>
				    </div>
				    <div class="control-group info">
					    <label class="control-label">Quantité</label>
					       <div class="controls">
					        <input type="number" min="1" max="<?php echo $stock;?>" required="true" name="quantite">
					       </div>
				    </div>
				    <div class="control-group info">
						<label class="control-label"></label>
						<div class="controls">
						  <input type="hidden" name="cli" required="true" value="<?php echo $clien;?>">
						</div>
				    </div>
				    <div class="form-actions">
					  <button type="submit" name="send" class="btn btn-primary">Enregistrer</button>
					  <a class="btn btn-info" href="VendreProduitBis.php">Retour à la liste</a>
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