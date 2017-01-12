<?php 
$products = get_woo_paginated_products_by_seller(
	$_POST['seller'], 
	$_POST['limit'], 
	$_POST['offset'],
	//$_POST['check_published']
	'publish'
);

$all_products = count_products();
//var_dump($offset);var_dump($all_products); die();
//var_dump($_POST);die();
$limit = intval($_POST['limit']);
$offset = intval($_POST['offset']);
//var_dump(count($products));die();

if ($products){
	foreach ($products as $key=>$value){
		$ch = curl_init();
		$product_link = $products[$key]['real_link'];
		
		curl_setopt($ch, CURLOPT_URL, $product_link);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		//curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$page_content = curl_exec($ch); 
		
		$product_ok = true;
		
		if ($_POST['check_http']){
			$products[$key]['link_http_status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($_POST['seller'] == 'gullfunn'){
				$products[$key] = get_gullfunn_product_info($products[$key]);
			}
			if ($products[$key]['link_http_status'] > 400){
				$product_ok = false;
			}
		}
		
		if ($_POST['check_thumb']){
			$ch_thumb = curl_init($products[$key]['thumb_url']);
			curl_setopt( $ch_thumb, CURLOPT_NOBODY, true );
			curl_setopt( $ch, CURLOPT_HEADER, TRUE );
			
			$thumb = curl_exec( $ch_thumb );
			$products[$key]['thumb_http_status'] = curl_getinfo( $ch_thumb, CURLINFO_HTTP_CODE );
			
			//var_dump(getimagesize($products[$key]['thumb_url']));
			if(!is_array(getimagesize($products[$key]['thumb_url']))){
				$products[$key]['thumb_http_status'] = 415;
				$product_ok = FALSE;
			}
			if ($products[$key]['thumb_http_status'] > 400){
				$product_ok = false;
			}
		}
		
		if ($_POST['check_matching_skus']){
			//echo $page_content;


			if (!stristr($page_content, $products[$key]['seller_sku'])){
				$products[$key]['sku_http_status'] = 'not found';
				$product_ok = FALSE;
			} else {
				$products[$key]['sku_http_status'] = 'found';
			}
		}

		if ($_POST['check_stock']){
			if (!stristr($page_content, 'Finns i lager')){
				$products[$key]['stock_http_status'] = 'not in stock';
				$product_ok = FALSE;
			} else {
				$products[$key]['stock_http_status'] = 'in stock';
			}
		}
		
		if ($_POST['monitoring_set']){
			$monitoring_set = get_monitoring_set_by_id($_POST['monitoring_set']);
			
			foreach ($monitoring_set->Values as $value){
				if (stristr($page_content, $value->value)){
					$products[$key]['Monitoring'][$value->value] = TRUE;
					//hardcoded to show products even if they are ok
					//$product_ok = false;
				} else {
					$products[$key]['Monitoring'][$value->value] = FALSE;
					$product_ok = false;
				}
			}
		}
		
		$products[$key]['product_ok'] = $product_ok;
		$products[$key]['show_only_incomplete'] = $_POST['list_incomplete'];
		$products[$key]['list_when_text_found'] = $_POST['list_when_text_found'];
		$products[$key]['list_when_text_not_found'] = $_POST['list_when_text_not_found'];
		//var_dump($_POST['list_when_text_found']);die();
		curl_close($ch);
	}
}

$can_continue = FALSE;
if ($products || $offset <= $all_products){
	$can_continue = TRUE;
}

//$can_continue = true;

echo json_encode(array(
	'products' => $products,
	'limit' => $limit,
	'new_offset' => ($offset + 1),
	'can_continue' => $can_continue,
	'total_products' => $all_products
));

die();

function get_da_product_link($link){
	$link = explode("/", $link);
	return "http://david-andersen.no/ajax/productinfo.aspx?pid=" . $link[count($link) - 1];
}

function get_mg_product_link($link){
	
	$mestergull_pattern = "/";
	$mestergull_pattern .= "<li class=\"(.*?)\" data-id=\"(.*?)\"><a href=\"(.*?)\" class=\"product\">\s+?";
	$mestergull_pattern .= "<h3(.*?)>(.*?)<\/h3><span class=\"description\">(.*?)<\/span><img src=\"(.*?)\" alt=\"(.*?)\" title=\"(.*?)\" data-src=\"(.*?)\"><span class=\"article_number\">(.*?)<\/span><dl class=\"price_info clearfix\">\s+?";
	$mestergull_pattern .= "<dt class=\"price\">Kr<\/dt>\s+?";
	$mestergull_pattern .= "<dd class=\"price\">(.*?),-<\/dd>\s+?";
	$mestergull_pattern .= "<\/dl><\/a><\/li>/s";
	
	$ajax_link = str_replace("productSearch", "ajax_product_search", $link);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $ajax_link);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$page_content = curl_exec($ch); 
	
	$html = html_entity_decode($page_content, ENT_NOQUOTES, "UTF-8");
	preg_match_all(
		$mestergull_pattern,
		$html,
		$matches,
		PREG_SET_ORDER
	);
	
	$f_link = explode("&id=", $link);
	$id = $f_link[1];

	foreach ($matches as $match){
		if ($match[2] == $id){
			$real_link = "http://www.mestergull.no" . $match[3];
		}
	}
	
	return $real_link;
}

function get_gullfunn_product_info($product){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $product['link']);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$page_content = curl_exec($ch);

	if (!stristr($page_content, $product['title'])){
		$product['link_http_status'] = 401;
	}
	
	return $product;
}