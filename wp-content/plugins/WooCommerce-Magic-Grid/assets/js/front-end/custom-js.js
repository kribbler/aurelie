	var loading='<div class="le-loading woo-loading"><img src="'+parameters.template_url+'/assets/images/loading.gif" /></div>';
	
	if (typeof  pw_woo_search_add_equalHeight != 'function') { 
		function pw_woo_search_add_equalHeight(group) {
			
			var tallest = 0;
			group.each(function() {
				var thisHeight = jQuery(this).height();
				if(thisHeight > tallest) {
					tallest = thisHeight;
				}
			});
			group.height(tallest);
		}
	}
	
	if (typeof number_format != 'function') { 
		// JavaScript Document
		function number_format ( number , decimals , dec_point , thousands_sep )  { 
			number = (number + '')
			.replace(/[^0-9+\-Ee.]/g, '');
			var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function(n, prec) {
			  var k = Math.pow(10, prec);
			  return '' + (Math.round(n * k) / k)
				.toFixed(prec);
			};
			// Fix for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			if (s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
			}
			if ((s[1] || '')
			.length < prec) {
				s[1] = s[1] || '';
				s[1] += new Array(prec - s[1].length + 1)
				  .join('0');
			}
			return s.join(dec);
		}
	}
	
	if (typeof add_remove_favorite != 'function') { 
		function add_remove_favorite(element)
		{

			var $post_id=element.attr('data-property-id');
			//confirm($post_id);
		
			var $favorite_status='pw-woo-ad-search-favorite';
			if(element.hasClass('pw-woo-ad-search-favorite'))
			{
				$favorite_status='pw-woo-ad-search-favorite';
				element.removeClass('pw-woo-ad-search-favorite').addClass('pw-woo-ad-search-unfavorite');
				
				favorite_posts=jQuery.cookie('favorite_posts');
				favorite_posts=favorite_posts.replace($post_id+",", "");
				favorite_posts=favorite_posts+"-"+$post_id+",";
				jQuery.cookie('favorite_posts',  favorite_posts);
				
				jQuery('.pw-woo-ad-search-favorite').each(function(){
					if(jQuery(this).attr('data-property-id')==element.attr('data-property-id'))
					{
						jQuery(this).removeClass('pw-woo-ad-search-favorite').addClass('pw-woo-ad-search-unfavorite');
					}
				});
				
			}else
			{
				$favorite_status='pw-woo-ad-search-unfavorite';
				element.removeClass('pw-woo-ad-search-unfavorite').addClass('pw-woo-ad-search-favorite');
				
				if(typeof jQuery.cookie('favorite_posts') !== 'undefined')
				{
					favorite_posts=jQuery.cookie('favorite_posts');
					favorite_posts=favorite_posts.replace("-"+$post_id+",", "");
					favorite_posts=favorite_posts+$post_id+",";
					jQuery.cookie('favorite_posts',  favorite_posts);
				}else
				{
					jQuery.cookie('favorite_posts',  $post_id+",");
				}
				
				jQuery('.pw-woo-ad-search-unfavorite').each(function(){
					if(jQuery(this).attr('data-property-id')==element.attr('data-property-id'))
					{
						jQuery(this).removeClass('pw-woo-ad-search-unfavorite').addClass('pw-woo-ad-search-favorite');
					}
				});
			}
			jQuery('.loadd').css('display','block');
			jQuery.ajax ({
				type: "POST",
				url: parameters.ajaxurl,
				data:  "post_id="+$post_id+"&favorite_status="+$favorite_status+"&action=pw_woo_ad_sesarch_add_to_favorit",
				success: function(data) {
					jQuery('.loadd').css('display','none');
					//confirm(data);
					var arr=Array();
					arr=data.split('@');
					
					jQuery('#favorite_div_count').html(arr[0]);
					jQuery('#favorite_div_content').html(arr[1]);
					
					var aaa=jQuery('#favorite_div_items').bxSlider({ 
						mode : 'horizontal' ,
						touchEnabled : true ,
						adaptiveHeight : true ,
						slideMargin : 10 , 
						wrapperClass : 'woo-bx-wrapper woo-agent-car ' ,
						infiniteLoop: true,
						pager: true,
						controls: false,
						slideWidth:150,
						minSlides: 1,
						maxSlides: 3,
						moveSlides: 1, 
						auto: true,
						speed :1000,
						autoHover  : true , 
						autoStart: false
					});
					
					//START AFTER CLICK NEXT & PREV BUTTONS
					jQuery('.woo-bx-wrapper .woo-bx-controls-direction a').click(function(){
						aaa.startAuto();
					});
					
					//////////////ADD PROPERTY TO FAVORITE////////////////////
					jQuery('.woo-addfav').unbind("click");
					jQuery('.woo-addfav').click(function(e){
						e.preventDefault();
						add_remove_favorite(jQuery(this).find('i'));	
					});	 
					
					jQuery('.woo-addfav-btn').find('a').unbind("click");
					jQuery('.woo-addfav-btn').find('a').click(function(e){
						e.preventDefault();
						add_remove_favorite(jQuery(this).find('i'));	
					});	 
					
					/*TOOLTIP*/
					jQuery('.favorite-icon').tipsy({gravity: 's',opacity: 1});
				}
			});
		
		}
	}

	if (typeof sendto_form != 'function') { 
		function sendto_form(element){
			jQuery('.loadd').css('display','block');
			var $post_id=element.attr("data-property-id");

			jQuery.ajax ({
				type: "POST",
				url: parameters.ajaxurl,
				data:  "post_id="+$post_id+"&action=pw_woo_ad_sesarch_sendto_form",
				success: function(data) {
					jQuery('.loadd').css('display','none');
					jQuery('#pw_woo_ad_search_popup_content').html(data);
					
					jQuery('#pw_woo_ad_search_popup_main').addClass('popup_sendto');
					jQuery('#pw_woo_ad_search_popup_main').removeClass('popup_quickview');
					
					jQuery('#pw_woo_ad_search_popup_main').bPopup({
						modalClose: true,
						fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
						followSpeed: 500, //can be a string ('slow'/'fast') or int
						modalColor: "#333",
						
						easing: 'easeOutBack', //uses jQuery easing plugin
						speed: 300,
						transition: 'slideDown',
						transitionClose: 'slideIn'
					});
					
					
					jQuery('#pw_woo_ad_search_sendto_form').submit(function(e){
						e.preventDefault();
						jQuery('#pw-ad-woo-search-sendto-result').html(loading); 
						jQuery.ajax ({
							type: "POST",
							url: parameters.ajaxurl,
							data:  jQuery('#pw_woo_ad_search_sendto_form').serialize()+"&action=pw_woo_ad_sesarch_sendto_form",
							success: function(data) {
								jQuery('#pw-ad-woo-search-sendto-result').html(data);
							}
						});
					});
				}
			});
		}
	}
	
	if (typeof quick_view != 'function') { 
		function quick_view(element){
		
			var $post_id=element.attr("data-property-id");
			jQuery('.loadd').css('display','block');
			jQuery.ajax ({
				type: "POST",
				url: parameters.ajaxurl,
				data:  "post_id="+$post_id+"&action=pw_woo_ad_sesarch_quickview",
				success: function(data) {
					jQuery('#pw_woo_ad_search_popup_content').html(data);
					jQuery('.loadd').css('display','none');
					jQuery('#pw_woo_ad_search_popup_main').addClass('popup_quickview');
					jQuery('#pw_woo_ad_search_popup_main').removeClass('popup_sendto');
					
					jQuery('#pw_woo_ad_search_popup_main').bPopup({
						modalClose: true,
						fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
						followSpeed: 500, //can be a string ('slow'/'fast') or int
						modalColor: "#333",

						easing: 'easeOutBack', //uses jQuery easing plugin
						speed: 300,
						transition: 'slideDown',
						transitionClose: 'slideIn'
					});
					
					setTimeout(function(){
					 	wooslider =
						 jQuery('.woo-quick-car').bxSlider({ 
							  mode : 'horizontal' ,
							  touchEnabled : true ,
							  adaptiveHeight : false ,
							  slideMargin : '10', 
							  wrapperClass : 'woo-bx-wrapper woo-sidebar-car ' ,
							  infiniteLoop: true,
							  pagerCustom: '#woo-pager',
							  controls: false,
							  slideWidth: 500,
							  minSlides:1,
							  maxSlides:1,
							  moveSlides: 1,
							  auto: true,
							  pause : 4000 ,
							  autoHover  : true , 
							  autoStart: true
						 });
					 
					},10);
					jQuery('.woo-pager a').click(function(){
						 var i = jQuery(this).attr('data-slide-index');
						 wooslider.goToSlide(i);
						 wooslider.stopAuto();
						 restart=setTimeout(function(){
							wooslider.startAuto();
							},1000);
						 return false;
					 });
					
				}
			});
		}
	}

	var ajaxcache={};
	var current_cache_id={};
	var masonry_isAtcive=false;
	
	function ajax_action(form_id,target_element_id,action,html_append)
	{
		//confirm("sd");
		/*var selector = ".pw-ad-codenegar-shop-loop-wrapper";
		var $wrap = jQuery(".pw-ad-codenegar-shop-loop-wrapper");
		jQuery.get("http://192.168.1.102/wordpress_search_grid/shop/?min_price=2&max_price=100&post_type=product", function(data) {
			var $data = jQuery(data);
			
			var shop_loop = $data.find(selector);
			confirm(shop_loop.html());
			
			$wrap.hide().html(shop_loop.html()).fadeIn();
		});*/
		
		html_append = typeof html_append !== 'undefined' ? html_append : 'html';

		var cache_id=form_id+"_"+jQuery(form_id).serialize();
		if (!ajaxcache[cache_id]) {
			jQuery('.loadd').css('display','block');
			ajaxcache[cache_id]=jQuery.ajax ({
				type: "POST",
				url: parameters.ajaxurl,
				data:  jQuery(form_id).serialize()+"&action="+action
			});
		}
		
		ajaxcache[cache_id].success(function(data){
			//confirm("ss");

			//jQuery('.loadd').css('display','none');
			var arr=Array();
			arr=data.split('@');
			
			jQuery(target_element_id+"_yoursearch").html(arr[1]);
			
			//FOR PAGINATION
			if(html_append=='html')
			{
				//jQuery(target_element_id).html(arr[0]);
				jQuery(target_element_id).html(arr[0]).hide().waitForImages().done(function(){
					
					jQuery(target_element_id).show();
					jQuery('.loadd').css('display','none');
					
					
					
					////////////////YOUR SAERCH////////////////////
					jQuery('.ys_items').click(function(){
						var target_element=jQuery(this).attr("data-target-element");
						var rand_id=jQuery(this).attr("data-rand-id");
		
						var element_type=jQuery('.'+target_element+rand_id).prop("tagName");
						var element_type=typeof element_type !== 'undefined' ? element_type.toLowerCase() : '';
						
						if(element_type=="input")
						{
							element_type=jQuery('.'+target_element+rand_id).attr("type");
						}
		
						switch(element_type)
						{
							case "hidden":
								if(jQuery('.'+target_element+rand_id).hasClass('pw_woo_ad_search_attr_hide'))
								{
									jQuery('.'+target_element+rand_id).val('');
								}
								
								if(jQuery("html").find("#main_price-range"+rand_id).length)
								{
									if(target_element=='from_main_price_range')
									{
										jQuery("#main_price-range"+rand_id).slider('values', [ jQuery( "#main_price-range"+rand_id).attr("data-min-num"), jQuery( "#to_main_price_range"+rand_id ).val() ]);
										jQuery( "#amount_main_price"+rand_id).html( jQuery( "#main_price-range"+rand_id).attr("data-min-num") + " - " + jQuery( "#to_main_price_range"+rand_id ).val() )	
										jQuery( "#from_main_price_range"+rand_id ).val(jQuery( "#main_price-range"+rand_id).attr("data-min-num"));
									}
									
									if(target_element=='to_main_price_range')
									{
										jQuery("#main_price-range"+rand_id).slider('values', [ jQuery( "#from_main_price_range"+rand_id ).val(), jQuery( "#main_price-range"+rand_id).attr("data-max-num") ]);
										jQuery( "#amount_main_price"+rand_id).html( jQuery( "#from_main_price_range"+rand_id ).val() + " - " + jQuery( "#main_price-range"+rand_id).attr("data-max-num") )	
			
										jQuery( "#to_main_price_range"+rand_id ).val(jQuery( "#main_price-range"+rand_id).attr("data-max-num"));  
									}
									
									
								}else{
									if(target_element=='from_main_price_range')
									{
										jQuery( "#from_main_price_range"+rand_id ).val(jQuery( "#sale_price-list"+rand_id).attr("data-min-num"));
									}
									
									
									if(target_element=='to_main_price_range')
									{
										jQuery( "#to_main_price_range"+rand_id ).val(jQuery( "#sale_price-list"+rand_id).attr("data-max-num"));
									}
									
								}
								
							break;
							
							case "text":
								jQuery('.'+target_element+rand_id).val('');
							break;
						
							case "select":
								var option_value=jQuery(this).attr("id");
								jQuery('.'+target_element+rand_id+" option[value="+option_value+"]").removeAttr('selected');
								
								//jQuery('.chosen-select').trigger('chosen:close');
								//jQuery('.chosen-select').trigger('chosen:updated');
								jQuery('.search-selectbox').multiselect('refresh');
							break;
							
							case "checkbox":
								var checked_value=jQuery(this).attr("id");
								//jQuery('.'+target_element).removeAttr('checked');
								jQuery('.'+target_element+rand_id).each(function(){
									if(jQuery(this).val()==checked_value)
									{
										jQuery(this).removeAttr('checked');
										jQuery(this).parent().removeClass('woo-active-check');
									}
								});
							break;
						}
						ajax_action(form_id,target_element_id,action);
					});
					
					/////////EQUAL HEIGHT COLOR IN COLORED STYLE/////
					if(jQuery('html').find('.woo-style-1').length)
					{
						var max_height=0;
						jQuery('.woo-style-1').find('.woo-overlay-cnt').each(function(){
							if(jQuery(this).outerHeight()>max_height)
								max_height=jQuery(this).outerHeight();	
						});
						
						jQuery('.woo-style-1').find('.woo-overlay-cnt').each(function(){
							jQuery(this).css( 'height', max_height );
						});
					}
					
					
					///////////EQUAL HEIGHT//////////////////////
					if(jQuery('html').find('.woo-grid-style-equal-height').length)
					{
						setTimeout(function(){
							jQuery('.woo-desc-cnt').responsiveEqualHeightGrid();
						},500);
					}
					
						
					/*TOOLTIP*/
					jQuery(' .search_form_popup_btn , .pw-order , .pw_view_type , .pw_map_reset , .wt-pw-content-popup-close , .btn , .title-input , .wt-pw-content-close, .woo-check-img').tipsy({gravity: 's',opacity: 1});
					jQuery('.woo-btns > div ').tipsy({gravity: 'n',opacity: 1});
					
					
					
					
					/////SVG///////
					//FOR FIT ROW BOXED EFFECT 3,4,5
					if(jQuery("html").find(".wg-svg-col").length)
					{
						svg_init();
					}
					
					//////////////ADD PROPERTY TO FAVORITE////////////////////
					jQuery('.woo-addfav').unbind("click");
					jQuery('.woo-addfav').click(function(e){
						e.preventDefault();
						add_remove_favorite(jQuery(this).find('i'));	
					});	 
					
					jQuery('.woo-addfav-btn').find('a').unbind("click");
					jQuery('.woo-addfav-btn').find('a').click(function(e){
						e.preventDefault();
						add_remove_favorite(jQuery(this).find('i'));	
					});	 
					
					////////////////SEND TO FORM/////////////////
					jQuery('.woo-sendbtn').unbind("click");
					jQuery('.woo-sendbtn').click(function(e){
						e.preventDefault();
						sendto_form(jQuery(this).find('i'));	
					});
					
					////////////////QUICK VIEW/////////////////
					jQuery('.woo-quickviewbtn').unbind("click");
					jQuery('.woo-quickviewbtn').click(function(e){
						e.preventDefault();
						quick_view(jQuery(this).find('i'));	
					});
					
					jQuery('.woo-quickviewbtn').click(function(){
						setTimeout(function(){
							var $wt_scrollbar = jQuery(".wt-scrollbarcnt");
							$wt_scrollbar.tinyscrollbar();
							var $wt_scrollbar = $wt_scrollbar.data("plugin_tinyscrollbar")
						},2000);
					});
					//////////MASONRY/////////////
					if(jQuery("html").find(".pl-masonry-grid").length)
					{
						
						if(masonry_isAtcive)
						{
							var $container = jQuery('.pl-masonry-grid');
							$container.masonry('destroy');
						}
						
						var container = jQuery('.pl-masonry-grid');
						
						setTimeout(function(){
							var container = jQuery('.pl-masonry-grid');
							jQuery('.pl-masonry-grid').masonry({});
							masonry_isAtcive=true;
							//alert('bye');
						},500);
						
						jQuery(window).resize(function () {
							container.masonry({
							  itemSelector: '.pl-col',
							  isAnimated: true
							})
						});
					}
					
					
					////////////ADD TO CART IN EQUAL HEIGHT///////////
					jQuery('.add_to_cart_button').click(function(){
						///////////EQUAL HEIGHT//////////////////////
						setTimeout(function(){
							if(jQuery('html').find('.woo-grid-style-equal-height').length)
							{
								jQuery('.woo-desc-cnt').responsiveEqualHeightGrid();
							}	
						},2000);
						
					});
					
				});
			}
			else //FOR SHOW MORE TYPE
			{
				//jQuery(arr[0]).appendTo(target_element_id);	
				jQuery(target_element_id+"_temp").html(arr[0]).hide().waitForImages().done(function(){
					
					jQuery(jQuery(target_element_id+"_temp").html()).appendTo(target_element_id);
					jQuery(target_element_id).show();
					jQuery(target_element_id+"_temp").html('');
					jQuery('.loadd').css('display','none');
					
					////////////////YOUR SAERCH////////////////////
					jQuery('.ys_items').click(function(){
						var target_element=jQuery(this).attr("data-target-element");
						var rand_id=jQuery(this).attr("data-rand-id");
		
						var element_type=jQuery('.'+target_element+rand_id).prop("tagName");
						var element_type=typeof element_type !== 'undefined' ? element_type.toLowerCase() : '';
						
						if(element_type=="input")
						{
							element_type=jQuery('.'+target_element+rand_id).attr("type");
						}
		
						switch(element_type)
						{
							case "hidden":
								if(jQuery('.'+target_element+rand_id).hasClass('pw_woo_ad_search_attr_hide'))
								{
									jQuery('.'+target_element+rand_id).val('');
								}
								
								if(jQuery("html").find("#main_price-range"+rand_id).length)
								{
									if(target_element=='from_main_price_range')
									{
										jQuery("#main_price-range"+rand_id).slider('values', [ jQuery( "#main_price-range"+rand_id).attr("data-min-num"), jQuery( "#to_main_price_range"+rand_id ).val() ]);
										jQuery( "#amount_main_price"+rand_id).html( jQuery( "#main_price-range"+rand_id).attr("data-min-num") + " - " + jQuery( "#to_main_price_range"+rand_id ).val() )	
										jQuery( "#from_main_price_range"+rand_id ).val(jQuery( "#main_price-range"+rand_id).attr("data-min-num"));
									}
									
																		
									if(target_element=='to_main_price_range')
									{
										jQuery("#main_price-range"+rand_id).slider('values', [ jQuery( "#from_main_price_range"+rand_id ).val(), jQuery( "#main_price-range"+rand_id).attr("data-max-num") ]);
										jQuery( "#amount_main_price"+rand_id).html( jQuery( "#from_main_price_range"+rand_id ).val() + " - " + jQuery( "#main_price-range"+rand_id).attr("data-max-num") )	
			
										jQuery( "#to_main_price_range"+rand_id ).val(jQuery( "#main_price-range"+rand_id).attr("data-max-num"));  
									}
									
									
								}else{
									if(target_element=='from_main_price_range')
									{
										jQuery( "#from_main_price_range"+rand_id ).val(jQuery( "#sale_price-list"+rand_id).attr("data-min-num"));
									}
									
																		
									if(target_element=='to_main_price_range')
									{
										jQuery( "#to_main_price_range"+rand_id ).val(jQuery( "#sale_price-list"+rand_id).attr("data-max-num"));
									}
									
								}
								
							break;
							
							case "text":
								jQuery('.'+target_element+rand_id).val('');
							break;
						
							case "select":
								var option_value=jQuery(this).attr("id");
								jQuery('.'+target_element+rand_id+" option[value="+option_value+"]").removeAttr('selected');
								
								//jQuery('.chosen-select').trigger('chosen:close');
								//jQuery('.chosen-select').trigger('chosen:updated');
								jQuery('.search-selectbox').multiselect('refresh');
							break;
							
							case "checkbox":
								var checked_value=jQuery(this).attr("id");
								//jQuery('.'+target_element).removeAttr('checked');
								jQuery('.'+target_element+rand_id).each(function(){
									if(jQuery(this).val()==checked_value)
									{
										jQuery(this).removeAttr('checked');
										jQuery(this).parent().removeClass('woo-active-check');
										
									}
								});
							break;
						}
						ajax_action(form_id,target_element_id,action);
					});
					
					/////////EQUAL HEIGHT COLOR IN COLORED STYLE/////
					if(jQuery('html').find('.woo-style-1').length)
					{
						var max_height=0;
						jQuery('.woo-style-1').find('.woo-overlay-cnt').each(function(){
							if(jQuery(this).outerHeight()>max_height)
								max_height=jQuery(this).outerHeight();	
						});
						
						jQuery('.woo-style-1').find('.woo-overlay-cnt').each(function(){
							jQuery(this).css( 'height', max_height );
						});
					}
					
					
					///////////EQUAL HEIGHT//////////////////////
					if(jQuery('html').find('.woo-grid-style-equal-height').length)
					{
						//pw_woo_search_add_equalHeight(jQuery(".woo-product-cnt"));
						setTimeout(function(){
							jQuery('.woo-desc-cnt').responsiveEqualHeightGrid();
						},500);
					}
					
						
					/*TOOLTIP*/
					jQuery(' .search_form_popup_btn , .pw-order , .pw_view_type , .pw_map_reset , .wt-pw-content-popup-close , .btn , .title-input , .wt-pw-content-close').tipsy({gravity: 's',opacity: 1});
					jQuery('.woo-btns > div ').tipsy({gravity: 'n',opacity: 1});
					
					
					
					
					/////SVG///////
					//FOR FIT ROW BOXED EFFECT 3,4,5
					if(jQuery("html").find(".wg-svg-col").length)
					{
						svg_init();
					}
					
					//////////////ADD PROPERTY TO FAVORITE////////////////////
					jQuery('.woo-addfav').unbind("click");
					jQuery('.woo-addfav').click(function(e){
						e.preventDefault();
						add_remove_favorite(jQuery(this).find('i'));	
					});	 
					
					jQuery('.woo-addfav-btn').find('a').unbind("click");
					jQuery('.woo-addfav-btn').find('a').click(function(e){
						e.preventDefault();
						add_remove_favorite(jQuery(this).find('i'));	
					});	 
					
					////////////////SEND TO FORM/////////////////
					jQuery('.woo-sendbtn').unbind("click");
					jQuery('.woo-sendbtn').click(function(e){
						e.preventDefault();
						sendto_form(jQuery(this).find('i'));	
					});
					
					////////////////QUICK VIEW/////////////////
					jQuery('.woo-quickviewbtn').unbind("click");
					jQuery('.woo-quickviewbtn').click(function(e){
						e.preventDefault();
						quick_view(jQuery(this).find('i'));	
					});
					jQuery('.woo-quickviewbtn').click(function(){
						setTimeout(function(){
							var $wt_scrollbar = jQuery(".wt-scrollbarcnt");
							$wt_scrollbar.tinyscrollbar();
							var $wt_scrollbar = $wt_scrollbar.data("plugin_tinyscrollbar")
						},2000);
					});
					
					//////////MASONRY/////////////
					if(jQuery("html").find(".pl-masonry-grid").length)
					{
						
						if(masonry_isAtcive)
						{
							var $container = jQuery('.pl-masonry-grid');
							$container.masonry('destroy');
						}
						
						var container = jQuery('.pl-masonry-grid');
						
						setTimeout(function(){
							var container = jQuery('.pl-masonry-grid');
							jQuery('.pl-masonry-grid').masonry({});
							masonry_isAtcive=true;
							//alert('bye');
						},500);
						
						jQuery(window).resize(function () {
							container.masonry({
							  itemSelector: '.pl-col',
							  isAnimated: true
							})
						});
					}
					
					
					////////////ADD TO CART IN EQUAL HEIGHT///////////
					jQuery('.add_to_cart_button').click(function(){
						///////////EQUAL HEIGHT//////////////////////
						setTimeout(function(){
							if(jQuery('html').find('.woo-grid-style-equal-height').length)
							{
								jQuery('.woo-desc-cnt').responsiveEqualHeightGrid();
							}	
						},2000);
					});
					
					
				});
				
				
			}
			
		});//END AJAX 
		
		
		
	
	}
		
jQuery(function(jQuery) {	

	//////////////////////SEARCH SELECTBOX////////////////////////////
	//////////////////////////////////////////////////////////////////
	//jQuery('.search-selectbox').parent().css('visibility','hidden'),
	jQuery.when( 
		jQuery('.search-selectbox').multiselect({
			buttonClass: 'btn btn-default left-btn ',
			includeSelectAllOption: true,
			enableCaseInsensitiveFiltering: true,
			enableFiltering: true,
			buttonWidth: '100%',
			buttonText: function(options , element) {
			if (options.length == 0) {
				var combo_title = jQuery(element).attr('data-combotitle');
				return combo_title+' <b class="dropdown-caret"><i class="fa fa-angle-double-down"></i></b>';
			}
			else if (options.length > 2) {
				return options.length + ' selected  <b class="dropdown-caret"><i class="fa fa-angle-double-down"></i></b>';
			}
			else {
				
				var selected = '';
				options.each(function() {
					selected += jQuery(this).text() + ', ';
				});
				
				return selected.substr(0, selected.length -2) + ' <b class="dropdown-caret"><i class="fa fa-angle-double-down"></i></b>';
			}
			},
		})
	).done(function( x ) {
		//jQuery('.search-selectbox').parent().css('visibility','visible');
		jQuery('.gt-searchform').css('visibility','visible');
	});
	
	
	
	///////////////Reset Search Form/////////////
	jQuery('.pw_map_reset').click(function()
	{	
		var form_id="#"+jQuery(this).attr('data-form-id');
		
		//jQuery(form_id+" input ").unbind('change');
		
		var rand_id=jQuery(form_id+" :input[name='pw_sf_rand_id']").val();
		//jQuery(form_id+" input,"+ form_id+" select,"+ form_id+" textarea").unbind('change');
		jQuery(form_id)[0].reset();
		jQuery(form_id +' input[type="text"]').val('');
		//
		if(jQuery('html').find('.pw_woo_ad_search_attr_hide').length)
		{
			jQuery(form_id +' .pw_woo_ad_search_attr_hide').val('');
		}
		
		if(jQuery('html').find('.pw_sf_orderby').length)
		{
			jQuery('.pw_sf_orderby').prop('selectedIndex',0);
			jQuery('.pw_sf_orderby').trigger("change");
		}
		jQuery('.search-selectbox').val('');
		jQuery('.search-selectbox').multiselect('refresh');
		//jQuery('.chosen-select').trigger('chosen:close');
		//jQuery('.chosen-select').trigger('chosen:updated');
		
		if(jQuery("html").find("#main_price-range"+rand_id).length)
		{
			jQuery("#main_price-range"+rand_id).slider('values', [ jQuery( "#main_price-range"+rand_id).attr("data-min-num"), jQuery( "#main_price-range"+rand_id).attr("data-max-num") ]);
			jQuery( "#amount_main_price"+rand_id).html( price_with_currency(number_format(jQuery( "#main_price-range"+rand_id).attr("data-min-num")))+ " - " + price_with_currency(number_format(jQuery( "#main_price-range"+rand_id).attr("data-max-num"))) )	
			jQuery( "#from_main_price_range"+rand_id ).val(jQuery( "#main_price-range"+rand_id).attr("data-min-num"));
			jQuery( "#to_main_price_range"+rand_id ).val(jQuery( "#main_price-range"+rand_id).attr("data-max-num"));  
			
			
		}else
		{
			jQuery( "#from_main_price_range"+rand_id ).val(jQuery( "#sale_price-list"+rand_id).attr("data-min-num"));
			jQuery( "#to_main_price_range"+rand_id ).val(jQuery( "#sale_price-list"+rand_id).attr("data-max-num"));
			
			
		}
		
		
		//////////FOR LIST VIEW & FLITER VIEW SEARCH FIELDS////////////
		jQuery(form_id).find('.woo-active-check').each(function(index, element) {
			jQuery(this).removeClass('woo-active-check');
			jQuery(this).find('input').prop("checked",false);
		});
		
		jQuery(form_id).find('.woo-checkbox-lbl').each(function(index, element) {
			if(jQuery(this).find("input").is(":checked")){
				jQuery(this).addClass('woo-active-check');
			}
		});
		
	
		var pw_sf_part=jQuery(form_id+" :input[name='pw_sf_part']").val();
		var pw_sf_target_element_id="#"+jQuery(form_id+" :input[name='pw_sf_target_element_id']").val();
		
		if(pw_sf_part!='pw_woo_ad_grid_widget'){			
			ajax_action(form_id,pw_sf_target_element_id,"pw_woo_ad_search_action_build_query_sql_result");
			//jQuery(form_id+" input ").unbind('change');
			jQuery(form_id+" input ").change(function(){
				ajax_action(form_id,pw_sf_target_element_id,"pw_woo_ad_search_action_build_query_sql_result");
			});
		}
		
		//map_search('googleMap');
	});
	
	//////////////input_price_range //////////////////
	
	function price_with_currency(value){
		var $woo_currency_symbol='<span>'+parameters.woo_currency_symbol+'</span>';
		if(parameters.woo_currency_pos=='left_space'){
			$woo_currency_symbol=$woo_currency_symbol+" "+value;
		}else if(parameters.woo_currency_pos=='left'){
			$woo_currency_symbol=$woo_currency_symbol+value;
		}else if(parameters.woo_currency_pos=='right_space'){
			$woo_currency_symbol=value+" "+$woo_currency_symbol;
		}else if(parameters.woo_currency_pos=='right'){
			$woo_currency_symbol=value+$woo_currency_symbol;
		}
		return $woo_currency_symbol;
	}
	
	jQuery('.input_price_range').keyup(function(){
		var form_id="#"+jQuery(this).closest('form').attr('id');
		var rand_id=jQuery(form_id+" :input[name='pw_sf_rand_id']").val();
				
		var slider_element=jQuery(this).attr('data-slider-element');
		var new_value=jQuery(this).val();
		
		jQuery("#main_price-range"+rand_id).slider('values', [ jQuery( "#from_main_price_range"+rand_id ).val(), jQuery( "#to_main_price_range"+rand_id ).val() ]);
		jQuery( "#amount_main_price"+rand_id).html( price_with_currency(number_format(jQuery( "#from_main_price_range"+rand_id ).val()))+ " - " + price_with_currency(number_format(jQuery( "#to_main_price_range"+rand_id ).val())) )	
		
		
	});
	
	//////////////CHANGE ORDER////////////
	jQuery(".pw-order").click(function(){
		var form_id =jQuery(this).attr("data-form-id");
		jQuery(this).siblings('.pw-order').removeClass('active');
		jQuery(this).addClass('active');
		var ordertype=jQuery(this).attr("data-order");
		jQuery ( form_id +" :input[name=\'pw_sf_order\']").val(ordertype);
		jQuery ( form_id +" :input[name=\'pw_sf_order\']").trigger("change");
	});
	
	
	////////////////IMAGES AND DIV FILTER ACTIONS/////////////////
	jQuery('.woo-checkbox-lbl').click(function(){

		if(jQuery(this).hasClass('none-value'))
		{
			var form_id =jQuery(this).parent().attr("data-form-id");
			var $element_name=jQuery(this).parent().find('input').attr('name');
			
			jQuery(this).parent().find('input[type=checkbox]:checked').removeAttr('checked');
			jQuery(this).parent().find('.woo-active-check').removeClass('woo-active-check');
			jQuery ( form_id +" :input[name=\'"+$element_name+"\']").trigger("change");
		}
	});
	
	
	jQuery('.pw_woo_ad_attr_checkbox , .pw_woo_ad_attr_filter').change(function(){

		if(jQuery(this).is(":checked"))
		{
			jQuery(this).parent().addClass('woo-active-check');
		}else
		{
			jQuery(this).parent().removeClass('woo-active-check');
		}
	});

	jQuery(".woo-lbl-main-price").click(function(){
		var form_id =jQuery(this).parent().parent().attr("data-form-id");
		
		jQuery(this).parent().parent().find(".woo-checkbox-lbl").removeClass("woo-active-check");
		jQuery(this).parent().addClass("woo-active-check");
		
		var $from_main_price=jQuery(this).attr("data-min-num");
		var $to_main_price=jQuery(this).attr("data-max-num");
		
		jQuery ( form_id +" :input[name=\'search_from_main_price_range\']").val($from_main_price);
		jQuery ( form_id +" :input[name=\'search_to_main_price_range\']").val($to_main_price);
		
		jQuery ( form_id +" :input[name=\'search_to_main_price_range\']").trigger("change");

	});
	
	
	
	//////////////SWITCH LIST/GRID////////////
	
	var $current_style='';
	jQuery(".pw_view_type").click(function(){
		
		var form_id =jQuery(this).attr("data-form-id");
		jQuery(this).siblings('.pw_view_type').removeClass('active');
		jQuery(this).addClass('active');
		var viewtype=jQuery(this).attr("data-viewtype");
		jQuery ( form_id +" :input[name=\'pw_sf_display_type\']").val(viewtype);
		jQuery ( form_id +" :input[name=\'pw_sf_display_type\']").trigger("change");
		
		$target_id=jQuery ( form_id +" :input[name=\'pw_sf_target_element_id\']").val();
		$rand_id=jQuery ( form_id +" :input[name=\'pw_sf_rand_id\']").val();
		
		if($current_style=='')
		{
			$current_style=jQuery('#'+$target_id).attr('class');
		}
		
		if(viewtype=='style_2')
		{
			$class='woo-row woogrid woo-list-style wg-list-'+$rand_id;
			jQuery('#'+$target_id).attr('class',$class);
		}else
		{
			jQuery('#'+$target_id).attr('class',$current_style);
		}
		
	});
	
	//////////////ATTRIBUTE IMAGE///////////////
	jQuery(".pw_woo_ad_search_attr_img").click(function(){
		var $attr_id=jQuery(this).attr("data-attr-id");
		var $element_id=jQuery(this).attr("data-element-id");
		
		jQuery($element_id).val($attr_id);
		jQuery($element_id).trigger("change");
	});
	
	jQuery('#search_sticky, .search_form_popup_btn , .woo-quickviewbtn').click(function(){
		setTimeout(function(){
			var $wt_scrollbar = jQuery(".wt-sticky-scroller-search");
			$wt_scrollbar.tinyscrollbar();
			var $wt_scrollbar = $wt_scrollbar.data("plugin_tinyscrollbar")
			$wt_scrollbar.update("relative");
		},1000);
	});
	//////////////SEARCH FOR TOGGLE////////////
	//jQuery(".search_form_toggle_cnt").hide();
	jQuery(".search_form_toggle_btn").click(function(){
		var $content_id=jQuery(this).attr("data-content-id");
		jQuery($content_id).slideToggle("2000");
	});
	
	//////////////SEARCH FOR POPUP////////////
	//jQuery(".search_form_popup_btn").hide();
	jQuery(".search_form_popup_btn").click(function(){
		
		var $content_id=jQuery(this).attr("data-content-id");
		//jQuery($content_id).show("2000");
		jQuery($content_id).addClass("displayed");
		
		/*setTimeout(function(){
			var $wt_scrollbar = jQuery(".wt-sticky-scroller-search");
			$wt_scrollbar.tinyscrollbar();
			var $wt_scrollbar = $wt_scrollbar.data("plugin_tinyscrollbar")
			$wt_scrollbar.update("relative");
		},1000);*/
		
		
	});
	jQuery(".wt-pw-content-popup-close").click(function(){
		var $content_id=jQuery(this).attr("data-content-id");
		jQuery($content_id).removeClass("displayed");
		//jQuery($content_id).hide("2000");
	});

	/////////////////FAVORITE SLIDER///////////////
	//////////////ADD PROPERTY TO FAVORITE////////////////////
	jQuery('.woo-addfav').unbind("click");
	jQuery('.woo-addfav').click(function(e){
		e.preventDefault();
		add_remove_favorite(jQuery(this).find('i'));	
	});	 
	
	jQuery('.woo-addfav-btn').find('a').unbind("click");
	jQuery('.woo-addfav-btn').find('a').click(function(e){
		e.preventDefault();
		add_remove_favorite(jQuery(this).find('i'));	
	});	 
	
	var aaa= jQuery('#favorite_div_items').bxSlider({ 
		  mode : 'horizontal' ,
		  touchEnabled : true ,
		  adaptiveHeight : true ,
		  slideMargin : 10 , 
		  wrapperClass : 'woo-bx-wrapper woo-agent-car ' ,
		  infiniteLoop: true,
		  pager: true,
		  controls: false,
		  slideWidth:150,
		  minSlides: 1,
		  maxSlides: 3,
		  moveSlides: 1, 
		  auto: true,
		  speed : 1000,
		  autoHover  : true , 
		  autoStart: false
	 });
	 jQuery('.woo-bx-wrapper .woo-bx-controls-direction a').click(function(){
		aaa.startAuto();
	});
	
	
	////////////////SEND TO FORM/////////////////
	jQuery('.woo-sendbtn').unbind("click");
	jQuery('.woo-sendbtn').click(function(e){
		e.preventDefault();
		sendto_form(jQuery(this).find('i'));	
	});
	
	////////////////QUICK VIEW/////////////////
	jQuery('.woo-quickviewbtn').unbind("click");
	jQuery('.woo-quickviewbtn').click(function(e){
		e.preventDefault();
		quick_view(jQuery(this).find('i'));	
	});

	////////////////MASONRY/////////////////
	if(jQuery("html").find(".pl-masonry-grid").length)
	{
		var container = jQuery('.pl-masonry-grid');
		setTimeout(function(){
			var container = jQuery('.pl-masonry-grid');
			//alert('hi');
			jQuery('.pl-masonry-grid').masonry({});
			//alert('bye');
			masonry_isAtcive=true;
		},1000);
		
		jQuery(window).resize(function () {
			container.masonry({
			  itemSelector: '.pl-col',
			  isAnimated: true
			})
			//alert('hi');
		});
	}

	/*TOOLTIP*/
	jQuery('.wt-pw-stick').tipsy({gravity: 'e', opacity: 1});
	
	
	
	
		
});

//SVG
function svg_init() {
	var speed = 250,
		easing = mina.easeinout;

	[].slice.call ( document.querySelectorAll( '.svg-grid > div , .svg-grid > div > div' ) ).forEach( function( el ) {
		var s = Snap( el.querySelector( 'svg' ) ), path = s.select( 'path' ),
			pathConfig = {
				from : path.attr( 'd' ),
				to : el.getAttribute( 'data-path-hover' )
			};

		el.addEventListener( 'mouseenter', function() {
			path.animate( { 'path' : pathConfig.to }, speed, easing );
		} );

		el.addEventListener( 'mouseleave', function() {
			path.animate( { 'path' : pathConfig.from }, speed, easing );
		} );
	} );
}
if(jQuery("html").find(".wg-svg-col").length)
{
	svg_init();
}