<?php
/*
Plugin Name: Woocommerce CSV Import variable products add-on
#Plugin URI: http://allaerd.org/
Description: Import variable products
Version: 1.0.0
Author: Allaerd Mensonides
License: GPLv2 or later
Author URI: http://allaerd.org
*/

class woocsvVariableProducts {

	public function __construct() {
	
		add_action('woocsv_after_save',array($this,'saveVariabelProductAfter'));
		
		add_action('admin_menu', array($this,'adminMenu'));
		
		$this->addToFields();
	}
		
	public function adminMenu() {
		add_submenu_page( 'woocsv_import', 'Variations', 'Variations', 'manage_options', 'woocsvVariations', array($this,'addToAdmin'));
	}
	
	public function addToFields() {
		global $wpdb, $woocsvImport;
		$attributes = $wpdb->get_results ("select * from {$wpdb->prefix}woocommerce_attribute_taxonomies");
		$woocsvImport->fields[] = 'product_type';
		$woocsvImport->fields[] = 'post_parent';
		$woocsvImport->fields[] = 'variation';
		$woocsvImport->fields[] = 'default_attributes';
		
		if ($attributes) {
			foreach ($attributes as $attribute) {
				$woocsvImport->fields[] = 'var_'.$attribute->attribute_name;
			}
		}
	}

	public function saveVariabelProductAfter ($product) {
	global $wpdb;
		foreach ($product->header as $key=>$value) {
			if ($value == 'product_type' ) {
				if ( $product->rawData[$key] == 'variation_master' ) {
					wp_set_object_terms( $product->body['ID'], null , 'product_type');
					wp_set_object_terms( $product->body['ID'], 'variable' , 'product_type', true );
				}
			}
			
			
			if ( $value  == 'default_attributes' && !empty($product->rawData[$key]) ) {
				$defaults = explode('|', $product->rawData[$key]);
				$product_attributes_default = array();
				foreach ($defaults as $default) {
					 list($key,$value) = explode('->', $default);
					 $product_attributes_default['pa_'.$key] = $value;	 
				}
				update_post_meta( $product->body['ID'], '_default_attributes' , $product_attributes_default );
			}
			
			if ($value == 'variation' && !empty($product->rawData[$key]) ) {
				$variations = explode('|', $product->rawData[$key]);
				$product_attributes = get_post_meta($product->body['ID'],'_product_attributes',true);
				if (!$product_attributes) $product_attributes = array ();
				$pos = 0;
				foreach ($variations as $variation) {
					$product_attributes['pa_'.$variation] = array
					(
						'name' => 'pa_'.$variation,
						'value' => '',
						'position' => "$pos",
						'is_visible' => 1,
						'is_variation' => 1,
						'is_taxonomy' => 1,
					);
					$terms = get_terms('pa_'.$variation,array( 'hide_empty' => 0 ));
					foreach ($terms as $term) {
						wp_set_object_terms( $product->body['ID'], $term->slug, 'pa_'.$variation, true );
					}
				$pos ++;
				}
				
				if ( ! function_exists( 'attributes_cmp' ) ) {
					function attributes_cmp( $a, $b ) {
					    if ( $a['position'] == $b['position'] ) return 0;
					    return ( $a['position'] < $b['position'] ) ? -1 : 1;
					}
				}
				uasort( $product_attributes, 'attributes_cmp' );
				
				update_post_meta( $product->body['ID'], '_product_attributes' , $product_attributes );
			}
			//for the child
			if ($value == 'product_type' ) {
				if ( $product->rawData[$key] == 'product_variation' ) {
					$product->body['post_type'] = 'product_variation';		
					wp_insert_post($product->body);		
				}
			}
			
			if ($value == 'post_parent' ) {
				if ( !empty($product->rawData[$key]) ) {
					$parent_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id 
						FROM $wpdb->postmeta 
						WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $product->rawData[$key] ) 
					);
					if ($parent_id) {
						$product->body['post_parent'] = $parent_id;		
						wp_insert_post($product->body);		
					}	
				}
			}
			
			if (substr($value,0,4) === 'var_') {				
				if (!empty($product->rawData[$key])) {
					$parent_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id 
						FROM $wpdb->postmeta 
						WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $product->rawData[array_search('post_parent',$product->header)] ) 
					);
					update_post_meta( $product->body['ID'], 'attribute_pa_'.substr($value, 4), $product->rawData[$key]);
				}
			}
		}
	}
	
	function addToAdmin () {
	?>
		<div class="wrap">
		<div id="woocsv_warning" style="display:none" class="updated"></div>
		<h2>Variable products</h2>
		To import variable products you have to set up the attributes you want to use in advance. 
		<p>
			Now think of the following example, you have pants and shirts in different sizes and colors. You have to setup 2 attributes, color (blue,red,green) and size(l,m,xxl). The following CSV file would reassemble that how an import could look like:
		</p>
		<code>
			<b>sku;product_type;post_title;price;stock;post_parent;variation;var_color;var_size </b><br>
			1;variation_master;pants;10;5;;color|size;;<br>
			2;product_variation;pants;10;6;1;;blue;l<br>
			3;product_variation;pants;10;7;1;;red;m<br>
			4;product_variation;pants;10;8;1;;green;xxl<br>
			5;variation_master;t-shirt;10;1;;size|color;;<br>
			6;product_variation;t-shirt;10;2;5;;blue;l<br>
			7;product_variation;t-shirt;10;3;5;;red;m<br>
			8;product_variation;t-shirt;10;4;5;;green;xxl<br>
		</code>
		</div>
		<?php
	}
}