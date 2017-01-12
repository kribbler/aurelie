<?php 
	global $pw_woo_ad_main_class; 
	$custom_item_fields = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'item_fields','custom_field','');
	$col_array=array(3,6,3,3,3,3,3,3,3,6,3,3,3,3,3,3,3,3,3,3,6,3,3,3,3,3,3);
	
	if(($pw_sf_pagination_type=='pagination_showmore' || $pw_sf_pagination_type=='pagination_infinite' ) && $pw_sf_pagination_paged>1)
	{
		$counter=$pw_sf_pagination_paged*$pw_sf_post_per_page;
		//$paged=1;
	}
	
	if ($counter==26) $counter=0;
	
	$box_shadow_set = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_shadow_set'];
	$btn_option = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'set_btn_option'];
?>
<?php 
if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type_outer']=='bottom'): ?>
	<div class="woo-col-md-<?php echo $col_array[$counter]; ?>" >
        <div class="woo-product-cnt woo-grid-eff <?php echo $box_shadow_set['type']; ?> wg-bottom-desc">
            <div class="woo-thumb-cnt">
                <?php if ( $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type']=='second_image'): ?>
                    <a href="<?php echo $product_permalink; ?>">
                        <div class="woo-secondimg <?php echo $image_ratio ?>" style="background:url(<?php echo $img2[0] ?>);">
                            <img src="<?php echo $img2[0] ?>"  />
                        </div>
                    </a>
                <?php endif; ?>
                <a href="<?php echo $product_permalink; ?>">
                    <div class="thumb-divback <?php echo $image_ratio .' '.$image_eff; ?>" style="background:url(<?php echo $img1[0] ?>);">
                        <img src="<?php echo $img1[0] ?>" alt="<?php echo $title; ?>" />
                    </div>
                </a>
                <?php if (($price!='') && (isset($custom_item_fields['sale'])) ){ ?>
                    <div class="woo-banner sale-banner" ><?php echo __('sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
                <?php } ?>
                
                <?php if (($featured=='yes')&& (isset($custom_item_fields['featured']))){ ?>
                    <div class="woo-banner feature-banner" ><?php echo __('featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
                <?php } ?>
                <div class="woo-overlay-cnt <?php echo $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_outer_overlay_type']; ?>">
					<div  class="woo-btns <?php echo $icon_style; ?>"  >
                    	<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more'])): ?>
                            <div class="woo-readmore" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));?>"><a href="<?php echo $product_permalink; ?>"><i class="fa fa-link"></i></a></div>
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
            </div>
            <div class="woo-desc-cnt">
                
                <?php if (isset($custom_item_fields['title'])): ?>
                    <h3 class="woo-product-title"><a href="<?php echo $product_permalink; ?>"><?php echo $title; ?></a></h3>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['category'])): ?>
                    <div class="woo-product-category"><?php echo $cat; ?></div>
                <?php endif; ?>
                
                <?php if (isset($custom_item_fields['star'])): ?>
					<?php echo '<div class="woo-starcnt">'. pw_woo_ad_search_rating_grid($my_query->post->ID) .'</div>'; ?>
                <?php endif ?>
            
                <?php if (isset($custom_item_fields['excerpt'])): ?>
                    <div class="woo-product-desc"><?php echo  $pw_woo_ad_main_class->excerpt($product_excerpt,$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len','custom_field','10')); ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['price'])): ?>
                    <?php 
                     echo '<div class="woo-product-price">'.$price.'</div>';
                    ?>
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
                    <div class="woo-addfav-btn <?php echo $btn_option['type']; ?>"><a href="#"><span><i data-property-id="<?php echo $id?>"  class="fa fa-heart <?php echo $favorite_status;?>"></i><?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')=='' ? __('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')) ?></span></a></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['add_cart'])): ?>
                    <div class="woo-addcard-btn <?php echo $btn_option['type']; ?>">
						<?php echo $product_bottun_text_link;?>    
                    </div>
                <?php endif; ?>
            </div><!--- woo-desc-cnt-->       
        </div>
    </div>
<?php endif; ?>
<?php 
if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type_outer']=='top'): ?>
	<div class="woo-col-md-<?php echo $col_array[$counter]; ?> " >
        <div class="woo-product-cnt woo-grid-eff">
            <div class="woo-desc-cnt">
                <?php if (isset($custom_item_fields['title'])): ?>
                    <h3 class="woo-product-title"><a href="<?php echo $product_permalink; ?>"><?php echo $title; ?></a></h3>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['category'])): ?>
                    <div class="woo-product-category"><?php echo $cat; ?></div>
                <?php endif; ?>
                
                <?php if (isset($custom_item_fields['star'])): ?>
					<?php echo '<div class="woo-starcnt">'. pw_woo_ad_search_rating_grid($my_query->post->ID) .'</div>'; ?>
                <?php endif ?>
            
                <?php if (isset($custom_item_fields['excerpt'])): ?>
                    <div class="woo-product-desc"><?php echo  $pw_woo_ad_main_class->excerpt($product_excerpt,$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len','custom_field','10')); ?></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['price'])): ?>
                    <?php 
                     echo '<div class="woo-product-price">'.$price.'</div>';
                    ?>
                <?php endif; ?>
            </div>  
            <div class="woo-thumb-cnt">
                <?php if ( $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type']=='second_image'): ?>
                    <a href="<?php echo $product_permalink; ?>">
                        <div class="woo-secondimg <?php echo $image_ratio ?>" style="background:url(<?php echo $img2[0] ?>);">
                            <img src="<?php echo $img2[0] ?>"  />
                        </div>
                    </a>
                <?php endif; ?>
                <a href="<?php echo $product_permalink; ?>">
                    <div class="thumb-divback <?php echo $image_ratio .' '.$image_eff; ?>" style="background:url(<?php echo $img1[0] ?>);">
                        <img src="<?php echo $img1[0] ?>" alt="<?php echo $title; ?>" />
                    </div>
                </a>
                <?php if (($price!='') && (isset($custom_item_fields['sale'])) ){ ?>
                    <div class="woo-banner sale-banner" ><?php echo __('sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
                <?php } ?>
                
                <?php if (($featured=='yes')&& (isset($custom_item_fields['featured']))){ ?>
                    <div class="woo-banner feature-banner" ><?php echo __('featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></div>
                <?php } ?>
                <div class="woo-overlay-cnt <?php echo $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_outer_overlay_type']; ?>">
					<div  class="woo-btns <?php echo $icon_style; ?>"  >
                    	<?php if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more'])): ?>
                            <div class="woo-readmore" title="<?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));?>"><a href="<?php echo $product_permalink; ?>"><i class="fa fa-link"  ></i></a></div>
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
            </div>
            <div class="woo-desc-cnt">
                <?php 
					$favorite_status='pw-woo-ad-search-unfavorite';
					if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
					{
						$favorites=explode(',',$_COOKIE['pw_woo_ad_search_favorit_cookie']);
						if(is_array($favorites) && in_array($id,$favorites))
							$favorite_status='pw-woo-ad-search-favorite';
					}
					if (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='on' && isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'])): ?>
                    <div class="woo-addfav-btn <?php echo $btn_option['type']; ?>"><a href="#"><span><i data-property-id="<?php echo $id?>" class="fa fa-heart <?php echo $favorite_status;?>"></i><?php echo (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')=='' ? __('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_favorite_title')) ?> </span></a></div>
                <?php endif; ?>
                <?php if (isset($custom_item_fields['add_cart'])): ?>
                    <div class="woo-addcard-btn <?php echo $btn_option['type']; ?>">
						<?php echo $product_bottun_text_link;?>    
                    </div>
                <?php endif; ?>
            </div><!--- woo-desc-cnt-->       
        </div>
    </div>
<?php endif; ?>