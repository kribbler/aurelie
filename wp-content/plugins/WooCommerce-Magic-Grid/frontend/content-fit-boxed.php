<?php 
	global $pw_woo_ad_main_class; 
	$custom_item_fields = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'item_fields','custom_field','');
?>


<?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_box_effect_type']=='effect1'): ?>
	<div class="<?php echo (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))?'woo-car-item':$desktop_col.' '.$tablet_col.' '.$mobile_col; ?>">
    <div class="woo-product-cnt woo-boxed-eff-one">
        <?php if ( $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type']=='second_image'): ?>
        	<div class="woo-secondimg <?php echo $image_ratio ?>" style="background:url(<?php echo $img2[0] ?>);">
                <img src="<?php echo $img2[0] ?>"  />
            </div>
        <?php endif; ?>
		<div class="thumb-divback <?php echo $image_ratio .' '.$image_eff; ?>" style="background:url(<?php echo $img1[0] ?>);">
            <img src="<?php echo $img1[0] ?>" alt="<?php echo $title; ?>" />
        </div>
        <?php if (isset($custom_item_fields['excerpt'])): ?>
            <div class="woo-product-desc"><?php echo  $pw_woo_ad_main_class->excerpt($product_excerpt,$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len','custom_field','10')); ?></div>
        <?php endif; ?>
        <div class="woo-overlay-cnt">
            <?php if (($price!='') && (isset($custom_item_fields['sale'])) ){ ?>
        	<div class="woo-banner sale-banner" ><?php echo __('sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
        <?php } ?>
        <?php if (($featured=='yes')&& (isset($custom_item_fields['featured']))){ ?>
        	<div class="woo-banner feature-banner" ><?php echo __('featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
        <?php } ?>    
            
            
		<?php if (isset($custom_item_fields['title'])): ?>
            <h3 class="woo-product-title"><a href="<?php echo $product_permalink; ?>"><?php echo $title; ?></a></h3>
        <?php endif; ?>
        <?php if (isset($custom_item_fields['category'])): ?>
            <div class="woo-product-category"><?php echo $cat; ?></div>
        <?php endif; ?>
        <?php if (isset($custom_item_fields['price'])): ?>
            <?php 
             echo '<div class="woo-product-price">'.$price.'</div>';
            ?>
        <?php endif; ?>
        <?php if (isset($custom_item_fields['star'])): ?>
            <?php echo pw_woo_ad_search_rating_grid($my_query->post->ID); ?>
        <?php endif ?>
        <div  class="woo-btns <?php echo $icon_style; ?>" >
            <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more'])): ?>
                <div class="woo-readmore" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));?>"><a href="<?php echo $product_permalink; ?>"><i class="fa fa-link"></i></a></div>
            <?php endif; ?>
			<?php 
				$favorite_status='pw-woo-ad-search-unfavorite';
				if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
				{
					$favorites=explode(',',$_COOKIE['pw_woo_ad_search_favorit_cookie']);
					if(is_array($favorites) && in_array($id,$favorites))
						$favorite_status='pw-woo-ad-search-favorite';
				}
				if (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='on' && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'])): ?>
                <div class="woo-addfav" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')=='' ? __('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')); ?>"><i data-property-id="<?php echo $id?>" class="fa fa-heart <?php echo $favorite_status;?>"></i></div>
            <?php endif; ?>
            <?php if (isset($custom_item_fields['add_cart'])): ?>
 
                        <?php echo $product_bottun_icon_link;?>    
 
            <?php endif; ?>
            <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons']) && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && is_array($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && count($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'])>0): ?>
                <div class="woo-sharebtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title')=='' ? __('Share product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title'));?>" >
                    <div class="woo-shareicon-cnt">
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('facebook' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $product_permalink; ?>"><i class="fa fa-facebook"></i></a>
                                <?php endif; ?>
                                
								<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('twitter' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://twitter.com/home?status=Currentlyreading <?php echo $product_permalink; ?>"><i class="fa fa-twitter"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('google_plus' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://plus.google.com/share?url=<?php echo $product_permalink; ?>"><i class="fa fa-google-plus"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('pinterest' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $product_permalink; ?>&description=<?php echo $title; ?>"><i class="fa fa-pinterest"></i></a>
                                <?php endif; ?>
                                
                                
                            </div>
                    <i class="fa fa-share"></i>
                </div>
            <?php endif; ?>
		    <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'quickview_style'])): ?>
                <div class="woo-quickviewbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title')=='' ? __('Quick View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title'));?>"><i class="fa fa-eye" data-property-id="<?php echo $id?>" ></i></div>
            <?php endif; ?>
            <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_send_to'])): ?>
                <div class="woo-sendbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title')=='' ? __('Send product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title'));?>"><i class="fa fa-envelope" data-property-id="<?php echo $id?>" ></i></div>
            <?php endif; ?>
            <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_zoom'])): ?>
                <div class="woo-icon" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title')=='' ? __('Big Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title'));?>" ><a class="example-image-link" data-lightbox="example-<?php echo rand(0,2000); ?>" href="<?php echo $img1[0]; ?>"><i class="fa fa-search-plus"></i></a></div>
            <?php endif; ?>
            </div> 
        </div>
    </div><!-- woo-product-cnt-->
</div>
<?php endif; ?>

<?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_box_effect_type']=='effect2'): ?>
	
    <div class="<?php echo (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))?'woo-car-item':$desktop_col.' '.$tablet_col.' '.$mobile_col; ?>">
    <div class="woo-product-cnt woo-boxed-eff-two ">
        <?php if ( $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type']=='second_image'): ?>
        	<div class="woo-secondimg <?php echo $image_ratio ?>" style="background:url(<?php echo $img2[0] ?>);">
                <img src="<?php echo $img2[0] ?>"  />
            </div>
        <?php endif; ?>
		<div class="thumb-divback <?php echo $image_ratio .' '.$image_eff; ?>" style="background:url(<?php echo $img1[0] ?>);">
            <img src="<?php echo $img1[0] ?>" alt="<?php echo $title; ?>" />
        </div>
        <div class="woo-overlay-cnt">
            <?php if (isset($custom_item_fields['title'])): ?>
                <h3 class="woo-product-title"><a href="<?php echo $product_permalink; ?>"><?php echo $title; ?></a></h3>
            <?php endif; ?>
            <?php if (isset($custom_item_fields['category'])): ?>
                <div class="woo-product-category"><?php echo $cat; ?></div>
            <?php endif; ?>
            
            <?php if (isset($custom_item_fields['excerpt'])): ?>
                <div class="woo-product-desc"><?php echo  $pw_woo_ad_main_class->excerpt($product_excerpt,$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len','custom_field','10')); ?></div>
            <?php endif; ?>
            <?php if (isset($custom_item_fields['price'])): ?>
				<?php 
                 echo '<div class="woo-product-price">'.$price.'</div>';
                ?>
            <?php endif; ?>
            
            <?php if (($price!='') && (isset($custom_item_fields['sale'])) ){ ?>
                <div class="woo-banner sale-banner" ><?php echo __('sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
            
            <?php if (($featured=='yes')&& (isset($custom_item_fields['featured']))){ ?>
                <div class="woo-banner feature-banner" ><?php echo __('featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
           
            <?php if (isset($custom_item_fields['star'])): ?>
				<?php echo '<div class="woo-starcnt">'. pw_woo_ad_search_rating_grid($my_query->post->ID) .'</div>'; ?>
            <?php endif ?>
            <div  class="woo-btns <?php echo $icon_style; ?>"  >
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more'])): ?>
                    <div class="woo-readmore" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));?>"><a href="<?php echo $product_permalink; ?>"><i class="fa fa-link"></i></a></div>
                <?php endif; ?>
				<?php 
					$favorite_status='pw-woo-ad-search-unfavorite';
					if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
					{
						$favorites=explode(',',$_COOKIE['pw_woo_ad_search_favorit_cookie']);
						if(is_array($favorites) && in_array($id,$favorites))
							$favorite_status='pw-woo-ad-search-favorite';
					}
					if (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='on' && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'])): ?>
                	<div class="woo-addfav" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')=='' ? __('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')); ?>"><i data-property-id="<?php echo $id?>" class="fa fa-heart <?php echo $favorite_status;?>"></i></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['add_cart'])): ?>
                	
						<?php echo $product_bottun_icon_link;?>    
                  
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons']) && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && is_array($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && count($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'])>0): ?>
                    <div class="woo-sharebtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title')=='' ? __('Share product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title'));?>" >
                        <div class="woo-shareicon-cnt">
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('facebook' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $product_permalink; ?>"><i class="fa fa-facebook"></i></a>
                                <?php endif; ?>
                                
								<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('twitter' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://twitter.com/home?status=Currentlyreading <?php echo $product_permalink; ?>"><i class="fa fa-twitter"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('google_plus' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://plus.google.com/share?url=<?php echo $product_permalink; ?>"><i class="fa fa-google-plus"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('pinterest' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $product_permalink; ?>&description=<?php echo $title; ?>"><i class="fa fa-pinterest"></i></a>
                                <?php endif; ?>
                                
                                
                            </div>
                        <i class="fa fa-share"></i>
                    </div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'quickview_style'])): ?>
                    <div class="woo-quickviewbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title')=='' ? __('Quick View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title'));?>"><i class="fa fa-eye" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_send_to'])): ?>
	                <div class="woo-sendbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title')=='' ? __('Send product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title'));?>"><i class="fa fa-envelope" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_zoom'])): ?>
                    <div class="woo-icon" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title')=='' ? __('Big Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title'));?>" ><a class="example-image-link" data-lightbox="example-<?php echo rand(0,2000); ?>" href="<?php echo $img1[0]; ?>"><i class="fa fa-search-plus"></i></a></div>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- woo-product-cnt-->
</div>
<?php endif; ?>

<?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_box_effect_type']=='effect3'): ?>
	<div class="<?php echo (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))?'woo-car-item':$desktop_col.' '.$tablet_col.' '.$mobile_col; ?> wg-svg-col"  data-path-hover="m 0,0 0,47.7775 c 24.580441,3.12569 55.897012,-8.199417 90,-8.199417 34.10299,0 65.41956,11.325107 90,8.199417 L 180,0 z">
        <div class="woo-product-cnt woo-boxed-eff-three">
            <?php if ( $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type']=='second_image'): ?>
                <div class="woo-secondimg <?php echo $image_ratio ?>" style="background:url(<?php echo $img2[0] ?>);">
                    <img src="<?php echo $img2[0] ?>"  />
                </div>
            <?php endif; ?>
            <div class="thumb-divback <?php echo $image_ratio .' '.$image_eff; ?>" style="background:url(<?php echo $img1[0] ?>);">
                <img src="<?php echo $img1[0] ?>" alt="<?php echo $title; ?>" />
            </div>
            <div class="svg-cnt">
           		<svg viewBox="0 0 180 320" preserveAspectRatio="none"><path d="M0,0C0,0,0,171.14385,0,171.14385C24.580441,186.61523,55.897012,195.90157,90,195.90157C124.10299,195.90157,155.41956,186.61523,180,171.14385C180,171.14385,180,0,180,0C180,0,0,0,0,0C0,0,0,0,0,0"></path><desc>Created with Snap</desc><defs></defs></svg>
            </div>
            <div class="woo-overlay-cnt">
                <?php if (isset($custom_item_fields['title'])): ?>
                    <h3 class="woo-product-title"><a href="<?php echo $product_permalink; ?>"><?php echo $title; ?></a></h3>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['category'])): ?>
                    <div class="woo-product-category"><?php echo $cat; ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['price'])): ?>
				<?php 
					 echo '<div class="woo-product-price">'.$price.'</div>';
					?>
				<?php endif; ?>
                
				<?php if (isset($custom_item_fields['excerpt'])): ?>
                    <div class="woo-product-desc"><?php echo  $pw_woo_ad_main_class->excerpt($product_excerpt,$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len','custom_field','10')); ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['star'])): ?>
					<?php echo '<div class="woo-starcnt">'. pw_woo_ad_search_rating_grid($my_query->post->ID) .'</div>'; ?>
                <?php endif ?>
                <div  class="woo-btns <?php echo $icon_style; ?>"  >
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more'])): ?>
                    <div class="woo-readmore" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));?>"><a href="<?php echo $product_permalink; ?>"><i class="fa fa-link"></i></a></div>
                <?php endif; ?>
				<?php 
					$favorite_status='pw-woo-ad-search-unfavorite';
					if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
					{
						$favorites=explode(',',$_COOKIE['pw_woo_ad_search_favorit_cookie']);
						if(is_array($favorites) && in_array($id,$favorites))
							$favorite_status='pw-woo-ad-search-favorite';
					}
					
					if (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='on' && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'])): ?>
                	<div class="woo-addfav" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')=='' ? __('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')); ?>"><i data-property-id="<?php echo $id?>" class="fa fa-heart <?php echo $favorite_status;?>"></i></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['add_cart'])): ?>

						<?php echo $product_bottun_icon_link;?>    

                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons']) && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && is_array($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && count($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'])>0): ?>
                    <div class="woo-sharebtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title')=='' ? __('Share product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title'));?>" >
                        <div class="woo-shareicon-cnt">
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('facebook' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $product_permalink; ?>"><i class="fa fa-facebook"></i></a>
                                <?php endif; ?>
                                
								<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('twitter' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://twitter.com/home?status=Currentlyreading <?php echo $product_permalink; ?>"><i class="fa fa-twitter"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('google_plus' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://plus.google.com/share?url=<?php echo $product_permalink; ?>"><i class="fa fa-google-plus"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('pinterest' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $product_permalink; ?>&description=<?php echo $title; ?>"><i class="fa fa-pinterest"></i></a>
                                <?php endif; ?>
                                
                                
                            </div>
                        <i class="fa fa-share"></i>
                    </div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'quickview_style'])): ?>
                    <div class="woo-quickviewbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title')=='' ? __('Quick View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title'));?>"><i class="fa fa-eye" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_send_to'])): ?>
	                <div class="woo-sendbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title')=='' ? __('Send product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title'));?>"><i class="fa fa-envelope" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_zoom'])): ?>
                    <div class="woo-icon" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title')=='' ? __('Big Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title'));?>" ><a class="example-image-link" data-lightbox="example-<?php echo rand(0,2000); ?>" href="<?php echo $img1[0]; ?>"><i class="fa fa-search-plus"></i></a></div>
                <?php endif; ?>
            </div>
            </div>
            <?php if (($price!='') && (isset($custom_item_fields['sale'])) ){ ?>
                <div class="woo-banner sale-banner" ><?php echo __('sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
            
            <?php if (($featured=='yes')&& (isset($custom_item_fields['featured']))){ ?>
                <div class="woo-banner feature-banner" ><?php echo __('featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
            
        </div>
    </div>
<?php endif; ?>

<?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_box_effect_type']=='effect4'): ?>
	<div class="<?php echo (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))?'woo-car-item':$desktop_col.' '.$tablet_col.' '.$mobile_col; ?> wg-svg-col"   data-path-hover="m 180,34.57627 -180,0 L 0,0 180,0 z">
        <div class="woo-product-cnt woo-boxed-eff-three">
            <?php if ( $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type']=='second_image'): ?>
                <div class="woo-secondimg <?php echo $image_ratio ?>" style="background:url(<?php echo $img2[0] ?>);">
                    <img src="<?php echo $img2[0] ?>"  />
                </div>
            <?php endif; ?>
            <div class="thumb-divback <?php echo $image_ratio .' '.$image_eff; ?>" style="background:url(<?php echo $img1[0] ?>);">
                <img src="<?php echo $img1[0] ?>" alt="<?php echo $title; ?>" />
            </div>
            <div class="svg-cnt">
            	<svg viewBox="0 0 180 320" preserveAspectRatio="none"><path d="M180,160C180,160,0,218,0,218C0,218,0,0,0,0C0,0,180,0,180,0C180,0,180,160,180,160"></path><desc>Created with Snap</desc><defs></defs></svg>
            </div>
            <div class="woo-overlay-cnt">
                <?php if (isset($custom_item_fields['title'])): ?>
                    <h3 class="woo-product-title"><a href="<?php echo $product_permalink; ?>"><?php echo $title; ?></a></h3>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['category'])): ?>
                    <div class="woo-product-category"><?php echo $cat; ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['price'])): ?>
				<?php 
					 echo '<div class="woo-product-price">'.$price.'</div>';
					?>
				<?php endif; ?>
                
				<?php if (isset($custom_item_fields['excerpt'])): ?>
                    <div class="woo-product-desc"><?php echo  $pw_woo_ad_main_class->excerpt($product_excerpt,$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len','custom_field','10')); ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['star'])): ?>
					<?php echo '<div class="woo-starcnt">'. pw_woo_ad_search_rating_grid($my_query->post->ID) .'</div>'; ?>
                <?php endif ?>
                <div  class="woo-btns <?php echo $icon_style; ?>"  >
                
				<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more'])): ?>
                    <div class="woo-readmore" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));?>"><a href="<?php echo $product_permalink; ?>"><i class="fa fa-link"></i></a></div>
                <?php endif; ?>
				<?php 
					$favorite_status='pw-woo-ad-search-unfavorite';
					if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
					{
						$favorites=explode(',',$_COOKIE['pw_woo_ad_search_favorit_cookie']);
						if(is_array($favorites) && in_array($id,$favorites))
							$favorite_status='pw-woo-ad-search-favorite';
					}
					
					if (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='on' && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'])): ?>
                	<div class="woo-addfav" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')=='' ? __('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')); ?>"><i data-property-id="<?php echo $id?>" class="fa fa-heart <?php echo $favorite_status;?>"></i></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['add_cart'])): ?>

						<?php echo $product_bottun_icon_link;?>    

                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons']) && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && is_array($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && count($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'])>0): ?>
                    <div class="woo-sharebtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title')=='' ? __('Share product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title'));?>" >
                        <div class="woo-shareicon-cnt">
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('facebook' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $product_permalink; ?>"><i class="fa fa-facebook"></i></a>
                                <?php endif; ?>
                                
								<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('twitter' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://twitter.com/home?status=Currentlyreading <?php echo $product_permalink; ?>"><i class="fa fa-twitter"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('google_plus' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://plus.google.com/share?url=<?php echo $product_permalink; ?>"><i class="fa fa-google-plus"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('pinterest' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $product_permalink; ?>&description=<?php echo $title; ?>"><i class="fa fa-pinterest"></i></a>
                                <?php endif; ?>
                                
                                
                            </div>
                        <i class="fa fa-share"></i>
                    </div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'quickview_style'])): ?>
                    <div class="woo-quickviewbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title')=='' ? __('Quick View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title'));?>"><i class="fa fa-eye" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_send_to'])): ?>
	                <div class="woo-sendbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title')=='' ? __('Send product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title'));?>"><i class="fa fa-envelope" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_zoom'])): ?>
                    <div class="woo-icon" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title')=='' ? __('Big Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title'));?>" ><a class="example-image-link" data-lightbox="example-<?php echo rand(0,2000); ?>" href="<?php echo $img1[0]; ?>"><i class="fa fa-search-plus"></i></a></div>
                <?php endif; ?>
            </div>
            </div>
            <?php if (($price!='') && (isset($custom_item_fields['sale'])) ){ ?>
                <div class="woo-banner sale-banner" ><?php echo __('sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
            
            <?php if (($featured=='yes')&& (isset($custom_item_fields['featured']))){ ?>
                <div class="woo-banner feature-banner" ><?php echo __('featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
            
        </div>
    </div>
<?php endif; ?>
<?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_box_effect_type']=='effect5'): ?>
	<div class="<?php echo (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))?'woo-car-item':$desktop_col.' '.$tablet_col.' '.$mobile_col; ?> wg-svg-col"  data-path-hover="M 0,0 0,38 90,58 180.5,38 180,0 z">
        <div class="woo-product-cnt woo-boxed-eff-three">
            <?php if ( $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type']=='second_image'): ?>
                <div class="woo-secondimg <?php echo $image_ratio ?>" style="background:url(<?php echo $img2[0] ?>);">
                    <img src="<?php echo $img2[0] ?>"  />
                </div>
            <?php endif; ?>
            <div class="thumb-divback <?php echo $image_ratio .' '.$image_eff; ?>" style="background:url(<?php echo $img1[0] ?>);">
                <img src="<?php echo $img1[0] ?>" alt="<?php echo $title; ?>" />
            </div>
            <div class="svg-cnt">
            <svg viewBox="0 0 180 320" preserveAspectRatio="none"><path d="M0,0C0,0,0,182,0,182C0,182,90,126.5,90,126.5C90,126.5,180,182,180,182C180,182,180,0,180,0C180,0,0,0,0,0C0,0,0,0,0,0"></path><desc>Created with Snap</desc><defs></defs></svg>
            </div>
            <div class="woo-overlay-cnt">
                <?php if (isset($custom_item_fields['title'])): ?>
                    <h3 class="woo-product-title"><a href="<?php echo $product_permalink; ?>"><?php echo $title; ?></a></h3>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['category'])): ?>
                    <div class="woo-product-category"><?php echo $cat; ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['price'])): ?>
				<?php 
					 echo '<div class="woo-product-price">'.$price.'</div>';
					?>
				<?php endif; ?>
                
				<?php if (isset($custom_item_fields['excerpt'])): ?>
                    <div class="woo-product-desc"><?php echo  $pw_woo_ad_main_class->excerpt($product_excerpt,$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len','custom_field','10')); ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['star'])): ?>
					<?php echo '<div class="woo-starcnt">'. pw_woo_ad_search_rating_grid($my_query->post->ID) .'</div>'; ?>
                <?php endif ?>
                <div  class="woo-btns <?php echo $icon_style; ?>"  >
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more'])): ?>
                    <div class="woo-readmore" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));?>"><a href="<?php echo $product_permalink; ?>"><i class="fa fa-link"></i></a></div>
                <?php endif; ?>
				<?php 
				
					$favorite_status='pw-woo-ad-search-unfavorite';
					if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
					{
						$favorites=explode(',',$_COOKIE['pw_woo_ad_search_favorit_cookie']);
						if(is_array($favorites) && in_array($id,$favorites))
							$favorite_status='pw-woo-ad-search-favorite';
					}
					if (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='on' && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'])): ?>
                	<div class="woo-addfav" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')=='' ? __('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')); ?>"><i data-property-id="<?php echo $id?>" class="fa fa-heart <?php echo $favorite_status;?>"></i></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['add_cart'])): ?>

						<?php echo $product_bottun_icon_link;?>    

                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons']) && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && is_array($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && count($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'])>0): ?>
                    <div class="woo-sharebtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title')=='' ? __('Share product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'share_product_title'));?>" >
                        <div class="woo-shareicon-cnt">
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('facebook' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $product_permalink; ?>"><i class="fa fa-facebook"></i></a>
                                <?php endif; ?>
                                
								<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('twitter' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://twitter.com/home?status=Currentlyreading <?php echo $product_permalink; ?>"><i class="fa fa-twitter"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('google_plus' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="https://plus.google.com/share?url=<?php echo $product_permalink; ?>"><i class="fa fa-google-plus"></i></a>
                                <?php endif; ?>
                                
                                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons']) && (in_array('pinterest' , $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons'] ))): ?>
	                                	<a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $product_permalink; ?>&description=<?php echo $title; ?>"><i class="fa fa-pinterest"></i></a>
                                <?php endif; ?>
                                
                                
                            </div>
                        <i class="fa fa-share"></i>
                    </div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'quickview_style'])): ?>
                    <div class="woo-quickviewbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title')=='' ? __('Quick View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'quick_view_title'));?>"><i class="fa fa-eye" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_send_to'])): ?>
	                <div class="woo-sendbtn" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title')=='' ? __('Send product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title'));?>"><i class="fa fa-envelope" data-property-id="<?php echo $id?>" ></i></div>
                <?php endif; ?>
                <?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_zoom'])): ?>
                    <div class="woo-icon" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title')=='' ? __('Big Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'zoom_title'));?>" ><a class="example-image-link" data-lightbox="example-<?php echo rand(0,2000); ?>" href="<?php echo $img1[0]; ?>"><i class="fa fa-search-plus"></i></a></div>
                <?php endif; ?>
            </div>
            </div>
            <?php if (($price!='') && (isset($custom_item_fields['sale'])) ){ ?>
                <div class="woo-banner sale-banner" ><?php echo __('sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
            
            <?php if (($featured=='yes')&& (isset($custom_item_fields['featured']))){ ?>
                <div class="woo-banner feature-banner" ><?php echo __('featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
            <?php } ?>
            
        </div>
    </div>
<?php endif; ?>
