<?php
	global $pw_woo_ad_main_class;
	$show_preset = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_show_more_type'];
	$pagination='';
	if($pw_sf_pagination_type=='pagination_showmore')
	{
		$sendto_show_more_title=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_show_more_title')=='' ? __('Show More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_show_more_title'));
		$form_id='#'.$pw_sf_part."_form".$pw_sf_rand_id;
		
		$pagination.='
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#pw_sf_pagination_total_page'.$pw_sf_rand_id.'").val("'.$all_page_number.'");
						
						if(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val()<jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val() && jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val()>1)
						{
							if(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val()<jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val() && !jQuery("html").find(".pw_pl_load_more'.$pw_sf_rand_id.'").length)
							{
								jQuery("<div class=\"pagination-cnt show-'.$show_preset.' \"><div rel=\"3\" class=\"pl-loadmorecnt loadmore_id_\"><a class=\"showmore-btn pw_pl_load_more'.$pw_sf_rand_id.' load-more-link\">'.$sendto_show_more_title.'</a></div></div>").insertAfter("#'.$pw_sf_target_element_id.'");
								
								if(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val()<jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val())
								{
									jQuery( ".pw_pl_load_more'.$pw_sf_rand_id.'" ).click(function(event) {
										event.preventDefault(event);
										jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val(Number(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val())+1);
										ajax_action("'.$form_id.'","#'.$pw_sf_target_element_id.'","pw_woo_ad_search_action_build_query_sql_result","append_result");
										if(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val()==jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val())
										{
											jQuery(this).remove();
										}
									});	
								}
							}
						}else
						{
							jQuery( ".pw_pl_load_more'.$pw_sf_rand_id.'" ).remove();
						}
					});
				</script>			
		';	
	}
	else if($pw_sf_pagination_type=='pagination_pagenumber_hor')
	{
		$paginations='';
		if($all_page_number>1)
			$paginations=$pw_woo_ad_main_class->horizontal_pagination($all_page_number,4,'pl-pagination-link-',$pw_sf_rand_id);
		$pagination='
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#pagination-cnt'.$pw_sf_rand_id.'").remove();';
					if($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_hor_pagenumber_position']=='top')
					{
						$pagination.='jQuery("'.$paginations.'").insertBefore("#'.$pw_sf_target_element_id.'");';
					}else if($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_hor_pagenumber_position']=='bottom'){
						$pagination.='jQuery("'.$paginations.'").insertAfter("#'.$pw_sf_target_element_id.'");';
					}
					
					$pagination.='
					jQuery("#pw_sf_pagination_total_page'.$pw_sf_rand_id.'").val("'.$all_page_number.'");
					jQuery(".pl-pagination-link'.$pw_sf_rand_id.'").click(function(){
						jQuery(this).siblings(".active").removeClass("active");
						jQuery(this).addClass("active");
						jQuery("#pw_sf_pagination_paged'.$pw_sf_rand_id.'").val(jQuery(this).attr("id"));
						ajax_action("#'.$pw_sf_part.'_form'.$pw_sf_rand_id.'","#'.$pw_sf_target_element_id.'","pw_woo_ad_search_action_build_query_sql_result");
					});
				});
			</script>
		';
		
	}
	else if($pw_sf_pagination_type=='pagination_pagenumber_ver')
	{
		$ver_pagination_position = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_ver_pagenumber_position'];
		
		$paginations=$pw_woo_ad_main_class->vertical_pagination($all_page_number,4,'pl-pagination-link-',$pw_sf_rand_id);
		$pagination='
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#pagination-cnt'.$pw_sf_rand_id.'").remove();
					jQuery("'.$paginations.'").insertAfter("#'.$pw_sf_target_element_id.'");
					jQuery("#pw_sf_pagination_total_page'.$pw_sf_rand_id.'").val("'.$all_page_number.'");
					jQuery(".pl-pagination-link'.$pw_sf_rand_id.'").click(function(){
						jQuery("#pw_sf_pagination_paged'.$pw_sf_rand_id.'").val(jQuery(this).attr("id"));
						ajax_action("#'.$pw_sf_part.'_form'.$pw_sf_rand_id.'","#'.$pw_sf_target_element_id.'","pw_woo_ad_search_action_build_query_sql_result");
					});
					
					if(jQuery("html").find("#pagination-cnt'.$pw_sf_rand_id.'").length)
					{
						setTimeout(function(){
							
							var length = jQuery("#'.$pw_sf_target_element_id.'").height() - jQuery("#pagination-cnt'.$pw_sf_rand_id.'").height() + jQuery("#'.$pw_sf_target_element_id.'").offset().top;
							
							jQuery("#'.$pw_sf_target_element_id.'").offset().left;
							myLeft = jQuery("#'.$pw_sf_target_element_id.'").offset().left;
							myRight = myLeft + jQuery("#'.$pw_sf_target_element_id.'").outerWidth();
							myTop=jQuery("#'.$pw_sf_target_element_id.'").scrollTop();
							
							//confirm(myLeft+"---"+myRight);
		
							var s = jQuery("#pagination-cnt'.$pw_sf_rand_id.'");
							var pos = s.offset(); ';
							
							$default_navigation_position='';
							if($ver_pagination_position=='right'){
								$default_navigation_position.='
									//s.css("top",myTop);
									s.css("left",myRight-myLeft-10);
								';
							}else{
								$default_navigation_position.='
									//s.css("top",myTop);
									s.css("left",-myLeft+50);
								';
							}
							
							$pagination.=$default_navigation_position.'                   
							jQuery(window).scroll(function() {
								var windowpos = jQuery(window).scrollTop();
								
								if(windowpos>length)
								{
									//SCROLL PASSED BOTTOM ELEMENT
									s.removeClass("fixed-pagination"); 
									s.css("left","auto");
		
								}else if (windowpos >= (pos.top)) {
									//SCROLL BETWEEN ELEMTN LENGTH
									
									s.addClass("fixed-pagination");
									//s.css("left",myRight);
									
									'.($ver_pagination_position=='left' ? "s.css('left',myLeft-35)":"s.css('left',myRight)").'
									
									//s.css("left",myLeft);
								}
								else {
									//SCROLL SMALL BEFORE
									s.removeClass("fixed-pagination"); 
									//s.css("left",0);
									';
									$pagination.=$default_navigation_position.'
									
									//s.css({"left":"auto","right":myRight});
									//s.css("left",myLeft);
									
								}
					
							});
							
						},100);	
					}
				});
			</script>
		';
	}
	else if($pw_sf_pagination_type=='pagination_infinite' && $all_page_number>1)
	{
		$pagination='';
		$form_id='#'.$pw_sf_part."_form".$pw_sf_rand_id;
		
		$pagination.='
				<script type="text/javascript">
					
					jQuery(document).ready(function() {
						jQuery("#pw_sf_pagination_total_page'.$pw_sf_rand_id.'").val("'.$all_page_number.'");
						function isScrolledIntoView(elem)
						{
							var docViewTop = jQuery(window).scrollTop();
							
							var docViewBottom = docViewTop + jQuery(window).height();
						
							var elemTop = jQuery(elem).offset().top;
							var elemBottom = elemTop + jQuery(elem).height();
							//confirm(elem+"---"+docViewTop+"---"+docViewBottom+"---"+elemTop+"---"+elemBottom);
							return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
						}
						

						if(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val()<jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val())
						{
							if(!jQuery("html").find(".pw_pl_load_more'.$pw_sf_rand_id.'").length)
							{
								jQuery("<div  style=\"clear:both\" class=\"pw_pl_load_more'.$pw_sf_rand_id.'\"></div>").insertAfter("#'.$pw_sf_target_element_id.'");
							}
							
							if(isScrolledIntoView(".pw_pl_load_more'.$pw_sf_rand_id.'") && !jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").hasClass("visit"))
							{
								jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").addClass("visit");
								jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val(Number(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val())+1);
								ajax_action("'.$form_id.'","#'.$pw_sf_target_element_id.'","pw_woo_ad_search_action_build_query_sql_result","append_result");
								if(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val()==jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val())
								{
									jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").remove();
								}else
								{
									jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").removeClass("visit");
								}
							}
							
							jQuery(window).scroll(function() {
								if(jQuery("html").find(".pw_pl_load_more'.$pw_sf_rand_id.'").length)
								{
									if(isScrolledIntoView(".pw_pl_load_more'.$pw_sf_rand_id.'") && !jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").hasClass("visit"))
									{
										jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").addClass("visit");
										
										jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val(Number(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val())+1);
										
										jQuery.when( ajax_action("'.$form_id.'","#'.$pw_sf_target_element_id.'","pw_woo_ad_search_action_build_query_sql_result","append_result") ).then(function( data, textStatus, jqXHR ) {
										
											if(jQuery("'.$form_id.' :input[name=pw_sf_pagination_paged]").val()==jQuery("'.$form_id.' :input[name=pw_sf_pagination_total_page]").val())
											{
												jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").remove();
											}else
											{
												jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").remove();
												jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").removeClass("visit");
											}
										});
									}
								}
							});
						}else
						{
							jQuery(".pw_pl_load_more'.$pw_sf_rand_id.'").remove();
						}
					});
				</script>			
		';	
	}
?>