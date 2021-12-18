
<?php 
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
	
require_once('../classes/vente.php');
$vte = new vente();

//$total = $vte->showTotalVteRollback($id);
//$client = $vte->showClientVteRollback($id);
//$vte->updateSoldeMAVteRollback($total,$id,$client);

$id = $_GET['id'];
$qte = $vte->showQteVendu($id);
$idProd = $vte->showIdProduit($id);
$typeVte = $vte->showTypeVente($id);
$vte->delete($id);
if($typeVte == "En gros"){
  $vte->updateStockProdDelVte($qte,$idProd);	
}else{
    $n = $vte->updateStockProdDelVteDet($qte,$idProd);
}
header('location:Rollback.php');

 ?>