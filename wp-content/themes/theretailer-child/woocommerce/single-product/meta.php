<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

?>
<div class="product_meta">

	<div class="small_sep margin50_20"></div>

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option( 'woocommerce_enable_sku' ) == 'yes' && $product->get_sku() ) : ?>
		<span itemprop="productID" class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <?php echo $product->get_sku(); ?></span>
	<?php endif; ?>

	<?php 
	$is_safira_product = false;
	$attributes = $product->get_attributes();
	foreach ($attributes as $attribute) :
		if ($attribute['name'] == 'pa_original-sku'){
			$values = woocommerce_get_product_terms( $product->id, $attribute['name'], 'names' );
			echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
		}
		if ($attribute['name'] == 'pa_original-url'){
			//var_dump($attribute);
			$is_safira_product = true;
		}
	endforeach;	
	?>
	
	<div>
	Leveringstid: 
	<?php
	if ($is_safira_product) {
		echo " 6-9 virkedager";
	} else {
		echo " 1-3 virkedager";
	}
	?>
	</div>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
		echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'woocommerce' ) . ' ', '.</span>' );
	?>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
		echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $size, 'woocommerce' ) . ' ', '.</span>' );
	?>

	<?php
	$s1 = get_post_meta($product->id, 'Leveringstid', true);
	if ($s1)
		echo '<span class="tagged_as">Leveringstid: ' . $s1 . '</span>';
	$s2 = get_post_meta($product->id, 'Leverandør', true);
	if ($s2)
		echo '<span class="tagged_as">Leverandør: ' . $s2 . '</span>';
	?>


<?php 
$terms = get_the_terms( $post->ID, 'product_cat' );
//echo "<pre>"; var_dump($terms); echo "</pre>";
foreach ($terms as $term) {
    $product_cat_id = $term->term_id;
    //break;
}

$tax_meta = get_option( 'my_wpseo_taxonomy_meta' ); 
//echo "<pre>"; var_dump($tax_meta); echo "</pre>";
//var_dump($product_cat_id);
$special_text = $tax_meta['product_cat'][$product_cat_id]['wpcategory_extra_text'];
$is_bold = ($tax_meta['product_cat'][$product_cat_id]['wpcategory_extra_text_bold'] == 'on') ? ' style="font-weight:bold"' : "";

echo '<br /><p' . $is_bold . '>' . $special_text . '</p>';
?>


	<?php 
	/**
	 * following block added by daniel from product-attributes.php - and I removed the table layout
	 */
$attributes = $product->get_attributes();
//echo "<pre>";var_dump($attributes);echo "</pre>";
if ( empty( $attributes ) && ( ! $product->enable_dimensions_display() || ( ! $product->has_dimensions() && ! $product->has_weight() ) ) ) return;
?>
<br />

<?php global $theretailer_theme_options;
if($theretailer_theme_options['attribute_visibility'] && count($attributes) > 1): ?>

<h2><?php _e( 'Product Information', 'theretailer' )?></h2>
	<?php if ( $product->enable_dimensions_display() ) : ?>

<?php
/** hidden content as required on 20141015

		<?php if ( $product->has_weight() ) :  ?>

			<?php _e( 'Weight', 'woocommerce' ) ?>:
			<?php echo $product->get_weight() . ' ' . esc_attr( get_option('woocommerce_weight_unit') ); ?>
<br />
		<?php endif; ?>

		<?php if ($product->has_dimensions()) : ?>

			<?php _e( 'Dimensions', 'woocommerce' ) ?>:
			<?php echo $product->get_dimensions(); ?>
<br />
		<?php endif; ?>
*/?>
	<?php endif; ?>

	<?php foreach ($attributes as $attribute) :
//echo "<pre>";var_dump($attribute); echo "</pre>";
	if ($attribute['name'] != 'pa_original-url' && $attribute['name'] != 'pa_size' && $attribute['name'] != 'pa_length'){
		if ( ! isset( $attribute['is_visible'] ) || ! $attribute['is_visible'] ) continue;
		if ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) continue;

		?>

		<div class="attr_name1"><?php echo $woocommerce->attribute_label( $attribute['name'] ); ?>:</div>
		<div class="attr_value1">
			<?php
			
			
				if ( $attribute['is_taxonomy'] ) {

					$values = woocommerce_get_product_terms( $product->id, $attribute['name'], 'names' );
					if ($woocommerce->attribute_label( $attribute['name'] ) == 'Bredde (cm)' || 
						$woocommerce->attribute_label( $attribute['name'] ) == 'Høyde (cm)' ){
							echo apply_filters( 'woocommerce_attribute', wpautop( str_replace (".", ",", wptexturize( implode( '', $values ) ) ) ), $attribute, $values );
						}
					else echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
					//echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

				} else {

					// Convert pipes to commas and display values
					$values = array_map( 'trim', explode( '|', $attribute['value'] ) );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

				}
			?>
		</div>
<br />
	<?php } ?>
	<?php endforeach; ?>

<?php endif; //check if show attributes?>

	
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>