<?php
/**
 * Customer processing order email
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

?>

<?php do_action('woocommerce_email_header', $email_heading); ?>

<p><?php _e( "Vi takker for Deres bestilling. Her er din ordrebekreftelse:", 'woocommerce' ); ?></p>

<?php do_action('woocommerce_email_before_order_table', $order, false); ?>

<h2 style="font-size:18px; color:#000000"><?php echo __( 'Bestilling:', 'woocommerce' ) . ' ' . $order->get_order_number(); ?></h2>

<table cellspacing="0" cellpadding="6" style="<?php echo $table_style?>">
	<thead>
		<tr>
			<th scope="col" style="<?php echo $th_style1;?>"><?php _e( 'Produkt', 'woocommerce' ); ?></th>
			<th scope="col" style="<?php echo $th_style2;?>" width="100"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( $order->is_download_permitted(), true, ($order->status=='processing') ? true : false ); ?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $key=>$value ) :
					if ($key == 'order_total') : $i++?>
						<tr>
							<th scope="row" style="text-align:right; color: #8D8D8D; border-top: 2px solid #000;"><?php echo $value['label']; ?></th>
							<td style="text-align:right; border-top: 2px solid #000; "><b><?php echo $value['value']; ?></b></td>
						</tr>
					<?php endif;
				endforeach;
			}
		?>
	</tfoot>
</table>

<?php do_action('woocommerce_email_after_order_table', $order, false); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, false ); ?>

<h2 style="font-size:18px; color:#000000"><?php _e( 'Kundedetaljer', 'woocommerce' ); ?></h2>

<?php if ($order->billing_email) : ?>
	<p style="<?php echo $text1_style?>"><strong><?php _e( 'Email:', 'woocommerce' ); ?></strong> <?php echo $order->billing_email; ?></p>
<?php endif; ?>
<?php if ($order->billing_phone) : ?>
	<p style="<?php echo $text1_style?>"><strong><?php _e( 'Telefon:', 'woocommerce' ); ?></strong> <?php echo $order->billing_phone; ?></p>
<?php endif; ?>

<?php woocommerce_get_template('emails/email-addresses.php', array( 'order' => $order )); ?>

<?php do_action('woocommerce_email_footer'); ?>