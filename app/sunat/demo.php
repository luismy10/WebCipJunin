<?php

require 'lib/dompdf/vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

$html = ' <div id="content">
  
<div class="page" style="font-size: 7pt">
<table style="width: 100%;" class="header">
<tbody><tr>
<td><h1 style="text-align: left">SCHEDULE A</h1></td>
<td><h1 style="text-align: right">Job: 132-003</h1></td>
</tr>
</tbody></table>

<table style="width: 100%; font-size: 8pt;">
<tbody><tr>
<td>Job: <strong>132-003</strong></td>
<td>Purchasers(s): <strong>Palmer</strong></td>
</tr>

<tr>
<td>Created: <strong>2004-08-13</strong></td>
<td>Last Change: <strong>2004-08-16  9:28 AM</strong></td>
</tr>

<tr>
<td>Address: <strong>667 Pine Lodge Dr.</strong></td>
<td>Legal: <strong>N/A</strong></td>
</tr>
</tbody></table>

<table style="width: 100%; border-top: 1px solid black; border-bottom: 1px solid black; font-size: 8pt;">

<tbody><tr>
<td>Model: <strong>Franklin</strong></td>
<td>Elevation: <strong>B</strong></td>
<td>Size: <strong>1160 Cu. Ft.</strong></td>
<td>Style: <strong>Reciprocating</strong></td>
</tr>

</tbody></table>

<table class="change_order_items">

<tbody><tr><td colspan="6"><h2>Standard Items:</h2></td></tr>

</tbody><tbody>
<tr>
<th>Item</th>
<th>Description</th>
<th>Quantity</th>
<th colspan="2">Unit Cost</th>
<th>Total</th>
</tr>

<tr class="even_row">
<td style="text-align: center">1</td>
<td>Sprockets (13 tooth)</td>
<td style="text-align: center">50</td>
<td style="text-align: right; border-right-style: none;">$10.00</td>
<td class="change_order_unit_col" style="border-left-style: none;">Ea.</td>
<td class="change_order_total_col">$5,000.00</td>
</tr>


<tr class="odd_row">
<td style="text-align: center">2</td>
<td>Cogs (Cylindrical)</td>
<td style="text-align: center">45</td>
<td style="text-align: right; border-right-style: none;">$25.00</td>
<td class="change_order_unit_col" style="border-left-style: none;">Ea.</td>
<td class="change_order_total_col">$1125.00</td>
</tr>

<tr class="even_row">
<td style="text-align: center">3</td>
<td>Gears (15 tooth)</td>
<td style="text-align: center">32</td>
<td style="text-align: right; border-right-style: none;">$19.00</td>
<td class="change_order_unit_col" style="border-left-style: none;">Ea.</td>
<td class="change_order_total_col">$608.00</td>
</tr>

<tr class="odd_row">
<td style="text-align: center">4</td>
<td>Leaf springs (13 N/m)</td>
<td style="text-align: center">6</td>
<td style="text-align: right; border-right-style: none;">$125.00</td>
<td class="change_order_unit_col" style="border-left-style: none;">Ea.</td>
<td class="change_order_total_col">$750.00</td>
</tr>

<tr class="even_row">
<td style="text-align: center">5</td>
<td>Coil springs (6 N/deg)</td>
<td style="text-align: center">7</td>
<td style="text-align: right; border-right-style: none;">$11.00</td>
<td class="change_order_unit_col" style="border-left-style: none;">Ea.</td>
<td class="change_order_total_col">$77.00</td>
</tr>

</tbody>




<tbody><tr>
<td colspan="3" style="text-align: right;">(Tax is not included; it will be collected on closing.)</td>
<td colspan="2" style="text-align: right;"><strong>GRAND TOTAL:</strong></td>
<td class="change_order_total_col"><strong>$7560.00</strong></td></tr>
</tbody></table>

<table class="sa_signature_box" style="border-top: 1px solid black; padding-top: 2em; margin-top: 2em;">

  <tbody><tr>    
    <td>WITNESS:</td><td class="written_field" style="padding-left: 2.5in">&nbsp;</td>
    <td style="padding-left: 1em">PURCHASER:</td><td class="written_field" style="padding-left: 2.5in; text-align: right;">X</td>
  </tr>
  <tr>
    <td colspan="3" style="padding-top: 0em">&nbsp;</td>
    <td style="text-align: center; padding-top: 0em;">Mr. Leland Palmer</td>
  </tr>

<tr><td colspan="4" style="white-space: normal">
This change order shall have no force or effect until approved and signed
by an authorizing signing officer of the supplier.  Any change or special
request not noted on this document is not contractual.
</td>
</tr>

<tr>
<td colspan="2">ACCEPTED THIS
<span class="written_field" style="padding-left: 4em">&nbsp;</span>
DAY OF <span class="written_field" style="padding-left: 8em;">&nbsp;</span>, 
20<span class="written_field" style="padding-left: 4em">&nbsp;</span>.
</td>

<td colspan="2" style="padding-left: 1em;">TWIN PEAKS SUPPLY LTD.<br><br>
PER: 
<span class="written_field" style="padding-left: 2.5in">&nbsp;</span>
</td>
</tr>
</tbody></table>

</div>

</div> ';

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

exit(0);
