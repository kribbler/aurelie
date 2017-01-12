<?php /*
    Plugin Name: Aurelie Product Listing
    Plugin URI: http://oku.no
    Description: Show on product listing: permalinks, gallery images 
    Version: 1
    Author: Daniel Oraca
    Author URI: 
    Text Domain: aurelie-product-listing
    Domain Path: /languages/
*/

add_action('manage_posts_custom_column', 'my_render_post_columns', 10, 2);

add_action( 'admin_enqueue_scripts', 'apl_load_js_and_css' );

function apl_load_js_and_css(){
	global $hook_suffix;
	if (
		$hook_suffix == 'edit.php'
	) {		
		wp_enqueue_script( 'pretty_photo', plugins_url('/pretty_photo/js/jquery.prettyPhoto.js', __FILE__), array(), '1.0.0', true );
		wp_enqueue_script( 'pretty_photo_use', plugins_url('/pretty_photo/js/prettyPhoto_use.js', __FILE__), array(), '1.0.0', true );
		wp_register_style( 'pretty_photo_css', plugins_url('pretty_photo/css/prettyPhoto.css', __FILE__) );
		wp_enqueue_style( 'pretty_photo_css' );
	}
}


	

function my_render_post_columns($column_name, $id){
	switch ($column_name) {
	case 'name':
		echo get_permalink( $id ) . '<br />';
		break;
		
	case 'thumb':
		display_images_in_list($id);
		break;
		
	} 
	
}

function display_images_in_list($id) {
	if($images = get_posts(array(
		'post_parent'    => $id,
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
                'orderby'        => 'menu_order',
                'order'           => 'ASC',
	))) {
		
		echo '<ul class="gallery clearfix thumb_ul">';
		
		$k = 1;
		foreach($images as $image) {
			$thumb = wp_get_attachment_image_src($image->ID, 'thumbnail');
			$medium = wp_get_attachment_image_src($image->ID, 'medium');
			echo '<li><a href="'.$medium[0].'" rel="prettyPhoto[gallery'.$id.']"><img src="'.$thumb[0].'" width="60" height="60" /></a></li>';
			//if ($k++ > 3) break;
		}
		
		echo '</ul>';
	}
}
