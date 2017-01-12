<?php
	
	global $pw_woo_ad_main_class;
	$pw_woo_ad_main_class->fetch_custom_fields($fetch_post_id);
	
	$thumbnail_id = get_post_meta( $fetch_post_id, '_thumbnail_id',true);
	$src_featured = wp_get_attachment_image( $thumbnail_id, 'thumbnail');
	
	
	$thumbnail_size = 'thumbnail';
	
	$thumbnail_id = get_post_meta( $fetch_post_id, '_thumbnail_id',true);
	$src_featured = wp_get_attachment_image( $thumbnail_id, $thumbnail_size ,0,array("style"=>"width:auto !important"));						
	$img1=$img2=$src_featured;
	
	
	$output .= '
	<li >
		<div class="woo-favitem-cnt">
			<div class="woo-favitem-thumb"><a href="'.get_the_permalink().'" title="'.__('View the ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) . get_the_title().'">'.$img1.'</a>
				<span class="woo-addfav  grid-unfavorite-icon favorite-icon favorite"  title="'.__('Remove From Favorites',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" ><i data-property-id="'.$fetch_post_id.'" class="fa fa-times pw-woo-ad-search-favorite"></i></span>
			</div>
			<a class="woo-favitem-title" href="'.get_the_permalink().'" title="'.__('View the ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) . get_the_title().'">'.get_the_title().'</a>
			';	
			
		$output .= '
		</div>
	</li>';
?>