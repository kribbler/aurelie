<?php
/**
 * Checkout shipping information form Cargonizer
 *
 * @author 		Daniel Oraca
 * @package 	WooCommerce/Templates
 * @version     1.0
 */

global $woocommerce;
__( 'Fri frakt', 'theretailer' );
?>
<div id="order_levering">
<h3 class="gbtr_order_levering_header accordion_header" id="order_levering_heading"><?php _e('Levering', 'theretailer'); ?></h3>

<div class="gbtr_order_levering_content accordion_content">
	<?php 
	//$available_methods = $woocommerce->shipping->get_available_shipping_methods();
	// If at least one shipping method is available
	if ( $available_methods ) {
		
		echo "<div id='div_order_levering'>";
		// Prepare text labels with price for each shipping method
		foreach ( $available_methods as $method ) {
			$method->full_label = __( $method->label, 'theretailer' );
			//$method->full_label = $method->label;
			if (!$method->error){
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
					//$method->full_label .= ' (' . __( 'Free', 'woocommerce' ) . ')';
				}
			} else {
				if ($method->cost == 1){
					$error = __('Currently not possible to use this shipping method.', 'theretailer');
					if (is_string($method->error)) {
						$error = __( $method->error, 'theretailer' );
					}
					$method->full_label .= '<span class="shipping_error"> : ' . $error . ' ' . '<a href="' . get_site_url() . '/kontakt-oss">' . __( 'Please contact us', 'theretailer' ) . '</a>' . '</span>';
				}
			}
			$method->full_label = apply_filters( 'woocommerce_cart_shipping_method_full_label', $method->full_label, $method );
		}
	
		// Print a single available shipping method as plain text
		/**
		 * added 1==2 by daniel because I dont want to have different style
		 * when there is only one available method
		 */
		if ( 1 === count( $available_methods ) && 1==2 ) {
	
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
	
			foreach ( $available_methods as $method ){
				/*echo '<li>';
				echo '<input type="radio" name="shipping_method" id="shipping_method_' . sanitize_title( $method->id ) . '" value="' . esc_attr( $method->id ) . '" ' . checked( $method->id, $woocommerce->session->chosen_shipping_method, false) . ' /> <label for="shipping_method_' . sanitize_title( $method->id ) . '">' . wp_kses_post( $method->full_label ) . '</label>';
				echo '</li>';*/
				
				$disabled = ($method->error) ? "DISABLED" : "";
				?>
				<li>
					<input type="radio" <?php echo $disabled?> name="shipping_method" class="shipping_methods" id="shipping_method_<?php echo sanitize_title( $method->id )?>" value="<?php echo esc_attr( $method->id )?>" <?php echo checked( $method->id, $woocommerce->session->chosen_shipping_method, false)?> /> 
					<label for="shipping_method_<?php echo sanitize_title( $method->id )?>">
						<?php //echo wp_kses_post( $method->full_label );?>
						<?php
							_e( wp_kses_post( $method->full_label ), 'theretailer' );
						?>
					</label>
					<?php 
					if ($method->label == 'På Døren' || $method->label == 'Minipakke' || $method->label == 'Fri frakt'){
						/**
						 * only display notification sms/email for Bring with Notification option checked.
						 */
						if ($method->label == 'På Døren'){
							echo "<p class='checkout_p'>" . __( 'The goods will be delivered at street level and delivered against receipt. Thats recipient must be present at delivery. The customer will be sends messages before delivery.', 'theretailer' ) . "</p>";
						}
						
						if (check_frontend_for_bring_notification_service()){?>
							<div style="display:none;" id="retrieve_<?php echo $method->id?>">
								<div class="choose_retrieve"><?php _e('Velg hentemelding', 'theretailer')?></div>
								<ul>
									<li class="retrieve_inline">
										<input type="radio" name="retrieve_method_<?php echo sanitize_title( $method->id )?>" id="retrieve_method_sms_<?php echo sanitize_title( $method->id )?>" value="retrieve_sms_<?php echo esc_attr( $method->id )?>" />
										<label for="retrieve_method_sms_<?php echo sanitize_title( $method->id )?>"><?php _e('SMS:', 'theretailer')?></label>
										&nbsp;<input type="text" placeholder="<?php //_e("Enter a valid mobile number", "theretailer");?>" id="retrieve_method_sms_number_<?php echo sanitize_title( $method->id )?>" name="retrieve_method_sms_number_<?php echo sanitize_title( $method->id )?>" class="input_retrieve" />
									</li>
									
									<li class="retrieve_inline">
										<input type="radio" name="retrieve_method_<?php echo sanitize_title( $method->id )?>" id="retrieve_method_email_<?php echo sanitize_title( $method->id )?>" value="retrieve_email_<?php echo esc_attr( $method->id )?>" checked="checked" />
										<label for="retrieve_method_email_<?php echo sanitize_title( $method->id )?>"><?php _e('Email:', 'theretailer')?></label>
										<?php 
										$checkout = $woocommerce->checkout();
										$email_value = $checkout->get_value( 'billing_email' );
										//echo "&nbsp;" . $email_value;
										?>
										&nbsp;<input type="email" placeholder="<?php //_e("Enter a valid email address", "theretailer");?>" id="retrieve_method_email_value_<?php echo sanitize_title( $method->id )?>" name="retrieve_method_email_value_<?php echo sanitize_title( $method->id )?>" value="<?php echo $email_value;?>" class="input_retrieve" />
									</li>
								</ul>
							</div>
						<?php }
						
					}
					if ($method->label == 'Minipakke' && !$method->error){
						//do_action('show_google_map', array('method' => 'minipakke', 'service_partner' => $method->service_partner));
					}
					if ($method->label == 'MyPack' && !$method->error){
						do_action('show_google_map', array('method' => 'mypack', 'service_partners' => $method->service_partners));
					}
					
					?>
					
					
				</li>
				<?php 
			}
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

	<div class="clr"></div>
	<input type="button" class="button_order_levering_continue button" name="button_create_account_continue" value="<?php _e('Continue &raquo;', 'theretailer'); ?>" />
	<div class="clr"></div>
</div>
</div>