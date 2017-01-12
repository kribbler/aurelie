<?php
/**
 * Checkout shipping information form Cargonizer
 *
 * @author 		Daniel Oraca
 * @package 	WooCommerce/Templates
 * @version     1.0
 */

global $woocommerce;
?>

<h3 class="gbtr_shipping_cargonizer_header accordion_header"><?php _e('Levering', 'theretailer'); ?></h3>

<div class="gbtr_shipping_cargonizer_content accordion_content">
	<?php 
	// If at least one shipping method is available
	if ( $available_methods ) {
		echo "<div id='shipping_cargonizer'>";
		// Prepare text labels with price for each shipping method
		foreach ( $available_methods as $method ) {
			$method->full_label = $method->label;
	
			if ( $method->cost > 0 ) {
				if ( $woocommerce->cart->tax_display_cart == 'excl' ) {
					$method->full_label .= ': ' . woocommerce_price( $method->cost );
					if ( $method->get_shipping_tax() > 0 && $woocommerce->cart->prices_include_tax ) {
						$method->full_label .= ' <small>' . $woocommerce->countries->ex_tax_or_vat() . '</small>';
					}
				} else {
					$method->full_label .= ': ' . woocommerce_price( $method->cost + $method->get_shipping_tax() );
					if ( $method->get_shipping_tax() > 0 && ! $woocommerce->cart->prices_include_tax ) {
						$method->full_label .= ' <small>' . $woocommerce->countries->inc_tax_or_vat() . '</small>';
					}
				}
			} elseif ( $method->id !== 'free_shipping' ) {
				$method->full_label .= ' (' . __( 'Free', 'woocommerce' ) . ')';
			}
			$method->full_label = apply_filters( 'woocommerce_cart_shipping_method_full_label', $method->full_label, $method );
		}
	
		// Print a single available shipping method as plain text
		if ( 1 === count( $available_methods ) ) {
	
			echo wp_kses_post( $method->full_label ) . '<input type="hidden" name="shipping_method" id="shipping_method" value="' . esc_attr( $method->id ) . '" />';
	
		// Show select boxes for methods
		} elseif ( get_option('woocommerce_shipping_method_format') == 'select' ) {
	
			echo '<select name="shipping_method" id="shipping_method">';
	
			foreach ( $available_methods as $method )
				echo '<option value="' . esc_attr( $method->id ) . '" ' . selected( $method->id, $woocommerce->session->chosen_shipping_method, false ) . '>' . wp_kses_post( $method->full_label ) . '</option>';
	
			echo '</select>';
	
		// Show radio buttons for methods
		} else {
	
			echo '<ul id="shipping_method">';
	
			foreach ( $available_methods as $method )
				echo '<li><input type="radio" name="shipping_method" id="shipping_method_' . sanitize_title( $method->id ) . '" value="' . esc_attr( $method->id ) . '" ' . checked( $method->id, $woocommerce->session->chosen_shipping_method, false) . ' /> <label for="shipping_method_' . sanitize_title( $method->id ) . '">' . wp_kses_post( $method->full_label ) . '</label></li>';
	
			echo '</ul>';
		}
		echo "</div>";
	// No shipping methods are available
	} else {
	
		if ( ! $woocommerce->customer->get_shipping_country() || ! $woocommerce->customer->get_shipping_state() || ! $woocommerce->customer->get_shipping_postcode() ) {
			echo '<p>' . __( 'Please fill in your details to see available shipping methods.', 'woocommerce' ) . '</p>';
		} else {
			echo '<p>' . __( 'Sorry, it seems that there are no available shipping methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) . '</p>';
		}
	
	}
	?>
	
	<?php 
	global $woocommerce;
	
	$checkout = $woocommerce->checkout();
	
	$shipping_country = $checkout->get_value('shipping_country');
	$shipping_first_name = $checkout->get_value('shipping_first_name');
	$shipping_last_name = $checkout->get_value('shipping_last_name');
	$shipping_company = $checkout->get_value('shipping_company');
	$shipping_address_1 = $checkout->get_value('shipping_address_1');
	$shipping_address_2 = $checkout->get_value('shipping_address_2');
	$shipping_postcode = $checkout->get_value('shipping_postcode');
	$shipping_city = $checkout->get_value('shipping_city');
	$shipping_state = $checkout->get_value('shipping_state');
	
	$items = array();

	if (sizeof($woocommerce->cart->get_cart())>0) :
		$k = 0;
		foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) :
			$_product = $values['data'];
			
			$items[$k]['item']['_attribs']['amount'] = $values['quantity'];
			$items[$k]['item']['_attribs']['weight'] = $_product->get_weight();
			$items[$k]['item']['_attribs']['description'] = $_product->get_title();
			$items[$k]['item']['_attribs']['type'] = "PK";
			$k++;
			
		endforeach;
	endif;
	
	include( 'cargonizer.no/cargonizer_estimate.php' );?>
	
	<div class="clr"></div>
	<input type="button" class="button_shipping_cargonizer_continue button" name="button_create_account_continue" value="<?php _e('Continue &raquo;', 'theretailer'); ?>" />
	<div class="clr"></div>
</div>