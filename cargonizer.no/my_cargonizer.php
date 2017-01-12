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

$crg_consignment_url = "http://sandbox.cargonizer.no/consignments.xml";
//$crg_consignment_costs_url = "http://sandbox.cargonizer.no/consignments-costs.xml";
$crg_transport_url = "http://sandbox.cargonizer.no/transport_agreements.xml";

$debug = 0;

//Instantiate class
$crg = new cargonizer($crg_api_key,$crg_sender_id,$crg_consignment_url);

//Find your transport agreements
echo "Transport agreements<br>\n";
$xml = $crg->requestTransportAgreements($crg_transport_url);
//echo "<pre>".print_r($xml,1)."</pre>";

/*
* Uses transport agreement
*/

$items = 

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
		/*"items" => array(
			array("item" => array(
				"_attribs" => array(
					"amount" => "1",
					"description" => "Package #1",
					"type" => "PK",
					"weight" => "1",
					),
			)),
			array("item" => array(
				"_attribs" => array(
					"amount" => "1",
					"description" => "Package #2",
					"type" => "PK",
					"weight" => "1",
				),
			)),
		),*/
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

//Example for adding/changing parts of the array
//$crg_data['consignments']['consignment']['items'][] = array("item"=>array("_attribs"=>array("amount" => "1","description" => "Pakke#1","type" => "PK","weight" => "1")));
//$crg_data['consignments']['consignment']['items'][] = array("item"=>array("_attribs"=>array("amount" => "1","description" => "Pakke#2","type" => "PK","weight" => "1")));

//Request a consignment
echo "Consignment<br>\n";
$crg->requestConsignment($crg_data,$debug,$crg_consignment_url);

echo "Package number: ".$crg->getPkgNumber()."<br>\n";

//Display the entire xml response from cargonizer
$result_xml = $crg->getResultXml();
echo "<pre>".print_r($result_xml,1)."</pre>";
?>