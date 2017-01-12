<?php 

wp_enqueue_style('monitoring_css', plugin_dir_url(__FILE__) . 'style.css');

function create_new_set($set_name, $set_values){
	global $wpdb;
	
	$insert_set_name = array(
		'name' => $set_name
	);
	
	$wpdb->insert( "wp_monitoring_sets", $insert_set_name);
	
	$set_id = mysql_insert_id();
	
	save_set_values($set_values, $set_id);
}

function edit_set($set_name, $set_values, $set_id){
	global $wpdb;
	
	$wpdb->delete("wp_monitoring_set_values", array('set_id' => $set_id));
	save_set_values($set_values, $set_id);
	
	$wpdb->update(
		'wp_monitoring_sets',
		array('name' => $set_name),
		array('id' => $set_id)
	);
}

function save_set_values($set_values, $set_id){
	global $wpdb;
	
	foreach ($set_values as $value) {
		$insert_set_values = array(
			'set_id' => $set_id,
			'value' => $value
		);
		
		$wpdb->insert( "wp_monitoring_set_values", $insert_set_values );
	}
}

function get_current_sellers(){
	global $wpdb, $woocommerce;
	
	$taxonomy = "pa_seller";

	$args = array(
		'hide_empty' => '1'
	);
	$terms = get_terms( $taxonomy, $args );
	
	return $terms;
}

function check_if_tables_exist(){
	global $wpdb;
	
	$query = "SHOW TABLES LIKE 'wp_monitoring_sets'";
	$is = $wpdb->get_results( $query );
	if (!$is){
		$query = "CREATE TABLE IF NOT EXISTS `wp_monitoring_sets` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB";
		$wpdb->get_results( $query );
	}
	
	$query = "SHOW TABLES LIKE 'wp_monitoring_set_values'";
	$is = $wpdb->get_results( $query );
	if (!$is){
		$query = "CREATE TABLE IF NOT EXISTS `wp_monitoring_set_values` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `set_id` int(11) NOT NULL,
		  `value` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB";
		$wpdb->get_results( $query );
	}
	
	$query = "SHOW TABLES LIKE 'wp_monitoring_processes'";
	$is = $wpdb->get_results( $query );
	if (!$is){
		$query = "CREATE TABLE IF NOT EXISTS `wp_monitoring_processes` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `start_date` datetime NOT NULL,
		  `pause_date` datetime NOT NULL,
		  `offset` int(11) NOT NULL,
		  `rows_unchecked` int(11) NOT NULL,
		  `last_trs` text NOT NULL,
		  `seller` varchar(255) NOT NULL,
		  `set_id` int(11) NOT NULL,
		  `set_name` varchar(255) NOT NULL,
		  `check_http` tinyint(4) NOT NULL,
		  `check_thumb` tinyint(4) NOT NULL,
		  `check_published` tinyint(4) NOT NULL,
		  `check_matching_skus` tinyint(4) NOT NULL,
		  `list_incomplete` tinyint(4) NOT NULL,
		  `list_when_text_found` tinyint(4) NOT NULL,
		  `list_when_text_not_found` tinyint(4) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB";
		$wpdb->get_results( $query );
	}
}

function get_monitoring_sets(){
	global $wpdb;
	
	check_if_tables_exist();
	
	$query = "SELECT * FROM wp_monitoring_sets ORDER BY id";
	$sets = $wpdb->get_results( $query );
	
	foreach ($sets as $key=>$value){
		$query = "SELECT * FROM wp_monitoring_set_values WHERE set_id = " . $sets[$key]->id;
		$sets[$key]->Values = $wpdb->get_results( $query );
	}
	
	return $sets;
}

function get_monitoring_set_by_id($id){
	global $wpdb;
	
	$query = "SELECT * FROM wp_monitoring_sets WHERE id = {$id} LIMIT 1";
	$set = $wpdb->get_results( $query );
	$set = $set[0];

	$query = "SELECT * FROM wp_monitoring_set_values WHERE set_id = " . $id . " ORDER BY id";
	$set->Values = $wpdb->get_results( $query );
	
	return $set;
}

function get_woo_products(){
	global $product;
	
	$args = array( 
		'post_type' => 'product',
		'posts_per_page' => 500,
		'offset' => 2
	);
	
	$loop = new WP_Query( $args );
	$i = 0;
	
	while ( $loop->have_posts() ) : 
		$loop->the_post(); 
		$products[$i]['id'] = $loop->post->ID;		
		$i++;
	endwhile; 
	wp_reset_query();
	
	return $products;
}

function count_products() {
	global $product;
	$products = array();

	$args = array(
		'post_type' => 'product', 
		'post_status' => 'publish',
	);
	
	$loop_count = new WP_Query( $args );

	return $loop_count->found_posts;
}

function get_woo_paginated_products_by_seller($seller, $limit, $offset, $published_only){
	global $product;
	$products = array();

	$published = ($published_only) ? 'publish' : '';

	$args = array(
		'post_type' => 'product', 
		'post_status' => $published,
		'posts_per_page' => $limit,
		'pa_seller' => $seller
	);
	
	$loop_count = new WP_Query( $args );
	
	$args = array( 
		'post_type' => 'product', 
		'post_status' => $published,
		'posts_per_page' => $limit,
		'offset' => $offset,  
		'pa_seller' => $seller 
	);
	//var_dump($args); die();
	
	$loop = new WP_Query( $args );
	$i = 0;
	//var_dump($loop->have_posts()); die();
	while ( $loop->have_posts() ) : 
	
		$loop->the_post(); 
//echo 'here - ' . $loop->post->ID;
//var_dump(get_product_attribute( $loop->post->ID, 'pa_original-url', 'name' ));
//$attribute = get_the_terms( '200146', 'pa_original-url' );
//echo "<pre>"; var_dump($attribute);
		if (get_product_attribute( $loop->post->ID, 'pa_original-url', 'name' )){
//			echo 'there';
			$products[$i]['id'] = $loop->post->ID;
//			var_dump($loop->post);
//			var_dump($products[$i]); die();
			$products[$i]['title'] = $loop->post->post_title;
			$products[$i]['link_oku'] = get_permalink( $loop->post->ID );
			/**
			 * 20140104 - changed the "link" because it's null.
			 */
			$products[$i]['link'] = get_post_meta( $loop->post->ID, '_the_link', true );
			$products[$i]['link'] = get_product_attribute( $loop->post->ID, 'pa_product-link', 'name' );
			$products[$i]['real_link'] = get_product_attribute( $loop->post->ID, 'pa_original-url', 'name' );
			
			$products[$i]['seller_sku'] = get_product_attribute( $loop->post->ID, 'pa_seller-sku', 'name' );
			$products[$i]['has_thumb'] = has_post_thumbnail( $loop->post->ID );
			
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'thumbnail');
			$products[$i]['thumb_url'] = $thumb[0];
			//$products[$i]['Attributes'] = $product->get_attributes();
			$products[$i]['total_products'] = $loop_count->found_posts;
			$i++;
			
		}
		
	endwhile; 
	wp_reset_query();
	//echo "<pre>"; var_dump($products);
	//if ($offset > 1) return false;
	return $products;
}

function get_product_real_link($id, $link){
	$seller = get_product_attribute( $id, 'pa_seller', 'slug' );
	if ($seller == 'david-andersen'){
		$link = get_da_product_link($link);
	}

	if ($_POST['seller'] == 'mestergull'){
		$link = get_mg_product_link($link);
	}
return "#";
	return $link;
}

function get_product_attribute($product_id, $attribute_name, $v){
	$attribute = get_the_terms( $product_id, $attribute_name );
	foreach ($attribute as $key=>$value){
		return $value->$v;
	}
}

function get_woo_paginated_products($limit, $offset){
	global $product;
	$products = array();

	$args = array( 
		'post_type' => 'product', 
		'posts_per_page' => $limit,
		'offset' => $offset
	);
	
	$loop = new WP_Query( $args );
	$i = 0;
	
	while ( $loop->have_posts() ) : 
	
		$loop->the_post(); 
	
		$products[$i]['id'] = $loop->post->ID;
		$products[$i]['title'] = $loop->post->post_title;
		$products[$i]['link_oku'] = get_permalink( $loop->post->ID );
		$products[$i]['link'] = get_post_meta( $loop->post->ID, '_the_link', true );
		$products[$i]['has_thumb'] = has_post_thumbnail( $loop->post->ID );
		
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
		$products[$i]['thumb_url'] = $thumb[0];
		//$products[$i]['Attributes'] = $product->get_attributes();
		
		$i++;
		
	endwhile; 
	wp_reset_query();
	
	//if ($offset > 1) return false;
	return $products;
}

function delete_product($id){
	wp_delete_post($id);
}

function trash_product($id){
	wp_trash_post($id);
}

function pending_product($id){
	$current_post = get_post( $id, 'ARRAY_A' );
	$current_post['post_status'] = $status;
	wp_update_post($current_post);
}

function delete_set($id){
	global $wpdb;
	
	$query = "DELETE FROM `wp_monitoring_set_values` WHERE `wp_monitoring_set_values`.`set_id` = $id";
	mysql_query($query) or die(mysql_error());
	
	$query = "DELETE FROM `wp_monitoring_sets` WHERE `wp_monitoring_sets`.`id` = $id";
	mysql_query($query) or die(mysql_error());
}

function delete_process($id){
	global $wpdb;
	
	$query = "DELETE FROM `wp_monitoring_processes` WHERE `id` = $id";
	mysql_query($query) or die(mysql_error());
}

function save_paused_process($post){
	global $wpdb;
	
	$data = array(
		'start_date' 				=> $post['start_date'],
		'pause_date' 				=> date('Y-m-d h:i:s'),
		'offset'					=> $post['offset'],
		'rows_unchecked'			=> $post['rows_unchecked'],
		'last_trs'					=> $post['last_trs'],
		'seller'					=> $post['seller'],
		'set_id'					=> $post['monitoring_set'],
		'check_http'				=> $post['check_http'],
		'check_stock'				=> $post['check_stock'],
		'check_published'			=> $post['check_published'],
		'check_matching_skus'		=> $post['check_matching_skus'],
		'list_incomplete'			=> $post['list_incomplete'],
		'list_when_text_found'		=> $post['list_when_text_found'],
		'list_when_text_not_found'	=> $post['list_when_text_not_found'],
	);
	
	if (isset($post['id'])){
		$response = $wpdb->update( "wp_monitoring_processes", $data, array('id' => $post['id']));
	} else {
		$response = $wpdb->insert( "wp_monitoring_processes", $data);
	}
	
	//var_dump($response);
	return true;
}

function get_set_name($id){
	global $wpdb;
	$result = $wpdb->get_results( "SELECT * FROM wp_monitoring_sets WHERE id = $id" );
	return $result[0]->name;
}

function get_paused_processes(){
	global $wpdb;
	
	$processes = $wpdb->get_results( "SELECT * FROM wp_monitoring_processes ORDER BY start_date ASC");
	
	foreach ($processes as $key=>$value){
		if ($processes[$key]->set_id){
			$processes[$key]->set_name = get_set_name($processes[$key]->set_id);
		}
	}
	
	return $processes;
}

function get_finished_processes(){
	global $wpdb;
	
	$processes = $wpdb->get_results( "SELECT * FROM wp_monitoring_processes WHERE rows_unchecked = 0 ORDER BY start_date ASC");
	
	foreach ($processes as $key=>$value){
		if ($processes[$key]->set_id){
			$processes[$key]->set_name = get_set_name($processes[$key]->set_id);
		}
	}
	
	return $processes;
}


function get_process_info($id){
	global $wpdb;
	
	$process = $wpdb->get_results( "SELECT * FROM wp_monitoring_processes WHERE id = $id");
	//echo "<pre>"; var_dump($process); die();
	return $process[0];
}