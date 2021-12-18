<?php
session_start();
if(!(isset($_SESSION['niveau']))){
  header('location:../index.php');
}
  require_once('../classes/vente.php');
  $vte = new vente();

  //$facture=$vte->PrixTotalFacture();
  //$net=$vte->PrixTotalNet();
  //$Reste=$vte->TotalResteApayer();

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
    <td style="background-color:#C0C0C0;width:100%"><h4 style="color:white;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RAPPORT GENERAL DES VENTES DE LA JOURNEE DU <?php echo date("d-m-Y");?></h4></td>
  </tr>
</table>

<table style="margin-top:5mm;" class="mabordure">
        <thead>
            <tr>
                <th style="width:20%">Nom</th>
                <th style="width:20%">Prénoms</th>
                <th style="width:20%">Montant facture</th>
                <th style="width:20%">Montant payé</th>
                <th style="width:20%">Reste à payer</th>
            </tr>
        </thead>
        <tbody>
        <?php
          $facture=0;
          $mont=0;
          $solde=0; 
         $list=$vte->SommeListerVenteJour();
          foreach ($list as $v) {
          $facture=$facture+$v['total'];
          $mont=$mont+$v['paye'];
          $solde=$solde+$v['reste'];
          ?>
            <tr>
            <td> <?php echo $v['NOM_CLI'];?></td>
              <td> <?php echo $v['PRENOM_CLI'];?></td>
            <td> <?php echo strrev(wordwrap(strrev($v['total']), 3, ' ', true));?></td>
            <td> <?php echo strrev(wordwrap(strrev($v['paye']), 3, ' ', true));?></td>
            <td> <?php echo strrev(wordwrap(strrev($v['reste']), 3, ' ', true));?></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="2">Totaux</td>
              <td style="background-color: #FFFFF0;"><?php echo strrev(wordwrap(strrev($facture), 3, ' ', true));?></td>
              <td style="background-color: #FFFFF0;"><?php echo strrev(wordwrap(strrev($mont), 3, ' ', true));?></td>
              <td style="background-color: #FFFFF0;"><?php echo strrev(wordwrap(strrev($solde), 3, ' ', true));?></td>
            </tr>
        </tbody>
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
 