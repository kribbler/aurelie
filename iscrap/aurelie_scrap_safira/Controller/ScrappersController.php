<?php
class ScrappersController extends AppController {
	public $name = "Scrappers";
	public $csv_header = NULL;
	public $helpers = array('Html', 'Form', 'Csv'); 
		
    public $urls_to_scrap = array(
        
        //'http://www.safira.se/produkt/armband/',
        //'http://www.safira.se/produkt/halsband/',
        //'http://www.safira.se/produkt/orhangen/',
        //'http://www.safira.se/produkt/hangen/',
        //'http://www.safira.se/produkt/ringar/',


        
        'http://www.safira.se/produkt/armband/' => array(
            'name' => 'Armband',
            'subcategories' => array(
                array(
                    'Silverarmband',
                    'http://www.safira.se/produkt/armband/silver/',
                ),
                array(
                    'Läderarmband',
                    'http://www.safira.se/produkt/armband/lader/',
                ),
                array(
                    'Stålarmband',
                    'http://www.safira.se/produkt/armband/stalarmband/'
                )
            )
        ),
        
        'http://www.safira.se/produkt/halsband/' => array(
            'name' => 'Halsband',
            'subcategories' => array(
                array(
                    'Guldhalsband', 
                    'http://www.safira.se/produkt/halsband/guldhalsband/',
                ),
                array(
                    'Silverhalsband',
                    'http://www.safira.se/produkt/halsband/silverhalsband/',
                ),
                array(
                    'Korshalsband',
                    'http://www.safira.se/produkt/halsband/korshalsband/'
                )
            )
        ),
        
        'http://www.safira.se/produkt/orhangen/' => array(
            'name' => 'Örhängen',
            'subcategories' => array(
                array(
                    'Guld',
                    'http://www.safira.se/produkt/orhangen/guldorhangen/',
                ),
                array(
                    'Silver',
                    'http://www.safira.se/produkt/orhangen/silverorhangen/',
                ),
                array(
                    'Pärlor',
                    'http://www.safira.se/produkt/orhangen/parlor/',
                ),
                array(
                    'Cubic Zirkonia',
                    'http://www.safira.se/produkt/orhangen/cubiczirkonia/',
                ),
                array(
                    'Kristaller',
                    'http://www.safira.se/produkt/orhangen/kristaller/'
                )
            )
        ),
        
        'http://www.safira.se/produkt/hangen/' => array(
            'name' => 'Hängen',
            'subcategories' => array(
                
                array(
                    'Guld',
                    'http://www.safira.se/produkt/hangen/guldhangen/',
                ),
                
                array(
                    'Silver',
                    'http://www.safira.se/produkt/hangen/silverhangen/',
                ),

                array(
                    'Hjärtan',
                    'http://www.safira.se/produkt/hangen/hjartan/',
                ),
                array(
                   'Stjärntecken', 
                    'http://www.safira.se/produkt/hangen/stjarntecken/',
                ),
                array(
                    'Cubic Zirkonia',
                    'http://www.safira.se/produkt/hangen/cubiczirkonia/'
                )
                
            )
        ),
        
        'http://www.safira.se/produkt/ringar/' => array(
            'name' => 'Ringar',
            'subcategories' => array(
                array(
                    'Stålringar',
                    'http://www.safira.se/produkt/ringar/stalringar/',
                ),
                array(
                    'Silverringar',
                    'http://www.safira.se/produkt/ringar/silver/',
                ),
                array(
                    'Guldringar',
                    'http://www.safira.se/produkt/ringar/guldringar/',
                ),
                array(
                    'Förlovningsringar',
                    'http://www.safira.se/produkt/ringar/forlovningsringar/'
                )
            )
        )
        
    );

    public $url_subcategory = NULL;
    public $scraped_category = NULL;
    public $scraped_subcategory = NULL;

	//////////////////////////////////////////////////////////////////////////////////
	public function index(){
		$this->loadModel('Product');
        
	}
	
    //////////////////////////////////////////////////////////////////////////////////
    public function new_mega_scrap() {
        ini_set("memory_limit","1024M");
        set_time_limit(0);

        $this->loadModel('Product');
        //$this->Product->query("TRUNCATE TABLE products");

        foreach ($this->urls_to_scrap as $key=>$value){
            echo "Scrapping category " . $key . "<br />";
            $this->logme("Scrapping category " . $key);
            
            $this->scraped_category = $value['name'];
            //pr($value);die();
            foreach ($value['subcategories'] as $subcategory){
                $this->scraped_subcategory = $subcategory[0];
                $this->url_subcategory = $subcategory[1];
                if (!stristr($this->url_subcategory, "namnhalsband")){
                    echo "Scrapping subcategory " . $subcategory[1] . "<br />";
                    $this->logme("Scrapping subcategory " . $subcategory[1]);
                    $this->curl_subcategory($subcategory[1]);
                } else {
                    echo "Skipping subcategory " . $subcategory[1] . "<br />";
                }
                $this->logme("DONE scrapping " . $subcategory[1]);
            }
        }
        $this->logme("DONE scrapping " . $key);
        die( 'DONE!' ); 
    }

	//////////////////////////////////////////////////////////////////////////////////
	public function mega_scrap() {
        ini_set("memory_limit","1024M");
        set_time_limit(0);

        $this->loadModel('Product');
        //$this->Product->query("TRUNCATE TABLE products");

        $subcat_pattern = '/';
        $subcat_pattern .= '<div class=\"leftnavsubgroup\" id=\"(.*?)\">\s*?';
        $subcat_pattern .= '<a href=\"(.*?)\" class=\"leftnavcontent\" id=\"(.*?)\">(.*?)<\/a>\s*?';
        $subcat_pattern .= '<\/div>';
        $subcat_pattern .= '/s';
        foreach ($this->urls_to_scrap as $master_url){
            echo "Scrapping category " . $master_url . "<br />";
            $this->logme("Scrapping category " . $master_url);
            $ch = curl_init($master_url);
                curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
                curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch,CURLOPT_REFERER,$master_url);
                curl_setopt($ch,CURLOPT_TIMEOUT,30);        
            $output = curl_exec($ch);
            $output = html_entity_decode($output, ENT_NOQUOTES, "UTF-8");

            preg_match_all(
                    $subcat_pattern,
                    $output,
                    $matches,
                    PREG_SET_ORDER
            );

            if ($matches){
                $this->scraped_category = $this->get_category_name($output, $master_url);
                foreach ($matches as $match){
                    $this->scraped_subcategory = $match[4];
                    $this->url_subcategory = "http://www.safira.se" . $match[2];
                    if (!stristr($match[2], "namnhalsband")){
                        echo "Scrapping subcategory " . $match[2] . "<br />";
                        $this->logme("Scrapping subcategory " . $match[2]);
                        $this->curl_subcategory("http://www.safira.se" . $match[2]);
                    } else {
                        echo "Skipping subcategory " . $match[2] . "<br />";
                    }
                }
            } 
        }
        die( 'DONE!' ); 
	}

    private function get_category_name($output, $master_url){
        $catname_pattern = "/";
        $catname_pattern .= "<span style=\"font-size: medium; color: #888888;\">\s*?";
        $catname_pattern .= "<strong>(.*?)<\/strong>\s*?";
        $catname_pattern .= "<\/span>";
        $catname_pattern .= "/s";
        preg_match_all(
            $catname_pattern,
            $output,
            $matches_catname,
            PREG_SET_ORDER
        );
        if ($matches_catname[0][1]) {
            return $matches_catname[0][1];
        } 

        $catname_pattern = "/";
        $catname_pattern .= "<span style=\"color: #888888; font-size: medium;\">\s*?";
        $catname_pattern .= "<strong>(.*?)<\/strong>\s*?";
        $catname_pattern .= "<\/span>";
        $catname_pattern .= "/s";
        preg_match_all(
            $catname_pattern,
            $output,
            $matches_catname,
            PREG_SET_ORDER
        );

        if ($matches_catname[0][1]) {
            return $matches_catname[0][1];
        }

        return $master_url;
    }

    private function curl_subcategory($url){
        //pr($this->url_subcategory);die();
        //pr($url);die();
        $small_product_pattern = "/";
        $small_product_pattern .= "<div class=\"gridCellInner\" style=\"(.*?)\">\s*?";
        $small_product_pattern .= "<!-- CELL CONTENT START -->\s*?";
        $small_product_pattern .= "<div class=\"gridArticleImageContainer\" style=\"(.*?)\">\s*?";
        $small_product_pattern .= "<a href=\"(.*?)\">\s*?";
        $small_product_pattern .= "/s";

        $ch = curl_init($url);
            curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_REFERER,$url);
            curl_setopt($ch,CURLOPT_TIMEOUT,30);        
        $output = curl_exec($ch);
        $output = html_entity_decode($output, ENT_NOQUOTES, "UTF-8");

        preg_match_all(
                $small_product_pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );

        //pr($matches); die();
        foreach ($matches as $match){
            //now curl the product page!
            if ($this->ok_cat($match[3]) && $this->not_exist("http://www.safira.se" . $match[3])){
                $this->logme("Reading page " . "http://www.safira.se" . $match[3]);
                $this->curl_product_page("http://www.safira.se" . $match[3]);
            }
        }

        //now try to find the next page
        $page_next_pattern = "/";
        $page_next_pattern .= "<a href=\"javascript:browseTo(.*?)\" class=\"pagearrow next\">Nästa<\/a>";
        $page_next_pattern .= "/s";

        preg_match_all(
                $page_next_pattern,
                $output,
                $matches_page,
                PREG_SET_ORDER
        );

        if ($matches_page){
            $this->url_subcategory = $this->get_nextpage_url($this->url_subcategory, $matches_page[0][1]);
            $this->curl_subcategory($this->url_subcategory);  
        }
        
    }

    private function not_exist($url){
        $this->loadModel('Product');
        $exist = $this->Product->find('first', array('conditions' => array('Product.url' => $url)));
        if (!$exist) return true;
        else return false;
    }
    
    private function curl_product_page($url){
        $product_page_pattern = "/";
        $product_page_pattern .= "<H1 class=\"articleName\">(.*?)<\/H1>\s*?";
        $product_page_pattern .= "<div class=\"articleImageWrapper\">(.*?)<\/div>\s*?";
        $product_page_pattern .= "<div class=\"articleInfo\">\s*?";
        $product_page_pattern .= "<div id=\"articleNr\" class=\"articleNr\">Artikelnummer: (.*?)<\/div>\s*?";
        $product_page_pattern .= "<div id=\"articleText\">\s*?<b>(.*?)<\/b>\s*?";
        $product_page_pattern .= "(.*?)";
        $product_page_pattern .= "<\/div>";
        $product_page_pattern .= "<div class=\"buyinfo\">\s*?";
        $product_page_pattern .= "(.*?)";
        $product_page_pattern .= "<\/div>";
        $product_page_pattern .= "/s";

        $product_image_pattern = "/";
        $product_image_pattern .= "<div class=\"imageCaption\">\s*?";
        $product_image_pattern .= "<a class=\"enlarge\" href=\"(.*?)\">\s*?";
        $product_image_pattern .= "Klicka för större bild(\s*?)<\/a>\s*?";
        $product_image_pattern .= "<\/div>";
        $product_image_pattern .= "/s";

        $product = array();
        $product['Product']['url'] = $url;

        $ch = curl_init($url);
            curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_REFERER,$url);
            curl_setopt($ch,CURLOPT_TIMEOUT,30);        
        $output = curl_exec($ch);
        //now get product image::
        preg_match_all(
                $product_image_pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            $product['Product']['image_url'] = "http://www.safira.se" . $matches[0][1];
        } else {
            $product_image_pattern = "/";
            $product_image_pattern .= "<a href=\"(.*?)\" rel=\"article-image\">\s*?";
            $product_image_pattern .= "<img src=\"(.*?)\" (.*?)>\s*?";
            $product_image_pattern .= "<\/a>";
            $product_image_pattern .= "/s";
            preg_match_all(
                $product_image_pattern,
                $output,
                $matches,
                PREG_SET_ORDER
            );
            if ($matches){
                $product['Product']['image_url'] = "http://www.safira.se" . $matches[0][2];
            } else {
                //die('no imageeeee');
            }
        }

        //now get product fields::
        preg_match_all(
                $product_page_pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        
        if ($matches){
            unset($matches[0][0]);
            unset($matches[0][2]);
            $product['Product']['category'] = $this->scraped_category;
            $product['Product']['subcategory'] = $this->scraped_subcategory;
            $product['Product']['title'] = $matches[0][1];
            $product['Product']['original_sku'] = $this->to_slug($product['Product']['title']) . '--' . $matches[0][3];
            $product['Product']['description'] = $matches[0][4];
            $product['Product']['is_variation'] = 0;
            $product = $this->get_product_dimensions($product, $matches[0][5]);
            $product['Product']['price'] = $this->get_product_price($output);
            $product['Product']['in_stock'] = $this->get_product_in_stock($output);
        }

        $is_variable = false;
        $is_variable = $this->insert_product_variations($product, $output);
        if (!$is_variable)
            $this->insert_product($product);
    }

    private function get_product_in_stock($output){
        $in_stock = 0;
        if (stristr($output, "Finns i lager")){
            $in_stock = 1;
        }
        return $in_stock;
    }

    private function to_slug($string){
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
    private function get_product_price($output){
        $pattern = "/";
        $pattern .= "<td id=\"price\" class=\"articlePrice\">(.*?):-<\/td>\s*?";
        $pattern .= "/s";
        preg_match_all(
                $pattern,
                $output,
                $matches,
                PREG_SET_ORDER
        );
        if ($matches){
            $price = explode(":", $matches[0][1]);
            return strip_tags(str_replace(" ", "", $price[0]));
        } else {
            $pattern = "/";
            $pattern .= "<td class=\"articlePrice\" id=\"price\">(.*?):-<\/td>\s*?";
            $pattern .= "/s";
            preg_match_all(
                    $pattern,
                    $output,
                    $matches,
                    PREG_SET_ORDER
            );
            return str_replace(" ", "", $matches[0][1]);
        }
    }
    private function insert_product_variations($product, $output){
        $has_variations = false;
        //check if length options are present
        $pattern1 = "/";
        $pattern1 .= "<div id=\"articleAttributes\" class=\"ver_titles\">\s*?";
        $pattern1 .= "Längd\s*?";
        $pattern1 .= "<br>";
        $pattern1 .= "<select name=\"(.*?)\" onchange=\"(.*?)\">\s*?";
        $pattern1 .= "(.*?)";
        $pattern1 .= "<\/select>";
        $pattern1 .= "/s";

        preg_match_all(
            $pattern1,
            $output,
            $matches1,
            PREG_SET_ORDER
        );

        if ($matches1){
            $this->process_variations($product, $matches1[0][3], "length");
            $has_variations = true;
        }

        //check if  Längd Armband options are present::
        $pattern1 = "/";
        $pattern1 .= "<div id=\"articleAttributes\" class=\"ver_titles\">\s*?";
        $pattern1 .= "Längd Armband\s*?";
        $pattern1 .= "<br>";
        $pattern1 .= "<select name=\"(.*?)\" onchange=\"(.*?)\">\s*?";
        $pattern1 .= "(.*?)";
        $pattern1 .= "<\/select>";
        $pattern1 .= "/s";

        preg_match_all(
            $pattern1,
            $output,
            $matches1,
            PREG_SET_ORDER
        );

        if ($matches1){
            $this->process_variations($product, $matches1[0][3], "length");
            $has_variations = true;
        }    

        //check if storlek (size) options are present::
        $pattern1 = "/";
        $pattern1 .= "<div id=\"articleAttributes\" class=\"ver_titles\">\s*?";
        $pattern1 .= "Storlek\s*?";
        $pattern1 .= "<br>";
        $pattern1 .= "<select name=\"(.*?)\" onchange=\"(.*?)\">\s*?";
        $pattern1 .= "(.*?)";
        $pattern1 .= "<\/select>";
        $pattern1 .= "/s";

        preg_match_all(
            $pattern1,
            $output,
            $matches1,
            PREG_SET_ORDER
        );

        if ($matches1){
            $this->process_variations($product, $matches1[0][3], "size");
            $has_variations = true;
        }     

        //check if storlek (size) options are present::
        $pattern1 = "/";
        $pattern1 .= "<div id=\"articleAttributes\" class=\"ver_titles\">\s*?";
        $pattern1 .= "Storlek\s*?";
        $pattern1 .= "<br>";
        $pattern1 .= "<select name=\"(.*?)\">\s*?";
        $pattern1 .= "(.*?)";
        $pattern1 .= "<\/select>";
        $pattern1 .= "/s";

        preg_match_all(
            $pattern1,
            $output,
            $matches1,
            PREG_SET_ORDER
        );

        if ($matches1){
            $this->process_variations($product, $matches1[0][2], "size");
            $has_variations = true;
        }   
        return $has_variations;
    }

    private function process_variations($product, $matches1, $pa_){
        echo '<meta charset="UTF-8" />';
        $options_array = array();
        $options = explode("\n", $matches1);
        foreach ($options as $key=>$value){
            if ($key > 0 && $value != "")
                $options_array[] = strip_tags($value);
        }
        $original_sku = $product['Product']['original_sku'];
        foreach ($options_array as $key=>$value){
            $product['Product'][$pa_] = $value;
            if ($key > 0){
                $product['Product']['parent_sku'] = $original_sku;
                $product['Product']['original_sku'] = "";   
                $product['Product']['is_variation'] = 1;
            }
        
            $this->insert_product($product);
        }
    }

    private function insert_product($product){
        $this->loadModel('Product');

        @$exist = $this->Product->find('first', 
            array('conditions' => array(
                'Product.url' => $product['Product']['url'],
                'Product.original_sku' => $product['Product']['original_sku'],
                'Product.parent_sku' => $product['Product']['parent_sku'],
                //'Product.title' => $product['Product']['title'],
                'Product.size' => $product['Product']['size'],
                'Product.width' => $product['Product']['width'],
                'Product.height' => $product['Product']['height'],
                'Product.weight' => $product['Product']['weight'],
                'Product.stone' => $product['Product']['stone'],
                'Product.length' => $product['Product']['length'],
                'Product.length_washer' => $product['Product']['length_washer'],
                'Product.thickness' => $product['Product']['thickness'],
                'Product.stone_diameter' => $product['Product']['stone_diameter'],
            ))
        );
        
        if (!$exist){
            $this->logme('Adding ' . $product['Product']['url']); 
            $this->Product->create();
            $this->Product->save($product);
        } 
    }

    public function logme($str){
        $myFile = "scraplog.txt";
        $fh = fopen($myFile, 'a') or die("can't open file");
        fwrite($fh, $str . "\n");
        fclose($fh);
    }

    private function get_product_dimensions($product, $str){
        //get material
        $pattern = "/Material: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['material'] = str_ireplace("Material: ", "", $matches[0][0]);
            $product['Product']['material'] = str_ireplace("<br", "", $product['Product']['material']);
        }

        //get length
        $pattern = "/Standardlängd: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['length'] = str_ireplace("Standardlängd: ", "", $matches[0][0]);
            $product['Product']['length'] = str_ireplace(" (valbar)", "", $product['Product']['length']);
            $product['Product']['length'] = str_ireplace("<br", "", $product['Product']['length']);
        }   

        //get width
        $pattern = "/Bredd: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['width'] = str_ireplace("Bredd: ", "", $matches[0][0]);
            $product['Product']['width'] = str_ireplace(" (valbar)", "", $product['Product']['width']);
            $product['Product']['width'] = str_ireplace("<br", "", $product['Product']['width']);
        }             

        //get length_washer
        $pattern = "/Längd Bricka: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['length_washer'] = str_ireplace("Längd Bricka: ", "", $matches[0][0]);
            $product['Product']['length_washer'] = str_ireplace(" (valbar)", "", $product['Product']['length_washer']);
            $product['Product']['length_washer'] = str_ireplace("<br", "", $product['Product']['length_washer']);
        }

        //get thickness
        $pattern = "/Tjocklek: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['thickness'] = str_ireplace("Tjocklek: ", "", $matches[0][0]);
            $product['Product']['thickness'] = str_ireplace(" (valbar)", "", $product['Product']['thickness']);
            $product['Product']['thickness'] = str_ireplace("<br", "", $product['Product']['thickness']);
        }     

        //get height
        $pattern = "/Höjd: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['height'] = str_ireplace("Höjd: ", "", $matches[0][0]);
            $product['Product']['height'] = str_ireplace(" (valbar)", "", $product['Product']['height']);
            $product['Product']['height'] = str_ireplace("<br", "", $product['Product']['height']);
        }     

        //get stone
        $pattern = "/Stenar: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['stone'] = str_ireplace("Stenar: ", "", $matches[0][0]);
            $product['Product']['stone'] = str_ireplace(" (valbar)", "", $product['Product']['stone']);
            $product['Product']['stone'] = str_ireplace("<br", "", $product['Product']['stone']);
        }  

        //get stone
        $pattern = "/Sten\/Stenar: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['stone'] = str_ireplace("Sten/Stenar: ", "", $matches[0][0]);
            $product['Product']['stone'] = str_ireplace(" (valbar)", "", $product['Product']['stone']);
            $product['Product']['stone'] = str_ireplace("<br", "", $product['Product']['stone']);
        } 

        //get stone diameter
        $pattern = "/Diameter sten: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['stone_diameter'] = str_ireplace("Diameter sten: ", "", $matches[0][0]);
            $product['Product']['stone_diameter'] = str_ireplace(" (valbar)", "", $product['Product']['stone_diameter']);
            $product['Product']['stone_diameter'] = str_ireplace("<br", "", $product['Product']['stone_diameter']);
        }

        //get Mått kedja - Measurement chain
        $pattern = "/Mått kedja: (.*?)<br/s";
        preg_match_all(
                $pattern,
                $str,
                $matches,
                PREG_SET_ORDER
        );
        if($matches){
            $product['Product']['length'] = str_ireplace("Mått kedja: ", "", $matches[0][0]);
            $product['Product']['length'] = str_ireplace(" (valbar)", "", $product['Product']['length']);
            $product['Product']['length'] = str_ireplace("<br", "", $product['Product']['length']);
        }

        return $product;
    }


    private function ok_cat($str){
        if (stristr($str, "/gravyrsmycken/") ||
            stristr($str, "/namnsmycken/") ||
            stristr($str, "/namnhalsband/") ||
            stristr($str, "/piercingsmycken/") ||
            stristr($str, "/pilgrim/")
            ) 
        {
            return false;
        }

        return true;
    }

    private function get_nextpage_url($url, $str){
        $str = explode(";", $str);
        $str = $str[0];
        $str = str_ireplace("(", "", $str);
        $str = str_ireplace(")", "", $str);
        $str = explode(",", $str);
        return $url . "?sort=&offset[".$str[1]."]=" . $str[0];
    }
	
    public function scrap_images(){
        set_time_limit(0);
        $this->loadModel('Product');
        $products = $this->Product->find('all', array('conditions' => array('scraped_image' => NULL)));

        $folder_name = "images/";
        foreach ($products as $key => $value) {
            if (!$value['Product']['scraped_image']){
                $name = basename($value['Product']['image_url']);
                $ch = curl_init($value['Product']['image_url']);
                $fp = fopen($folder_name . $name, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                pr($fp);

                //die();
                if ($fp){
                    $value['Product']['scraped_image'] = $name;
                    $this->Product->save($value);
                }
                else {
                    pr($value); die('wrong');
                }

                fclose($fp);
                //die();
            }
        }
        echo 'done!!!';
    }
	//////////////////////////////////////////////////////////////////////////////////

	public function export_brute_csv(){
        //echo '<meta charset="UTF-8" />';
		$this->set_csv_header_for_product_master();
		$headers = array($this->csv_header);
		Configure::write('debug', 2);
		$this->loadModel('Product');
		
		$raw_items = $this->Product->find('all', array('limit' => 1));
        pr($raw_items[0]); //die();
		$items = array();
		
		foreach ($raw_items as $key=>$value){
            $ik = $key;
            $items[$ik]['post_title'] = html_entity_decode($value['Product']['title']);
            $items[$ik]['post_name'] = html_entity_decode($value['Product']['title']);
            $items[$ik]['post_content'] = html_entity_decode($value['Product']['description']);
            $items[$ik]['post_status'] = 'publish';
            $items[$ik]['post_parent'] = '0';
            $items[$ik]['post_author'] = "1";
            $items[$ik]['sku'] = $value['Product']['original_sku'];
            $items[$ik]['visibility'] = 'visible';
            $items[$ik]['stock'] = "";
            $items[$ik]['stock_status'] = $this->get_stock_status($value['Product']['in_stock']);
            $items[$ik]['manage_stock'] = "no";
            $items[$ik]['regular_price'] = $value['Product']['price'];
            $items[$ik]['sale_price'] = "";
            $items[$ik]['images'] = $value['Product']['image_url'];//this needs attention
            $items[$ik]['tax:product_type'] = $this->get_product_type($value['Product']['original_sku']);
            $items[$ik]['tax:product_cat'] = $this->get_product_cat($value['Product']['category'], $value['Product']['subcategory']); //this needs attention
            $items[$ik]['tax:product_tag'] = ""; //this needs attention
            $items[$ik]['attribute:pa_length'] = $this->get_product_variable_values($value['Product'], 'length', $items[$ik]['tax:product_type']); //this needs attention
            $items[$ik]['attribute_data:pa_length'] = $this->set_attribute_data($items[$ik]['tax:product_type']);
            $items[$ik]['attribute_default:pa_length'] = $value['Product']['length'];

		}
		array_unshift($items,$headers[0]); 

        pr($items);die();
		$this->layout = null;
		$this->autoLayout = false;
		$this->set('items', $items);
	}
	
	public function set_csv_header_for_product_master(){
            $headers = 'Name,SKU,Price,Short Description,Description,year,kilometer,antalseter,finn-url,effekt,pa_kontaktperson,pa_telefon,pa_mobil,pa_fax,Categories,Image,pa_merke,pa_modell,pa_adresse,pa_omregistrering,pa_pris-eks-omreg,pa_arsavgift,pa_bilen-selges-med,pa_salgsform,pa_kjoretoyet-star-i,pa_kilometer,pa_arsmodell,pa_karosseri,pa_variant,pa_avgiftsklasse,pa_1-gang-reg,pa_sylindervolum,pa_effekt,pa_drivstoff,pa_girkasse,pa_hjuldrift,pa_farge,pa_farge-beskr,pa_interiorfarge,pa_antall-seter,pa_antall-dorer,pa_antall-eiere,pa_co2-utslipp,pa_reg-nr,pa_utstyr,pa_gir-betegnelse,pa_hjuldrift-beskrivelse';
            $headers = 'post_title,post_name,post_content,post_status,post_parent,post_author,sku,visibility,stock,stock_status,manage_stock,regular_price,sale_price,images,tax:product_type,tax:product_cat,tax:product_tag,attribute:pa_length,attribute_data:pa_length,attribute_default:pa_length';
            $headers = explode(',', $headers);
            foreach ($headers as $key=>$value){
                    $this->csv_header[$value] = $value;
            }
	}

    public function export_variations_csv(){
        //echo '<meta charset="UTF-8" />';
        $this->set_csv_header_for_product_variations();
        $headers = array($this->csv_header);
        Configure::write('debug', 0);
        $this->loadModel('Product');
        
        $raw_items = $this->Product->find(
            'all', 
            array(
                'limit' => 10,
                'conditions' => array('original_sku' => ""),
                'order' => array('id' => 'ASC')
            )
        );
        //pr($raw_items); //die();
        $items = array();
        
        $ik = 0;
        $set_first_variable = false;
        $current_sku = "";
        foreach ($raw_items as $key=>$value){
            
            $parent_product = $this->get_parent_product_from_sku($value['Product']['parent_sku']);
            if ($current_sku != $parent_product['Product']['original_sku']){
                $set_first_variable = false;
            }
            if (!$set_first_variable){
                $items[$ik]['Parent'] = html_entity_decode($parent_product['Product']['title']);
                $items[$ik]['parent_sku'] = $value['Product']['parent_sku'];
                $items[$ik]['post_status'] = 'publish';
                $items[$ik]['sku'] = "";
                $items[$ik]['regular_price'] = $value['Product']['price'];
                $items[$ik]['sale_price'] = "";
                $items[$ik]['meta:attribute_pa_length'] = $parent_product['Product']['length'];
                //pr($items[$ik]);
                $ik++;
                $set_first_variable = true;
                $current_sku = $parent_product['Product']['original_sku'];
                //pr($current_sku);
            }

            $items[$ik]['Parent'] = html_entity_decode($parent_product['Product']['title']);
            $items[$ik]['parent_sku'] = $value['Product']['parent_sku'];
            $items[$ik]['post_status'] = 'publish';
            $items[$ik]['sku'] = "";
            $items[$ik]['regular_price'] = $value['Product']['price'];
            $items[$ik]['sale_price'] = "";
            $items[$ik]['meta:attribute_pa_length'] = $value['Product']['length'];
            $current_sku = $parent_product['Product']['original_sku'];
            
            //pr($items[$ik]);

            $ik++;
        }
        array_unshift($items,$headers[0]); 

        //pr($items);
        //die();
        $this->layout = null;
        $this->autoLayout = false;
        $this->set('items', $items);
        $this->render('export_variations_csv');
    }

    public function set_csv_header_for_product_variations(){
        $headers = 'Parent,parent_sku,post_status,sku,regular_price,sale_price,meta:attribute_pa_length';
        $headers = explode(',', $headers);
        foreach ($headers as $key=>$value){
                $this->csv_header[$value] = $value;
        }
    }

    private function get_parent_product_from_sku($sku){
        $this->loadModel('Product');
        $parent = $this->Product->find('first', array('conditions' => array('Product.original_sku' => $sku)));
        return $parent;
    }

    private function set_attribute_data($product_type){
        if ($product_type == 'variable'){
            return "0|1|1";
        } else if ($product_type == 'simple'){
            return "0|0|0";
        }
    }

    private function get_product_variable_values($product, $value, $type){
        $this->loadModel('Product');
        $values = $product[$value];
        if ($type == 'variable'){
            $var = $this->Product->find('all', array(
                'conditions' => array('Product.parent_sku' => $product['original_sku'])
            ));
            foreach ($var as $variable){
                $values .= "|" . $variable['Product'][$value];
            }
        }
        return $values;
    }

    private function get_product_cat($category, $subcategory){
        switch ($category){
            case "ARMBAND":
                $category = 'Armbånd';
                break;
        }
        switch ($subcategory){
            case "Silverarmband":
                $subcategory = "Sølvarmbånd";
                break;
        }
        $str = $category;
        $str .= "|";
        $str .= $category . ' > ' . $subcategory;
        return $str;
    }

    private function get_product_type($sku){
        $this->loadModel('Product');
        $var = $this->Product->find('first', array(
            'conditions' => array('Product.parent_sku' => $sku)
        ));
        if ($var){
            return "variable";
        } else {
            return "simple";
        }
    }

    private function get_stock_status($in_stock){
        if ($in_stock){
            return "instock";
        } else {
            return "outofstock";
        }
    }
        
    public function get_car_images_for_Woo($images){
        $string = "";
        $k = 0;
        foreach ($images as $image){
            if ($image['processed']){
                //$string .= "http://let.hagenmedia.no/wp-content/uploads/importer/" . $image['car_id'] . '___' . basename($image['url']);
                $string .= "http://localhost/cakephp2.1.3/finn_cars/webroot/images/" . $image['car_id'] . '___' . basename($image['url']);
                if ($k++ != count($images) - 1){
                    $string .= "|";
                }
            }
        }
        return $string;
    }
}