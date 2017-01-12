<?php

/**
 * http://sandbox.cargonizer.no/transport_agreements.xml
 * http://sandbox.cargonizer.no/consignments
 * https://github.com/logistra/cargonizer-api-examples/blob/master/php/cargonizer_example.php
 * http://www.logistra.no/transport-agreements.html
 */


require_once("include/cargonizer.php");

/*
* This wrapper converts array to xml
* It transfers to Cargonizer using array keys and values as: <array_key>array_value</array_key>
*
* _attribs are added to the parent element as attributes (<array_key attrib_key = 'attrib_value'>)
*
* For field values, see Logistra's documentation of API
* http://www.logistra.no/cargonizer/api/consignments
*
*/

//Attain API key and sender ID from Logistra
$crg_api_key = "xxx";
$crg_sender_id = "0000";

//$crg_consignment_url = "http://sandbox.cargonizer.no/consignments.xml";
$crg_consignment_url = "http://sandbox.cargonizer.no/consignment_costs.xml";
$crg_transport_url = "http://sandbox.cargonizer.no/transport_agreements.xml";

$debug = 0;

//Instantiate class
$crg = new cargonizer($crg_api_key,$crg_sender_id,$crg_consignment_url);

//Find your transport agreements
//echo "Transport agreements<br>\n";
//$xml = $crg->requestTransportAgreements($crg_transport_url);

/*
* Uses transport agreement
*/
$crg_data['consignments'] = array(
	"consignment" => array(
		//_attribs will be parsed as attributes on the parent xml element eg. <consignment key='value' />
		"_attribs" => array(
			"transport_agreement" => "1048", //From transport agreement request
			"estimate" => "true",
		),
		"values" => array(
			"value" => array(
				"_attribs" => array(
					"name" => "ordre_id",
					"value" => "123456",
				),
			),
		),
		"collection" => array(
			"name" => "Dagens",
			"transfer_date" => date("Y-m-d\TH:i:s",strtotime("+2 hour")), //Automatically transfers EDI after 2 hours
		),
		"product" => "bring_servicepakke", //From products in transport agreement request
		"parts" => array(
			"consignee" => array(
				"customer-number" => "123456789",
				"name" => $shipping_first_name . " " . $shipping_last_name,
				"address1" => $shipping_address_1,
				"address2" => $shipping_address_2,
				"country" => $shipping_country,
				"postcode" => $shipping_postcode,
				"city" => $shipping_city,
				"phone" => "66006600",
			),
		),
		"items" => $items, //as generated in functions.php
		//Note that if you use Tollpost instead of Bring, the service block will have more options
		//See logistra API documentation on Tollpost
		"services" => array(
			array("service" => array(
				"_attribs" => array("id"=>"bring_oppkrav"),
				"amount" => "100",
				"account_number" => "123456789",
				"kid" => "123456789",
			)),
		),
		"references" => array(
			"consignor" => "123456",
			"consignee" => "Ordre.nr: 123456",
		),
		"messages" => array(
			"carrier" => "test_message_carrier",
			"consignee" => "test_message_consignee",
		),
	),
);

//Request a consignment

$crg->requestConsignment($crg_data,$debug,$crg_consignment_url);

$result_xml = $crg->getResultXml();
$cost = $result_xml->{'estimated-cost'};
echo 'Estimated cost as retuned by cargonizer XML: ' . $cost;

?>