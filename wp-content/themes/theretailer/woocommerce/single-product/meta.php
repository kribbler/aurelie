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
	$attributes = $product->get_attributes();
	foreach ($attributes as $attribute) :
		if ($attribute['name'] == 'pa_original-sku'){
			$values = woocommerce_get_product_terms( $product->id, $attribute['name'], 'names' );
			echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
		}
	endforeach;	
	?>
	
	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
		echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'woocommerce' ) . ' ', '.</span>' );
	?>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
		echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $size, 'woocommerce' ) . ' ', '.</span>' );
	?>


	<?php 
	/**
	 * following block added by daniel from product-attributes.php - and I removed the table layout
	 */
$attributes = $product->get_attributes();

if ( empty( $attributes ) && ( ! $product->enable_dimensions_display() || ( ! $product->has_dimensions() && ! $product->has_weight() ) ) ) return;
?>
<br />
<h2><?php _e( 'Product Information', 'theretailer' )?></h2>
	<?php if ( $product->enable_dimensions_display() ) : ?>

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

	<?php endif; ?>

	<?php foreach ($attributes as $attribute) :

		if ( ! isset( $attribute['is_visible'] ) || ! $attribute['is_visible'] ) continue;
		if ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) continue;

		?>

		<?php echo $woocommerce->attribute_label( $attribute['name'] ); ?>:
			<?php
				if ( $attribute['is_taxonomy'] ) {

					$values = woocommerce_get_product_terms( $product->id, $attribute['name'], 'names' );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

				} else {

					// Convert pipes to commas and display values
					$values = array_map( 'trim', explode( '|', $attribute['value'] ) );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

				}
			?>
<br />
	<?php endforeach; ?>



	
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>