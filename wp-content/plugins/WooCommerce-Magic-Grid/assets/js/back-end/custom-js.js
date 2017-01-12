jQuery(function(jQuery) {
	
	if ( ! jQuery('.custom_upload_image').val() )
	{
		jQuery('.pw_woo_ad_search_remove_image_button').hide();
	}

	// Uploading files
	var file_frame;

	jQuery(document).on( 'click', '.pw_woo_search_upload_image_button', function( event ){

		event.preventDefault();
		
		formfield = jQuery(this).siblings('.custom_upload_image');
		preview = jQuery(this).siblings('.custom_preview_image');
		
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.downloadable_file = wp.media({
			title: 'Choose image',
			button: {
				text: 'Use image',
			},
			multiple: false
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();

			formfield.val( attachment.id );
			preview.attr('src', attachment.url );

			jQuery('.pw_woo_ad_search_remove_image_button').show();
		});

		// Finally, open the modal.
		file_frame.open();
	});

	jQuery(document).on( 'click', '.pw_woo_ad_search_remove_image_button', function( event ){
		
		formfield = jQuery(this).siblings('.custom_upload_image');
		preview = jQuery(this).siblings('.custom_preview_image');
	
		formfield.val('');
		preview.attr('src', '' );
		jQuery(this).siblings('.pw_woo_ad_search_remove_image_button').hide();
		return false;
	});
	
	/*jQuery('.hndle').click(function(){
		
		setTimeout(function(){
			
			jQuery('.chosen-select').each(function(index, element) {
				jQuery(this).chosen();
				jQuery(this).trigger("chosen:updated");
				jQuery(this).multiselect('refresh');
			});
			
		},1000);
		
	});*/
	
	
	
});