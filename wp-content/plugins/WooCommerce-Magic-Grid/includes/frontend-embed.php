<?php

	add_action( 'wp_head', 'pw_woo_ad_search_frontend_add_scripts' );	
	function pw_woo_ad_search_frontend_add_scripts(){
		
		//wp_register_style('pw-pl-custom-style', __PW_WOO_AD_SEARCH_CSS__ . '/custom.css', array() , null); 
		
		//////////MAIN CSS//////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'front-end-css', __PW_WOO_AD_SEARCH_CSS__.'front-end/frontend-style.css',true);
		//wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'front-end-css');
		
		//////////LAYOUT//////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'layout', __PW_WOO_AD_SEARCH_CSS__.'layouts/style.css',true);
		//wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'layout');
		
		//////////BOOTSTRAP//////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'framework', __PW_WOO_AD_SEARCH_CSS__.'framework/bootstrap.css',true);
		//wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'framework');
		
		//FONTAWESOME STYLE //font-awesome-css
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'font-awesome-ccc', __PW_WOO_AD_SEARCH_CSS__.'font-awesome.css',true);
		//wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'font-awesome-ccc');
		
		//////////////TOOLTIP//////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tooltip-style', __PW_WOO_AD_SEARCH_CSS__.'tooltip/tipsy.css',true);
		//wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tooltip-style');
		
		////////////////////////SEARCH FRAMEWORK///////////////////////
		wp_register_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search-framework', __PW_WOO_AD_SEARCH_CSS__.'front-end/search_framework/style.css', false, null);
		
		//////////PRETTY MULTI SELECT/////////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'multiselect',      __PW_WOO_AD_SEARCH_CSS__ . 'front-end/multiselect/bootstrap-multiselect.css', array() , null);
		//wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'multiselect-pretify',      __PW_WOO_AD_SEARCH_CSS__ . 'front-end/multiselect/prettify.css', array() , null);
		
		
		///////////////////////////////STICKY///////////////////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'extra-button-style', __PW_WOO_AD_SEARCH_CSS__.'front-end/extra-button/extra-style.css', array() , null);
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'scroller-style', __PW_WOO_AD_SEARCH_CSS__.'front-end/scroll/tinyscroller.css', array() , null);
		
		
		/////////////////////////CSS CHOSEN///////////////////////
		wp_register_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_css_1', __PW_WOO_AD_SEARCH_CSS__.'chosen/chosen.css', false, '1.0.0' );
		//wp_register_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_css_1' );
		
		////////////////////BX- SLider//////////////////////////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'bx-slider',      __PW_WOO_AD_SEARCH_CSS__ . 'front-end/bx-slider/jquery.bxslider.css', array() , null);
		
		////////////////////OWL- SLider//////////////////////////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'owl-slider',      __PW_WOO_AD_SEARCH_CSS__ . 'front-end/owl-slider/owl.carousel.css', array() , null);
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'owl-slider-theme',      __PW_WOO_AD_SEARCH_CSS__ . 'front-end/owl-slider/owl.theme.css', array() , null);
		
		/////////////////////////PRICE SLIDER///////////////////////
		wp_register_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'jquery-ui-style-slider', __PW_WOO_AD_SEARCH_CSS__.'front-end/jQueryUi/jquery-ui-slider.min.css', false, null);
		
		///////////////////POPUP STYLE//////////////////////////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup-style',      __PW_WOO_AD_SEARCH_CSS__ . 'front-end/popup/style.css', array() , null);
		
		///////////////////LIGHTBOX//////////////////////////////
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'lightbox-style',      __PW_WOO_AD_SEARCH_CSS__ . 'lightbox/lightbox.css', array() , null);
		
		///////////////////EQUAL HEIGHT//////////////////////////////
		
		
		
		/////COLOR PICKKER//////
		//wp_register_style( 'wp-color-picker' );
		
		/////JS ENQUEUE////////////
	//	wp_enqueue_script('jquery');
		
		//wp_enqueue_script('jquery-ui-core');
		//wp_enqueue_script('jquery-ui-slider');
		
		//wp_enqueue_script('wp-color-picker');
		
		//FOR UPLOAD FILE IN TAXONOMY
		//wp_enqueue_media();
		
		//////////////////CHOSEN//////////////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_js1', __PW_WOO_AD_SEARCH_JS__.'back-end/chosen/chosen.jquery.min.js' , false, '1.0.0' );
		//wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_js1' );
		
		//////////////////TOOLTIP//////////////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tooltip-jquery', __PW_WOO_AD_SEARCH_JS__.'tooltip/jquery.tipsy.js' , false, '1.0.0' );
		//wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tooltip-jquery' );
		
		//////////////////DEPENDENCY//////////////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'dependency', __PW_WOO_AD_SEARCH_JS__.'back-end/dependency/dependsOn-1.0.1.min.js' , false, '1.0.0' );
		//wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'dependency' );
		
		//////////////////////////STICKY/////////////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'extra-button-script', __PW_WOO_AD_SEARCH_JS__.'front-end/extra-button/extra-button.js', array( 'jquery' ) );
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'scroller-script', __PW_WOO_AD_SEARCH_JS__.'front-end/scroll/tinyscroller.js', array( 'jquery' ) , true );		
		
		//////////////////BOOTSTRAP - MULTI SELECT///////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'boostrap', __PW_WOO_AD_SEARCH_JS__.'framework/bootstrap.js', array( 'jquery' ),true );
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'multiselect', __PW_WOO_AD_SEARCH_JS__.'front-end/multiselect/bootstrap-multiselect.js', array( 'jquery' ),true );
		//wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'prettify', __PW_WOO_AD_SEARCH_JS__.'front-end/multiselect/prettify.js', array( 'jquery' ),true );
		
		//////////////////SVG////////////////////
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'svg', __PW_WOO_AD_SEARCH_JS__.'svg/snap.svg-min.js');
		
		
		//////////////////////BX- SLider////////////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'bx-slider', __PW_WOO_AD_SEARCH_JS__.'front-end/bx-slider/jquery.bxslider.js', array( 'jquery' ),true );
		
		//////////////////////OWL - SLider////////////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'owl-slider', __PW_WOO_AD_SEARCH_JS__.'front-end/owl-slider/owl.carousel.js', array( 'jquery' ),true );
		
		////////////////////////COOKIE//////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'jquery-cookie', __PW_WOO_AD_SEARCH_JS__.'front-end/cookie/jquery.cookie.js', array( 'jquery' ) , true );
		
		//////////////////Masonry////////////////////
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'masonry', __PW_WOO_AD_SEARCH_JS__.'masonry/masonry.js');
		
		//////////////////POPUP SCRIPT////////////////////
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup-script', __PW_WOO_AD_SEARCH_JS__.'front-end/popup/jquery.bpopup.min.js');
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'easing', __PW_WOO_AD_SEARCH_JS__.'front-end/popup/easing.js');
		
		//////////////////LIGHTBOX////////////////////
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'lightbox-script', __PW_WOO_AD_SEARCH_JS__.'lightbox/lightbox.js');

		//////////////////Masonry////////////////////
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'wait-image-load', __PW_WOO_AD_SEARCH_JS__.'front-end/imgload/jquery.waitforimages.js');
		
		//////////////////EQUAL HEIGHT////////////////////
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'js-equalheight', __PW_WOO_AD_SEARCH_JS__.'front-end/equal-height/grids.js');


		//////////////////CUSTOM JS////////////////////
		wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'front-custom-js', __PW_WOO_AD_SEARCH_JS__.'front-end/custom-js.js');
		

		//////////////////sticky-nav////////////////////
		/*wp_register_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sticky-nav', __PW_WOO_AD_SEARCH_JS__.'front-end/sticky-nav/jquery.hc-sticky.min.js');*/
		
	
	}
?>