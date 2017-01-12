<?php 
//var_dump($_POST);die();

$products = get_woo_paginated_products(
	$_POST['limit'], 
	$_POST['offset']
);

//var_dump($_POST);die();
$limit = intval($_POST['limit']);
$offset = intval($_POST['offset']);
//var_dump($products);die();

if ($products){
	foreach ($products as $key=>$value){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $products[$key]['link']);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		//curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$page_content = curl_exec($ch); 
		
		if ($_POST['check_http']){
			$products[$key]['link_http_status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE); ;
		}
		
		if ($_POST['check_thumb']){
			$ch_thumb = curl_init($products[$key]['thumb_url']);
			curl_setopt( $ch_thumb, CURLOPT_NOBODY, true );
			curl_exec( $ch_thumb );
			$products[$key]['thumb_http_status'] = curl_getinfo( $ch_thumb, CURLINFO_HTTP_CODE );
		}
		
		if ($_POST['monitoring_set']){
			$monitoring_set = get_monitoring_set_by_id($_POST['monitoring_set']);
			
			foreach ($monitoring_set->Values as $value){
				if (stristr($page_content, $value->value)){
					$products[$key]['Monitoring'][$value->value] = TRUE;
				} else {
					$products[$key]['Monitoring'][$value->value] = FALSE;
				}
			}
		}
		
		curl_close($ch);
	}
}

$can_continue = FALSE;
if ($products /*|| $offset <= 1*/){
	$can_continue = TRUE;
}

echo json_encode(array(
	'products' => $products,
	'limit' => $limit,
	'new_offset' => ($offset + 1),
	'can_continue' => $can_continue
));

die();