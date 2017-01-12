jQuery(document).ready(function() {
	jQuery(".wt-pw-stick").click(function(){
	   jQuery( ".wt-pw-stick" ).removeClass( "wt-pw-active-stick" );
	   jQuery(this).addClass( "wt-pw-active-stick" );  
	  
	  var id=jQuery(this).attr('data-id');
	  var distance=window.innerHeight - jQuery(this).position().top;
	  var height=jQuery('.dis-'+id).height();
	  jQuery('.dis-'+id).css('top',jQuery(this).position().top);
	  
	  if(height>distance)
	  {
	   jQuery('.dis-'+id).css('top',(jQuery(this).position().top)-((height-distance) + 30) );
	  }
	  setTimeout(function(){
		if (jQuery(".dis-"+id).hasClass('wt-pw-active-content')){ 
			jQuery(".dis-"+id).removeClass( "wt-pw-active-content" );
			jQuery( ".wt-pw-stick" ).removeClass( "wt-pw-active-stick" );
	   }
	   else if (!jQuery(".dis-"+id).hasClass('wt-pw-active-content')){ 
			jQuery('.wt-pw-content').removeClass('wt-pw-active-content');
			jQuery(".dis-"+id).addClass( "wt-pw-active-content" ); 
	   }
	   },300); 
	});
	jQuery(".wt-pw-content-close").click(function(){ 
		jQuery('.wt-pw-content').removeClass('wt-pw-active-content');
		jQuery( ".wt-pw-stick" ).removeClass( "wt-pw-active-stick" );
	}); 
   
});