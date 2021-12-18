<?php
session_start();
if(!(isset($_SESSION['niveau']))){
  header('location:../index.php');
}
  require_once('../classes/vente.php');
  $vte = new vente();
    
    $num=$_GET['id'];
    $PTotal=$vte->showPTotalVte($num);
    $dateVte=$vte->showDatevente($num);
    $heureVte=$vte->showHeureVente($num);
    $montant=$vte->showLasTMontantDetail($num);
    $montantT=$vte->showLasTMontantDetailTotal($num);
    $enlettre = $vte->Conversion($montantT);
    $nom=$vte->showNomClientDetail($num);
    $civil=$vte->showCivilClientDetail($num);
  
  ob_start();
?>
<style  type="text/css">
  table{border-collapse:collapse;width:100%;color:#717375;font-size:13;font-family:helvetica;line-height:6mm}
  table strong {color:#000;}
  table.mabordure td{ border:2px solid #CFD1D2; font-size:11; padding: 1mm 1mm}
  table.mabordure th{background:#C0C0C0; color:#FFF; font-weight:normal; padding: 1mm 1mm}
  p{margin:0; padding:2mm 0;}
</style>
<page backtop="30mm" backleft="10mm" backright="10mm" backbottom="30mm">
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
    <td style="width:80%"><strong><u>Reçu de vente de <?php echo $civil.'  '.$nom; ?></u></strong></td>
    <td style="width:20%"><strong>Reçu N° : <?php echo "RI".$num; ?></strong></td>
  </tr>
</table>
<table>
  <tr>
    <td style="width:100%"><strong><u>Date vente</u> : <?php echo $dateVte.' à '.$heureVte; ?></strong></td>
  </tr>
</table>
<table style="margin-top:2mm; " class="mabordure">
        <thead>
            <tr>
                <th style="width:42%">Produit</th>
                <th style="width:15%">Couleur</th>
                <th style="width:15%">IMEI</th>
                <th style="width:5%">Qté</th>
                <th style="width:10%">P. unit</th>
                <th style="width:10%">Prix total</th>
            </tr>
        </thead>
        <tbody>
        <?php 
         $total2=0;
         $total3=0;
         $list=$vte->ImprimerVenteClientDetail($num);    
         foreach ($list as $v) {
          $total2=$total2 + ($v['QTE_VENTE']*$v['PRIX_GROS']);
          $total3=$total3 + $v['QTE_VENTE'];
          ?>
            <tr>
                  <td> <?php echo $v['LIBELLE_PROD'];?></td>
                  <td> <?php echo $v['COULEUR_TEL'];?></td>
                  <td> <?php echo $v['IMEI_TELEPHONE'];?></td>
                  <td> <?php echo $v['QTE_VENTE'];?></td>
                  <td> <?php echo strrev(wordwrap(strrev($v['PRIX_GROS']), 3, ' ', true));?></td>
                  <td> <?php echo strrev(wordwrap(strrev($v['PRIX_TOTAL']), 3, ' ', true));?></td>
            </tr>
            <?php }?>
            <tr>
               <td colspan="5"><strong>TOTAL ACHAT : </strong></td>
               <td><strong><?php echo strrev(wordwrap(strrev($PTotal), 3, ' ', true)); ?></strong></td>
            </tr>
             <tr>
               <td colspan="5"><strong>Montant payé : </strong></td>
               <td><strong><?php echo strrev(wordwrap(strrev($montant), 3, ' ', true)); ?></strong></td>
             </tr>
             <tr>
               <td colspan="5"><strong>Quantité totale : </strong></td>
               <td><strong><?php echo strrev(wordwrap(strrev($total3), 3, ' ', true)); ?></strong></td>
             </tr>
        </tbody>
     </table>
      <table style="margin-top:5mm; ">
      <tr>
        <td style="width:100%"><strong>Arrêté la présente facture à la somme de : <u><em><?php echo $enlettre.' '.'F CFA';?></em></u></strong></td>
      </tr>
    </table>
     <h5 style="color:#C0C0C0"><u>NB</u>: Les retours des produits sont autorisés dans un delai de 14 jours à compter de la date d'achat.<br><br> Merci pour votre bonne compréhension.</h5>
    
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
 