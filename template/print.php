<?php



//============================================================+

// File name   : example_001.php

// Begin       : 2008-03-04

// Last Update : 2013-05-14

//

// Description : Example 001 for TCPDF class

//               Default Header and Footer

//

// Author: Nicola Asuni

//

// (c) Copyright:

//               Nicola Asuni

//               Tecnick.com LTD

//               www.tecnick.com

//               info@tecnick.com

//============================================================+



/**

 * Creates an example PDF TEST document using TCPDF

 * @package com.tecnick.tcpdf

 * @abstract TCPDF - Example: Default Header and Footer

 * @author Nicola Asuni

 * @since 2008-03-04

 */

  require_once('../inc/tcpdf/examples/tcpdf_include.php');

  include "../inc/tcpdf/tcpdf.php";

  $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );

require_once( $parse_uri[0] . 'wp-load.php' );

if(!is_user_logged_in ()){

  wp_redirect( wp_login_url()); exit; 

}

if(isset($_GET['id'])){

  $id = $_GET['id'];

  global $wpdb;

    $result = $wpdb->get_results("SELECT * From  wp_info_order join wp_order on wp_info_order.id = wp_order.idCustomer where wp_order.id=".$id,OBJECT);

}

// Include the main TCPDF library (search for installation path).





// create new PDF document

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Nicola Asuni');

$pdf->SetTitle('MtFujidenver-Export to PDF');

$pdf->SetSubject('TCPDF Tutorial');

$pdf->SetKeywords('TCPDF, PDF, example, test, guide');



// set default header data

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

$pdf->setFooterData(array(0,64,0), array(0,64,128));



// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// set default monospaced font

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set margins

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



// set image scale factor

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// set some language-dependent strings (optional)

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {

  require_once(dirname(__FILE__).'/lang/eng.php');

  $pdf->setLanguageArray($l);

}



// ---------------------------------------------------------



// set default font subsetting mode

$pdf->setFontSubsetting(true);



// Set font

// dejavusans is a UTF-8 Unicode font, if you only need to

// print standard ASCII chars, you can use core fonts like

// helvetica or times to reduce file size.

$pdf->SetFont('dejavusans', '', 9, '', true);



// Add a page

// This method has several options, check the source code documentation for more information.

$pdf->AddPage();



// set text shadow effect

$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));



// Set some content to print

/*$html = <<<EOD

<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>

<i>This is the first example of TCPDF library.</i>

<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>

<p>Please check the source code documentation and other examples for further information.</p>

<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>

EOD;

echo $html;*/



// Print text using writeHTMLCell()

$html1 = <<<EOD

 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tbody><tr>

    <td height="25" align="center" bgcolor="#F0F0F0" style="font-size:14px; font-weight:bold; line-height:25px;">Order Information</td>

  </tr>

</tbody></table> 

EOD;

    

    $pdf->writeHTML($html1, true, false, false, false, "");

    $html2 = "";

    $html2 .= "<table width=\"100%\" border=\"1\" align=\"center\">";

    $html2 .="<tbody><tr height=\"60\">

    <td width=\"60%\" height=\"30\" style=\"font-size:14px; font-weight:bold; line-height:30px\">&nbsp;&nbsp;Dish</td>

    <td width=\"5%\" height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">Qty</td>

    <td width=\"10%\" height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">Price</td>

    <td width=\"25%\" height=\"30\" style=\"font-size:14px; font-weight:bold;line-height:30px\">&nbsp;Notes</td>

  </tr>";

    $result = $wpdb->get_results("SELECT * From  wp_order_detail where wp_order_detail.idOrder=".$id,OBJECT);

    $subtotal =0;

    foreach($result as $row){

      ////var_dump($row);

      $html2.="<tr>

          <td height=\"30\" align=\"left\" style=\"font-size:10px; font-weight:bold;line-height:30px;\">&nbsp;&nbsp;".$row->nameProduct."</td>

          <td align=\"center\" height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">".$row->quanlity."</td>

          <td align=\"center\" height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">".$row->price."$</td>

          <td height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">".$row->note."</td>

        </tr>";

        $subtotal += $row->price*$row->quanlity;

    }

    $html2 .="</tbody></table>";

$pdf->writeHTML($html2, true, false, false, false, '');

$tax = $subtotal*8.1/100;

$total = $subtotal + $tax;

    $html1 = "

  <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">

  <tbody><tr>

    <td>&nbsp;</td>

  </tr>

</tbody></table>



<table width=\"100%\" border=\"1\" align=\"center\">

  <tbody><tr>

    <td width=\"30%\" height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">&nbsp;&nbsp;Sub Total:</td>

    <td width=\"70%\" height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">&nbsp;&nbsp;".$subtotal."$</td>

  </tr>

  <tr>

    <td height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">&nbsp;&nbsp;Sales Tax(8.1%): </td>

    <td height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">&nbsp;&nbsp;".number_format((float)$tax, 2, '.', '')."$</td>

  </tr>

  <tr>

    <td height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">&nbsp;&nbsp;Total:</td>

    <td height=\"30\" align=\"center\" style=\"font-size:14px; font-weight:bold;line-height:30px\">&nbsp;&nbsp;".number_format((float)$total, 2, '.', '')."$</td>

  </tr>

</tbody></table>";

    $pdf->writeHTML($html1, true, false, false, false, "");



$html ="";

$html .= "<table width=\"99%\"  align=\"center\" bgcolor=\"#CCCCCC\" style=\"margin:30px 0px;\">

  <tbody>";

  $result = $wpdb->get_results("SELECT * From  wp_info_order join wp_order on wp_info_order.id = wp_order.idCustomer where wp_order.id=".$id,OBJECT);

foreach($result as $row){

$html .="<tr>

    <td height=\"25\" bgcolor=\"#FFFFFF\" style=\"color:#000000; font-size:14px;\" align=\"center\"><strong style=\"color:#000000;\">

    Ready Time:</strong>&nbsp;&nbsp;".$row->ready_time."<br><strong style=\"color:#000000;\">

    Order Type:</strong>&nbsp;&nbsp; ".$row->order_type."<br>

    <strong style=\"color:#000000;\">Date: ".$row->created."</strong>

    <br>------------------------------------------------------<br>

    <strong style=\"color:#000000; text-align:center;\">

    Customer Information:</strong><br><strong style=\"color:#000000;\">

    Name:</strong>&nbsp;&nbsp;".$row->name."<br><strong style=\"color:#000000;\">

    Tel:</strong>&nbsp;&nbsp;".$row->tel."<br><strong style=\"color:#000000;\">

    Address:</strong>&nbsp;&nbsp;".$row->address."

    <br>------------------------------------------------------<br>

    <strong style=\"color:#000000;\">

    Payment Method:</strong>&nbsp;&nbsp;".$row->payment."<br>

    <strong style=\"color:#000000;\">

    Credit Card Number:</strong>&nbsp;&nbsp;".$row->card_number."<br><strong style=\"color:#000000;\">

    Expiration Date:</strong>&nbsp;&nbsp;".$row->expiration_date."<br><strong style=\"color:#000000;\">

    Csv Code:</strong>&nbsp;&nbsp;".$row->csv_code."<br><strong style=\"color:#000000;\">

    Zip Code:</strong>&nbsp;&nbsp;".$row->zipcode_card."

    <br>------------------------------------------------------<br>

    <strong style=\"color:#000000;\">Remark:</strong>&nbsp;&nbsp;".$row->remark." </td>

  </tr>

  ";

  }

$html .= "</tbody></table>";

$pdf->writeHTML($html, true, false, false, false, '');









// ---------------------------------------------------------



// Close and output PDF document

// This method has several options, check the source code documentation for more information.

//Change To Avoid the PDF Error 

ob_end_clean();

//$pdf->Output('example_001.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

echo $html;

// Print

// if($_GET['print'] == true){

?>

<script type="text/javascript">

  javascript:window.print();

</script>

<?php

// }