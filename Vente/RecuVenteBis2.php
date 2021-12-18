<?php
session_start();
if(!(isset($_SESSION['niveau']))){
  header('location:../index.php');
}
  require_once('../classes/vente.php');
  $vte = new vente();
    
    $numCli=substr($_GET['client'], 0,7);
    $NumVte=substr($_GET['client'], 8);

    $solde=$vte->showSoldeClient($numCli);

    $montant=$vte->showLasTMontantBis($NumVte);
    $nom=$vte->showLasTNomClient($numCli);
    $prenom=$vte->showLasTPrenomClient($numCli);

    $date = ucfirst(strftime('%A, le %d' ));
    $date .= ucfirst(strftime('%B %Y' ));
  
  ob_start();
?>
<style  type="text/css">
  table{border-collapse:collapse;width:100%;color:#717375;font-size:13;font-family:helvetica;line-height:6mm}
  table strong {color:#000;}
  table.mabordure td{ border:1px solid #CFD1D2; padding: 1mm 1mm}
  table.mabordure th{background:#C0C0C0; color:#FFF; font-weight:normal; padding: 1mm 1mm}
  p{margin:0; padding:2mm 0;}
</style>
<page backtop="40mm" backleft="10mm" backright="10mm" backbottom="30mm">
<page_header>
  <table style="margin-left:10mm;margin-right:10mm;">
  <tr>
      <td style="width:50%"><strong>ETS RIKOMEDO</strong> <br>
      <strong>TEL : (+228) 93 60 22 14 / (+228) 98 79 34 95 </strong><br>
      <strong>Email : info@rikomedo.com </strong>
      </td>
      <td style="width:50%;"><img src="../images/logo.PNG">
    </td>
  </tr>
</table>
</page_header>

<page_footer>
  <hr/>
   <p>&copy; Ets RIKOMEDO vous remercie pour votre fidélité &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   Reçu établi le : <?php echo date("d-m-Y H:i");?> </p>
</page_footer>
<table style="margin-top:15mm;">
  <tr>
    <td style="width:100%"><h4><u>Reçu de vente de Mr. <?php echo $nom.' '.$prenom; ?></u></h4></td>
  </tr>
</table>
<table style="margin-top:2mm; " class="mabordure">
        <thead>
            <tr>
                <th style="width:30%">Produit</th>
                <th style="width:30%">Etat</th>
                <th style="width:15%">Quantité</th>
                <th style="width:15%">Prix unitaire</th>
                <th style="width:10%">Prix total</th>
            </tr>
        </thead>
        <tbody>
        <?php 
         $total2=0;
         $total3=0;
         $list=$vte->ImprimerAchatClient2($numCli,$NumVte);    
         foreach ($list as $v) {
          $total2=$total2 + ($v['QTE_VENTE']*$v['PRIX_GROS']);
          $total3=$total3 + $v['QTE_VENTE'];
          ?>
            <tr>
                  <td> <?php echo $v['LIBELLE_PROD'];?></td>
                  <td> <?php echo $v['ETAT_TELEPHONE'];?></td>
                  <td> <?php echo $v['QTE_VENTE'];?></td>
                  <td> <?php echo strrev(wordwrap(strrev($v['PRIX_GROS']), 3, ' ', true));?></td>
                  <td> <?php echo strrev(wordwrap(strrev($v['PRIX_TOTAL']), 3, ' ', true));?></td>
            </tr>
            <?php }?>
            <tr>
               <td colspan="4"><strong>TOTAL ACHAT : </strong></td>
               <td><strong><?php echo strrev(wordwrap(strrev($total2), 3, ' ', true)); ?></strong></td>
            </tr>
             <tr>
               <td colspan="4"><strong>Montant payé : </strong></td>
               <td><strong><?php echo strrev(wordwrap(strrev($montant), 3, ' ', true)); ?></strong></td>
             </tr>
             <tr>
               <td colspan="4"><strong>Quantité totale : </strong></td>
               <td><strong><?php echo strrev(wordwrap(strrev($total3), 3, ' ', true)); ?></strong></td>
             </tr>
             <tr>
               <td colspan="4"><strong>Solde du client : </strong></td>
               <td><strong><?php echo strrev(wordwrap(strrev($solde), 3, ' ', true)); ?></strong></td>
             </tr>
        </tbody>
     </table>
     <h5 style="color:#C0C0C0"><u>NB</u>: Tout produit acheté doit être vérifié avant de sortir du magasin. En conséquence aucune réclamation ne sera acceptée pour les produits retournés. <br><br> Merci pour votre bonne compréhension.</h5>
    
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
 