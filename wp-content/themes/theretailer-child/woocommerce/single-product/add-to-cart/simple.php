<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce, $product, $theretailer_theme_options;

if ( (!$theretailer_theme_options['catalog_mode']) || ($theretailer_theme_options['catalog_mode'] == 0) ) {

if ( ! $product->is_purchasable() ) return;
?>

<div class="gbtr_add_to_cart_simple">

<?php
	// Availability
	$availability = $product->get_availability();

	if ($availability['availability']) :
		//echo apply_filters( 'woocommerce_stock_html', '<p class="stock '.$availability['class'].'">'.$availability['availability'].'</p>', $availability['availability'] );
		echo '<p class="stock">På lager</p>';
    endif;
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype='multipart/form-data'>

	 	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

<?php
		$engraving = get_post_meta( $product->id, 'engraving', true );
		if($engraving == "yes"){?>
		<div id="engraving_info">
			<label for="engraving_text">GRAVERING</label><br />
			<input id="engraving_text" name="engraving_text" type="text" value="ANGI GRAVERINGSTEKST" 
				onblur="if (this.value == '') {this.value = 'ANGI GRAVERINGSTEKST';}"
				 onfocus="if (this.value == 'ANGI GRAVERINGSTEKST') {this.value = '';}" />
		</div>
		<?php }
		?>
		
		<?php
	 		if ( ! $product->is_sold_individually() )
	 			woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
	 	?>

	 	<?php
	 	$price = get_post_meta( get_the_ID(), '_regular_price');
		$price = $price[0];
	 	$google_link = "_gaq.push(['_trackEvent', 'Products', 'Add To Basket', '".esc_attr( $product->get_sku() )."', ".$price.", true]);";
	 	?>

	 	<script type="text/javascript">
jQuery('.single_add_to_cart_button').on('click', function() {
  //ga('send', 'event', 'button', 'click', 'nav-buttons');
  //return false;
});
</script>

        <button type="submit" class="single_add_to_cart_button button alt" onClick="<?php echo $google_link; ?>"><?php echo apply_filters('single_add_to_cart_text', __('Legg I Handlepose', 'woocommerce'), $product->product_type); ?></button>
        
        <div class="clr"></div>
        
	 	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>

</div><!-- /gbtr_add_to_cart_simple -->

<?php } ?>