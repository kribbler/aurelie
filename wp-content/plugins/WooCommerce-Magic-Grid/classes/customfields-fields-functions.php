<?php
	
	function pw_woo_ad_get_google_fonts($selected=''){
		require __PW_ROOT_WOO_AD_SEARCH__.'/includes/google-fonts.php';
		$font_options='';
		foreach($fonts_array as $key=>$value){
			$font_options.='<option '.selected($selected,$key,0).' value="'.$key.'">'.$value.'</option>';
		}
		return $font_options;
	}
	
	function ad_search_grid_main_page(){
		global $ad_search_grid_general_setting, $post;  
		global $ad_search_grid_build_query;
		global $ad_search_grid_advence_setting;
		global $ad_search_grid_fields_order_setting;
		global $pw_woo_ad_main_class;
		
		$html= '<div class="build_query_loading_back" style="display:block"><div id="build_query_loading" ><i class="fa fa-refresh fa-spin"></i> '.__('Please Wait to Load Data ... !',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div></div>';
		
		$html.='
		<div id="wizard">
			<h2><i class="fa fa-magic"></i> '.__('Biuld Query',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</h2>
			<section >
			   '.ad_search_grid_general_setting().'
			   '.ad_search_grid_build_query().'
			</section>

			<h2><i class="fa fa-check-square-o"></i> '.__('Custom Fields & Orders',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</h2>
			<section>
				'.ad_search_grid_fields_order_setting().'
			</section>

			<h2><i class="fa fa-cogs"></i> '.__('Advanced Setting',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</h2>
			<section>
				'.ad_search_grid_advence_setting().'
			</section>
			
			<h2><i class="fa fa-picture-o"></i> '.__('Front-End Layout',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</h2>
			<section>
				'.ad_search_grid_layout_setting().'
			</section>
		</div>
		
		<script type="text/javascript">
			jQuery(document).ready(function(jQuery){
				var fornt_end_view=false;
				jQuery.when(
					jQuery("#wizard").steps({
                        headerTag: "h2",
                        bodyTag: "section",
                        transitionEffect: "slideLeft",
						enableAllSteps :true,
						titleTemplate: "#title#",
                        //stepsOrientation: "vertical",
						
					    onInit: function (event, currentIndex) 
  					    {
							jQuery(".wp_ad_picker_color").wpColorPicker();
							
							if(currentIndex==0)
							{
								if(jQuery(".chosen-select-build").is(":visible")) {
									setTimeout(function(){
										if(jQuery(".chosen-select-build").is(":visible")) {
											jQuery(".chosen-select-build").chosen();
										}	
									},100);	
								}
								
								jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'fetch_type").change(function(){
									if(jQuery(this).val()=="build_query"){
										setTimeout(function(){
											if(jQuery(".chosen-select-build").is(":visible")) {
												jQuery(".chosen-select-build").chosen();
											}	
										},100);	
									}
								});
								
								if(jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type").val()=="search_grid_widget"){
									jQuery(".pw_woo_ad_err").remove();
									jQuery("#pw_woo_ad_search_frontend_setting").hide();
									jQuery(\'<div class="pw_woo_ad_err">'.$pw_woo_ad_main_class->alert('error',__('This Section is Disable for Widget Type!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)).'</div>\').insertBefore("#pw_woo_ad_search_frontend_setting");
									
								}else{
									
									jQuery("#pw_woo_ad_search_frontend_setting").show();
									jQuery(".pw_woo_ad_err").remove();
								}
								
								jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type").change(function(){
									if(jQuery(this).val()=="search_grid_widget"){
										jQuery(".pw_woo_ad_err").remove();
										jQuery(\'<div class="pw_woo_ad_err">'.$pw_woo_ad_main_class->alert('error',__('This Section is Disable for Widget Type!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)).'</div>\').insertBefore("#pw_woo_ad_search_frontend_setting");
										jQuery("#pw_woo_ad_search_frontend_setting").hide();
										
									}else{
										
										jQuery("#pw_woo_ad_search_frontend_setting").show();
										jQuery(".pw_woo_ad_err").remove();
										
									}
								});
								
							}
							';
							if(isset($_GET['action']) && $_GET['action']=='edit')
							{
								$html.='
							jQuery(".actions").find("ul").append("<li aria-hidden=\"false\" aria-disabled=\"false\"><input name=\"save\" type=\"submit\" class=\"button button-primary button-large\" id=\"publish\" accesskey=\"p\" value=\"Update\"></li>");';
							}else{
								$html.='
							jQuery(".actions").find("ul").append("<li aria-hidden=\"false\" aria-disabled=\"false\"><input name=\"original_publish\" type=\"hidden\" id=\"original_publish\" value=\"Publish\"><input type=\"submit\" name=\"publish\" id=\"publish\" class=\"button button-primary button-large\" value=\"Publish\" accesskey=\"p\"></li>");';
							}
						$html.='
					 	},
						onStepChanged :function (event, currentIndex, priorIndex) { 
							
							//FOR CHOSEN TYPE
							if(currentIndex==1)
							{
								if(jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_show_filter").is(":checked"))
								{
									jQuery(".chosen-select").chosen();
								}
								
								jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_show_filter").click(function(){
									if(jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_show_filter").is(":checked"))
									{
										jQuery(".chosen-select").chosen();
									}
								});
								
								////////////SHOW TAX & CAT WITH IMAGE _ LABEL ///////////
								var $taxonomy_display_val=jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_fields_tax_style").val();
								if($taxonomy_display_val=="dropdown_style"){
									jQuery(".pw_woo_search_taxonomy_display_type").show();
									jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'List Types\']").children().prop("disabled", true);
									jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'Dropdown Types\']").children().prop("disabled", false);
									
								}else if($taxonomy_display_val=="list_style"){
									jQuery(".pw_woo_search_taxonomy_display_type").show();
									jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'Dropdown Types\']").children().prop("disabled", true);
									jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'List Types\']").children().prop("disabled", false);
									
								}else{
									jQuery(".pw_woo_search_taxonomy_display_type").hide();
								}
								
								jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_fields_tax_style").change(function(){
									var $taxonomy_display_val=jQuery(this).val();
									if($taxonomy_display_val=="dropdown_style"){
										jQuery(".pw_woo_search_taxonomy_display_type").show();
										jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'List Types\']").children().prop("disabled", true);
										jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'Dropdown Types\']").children().prop("disabled", false);
										
									}else if($taxonomy_display_val=="list_style"){
										jQuery(".pw_woo_search_taxonomy_display_type").show();
										jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'Dropdown Types\']").children().prop("disabled", true);
										jQuery(".pw_woo_search_taxonomy_display_type").children("optgroup[label=\'List Types\']").children().prop("disabled", false);
										
									}else{
										jQuery(".pw_woo_search_taxonomy_display_type").hide();
									}
									
								});
								/////////////////END SHOW TAX & CAT WITH IMAGE _ LABEL ////////////////
								
							}
							
							//PRESET STYLE
							if(currentIndex==3)
							{
								if(!fornt_end_view)
								{
									fornt_end_view=true;
									jQuery("#wizards").steps({
										headerTag: "h2",
										bodyTag: "section",
										transitionEffect: "slideLeft",
										enableFinishButton: false,
										enablePagination: false,
										enableAllSteps: true,
										titleTemplate: "#title#",
										cssClass: "tabcontrol"
									});
								}
								
								
								jQuery(".delete-icon").click(function(e){
									e.preventDefault();
									var $this=jQuery(this);
									var $post_id=jQuery(this).attr("data-id");
									jQuery(".build_query_loading_back").show();
									jQuery.post(
										ajaxurl,
										{
											action       : "pw_woo_ad_search_preset_frontend_delete",
											post_id		 : $post_id,
											current_id   : '.$post->ID.',
										},
										function(response){
											jQuery(".build_query_loading_back").slideUp();
											$this.parent().hide(1000);
											if(response=="UNCHECK")
											{
												jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset'.'").prop("checked",false);
												jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset'.'").trigger("change");
												jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_prest_image'.'").val("");
												jQuery(".custom_preview_image").attr("src","");
												jQuery(".pw_woo_ad_search_remove_image_button").hide();
											}
										}
									);	
								});
								
								function hexc(colorval) {
									var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
									delete(parts[0]);
									for (var i = 1; i <= 3; ++i) {
										parts[i] = parseInt(parts[i]).toString(16);
										if (parts[i].length == 1) parts[i] = "0" + parts[i];
									}
									color = "#" + parts.join("");
									return color;
								}
								jQuery(document).ready(function(jQuery){
									jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'preset_frontend").find(".link-icon").click(function(e){
										e.preventDefault();
										var $filename=jQuery(this).attr("data-name")+".xml";
										var $source_type="from_xml";
										if(jQuery(this).attr("data-name")=="")
										{
											var $filename=jQuery(this).attr("data-id");
											$source_type="from_database";
										}
										
										jQuery(".build_query_loading_back").show();
										jQuery.post(
											ajaxurl,
											{
												action       : "pw_woo_ad_search_preset_frontend",
												xml_filename : $filename,
												source_type	 : $source_type	
											},
											function(response){
												
												jQuery("input:checkbox[name*=\"item_fields\"]").each(function(i){
													jQuery(this).prop("checked", false);
												});
												
												jQuery.each(response, function (key, data) {
													if(jQuery.isPlainObject(data))
													{
														//confirm("array - "+key);
														jQuery.each(data, function (keys, data) {
															var element_type=jQuery("[name=\""+key+"["+keys+"]\"]").prop("tagName");
															var element_type=typeof element_type !== "undefined" ? element_type.toLowerCase() : "";
															if(element_type=="input")
															{
																element_type=jQuery("input[name=\""+key+"["+keys+"]\"]").attr("type");
															}
															//confirm(key+"---"+element_type);

															switch(element_type)
															{
																case "text":
																	jQuery("input[name=\""+key+"["+keys+"]\"]").val(data);
																	if(jQuery("input[name=\""+key+"["+keys+"]\"]").hasClass("wp_ad_picker_color")){
																		jQuery("input[name=\""+key+"["+keys+"]\"]").wpColorPicker("color",data);
																		
																	}
																break;
																
																case "number":
																	jQuery("input[name=\""+key+"["+keys+"]\"]").val(data);
																break;
																
																case "select":
																	jQuery("select[name=\""+key+"["+keys+"]\"]").val(data);
																	jQuery("select[name=\""+key+"["+keys+"]\"]").trigger("change");
																break;
																
																case "checkbox":
																	//confirm(keys);
																	
																	jQuery("input[name=\""+key+"["+keys+"]\"]").prop("checked", true);
																	jQuery("input[name=\""+key+"["+keys+"]\"]").trigger("change");
																break;
															}
															
														});
													}else
													{
														
														var element_type=jQuery("[name=\""+key+"\"]").prop("tagName");
														var element_type=typeof element_type !== "undefined" ? element_type.toLowerCase() : "";
														if(element_type=="input")
														{
															element_type=jQuery("input[name=\""+key+"\"]").attr("type");
														}
														
														//confirm(key+"---"+element_type);

														switch(element_type)
														{
															case "text":
																jQuery("input[name=\""+key+"\"]").val(data);
																	if(jQuery("input[name=\""+key+"\"]").hasClass("wp_ad_picker_color")){
																		jQuery("input[name=\""+key+"\"]").wpColorPicker("color",data);
																	}
															break;
															
															case "number":
																jQuery("input[name=\""+key+"\"]").val(data);
															break;
															
															case "select":
																jQuery("select[name=\""+key+"\"]").val(data);
																jQuery("select[name=\""+key+"\"]").trigger("change");
															break;
															
															case "checkbox":
																if(data=="on")
																	jQuery("input[name=\""+key+"\"]").prop("checked", true);
																else
																	jQuery("input[name=\""+key+"\"]").prop("checked", false);											
																jQuery("input[name=\""+key+"\"]").trigger("change");	
															break;
														}
													}
												});
												
												jQuery(".build_query_loading_back").slideUp();
											}
										);	
										jQuery(this).parent().siblings( ".active" ).removeClass( "active" );
										jQuery(this).parent().addClass("active");
									});
								});
							}
							
							if(currentIndex==0)
							{
								if(jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type").val()=="search_grid_widget"){
									jQuery(".pw_woo_ad_err").remove();
									jQuery("#pw_woo_ad_search_frontend_setting").hide();
									jQuery(\'<div class="pw_woo_ad_err">'.$pw_woo_ad_main_class->alert('error',__('This Section is Disable for Widget Type!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)).'</div>\').insertBefore("#pw_woo_ad_search_frontend_setting");
									
								}else{
									
									jQuery("#pw_woo_ad_search_frontend_setting").show();
									jQuery(".pw_woo_ad_err").remove();
								}
								
								jQuery("#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type").change(function(){
									if(jQuery(this).val()=="search_grid_widget"){
										jQuery(".pw_woo_ad_err").remove();
										jQuery(\'<div class="pw_woo_ad_err">'.$pw_woo_ad_main_class->alert('error',__('This Section is Disable for Widget Type!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)).'</div>\').insertBefore("#pw_woo_ad_search_frontend_setting");
										jQuery("#pw_woo_ad_search_frontend_setting").hide();
										
									}else{
										
										jQuery("#pw_woo_ad_search_frontend_setting").show();
										jQuery(".pw_woo_ad_err").remove();
										
									}
								});
								
							}
						}
                    })
				).done(function( x ) {
					jQuery(".build_query_loading_back").slideUp();
				});
				
				
			});
		</script>';
		
		echo $html;
	}
	
	function ad_search_grid_general_setting() {  
		global $ad_search_grid_general_setting, $post;  
		// Use nonce for verification  
		$html= '<input type="hidden" name="show_custom_meta_box_woo_ad_search_grid_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
			  
			// Begin the field table and loop  
			$html.= '<table class="form-table">';  
			foreach ($ad_search_grid_general_setting as $field) {  
				// get value of this field if it exists for this post  
				if(isset($field['dependency']))  
				{
					$html.=pw_woo_ad_search_dependency($field['id'],$field['dependency']);	
				}
				
				// get value of this field if it exists for this post  
				$meta = get_post_meta($post->ID, $field['id'], true);  
				// begin a table row with 
				$html.= '<tr class="'.$field['id'].'_field">

						<th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
						<td>';  
						switch($field['type']) {  
							
							case 'text':  
	
								$html.= '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" />
								<br /><span class="description">'.$field['desc'].'</span>	';  
							break; 
							
							case 'radio':  
								foreach ( $field['options'] as $option ) {
									$html.= '<input type="radio" name="'.$field['id'].'" value="'.$option['value'].'" '.checked( $meta, $option['value'] ,0).' '.$option['checked'].' /> 
											<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
								}  
							break;
							
							case 'select':  
								$html.= '<select name="'.$field['id'].'" id="'.$field['id'].'" style="width: 170px;">';  
								foreach ($field['options'] as $option) {  
									$html.= '<option '. selected( $meta , $option['value'],0 ).' value="'.$option['value'].'">'.$option['label'].'</option>';  
								}  
								$html.= '</select><br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'numeric':  
								$default_value=(isset($field['value'])? $field['value']:"");
								$html.= '
								<input type="number" name="'.$field['id'].'" id="'.$field['id'].'" value="'.($meta=='' ? $default_value:$meta).'" size="30" class="width_170" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />
	';
								$html.= '
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'checkbox':  
								$html.= '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" '.checked( $meta, "on" ,0).'"/>
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;  
							
							case 'icon_type':  
								$html.= '<input type="hidden" id="'.$field['id'].'_font_icon" name="'.$field['id'].'" value="'.$meta.'"/>';
								$html.= '<div class="'.$field['id'].' pw_iconpicker_grid" id="benefit_image_icon">';
								$html.=include(__PW_ROOT_WOO_AD_SEARCH__ .'/includes/font-awesome.php');
								$html.= '</div>';
								$output = '
								<script type="text/javascript"> 
									jQuery(document).ready(function(jQuery){';
										if ($meta == '') $meta ="fa-none";
										$output .= 'jQuery( ".'.$field['id'].' .'.$meta.'" ).siblings( ".active" ).removeClass( "active" );
										jQuery( ".'.$field['id'].' .'.$meta.'" ).addClass("active");';
								$output.='
										jQuery(".'.$field['id'].' i").click(function(){
											var val=(jQuery(this).attr("class").split(" ")[0]!="fa-none" ? jQuery(this).attr("class").split(" ")[0]:"");
											jQuery("#'.$field['id'].'_font_icon").val(val);
											jQuery(this).siblings( ".active" ).removeClass( "active" );
											jQuery(this).addClass("active");
										});
									});
								</script>';
								$html.= $output;
							break; 
							
						} //end switch  
				$html.= '</td></tr>';  
			} // end foreach  
			$html.= '</table>'; // end table  
			return $html;
	}
	
	function ad_search_grid_build_query() {  
		global $ad_search_grid_build_query, $post;
		// Use nonce for verification  
		$html= '<input type="hidden" name="show_custom_meta_box_woo_ad_search_grid_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
			  
			// Begin the field table and loop  
			$html.= '<table class="form-table">';  
			foreach ($ad_search_grid_build_query as $field) {  
			
				if(isset($field['dependency']))  
				{
					$html.=pw_woo_ad_search_dependency($field['id'],$field['dependency']);	
				}
				
				// get value of this field if it exists for this post  
				$meta = get_post_meta($post->ID, $field['id'], true);  
				// begin a table row with 
				if($field['type']=='hidden')
				{
					$html.= '<input type="hidden" name="'.$field['id'].'" id="'.$field['id'].'" value="product" />';
					continue;
				}
				 
				$html.= '<tr class="'.$field['id'].'_field"> 

						<th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
						<td>';  
						switch($field['type']) {  

							case 'text':  
	
								$html.= '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" />
								<br /><span class="description">'.$field['desc'].'</span>	';  
							break; 
							
							case 'hidden':  
	
								$html.= '<input type="hidden" name="'.$field['id'].'" id="'.$field['id'].'" value="product" />';  
							break; 
							
							case 'radio':  
								foreach ( $field['options'] as $option ) {
									$html.= '<input type="radio" name="'.$field['id'].'" value="'.$option['value'].'" '.checked( $meta, $option['value'] ,0).' '.$option['checked'].' /> 
											<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
								}  
							break;
							
							case 'select':  
								$html.= '<select name="'.$field['id'].'" id="'.$field['id'].'" style="width: 170px;">';  
								foreach ($field['options'] as $option) {  
									$html.= '<option '. selected( $meta , $option['value'],0 ).' value="'.$option['value'].'">'.$option['label'].'</option>';  
								}  
								$html.= '</select><br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'chosen_select':  
								$html.= '<select name="'.$field['id'].'" id="'.$field['id'].'" style="width: 170px;">';  
								foreach ($field['options'] as $option) {  
									$html.= '<option '. selected( $meta , $option['value'],0 ).' value="'.$option['value'].'">'.$option['label'].'</option>';  
								}  
								$html.= '</select><br /><span class="description">'.$field['desc'].'</span>';  
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function(jQuery){
										
										jQuery("#'.$field['id'].'").change(function(){
											setTimeout(function(){
												if(jQuery(".chosen-select-build").is(":visible")) {
													//jQuery(".chosen-select-build").chosen();
												}	
											},500);	
										});
										
									});
								</script>';
							break;
							
							
							case 'numeric':  
								$default_value=(isset($field['value'])? $field['value']:"");
								$html.= '
								<input type="number" name="'.$field['id'].'" id="'.$field['id'].'" value="'.($meta=='' ? $default_value:$meta).'" size="30" class="width_170" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />
	';
								$html.= '
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'checkbox':  
								$html.= '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" '.checked( $meta, "on" ,0).'"/> 
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'order_by_multiselect':  
								$html.= '
								<select name="'.$field['id'].'" id="'.$field['id'].'">
									<optgroup label="'.__('Woocommerce Order',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
									<option value="_price" '.selected($meta,"_price",0).'>'.__('Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="_regular_price" '.selected($meta,"_regular_price",0).'>'.__('Regular Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="_sale_price" '.selected($meta,"_sale_price",0).'>'.__('Sale Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="total_sales" '.selected($meta,"total_sales",0).'>'.__('Number Of Sales',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="_featured" '.selected($meta,"_featured",0).'>'.__('Featured Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="num_stock" '.selected($meta,"num_stock",0).'>'.__('Stock Quantity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="_sku" '.selected($meta,"_sku",0).'>'.__('SKU',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									</optgroup>
									
									<optgroup label="'.__('Popular Order',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">	
									<option value="date" '.selected($meta,"date",0).'>'.__('Date',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="title" '.selected($meta,"title",0).'>'.__('Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="ID" '.selected($meta,"ID",0).'>'.__('ID',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="author" '.selected($meta,"author",0).'>'.__('Author',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="modified" '.selected($meta,"modified",0).'>'.__('Modified',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="rand" '.selected($meta,"rand",0).'>'.__('Random',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="comment_count" '.selected($meta,"comment_count",0).'>'.__('Comment Count',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									<option value="menu_order" '.selected($meta,"menu_order",0).'>'.__('Menu Order',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
									</optgroup>								
								</select>
								';  
							break;
							
							case 'pw_custom_taxonomy':
							
								$original_query = $post;
							
								$post_name='product';
								$option_data='';
								$param_line='';
								
								$all_tax=get_object_taxonomies( $post_name );
								//$all_tax = array_diff($all_tax,array('post_tag'));
								
								$current_value=array();
								if(is_array($all_tax) && count($all_tax)>0){
									$post_type_label=get_post_type_object( $post_name );
									$label=$post_type_label->label ; 
									$param_line .='<div class="header-lbl" style="display: block !important">'.$label.' '.__('Taxonomies ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>';
									
									//FETCH TAXONOMY
									foreach ( $all_tax as $tax ) {
										
										//if ('post_tag' === $taxonomy) continue;
										
										$taxonomy=get_taxonomy($tax);	
										$values=$tax;
										$label=$taxonomy->label;
							
										$checked='';
										if (isset($meta['taxonomy_checkbox']) &&  in_array($tax, $meta['taxonomy_checkbox']) ) $checked = ' checked="checked"';
										
										$param_line .=' 
										<div class="full-lbl-cnt more-padding" style="display: block;">
											<label class="full-label" >
												<input type="checkbox" data-input="post_type" value="'.$tax.'" id="pw_checkbox_'.$tax.'" name="'.$field['id'].'[taxonomy_checkbox][]" class="pw_taxomomy_checkbox" '.$checked.'> 
												'.$label.'
											</label>';
											
							
											$param_line_exclude =$param_line_include = '<select name="'.$field['id'].'[in_'.$tax.'][]" class="chosen-select-build" multiple="multiple" style="width: 531px;" data-placeholder="'.__('Choose Inclulde ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' '.$label.' ..." id="pw_'.$tax.'">';
											$param_line_exclude = '<select name="'.$field['id'].'[ex_'.$tax.'][]" class="chosen-select-build" multiple="multiple" style="width: 531px;" data-placeholder="'.__('Choose Exclude',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' '.$label.' ..." id="pw_'.$tax.'">';
											$args = array(
												'taxonomy'       			 =>  $tax,
												'name'          		     =>  'pw_'.$tax.'[]',
												'id'                       =>  'pw_'.$tax,
												'orderby'                  => 'name',
												'order'                    => 'ASC',
												'hide_empty'               => 1,
												'hierarchical'             => 1,
												'exclude'                  => '',
												'include'                  => '',
												'child_of'          		 => 0,
												'number'                   => '',
												'pad_counts'               => false 
											
											); 
							
											$categories = get_categories($args); 
											foreach ($categories as $category) {
												$selected='';
												if(isset($meta['in_'.$tax]) && is_array($meta['in_'.$tax]))
												{
													$selected=(in_array($category->cat_ID,$meta['in_'.$tax]) ? "SELECTED":"");
												}
												
												$option = '<option value="'.$category->cat_ID.'" '.$selected.'>';
												$option .= $category->cat_name;
												$option .= ' ('.$category->category_count.')';
												$option .= '</option>';
												$param_line_include .= $option;
	
											}
											$param_line_include .='</select>';
											
											$categories = get_categories($args); 
											foreach ($categories as $category) {
												$selected='';
												if(isset($meta['ex_'.$tax]) && is_array($meta['ex_'.$tax]))
												{
													$selected=(in_array($category->cat_ID,$meta['ex_'.$tax]) ? "SELECTED":"");
												}
												
												$option = '<option value="'.$category->cat_ID.'" '.$selected.'>';
												$option .= $category->cat_name;
												$option .= ' ('.$category->category_count.')';
												$option .= '</option>';
												$param_line_exclude .= $option;
											}
											$param_line_exclude .='</select>';
											$param_line .= $param_line_include.$param_line_exclude.'
										</div>';	
									}
								
								
									//CREATE INDIVIDUAL SELECT BOX
									$pw_post_id='';
									$args_post = array('post_type' => $post_name);
									$loop_post = new WP_Query( $args_post );
									$in_option_data ='<optgroup label="'.$post_name.'">';
									$ex_option_data ='<optgroup label="'.$post_name.'">';
									while ( $loop_post->have_posts() ) : $loop_post->the_post();
										$selected='';
										if(isset($meta['in_ids']))
										{
											$selected=(in_array(get_the_ID(),$meta['in_ids']) ? "SELECTED":"");
										}
										$in_option_data.='<option '.$selected.' value="'.get_the_ID().'">'.get_the_title().'</option>';
										
										$selected='';
										if(isset($meta['ex_ids']))
										{
											$selected=(in_array(get_the_ID(),$meta['ex_ids']) ? "SELECTED":"");
										}
										$ex_option_data.='<option '.$selected.' value="'.get_the_ID().'">'.get_the_title().'</option>';
									endwhile;
									
									$post = $original_query;
            						wp_reset_postdata();
									
									$in_option_data.='</optgroup>';
									$ex_option_data.='</optgroup>';
								}else{
									$param_line=__('Please Install Woocommecer Plugin!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__);
								}
								
								if($ex_option_data!='' || $in_option_data!=''){
									$param_line .='<div class="header-lbl" style="display: block !important;">'.__('Individual Product(s)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>';
									$param_line .='<div class="full-lbl-cnt more-padding" style="display: block;">
										<select name="'.$field['id'].'[in_ids][]" style="width: 531px;" class="chosen-select-build" multiple="multiple" data-placeholder="'.__('Choose Include Product(s) ...',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' ..." id="pw_post_id">';
											$param_line.= $in_option_data.'
										</select>
												  ';	
									
									$param_line .='
										<select name="'.$field['id'].'[ex_ids][]" style="width: 531px;" class="chosen-select-build" multiple="multiple" data-placeholder="'.__('Choose Exclude Product(s) ...',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' ..." id="pw_post_id">';
											$param_line.= $ex_option_data.'
										</select>
									</div>';	
								}
								$param_line.='
									<script type="text/javascript"> 
										jQuery(document).ready(function(){
											
											/*jQuery.when( jQuery(".chosen-select").chosen() ).done(function( x ) {
												jQuery(".chosen-container").each(function(){
													//jQuery(this).css({"width": "500px"});
												});
											});*/
											
										});
									</script>
								';
								$html.= $param_line;
							break;
							
							case 'individual_multiselects':
								$original_query = $post;
								
								$pw_post_id=$meta;
								$post_types = get_post_types( '', 'names' ); 
								$param_line ='
									<select name="pw_post_id[]" style="width: 531px;" class="chosen-select" multiple="multiple" data-placeholder="'.__('Choose Product(s) ...',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' ..." id="pw_post_id">';
										$option_data='';
										foreach ( $post_types as $post_type ) {
											$args_post = array('post_type' => $post_type,'posts_per_page'=>-1);
											$loop_post = new WP_Query( $args_post );
											$option_data.='<optgroup label="'.$post_type.'">';
											while ( $loop_post->have_posts() ) : $loop_post->the_post();
												$selected='';
												if(is_array($pw_post_id))
												{
													$selected=(in_array(get_the_ID(),$pw_post_id) ? "SELECTED":"");
												}
												$option_data.='<option '.$selected.' value="'.get_the_ID().'">'.get_the_title().'</option>';
											endwhile;
											
											$post = $original_query;
            								wp_reset_postdata();
											
											$option_data.='</optgroup>';
										}
										$param_line.= $option_data.'
									</select>
								';
								$param_line.='
									<script type="text/javascript"> 
										jQuery(document).ready(function(){
											
											/*jQuery.when( jQuery(".chosen-select").chosen() ).done(function( x ) {
												jQuery(".chosen-container").each(function(){
													//jQuery(this).css({"width": "500px"});
												});
											});*/
											
										});
									</script>
								';
								$html.= $param_line;
							break;
							
	
						} //end switch  
				$html.= '</td></tr>';  
			} // end foreach  
			$html.= '</table>'; // end table  
			return $html;
	}
	
	function ad_search_grid_advence_setting() {  
		global $ad_search_grid_advence_setting, $post;
		// Use nonce for verification  
		$html= '<input type="hidden" name="show_custom_meta_box_woo_ad_search_grid_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
			  
			// Begin the field table and loop  
			$html.= '<table class="form-table">';  
			foreach ($ad_search_grid_advence_setting as $field) {  
			
				if(isset($field['dependency']))  
				{
					$html.=pw_woo_ad_search_dependency($field['id'],$field['dependency']);	
				}
				
				// get value of this field if it exists for this post  
				$meta = get_post_meta($post->ID, $field['id'], true);  
				// begin a table row with  
				$html.= '<tr class="'.$field['id'].'_field"> 

						<th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
						<td>';  
						switch($field['type']) {  

							case 'text':  
	
								$html.= '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" />
								<br /><span class="description">'.$field['desc'].'</span>	';  
							break; 
							
							case 'radio':  
								foreach ( $field['options'] as $option ) {
									$html.= '<input type="radio" name="'.$field['id'].'" value="'.$option['value'].'" '.checked( $meta, $option['value'] ,0).' '.$option['checked'].' /> 
											<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
								}  
							break;
							
							case 'select':  
								$html.= '<select name="'.$field['id'].'" id="'.$field['id'].'" style="width: 170px;">';  
								foreach ($field['options'] as $option) {  
									$html.= '<option '. selected( $meta , $option['value'],0 ).' value="'.$option['value'].'">'.$option['label'].'</option>';  
								}  
								$html.= '</select><br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'numeric':  
								$default_value=(isset($field['value'])? $field['value']:"");
								$html.= '
								<input type="number" name="'.$field['id'].'" id="'.$field['id'].'" value="'.($meta=='' ? $default_value:$meta).'" size="30" class="width_170" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />
	';
								$html.= '
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'checkbox':  
								$html.= '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" '.checked( $meta, "on" ,0).'"/> 
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'icon_type':  
								$html.= '<input type="hidden" id="'.$field['id'].'_font_icon" name="'.$field['id'].'" value="'.$meta.'"/>';
								$html.= '<div class="'.$field['id'].' pw_iconpicker_grid" id="benefit_image_icon">';
								$html.= include(__PW_ROOT_WOO_AD_SEARCH__ .'/includes/font-awesome.php');
								$html.= '</div>';
								$output = '
								<script type="text/javascript"> 
									jQuery(document).ready(function(jQuery){';
										if ($meta == '') $meta ="fa-none";
										$output .= 'jQuery( ".'.$field['id'].' .'.$meta.'" ).siblings( ".active" ).removeClass( "active" );
										jQuery( ".'.$field['id'].' .'.$meta.'" ).addClass("active");';
								$output.='
										jQuery(".'.$field['id'].' i").click(function(){
											var val=(jQuery(this).attr("class").split(" ")[0]!="fa-none" ? jQuery(this).attr("class").split(" ")[0]:"");
											jQuery("#'.$field['id'].'_font_icon").val(val);
											jQuery(this).siblings( ".active" ).removeClass( "active" );
											jQuery(this).addClass("active");
										});
									});
								</script>';
								$html.= $output;
							break; 
							
							case 'color_picker':
							{	
								$default_value=(isset($field['value']) ? $field['value']:"#fc5b5b");
							
								$html.= '<div class="medium-lbl-cnt">
										<label for="'.$field['id'].'-color" class="full-label">'.$field['label'].'</label><input name="'.$field['id'].'" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="'.($meta!=''?$meta:$default_value).'" data-default-color="'.$default_value.'">
									 </div>';
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>
								';
							}
							break;
							
							case "pw_pagination_number_color_set":
							{
								if(!is_array($meta))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										 </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#333333" data-default-color="#333333">
										  </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Bg Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										  </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Text Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#141414" data-default-color="#141414">
									      </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Actice Bg Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active_bg-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#8e8e8e" data-default-color="#8e8e8e">
										 </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Active Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active-text-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										  </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Border Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[border-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#7C7C7C" data-default-color="#7C7C7C">
										 </div>';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Bg Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-color'].'" data-default-color="#'.$meta['bg-color'].'">
										</div>';	
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-color'].'" data-default-color="#'.$meta['text-color'].'">
										  </div>';	
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Bg Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-hcolor'].'" data-default-color="#'.$meta['bg-hcolor'].'">
										  </div>';	
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Text Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-hcolor'].'" data-default-color="#'.$meta['text-hcolor'].'">
										  </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Actice Bg Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active_bg-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="'.$meta['active_bg-color'].'" data-default-color="#'.$meta['active_bg-color'].'">
										</div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Active Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active-text-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="'.$meta['active-text-color'].'" data-default-color="#'.$meta['active-text-color'].'">
										  </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Border Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[border-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="'.$meta['border-color'].'" data-default-color="#'.$meta['border-color'].'">
										</div>';
								}
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>

								';
							}
							break;
							
							case "pw_pagination_showmore_color_set":
							{
								if(!is_array($meta))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										 </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#333333" data-default-color="#333333">
										</div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
											</div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#141414" data-default-color="#141414">
										 </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Border Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[border-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#7C7C7C" data-default-color="#7C7C7C">
										  </div>';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Bg Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-color'].'" data-default-color="#'.$meta['bg-color'].'">
										</div>';	

									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-color'].'" data-default-color="#'.$meta['text-color'].'">
										  </div>';	
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-hcolor'].'" data-default-color="#'.$meta['bg-hcolor'].'">
										  </div>';	
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-hcolor'].'" data-default-color="#'.$meta['text-hcolor'].'">
										  </div>';
									
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Border Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[border-color]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="'.$meta['border-color'].'" data-default-color="#'.$meta['border-color'].'">
										  </div>';
								}
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>

								';
							}
							break;
						} //end switch  
				$html.= '</td></tr>';  
			} // end foreach  
			$html.= '</table>'; // end table  
			return $html;
	}
	
	function ad_search_grid_fields_order_setting() {  
		global $ad_search_grid_fields_order_setting, $post;
		// Use nonce for verification  
		$html= '<input type="hidden" name="show_custom_meta_box_woo_ad_search_grid_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
			  
			// Begin the field table and loop  
			$html.= '<table class="form-table">';  
			foreach ($ad_search_grid_fields_order_setting as $field) {  
			
				if(isset($field['dependency']))  
				{
					$html.=pw_woo_ad_search_dependency($field['id'],$field['dependency']);	
				}
				
				// get value of this field if it exists for this post  
				$meta = get_post_meta($post->ID, $field['id'], true);  
				// begin a table row with 
				$style='';
				if($field['type']=='notype')
					$style='style="border-bottom:solid 1px #ccc"';
				$html.= '<tr class="'.$field['id'].'_field" '.$style.'> 

						<th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
						<td>';  
						switch($field['type']) {  
							
							case 'notype':
								$html.= '<span class="description">'.$field['desc'].'</span>';
							break;
							
							case 'checkbox':  

								if(isset($field['options']) && is_array($field['options'])){
									foreach ( $field['options'] as $option ) {
										$checked='';
										if(is_array($meta) && in_array($option['value'],$meta))
											$checked='checked';
										$html.= '<input type="checkbox" name="'.$field['id'].'[]" value="'.$option['value'].'" '.$checked.' /> 
												<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
									}
								}else
								{
							
									$html.= '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" '.checked( $meta, "on" ,0).'"/>'; 
								}
									$html.= '<br /><span class="description">'.$field['desc'].'</span>';  
							break;


							
							case 'pw_custom_search_fields':
								$html.= '
									<label class="pw_showhide" for="displayProduct-title"><input name="'.$field['id'].'[]" type="checkbox" value="title" '.(is_array($meta) && in_array("title",$meta) ? "CHECKED": "").'>'.__('Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>

									<label class="pw_showhide" for="displayProduct-saleprice"><input name="'.$field['id'].'[]" type="checkbox" value="main_price_range" '.(is_array($meta) && in_array("main_price_range",$meta) ? "CHECKED": "").' class="displayProduct-eneble">'.__('Price Range',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" style="width:97%" for="displayProduct-status"><input name="'.$field['id'].'[]" type="checkbox" value="product_status" '.(is_array($meta) && in_array("product_status",$meta) ? "CHECKED": "").' class="displayProduct-eneble">'.__(' Product Status (Featured, On-sale Products, In Stock Products, Out of Stock Products)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									
									<p style="clear:both"></p>
									<br />
									<span class="description">'.$field['desc'].'</span>
								';
							break;
							
							case 'OLD_pw_custom_taxonomy_filter':
							{
								$post_name='product';
								$option_data='';
								$param_line='';
								
								$all_tax=get_object_taxonomies( $post_name );
								$current_value=array();
								if(is_array($all_tax) && count($all_tax)>0){
									$post_type_label=get_post_type_object( $post_name );
									$label=$post_type_label->label ; 
									$param_line .='<div class="header-lbl">'.$label.' Taxonomies</div>';
									
									//FETCH TAXONOMY
									foreach ( $all_tax as $tax ) {
										$taxonomy=get_taxonomy($tax);	
										$values=$tax;
										$label=$taxonomy->label;
							
										$checked='';
										if ( is_array($meta) && in_array($values,  $meta) ) $checked = ' checked="checked"';
										
										$param_line .=' 
										<div class="full-lbl-cnt more-padding">
											<label class="full-label">
												<input type="checkbox" data-input="post_type" value="'.$tax.'" id="pw_checkbox_'.$tax.'" name="'.$field['id'].'[]" class="pw_taxomomy_checkbox" '.$checked.'> 
												'.$label.'
											</label>
										</div>';	
									}
								}else{
									$param_line=__('Please Install Woocommecer Plugin!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__);
								}
								$html.= $param_line;
								$html.= '<br /><span class="description">'.$field['desc'].'</span>';
							}
							break;
							
							case 'pw_custom_taxonomy_filter':
							{
								
								$attribute_taxonomies = wc_get_attribute_taxonomies();
								$attribute_taxonomies_name_lbl=array();
								foreach($attribute_taxonomies as $attributes){
									
									$attr_label = ! empty( $attributes->attribute_label ) ? $attributes->attribute_label : $attributes->attribute_name;
									
									$attribute_taxonomies_name_lbl['pa_' .$attributes->attribute_name]['name']='pa_' .$attributes->attribute_name;
									$attribute_taxonomies_name_lbl['pa_' .$attributes->attribute_name]['lbl']=$attr_label;
								}
								
								$original_query = $post;
							
								$post_name='product';
								$option_data='';
								$param_line='';
								
								$all_tax=get_object_taxonomies( $post_name );
								$current_value=array();
								if(is_array($all_tax) && count($all_tax)>0){
									
									$post_type_label=get_post_type_object( $post_name );
									$label=$post_type_label->label ; 
									$param_line .='<div class="header-lbl">'.$label.' Taxonomies</div>';
									
									//FETCH TAXONOMY
									foreach ( $all_tax as $tax ) {
										$taxonomy=get_taxonomy($tax);	
										$values=$tax;
										$label=$taxonomy->label;
							
										$checked='';
										if (isset($meta['taxonomy_checkbox']) &&  in_array($tax, $meta['taxonomy_checkbox']) ) 
											$checked = ' checked="checked"';
										
										$attribute_taxonomies = wc_get_attribute_taxonomies();
										$pw_display_type='';
										
										
										//if(array_key_exists($tax,$attribute_taxonomies_name_lbl)){
											
											
											$pw_display_type='
											<select id="pw_display_type_'.$tax.'" name="'.$field['id'].'[taxonomy_display_type_'.$tax.'][]" class="pw_woo_search_taxonomy_display_type" > 
												<option value="">'.__('Choose Display Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
												<optgroup label="'.__('Dropdown Types',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
													<option value="pw_tax_display_dropdown_lbl" '.(isset($meta['taxonomy_display_type_'.$tax]) &&  in_array('pw_tax_display_dropdown_lbl', $meta['taxonomy_display_type_'.$tax]) ? "SELECTED":"").'>'.__('Just Label',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
												
													<option value="pw_tax_display_dropdown_lbl_img" '.(isset($meta['taxonomy_display_type_'.$tax]) &&  in_array('pw_tax_display_dropdown_lbl_img', $meta['taxonomy_display_type_'.$tax]) ? "SELECTED":"").'>'.__('Label & Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
												</optgroup>
												
												<optgroup label="'.__('List Types',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
													<option value="pw_tax_display_inline_lbl" '.(isset($meta['taxonomy_display_type_'.$tax]) &&  in_array('pw_tax_display_inline_lbl', $meta['taxonomy_display_type_'.$tax]) ? "SELECTED":"").'>'.__('Just Label - Inline',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
												
													<option value="pw_tax_display_list_lbl" '.(isset($meta['taxonomy_display_type_'.$tax]) &&  in_array('pw_tax_display_list_lbl', $meta['taxonomy_display_type_'.$tax]) ? "SELECTED":"").'>'.__('Just Label - List',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
													
													<option value="pw_tax_display_inline_img" '.(isset($meta['taxonomy_display_type_'.$tax]) &&  in_array('pw_tax_display_inline_img', $meta['taxonomy_display_type_'.$tax]) ? "SELECTED":"").'>'.__('Just Image - Inline',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
												
													<option value="pw_tax_display_list_lbl_img" '.(isset($meta['taxonomy_display_type_'.$tax]) &&  in_array('pw_tax_display_list_lbl_img', $meta['taxonomy_display_type_'.$tax]) ? "SELECTED":"").'>'.__('Label & Image- List',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
													
												</optgroup>	
												
											</select>
											
											';
										//}
										
										$param_line .=' 
										<div class="full-lbl-cnt more-padding">
											<label class="full-label">
												<input type="checkbox" data-input="post_type" value="'.$tax.'" id="pw_checkbox_'.$tax.'" name="'.$field['id'].'[taxonomy_checkbox][]" class="pw_taxomomy_checkbox" '.$checked.'>
												
												'.$label.'
											</label>
											'.$pw_display_type;
											
							
											$param_line_exclude =$param_line_include = '<select name="'.$field['id'].'[in_'.$tax.'][]" class="chosen-select" multiple="multiple" style="width: 531px;" data-placeholder="'.__('Choose Inclulde ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' '.$label.' ..." id="pw_'.$tax.'">';
											$param_line_exclude = '<select name="'.$field['id'].'[ex_'.$tax.'][]" class="chosen-select" multiple="multiple" style="width: 531px;" data-placeholder="'.__('Choose Exclude',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' '.$label.' ..." id="pw_'.$tax.'">';
											$args = array(
												'taxonomy'       			 =>  $tax,
												'name'          		     =>  'pw_'.$tax.'[]',
												'id'                       =>  'pw_'.$tax,
												'orderby'                  => 'name',
												'order'                    => 'ASC',
												'hide_empty'               => 0,
												'hierarchical'             => 1,
												'exclude'                  => '',
												'include'                  => '',
												'child_of'          		 => 0,
												'number'                   => '',
												'pad_counts'               => false 
											
											); 
							
											$categories = get_categories($args); 
											foreach ($categories as $category) {
												$selected='';
												if(isset($meta['in_'.$tax]) && is_array($meta['in_'.$tax]))
												{
													$selected=(in_array($category->cat_ID,$meta['in_'.$tax]) ? "SELECTED":"");
												}
												
												$option = '<option value="'.$category->cat_ID.'" '.$selected.'>';
												$option .= $category->cat_name;
												$option .= ' ('.$category->category_count.')';
												$option .= '</option>';
												$param_line_include .= $option;
	
											}
											$param_line_include .='</select>';
											
											$categories = get_categories($args); 
											foreach ($categories as $category) {
												$selected='';
												if(isset($meta['ex_'.$tax]) && is_array($meta['ex_'.$tax]))
												{
													$selected=(in_array($category->cat_ID,$meta['ex_'.$tax]) ? "SELECTED":"");
												}
												
												$option = '<option value="'.$category->cat_ID.'" '.$selected.'>';
												$option .= $category->cat_name;
												$option .= ' ('.$category->category_count.')';
												$option .= '</option>';
												$param_line_exclude .= $option;
											}
											$param_line_exclude .='</select>';
											$param_line .= $param_line_include.$param_line_exclude.'
										</div>';	
									}
								
								
									//CREATE INDIVIDUAL SELECT BOX
									$pw_post_id='';
									$args_post = array('post_type' => $post_name);
									$loop_post = new WP_Query( $args_post );
									$option_data.='<optgroup label="'.$post_name.'">';
									while ( $loop_post->have_posts() ) : $loop_post->the_post();
										$selected='';
										if(isset($meta['ids']))
										{
											$selected=(in_array(get_the_ID(),$meta['ids']) ? "SELECTED":"");
										}
										$option_data.='<option '.$selected.' value="'.get_the_ID().'">'.get_the_title().'</option>';
									endwhile;
									
									$post = $original_query;
            						wp_reset_postdata();
									
									$option_data.='</optgroup>';
								}else{
									$param_line=__('Please Install Woocommecer Plugin!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__);
								}
								
								$param_line.='
									<script type="text/javascript"> 
										jQuery(document).ready(function(){
											
											/*jQuery.when( jQuery(".chosen-select").chosen() ).done(function( x ) {
												jQuery(".chosen-container").each(function(){
													//jQuery(this).css({"width": "500px"});
												});
											});*/
											
										});
									</script>
								';
								$html.= $param_line;

							}
							break;
							
							case 'pw_custom_search_orders':
								$html.= '
									<label class="pw_showhide" for="displayProduct-title"><input name="'.$field['id'].'[]" type="checkbox" value="date" '.(is_array($meta) && in_array("date",$meta) ? "CHECKED": "").'>'.__('Date',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-excerpt"><input name="'.$field['id'].'[]" type="checkbox" value="title" '.(is_array($meta) && in_array("title",$meta) ? "CHECKED": "").' class="displayProduct-eneble">'.__('Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' 
									</label>                                    
									
									<label class="pw_showhide" for="displayProduct-image"><input name="'.$field['id'].'[]" type="checkbox" value="_price" '.(is_array($meta) && in_array("_price",$meta) ? "CHECKED": "").' class="displayProduct-eneble">'.__('Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-image"><input name="'.$field['id'].'[]" type="checkbox" value="_regular_price" '.(is_array($meta) && in_array("_regular_price",$meta) ? "CHECKED": "").' class="displayProduct-eneble">'.__('Regular Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>                            
									<label class="pw_showhide" for="displayProduct-image"><input name="'.$field['id'].'[]" type="checkbox" value="_sale_price" '.(is_array($meta) && in_array("_sale_price",$meta) ? "CHECKED": "").' class="displayProduct-eneble">'.__('Sale Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									
									<label class="pw_showhide" for="displayProduct-sale"><input name="'.$field['id'].'[]" type="checkbox" value="total_sales" '.(is_array($meta) && in_array("total_sales",$meta) ? "CHECKED": "").' class="displayProduct-eneble">'.__('Number Of Sales',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>                            

									<label class="pw_showhide" for="displayProduct-metacategory"><input name="'.$field['id'].'[]" type="checkbox" value="_featured" '.(is_array($meta) && in_array("_featured",$meta) ? "CHECKED": "").'>'.__('Featured Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-metacategory"><input name="'.$field['id'].'[]" type="checkbox" value="_sku" '.(is_array($meta) && in_array("_sku",$meta) ? "CHECKED": "").'>'.__('SKU',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[]" type="checkbox" value="num_stock" '.(is_array($meta) && in_array("num_stock",$meta) ? "CHECKED": "").'>'.__(' Stock Quantity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[]" type="checkbox" value="ID" '.(is_array($meta) && in_array("ID",$meta) ? "CHECKED": "").'>'.__(' ID',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[]" type="checkbox" value="author" '.(is_array($meta) && in_array("author",$meta) ? "CHECKED": "").'>'.__(' Author',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[]" type="checkbox" value="modified" '.(is_array($meta) && in_array("modified",$meta) ? "CHECKED": "").'>'.__(' Modified',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[]" type="checkbox" value="rand" '.(is_array($meta) && in_array("rand",$meta) ? "CHECKED": "").'>'.__(' Random',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[]" type="checkbox" value="comment_count" '.(is_array($meta) && in_array("comment_count",$meta) ? "CHECKED": "").'>'.__(' Comment Count',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[]" type="checkbox" value="menu_order" '.(is_array($meta) && in_array("menu_order",$meta) ? "CHECKED": "").'>'.__(' Menu Order',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
								';
							break;
							
							
							case 'radio':  
								foreach ( $field['options'] as $option ) {
									$html.= '<input type="radio" name="'.$field['id'].'" value="'.$option['value'].'" '.checked( $meta, $option['value'] ,0).' '.$option['checked'].' /> 
											<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
								}  
							break;
							case 'select':  
								$html.= '<select name="'.$field['id'].'" id="'.$field['id'].'" style="width: 170px;">';  
								foreach ($field['options'] as $option) {  
									$html.= '<option '. selected( $meta , $option['value'],0 ).' value="'.$option['value'].'">'.$option['label'].'</option>';  
								}  
								$html.= '</select><br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'numeric':  
								$default_value=(isset($field['value'])? $field['value']:"");
								$html.= '
								<input type="number" name="'.$field['id'].'" id="'.$field['id'].'" value="'.($meta=='' ? $default_value:$meta).'" size="30" class="width_170" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />
	';
								$html.= '
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
						
						} //end switch  
				$html.= '</td></tr>';  
			} // end foreach  
			$html.= '</table>'; // end table  
			return $html;
	}
	
	function ad_search_grid_layout_setting() {  
		global $ad_search_grid_layout_setting, $post;
		// Use nonce for verification  
		$html= '<input type="hidden" name="show_custom_meta_box_woo_ad_search_grid_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
			  
			// Begin the field table and loop  
			$html.= '<table class="form-table" id="pw_woo_ad_search_frontend_setting">';  
			foreach ($ad_search_grid_layout_setting as $field) {  
				
				//IF FAVORITE STICKY DISABLED
				if(($field['id']==__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite' || $field['id']==__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'favorite_icon_color') && get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='')	
					continue;
					
				if(isset($field['dependency']))  
				{
					$html.= pw_woo_ad_search_dependency($field['id'],$field['dependency']);	
				}
				
				// get value of this field if it exists for this post  
				$meta = get_post_meta($post->ID, $field['id'], true);  
			
				// begin a table row with  
				$style='';
				
				if($field['type']=='notype')
					$style='style="border-bottom:solid 1px #ccc"';
					
				
					
				$html.= '<tr class="'.$field['id'].'_field" '.$style.'> 

						<th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
						<td>';  
						switch($field['type']) {  
						
							case 'notype':
								$html.= '<span class="description">'.$field['desc'].'</span>';
							break;

							case 'text':  
	
								$html.= '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" />
								<br /><span class="description">'.$field['desc'].'</span>	';  
							break; 
							
							case 'radio':  
								foreach ( $field['options'] as $option ) {
									$html.= '<input type="radio" name="'.$field['id'].'" value="'.$option['value'].'" '.checked( $meta, $option['value'] ,0).' '.$option['checked'].' /> 
											<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
								}  
							break;
							
							case 'select':  
								$html.= '<select name="'.$field['id'].'" id="'.$field['id'].'" style="width: 170px;">';  
								foreach ($field['options'] as $option) {  
									$html.= '<option '. selected( $meta , $option['value'],0 ).' value="'.$option['value'].'">'.$option['label'].'</option>';  
								}  
								$html.= '</select><br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'numeric':  
								$default_value=(isset($field['value'])? $field['value']:"");
								//$html.=$default_value;
								//$html.= $meta;
								$html.= '
								<input type="number" name="'.$field['id'].'" id="'.$field['id'].'" value="'.($meta=='' ? $default_value:$meta).'" size="30" class="width_170" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />
	';
								$html.= '
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'checkbox':  

								if(isset($field['options']) && is_array($field['options'])){
									foreach ( $field['options'] as $option ) {
										$checked='';
										if(is_array($meta) && in_array($option['value'],$meta))
											$checked='checked';
										$html.= '<input type="checkbox" name="'.$field['id'].'[]" value="'.$option['value'].'" '.$checked.' /> 
												<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
									}
								}else
								{
							
									$html.= '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" '.checked( $meta, "on" ,0).'"/>'; 
								}
									$html.= '<br /><span class="description">'.$field['desc'].'</span>';  
							break;
							
							case 'icon_type':  
							{
								$html.= '<input type="hidden" id="'.$field['id'].'_font_icon" name="'.$field['id'].'" value="'.$meta.'"/>';
								$html.= '<div class="'.$field['id'].' pw_iconpicker_grid" id="benefit_image_icon">';
								$html.=include(__PW_ROOT_WOO_AD_SEARCH__ .'/includes/font-awesome.php');
								$html.= '</div>';
								$output = '
								<script type="text/javascript"> 
									jQuery(document).ready(function(jQuery){';
										if ($meta == '') $meta ="fa-none";
										$output .= 'jQuery( ".'.$field['id'].' .'.$meta.'" ).siblings( ".active" ).removeClass( "active" );
										jQuery( ".'.$field['id'].' .'.$meta.'" ).addClass("active");';
								$output.='
										jQuery(".'.$field['id'].' i").click(function(){
											var val=(jQuery(this).attr("class").split(" ")[0]!="fa-none" ? jQuery(this).attr("class").split(" ")[0]:"");
											jQuery("#'.$field['id'].'_font_icon").val(val);
											jQuery(this).siblings( ".active" ).removeClass( "active" );
											jQuery(this).addClass("active");
										});
									});
								</script>';
								$html.= $output;
							}
							break; 
							
							case 'pw_custom_search_fields':
							{
								$html.= '
									<label class="pw_showhide" for="displayProduct-title"><input name="'.$field['id'].'[add_cart]" type="checkbox" '.(is_array($meta) && in_array("add_cart",$meta) ? "CHECKED": "").' value="add_cart" id="pw_add_cart_btn">'.__('Add to Cart',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-title"><input name="'.$field['id'].'[title]" type="checkbox" '.(is_array($meta) && in_array("title",$meta) ? "CHECKED": "").' value="title">'.__('Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-excerpt"><input name="'.$field['id'].'[excerpt]" type="checkbox" '.(is_array($meta) && in_array("excerpt",$meta) ? "CHECKED": "").' value="excerpt" class="displayProduct-eneble">'.__('Excerpt',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' 
									</label>                                    
									
									<label class="pw_showhide" for="displayProduct-image"><input name="'.$field['id'].'[thumbnail]" type="checkbox" '.(is_array($meta) && in_array("thumbnail",$meta) ? "CHECKED": "").' value="thumbnail" class="displayProduct-eneble">'.__('Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>                            
									
									<label class="pw_showhide" for="displayProduct-price"><input name="'.$field['id'].'[price]" type="checkbox" '.(is_array($meta) && in_array("price",$meta) ? "CHECKED": "").' value="price" class="displayProduct-eneble">'.__('Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>                            
									
									<label class="pw_showhide" for="displayProduct-star"><input name="'.$field['id'].'[star]" type="checkbox" '.(is_array($meta) && in_array("star",$meta) ? "CHECKED": "").' value="star" class="displayProduct-eneble">'.__('Star',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>                                    
									
									<label class="pw_showhide" for="displayProduct-sku"><input name="'.$field['id'].'[sku]" type="checkbox" '.(is_array($meta) && in_array("sku",$meta) ? "CHECKED": "").' value="sku">'.__('SKU',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-metacategory"><input name="'.$field['id'].'[category]" type="checkbox" '.(is_array($meta) && in_array("category",$meta) ? "CHECKED": "").' value="category">'.__('Category',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[tag]" type="checkbox" '.(is_array($meta) && in_array("tag",$meta) ? "CHECKED": "").' value="tag">'.__('Tag',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-featured"><input name="'.$field['id'].'[featured]" type="checkbox" '.(is_array($meta) && in_array("featured",$meta) ? "CHECKED": "").' value="featured" class="displayProduct-eneble">'.__('Featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									<label class="pw_showhide" for="displayProduct-sale"><input name="'.$field['id'].'[sale]" type="checkbox" '.(is_array($meta) && in_array("sale",$meta) ? "CHECKED": "").' value="sale" class="displayProduct-eneble">'.__('Sale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
									<label class="pw_showhide" for="displayProduct-outofstock"><input name="'.$field['id'].'[out_stock]" type="checkbox" '.(is_array($meta) && in_array("stock_status",$meta) ? "CHECKED": "").' value="stock_status">'.__('Stock Status',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									
								';
							}
							break;
							
							case 'font_select':
							{
								$html.= '
								<select name="'.$field['id'].'" id="'.$field['id'].'">                                                <option value="Droid+Sans">Droid Sans</option>                                                <option value="Source+Sans+Pro">Source Sans Pro</option>                                                <option value="Source+Sans+Pro">Nixie One</option>                                                <option value="Signika+Negative">Signika Negative</option>                                                <option value="Lato">Lato</option>                                                <option value="Lora">Lora</option>                                                <option value="PT+Sans+Narrow">PT Sans Narrow</option>                                                <option value="Ubuntu">Ubuntu</option>                                                <option value="Contrail+One">Contrail One</option>                                                <option value="Bitter">Bitter</option>                                                <option value="Lobster">Lobster</option>                                                <option value="Shadows+Into+Light">Shadows Into Light</option>                                                <option value="Libre+Baskerville">Libre Baskerville</option>                                                <option value="Open+Sans">Open Sans</option>                                                <option value="Open+Sans+Condensed">Open Sans Condensed</option>                                                <option value="Varela+Round">Varela Round</option>                                                <option value="Cinzel">Cinzel</option>                                                <option value="Comfortaa">Comfortaa</option>                                                <option value="Doppio+One">Doppio+One</option>                                        </select>
								';
							}
							break;
							
							case 'color_picker':
							{	
								$default_value=(isset($field['value']) ? $field['value']:"#fc5b5b");
								$html.= '<div class="medium-lbl-cnt">
										<label for="'.$field['id'].'-color" class="full-label">'.$field['label'].'</label><input name="'.$field['id'].'" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="'.($meta!=''?$meta:$default_value).'" data-default-color="'.$default_value.'">
									 </div>';
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>
								';
							}
							break;
							
							case 'pw_custom_color_set':
							{
								$html.= '
								<a class="set-color" rel="theme1"><span style="background-color:#fc5b5b"></span><span style="background-color:#27872b"></span><span style="background-color:#8224e3"></span><span style="background-color:#d34dd6"></span><span style="background-color:#1e1e1e"></span><span style="background-color:#c44f46"></span><span style="background-color:#50a9e0"></span><span style="background-color:#bf4465"></span><span style="background-color:#4a74ce"></span><span style="background-color:#262626"></span></a>
								
								<a class="set-color" rel="theme2"><span style="background-color:#4bcd36"></span><span style="background-color:#28cedb"></span><span style="background-color:#96ffdd"></span><span style="background-color:#dda6a6"></span><span style="background-color:#fff600"></span><span style="background-color:#afff4f"></span><span style="background-color:#fd6af0"></span><span style="background-color:#fd6a70"></span><span style="background-color:#ffffff"></span><span style="background-color:#ffb73a"></span></a>
								
								<a class="set-color" rel="theme8"><span style="background-color:#1abc9c"></span><span style="background-color:#2ecc71"></span><span style="background-color:#3498db"></span><span style="background-color:#9b59b6"></span><span style="background-color:#34495e"></span><span style="background-color:#16a085"></span><span style="background-color:#e74c3c"></span><span style="background-color:#e67e22"></span><span style="background-color:#c0392b"></span><span style="background-color:#7f8c8d"></span></a>
								
								<a class="set-color" rel="theme8"><span style="background-color:#95a5a6"></span><span style="background-color:#ffffff"></span><span style="background-color:#bdc3c7"></span><span style="background-color:#ecf0f1"></span><span style="background-color:#f39c12"></span><span style="background-color:#f1c40f"></span><span style="background-color:#96ffdd"></span><span style="background-color:#afff4f"></span><span style="background-color:#7f8c8d"></span><span style="background-color:#e8c0df"></span></a>
								<br />
								';
								
								$html.= '
								<input name="'.$field['id'].'[c0]" id="color_set_0" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c0']).'" data-default-color="#fc5b5b">			
								
								<input name="'.$field['id'].'[c1]" id="color_set_1" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c1']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c2]" id="color_set_2" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c2']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c3]" id="color_set_3" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c3']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c4]" id="color_set_4" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c4']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c5]" id="color_set_5" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c5']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c6]" id="color_set_6" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c6']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c7]" id="color_set_7" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c7']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c8]" id="color_set_8" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c8']).'" data-default-color="#fc5b5b">
								
								<input name="'.$field['id'].'[c9]" id="color_set_9" type="text" class="color_set wp_ad_picker_color" value="'.($meta=='' ? "#fc5b5b":$meta['c9']).'" data-default-color="#fc5b5b">
								
								';
								
								$html.= '
								<script type="text/javascript">
								
									function hexc(colorval) {
										var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
										delete(parts[0]);
										for (var i = 1; i <= 3; ++i) {
											parts[i] = parseInt(parts[i]).toString(16);
											if (parts[i].length == 1) parts[i] = "0" + parts[i];
										}
										color = "#" + parts.join("");
										return color;
									}
									
									jQuery(document).ready(function($) {   
										jQuery(".set-color").click(function(){
											jQuery(this).find("span").each(function(index, elem){
												var $color=hexc(jQuery(elem).css("backgroundColor"));
												jQuery("#color_set_"+index).val($color);
												jQuery("#color_set_"+index).wpColorPicker("color",$color);
											});
										});
									});
								</script>
								';	
								
							}
							break;
							
							case 'pw_custom_border_set':
							{
								if(!isset($meta['color']))
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
											<input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="#dddddd" data-default-color="#dddddd">
										  </div>';
								else
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
											<input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color'].'" data-default-color="#'.$meta['color'].'">
										  </div>';	
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>';
								
								$border_type=array('solid','dotted','dashed','none','hidden','double','groove','ridge','inset','outset','initial','inherit');
								$html.= '
								<div class="medium-lbl-cnt">
									<label for="'.$field['id'].'" class="full-label">'.__('Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									<select name="'.$field['id'].'[type]" id="'.$field['id'].'">';
									foreach($border_type as $b_type){
										if(is_array($meta))
											$html.= '<option value="'.$b_type.'" '.selected($b_type,$meta['type'],0).'>'.$b_type.'</option>';
										else
											$html.= '<option value="'.$b_type.'" >'.$b_type.'</option>';	
											
									}
									$html.= '</select>
								</div>';
								
								$html.= '
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
									<input type="number" name="'.$field['id'].'[top]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['top']).'" size="1"  min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </span>
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[right]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['right']).'" size="1" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'  </span>
								</div>	
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Bottom',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[bottom]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['bottom']).'" size="1" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span> 
								</div>
								<div class="small-lbl-cnt">								
									<label for="'.$field['id'].'" class="small-label">'.__('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[left]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['left']).'" size="1" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>';
								
								
							}
							break;
							
							case "pw_custom_border_radius_set":
							{
								$html.= '
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[top]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['top']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span> 
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[right]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['right']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Bottom',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[bottom]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['bottom']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>  
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[left]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['left']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>';
							}
							break;
							
							case "pw_custom_padding_set":
							{
								$html.= '
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[top]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['top']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>
								<div class="small-lbl-cnt"> 
									<label for="'.$field['id'].'" class="small-label">'.__('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[right]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['right']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>  
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Bottom',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[bottom]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['bottom']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>  
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[left]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['left']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>
	';
							}
							break;
							
							case "pw_custom_margin_set":
							{
								$html.= '
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[top]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['top']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[right]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['right']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Bottom',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[bottom]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['bottom']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>  
								</div>
								<div class="small-lbl-cnt">
									<label for="'.$field['id'].'" class="small-label">'.__('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[left]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['left']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>';	
							}
							break;
							
							/*case "pw_custom_overlay_set":
							{
								if(!isset($meta['color']))
								{
									$html.= '<label for="'.$field['id'].'-color">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">';
									$html.= '<label for="'.$field['id'].'-hover">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">';
								}
								else{
									$html.= '<label for="'.$field['id'].'-color">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color'].'" data-default-color="#'.$meta['color'].'">';	
									$html.= '<label for="'.$field['id'].'-hover">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['hcolor'].'" data-default-color="#'.$meta['hcolor'].'">';	
								}
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>
								<br />';
								
								$html.= '
								<label for="'.$field['id'].'">- '.__('Opacity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
								<input type="number" name="'.$field['id'].'[opacity]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['opacity']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /> - 
								<label for="'.$field['id'].'">'.__('Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
								<select name="'.$field['id'].'[effect]" id="'.$field['id'].'" class="vc_border-style"><option value="solid">Effect 1</option><option value="solid">Effect 2</option><option value="dotted">Effect 3</option><option value="dashed">Effect 4</option><option value="none">Effect 5</option><option value="hidden">Effect 6</option><option value="double">Effect 7</option><option value="groove">Effect 8</option></select> <br />
								Padding :
								<label for="'.$field['id'].'" class="small-label">'.__('Top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
								<input type="number" name="'.$field['id'].'[padding-top]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['padding-top']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'  
								<label for="'.$field['id'].'" class="small-label">'.__('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
								<input type="number" name="'.$field['id'].'[padding-right]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['padding-right']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'  
								
								<label for="'.$field['id'].'" class="small-label">'.__('Bottom',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
								<input type="number" name="'.$field['id'].'[padding-bottom]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['padding-bottom']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'  
								
								<label for="'.$field['id'].'" class="small-label">'.__('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
								<input type="number" name="'.$field['id'].'[padding-left]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['padding-left']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'
	';
							}
							break;
							*/
							case "pw_custom_font_set":
							{
								if(!isset($meta['color']))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#333333" data-default-color="#333333">
										  </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">
										  </div>';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color'].'" data-default-color="#'.$meta['color'].'">
										  </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['hcolor'].'" data-default-color="#'.$meta['hcolor'].'">
										  </div>';	
								}
								
								$html.= '<div class="medium-lbl-cnt">
										<label for="'.$field['id'].'" class="full-label">'.__('Size',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
										<input type="number" name="'.$field['id'].'[size]" id="'.$field['id'].'" value="'.($meta=='' ? "13":$meta['size']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>  
									  </div>
									  <div class="medium-lbl-cnt">
										<label for="'.$field['id'].'" class="full-label">'.__('Font Family',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
										<select name="'.$field['id'].'[font-family]" id="'.$field['id'].'-family"><option value="inherit">Inherit</option>'.pw_woo_ad_get_google_fonts((isset($meta['font-family'])?$meta['font-family']:'')).'</select>
										<script type="text/javascript">
											function pw_search_isNumber(n) {
											  return !isNaN(parseFloat(n)) && isFinite(n);
											}
											jQuery(document).ready(function(){
												
												if(jQuery("#'.$field['id'].'-family").val()!="inherit")
												{
													jQuery("head").append("<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family="+jQuery("#'.$field['id'].'-family").val()+"\" />");	
													var $font_family=jQuery("#'.$field['id'].'-family").val();
													var $font_arr=$font_family.split(":");
													if($font_arr.length>0 && pw_search_isNumber($font_arr[1]))
													{
														$font_weight=$font_arr[1];
														$font_name=$font_arr[0].replace("+"," ");
														jQuery(".pw-check-font-'.$field['id'].'-family").css({"font-family":$font_name,"font-weight":$font_weight});
													}else
													{
														jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery("#'.$field['id'].'-family").find(":selected").text());
													}
													
													jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery("#'.$field['id'].'-family").find(":selected").text());
												}
												
												jQuery("#'.$field['id'].'-family").change(function(){
													jQuery("head").append("<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family="+jQuery(this).val()+"\" />");	
													
													var $font_family=jQuery(this).val();
													var $font_arr=$font_family.split(":");
													if($font_arr.length>0 && pw_search_isNumber($font_arr[1]))
													{
														$font_weight=$font_arr[1];
														$font_name=$font_arr[0].replace("+"," ");
														jQuery(".pw-check-font-'.$field['id'].'-family").css({"font-family":$font_name,"font-weight":$font_weight});
													}else
													{
														jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery(this).find(":selected").text());
													}
												});
												
											});
										
										</script>
										<p class="pw-check-font-'.$field['id'].'-family">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>
									  </div>';
								
								
							}
							break;
							
							case "pw_custom_general_font_set":
							{
								if(!isset($meta['color']))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#333333" data-default-color="#333333">
										  </div>';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color'].'" data-default-color="#'.$meta['color'].'">
										</div>';	
								}
								
								$html.= '<div class="medium-lbl-cnt">
										<label for="'.$field['id'].'" class="full-label">'.__('Size',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
										<input type="number" name="'.$field['id'].'[size]" id="'.$field['id'].'" value="'.($meta=='' ? "13":$meta['size']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
									  </div>
									  <div class="medium-lbl-cnt">
									  	<label for="'.$field['id'].'" class="full-label">'.__('Font Family',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>								
										<select name="'.$field['id'].'[font-family]" id="'.$field['id'].'-family"><option value="inherit">Inherit</option>'.pw_woo_ad_get_google_fonts((isset($meta['font-family'])?$meta['font-family']:'')).'</select>
										
										
										<script type="text/javascript">
											function pw_search_isNumber(n) {
										  		return !isNaN(parseFloat(n)) && isFinite(n);
											}
											jQuery(document).ready(function(){
												
											
												if(jQuery("#'.$field['id'].'-family").val()!="inherit")
												{
													jQuery("head").append("<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family="+jQuery("#'.$field['id'].'-family").val()+"\" />");	
													var $font_family=jQuery("#'.$field['id'].'-family").val();
													var $font_arr=$font_family.split(":");
													if($font_arr.length>0 && pw_search_isNumber($font_arr[1]))
													{
														$font_weight=$font_arr[1];
														$font_name=$font_arr[0].replace("+"," ");
														jQuery(".pw-check-font-'.$field['id'].'-family").css({"font-family":$font_name,"font-weight":$font_weight});
													}else
													{
														jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery("#'.$field['id'].'-family").find(":selected").text());
													}
													
													jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery("#'.$field['id'].'-family").find(":selected").text());
												}
												
												jQuery("#'.$field['id'].'-family").change(function(){
													jQuery("head").append("<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family="+jQuery(this).val()+"\" />");	
													
													var $font_family=jQuery(this).val();
													var $font_arr=$font_family.split(":");
													if($font_arr.length>0 && pw_search_isNumber($font_arr[1]))
													{
														$font_weight=$font_arr[1];
														$font_name=$font_arr[0].replace("+"," ");
														jQuery(".pw-check-font-'.$field['id'].'-family").css({"font-family":$font_name,"font-weight":$font_weight});
													}else
													{
														jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery(this).find(":selected").text());
													}
												});
												
											});
										
										</script>
										<p class="pw-check-font-'.$field['id'].'-family">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>
									  </div>';
								
							}
							break;
							
							case "pw_custom_banner_font_set":
							{
								if(!isset($meta['color']))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										 </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-BgColor" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bgcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#81af3f" data-default-color="#81af3f">
										  </div>';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color'].'" data-default-color="#'.$meta['color'].'">
										  </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-BgColor" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bgcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bgcolor'].'" data-default-color="#'.$meta['bgcolor'].'">
										</div>';	
								}
								
								$html.= '
								<div class="medium-lbl-cnt">
									<label for="'.$field['id'].'" class="full-label">'.__('Size',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<input type="number" name="'.$field['id'].'[size]" id="'.$field['id'].'" value="'.($meta=='' ? "13":$meta['size']).'" size="1" style="width:50px" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="'.__('Only Digits!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
								</div>
								<div class="medium-lbl-cnt">
									<label for="'.$field['id'].'" class="full-label">'.__('Font Family',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
									<select name="'.$field['id'].'[font-family]" id="'.$field['id'].'-family"><option value="inherit">Inherit</option>'.pw_woo_ad_get_google_fonts((isset($meta['font-family'])?$meta['font-family']:'')).'</select>
									
									<script type="text/javascript">
											function pw_search_isNumber(n) {
												return !isNaN(parseFloat(n)) && isFinite(n);
											}
											jQuery(document).ready(function(){
												
												if(jQuery("#'.$field['id'].'-family").val()!="inherit")
												{
													jQuery("head").append("<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family="+jQuery("#'.$field['id'].'-family").val()+"\" />");	
													var $font_family=jQuery("#'.$field['id'].'-family").val();
													var $font_arr=$font_family.split(":");
													if($font_arr.length>0 && pw_search_isNumber($font_arr[1]))
													{
														$font_weight=$font_arr[1];
														$font_name=$font_arr[0].replace("+"," ");
														jQuery(".pw-check-font-'.$field['id'].'-family").css({"font-family":$font_name,"font-weight":$font_weight});
													}else
													{
														jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery("#'.$field['id'].'-family").find(":selected").text());
													}
													
													jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery("#'.$field['id'].'-family").find(":selected").text());
												}
												
												jQuery("#'.$field['id'].'-family").change(function(){
													jQuery("head").append("<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family="+jQuery(this).val()+"\" />");	
													
													var $font_family=jQuery(this).val();
													var $font_arr=$font_family.split(":");
													if($font_arr.length>0 && pw_search_isNumber($font_arr[1]))
													{
														$font_weight=$font_arr[1];
														$font_name=$font_arr[0].replace("+"," ");
														jQuery(".pw-check-font-'.$field['id'].'-family").css({"font-family":$font_name,"font-weight":$font_weight});
													}else
													{
														jQuery(".pw-check-font-'.$field['id'].'-family").css("font-family",jQuery(this).find(":selected").text());
													}
												});
												
											});
										
										</script>
										<p class="pw-check-font-'.$field['id'].'-family">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>
								</div>';
								
								
							}
							break;
							
							case "pw_custom_box_shadow_set":
							{
								
								if(is_array($meta))
								{
									$html.= '
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Horizontal Length',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[hor-len]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['hor-len']).'" size="1" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </span>
										</div>	
										<div class="medium-lbl-cnt"> 
											<label for="'.$field['id'].'" class="full-label">'.__('Vertical Length',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[ver-len]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['ver-len']).'" size="1" style="width:50px" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </span> 
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Blur Radius',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[blur-radius]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['blur-radius']).'" size="1" style="width:50px" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'  </span>
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Spread Radius',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[spread-radius]" id="'.$field['id'].'" value="'.($meta=='' ? "0":$meta['spread-radius']).'" size="1" style="width:50px" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Shadow Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="'.$meta['color'].'" data-default-color="#'.$meta['color'].'">
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Opacity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<select name="'.$field['id'].'[opacity]" id="'.$field['id'].'">
												<option value="0.1" '.selected($meta['opacity'],'0.1',0).'>0.1</option>
												<option value="0.2" '.selected($meta['opacity'],'0.2',0).'>0.2</option>
												<option value="0.3" '.selected($meta['opacity'],'0.3',0).'>0.3</option>
												<option value="0.4" '.selected($meta['opacity'],'0.4',0).'>0.4</option>
												<option value="0.5" '.selected($meta['opacity'],'0.5',0).'>0.5</option>
												<option value="0.6" '.selected($meta['opacity'],'0.6',0).'>0.6</option>
												<option value="0.7" '.selected($meta['opacity'],'0.7',0).'>0.7</option>
												<option value="0.8" '.selected($meta['opacity'],'0.8',0).'>0.8</option>
												<option value="0.9" '.selected($meta['opacity'],'0.9',0).'>0.9</option>
												<option value="1" '.selected($meta['opacity'],'1',0).'>1</option>
											</select>
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<select name="'.$field['id'].'[type]" id="'.$field['id'].'">
												<option value="outline" '.selected($meta['type'],'outline',0).'>Outline</option>
												<option value="inset" '.selected($meta['type'],'inset',0).'>Inset</option>
											</select>
										</div>
									<span class="description">'.$field['desc'].'</span>
									';
								}else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Horizontal Length',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[hor-len]" id="'.$field['id'].'" size="1" style="width:50px" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>  
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Vertical Length',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[ver-len]" id="'.$field['id'].'"  size="1" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</div>  
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Blur Radius',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[blur-radius]" id="'.$field['id'].'"  size="1"  pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</div>
										<div class="medium-lbl-cnt">  
											<label for="'.$field['id'].'" class="full-label">'.__('Spread Radius',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<input type="number" name="'.$field['id'].'[spread-radius]" id="'.$field['id'].'"  size="1" style="width:50px" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" /><span class="input-unit">'.__('px',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Shadow Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Opacity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<select name="'.$field['id'].'[opacity]" id="'.$field['id'].'">
												<option value="0.1">0.1</option>
												<option value="0.2">0.2</option>
												<option value="0.3">0.3</option>
												<option value="0.4">0.4</option>
												<option value="0.5">0.5</option>
												<option value="0.6">0.6</option>
												<option value="0.7">0.7</option>
												<option value="0.8">0.8</option>
												<option value="0.9">0.9</option>
												<option value="1">1</option>
											</select>
									
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<select name="'.$field['id'].'[type]" id="'.$field['id'].'">
												<option value="outline" >Outline</option>
												<option value="inset" >Inset</option>
											</select>
										</div>
									<span class="description">'.$field['desc'].'</span>
									';
								}
								
								
							}
							break;
							
							case "pw_custom_box_background_set":
							{
								if(!is_array($meta))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color-from]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										</div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color-to]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										 </div>';
									
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color-from]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color-from'].'" data-default-color="#'.$meta['color-from'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color-to]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color-to'].'" data-default-color="#'.$meta['color-to'].'">
										  </div>';	
									
								}
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>

								';
							}
							break;
							
							case "pw_custom_box_background_overlay_set":
							{
								if(!is_array($meta))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color-from]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										</div>
									
									<div class="medium-lbl-cnt">
										<label for="'.$field['id'].'" class="full-label">'.__('Opacity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
										<select name="'.$field['id'].'[opacity]" id="'.$field['id'].'">
											<option value="0.1" >0.1</option>
											<option value="0.2" >0.2</option>
											<option value="0.3" >0.3</option>
											<option value="0.4" >0.4</option>
											<option value="0.5" >0.5</option>
											<option value="0.6" >0.6</option>
											<option value="0.7" >0.7</option>
											<option value="0.8" >0.8</option>
											<option value="0.9" >0.9</option>
											<option value="1" >1</option>
										</select>
									</div>
									';
								}
								else{
									$html.= '<div class="medium-lbl-cnt" >
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color-from]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color-from'].'" data-default-color="#'.$meta['color-from'].'">
										</div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.__('Opacity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<select name="'.$field['id'].'[opacity]" id="'.$field['id'].'">
												<option value="0.1" '.selected($meta['opacity'],'0.1',0).'>0.1</option>
												<option value="0.2" '.selected($meta['opacity'],'0.2',0).'>0.2</option>
												<option value="0.3" '.selected($meta['opacity'],'0.3',0).'>0.3</option>
												<option value="0.4" '.selected($meta['opacity'],'0.4',0).'>0.4</option>
												<option value="0.5" '.selected($meta['opacity'],'0.5',0).'>0.5</option>
												<option value="0.6" '.selected($meta['opacity'],'0.6',0).'>0.6</option>
												<option value="0.7" '.selected($meta['opacity'],'0.7',0).'>0.7</option>
												<option value="0.8" '.selected($meta['opacity'],'0.8',0).'>0.8</option>
												<option value="0.9" '.selected($meta['opacity'],'0.9',0).'>0.9</option>
												<option value="1" '.selected($meta['opacity'],'1',0).'>1</option>
											</select>
										</div>';	
									
								}
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>

								';
							}
							break;
							
							case "upload":
							{
								$image='';
								$image = __PW_WOO_AD_SEARCH_URL__.'/assets/images/pw-transparent.gif'; 
								
								if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }
								$html.= '<input name="'.$field['id'].'" id="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.(isset($meta) ? $meta:'').'" /> 
										<img src="'.$image.'" class="custom_preview_image" alt="" />
										<input name="btn_'.$field['id'].'" class="pw_woo_search_upload_image_button button" type="button" value="'.__('Choose Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" />
										<button type="button" class="pw_woo_ad_search_remove_image_button button">'.__('Remove image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</button>';  
							}
							break;
							
							case "pw_custom_4_color":
							{
								if(!is_array($meta))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">
										</div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Background Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">
										  </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										  </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Text Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										 </div>
										';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-color'].'" data-default-color="#'.$meta['bg-color'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Background Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-hcolor'].'" data-default-color="#'.$meta['bg-hcolor'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-color'].'" data-default-color="#'.$meta['text-color'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Text Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-hcolor'].'" data-default-color="#'.$meta['text-hcolor'].'">
										 </div>
									';	
									
								}
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>

								';
							}
							break;
							
							
							case "pw_custom_btn_set":
							{
								if(!is_array($meta))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">
										</div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Background Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#fc5b5b" data-default-color="#fc5b5b">
										  </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										  </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Text Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#ffffff" data-default-color="#ffffff">
										 </div>
										<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<select name="'.$field['id'].'[type]" id="'.$field['id'].'">
												<option value="outline-btn" >'.__('Outline Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
												<option value="back-btn">'.__('Background Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
											</select>
										</div>';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-color'].'" data-default-color="#'.$meta['bg-color'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Background Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[bg-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['bg-hcolor'].'" data-default-color="#'.$meta['bg-hcolor'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-color'].'" data-default-color="#'.$meta['text-color'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Text Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[text-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['text-hcolor'].'" data-default-color="#'.$meta['text-hcolor'].'">
										 </div>
										 <div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label>
											<select name="'.$field['id'].'[type]" id="'.$field['id'].'">
												<option value="outline-btn" '.selected("outline-btn",$meta['type'],0).'>'.__('Outline Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
												<option value="back-btn" '.selected("back-btn",$meta['type'],0).'>'.__('Back Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>
											</select>
										</div>
									';	
									
								}
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>

								';
							}
							break;
							
							case "pw_favorite_color_set":
							{
								if(!is_array($meta))
								{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#333333" data-default-color="#333333">
										 </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#212121" data-default-color="#212121">
										 </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-active-color" class="full-label">'.__('Active Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active-color]" id="'.$field['id'].'-color" type="text" class="wp_ad_picker_color" value="#81af3f" data-default-color="#81af3f">
										  </div>';
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-active-hover" class="full-label">'.__('Active Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active-hcolor]" id="'.$field['id'].'-hover" type="text" class="wp_ad_picker_color" value="#212121" data-default-color="#212121">
										 </div>';
								}
								else{
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-color" class="full-label">'.__('Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['color'].'" data-default-color="#'.$meta['color'].'">
										 </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-hover" class="full-label">'.__('Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['hcolor'].'" data-default-color="#'.$meta['hcolor'].'">
										  </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-active-color" class="full-label">'.__('Active Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active-color]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['active-color'].'" data-default-color="#'.$meta['active-color'].'">
										  </div>';	
									$html.= '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'-active-hover" class="full-label">'.__('Active Hover Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</label><input name="'.$field['id'].'[active-hcolor]" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta['active-hcolor'].'" data-default-color="#'.$meta['active-hcolor'].'">
										  </div>';	
									
								}
								
								$html.= '
								<script type="text/javascript">
									jQuery(document).ready(function($) {   
										//jQuery(".wp_ad_picker_color").wpColorPicker();
									});
								</script>

								';
							}
							break;
														
							case 'preset_frontend':
							{
								$html.= '
								<div class="build_query_loading_back"><div id="build_query_loading" ><i class="fa fa-refresh fa-spin"></i> '.__('Please Wait to Load Data ... !',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div></div>';
								
								$html.= '<div>';
								$html.=include(__PW_ROOT_WOO_AD_SEARCH__ .'/includes/preset-frontend.php');
								$html.= '</div>';
								$output = '
								<script type="text/javascript"> 
									function hexc(colorval) {
										var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
										delete(parts[0]);
										for (var i = 1; i <= 3; ++i) {
											parts[i] = parseInt(parts[i]).toString(16);
											if (parts[i].length == 1) parts[i] = "0" + parts[i];
										}
										color = "#" + parts.join("");
										return color;
									}
									jQuery(document).ready(function(jQuery){
										jQuery(".'.$field['id'].'").find(".link-icon").click(function(e){
											e.preventDefault();
											var $filename=jQuery(this).attr("data-name")+".xml";
											var $source_type="from_xml";
											if(jQuery(this).attr("data-name")=="")
											{
												var $filename=jQuery(this).attr("data-id");
												$source_type="from_database";
											}
											
											jQuery(".build_query_loading_back").show();
											jQuery.post(
												ajaxurl,
												{
													action       : "pw_woo_ad_search_preset_frontend",
													xml_filename : $filename,
													source_type	 : $source_type	
												},
												function(response){
													
													jQuery("input:checkbox[name*=\"item_fields\"]").each(function(i){
														jQuery(this).prop("checked", false);
													});
													
													jQuery.each(response, function (key, data) {
														if(jQuery.isPlainObject(data))
														{
															//confirm("array - "+key);
															jQuery.each(data, function (keys, data) {
																var element_type=jQuery("[name=\""+key+"["+keys+"]\"]").prop("tagName");
																var element_type=typeof element_type !== "undefined" ? element_type.toLowerCase() : "";
																if(element_type=="input")
																{
																	element_type=jQuery("input[name=\""+key+"["+keys+"]\"]").attr("type");
																}
																//confirm(key+"---"+element_type);
	
																switch(element_type)
																{
																	case "text":
																		jQuery("input[name=\""+key+"["+keys+"]\"]").val(data);
																		if(jQuery("input[name=\""+key+"["+keys+"]\"]").hasClass("wp_ad_picker_color")){
																			jQuery("input[name=\""+key+"["+keys+"]\"]").wpColorPicker("color",data);
																			
																		}
																	break;
																	
																	case "number":
																		jQuery("input[name=\""+key+"["+keys+"]\"]").val(data);
																	break;
																	
																	case "select":
																		jQuery("select[name=\""+key+"["+keys+"]\"]").val(data);
																		jQuery("select[name=\""+key+"["+keys+"]\"]").trigger("change");
																	break;
																	
																	case "checkbox":
																		//confirm(keys);
																		
																		jQuery("input[name=\""+key+"["+keys+"]\"]").prop("checked", true);
																		jQuery("input[name=\""+key+"["+keys+"]\"]").trigger("change");
																	break;
																}
																
															});
														}else
														{
															
															var element_type=jQuery("[name=\""+key+"\"]").prop("tagName");
															var element_type=typeof element_type !== "undefined" ? element_type.toLowerCase() : "";
															if(element_type=="input")
															{
																element_type=jQuery("input[name=\""+key+"\"]").attr("type");
															}
															
															//confirm(key+"---"+element_type);

															switch(element_type)
															{
																case "text":
																	jQuery("input[name=\""+key+"\"]").val(data);
																		if(jQuery("input[name=\""+key+"\"]").hasClass("wp_ad_picker_color")){
																			jQuery("input[name=\""+key+"\"]").wpColorPicker("color",data);
																		}
																break;
																
																case "number":
																	jQuery("input[name=\""+key+"\"]").val(data);
																break;
																
																case "select":
																	jQuery("select[name=\""+key+"\"]").val(data);
																	jQuery("select[name=\""+key+"\"]").trigger("change");
																break;
																
																case "checkbox":
																	if(data=="on")
																		jQuery("input[name=\""+key+"\"]").prop("checked", true);
																	else
																		jQuery("input[name=\""+key+"\"]").prop("checked", false);											
																	jQuery("input[name=\""+key+"\"]").trigger("change");	
																break;
															}
														}
													});
													
													jQuery(".build_query_loading_back").slideUp();
												}
											);	
											jQuery(this).parent().siblings( ".active" ).removeClass( "active" );
											jQuery(this).parent().addClass("active");
										});
									});
								</script>';
								$html.= $output;
							}
							break;
							
							
						} //end switch  
				$html.= '</td></tr>';  
			} // end foreach  
			$html.= '</table>'; // end table  
			return $html;
	}
	
	function save_custom_meta_woo_ad_search_grid ($post_id) { 
		//die(print_r($_POST));
		global $ad_search_grid_general_setting,$ad_search_grid_build_query,$ad_search_grid_fields_order_setting,$ad_search_grid_advence_setting,$ad_search_grid_layout_setting;
		// verify nonce
		if(isset($_POST) && !empty($_POST)){
			if (isset($_POST['show_custom_meta_box_woo_ad_search_grid_nonce']) && !wp_verify_nonce($_POST['show_custom_meta_box_woo_ad_search_grid_nonce'], basename(__FILE__)))
				return $post_id;
		// check autosave  
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
				return $post_id;  
			// check permissions  
			if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {  
				if (!current_user_can('edit_page', $post_id))  
					return $post_id;  
				} elseif (!current_user_can('edit_post', $post_id)) {  
					return $post_id;  
			}  
			
			foreach ($ad_search_grid_general_setting as $field) { 
				if(!isset($_POST[$field['id']])){
					delete_post_meta($post_id, $field['id']);  
					continue;
				}
				
				$post = get_post($post_id);
				$category = $_POST[$field['id']];  
				wp_set_post_terms( $post_id, $category, $field['id'],false );

				$old = get_post_meta($post_id, $field['id'], true);  
				$new = $_POST[$field['id']];  
				if ('' == $new && ($old||$old==0)) {  
					delete_post_meta($post_id, $field['id'], $old);  
				}elseif (($new ||$new==0) && $new != $old) {  
					update_post_meta($post_id, $field['id'], $new);  
				} 
	
			} // end foreach  

			foreach ($ad_search_grid_build_query as $field) { 
				if(!isset($_POST[$field['id']])){
					delete_post_meta($post_id, $field['id']);  
					continue;
				}
				
				$post = get_post($post_id);
				$category = $_POST[$field['id']];  
				wp_set_post_terms( $post_id, $category, $field['id'],false );

				$old = get_post_meta($post_id, $field['id'], true);  
				$new = $_POST[$field['id']];  
				if ('' == $new && ($old||$old==0)) {  
					delete_post_meta($post_id, $field['id'], $old);  
				}elseif (($new ||$new==0) && $new != $old) {  
					update_post_meta($post_id, $field['id'], $new);  
				} 
	
			} // end foreach  
			
			foreach ($ad_search_grid_fields_order_setting as $field) { 
				if(!isset($_POST[$field['id']])){
					delete_post_meta($post_id, $field['id']);  
					continue;
				}
				
				$post = get_post($post_id);
				$category = $_POST[$field['id']];  
				wp_set_post_terms( $post_id, $category, $field['id'],false );

				$old = get_post_meta($post_id, $field['id'], true);  
				$new = $_POST[$field['id']];  
				if ('' == $new && ($old||$old==0)) {  
					delete_post_meta($post_id, $field['id'], $old);  
				}elseif (($new ||$new==0) && $new != $old) {  
					update_post_meta($post_id, $field['id'], $new);  
				} 
	
			} // end foreach  
			
			foreach ($ad_search_grid_advence_setting as $field) { 
				if(!isset($_POST[$field['id']])){
					delete_post_meta($post_id, $field['id']);  
					continue;
				}
				
				$post = get_post($post_id);
				$category = $_POST[$field['id']];  
				wp_set_post_terms( $post_id, $category, $field['id'],false );

				$old = get_post_meta($post_id, $field['id'], true);  
				$new = $_POST[$field['id']];  
				if ('' == $new && ($old||$old==0)) {  
					delete_post_meta($post_id, $field['id'], $old);  
				}elseif (($new ||$new==0) && $new != $old) {  
					update_post_meta($post_id, $field['id'], $new);  
				} 
	
			} // end foreach  
			
			
			
			$new_post_id='';
			if(isset($_POST[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset']) && !isset($_POST[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'replace_preset']) && $new_post_id=='')  
			{
				//$defaults = array('post_title'=>'New Preset', 'post_type'=>'ad_woo_search_grid', 'post_content'=>'demo text', 'post_status'=>'publish');	
				//$new_post_id=wp_insert_post( $defaults );	
			}
			
			foreach ($ad_search_grid_layout_setting as $field) { 
				if(!isset($_POST[$field['id']])){
					delete_post_meta($post_id, $field['id']);  
					continue;
				}
				
				//if($new_post_id!=''){
				if(isset($_POST[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset']) && !isset($_POST[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'replace_preset']))
				{	
					/*$new = $_POST[$field['id']];  
					update_post_meta($new_post_id, $field['id'], $new);
					continue;*/
				}
				
					
				
				$post = get_post($post_id);
				$category = $_POST[$field['id']];  
				wp_set_post_terms( $post_id, $category, $field['id'],false );

				$old = get_post_meta($post_id, $field['id'], true);  
				$new = $_POST[$field['id']];  
				if ('' == $new && ($old||$old==0)) {  
					delete_post_meta($post_id, $field['id'], $old);  
				}elseif (($new ||$new==0) && $new != $old) {  
					update_post_meta($post_id, $field['id'], $new);  
				} 
	
			} // end foreach  
		}		
	
		
	} 
	 
	add_action('save_post', 'save_custom_meta_woo_ad_search_grid');  
?>