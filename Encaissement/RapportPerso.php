<?php
session_start();
if(!(isset($_SESSION['niveau']))){
  header('location:../index.php');
}
  require_once('../classes/vente.php');
  $vte = new vente();

  $debut=substr($_GET['id'], 0,10);
  $fin=substr($_GET['id'], 10,10);
  $num=substr($_GET['id'], 20);

  $nom=$vte->showLasTNomClient($num);
  $prenom=$vte->showLasTPrenomClient($num);
  $totAchat=$vte->showTotalAchatReleve($num,$debut,$fin);
  $totAchatPaye=$vte->showTotalPayeReleve($num,$debut,$fin);
  $totEncaissement=$vte->showTotalEncaisseReleve($num,$debut,$fin);
  $soldeActuel=$vte->showSoldeClient($num);

  $list=$vte->ListerFirstAchatReleve($num,$debut,$fin);
  
  $total = $list['PRIX_TOTAL'];
  $payer = $list['MONT_PAYE'];
  $solde = $list['SOLDE_VENTE'];

  if($total==null){
    $nouveau=$payer+$solde;
  }else{
       $nouveau=$solde-$total;
  }
  

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
<table style="margin-top:5mm;">
  <tr>
    <td style="width:70%">Nom & prénoms du client : <?php echo $nom." ".$prenom; ?> </td>
    <td style="width:30%">Numéro du client : <?php echo $num; ?></td>
  </tr>
</table>
<table style="margin-top:3mm;">
  <tr>
    <td style="width:100%"><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relevé personnel des achats du
    <?php echo date_format(date_create($debut),"d/m/Y"); ?> au <?php echo date_format(date_create($fin),"d/m/Y"); ?> </h4></td>
  </tr>
</table>
<table border="1">
  <tr>
    <td style="width:20%"><strong>Total achat</strong></td>
    <td style="width:20%"><strong>Total montant payé</strong></td>
    <td style="width:20%"><strong>Total encaissement</strong></td>
    <td style="width:20%"><strong>Solde actuel</strong></td>
    <td style="width:20%"><strong>Solde avant</strong></td>
  </tr>
  <tr>
    <td style="color: blue;"><?php echo strrev(wordwrap(strrev((int)$totAchat), 3, ' ', true)); ?></td>
    <td style="color: blue;"><?php echo strrev(wordwrap(strrev((int)$totAchatPaye), 3, ' ', true)); ?></td>
    <td style="color: blue;"><?php echo strrev(wordwrap(strrev((int)$totEncaissement), 3, ' ', true)); ?></td>
    <td style="color: red;"><?php echo strrev(wordwrap(strrev((int)$soldeActuel), 3, ' ', true)); ?></td>
    <td style="color: red;"><?php echo strrev(wordwrap(strrev((int)$nouveau), 3, ' ', true)); ?></td>
  </tr>
</table>

<table style="margin-top:5mm;" class="mabordure">
        <thead>
            <tr>
                <th style="width:10%">Date</th>
                <th style="width:10%">Heure</th>
                <th style="width:30%">Produit</th>
                <th style="width:10%">Prix</th>
                <th style="width:7%">Qté</th>
                <th style="width:10%">Prix total</th>
                <th style="width:13%">Mont payé</th>
                <th style="width:10%">Solde</th>
            </tr>
        </thead>
        <tbody>
        <?php 
         $list=$vte->ListerAchatReleve($num,$debut,$fin);
          foreach ($list as $v) {?>
            <tr>
                  <td><?php echo $v['DATE_VENTE'];?></td>
                  <td><?php echo $v['HEURE_VENTE'];?></td>
                  <td><?php echo $v['LIBELLE_PROD'];?></td>
                  <td><?php echo strrev(wordwrap(strrev($v['PRIX_GROS']), 3, ' ', true));?></td>
                  <td><?php echo strrev(wordwrap(strrev($v['QTE_VENTE']), 3, ' ', true));?></td>
                  <td><?php echo strrev(wordwrap(strrev($v['PRIX_TOTAL']), 3, ' ', true));?></td>
                  <td><?php echo strrev(wordwrap(strrev($v['MONT_PAYE']), 3, ' ', true));?></td>
                  <td><?php echo strrev(wordwrap(strrev($v['SOLDE_VENTE']), 3, ' ', true));?></td>
            </tr>
            <?php }?>
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
 