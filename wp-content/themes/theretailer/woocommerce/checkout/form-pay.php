<?php
/**
 * Pay for order form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>
<form id="order_review" method="post">

    <table class="shop_table">
        <thead>
                <tr>
                        <th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
                        <th class="product-total"><?php _e( 'Totals', 'woocommerce' ); ?></th>
                </tr>
        </thead>
        <tfoot>
        <?php
        /*
                if ( $totals = $order->get_order_item_totals() ) foreach ( $totals as $total ) :
                        ?>
                        <tr>
                                <th scope="row" colspan="2"><?php echo $total['label']; ?></th>
                                <td class="product-total"><?php echo $total['value']; ?></td>
                        </tr>
                        <?php
                endforeach;
         * 
         */
        ?>
                        
            <tr class="total">
                    <th><strong><?php _e( 'Order Total', 'woocommerce' ); ?></strong></th>
                    <td>
                        <strong><?php echo woocommerce_price($order->get_total()); ?></strong>
                    </td>
                </tr>
            
            <tr class="total">
                	<th><strong><?php _e( 'Incl. Tax', 'theretailer' )?></strong></th>
                	<td>
                        <?php
                            // If prices are tax inclusive, show taxes here
                            if ( $woocommerce->cart->tax_display_cart == 'incl' ) {
                                /*
                                $tax_string_array = array();
                                $taxes = $woocommerce->cart->get_formatted_taxes();
                                
                                
                                if ( sizeof( $taxes ) > 0 ) {
                                    foreach ( $taxes as $key => $tax ) {
                                        $tax_string_array[] = sprintf( '%s %s', $tax, $woocommerce->cart->tax->get_rate_label( $key ) );
                                    }
                                } elseif ( $woocommerce->cart->get_cart_tax() ) {
                                    $tax_string_array[] = sprintf( '%s tax', $tax );
                                }*/
                                $taxes = $order->get_taxes();
                                foreach ($taxes as $t){
                                    $tax = $t['item_meta']['tax_amount'][0];break;
                                }
                                
                                /*
                                if ($_SERVER['REMOTE_ADDR'] == '81.89.11.237'){
                                	echo "<pre>";
                                	var_dump($tax);
                                	var_dump($tax_string_array);
                                	echo "</pre>";
                                }
   								*/
                                if ( ! empty( $tax ) ) {
                                	/*
                                    ?><small class="includes_tax"><?php printf( __( '(Includes %s)', 'woocommerce' ), implode( ', ', $tax_string_array ) ); ?></small><?php
                                    */
                                	?><small class="includes_tax"><?php echo $tax; ?></small><?php 
                                }
                            }
                        ?>
                    </td>
                </tr>
        </tfoot>
        <tbody>
            <?php
            if (sizeof($order->get_items())>0) :
                foreach ($order->get_items() as $item) :
                        echo '
                            <tr>
                                <td class="product-name">'.$item['name'].'</td>
                                <td class="product-subtotal">' . $order->get_formatted_line_subtotal($item) . '</td>
                            </tr>';
                endforeach;
            endif;
            ?>
            
            
        </tbody>
    </table>

    <div id="payment">
        <?php if ($order->order_total > 0) : ?>
        <ul class="payment_methods methods">
                <?php
                        if ( $available_gateways = $woocommerce->payment_gateways->get_available_payment_gateways() ) {
                                // Chosen Method
                                if ( sizeof( $available_gateways ) )
                                        current( $available_gateways )->set_current();

                                foreach ( $available_gateways as $gateway ) {
                                        ?>
                                        <li>
                                                <input type="radio" id="payment_method_<?php echo $gateway->id; ?>" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php if ($gateway->chosen) echo 'checked="checked"'; ?> />
                                                <label for="payment_method_<?php echo $gateway->id; ?>"><?php echo $gateway->get_title(); ?> <?php echo $gateway->get_icon(); ?></label>
                                                <?php
                                                        if ( $gateway->has_fields() || $gateway->get_description() ) {
                                                                echo '<div class="payment_box payment_method_' . $gateway->id . '" style="display:none;">';
                                                                $gateway->payment_fields();
                                                                echo '</div>';
                                                        }
                                                ?>
                                        </li>
                                        <?php
                                }
                        } else {

                                echo '<p>'.__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ).'</p>';

                        }
                ?>
        </ul>
        <?php endif; ?>

        <div class="form-row">
                <?php $woocommerce->nonce_field('pay')?>
                <input type="submit" class="button alt" id="place_order" value="<?php _e( 'Pay for order', 'woocommerce' ); ?>" />
                <input type="hidden" name="woocommerce_pay" value="1" />
        </div>

    </div>

</form>