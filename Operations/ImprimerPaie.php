<?php
session_start();
if(!(isset($_SESSION['niveau']))){
  header('location:../index.php');
}
  require_once('../classes/paiement.php');
  $p = new paiement();

  if(isset($_GET['id'])){
  $idpaie=$_GET['id'];
  $mois=$p->MoisPaie($idpaie);
  $IdmoisFin=$p->MoisPaieFinal($idpaie);
  $moisFin=$p->ShowNextMonth($IdmoisFin);

  $annee=$p->AnneePaie($idpaie);
  $commission=$p->CommissionPaie($idpaie);
  $action=$p->IdActionPaie($idpaie);
  $nom=$p->showNomActionnaire($action);
  $prenom=$p->showPrenomActionnaire($action);
  $solde=$p->showSoldeActionnaire($action);

  $p->updateEtatPaiement($idpaie);
}
  

  //$solde=$p->showSoldeClient($numCli);

  ob_start();
?>
<style  type="text/css">
  table{border-collapse:collapse;width:100%;color:#717375;font-size:13;font-family:helvetica;line-height:6mm}
  table strong {color:#000;}
  table.mabordure td{ border:1px solid #CFD1D2; padding: 1mm 1mm}
  table.mabordure th{background:#C0C0C0; color:#FFF; font-weight:normal; padding: 1mm 1mm}
  p{margin:0; padding:2mm 0;}
</style>
<page backtop="30mm" backleft="10mm" backright="10mm" backbottom="10mm">
<page_header>
  
</page_header>

<page_footer>
  <hr/>
   <p>&copy; Ets RIKOMEDO vous remercie pour votre fidélité &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   Reçu établi le : <?php echo date("d-m-Y H:i");?> </p>
</page_footer>

<table border="1">
  <tr>
      <td style="width:50%"><strong>ETS RIKOMEDO</strong> <br>
      <strong>TEL : (+228) 93 60 22 14 / (+228) 98 79 34 95 </strong><br>
      <strong>Email : info@rikomedo.com </strong>
      </td>
      <td style="width:50%;"><img src="../images/logo.PNG">
    </td>
  </tr>
  <?php if($mois==$moisFin){ ?>
  <tr>
    <td colspan="2" style="width:100%"><strong>PAIEMENT DE COMMISSION DE : <?php echo $mois.' '.$annee ?> </strong></td>
  </tr>
 <?php }else{ ?>
  <tr>
    <td colspan="2" style="width:100%"><strong>PAIEMENT DE COMMISSION DU MOIS DE : <?php echo $mois ;?> À <?php echo $moisFin.' '.$annee ?> </strong></td>
  </tr>
<?php } ?>
  <tr>
    <td style="width:50%"><strong>Nom :</strong><br> <?php echo $nom ?> </td>
    <td style="width:50%"><strong>Prénoms : </strong><br> <?php echo $prenom ?></td>
  </tr>
  <tr>
    <td style="width:50%"><strong>Solde :</strong><br> <?php echo strrev(wordwrap(strrev((int)$solde), 3, ' ', true)) ?> </td>
    <td style="width:50%"><strong>Commission : </strong><br> <?php echo strrev(wordwrap(strrev((int)$commission), 3, ' ', true));?></td>
  </tr>
  <tr>
    <td style="width:50%"><strong>Signature du client</strong><br><br><br><br></td>
    <td style="width:50%"><strong>Signature du responsable</strong><br><br><br><br></td>
  </tr>
</table>
<h2 style="color: #C0C0C0">-------------------------------------------------------------------------------------</h2>
<table border="1">
  <tr>
      <td style="width:50%"><strong>ETS RIKOMEDO</strong> <br>
      <strong>TEL : (+228) 93 60 22 14 / (+228) 98 79 34 95 </strong><br>
      <strong>Email : info@rikomedo.com </strong>
      </td>
      <td style="width:50%;"><img src="../images/logo.PNG">
    </td>
  </tr>
  <?php if($mois==$moisFin){ ?>
  <tr>
    <td colspan="2" style="width:100%"><strong>PAIEMENT DE COMMISSION DE : <?php echo $mois.' '.$annee ?> </strong></td>
  </tr>
 <?php }else{ ?>
  <tr>
    <td colspan="2" style="width:100%"><strong>PAIEMENT DE COMMISSION DU MOIS DE : <?php echo $mois ;?> À <?php echo $moisFin.' '.$annee ?> </strong></td>
  </tr>
<?php } ?>
  <tr>
    <td style="width:50%"><strong>Nom :</strong><br> <?php echo $nom ?> </td>
    <td style="width:50%"><strong>Prénoms : </strong><br> <?php echo $prenom ?></td>
  </tr>
  <tr>
    <td style="width:50%"><strong>Solde :</strong><br> <?php echo strrev(wordwrap(strrev((int)$solde), 3, ' ', true)) ?> </td>
    <td style="width:50%"><strong>Commission : </strong><br> <?php echo strrev(wordwrap(strrev((int)$commission), 3, ' ', true));?></td>
  </tr>
  <tr>
    <td style="width:50%"><strong>Signature du client</strong><br><br><br><br></td>
    <td style="width:50%"><strong>Signature du responsable</strong><br><br><br><br></td>
  </tr>
</table>
</page>
<?php
 $content= ob_get_clean() ;

require '../html2pdf/html2pdf.class.php';
 try{
   $pdf=new HTML2PDF('P','A4','fr');
   $pdf->pdf->setDisplayMode('fullpage');
   $pdf->writeHTML($content);
   $pdf->output('test.pdf');
 
 }catch(HTML2PDF_exception $ex){
 die($ex);
 }
 