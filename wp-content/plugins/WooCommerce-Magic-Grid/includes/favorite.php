<?php
	global $pw_woo_ad_main_class,$wpdb,$post;
	$fav_count='';
	$output='';
	//echo (isset($_COOKIE['pw_woo_ad_search_favorit_cookie']) ? $_COOKIE['pw_woo_ad_search_favorit_cookie']:"NO FAVORITS!");
	if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
	{
		$your_favorites = $_COOKIE['pw_woo_ad_search_favorit_cookie'];
		$your_favorites = explode( ',' , $your_favorites );
		$favorite_count=count($your_favorites)-1;
		$fav_count = $favorite_count;
		if(count($your_favorites)>1)
		{
			$query_by_id_in=array();
			foreach($your_favorites as $ids)
			{
				$query_by_id_in[]=$ids;
			}
			
			$ars=array(
					'post_type' =>'product',
					'post_status'=>'publish',
					'post__in'=>$query_by_id_in,
				);
			$original_query = $post;	
			$querys = new WP_Query($ars);
			$output .='<ul id="favorite_div_items" class="woo-bxslider woo-single-car  woo-carousel-layout ">';
			while ( $querys->have_posts() ) : $querys->the_post(); 
				$fetch_post_id=get_the_ID();
				require __PW_ROOT_WOO_AD_SEARCH__.'/includes/content-favorite.php';
			endwhile;
			$post = $original_query;
            wp_reset_postdata();
			
			$output.='</ul>';
			
			$output .="
				<script type='text/javascript'>
					
				</script>";
		}else
		{
			$output.=$pw_woo_ad_main_class->alert('error',__('No Favorites Has Been Added!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__));
		}
		
	}else
	{
		$output.=$pw_woo_ad_main_class->alert('error',__('No Favorites Has Been Added!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__));
	}
	
	$favorite_sticky_margin_top=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_margin')=='' ? '400':get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_margin'));
	
	$favorite_sticky_align=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_position')=='' ? 'right':get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_position'));
	
	$favorite_sticky_icon='<i class="fa fa-heart"></i>';
	if(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_icon_type')!='')
	{
		$icon_type=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_icon_type');
		
		if($icon_type=='fontawesome'){
			
		
			$favorite_sticky_icon='<i class="fa '.(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_font_icon')!='' ? get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_font_icon'):"fa-heart").'"></i>';
		}else if($icon_type=='upload'){
			$icon_value=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_upload_icon');
			
			$favorite_sticky_icon=wp_get_attachment_image( $icon_value , array(50,50),false,array("style"=>"margin:5px"));
		}
	}

	
	
	$output='<div id="favorite_div_s" class="favorite-cnt">
		<div id="fav" data-id="fav" class="wt-pw-stick  pulsegrow-eff wt-pw-stick-light pw-'.$favorite_sticky_align.'-stick ltooltip" style="top:'.$favorite_sticky_margin_top.'px" title="'.__('Favorites',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
			<span class="wt-pw-title" rel="tipsye" >'.$favorite_sticky_icon.'</span>
			<div id="favorite_div_count" class="fav-count">
			 '.$fav_count.'
			</div>  
		</div>
		
		
		<div class="wt-pw-content wt-pw-content-light pw-content-fav wt-pw-content-'.$favorite_sticky_align.'  dis-fav">
			<div class="wt-pw-content-close"></div>
			<div id="favorite_div_content">
			   '.$output.'
			</div>    
		</div>
	</div>';

	
		echo $output;
	
?>