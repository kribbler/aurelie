<?php
add_action('current_screen','pw_attribute_image');
if(!function_exists('pw_attribute_image'))
{
	function pw_attribute_image() {
		global $woocommerce, $_wp_additional_image_sizes;
		$screen = get_current_screen();
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		
		if ($attribute_taxonomies) {
			foreach ($attribute_taxonomies as $tax) {
	
			add_action('pa_' . $tax->attribute_name . '_add_form_fields', 'pw_add_attribute_image', 10, 2);
			add_action( 'pa_' .$tax->attribute_name . '_edit_form_fields','pw_edit_att_image', 10, 2);
			add_filter('manage_edit-pa_' . $tax->attribute_name . '_columns', 'pw_attribute_columns');
			add_filter('manage_pa_' . $tax->attribute_name . '_custom_column','pw_attribute_column', 10, 3);
			}
		}	
	}
	function pw_add_attribute_image() {
		global $woocommerce;
		$image = $woocommerce->plugin_url() . '/assets/images/placeholder.png';		
		?>
		<div class="form-field">
			<label><?php _e( 'Thumbnail', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?></label>
			<div id="brands_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="att_thumbnail_id" name="att_thumbnail_id" />
				<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?></button>
				<button type="button" class="remove_image_button button"><?php _e( 'Remove image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?></button>
			</div>
			<script type="text/javascript">
				 // Only show the "remove image" button when needed
				 if ( ! jQuery('#att_thumbnail_id').val() )
					 jQuery('.remove_image_button').hide();
	
				// Uploading files
				var file_frame;
	
				jQuery(document).on( 'click', '.upload_image_button', function( event ){
					
	
					event.preventDefault();
	
					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}
	
					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( 'Choose an image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?>',
						button: {
							text: '<?php _e( 'Use image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?>',
						},
						multiple: false
					});
	
					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						attachment = file_frame.state().get('selection').first().toJSON();
	
						jQuery('#att_thumbnail_id').val( attachment.id );
						jQuery('#brands_thumbnail img').attr('src', attachment.url );
						jQuery('.remove_image_button').show();
					});
	
					// Finally, open the modal.
					file_frame.open();
				});
	
				jQuery(document).on( 'click', '.remove_image_button', function( event ){
					jQuery('#brands_thumbnail img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
					jQuery('#att_thumbnail_id').val('');
					jQuery('.remove_image_button').hide();
					return false;
				});
	
			</script>
	<?php
	}
	
	function pw_edit_att_image($term,$taxonomy)
	{
		global $woocommerce;
		$thumbnail_id = get_woocommerce_term_meta($term->term_id,'thumbnail_id_attr', true);
		if ($thumbnail_id) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		}
		else
			$image = $woocommerce->plugin_url() . '/assets/images/placeholder.png';	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Thumbnail', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?></label></th>
			<td>
				<div id="brands_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
				<div style="line-height:60px;">
					<input type="hidden" id="att_thumbnail_id" name="att_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="submit" class="upload_image_button button"><?php _e( 'Upload/Add image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?></button>
					<button type="submit" class="remove_image_button button"><?php _e( 'Remove image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?></button>
				</div>
				<script type="text/javascript">
	
					// Uploading files
					var file_frame;
	
					jQuery(document).on( 'click', '.upload_image_button', function( event ){
	
						event.preventDefault();
	
						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}
	
						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( 'Choose an image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?>',
							button: {
								text: '<?php _e( 'Use image', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ); ?>',
							},
							multiple: false
						});
	
						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							attachment = file_frame.state().get('selection').first().toJSON();
	
							jQuery('#att_thumbnail_id').val( attachment.id );
							jQuery('#brands_thumbnail img').attr('src', attachment.url );
							jQuery('.remove_image_button').show();
						});
	
						// Finally, open the modal.
						file_frame.open();
					});
	
					jQuery(document).on( 'click', '.remove_image_button', function( event ){
						jQuery('#brands_thumbnail img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
						jQuery('#att_thumbnail_id').val('');
						jQuery('.remove_image_button').hide();
						return false;
					});
	
				</script>
				<div class="clear"></div>
				<?php
	}
	add_action('created_term', 'save_att_fields', 10, 3);
	add_action('edit_term','save_att_fields', 10, 3);
	function save_att_fields( $term_id, $tt_id, $taxonomy ) {
			if ( isset( $_POST['att_thumbnail_id'] ) )
				update_woocommerce_term_meta( $term_id, 'thumbnail_id_attr', absint( $_POST['att_thumbnail_id'] ) );
	}
	function pw_attribute_columns($columns) {
		$new_columns = array();
		$new_columns['cb'] = $columns['cb'];
		$new_columns['att_thumbnail_id'] = __('Thumbnail', __PW_WOO_AD_SEARCH_TEXTDOMAIN__);
		unset($columns['cb']);
		$columns = array_merge($new_columns, $columns);
		return $columns;
	}

	function pw_attribute_column($columns, $column, $id) {
		global $woocommerce;
		if ( $column == 'att_thumbnail_id' ) {
			$image 			= '';
			$thumbnail_id 	= get_woocommerce_term_meta( $id, 'thumbnail_id_attr', true );
			if ($thumbnail_id)
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			else
				$image = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
			$image = str_replace( ' ', '%20', $image );

			$columns .= '<img src="' . esc_url( $image ) . '" alt="Thumbnail" class="wp-post-image" height="48" width="48" />';
		}
		return $columns;		
	}
}


?>