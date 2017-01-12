<?php
/*
    Plugin Name: Aurelie Printed Delivery Confirmation
    Plugin URI: http://aurelie.no
    Description: Aurelie Printed Delivery Confirmation
    Version: 1
    Author: Daniel Oraca
    Author URI:     
 */

/**
 * Check if WooCommerce is active
 **/

add_action('plugins_loaded', 'init_aurelie_printed_delivery_confirmation', 0);

function init_aurelie_printed_delivery_confirmation() {
    if ( ! class_exists( 'WC_Shipping_Method' ) ) return;
    
    class aurelie_Printed_Delivery_Confirmation extends WC_Shipping_Method {
    	
    	function __construct() { 
			$this->id = 'aurelie_Printed_Delivery_Confirmation';
			$this->method_title = __( 'Aurelie Printed Delivery Confirmation', 'woocommerce' );
		
			$this->admin_page_heading 	= __( 'Weight based shipping', 'woocommerce' );
			$this->admin_page_description 	= __( 'Define shipping by weight and country', 'woocommerce' );

			$this->order_id					= NULL;

            load_plugin_textdomain('aurelie_Printed_Delivery_Confirmation', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
			add_action( 'woocommerce_update_options_shipping_' . $this->id, array( &$this, 'process_admin_options' ) );

			$this->init();      
    	}
    
		function init() {
			$this->init_form_fields();
			$this->init_settings();

			$this->enabled			= $this->settings['enabled'];
			$this->title			= $this->settings['title'];
			//$this->availability		= 'specific';
			//$this->type				= 'order';
			
			$this->set_options();
						
    	}
    	
    	function set_options(){
    		/**
    		 * set the checked shipping methods
    		 * also, set 'eVarsling' state 
    		 */

    		$this->options = array();
    		
    		for ($k = 1; $k <= 4; $k++){
	    		if ( $this->settings["shipping_option_$k"] == 'yes' ){
	    			$this->options[] = $this->form_fields["shipping_option_$k"]['label'];
	    		}
    		}
    		
    	}
    	
    function init_form_fields() {
    	global $woocommerce;
        	$this->form_fields = array(
				
				'title'	=> array(
					'title'			=> 'Title',
    				'label'			=> __( 'Title', 'aurelie_Printed_Delivery_Confirmation' ),
    				'type'			=> 'text',
    				'desc_tip'		=> __( 'This is the title' )
				),
				
				'greetings'	=> array(
					'title'			=> 'Greetings',
    				'label'			=> __( 'Greetings', 'aurelie_Printed_Delivery_Confirmation' ),
    				'type'			=> 'text',
    				'desc_tip'		=> __( 'This is the "greetings text"' )
				),
				
				'thankyou'	=> array(
					'title'			=> 'Thank you',
    				'label'			=> __( 'Thank you', 'aurelie_Printed_Delivery_Confirmation' ),
    				'type'			=> 'textarea',
    				'desc_tip'		=> __( 'This is the "thank you text"' )
				),
				
				'order_details'	=> array(
					'title'			=> 'Order Details',
    				'label'			=> __( 'Order Details', 'aurelie_Printed_Delivery_Confirmation' ),
    				'type'			=> 'text',
    				'desc_tip'		=> __( 'This is the "order details text"' )
				),
				
				'bellow1'	=> array(
					'title'			=> 'Bellow1',
    				'label'			=> __( 'Bellow1', 'aurelie_Printed_Delivery_Confirmation' ),
    				'type'			=> 'textarea',
    				'desc_tip'		=> __( 'This is the "Your orders on... text"' )
				),
				
				'bellow2'	=> array(
					'title'			=> 'Bellow2',
    				'label'			=> __( 'Bellow2', 'aurelie_Printed_Delivery_Confirmation' ),
    				'type'			=> 'textarea',
    				'desc_tip'		=> __( 'This is the "How to return items text"' )
				),
				
				'footer'	=> array(
					'title'			=> 'Footer',
    				'label'			=> __( 'Footer', 'aurelie_Printed_Delivery_Confirmation' ),
    				'type'			=> 'text',
    				'desc_tip'		=> __( 'This is the "footer text"' )
				),
			);
			__( 'PDF2 Seller Name', 'aurelie_Printed_Delivery_Confirmation' );
			__( 'PDF2 Seller Address', 'aurelie_Printed_Delivery_Confirmation' );
			__( 'PDF2 Seller Phone', 'aurelie_Printed_Delivery_Confirmation' );
			__( 'PDF2 Seller Fax', 'aurelie_Printed_Delivery_Confirmation' );
			__( 'PDF2 Seller Email', 'aurelie_Printed_Delivery_Confirmation' );
    	}
 
    function is_available( $package ) {
		global $woocommerce;

		$is_available = false;

		return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', $is_available, $package );
	}
	
	    public function admin_options() {
            ?>
	    	<h3><?php _e('Aurelie Printed Delivery Confirmation', 'woocommerce'); ?></h3>
	    	<h4>Warning! Bellow fields are not used when displaing generated pdf. To edit the content please use 'Codestyling Localization' plugin. <br />
	    	You've been warned! :-)</h4>
	    	<table class="form-table">
	    	<?php
	    		// Generate the HTML For the settings form.
	    		$this->generate_settings_html();
	    	?>
			</table><!--/.form-table-->
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				
			});
			</script>
	    	<?php
	    }
    }
}

/**
 * Add shipping method to WooCommerce
 **/
function add_aurelie_Printed_Delivery_Confirmation( $methods ) {
	$methods[] = 'aurelie_Printed_Delivery_Confirmation'; return $methods;
}

add_filter( 'woocommerce_shipping_methods', 'add_aurelie_Printed_Delivery_Confirmation' );

function woocommerce_meta_boxes_aurelie_pdf($mb){
	add_meta_box( 
		'woocommerce-aurelie_pdf', 
		__( 'Aurelie Printed Delivery Confirmation', 'woocommerce' ), 
		'woocommerce_aurelie_pdf', 
		'shop_order', 
		'side', 
		'default'
	);
	return $mb;
}

function woocommerce_aurelie_pdf(){
	global $post, $wpdb, $thepostid, $woocommerce, $theorder;
    load_plugin_textdomain('aurelie_Printed_Delivery_Confirmation', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
	$option = get_option( 'woocommerce_aurelie_Printed_Delivery_Confirmation_settings' );

	$bacs_settings =  get_option( 'woocommerce_bacs_settings');

	?>
	<input type="hidden" id="aurelie_order_id" value="<?php echo $post->ID?>" />
	<input type="hidden" id="aurelie_logo" value="<?php echo (plugins_url( 'include/images/logo.png' , __FILE__ ))?>" />
	<input type="hidden" id="aurelie_title" value="<?php _e( 'Title', 'aurelie_Printed_Delivery_Confirmation' )?>" />
	<input type="hidden" id="aurelie_greetings" value="<?php _e( 'Greetings', 'aurelie_Printed_Delivery_Confirmation' )?> <?php echo $theorder->billing_first_name?> <?php echo $theorder->billing_last_name?>," />
	<input type="hidden" id="aurelie_thankyou" value="<?php _e( 'Thank you', 'aurelie_Printed_Delivery_Confirmation' )?>" />
	<input type="hidden" id="aurelie_footer" value="<?php _e( 'Footer', 'aurelie_Printed_Delivery_Confirmation' )?>" />
	<input type="hidden" id="aurelie_address" value="<?php echo $theorder->get_formatted_billing_address()?>" />
	<input type="hidden" id="aurelie_shipping_address" value="<?php _e( 'Shipping Address', 'aurelie_Printed_Delivery_Confirmation' )?>" />
	<input type="hidden" id="aurelie_account_number" value="<?php _e( 'Account Number', 'aurelie_Printed_Delivery_Confirmation' )?>: <b><?php echo $bacs_settings['account_number']?></b>" />
	<input type="hidden" id="aurelie_order_number" value="<?php _e( 'Order Number', 'aurelie_Printed_Delivery_Confirmation' )?>: <b><?php echo $post->ID?></b>" />
	<input type="hidden" id="aurelie_invoice_number" value="<?php _e( 'Invoice Number', 'aurelie_Printed_Delivery_Confirmation' )?>: <b><?php echo $post->ID?></b>" />
	<input type="hidden" id="aurelie_date_number" value="<?php _e( 'Invoice Date', 'aurelie_Printed_Delivery_Confirmation' )?>: <b><?php echo convert_date(date("Y-m-d"))?></b>" />
	<input type="hidden" id="aurelie_side_number" value="<?php _e( 'Side', 'aurelie_Printed_Delivery_Confirmation' )?>: <b>1/1</b>" />
	
	<input type="hidden" id="aurelie_order_details" value="<?php echo $option['order_details']?>" />
	<?php

	$the_date = convert_date($theorder->order_date);
	
	?>
	<input type="hidden" id="aurelie_bellow0" value="<?php printf( __( 'Your orders on %s was also carried out by way of payment: %s. The total amount of %s is charged to your card. Thank you for your purchase!', 'aurelie_Printed_Delivery_Confirmation' ), $the_date, $theorder->payment_method_title, $theorder->order_total)?>" />
	<input type="hidden" id="aurelie_bellow1" value="<?php _e( 'Bellow1', 'aurelie_Printed_Delivery_Confirmation' )?>" />
	<input type="hidden" id="aurelie_bellow2" value="<?php _e( 'Bellow2', 'aurelie_Printed_Delivery_Confirmation' )?>" />
	
	<input type="hidden" id="aurelie_shipping_cost" value="<?php echo $theorder->order_shipping?>" />
	<input type="hidden" id="aurelie_shipping_method" value="<?php _e($theorder->get_shipping_method(), 'theretailer')?>" />
	<input type="hidden" id="aurelie_cart_subtotal" value="<?php _e( 'Cart Subtotal', 'aurelie_Printed_Delivery_Confirmation' ) ?>" />
	<input type="hidden" id="aurelie_shipping_text" value="<?php _e( 'Shipping', 'aurelie_Printed_Delivery_Confirmation' ) ?>" />
	
	<input type="hidden" id="aurelie_order_tax" value="<?php echo $theorder->order_tax?>" />
	
	<?php $order = $theorder;
	$pdf_order = array(); $k = 0;
	
	foreach ($order->get_items() as $item){
		
		$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );
		$pdf_order['items'][$k]['name'] = $item['name'];
		$pdf_order['items'][$k]['qty'] = $item['qty'];
		$pdf_order['items'][$k]['line_total'] = $item['line_total'];
		$k++;
	}
	
	if ( $totals = $order->get_order_item_totals() ) foreach ( $totals as $key=>$value ) :
			if ($key == 'order_total') : 	
				$pdf_order['total']['label'] = $value['label'];
				$pdf_order['total']['value'] = $value['value'];
			endif;
	endforeach;
	
	$pdf_order['translate']['product'] = __( 'Product', 'woocommerce' );
	$pdf_order['translate']['total'] = __( 'Total', 'woocommerce' );
	
	/**
	 * added on 20140214 to include tax row on pdf
	 */
	
	$t=0;$ttax=0;
	$is = $order->get_items();
	foreach ($is as $i){
		$t = $t + $i['line_total'];
		$ttax = $ttax + $i['line_tax'];
	}
	$t=round($t);$ttax = round($ttax);
	/*
	 * the end
	 */
	
	?>

	<input type="button" class="button" id="aurelie_generate_pdf" value="Generate PDF" />
	
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#aurelie_generate_pdf').click(function(){
			var order_id = $('#aurelie_order_id').val();
			var logo = $('#aurelie_logo').val();
			var title = $('#aurelie_title').val();
			var greetings = $('#aurelie_greetings').val();
			var thankyou = $('#aurelie_thankyou').val();
			var footer = $('#aurelie_footer').val();
			var address = $('#aurelie_address').val();
			var shipping_address = $('#aurelie_shipping_address').val();
			var info_account = $('#aurelie_account_number').val();
			var info_order = $('#aurelie_order_number').val();
			var info_invoice = $('#aurelie_invoice_number').val();
			var info_date = $('#aurelie_date_number').val();
			var info_side = $('#aurelie_side_number').val();
			var bellow0 = $('#aurelie_bellow0').val();
			var bellow1 = $('#aurelie_bellow1').val();
			var bellow2 = $('#aurelie_bellow2').val();
			var order_details = $('#aurelie_order_details').val();

			var shipping_cost = $('#aurelie_shipping_cost').val();
			var shipping_method = $('#aurelie_shipping_method').val();
			var cart_subtotal = $('#aurelie_cart_subtotal').val();
			
			var shipping_text = $('#aurelie_shipping_text').val();

			var item_total_label = '<?php echo $pdf_order['total']['label']?>';
			var item_total_value = '<?php echo $pdf_order['total']['value']?>';
			<?php foreach ($pdf_order['items'] as $key=>$value){
				echo "var item_name_$key = '" . $value['name'] . "';";
				echo "var item_qty_$key = '" . $value['qty'] . "';";
			}
			?>
			
			$.ajax({
				url: '<?php echo plugins_url( 'generate_pdf.php' , __FILE__ )?>',
				data: {
					'order_id'			: order_id, 
					'logo'				: logo,
					'title'				: title,
					'greetings'			: greetings,
					'thankyou'			: thankyou,
					'footer'			: footer,
					'address'			: address,
					'shipping_address'	: shipping_address,
					'info_account'		: info_account,
					'info_order'		: info_order,
					'info_invoice'		: info_invoice,
					'info_date'			: info_date,
					'info_side'			: info_side,
					'bellow0'			: bellow0,
					'bellow1'			: bellow1,
					'bellow2'			: bellow2,
					'order_details'		: order_details,
					'items_json'		: '<?php echo serialize($pdf_order)?>',
					'item_total'		: '<?php echo count($order->get_items())?>',
					'item_total_label'	: item_total_label,
					'item_total_value'	: item_total_value,
					'shipping_cost'		: shipping_cost,
					'shipping_method'	: shipping_method,
					'cart_subtotal'		: cart_subtotal,
					//'order_tax'			: order_tax,
					'total_order'		: '<?php echo $t?>',
					'total_tax'			: '<?php echo $ttax?>',
					'tax_label'			: '<?php _e( 'Incl. tax', 'aurelie_Printed_Delivery_Confirmation' )?>',
					'shipping_text'		: shipping_text,
					<?php foreach ($pdf_order['items'] as $key=>$value){
						echo "'item_name_$key' : '" . $value['name'] . "',";
						echo "'item_qty_$key' : '" . $value['qty'] . "',";
					}
					?>
				},
				type: "POST",
				success: function(){
					window.open('<?php echo plugins_url( 'export.pdf' , __FILE__ )?>', 'g');
				}
			});
			
		});
	});
	</script>
	
	<fieldset style="margin-top:15px;">
		<h4>Second PDF</h4>
		<?php //var_dump($order)?>
		<label for="pdf2_name">Seller's name: </label><br />
		<input style="width:100%" type="text" name="pdf2_name" id="pdf2_name" value="<?php _e( 'PDF2 Seller Name', 'aurelie_Printed_Delivery_Confirmation' )?>" /><br />
		
		<label for="pdf2_address">Seller's address: </label><br />
		<textarea style="width:100%" name="pdf2_address" id="pdf2_address"><?php _e( 'PDF2 Seller Address', 'aurelie_Printed_Delivery_Confirmation' )?></textarea><br />
		
		<label for="pdf2_phone">Phone Number: </label><br />
		<input style="width:100%" type="text" name="pdf2_phone" id="pdf2_phone" value="<?php _e( 'PDF2 Seller Phone', 'aurelie_Printed_Delivery_Confirmation' )?>" /><br />
		
		<label for="pdf2_fax">Fax: </label><br />
		<input style="width:100%" type="text" name="pdf2_fax" id="pdf2_fax" value="<?php _e( 'PDF2 Seller Fax', 'aurelie_Printed_Delivery_Confirmation' )?>" /><br />
		
		<label for="pdf2_email">Seller's email: </label><br />
		<input style="width:100%" type="text" name="pdf2_email" id="pdf2_email" value="<?php _e( 'PDF2 Seller Email', 'aurelie_Printed_Delivery_Confirmation' )?>" /><br />
		
		<label for="pdf2_order_number">Order number: </label><br />
		<input style="width:100%" type="text" name="pdf2_order_number" id="pdf2_order_number" value="<?php echo $post->ID?>" /><br />
		
		<label for="pdf2_date_agreement">The agreement was signed on: </label><br />
		<input style="width:100%" type="text" name="pdf2_date_agreement" id="pdf2_date_agreement" value="<?php echo convert_date($order->order_date)//echo date("d/m, Y", strtotime($order->order_date));?>" /><br />
		
		<label for="pdf2_date_form">The form is submitted / sent on: </label><br />
		<input style="width:100%" type="text" name="pdf2_date_form" id="pdf2_date_form" value="<?php echo convert_date(date("Y-m-d"))?>" /><br />
		
		<input type="button" class="button" id="aurelie_generate_pdf2a" value="Generate PDF 2 (page 1)" />
		<input type="button" class="button" id="aurelie_generate_pdf2b" value="Generate PDF 2 (page 2)" />
	</fieldset>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#aurelie_generate_pdf2a').click(function(){
			$.ajax({
				url: '<?php echo plugins_url( 'generate_pdf2a.php' , __FILE__ )?>',
				data: {
					'pdf2_name'				: $('#pdf2_name').val(),
					'pdf2_address'			: $('#pdf2_address').val(),
					'pdf2_phone'			: $('#pdf2_phone').val(),
					'pdf2_fax'				: $('#pdf2_fax').val(),
					'pdf2_email'			: $('#pdf2_email').val(),
					'pdf2_order_number'		: $('#pdf2_order_number').val(),
					'pdf2_date_agreement'	: $('#pdf2_date_agreement').val(),
					'pdf2_date_form'		: $('#pdf2_date_form').val(),
					'pdf2_customer_name'	: '<?php echo $order->billing_first_name; echo ( $order->billing_last_name ) ? " " . $order->billing_last_name : "" ?>',
					'pdf2_customer_address'	: '<?php echo $order->billing_address_1 . ', ' . $order->billing_postcode . ' ' . $order->billing_city; ?>',
					'pdf2_customer_phone'	: '<?php echo $order->billing_phone;?>',
					'pdf2_customer_email'	: '<?php echo $order->billing_email;?>'
				},
				type: "POST",
				success: function(){
					window.open('<?php echo plugins_url( 'pdf2.pdf' , __FILE__ )?>', 'g');
				}
			});

		});

		$('#aurelie_generate_pdf2b').click(function(){
			$.ajax({
				url: '<?php echo plugins_url( 'generate_pdf2b.php' , __FILE__ )?>',
				type: "POST",
				success: function(){
					window.open('<?php echo plugins_url( 'pdf2b.pdf' , __FILE__ )?>', 'g');
				}
			});
			
		});
	});
	</script>
	
	<?php 
	 
}

function convert_date($date){
	$date = explode(" ", $date);
	$date = $date[0];
	$date = explode("-", $date);
	foreach ($date as $key=>$value){
		$date[$key] = (int)$value;
	}
	$date = $date[2] . '/' . $date[1] . ', ' . $date[0];
	
	return $date;
}
add_action( 'add_meta_boxes', 'woocommerce_meta_boxes_aurelie_pdf' );

function get_customer_number($post){
	$customer_user = absint( get_post_meta( $post->ID, '_customer_user', true ) );
	if ( $customer_user ) {
		$user = get_user_by( 'id', $customer_user );
		return $user->ID;
	} 
	return NULL;
	
}