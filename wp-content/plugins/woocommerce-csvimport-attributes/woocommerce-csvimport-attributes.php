<?php
/*
Plugin Name: Woocommerce CSV Import Attributes add-on
#Plugin URI: http://allaerd.org/
Description: Import attributes
Version: 1.0.0
Author: Allaerd Mensonides
License: GPLv2 or later
Author URI: http://allaerd.org
parent: woocommerce
*/

class woocsvAttributes
{

	public function __construct()
	{

		add_action('woocsv_after_save', array($this, 'saveAttributes'));
		add_action('admin_menu', array($this, 'adminMenu'));
		$this->addToFields();
	}

	public function adminMenu()
	{
		add_submenu_page( 'woocsv_import', 'Attributes', 'Attributes', 'manage_options', 'woocsvAttributes', array($this, 'addToAdmin'));
	}

	public function addToFields()
	{
		global $wpdb, $woocsvImport;
		$attributes = $wpdb->get_results ("select * from {$wpdb->prefix}woocommerce_attribute_taxonomies");
		if ($attributes) {
			foreach ($attributes as $attribute) {
				$woocsvImport->fields[] = 'pa_'.$attribute->attribute_name;
			}
		}

	}

	public function saveAttributes($product)
	{
	$product_attributes = get_post_meta($product->body['ID'],'_product_attributes',true);
	if (!$product_attributes) $product_attributes = array ();
	try {
		foreach ($product->header as $key=>$value) {
			if (substr($value, 0, 3) === 'pa_') {
				$product_attributes['pa_'.substr($value, 3)] = array
				(
					'name' => 'pa_'.substr($value, 3),
					'value' => ($product->rawData[$key]),
					'position' => '0',
					'is_visible' => '1',
					'is_variation' => '0',
					'is_taxonomy' => '1',
				);
				
				$terms = explode('|', $product->rawData[$key]);
				if (!empty($terms)) {
					foreach ($terms as $term)
						wp_set_object_terms( $product->body['ID'], $term, $value, true );	
				}

			}
		}
		if (!empty($product_attributes)) {
			update_post_meta( $product->body['ID'], '_product_attributes' , $product_attributes );
			delete_option("product_cat_children");
		}
		} catch (Exception $e) {
			return;
		}
	}

	function addToAdmin()
	{
		global $woocommerce, $wpdb;
		$attributes = $wpdb->get_results ("select * from {$wpdb->prefix}woocommerce_attribute_taxonomies");
?>
		<div class="wrap">
		<h2>Attributes</h2>
		<?php
		if (!$attributes) {
			echo '<p>You do not have any attributes yet! Please create one or more.</p>';
			return;
		}
?>
		<table class="widefat">
		<thead>
			<tr>
				<th scope="row" class="titledesc"><label for="seperator">Attribute</label></th>
				<th scope="row" class="titledesc"><label for="seperator">header TAG</label></th>
				<th scope="row" class="titledesc"><label for="seperator">type</label></th>
				<th scope="row" class="titledesc"><label for="seperator">Terms</label></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($attributes as $attribute) :
			$terms = $term_string = '';
		$terms = get_terms( $woocommerce->attribute_taxonomy_name($attribute->attribute_name), 'orderby=name&hide_empty=0' );
		foreach ($terms as $term) $term_string .= $term->name.',';
?>
					<tr>
						<td><?php echo $attribute->attribute_name; ?></td>
						<td><?php echo 'pa_'. $attribute->attribute_name; ?></td>
						<td><?php echo $attribute->attribute_type; ?></td>
						<td><?php echo ($term_string)? substr($term_string, 0, -1) : 'no terms'; ?></td>
					</tr>

		<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<?php
	}
}