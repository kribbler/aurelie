<div id="icon-tools" class="icon32"><br /></div>
<h2><?php _e( 'WoOKU Product Monitoring', 'wooku-monitoring' ); ?></h2>
<?php 
if (isset($_GET['process_id'])){
	$process_info = get_process_info($_GET['process_id']);
	$_POST = (array) $process_info;
}
?>

<?php include ('wooku-monitoring-menu.php');?>
<?php //echo "<pre>";var_dump($_POST); die();?>
<div id="loading_products">
	<img align="left" src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader1.gif" id="ajax_loading" style="display:block" />&nbsp;<span id="loading_products_text">Loading products... Please standby until it finishes checking them</span>
	<span id="products_counter"></span> 
</div>
<span id="start_date" style="display:none"><?php echo date("Y-m-d h:i:s")?></span>
<span id="stop_call">Abort the Monitoring Process</span><span id="pause_call">Save & Pause the Monitoring Process</span>
<table id="products_list">
	<tr>
		<?php $nr_cols = 0;?>
		<th>ID</th><?php $nr_cols++;?>
		<th>Safira Link</th><?php $nr_cols++;?>
		<th>Aurelie Link</th><?php $nr_cols++;?>
		<?php if (isset($_POST['check_http']) && $_POST['check_http']){?>
			<th>HTTP Response</th><?php $nr_cols++;?>
		<?php }?>
		<?php if (isset($_POST['check_stock']) && $_POST['check_stock']){?>
			<th>In Stock</th><?php $nr_cols++;?>
		<?php }?>
		<?php if (isset($_POST['check_matching_skus']) && $_POST['check_matching_skus']){?>
			<th>SKU Found</th><?php $nr_cols++;?>
		<?php }?>
		<?php if (isset($_POST['check_thumb']) && $_POST['check_thumb']){?>
			<th>Thumbnail</th><?php $nr_cols++;?>
		<?php } ?>
		<?php if (isset($_POST['set_id']) && $_POST['set_id']){?>
			<th>Monitoring Set</th><?php $nr_cols++;?>
		<?php } ?>
		<th>Actions</th><?php $nr_cols++;?>
	</tr>
	<tr>
		<th colspan = "<?php echo $nr_cols - 1;?>" style="text-align: right">
			Bulk Actions
		</th>
		<th>
			<button class='button-delete-bulk' type='submit' value=''>Delete</button>
			<button class='button-trash-bulk' type='submit' value=''>Trash</button>
			<button class='button-pending-bulk' type='submit' value=''>Pending</button>
		</th>
	</tr>
	<?php if (isset($_POST['offset']) && $_POST['offset']) echo stripcslashes($_POST['last_trs'])?>
</table>

<div id="loading_products2">
	<img align="left" src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader1.gif" id="ajax_loading2" style="display:block" />&nbsp;<span id="loading_products_text2">Loading products... Please stand by until it finishes checking them</span>
	<span id="products_counter2"></span> 
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$('#loading_products').show();
	$('#loading_products2').show();

	var offset = 0;
	var products_displayed = 0;
	<?php if (isset($_POST['offset']) && $_POST['offset']) {
		echo "offset = " . $_POST['offset'] . ';';
		echo "products_displayed = " . $_POST['offset'] . ";";
	}
	?>
	start_quering_products(1, offset);
	
	var loaded_ids = new Array();
	var data, v_product, ajaxProcess;
	var last_trs = "";

	<?php if(isset($_POST['last_trs']) && $_POST['last_trs']) echo "last_trs = \"" . $_POST['last_trs'] . "\";";?>
	
	$('#pause_call').click(function(){
		$('#stop_call').trigger('click');

		$('#products_counter').hide();
		$('#loading_products_text').html('Pausing the monitoring process');
		$('#loading_products').show();
		
		data.action = "wooku-save-paused-process-ajax";
		data.start_date = $('#start_date').html();
		data.rows_checked = products_displayed;
		data.rows_unchecked = v_product.total_products - products_displayed;
		data.last_trs = last_trs;
		<?php if (isset($_POST['id']) && $_POST['id']) echo "data.id = " . $_POST['id'] . ";";?>
		ajaxSaveProcess = $.post(ajaxurl, data, ajaxPauseCallback);
	});

	$('#stop_call').click(function(){
		ajaxProcess.abort();
		$('#loading_products').hide();
		$('#loading_products2').hide();
		$('#stop_call').hide();
	});
	
	function start_quering_products(limit, offset){
		data = {
			"action"					: "wooku-load-products-ajax",
			"seller"					: "<?php echo $_POST['seller']?>",
			"limit" 					: limit,
			"monitoring_set"			: "<?php echo $_POST['set_id']; ?>",
			"check_http"				: "<?php echo (isset($_POST['check_http']) && $_POST['check_http']) ? 1 : 0; ?>",
			"check_stock"				: "<?php echo (isset($_POST['check_stock']) && $_POST['check_stock']) ? 1 : 0; ?>",
			"check_thumb"				: "<?php echo (isset($_POST['check_thumb']) && $_POST['check_thumb']) ? 1 : 0; ?>",
			"check_published"			: "<?php echo (isset($_POST['check_published']) && $_POST['check_published']) ? 1 : 0; ?>",
			"check_matching_skus"		: "<?php echo (isset($_POST['check_matching_skus']) && $_POST['check_matching_skus']) ? 1 : 0; ?>",
			"list_incomplete"			: "<?php echo (isset($_POST['list_incomplete']) && $_POST['list_incomplete']) ? 1 : 0; ?>",
			"list_when_text_found"		: "<?php echo (isset($_POST['list_when_text_found']) && $_POST['list_when_text_found']) ? 1 : 0; ?>",
			"list_when_text_not_found"	: "<?php echo (isset($_POST['list_when_text_not_found']) && $_POST['list_when_text_not_found']) ? 1 : 0; ?>",
			"offset"			: offset,
			"rows_unchecked"	: "<?php echo $process_info->rows_unchecked;?>"
		};
		$('#ajax_loading').show();
		ajaxProcess = $.post(ajaxurl, data, ajaxCheckCallback);
	}

	function ajaxPauseCallback(response_text) {
		//console.log(response_text);
		//return false;
		window.location.href="<?php echo get_admin_url().'tools.php?page=wooku-monitoring'?>";
	}
	
	function ajaxCheckCallback(response_text) {
		var response = jQuery.parseJSON(response_text);
		
		can_continue = false;
		//console.log(response); return false;
		var k = 0;
		$.each(response.products, function(i, product){
			//console.log(product); return false;
			can_continue = response.can_continue;
			show_response(product, response.total_products);
			k++;
		});

		if (k==0) {
			show_response("", response.total_products);
		}
		if (response.new_offset <= response.total_products)
			can_continue = true;

		if (can_continue){
			start_quering_products(response.limit, response.new_offset);
		} else {
			$('#loading_products').hide();
			$('#loading_products2').hide();
			return false;
		}

	}	

	function show_counter(total){
		products_displayed++;
		$('#products_counter').html(products_displayed + '/' + total);
		$('#products_counter2').html(products_displayed + '/' + total);
	}
	
	function show_response(product, total_products){
		if (product) {
			show_counter(product.total_products);
			v_product = product;
			if (product.show_only_incomplete == 1){
				if (!product.product_ok){
					show_product_line(product);
				}
			} else {
				if (product.Monitoring){
					var monitored_text_found = true;
					$.each(product.Monitoring, function (i, v){
						if (!v) monitored_text_found = false;
					});
					if (product.list_when_text_not_found == 1 && !monitored_text_found){
						show_product_line(product);
					} else if (product.list_when_text_not_found == 1 && monitored_text_found){
					} else if (product.list_when_text_found == 1 && !monitored_text_found){
					} else if (product.list_when_text_found == 1 && monitored_text_found){
						show_product_line(product);
					}
				} else {
					show_product_line(product);
				}
			}	
		} else {
			show_counter(total_products);
		}
	}

	function show_product_line(product){
		var product_seller_link = "<a href='" + product.real_link + "' target='_blank'>" + product.title + "</a>";
		var product_oku_link = "<a href='" + product.link_oku + "' target='_blank'>" + product.title + "</a>";
		var product_link_http_status = product.link_http_status;
		var product_thumb_http_status = product.thumb_http_status;
		var product_stock_http_status = product.stock_http_status;
		console.log(product);
		var product_matching_skus = product.sku_http_status;
		if (product_link_http_status > 400) {
			product_link_http_status = "<span class='red'>" + product_link_http_status + "</span>";
		}

		if (product_thumb_http_status > 400) {
			product_thumb_http_status = "<span class='red'>" + product_thumb_http_status + "</span>";
		}

		if (product_matching_skus == "not found"){
			product_matching_skus = "<span class='red'>" + product_matching_skus + "</span>";
		}

		if (product_stock_http_status == "not found"){
			product_stock_http_status = "<span class='red'>" + product_stock_http_status + "</span>";
		}
		//console.log(product_stock_http_status);

		monitoring_set_response = 'No monitoring set selected';
		if (product.Monitoring){
			var product_monitoring = product.Monitoring;
			var monitoring_set_response = "";
			
			$.each(product_monitoring, function (index, value){
				//console.log(index); console.log(value);
				monitoring_set_response += "<b>" + index + "</b>" + ": ";
				if (value){
					monitoring_set_response += value;
				} else {
					monitoring_set_response += "<span class='red'>" + value + "</span>";
				}
				monitoring_set_response += "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			});
		}
		
		var tr = "<tr id='tr_" + product.id + "'>";
		tr += "<td>" + product.id + "</td>";
		tr += "<td>" + product_seller_link + "</td>";
		tr += "<td>" + product_oku_link + "</td>";
		<?php if (isset($_POST['check_http']) && $_POST['check_http']){?>
			tr += "<td>" + product_link_http_status + "</td>";
		<?php } ?>
		<?php if (isset($_POST['check_matching_skus']) && $_POST['check_matching_skus']){?>
			tr += "<td>" + product_matching_skus + "</td>";
		<?php } ?>
		<?php if (isset($_POST['check_stock']) && $_POST['check_stock']){?>
			tr += "<td>" + product_stock_http_status + "</td>";
		<?php } ?>
		<?php if (isset($_POST['check_thumb']) && $_POST['check_thumb']){?>
			tr += "<td>" + product_thumb_http_status + "</td>";
		<?php } ?>
		<?php if (isset($_POST['set_set']) && $_POST['set_id']){?>
			tr += "<td>" + monitoring_set_response + "</td>";
		<?php } ?>
		//tr += "<td><span class='delete_products' id='delete_" + product.id + "'>Delete</span>";
		tr += "<td>";
			tr += "<button class='button-delete' type='submit' value='" + product.id + "'>Delete</button>";
			tr += "<button class='button-trash' type='submit' value='" + product.id + "'>Trash</button>";
			tr += "<button class='button-pending' type='submit' value='" + product.id + "'>Pending</button>";
		tr += "</td>";
		tr += "</tr>";
		$('#products_list').append(tr);

		last_trs += tr;
		console.log(tr);
		loaded_ids.push( product.id );
	}

	$('.button-delete').live('click', function(){
		if(confirm('Are you sure you want to delete this product?')){
			//deleting the product
			var id = $(this).attr('value');
			var data = {
				"action"	: "wooku-delete-product-ajax",
				"id"		: id
			};
			$('#ajax_loading').show();
			$.post(ajaxurl, data, ajaxDeleteCallback);
			
		} else {
			return false;
		}
	});

	$('.button-delete-bulk').live('click', function(){
		if(confirm('Are you sure you want to delete this product?')){
			$.each(loaded_ids, function(index, id){
				var data = {
					"action"	: "wooku-delete-product-ajax",
					"id"		: id
				};
				$('#ajax_loading').show();
				$.post(ajaxurl, data, ajaxDeleteCallback);
			});
		} else {
			return false;
		}
	});

	$('.button-trash').live('click', function(){
		if(confirm('Are you sure you want to move this product to trash?')){
			var id = $(this).attr('value');
			var data = {
				"action"	: "wooku-trash-product-ajax",
				"id"		: id
			};
			$('#ajax_loading').show();
			$.post(ajaxurl, data, ajaxTrashCallback);
			
		} else {
			return false;
		}
	});

	$('.button-trash-bulk').live('click', function(){
		if(confirm('Are you sure you want to move this product to trash?')){
			$.each(loaded_ids, function(index, id){
				var data = {
					"action"	: "wooku-trash-product-ajax",
					"id"		: id
				};
				$('#ajax_loading').show();
				$.post(ajaxurl, data, ajaxTrashCallback);
			});
		} else {
			return false;
		}
	});

	$('.button-pending').live('click', function(){
		if(confirm('Are you sure you want to change the status to PENDING?')){
			var id = $(this).attr('value');
			var data = {
				"action"	: "wooku-pending-product-ajax",
				"id"		: id
			};
			$('#ajax_loading').show();
			$.post(ajaxurl, data, ajaxPendingCallback);
			
		} else {
			return false;
		}
	});

	$('.button-pending-bulk').live('click', function(){
		if(confirm('Are you sure you want to change the status to PENDING?')){
			$.each(loaded_ids, function(index, id){
				var data = {
					"action"	: "wooku-pending-product-ajax",
					"id"		: id
				};
				$('#ajax_loading').show();
				$.post(ajaxurl, data, ajaxPendingCallback);
			});
		} else {
			return false;
		}
	});

	function ajaxDeleteCallback(response_text) {
		var response = jQuery.parseJSON(response_text);
		$('#tr_' + response.id).hide();
		return false;
	}	
	
	function ajaxTrashCallback(response_text) {
		var response = jQuery.parseJSON(response_text);
		$('#tr_' + response.id).hide();
		return false;
	}	
	
	function ajaxPendingCallback(response_text) {
		var response = jQuery.parseJSON(response_text);
		$('#tr_' + response.id).hide();
		return false;
	}	
	
});
</script>