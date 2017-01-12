<?php
/**
 * Customer completed order email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php 

$table_style = "margin-bottom: 30px;
    padding-bottom: 50px;
    border-top:2px solid #000;
    border-bottom:1px solid #ccc;
    width:100%";
$th_style1="padding: 15px 10px 15px 0 !important;border-bottom: 1px solid #CCCCCC;color: #000000;
    font-size: 12px;
    font-weight: 900;
    text-decoration: none;
    text-transform: uppercase;
    vertical-align: middle;line-height: 18px;font-family: 'Lato',Arial,Helvetica,sans-serif !important;
    text-align:left;";
$th_style2="padding: 15px 10px 15px 0 !important;border-bottom: 1px solid #CCCCCC;color: #000000;
    font-size: 12px;
    font-weight: 900;
    text-decoration: none;
    text-transform: uppercase;
    vertical-align: middle;line-height: 18px;font-family: 'Lato',Arial,Helvetica,sans-serif !important;
    text-align:right;";

$text1_style = "line-height: 1.7em;
	color: #777777 !important;
    font-size: 12px !important;
    padding: 0 0 15px 0 !important;";

$text2_style = "line-height: 1.1em;
	color: #777777 !important;
    font-size: 12px !important;
    padding: 0 0 0px 0 !important;";
?>

<?php do_action('woocommerce_email_header', $email_heading); ?>

<p><?php printf( __( "Hei. En bestilling ble fullført. Detaljene finner du under:", 'woocommerce' ), get_option( 'blogname' ) ); ?></p>
<?php do_action('woocommerce_special_info_admin_email', $order);?>
<?php do_action('woocommerce_email_before_order_table', $order, false); ?>

<h2 style="font-size:18px; color:#000000"><?php echo __( 'Bestilling:', 'woocommerce' ) . ' ' . $order->get_order_number(); ?></h2>
<table cellspacing="0" cellpadding="6" style="<?php echo $table_style?>">
	<thead>
		<tr>
			<th scope="col" style="<?php echo $th_style1;?>"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th scope="col" style="<?php echo $th_style2;?>" width="100"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( true, false, true ); ?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$v1 = filter_var($totals['cart_subtotal']['value'], FILTER_SANITIZE_NUMBER_INT);
				$v2 = filter_var($totals['order_total']['value'], FILTER_SANITIZE_NUMBER_INT);
				foreach ( $totals as $key=>$value ) :
					$value['remove_p'] = FALSE;
					if ($key == 'shipping'){
						$value = switch_via($value);
					}
					if ($key == 'order_total'){
						//skip this because it's displayed outside this foreach
					}
					else if ($v1 == $v2){
						if ($key == 'order_total') : ?>
							<!-- 
							<tr>
								<th scope="row" style="text-align:right; border-top: 2px solid #000;"><?php echo $value['label']; ?></th>
								<td style="text-align:right; border-top: 2px solid #000;"><b><?php echo $value['value']; ?>,-</b></td>
							</tr>
							 -->
						<?php endif;
					} else {
						?>
						<tr>
							<th scope="row" style="text-align:right; border-top: 2px solid #000;"><?php echo $value['label']; ?></th>
							<td style="text-align:right; border-top: 2px solid #000;"><b><?php echo $value['value']; ?><?php echo ($value['remove_p'])?"":",-"?></b></td>
						</tr>
						<?php 
					}
				endforeach;
				?>
				<tr>
					<th scope="row" style="text-align:right; color: #8D8D8D; border-top: 0px solid #000;"><?php _e( 'Order Total', 'woocommerce' )?>:</th>
					<td style="text-align:right; border-top: 0px solid #000; "><b><?php echo woocommerce_price($order->get_total())?>,-</b></td>
				</tr>
				<tr>
					<th scope="row" style="text-align:right; color: #8D8D8D; border-top: 0px solid #000;"><?php _e( 'Incl. Tax', 'theretailer' )?>:</th>
					<td style="text-align:right; border-top: 0px solid #000; "><b><?php echo woocommerce_price($order->get_total_tax()); ?>,-</b></td>
				</tr>
				<?php 
			}
		?>
	</tfoot>
</table>

<?php do_action('woocommerce_email_after_order_table', $order, false); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, false ); ?>

<h2 style="font-size:18px; color:#000000"><?php _e( 'Kundeopplysninger', 'woocommerce' ); ?></h2>

<?php if ($order->billing_email) : ?>
	<p style="<?php echo $text2_style?>"><strong><?php _e( 'E-post:', 'woocommerce' ); ?></strong> <?php echo $order->billing_email; ?></p>
<?php endif; ?>
<?php if ($order->billing_phone) : ?>
	<p style="<?php echo $text2_style?>"><strong><?php _e( 'Telefon:', 'woocommerce' ); ?></strong> <?php echo $order->billing_phone; ?></p>
<?php endif; ?>

<?php woocommerce_get_template('emails/email-addresses.php', array( 'order' => $order )); ?>

<?php do_action('woocommerce_email_footer'); ?>