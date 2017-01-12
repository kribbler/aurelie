<?php
/**
 * Email Addresses
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$address_style = "border-bottom: 1px dotted #CCCCCC;
    color: #000000;
    display: block;
    float: none;
    font-size: 12px;
    font-weight: 900;
    padding: 0 0 15px 0;
    text-transform: uppercase;";

$address_b_style = "line-height: 1.7em;
	color: #777777 !important;
    font-size: 12px !important;
    padding: 0 0 15px 0 !important;";

?><table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top;" border="0">

	<tr>

		<td valign="top" width="50%">

			<div style="<?php echo $address_style?>"><?php _e( 'Leveringsadresse', 'woocommerce' ); ?></div>

			<p style="<?php echo $address_b_style?>"><?php echo $order->get_formatted_billing_address(); ?></p>

		</td>

		<?php if ( 1==2 && get_option( 'woocommerce_ship_to_billing_address_only' ) == 'no' && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>

		<td valign="top" width="50%">

			<div style="<?php echo $address_style?>"><?php _e( 'Leveringsadresse', 'woocommerce' ); ?></div>

			<p style="<?php echo $address_b_style?>"><?php echo $shipping; ?></p>

		</td>

		<?php endif; ?>

	</tr>

</table>