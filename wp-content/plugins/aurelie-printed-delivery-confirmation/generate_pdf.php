<?php
$order_id = $_POST['order_id'];
$logo = $_POST['logo'];
$title = $_POST['title'];
$greetings = $_POST['greetings'];
$thankyou = nl2br($_POST['thankyou']);
$footer = $_POST['footer'];
$shipping_address = $_POST['shipping_address'];
$address = $_POST['address'];
$info_account = $_POST['info_account'];
$info_order = $_POST['info_order'];
$info_invoice = $_POST['info_invoice'];
$info_date = $_POST['info_date'];
$info_side = $_POST['info_side'];
$bellow0 = nl2br($_POST['bellow0']);
$bellow1 = nl2br($_POST['bellow1']);
$bellow2 = nl2br($_POST['bellow2']);
$order_details = $_POST['order_details'];
$item_total = $_POST['item_total'];
$items_json = unserialize($_POST['items_json']);
$shipping_cost = $_POST['shipping_cost'];
$shipping_method = $_POST['shipping_method'];
$cart_subtotal = $_POST['cart_subtotal'];
$shipping_text = $_POST['shipping_text'];
$total_order = $_POST['total_order'];
$total_tax = $_POST['total_tax'];
$tax_label = $_POST['tax_label'];

$items_table = '<br /><h3 style="padding:30px 0;margin:0;border-bottom: 1px solid #000000;">'.$order_details.'</h3>';
$items_table .= '<table cellpadding="5px" style="margin-top:20px;">';

$items_table .= '<thead>';
	$items_table .= '<tr>';
		$items_table .= '<th style="width:535px;padding:5px 0;font-weight:bold;border-bottom:1px solid #cccccc">' . strtoupper($items_json['translate']['product']) . '</th>';
		$items_table .= '<th style="width:100px;padding:5px 0;font-weight:bold;text-align:right;border-bottom:1px solid #cccccc">' . strtoupper($items_json['translate']['total']) . '</th>';
	$items_table .= '</tr>';
$items_table .= '</thead>';

$items_table .= '<tbody>';
$lines = 0;
foreach ($items_json['items'] as $item){
	$lines++;
	if ($lines < count($items_json['items'])){
		$border = "border-bottom:1px solid #cccccc";
	} else $border = "";
	$items_table .= '<tr>';
	$items_table .= '<td style="line-height:2px;'.$border.'">' . $item['name'] . '<b>&times;' . $item['qty'] . '</b></td>';
	$items_table .= '<td style="text-align:right;'.$border.'">kr ' . number_format($item['line_total'], 0, '.', ' ') . ',-</td>';
	$items_table .= '</tr>';
}

if ($shipping_cost > 0){
	$subtotal = filter_var($items_json['total']['value'], FILTER_SANITIZE_NUMBER_INT);
	$subtotal = $subtotal - $shipping_cost;
	$subtotal = number_format( $subtotal , 0, '.', ' ') . ",-";
	$shipping_cost = number_format( $shipping_cost , 0, '.', ' ') . ",-";
	$items_table .= '<tr>';
		$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($cart_subtotal) . ':</th>';
		$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>kr ' . $subtotal . '</b></td>';
	$items_table .= '</tr>';
	$items_table .= '<tr>';
		$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($shipping_text) . ' <span style="font-size:10px">('.$shipping_method.')</span>:</th>';
		$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>kr ' . $shipping_cost . '</b></td>';
	$items_table .= '</tr>';
}
$items_table .= '</tbody>';

$items_table .= '<tfoot>';
	//$items_table .= '<tr>';
	//	$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($items_json['total']['label']) . '</th>';
	//	$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>' . $items_json['total']['value'] . ',-</b></td>';
	//$items_table .= '</tr>';
	$items_table .= '<tr>';
		$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($items_json['total']['label']) . '</th>';
		$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>kr ' . $total_order . ',-</b></td>';
	$items_table .= '</tr>';
	$items_table .= '<tr>';
		$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($tax_label) . '</th>';
		$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>kr ' . $total_tax . ',-</b></td>';
	$items_table .= '</tr>';
$items_table .= '</tfoot>';

$items_table .='</table>';

//echo $items_table;die();
require_once('include/tcpdf/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Aurelie.no');
$pdf->SetTitle('Aurelie.no - Printed delivery confirmation');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->setFooterData(array(0,0,0), array(0,0,0), $footer);

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
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
<div style="text-align:right"><img width="270px" src="$logo" align="right" /></div>
<table>
		<tr>
			<td colspan="2">
				<h2>$title</h2>
				<br />
				<br />
				<h4 style="font-weight:bold">$shipping_address</h4>
			</td>
		</tr>
		<tr>
			<td valign="top" align="left">$address</td>
			<td valign="top" align="right">
				$info_account<br />
				$info_order<br />
				$info_invoice<br />
				$info_date<br />
				$info_side<br />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<br /><p>$greetings</p>
				<p>$thankyou</p>
			</td>
		</tr>

		<tr>
			<td colspan="2">$items_table</td>
		</tr>
		<tr>
			<td colspan="2">
				<br />
				<p>$bellow0</p>
				<p></p>
				<p>$bellow1</p>
				<p>$bellow2</p>
			</td>
		</tr>
		
	</table>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('export.pdf', 'F');
