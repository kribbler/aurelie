<div id="icon-tools" class="icon32"><br /></div>
<h2><?php _e( 'WoOKU Product Monitoring', 'wooku-monitoring' ); ?></h2>
<?php include ('wooku-monitoring-menu.php');?>
<?php //var_dump($_POST); die();?>
<div id="loading_products">
	<img align="left" src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader1.gif" id="ajax_loading" style="display:block" />&nbsp;<span id="loading_products_text">Loading products... Please stand by until it finishes checking them</span> 
</div>

<table id="products_list">
	<tr>
		<th>ID</th>
		<th>Actions</th>
	</tr>
</table>

<div id="loading_products2">
	<img align="left" src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader1.gif" id="ajax_loading2" style="display:block" />&nbsp;<span id="loading_products_text2">Loading products... Please stand by until it finishes checking them</span> 
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$('#loading_products').show();
	$('#loading_products2').show();
	start_quering_products(1, 0);
	
	function start_quering_products(limit, offset){
		var data = {
			"action"			: "wooku-load-products-to-delete-ajax",
			"limit" 			: limit,
			"offset"			: offset
		};
		$('#ajax_loading').show();
		$.post(ajaxurl, data, ajaxCheckCallback);
	}

	function ajaxCheckCallback(response_text) {
		var response = jQuery.parseJSON(response_text);
		
		can_continue = false;
		//console.log(response); //return false;
		$.each(response.products, function(i, product){
			//console.log(product); return false;
			can_continue = response.can_continue;
			show_response(product);
		});
		
		if (can_continue){
			start_quering_products(response.limit, response.new_offset);
		} else {
			$('#loading_products').hide();
			$('#loading_products2').hide();
			return false;
		}

	}	

	function show_response(product){
		console.log(product);
		
		var tr = "<tr id='tr_" + product.id + "'>";
		tr += "<td>" + product.id + "</td>";
		tr += "<td><button class='button-primary' type='submit' value='" + product.id + "'>Delete</button>";
		tr += "</tr>";
		$('#products_list').append(tr);

		var id = $(this).attr('value');
		var data = {
			"action"	: "wooku-delete-product-ajax",
			"id"		: id
		};
		$('#ajax_loading').show();
		$.post(ajaxurl, data, ajaxDeleteCallback);

		function ajaxDeleteCallback(response_text) {
			var response = jQuery.parseJSON(response_text);
			$('#tr_' + response.id).hide();
			return false;
		}	
	}

	

	
	
});
</script>