<?php
/**
 * Customer invoice email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.0.0
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
?>

<?php do_action('woocommerce_email_header', $email_heading); ?>

<?php if ($order->status=='pending') : ?>

	<p><?php printf( __( 'En bestilling er opprettet. For å betale for denne kan du gå hit: %s', 'woocommerce' ), get_bloginfo( 'name' ), '<a href="' . $order->get_checkout_payment_url() . '">' . __( 'pay', 'woocommerce' ) . '</a>' ); ?></p>

<?php endif; ?>

<?php do_action('woocommerce_email_before_order_table', $order, false); ?>

<h2 style="font-size:18px; color:#000000"><?php echo __( 'Bestilling:', 'woocommerce' ) . ' ' . $order->get_order_number(); ?> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( woocommerce_date_format(), strtotime( $order->order_date ) ) ); ?>)</h2>

<table cellspacing="0" cellpadding="6" style="<?php echo $table_style?>">
	<thead>
		<tr>
			<th scope="col" style="<?php echo $th_style1;?>"><?php _e( 'Produkt', 'woocommerce' ); ?></th>
			<th scope="col" style="<?php echo $th_style2;?>" width="100"><?php _e( 'Pris', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			switch ( $order->status ) {
				case "completed" :
					echo $order->email_order_items_table( $order->is_download_permitted(), false, true );
				break;
				case "processing" :
					echo $order->email_order_items_table( $order->is_download_permitted(), true, true );
				break;
				default :
					echo $order->email_order_items_table( $order->is_download_permitted(), true, false );
				break;
			}
		?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				/*
				foreach ( $totals as $key=>$value ) :
					if ($key == 'order_total') : $i++?>
						<tr>
							<th scope="row" style="text-align:right; border-top: 2px solid #000;"><?php echo $value['label']; ?></th>
							<td style="text-align:right; border-top: 2px solid #000;"><b><?php echo $value['value']; ?></b></td>
						</tr>
					<?php endif;
				endforeach;
				*/
				?>
				<tr>
					<th scope="row" style="text-align:right; color: #8D8D8D; border-top: 2px solid #000;"><?php _e( 'Order Total', 'woocommerce' )?></th>
					<td style="text-align:right; border-top: 2px solid #000; "><b><?php echo woocommerce_price($order->get_total())?>,-</b></td>
				</tr>
				<tr>
					<th scope="row" style="text-align:right; color: #8D8D8D; border-top: 0px solid #000;"><?php _e( 'Incl. Tax', 'theretailer' )?></th>
					<td style="text-align:right; border-top: 0px solid #000; "><b><?php echo woocommerce_price($order->get_total_tax()); ?>,-</b></td>
				</tr>
				<?php 
			}
		?>
	</tfoot>
</table>

<?php do_action('woocommerce_email_after_order_table', $order, false); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, false ); ?>

<?php do_action('woocommerce_email_footer'); ?>