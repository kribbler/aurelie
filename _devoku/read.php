jQuery(document).ready(function($){
	<?php if ($_GET['n'] == 'right_sidebar'){?>
	$('#fromster').html(
		'<?php 
			//define('WP_USE_THEMES', true);
			if ( !isset($wp_did_header) ) {
				$wp_did_header = true;
				require_once( '../wp-load.php' );
				//wp();
				require_once( '../wp-settings.php' );
			} 
			
				$the_slug = 'sidebar-oku';
				$args=array(
				  'name' => $the_slug,
				  'post_type' => 'post',
				  'post_status' => 'publish',
				  'numberposts' => 1
				);
				
				$my_posts = get_posts($args);
				echo str_replace(array("\r", "\n"), '', $my_posts[0]->post_content);
				//echo 'daniel';
			?>'
	);
	$('#fromster').show();
	
	<?php } else if ($_GET['n'] == 'footer'){?>
	$('#Bottom').html(
		'<?php 
			//define('WP_USE_THEMES', true);
			if ( !isset($wp_did_header) ) {
				$wp_did_header = true;
				require_once( '../wp-load.php' );
				//wp();
				require_once( '../wp-settings.php' );
			} 
			
				$the_slug = 'footer-oku';
				$args=array(
				  'name' => $the_slug,
				  'post_type' => 'post',
				  'post_status' => 'publish',
				  'numberposts' => 1
				);
				
				$my_posts = get_posts($args);
				echo str_replace(array("\r", "\n"), '', $my_posts[0]->post_content);
				//echo 'daniel';
			?>'
	);
	$('#super_footer').show();
	<?php }?>
});