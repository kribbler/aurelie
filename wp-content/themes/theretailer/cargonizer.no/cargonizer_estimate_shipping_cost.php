<?php

require_once("include/cargonizer.php");
$crg_api_key = "5ef3837dd827b5431c8ce8f542b0aa8cd6844793";
$crg_sender_id = "1051";

$crg_consignment_url = "http://sandbox.cargonizer.no/consignment_costs.xml";
$crg_transport_url = "http://sandbox.cargonizer.no/transport_agreements.xml";

$debug = 0;

$crg = new cargonizer($crg_api_key,$crg_sender_id,$crg_consignment_url);

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

$crg->requestConsignment($crg_data,$debug,$crg_consignment_url);
$result_xml = $crg->getResultXml();
$cost = $result_xml->{'estimated-cost'};echo 'her';
global $woocommerce;
$woocommerce->session->estimated_shipping_cost = $cost;
