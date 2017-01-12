<?php
/**
 * Order details
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$order = new WC_Order( $order_id );
?>

<div class="gbtr_my_account_wrapper">

<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
<table class="shop_table order_details gbtr_order_details">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
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
				if ($v1 == $v2){
					if ($key == 'order_total'):
					?>
					<tr>
						<th scope="row"><?php echo $value['label']; ?></th>
						<td><?php echo $value['value']; ?></td>
					</tr>
				<?php
					endif;
				} else {
					if ($key != 'order_total'):
					?>
					<tr>
						<th scope="row"><?php echo $value['label']; ?></th>
						<td><?php echo $value['value']; ?><?php echo ($value['remove_p'])?"":",-"?></td>
					</tr>
					<?php
					endif;
				}
			endforeach;
			?>
			<tr>
				<th scope="row"><?php _e( 'Order Total', 'woocommerce' )?></th>
				<td><?php echo woocommerce_price($order->get_total())?>,-</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Incl. Tax', 'theretailer' )?></th>
				<td><?php echo woocommerce_price($order->get_total_tax()); ?>,-</td>
			</tr>
			<?php
			
		}
	?>
	</tfoot>
	<tbody>
		<?php
		if (sizeof($order->get_items())>0) {

			foreach($order->get_items() as $item) {

				$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );

				echo '
					<tr class = "' . esc_attr( apply_filters( 'woocommerce_order_table_item_class', 'order_table_item', $item, $order ) ) . '">
						<td class="product-name">' .
							apply_filters( 'woocommerce_order_table_product_title', '<a href="' . get_permalink( $item['product_id'] ) . '">' . $item['name'] . '</a>', $item ) . ' ' .
							apply_filters( 'woocommerce_order_table_item_quantity', '<strong class="product-quantity">&times; ' . $item['qty'] . '</strong>', $item );

				$item_meta = new WC_Order_Item_Meta( $item['item_meta'] );
				$item_meta->display();

				if ( $_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted() ) {

					$download_file_urls = $order->get_downloadable_file_urls( $item['product_id'], $item['variation_id'], $item );

					$i     = 0;
					$links = array();

					foreach ( $download_file_urls as $file_url => $download_file_url ) {

						$filename = woocommerce_get_filename_from_url( $file_url );

						$links[] = '<small><a href="' . $download_file_url . '">' . sprintf( __( 'Download file%s', 'woocommerce' ), ( count( $download_file_urls ) > 1 ? ' ' . ( $i + 1 ) . ': ' : ': ' ) ) . $filename . '</a></small>';

						$i++;
					}

					echo implode( '<br/>', $links );
				}

				echo '</td><td class="product-total">' . $order->get_formatted_line_subtotal( $item ) . ',-</td></tr>';

				// Show any purchase notes
				if ($order->status=='completed' || $order->status=='processing') {
					if ($purchase_note = get_post_meta( $_product->id, '_purchase_note', true))
						echo '<tr class="product-purchase-note"><td colspan="3">' . apply_filters('the_content', $purchase_note) . '</td></tr>';
				}

			}
		}

		do_action( 'woocommerce_order_items_table', $order );
		?>
	</tbody>
</table>

<?php if ( get_option('woocommerce_allow_customers_to_reorder') == 'yes' && $order->status=='completed' ) : ?>
	<p class="order-again">
		<a href="<?php echo esc_url( $woocommerce->nonce_url( 'order_again', add_query_arg( 'order_again', $order->id, add_query_arg( 'order', $order->id, get_permalink( woocommerce_get_page_id( 'view_order' ) ) ) ) ) ); ?>" class="button"><?php _e( 'Order Again', 'woocommerce' ); ?></a>
	</p>
<?php endif; ?>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<header>
	<h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>
</header>
<dl class="customer_details">
<?php
	if ($order->billing_email) echo '<dt>'.__( 'Email:', 'woocommerce' ).'</dt><dd>'.$order->billing_email.'</dd>';
	if ($order->billing_phone) echo '<dt>'.__( 'Telephone:', 'woocommerce' ).'</dt><dd>'.$order->billing_phone.'</dd>';
?>
</dl>

<?php if (get_option('woocommerce_ship_to_billing_address_only')=='no') : ?>

<div class="col2-set addresses">

	<div class="col-1">

<?php endif; ?>

		<header class="title">
			<h3><?php _e( 'Delivery Address', 'theretailer' ); ?></h3>
		</header>
		<address><p>
			<?php
				if (!$order->get_formatted_billing_address()) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_billing_address();
			?>
		</p></address>

<?php if ( 1==2 && get_option('woocommerce_ship_to_billing_address_only')=='no' && ($order->get_formatted_shipping_address()) ) : ?>

	</div><!-- /.col-1 -->

	<div class="col-2">

		<header class="title">
			<h3><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
		</header>
		<address><p>
			<?php
				if (!$order->get_formatted_shipping_address()) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_shipping_address();
			?>
		</p></address>

	</div><!-- /.col-2 -->

</div><!-- /.col2-set -->
</div>

<?php endif; ?>

<div class="clear"></div>
<br /><h5><?php echo __( 'Sincerely', 'theretailer' ) . ",<br />Aurelie.no"?></h5>
<br /><h5><?php echo get_option("woocommerce_email_footer_text")?></h5>