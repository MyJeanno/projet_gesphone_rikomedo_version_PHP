<?php
session_start();
if(!(isset($_SESSION['niveau']))){
  header('location:../index.php');
}
  require_once('../classes/approvisionnement.php');
  $appro = new approvisionnement();
  $debut=date_format(date_create(substr($_GET['d'], 0,10)), "d-m-Y");
  $fin=date_format(date_create(substr($_GET['d'], -10)), "d-m-Y");

  $total=$appro->TotalPeriodeApproDet(substr($_GET['d'], 0,10),substr($_GET['d'], -10));

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
    <td style="width:100%"><h4><u>RAPPORT DES APPROVISIONNEMENTS EN DETAIL DU <?php echo $debut;?> au <?php echo $fin;?></u></h4></td>
  </tr>
</table>
<h4 style="color:#C0C0C0">MONTANT TOTAL APPROVISIONNE : <?php echo strrev(wordwrap(strrev($total), 3, ' ', true));?></h4>
<table style="margin-top:2mm;" class="mabordure">
        <thead>
            <tr>
                <th style="width:20%">ID</th>
                <th style="width:60%">Produit</th>
                <th style="width:20%">Quantité</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $total=0; 
         $list=$appro->QteApproPeriodiqueDet(substr($_GET['d'], 0,10),substr($_GET['d'], -10));
          foreach ($list as $v) {
          $total=$total+$v['quantite'];
            ?>
            <tr>
                <td> <?php echo $v['CODE_PROD'];?></td>
                <td> <?php echo $v['LIBELLE_PROD'];?></td>
                <td> <?php echo $v['quantite'];?></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="2"><strong>Quantité totale</strong></td>
              <td><strong><?php echo $total; ?></strong></td>
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
 