<?php
session_start();
if(!(isset($_SESSION['niveau']))){
  header('location:../index.php');
}
  require_once('../classes/encaissement.php');
  $enc = new encaissement();

  $total=$enc->showTotalEncaissementJour();

  ob_start();
?>
<style  type="text/css">
  table{border-collapse:collapse;width:100%;color:#717375;font-size:13;font-family:helvetica;line-height:6mm}
  table strong {color:#000;}
  table.mabordure td{ border:1px solid #CFD1D2; padding: 1mm 1mm}
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
    <td style="background-color:#C0C0C0;width:100%"><h4 style="color:white;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RAPPORT DES ENCAISSEMENTS DE LA JOURNEE DU <?php echo date("d-m-Y");?> </h4></td>
  </tr>
</table>
<h1 style="color:#C0C0C0">TOTAL : <?php echo strrev(wordwrap(strrev($total), 3, ' ', true)); ?></h1>

<table style="margin-top:5mm;" class="mabordure">
        <thead>
            <tr>
                <th style="width:10%">ID</th>
                <th style="width:30%">Client</th>
                <th style="width:20%">Date</th>
                <th style="width:20%">Heure</th>
                <th style="width:20%">Montant encaissé</th>
                
            </tr>
        </thead>
        <tbody>
        <?php 
         $list=$enc->ListerTout();
          foreach ($list as $v) {?>
            <tr>
                  <td><?php echo $v['ID_ENC'];?></td>
                  <td><?php echo $v['NOM_CLI'];?></td>
                  <td><?php echo $v['DATE_ENC'];?></td>
                  <td><?php echo $v['HEURE_ENC'];?></td>
                  <td><?php echo $v['MONT_ENC'];?></td>
                  
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
 