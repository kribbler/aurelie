<?php
class WorkerComponent extends Component {
    public $add_link_pattern;
    public $add_pattern_finn_id;
    public $add_pattern_name;
    public $add_pattern_address;
    public $add_pattern_name_broker;
    public $add_pattern_title;
    public $add_pattern_visit;
    public $add_pattern_rent_per_month;
    public $add_pattern_deposit;
    public $add_pattern_date_published;
    public $add_pattern_description;
    public $add_pattern_facilities;
    public $add_pattern_facts;
    public $add_pattern_included;
    public $add_pattern_rented;
    public $add_pattern_apartment_type;
    public $add_pattern_bedrooms;
    public $add_pattern_surface;
    public $add_pattern_rental_period;
    public $add_pattern_pets;
    public $adds;
    public $add_pattern_thumbs;
	
    ////////////////////////////////////////////////////////////////////////////
    public function get_car_models_links($master_url){
        $model_pattern = "/<li>\s+?";
        $model_pattern .= "<a href=\"(.*?)\" rel=\"nofollow\">\s+?";
        $model_pattern .= "(.*?)<span class=\"count neutral\">(.*?)<\/span>\s+?<\/a>\s+?<\/li>\s+?";
        $model_pattern .= "/s";
        
        $ch = curl_init($master_url);
            curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_REFERER,$master_url);
            curl_setopt($ch,CURLOPT_TIMEOUT,30);		
        $output = curl_exec($ch);
        
        preg_match_all(
                $model_pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        unset($matches[0]); //Diesel
        unset($matches[1]); //Bensin
        unset($matches[2]); //Hybrid
        
        //pr($matches);
        
        $models = array(); $k = 0;
        foreach ($matches as $match){
            $models[$k]['name'] = trim($match[2]);
            $models[$k]['link'] = str_replace("browse2", "result", $match[1]);
            $cars = $this->scrap_cars_pagination($models[$k]);
            $models[$k]['cars'] = $cars;
            //pr($models);die();
            //break; //this should be removed
            
            $k++;
        }
        
        return $models;
    }
    
    
    
    public function get_car_images($output){
        
        $pattern = "/";
        //$pattern .= "<div class=\"mtm pls contrast noprint\">\s+?<a href=\"(.*?)\">(.*?)<\/a>\s+?<\/div>";
        $pattern .= "<div class=\"thumbs r-margin\">\s+?";
        $pattern .= "<a href=\"(.*?)\" class=\"thumbwrap\">\s+?";
        $pattern .= "<span class=\"thumbinnerwrap\">\s+?";
        $pattern .= "<img src=\"(.*?)\" alt=\"\"\/>\s+?";
        $pattern .= "<\/span>\s+?";
        $pattern .= "<\/a>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );

        if ($matches){
            $link = $matches[0][1];
            $ch = curl_init($link);
                curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
                curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch,CURLOPT_REFERER,$link);
                curl_setopt($ch,CURLOPT_TIMEOUT,30);		
            $output = curl_exec($ch);
            $output = html_entity_decode($output , ENT_NOQUOTES, "UTF-8");
            
            $pattern2 = "/";
            $pattern2 .= "<div class=\"photoframe pts\">\s+?<img data-src=\"(.*?)\"\/>\s+?<\/div>";
            $pattern2 .= "/s";
            preg_match_all(
                    $pattern2,
                    $output,
                    $matches2,
                    PREG_SET_ORDER
            );
            
            if ($matches2){
                $images = array();
                foreach ($matches2 as $match2){
                    $images[] = $match2[1];
                }
                return $images;
            }
            //pr($matches2);die();
            
        } else {
            return NULL;
        }
    }
    
    public function get_car_submodel($output){
    	$pattern = "/";
    	$pattern .= "<li><span> \/ <\/span> <a href=\"(.*?)\" >(.*?)<\/a><\/li>";
    	$pattern .= "/s";
    	preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        if ($matches){
        	return $matches[count($matches) - 1][2];
        }	
        else return NULL;
    } 
    
    public function get_person_name($output){
    	$pattern = "/";
    	$pattern .= "<div id=\"contact-email\">\s+?<div class=\"mod\">\s+?<div class=\"inner\">\s+?<div class=\"bd\">\s+?<h2>(.*?)<\/h2>";
    	$pattern .= "/s";
    	
    	preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            //try again with company
            $pattern = "/";
            $pattern .= "<div class=\"unit r-size1of3\">\s+?";
            $pattern .= "<h2>(.*?)<\/h2>";
            $pattern .= "/s";
            preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
	        );
	        
	        if ($matches){
	            return trim($matches[0][1]);
	        } else {
	        	$pattern = "/";
	        	$pattern .= "<div class=\"unit r-size1of3\">\s+?";
	        	$pattern .= "<p class=\"contact-info-logo\">(.*?)<\/p>\s+?";
	        	$pattern .= "<h2>(.*?)<\/h2>";
	        	$pattern .= "/s";
	        	preg_match_all(
	                $pattern,
	                $output,
	                $matches,
	                PREG_SET_ORDER
		        );
		        
		        if ($matches){
		            return trim($matches[0][2]);
		        } else {
		        	return NULL;
		        }
	        }
        }
    }
    
    public function get_person_phone($output){
    	$pattern ="/";
    	$pattern .= "<dt class=\"label\">Telefon<\/dt>\s+?";
		$pattern .= "<dd class=\"value\">\s+?(.*?)\s+?<\/dd>";
    	$pattern .= "/s";
    	
    	preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
	        );
	        
        if ($matches){
            return trim($this->adjust_price($matches[0][1]));
        } else {
        	return NULL;
        }
    }
    
	public function get_person_mobil($output){
    	$pattern ="/";
    	$pattern .= "<dt class=\"label\">Mobil<\/dt>\s+?";
		$pattern .= "<dd class=\"value\">\s+?(.*?)\s+?<\/dd>";
    	$pattern .= "/s";
    	
    	preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
	        );
	        
        if ($matches){
            return trim($this->adjust_price($matches[0][1]));
        } else {
        	return NULL;
        }
    }
    
	public function get_person_fax($output){
    	$pattern ="/";
    	$pattern .= "<dt class=\"label\">Fax<\/dt>\s+?";
		$pattern .= "<dd class=\"value\">\s+?(.*?)\s+?<\/dd>";
    	$pattern .= "/s";
    	
    	preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
	        );
	        
        if ($matches){
            return trim($this->adjust_price($matches[0][1]));
        } else {
        	return NULL;
        }
    }
    
    public function get_car_equipment($output){
        $pattern = "/";
        $pattern .= "<p class=\"mvn\">(.*?)<\/p>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            $equipments = array();
            foreach ($matches as $match){
                $equipments[] = $match[1];
            }
            return $equipments;
        } else {
            return NULL;
        }
    }
    
    public function get_car_licence($output){
        $pattern = "/";
        $pattern .= "<dt>Reg. nr.<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_co2_emissions($output){
        $pattern = "/";
        $pattern .= "<dt>Co2-utslipp<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_number_of_owners($output){
        $pattern = "/";
        $pattern .= "<dt>Antall eiere<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_number_of_doors($output){
        $pattern = "/";
        $pattern .= "<dt>Antall dører<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_number_of_seats($output){
        $pattern = "/";
        $pattern .= "<dt>Antall seter<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_interior_color($output){
        $pattern = "/";
        $pattern .= "<dt>Interiørfarge<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_color_description($output){
        $pattern = "/";
        $pattern .= "<dt>Farge beskr<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_color($output){
        $pattern = "/";
        $pattern .= "<dt>Farge<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_weel_drive($output){
        $pattern = "/";
        $pattern .= "<dt>Hjuldrift<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_gearbox($output){
        $pattern = "/";
        $pattern .= "<dt>Girkasse<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_fuel($output){
        $pattern = "/";
        $pattern .= "<dt>Drivstoff<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_effect($output){
        $pattern = "/";
        $pattern .= "<dt>Effekt<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim(str_replace("hk", "", $matches[0][1]));
        } else {
            return NULL;
        }
    }
    
    public function get_car_displacement($output){
        $pattern = "/";
        $pattern .= "<dt>Sylindervolum<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_one_time_registration($output){
        $pattern = "/";
        $pattern .= "<dt>1. gang reg.<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            if ($matches[0][1]){
                return $matches[0][1];
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
    
    public function get_car_fee_category($output){
        $pattern = "/";
        $pattern .= "<dt>Avgiftsklasse<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_variety($output){
        $pattern = "/";
        $pattern .= "<dt>Variant<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_body($output){
        $pattern = "/";
        $pattern .= "<dt>Karosseri<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_year_model($output){
        $pattern = "/";
        $pattern .= "<dt>Årsmodell<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_kilometers($output){
        $pattern = "/";
        $pattern .= "<dt>Kilometer<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return $this->adjust_price(str_replace("km", "", $matches[0][1]));
        } else {
            return NULL;
        }
    }
    
    public function get_car_location($output){
        $pattern = "/";
        $pattern .= "<dt>Kjøretøyet står i<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_sales_from($output){
        $pattern = "/";
        $pattern .= "<dt>Salgsform<\/dt>\s+?<dd>(.*?)<\/dd>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_car_sold_with($output){
        $pattern = "/";
        $pattern .= "<h4 class=\"mbn\">Bilen selges med<\/h4>\s+?<ul class=\"mvn\">\s+?<li class=\"mbn\">(.*?)<\/li>\s+?<\/ul>";
        $pattern .= "/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_anual_fee($output){
        $pattern = "/";
        $pattern .= "<dt>Årsavgift<\/dt>\s+?<dd>\s+?(.*?)\s+?<a class=\"infolink\" href=\"(.*?)\">(.*?)<\/a>/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_price_items_translated($output){
        $pattern = "/";
        $pattern .= "<dt>Pris eks omreg<\/dt>\s+?<dd>kr (.*?),-<\/dd>/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return $this->adjust_price($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_new_registration($output){
        $pattern = "/";
        $pattern .= "<dt>Omregistrering<\/dt>\s+?<dd>\s+?kr (.*?),-\s+?<a class=\"infolink\" href=\"(.*?)\">(.*?)<\/a>/s";
            
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return $this->adjust_price($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function get_car_description($output){
        $pattern = "/";
        $pattern .= "<h2>Beskrivelse<\/h2>\s+?";
        $pattern .= "<div class=\"bd\">\s+?";
        $pattern .= "(.*?)\s+?";
        $pattern .= "<\/div>/s";
        
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            return trim(($matches[0][1]));
        } else {
            return NULL;
        }
    }
    
    public function get_car_address($output){
        $pattern = "/";
        $pattern .= "<figcaption>\s+?";
        $pattern .= "<a  data-fth-event-group=\"Map Link\" data-fth-event=\"Map - Heading\"\s+?";
        $pattern .= "href=\"(.*?)\">(.*?)<\/a>\s+?";
        $pattern .= "<\/figcaption>/s";
        
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );

        if ($matches){
            return $matches[0][2];
        } else {
            return NULL;
        }
    }
    
    public function get_car_price($output){
        $pattern = "/";
        $pattern .= "<span class=\"h2\">kr (.*?),-<\/span>\s+?";
        //$pattern .= "<a class=\"smalltext\" onclick=\"show('priceinfos','block');\">Rapporter pris<\/a>";
        $pattern .= "/s";
        
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        //pr($matches);die();
        if ($matches){
            return $this->adjust_price($matches[0][1]);
        } else {
            return NULL;
        }
    }
    
    public function adjust_price($text){
        preg_match_all('!\d+!', utf8_decode($text), $matches);
        $price = "";
        foreach ($matches[0] as $match){
            $price .= $match;
        }
        return $price;
    }
    
    
    //////////////////////////////////////////////////////////////////////////////////
    public function get_finn_pagination($master_url){
            $this->set_add_link_pattern();
            $this->set_add_pattern_finn_id();
            $this->set_add_pattern_name();
            $this->set_add_pattern_address();
            $this->set_add_pattern_name_broker();
            $this->set_add_pattern_title();
            $this->set_add_pattern_visit();
            $this->set_add_pattern_rent_per_month();
            $this->set_add_pattern_deposit();
            $this->set_add_pattern_date_published();
            $this->set_add_pattern_description();
            $this->set_add_pattern_facilities();
            $this->set_add_pattern_facts();
            $this->set_add_pattern_included();
            $this->set_add_pattern_rented();
            $this->set_add_pattern_apartment_type();
            $this->set_add_pattern_bedrooms();
            $this->set_add_pattern_surface();
            $this->set_add_pattern_rental_period();
            $this->set_add_pattern_pets();

            //man phl pvm media
            $all_urls = array();
            $page_exists = true; $i = 1;
            while ($page_exists){
                    $searched_url = "http://www.finn.no/finn/realestate/lettings/result?sort=1&PROPERTY_TYPE=3&page=$i&areaId=20110";
                    $ch = curl_init($searched_url);
                            curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
                            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
                            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
                            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                            curl_setopt($ch,CURLOPT_REFERER,$searched_url);
                            curl_setopt($ch,CURLOPT_TIMEOUT,30);		
                    $output = curl_exec($ch);

                    preg_match_all(
                            $this->add_link_pattern,
                            $output,
                            $matches,
                            PREG_SET_ORDER
                    );
                    //pr($matches);die();

                    if ($matches){
                            $adds_array = array();
                            //$adds_array['page_url'] = $searched_url;
                            foreach ($matches as $match){
                                    $add = array();
                                    $add['url'] = $match[1];
                                    $add['title'] = $match[2];
                                    $adds_array['adds'][] = $add;
                            }

                            $all_urls[] = $adds_array;
                            $i++;
                    } else {
                            $page_exists = false;
                    }
            }
            return $all_urls;
    }

    //////////////////////////////////////////////////////////////////////////////////
    public function scrape_finn_page($nodes){

            $referer = $nodes[0]['url'];
            $node_count = count($nodes);
            $master = curl_multi_init();
            for($i = 0; $i < $node_count; $i++) {
            //for($i = 0; $i < 1; $i++) {
                    $curl_arr[$i] = curl_init($nodes[$i]['url']);
                    curl_setopt($curl_arr[$i],CURLOPT_FRESH_CONNECT,true);
                    curl_setopt($curl_arr[$i],CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($curl_arr[$i],CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
                    curl_setopt($curl_arr[$i],CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($curl_arr[$i],CURLOPT_REFERER,$referer);
                    curl_setopt($curl_arr[$i],CURLOPT_TIMEOUT,30);
                    curl_multi_add_handle($master, $curl_arr[$i]);
            }
            do {
                    curl_multi_exec($master, $running);
                    $info = curl_multi_info_read($master);
                    if($info['handle']) {
                            $index = array_search($info['handle'], $curl_arr, true);
                            $html = curl_multi_getcontent($info['handle']);
                            $html = html_entity_decode($html, ENT_NOQUOTES, "UTF-8");
                            //$html = mb_convert_encoding($html, "UTF-8", "HTML-ENTITIES");

                            $preg_finn_id			= $this->get_regex($html, $this->add_pattern_finn_id);
                            $preg_name				= $this->get_regex($html, $this->add_pattern_name);
                            if (!$preg_name){
                                    $preg_name			= $this->get_regex($html, $this->add_pattern_name_broker);
                            }
                            $preg_address			= $this->get_regex($html, $this->add_pattern_address, "second");
                            $preg_title				= $this->get_regex($html, $this->add_pattern_title);
                            $preg_visit				= $this->get_regex($html, $this->add_pattern_visit);
                            $preg_price 			= $this->get_regex($html, $this->add_pattern_rent_per_month);
                            $preg_deposit 			= $this->get_regex($html, $this->add_pattern_deposit);
                            $preg_date_published 	= $this->get_regex($html, $this->add_pattern_date_published);
                            $preg_description	 	= $this->get_regex($html, $this->add_pattern_description);
                            $preg_facilities	 	= $this->get_regex($html, $this->add_pattern_facilities);
                            $preg_facts 			= $this->get_regex($html, $this->add_pattern_facts, "both");
                            $preg_included 			= $this->get_regex($html, $this->add_pattern_included);
                            $preg_rented 			= $this->get_regex($html, $this->add_pattern_rented, "rent");
                            $preg_apartment_type 	= $this->get_regex($html, $this->add_pattern_apartment_type);
                            $preg_bedrooms		 	= $this->get_regex($html, $this->add_pattern_bedrooms);
                            $preg_surface		 	= $this->get_regex($html, $this->add_pattern_surface);
                            $preg_rental_period	 	= $this->get_regex($html, $this->add_pattern_rental_period);
                            $preg_pets			 	= $this->get_regex($html, $this->add_pattern_pets);

                            $preg_description = mb_convert_encoding($preg_description, "UTF-8", "HTML-ENTITIES");
                            $preg_title = mb_convert_encoding($preg_title, "UTF-8", "HTML-ENTITIES");
                            $preg_address = mb_convert_encoding($preg_address, "UTF-8", "HTML-ENTITIES");

                            //if ($preg_finn_id == 39810173){
                                    //pr($preg_included);pr($preg_description);pr($preg_address);pr($preg_title);die();
                            //}
                            $add_array = array();
                            $add_array['finn_id']			= $preg_finn_id;
                            $add_array['url']				= "http://www.finn.no/finn/realestate/lettings/object?finnkode=$preg_finn_id";
                            $add_array['name'] 				= $preg_name;
                            $add_array['title'] 			= $preg_title;
                            $add_array['address'] 			= $preg_address;
                            $add_array['visit'] 			= $preg_visit;
                            $add_array['monthly_cost'] 		= $preg_price;
                            $add_array['deposit']			= $preg_deposit;
                            $add_array['date_published']	= trim($preg_date_published);
                            $add_array['description']		= $preg_description;
                            $add_array['facilities']		= $preg_facilities;
                            $add_array['facts']				= $preg_facts;
                            $add_array['included']			= $preg_included;
                            $add_array['rented']			= $preg_rented;
                            $add_array['apartment_type']	= $preg_apartment_type;
                            $add_array['bedrooms']			= $preg_bedrooms;
                            $add_array['surface']			= $preg_surface;
                            $add_array['rental_period']		= $preg_rental_period;
                            $add_array['pets']				= $preg_pets;

                            $this->adds[] = $add_array;
                    }
            } while($running > 0);
            curl_multi_close($master);
            return $this->adds;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_regex($html, $pattern, $get = NULL){
            preg_match_all(
                    $pattern,
                    $html,
                    $matches,
                    PREG_SET_ORDER
            );
            if ($matches){
                    unset($matches[0][0]);
                    if (isset($get)){
                            if ($get == "second") 	return $matches[0][2];
                            if ($get == "both") 	return $matches[0];
                            if ($get == "rent") 	return "rented";
                    } else {
                            return $matches[0][1];
                    }
            } else {
                    return NULL;
            }
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_link_pattern(){
            $this->add_link_pattern = "/";
            /*
            $this->add_link_pattern .= "<h2 data-automation-id=\"heading\" class=\"mtn mln\">\s+?";
            $this->add_link_pattern .= "<a href=\"(.*?)\"\s+?>(.*?)<\/a>\s+?<\/h2>";
            */
            $this->add_link_pattern .= "<h2 data-automation-id=\"heading\" class=\"mtn mln\">\s+?";
            $this->add_link_pattern .= "<a href=\"(.*?)\">(.*?)<\/a>\s+?";
            $this->add_link_pattern .= "<\/h2>";

            $this->add_link_pattern .="/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_address(){
            $this->add_pattern_address = "/";
            $this->add_pattern_address .= "<figcaption>\s+?<a href=\"(.*?)\"\s+?class=\"map-track\">(.*?)<\/a>\s+?<\/figcaption>";
            $this->add_pattern_address .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_finn_id(){
            $this->add_pattern_finn_id = "/";
            $this->add_pattern_finn_id .= "<meta name=\"adId\" content=\"(.*?)\" \/>";
            $this->add_pattern_finn_id .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_name(){
            $this->add_pattern_name = "/";
            $this->add_pattern_name .= "<div class=\"bd\" id=\"brokerContact-0\">\s+?<h2>(.*?)<\/h2>";
            $this->add_pattern_name .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_name_broker(){
            $this->add_pattern_name_broker = "/";
            $this->add_pattern_name_broker .= "<h2 class=\"fn n brokerName\">(.*?)<\/h2>";
            $this->add_pattern_name_broker .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_visit(){
            $this->add_pattern_visit = "/";
            //$this->add_pattern_visit .= "<time datetime=\"(.*?)\"\s+?class=\"unit lastUnit\">\s+?";
            $this->add_pattern_visit .= "<div class=\"capitalize\">\s+?(.*?)\s+?<\/div>";
            $this->add_pattern_visit .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_title(){
            $this->add_pattern_title = "/";
            $this->add_pattern_title .= "<h1 class=\"mal\" data-automation-id=\"heading\">(.*?)<\/h1>";
            $this->add_pattern_title .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_rent_per_month(){
            $this->add_pattern_rent_per_month = "/";
            $this->add_pattern_rent_per_month .= "<dt>Leie pr m�ned<\/dt>\s+?";
    $this->add_pattern_rent_per_month .= "<dd>(.*?),-<\/dd>";
            $this->add_pattern_rent_per_month .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_deposit(){
            $this->add_pattern_deposit = "/";
            $this->add_pattern_deposit .= "<dt>Depositum<\/dt>\s+?";
    $this->add_pattern_deposit .= "<dd>(.*?)<\/dd>";
            $this->add_pattern_deposit .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_date_published(){
            $this->add_pattern_date_published = "/";
            $this->add_pattern_date_published .= "<span class=\"last-changed-date\">(.*?)<\/span>";
            $this->add_pattern_date_published .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_description(){
            $this->add_pattern_description = "/";
            $this->add_pattern_description .= "<div class=\"bd\">\s+?<h2>Beskrivelse<\/h2>\s+?(.*?)\s+?<\/div>";
            $this->add_pattern_description .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_facilities(){
            $this->add_pattern_facilities = "/";
            $this->add_pattern_facilities .= "<h2>Fasiliteter<\/h2>\s+?<div class=\"bd\">(.*?)<\/div>\s+?<\/div>\s+?<\/div>";
            $this->add_pattern_facilities .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_apartment_type(){
            $this->add_pattern_apartment_type = "/";
            $this->add_pattern_apartment_type .= "<dt>Boligtype<\/dt>\s+?<dd>(.*?)<\/dd>";
            $this->add_pattern_apartment_type .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_bedrooms(){
            $this->add_pattern_bedrooms = "/";
            $this->add_pattern_bedrooms .= "<dt>Antall soverom<\/dt>\s+?<dd>(.*?)<\/dd>";
            $this->add_pattern_bedrooms .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_surface(){
            $this->add_pattern_surface = "/";
            $this->add_pattern_surface .= "<dt>Prim�rrom<\/dt>\s+?<dd>(.*?)\s+?<button(.*?)";
            $this->add_pattern_surface .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_rental_period(){
            $this->add_pattern_rental_period = "/";
            $this->add_pattern_rental_period .= "<dt>Leieperiode<\/dt>\s+?<dd>(.*?)<\/dd>";
            $this->add_pattern_rental_period .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_pets(){
            $this->add_pattern_pets = "/";
            $this->add_pattern_pets .= "<dt>Dyrehold tillatt<\/dt>\s+?<dd>(.*?)<\/dd>";
            $this->add_pattern_pets .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_included(){
            $this->add_pattern_included = "/";
            $this->add_pattern_included .= "<div class=\"bd\">\s+?";
            $this->add_pattern_included .= "<h3><strong>Leie inkluderer<\/strong><\/h3>\s+?";
            $this->add_pattern_included .= "(.*?)<\/div>";
            $this->add_pattern_included .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_facts(){
            $this->add_pattern_facts = "/";
            $this->add_pattern_facts .= "<h2>Fakta om boligen<\/h2>\s+?";
    $this->add_pattern_facts .= "<dl class=\"multicol colspan2 fleft mtn\">\s+?";
            $this->add_pattern_facts .= "(.*?)";
            $this->add_pattern_facts .= "<\/dl>\s+?";
            $this->add_pattern_facts .= "<dl class=\"multicol colspan2 fleft mtn\">\s+?";
            $this->add_pattern_facts .= "(.*?)";
            $this->add_pattern_facts .= "<\/dl>";
            $this->add_pattern_facts .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_rented(){
            $this->add_pattern_rented = "/";
            $this->add_pattern_rented .= "<div class=\"bd ribbon rented\">";
            $this->add_pattern_rented .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function set_add_pattern_thumbs(){
            $this->add_pattern_thumbs = "/";
            $this->add_pattern_thumbs .= "data-thumb=\"(.*?)\"\s+?";
            $this->add_pattern_thumbs .= "data-main=\"(.*?)\"";
            $this->add_pattern_thumbs .= "/s";
    }

    //////////////////////////////////////////////////////////////////////////////////
    public function prepare_add($add){
            $new_add = array();
            $new_add['Accommodation']['name'] = $add['name'];
            $new_add['Accommodation']['visit'] = $this->get_add_visit($add['visit']);
            $new_add['Accommodation']['address'] = $add['address'];
            $new_add['Accommodation']['postcode'] = $this->get_postcode($add['address']);
            $new_add['Accommodation']['included'] = $this->get_included($add['included']);
            $new_add['Accommodation']['facilities'] = $this->get_facilities($add['facilities']);
            $new_add['Accommodation']['description'] = trim($add['description']);
            $new_add['Accommodation']['monthly_cost'] = $this->get_monthly_cost($add['monthly_cost']);
            $new_add['Accommodation']['deposit'] = $this->get_deposit($add['deposit']);
            $new_add['Accommodation']['apartment_type'] = $add['apartment_type'];
            $new_add['Accommodation']['bedrooms'] = $add['bedrooms'];
            $new_add['Accommodation']['surface'] = $this->get_surface($add['surface']);
            $new_add['Accommodation']['rental_period'] = $add['rental_period'];
            $new_add['Accommodation']['pets'] = $add['pets'];
            $new_add['Accommodation']['finn_id'] = $add['finn_id'];
            $new_add['Accommodation']['url'] = $add['url'];
            $new_add['Accommodation']['date_published'] = $add['date_published'];
            $new_add['Accommodation']['date_rented'] = $this->get_date_rented($add['date_published'], $add['rented']);

            return $new_add;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_add_visit($string){
            $string = str_replace("  ", "", $string);
            $string = trim(str_replace("\r\n", " ", $string));
            return $string;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_postcode($string){
            preg_match('/(?P<digit1>\d+) Drammen/', $string, $matches);
            if ($matches) return $matches[1];
            else return NULL;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_included($string){
            $string = strip_tags(trim($string));
            return $string;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_facilities($string){
            preg_match_all('/<p class="mvn">(.*?)<\/p>/', $string, $matches);
            if ($matches){
                    $all = NULL; $i = 0;
                    foreach ($matches[1] as $match){
                            if ($i++%2 != 0){
                                    $all .= " - ";
                            }
                            $all .= $match;
                            if ($i%2 == 0){
                                    $all .= "; ";
                            }
                    }
                    return $all;
            }
            else return NULL;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_surface($string){
            $string = trim($string);
            return $string;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_date_rented($date, $rented){
            if ($rented) return date("Y-m-d");
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_monthly_cost($string){
            $pattern = "/(?P<digit1>\d+)/";
            preg_match_all(
                    $pattern,
                    $string,
                    $matches,
                    PREG_SET_ORDER
            );
            $price = NULL;
            foreach ($matches as $match){
                    $price.= $match[1];
            }
            return $price;
    }

    //////////////////////////////////////////////////////////////////////////////////
    private function get_deposit($string){
            if (stripos($string, "m�neder") !== NULL){
                    return $string;
            }
            $pattern = "/(?P<digit1>\d+)/";
            preg_match_all(
                    $pattern,
                    $string,
                    $matches,
                    PREG_SET_ORDER
            );
            $price = NULL;
            foreach ($matches as $match){
                    $price.= $match[1];
            }
            return $price;
    }

    //////////////////////////////////////////////////////////////////////////////////
    public function get_images_url($finn_id){
            $searched_url = "http://www.finn.no/finn/realestate/lettings/object?finnkode=" . $finn_id;
            $this->set_add_pattern_thumbs();

            $ch = curl_init($searched_url);
                    curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
                    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($ch,CURLOPT_REFERER,$searched_url);
                    curl_setopt($ch,CURLOPT_TIMEOUT,30);		
            $output = curl_exec($ch);
            preg_match_all(
                    $this->add_pattern_thumbs,
                    $output,
                    $matches,
                    PREG_SET_ORDER
            );
            $images = array();
            if ($matches){
                    foreach ($matches as $match){
                            $images[] = $match[2];
                    }
            }
            return $images;
    }
	
	
}