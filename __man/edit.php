<?php

include_once '../wp-config.php';

$query = "SELECT * FROM wp_posts WHERE post_type='product'";
$products = $wpdb->get_results($query);
$i=0;
foreach ($products as $product){
	
	$q = "SELECT meta_value FROM wp_postmeta WHERE meta_key = 'total_sales' AND post_id = " . $product->ID;
	$x = $wpdb->get_results($q);
	if (!$x){
		echo "<pre>"; var_dump($product);
		echo "<pre>";var_dump($x);
		$query = "INSERT INTO wp_postmeta (`post_id`, `meta_key`, `meta_value`)
		VALUES ($product->ID, 'total_sales', '0');";

	$x = $wpdb->query($query);
		$i++;
	}
	
}
echo $i;
die('what?!');
foreach ($products as $product) {
	$query = "INSERT INTO wp_postmeta (`post_id`, `meta_key`, `meta_value`)
		VALUES ($product, 'total_sales', '0');";

	$x = $wpdb->query($query);

	var_dump($x);
}