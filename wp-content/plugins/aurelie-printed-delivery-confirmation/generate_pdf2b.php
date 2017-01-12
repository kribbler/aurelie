<?php
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

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('pdf2b.pdf', 'F');
