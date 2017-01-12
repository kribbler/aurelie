<?php

class ProductsController extends AppController {
    public $name = "Products";
    public $helpers = array('Html', 'Form', 'Csv'); 

    public $page_pattern = "";
    public $image_pattern = "";
    public $csv_header = NULL;

    public function index(){
        $elements = $this->Product->find('all'); 
        $this->set('elements', $elements);
        //pr($elements);
    }

    public function edit($id){
		if (!empty($this->request->data)) {
			
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
		} else {
			$this->Product->locale = 'eng';
			$this->data = $this->Product->read(null, $id);
		}
	}
	
	public function add(){
		if (!empty($this->request->data)) {
            $this->Product->create();
            if ($this->Product->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
        }
	}

	public function delete($website_id) {
		$this->Product->delete($website_id);
		$this->Session->setFlash(__('The Product is deleted!'));
		$this->redirect($this->referer());

	}

//<span> Type:</span> Crystal Ear Studs </br><span> Size:</
//<span> Type:</span> Children Ear Studs</br>
	public function scrap(){
		$this->loadModel('Url');
		$urls = $this->Url->find('all');

		$this->page_pattern = "/<div class=\"right\">";
		$this->page_pattern .= "<div class=\"description\"><span>Product Code:<\/span> (.*?)<br \/>";
		$this->page_pattern .= "<span>Stock<\/span> (.*?) <br \/>";
		$this->page_pattern .= "<span>Description:<\/span> (.*?)<\/br>";
		$this->page_pattern .= "<span> Material:<\/span> (.*?)<\/br>";
		$this->page_pattern .= "<span> Finishing:<\/span> (.*?)<\/br>";
		$this->page_pattern .= "<span> Silver weight:<\/span> (.*?) g<\/br>";
		$this->page_pattern .= "<span> Approx. Weight :<\/span> (.*?) g<\/br>";
		$this->page_pattern .= "<span> Type:<\/span>(.*?)<\/br>";
		$this->page_pattern .= "<span> Size:<\/span> (.*?)<\/br><\/div>";
		$this->page_pattern .= "<div class=\"price\">Price: £(.*?) <br \/><\/div>";
		$this->page_pattern .= "/s";

		$this->image_pattern = "/<div class=\"image\"><a href=\"(.*?)\" title=\"(.*?)\" class=\"colorbox\"><img src=\"(.*?)\" title=\"(.*?)\" alt=\"(.*?)\" id=\"image\"  width=\"300\" height=\"300\"\/><\/a>/s";

		foreach ($urls as $url){
			$this->curl($url['Url'], '');
		}
//die('wait!');
		$this->redirect(array('action' => 'index'));
	}

	public function curl($node, $referer){
		if  (in_array  ('curl_multi_info_read', get_loaded_extensions())) {}
		else{}
		
		if(!$referer){
			$referer = $node['content'];
		}

		$ch = curl_init($node['content']);
			curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_REFERER,$node['content']);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch,CURLOPT_TIMEOUT,30);		
		$output = curl_exec($ch);

		preg_match_all(
			$this->page_pattern,
			$output,
			$matches,
			PREG_SET_ORDER
		);
		//pr($node['content']);
		//pr($matches); die();
		
		if ($matches){
			$product = array();
			$product['Product']['url_id'] = $node['id'];
			$product['Product']['product_code'] = $matches[0][1];
			$product['Product']['description'] = $matches[0][3];
			$product['Product']['material'] = $matches[0][4];
			$product['Product']['finishing'] = $matches[0][5];
			$product['Product']['silver_weight'] = $matches[0][6];
			$product['Product']['approx_weight'] = $matches[0][7];
			$product['Product']['type'] = $matches[0][8];
			$product['Product']['size'] = $matches[0][9];
			$product['Product']['price'] = $matches[0][10];

			preg_match_all(
				$this->image_pattern,
				$output,
				$matches_image,
				PREG_SET_ORDER
			);

			if ($matches_image){
				$product['Product']['image'] = $matches_image[0][1];
			}

			$this->save_product($product);
		}

		//pr($product);
	}

	private function save_product($product){
		$this->loadModel('Product');
		$exists = $this->Product->find(
			'first', 
			array('conditions' => array('Product.product_code' => $product['Product']['product_code']))
		);

		if (!$exists){
			//create a new entry
			$this->Product->create();
			$this->Product->save($product);
		} else {
			//update with the new set
			$product['Product']['id'] = $exists['Product']['id'];
			$this->Product->create();
			$this->Product->save($product);
		}
	}

	public function export_to_csv(){
		ini_set("memory_limit","512M");
		set_time_limit(0);

		$products = $this->Product->find('all');

		$export_products = array(); $k=0;
		foreach ($products as $product) {
			$k++;
			$export_products[$k]['Name'] = $product['Product']['description'];
			$export_products[$k]['SKU'] = $product['Product']['product_code'];
			$export_products[$k]['Price'] = $product['Product']['price'];
			$export_products[$k]['ShortDescription'] = $product['Product']['description'];
			$export_products[$k]['Description'] = $product['Product']['description'];
			$export_products[$k]['Image'] = $product['Product']['image'];
			$export_products[$k]['import_url'] = $product['Url']['content'];
			$export_products[$k]['material'] = $product['Product']['material'];
			$export_products[$k]['finishing'] = $product['Product']['finishing'];
			$export_products[$k]['silver_weight'] = $product['Product']['silver_weight'];
			$export_products[$k]['approx_weight'] = $product['Product']['approx_weight'];
			$export_products[$k]['type'] = $product['Product']['type'];
			$export_products[$k]['size'] = $product['Product']['size'];
		}
		//pr($products);die();
		$this->set_csv_header_for_woo_import();

		$headers = array($this->csv_header);
		
		array_unshift($export_products,$headers[0]); 
		$this->layout = null;
		$this->autoLayout = false;
		$this->set('items', $export_products);

	}

	public function set_csv_header_for_woo_import(){
		$headers = 'Name,SKU,Price,Short Description,Description,Image,pa_import-url,pa_material,pa_finishing,pa_silver-weight,approx-weight,pa_type,pa_size';
		$headers = explode(',', $headers);
		foreach ($headers as $key=>$value){
			$this->csv_header[$value] = $value;
		}
	}
}
