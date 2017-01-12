<?php

$pdf2_name 					= $_POST['pdf2_name'];
$pdf2_address 				= nl2br($_POST['pdf2_address']);
$pdf2_phone 				= $_POST['pdf2_phone'];
$pdf2_fax 					= $_POST['pdf2_fax'];
$pdf2_email 				= $_POST['pdf2_email'];
$pdf2_order_number 			= $_POST['pdf2_order_number'];
$pdf2_date_agreement 		= $_POST['pdf2_date_agreement'];
$pdf2_date_form 			= $_POST['pdf2_date_form'];

$pdf2_customer_name 		= $_POST['pdf2_customer_name'];
$pdf2_customer_address 		= $_POST['pdf2_customer_address'];
$pdf2_customer_phone 		= $_POST['pdf2_customer_phone'];
$pdf2_customer_email 		= $_POST['pdf2_customer_email'];

require_once('include/tcpdf/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Aurelie.no');
$pdf->SetTitle('Aurelie.no - Printed delivery confirmation');

$pdf->setFooterData(array(0,0,0), array(0,0,0), "");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

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
$pdf->SetFont('pdfatimes', '', 10, '', true);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// Add a page
// This method has several options, check the source code documentation for more information.

$pdf->AddPage();
$html = <<<EOD
<div style="text-align:center"><img width="400" align="center" style="text-align:center" src="include/images/barne.png" /></div>
<p style="text-align:center">Skjema A (bokmål) side 1 av 2.</p>
<p style="text-align:center">Dette skjemaet er obligatorisk ifølge forskrift om angreskjema av 27. februar 2001 fastsatt av Barne- og likestillingsdepartementet med hjemmel i lov 21.12.2000 nr. 105 om opplysningsplikt og angrerett mv. ved fjernsalg og salg utenfor fast utsalgssted (angrerettloven) § 10. Skal brukes ved fjernsalg og salg utenfor fast utsalgssted av varer.</p>
<p style="text-align:center"><b>DU HAR 14 DAGERS UBETINGET ANGRERETT</b></p>
<p>Etter angrerettloven kan forbrukeren gå fra avtalen uten å oppgi noen grunn innen 14 dager etter at hele varen og de opplysninger som kreves med hjemmel i angrerettloven kapittel 3 er mottatt på foreskreven måte (se side 2 av dette skjemaet). Fristen løper ved fjernsalg uansett ut senest 3 måneder etter at varen er mottatt, eller 1 år dersom opplysninger om angrerett ikke er gitt. Det er ingen tilsvarende frist ved salg utenfor fast utsalgssted. Melding om bruk av angreretten må gis til selgeren innen fristen, og kan gis på hvilken som helst måte. Du kan bruke dette skjemaet som skal være utfylt av selgeren som spesifisertnedenfor. Fristen anses overholdt dersom meldingen er avsendtinnen fristens utløp, og du bør sørge for at dette kan dokumenteres.</p>

<table cellpadding="10" cellspacing="0" width="630">
	<tr>
		<td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;"><p style="text-align:center"><b>Skal være utfylt av selgeren:</b></p></td>
	</tr>
	<tr>
		<td style="border-left:1px solid #000;border-right:1px solid #000;">
			<table>
				<tr>
					<td width="150">Selgerens navn:</td>
					<td width="200" style="padding:5px;">$pdf2_name</td>
					<td width="280"></td>
				</tr>
				<tr>
					<td width="150">Selgerens adresse:</td>
					<td style="padding:5px;">$pdf2_address</td>
					<td></td>
				</tr>
				<tr>
					<td width="150">Telefonnummer:</td>
					<td style="padding:5px;">$pdf2_phone</td>
					<td></td>
				</tr>
				<tr>
					<td width="150">Fax:</td>
					<td style="padding:5px;">$pdf2_fax</td>
					<td></td>
				</tr>
				<tr>
					<td width="150">E-postadresse:</td>
					<td style="padding:5px;">$pdf2_email</td>
					<td></td>
				</tr>
				<tr>
					<td width="150">Kontrakt/ordre/bestilling nr.</td>
					<td style="padding:5px;">$pdf2_order_number</td>
					<td></td>
				</tr>
				<tr>
					<td width="150">om vare(r)</td>
					<td style="padding:5px;">________________________________</td>
					<td>&nbsp;&nbsp;[X] Ordrebekreftelse er vedlagt dette skjemaet.</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="border-left:1px solid #000;border-right:1px solid #000; border-top:1px solid #000">
			<table>
				<tr>
					<td colspan="2">
						<p>Ordrebekreftelse er vedlagt dette skjemaet.</p>
						<p>Avtalen ble inngått $pdf2_date_agreement (dato). Skjemaet er levert/sendt $pdf2_date_form (dato).</p>
					</td>
				</tr>

			</table>
		</td>
	</tr>
	<tr>
		<td style="border:1px solid #000">
			<table>
				<tr>
					<td style="text-align:center;">
						<p><b>Fylles ut av forbrukeren:</b><br />
						<b>OBS! Skjemaet skal IKKE sendes til Barne- og likestillingsdepartementet.</b></p>
					</td>
				</tr>
				<tr>
					<td>
						<br /><br />
						<p>Skjemaet er mottatt ___________________________________ (dato). <i>Jeg benytter meg av angreretten.</i></p>
						<p>Navn: <span style="text-decoration:none">$pdf2_customer_name</span></p>
						<p>Adresse: <span style="text-decoration:none">$pdf2_customer_address</span></p>
						<p>Telefonnr.: <span style="text-decoration:none">$pdf2_customer_phone</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; E-postadresse: <span style="text-decoration:none">$pdf2_customer_email</span></p>
						<p>Dato ___________________________  Underskrift  ________________________________________________</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

EOD;
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

/**
 * bellow is page 2 - but it's not generated on this button
 */
/*
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
<p style="text-align:center;">Skjema A (bokmål) side 2 av 2.</p>
<p style="text-align:center;"><b>ANGREFRISTENS UTGANGSPUNKT</b></p>
<p>Opplysningene i henhold til angrerettloven kapittel 3 er mottatt på foreskreven måte når kravene i § 9 jf. § 7 er oppfylt og dette skjemaet er mottatt ferdig utfylt med de opplysningene selgeren skal fylle ut. Se utdrag fra § 9 og § 7 nedenfor.</p>
<p><b>§ 9. Opplysningsplikt ved avtaleinngåelse ved avtaler om varer og andre tjenester enn finansielle tjenester.</b></p>
<p>I forbindelse med inngåelse av en avtale skal forbrukeren motta følgende opplysninger skriftlig på et varig medium som forbrukeren råder over:</p>
<p>a) opplysningene som nevnt i § 7 første ledd bokstav a-f</p>
<p>b) vilkårene og framgangsmåten for, samt virkningene av å benytte angreretten</p>
<p>c) opplysninger om eventuell ettersalgsservice og gjeldende garantivilkår</p>
<p>d) vilkår for oppsigelse av avtalen dersom den er tidsubegrenset eller av mer enn ett års varighet</p>
<p>e) bekreftelse av bestillingen. Ved kjøp av varer skal forbrukeren motta opplysningene senest ved levering. Ved avtaler om varer som skal leveres til en annen enn kjøperen, kan det avtales at opplysningene skal gis først etter levering av varen. Opplysningene etter bokstav b-e skal uansett gis etter avtaleinngåelsen, selv om de er gitt på denne måten tidligere.</p>
<p><b>§ 7. Opplysningsplikt ved avtaler om varer og andre tjenester enn finansielle tjenester.</b></p>
<p>Før det blir inngått en avtale skal forbrukeren motta opplysninger som forbrukeren har grunn til å regne med å få, herunder opplysninger som forbrukeren har krav på etter annen lovgivning. Forbrukeren skal i alle fall ha opplysninger om:</p>
<p>a) varens eller tjenestens viktigste egenskaper</p>
<p>b) de totale kostnadene forbrukeren skal betale, inklusive alle avgifter og leveringskostnader, og spesifikasjon av de enkelte elementene i totalprisen</p>
<p>c) om forbrukeren har rett til å gå fra avtalen (angrerett) eller ikke</p>
<p>d) alle vesentlige avtalevilkår, herunder om betaling, levering eller annen oppfyllelse av avtalen samt om avtalens varighet når avtalen gjelder løpende ytelser</p>
<p>e) selgerens eller tjenesteyterens navn og adresse</p>
<p>f) tidsrommet tilbudet eller prisen er gyldig i</p>
<p style="text-align:center;"><b>OPPGJØR OG RETURKOSTNADER VED BRUK AV ANGRERETTEN</b></p>
<p>Hvis du benytter deg av angreretten skal du ha tilbake det du faktisk har betalt (alle kostnader som er belastet kunden, herunder porto og ekspedisjonsgebyr). Selgeren skal ha tilbake varen.</p>
<p>Eventuelle kostnader ved retur av varer skal bæres av selgeren dersom avtalen er inngått ved telefonsalg eller salg utenfor fast utsalgssted (f.eks. dørsalg, gatesalg, messesalg, "homeparties"). Dersom avtalen er inngått ved annet fjernsalg enn telefon (f.eks. ved postordresalg, internettsalg og tv-shopping) må du bære returkostnadene med mindre selgeren har misligholdt avtalen eller selgeren i henhold til avtalen har levert en erstatningsvare, fordi den bestilte varen ikke var tilgjengelig.</p>
<p style="text-align:center;"><b>ANDRE OPPLYSNINGER</b></p>
<p>Du mister ikke angreretten ved å åpne en vareforsendelse, så lenge varen kan leveres tilbake i vesentlig samme stand og mengde. Angrerettloven griper ikke inn i rettigheter du har etter bl.a. forbrukerkjøpsloven hvis det skulle oppstå mangler eller forsinkelser. Dersom du beholder varen, kan du på visse vilkår kreve prisavslag, omlevering (ny vare), erstatning eller heve kjøpet (få pengene tilbake). Du må da reklamere innen rimelig tid etter at feilen/mangelen er oppdaget. Har du spørsmål om angrerettloven, forbrukerkjøpsloven som angår deg som forbruker, kan du kontakte Forbrukerrådet på tlf. 815 58 200. Internettadresse: http://www.forbrukerportalen.no</p>
<p style="text-align:center;">Skjemaet kan kopieres.</p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
*/
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('pdf2.pdf', 'F');
