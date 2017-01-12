<?php

/*
* Wrapper for Logistra Cargonizer API
* w\ general array to xml converter
* + xml writer class
*
* Copyright (C) 2011 by ServiceLogistikk AS
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
*/

/**
* @param string api_key
* @param int sender_id
* @param string url [optional]
*/
class cargonizer {
private $consignment_url = "http://cargonizer.no/consignments.xml";
private $transport_agreement_url = "http://cargonizer.no/transport_agreements.xml";
private $api_key;
private $sender_id;
private $curl;
private $data_xml = "<xml></xml>";
private $data = array();
private $pkg_number;
public $urls = array();
private $cost_estimate = 0;
private $error = array();
private $error_flag = 0;
private $sxml;

/**
 * error parameters
 */
private $http_code;
private $error_500 = FALSE;
private $consignment_errors_found = FALSE;
private $error_found = array();


public function __construct($api_key,$sender_id,$url = "") {
if($url != '') $this->consignment_url = $url;
$this->api_key = $api_key;
$this->sender_id = $sender_id;

$this->curl = curl_init();
curl_setopt($this->curl, CURLOPT_URL, $this->consignment_url);
curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
curl_setopt($this->curl, CURLOPT_HEADER, 0);
curl_setopt($this->curl, CURLOPT_POST, 1);
curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
}

public function __destruct() {
curl_close($this->curl);
}

public function getPkgNumber() {
return $this->pkg_number;
}


/**
*
* Returns an array with the consignment document urls
* @return array
*/
public function getUrls() {
return $this->urls;
}

public function getErrorFlag() {
return $this->error_flag;
}

public function getErrors() {
return $this->errors;
}

public function getCostEstimate() {
return $this->cost_estimate;
}

public function check_xml_response(){
	$error = FALSE;
	$read_error = (array)$this->sxml->error;
	$read_error = $read_error[0];

	if (isset($this->sxml->body->div->h2[0]) && $this->sxml->body->div->h2[0] == 'Error'){
		$error = TRUE;
	}
	else if (isset($this->sxml->error) && $this->sxml->error == 'Package exceed maximum measurements for product SERVICEPAKKE '){
		$error = TRUE;
	}
	else if (isset($this->sxml->error)){
		$error = TRUE;
	}
	else if (isset($this->sxml->consignment->errors)){
		$error = TRUE;
		$read_error = (array)$this->sxml->consignment->errors;
		$read_error = $read_error['error'][0];
		if (stristr($read_error, "bundle_width_too_long") || 
			stristr($read_error, "Weight Sendinger med dette produktet kan ikke veie mer enn 2 Kg")
		){
			$error = "This product is too large to be sent using this shipping method";	
		}
	}
	
	if (stristr($read_error, "ArgumentError: File does not exist")){
		$error = "Tollpost have technical problems which have affected us. Please try again in a few moments.";
	}
	
	if (stristr($read_error, "Product PA_DOREN can not be sent between the given postal codes")){
		$error = "Product can not be sent between the given postal codes.";
	}
	//var_dump(stristr($read_error, "ArgumentError: File does not exist")); //die();
	//var_dump($error);
	return $error;
}

/**
*
* returns the resulting xml response from cargonizer consignment call
* @return simplexml_object
*/
public function getResultXml() {
	//echo 'her'; var_dump($this->sxml);
	return (string)$this->sxml;
}

public function getEstimatedCostFromXml(){
	return (string)$this->sxml->{'estimated-cost'};
}

/**
*
* Creates a consignment
* @param array $data
* @param int $debug [0|1] [optional]
*/
public function requestConsignment($data,$debug=0,$crg_consignment_url,$save_response=NULL,$shipping_method_name=NULL) {
$this->pkg_number = "0";
$this->urls = array();
$this->cost_estimate = 0;
$this->data = $data;

$xw = &new CRG_Xmlwriter();
$xw = $this->parseArray($data,$xw);

$xml = $xw->getXml();

curl_setopt($this->curl, CURLOPT_URL, $this->consignment_url);
curl_setopt($this->curl, CURLOPT_POST, 1);
curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");

if($debug == 1) echo "XML<br>\n".print_r($xml,1)."<br>\n";

curl_setopt($this->curl, CURLOPT_POSTFIELDS, $xml);

$headers = array(
"X-Cargonizer-Key:".$this->api_key,
"X-Cargonizer-Sender:".$this->sender_id,
"Content-type:application/xml",
"Content-length:".strlen($xml),
);
if($debug == 1) echo "Header\n".print_r($headers,1)."<br>\n";	
curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

if($debug == 0) $response = $this->runRequest($debug);

if($debug == 0) $this->parseResponse($response,$debug);

if (isset($save_response) && $save_response && $_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
	/**
	 * this saves cargonizer response to /cargonizer_response.txt
	 */
	$x = $xw->xml;
	$ran = rand(0, 100);
	$myFile = "cargonizer_response_".time().$ran.".txt";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = $shipping_method_name . "\n\n";
	$stringData .= $x;
	fwrite($fh, $stringData);
	fwrite($fh, "\n\nThe response:\n\n");
	fwrite($fh, $response);
	fclose($fh);
	
}

return $response;
}

/**
*
* Fetches the transport agreements for the set API key and Sender ID
* You need the transport ID and Product for the consignment call
* @param string $url [optional]
* @return simplexml_object
*/
public function requestTransportAgreements($url = "") {
	if($url == '') $url = $this->transport_agreement_url;
	echo "URL: $url<br>\n";
	curl_setopt($this->curl, CURLOPT_URL, $url);
	curl_setopt($this->curl, CURLOPT_POST, 0);
	$headers = array(
		"X-Cargonizer-Key:".$this->api_key,
		"X-Cargonizer-Sender:".$this->sender_id,
		"Content-type:application/xml",
		"Content-length:0",
	);
	curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
	$response = $this->runRequest($debug);
	return $response;
}

/**
* General array to xml parser
* NOTE: Some changes by DANIEL
* $v['_attribs'] is replaced now by $v['consignment']['_attribs']
* changes are wrong!!!
*/
private function parseArray($data,&$xw) {
	if ($data)foreach($data as $k=>$v) {
		if($k == "_attribs" and !is_numeric($k)) {
			continue;
		}
		if(is_numeric($k)) {
			$xw = $this->parseArray($v,$xw);
		} else if(is_array($v)) {
			if(count($v) == 1 and count($v['_attribs']) > 0) {
				$xw->element($k,'',$v['_attribs']);
			} else {
				//$xw->push($k,$v['_attribs']);
				$xw->push($k,$v['_attribs']);
				$xw = $this->parseArray($v,$xw);
				$xw->pop();
			}
		} else {
			$xw->element($k,$v);
		}
	}
	return $xw;
}

private function runRequest($debug=0) {
$response = curl_exec($this->curl);

if(!curl_errno($this->curl)) {
$info = curl_getinfo($this->curl);
$this->http_code = $info['http_code'];

if($debug == 1) echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url']."<br>\n";
} else {
if($debug == 1) echo 'Curl error: ' . curl_error($this->curl)."<br>\n";
$this->error_flag = 1;
$this->errors['curl_request'] .= curl_error($this->curl)."\n";
}
return $response;
}

private function parse_simple_xml_for_errors($the_xml) {
	foreach ($the_xml->children() as $child){
		$name = $child->getName();
		
		if ($name == 'error'){
			$this->consignment_errors_found = TRUE;
			$this->error_found[] = (string) $child;
		}
		if ($child->children()){
			$this->parse_simple_xml_for_errors($child);
		}
	}
}

private function parseResponse($xml,$debug=0) {
	$sxml = simplexml_load_string($xml);
	
	//echo "Http code: $this->http_code";
	$this->sxml = $sxml;
	$this->error_found = array();
	
	switch ($this->http_code){
		case "200": //Your request was successful
			$this->error_found[] = "200";
			break;

		case "201": //The resource you sent was created
			$this->error_found[] = "201";
			break;
		
		case "302": //Redirect: Follow the Location header to the next URL
			$this->error_found[] = "302";
			break;
			
		case "400": //Validation or other "user" error (i.e. your fault). Review the error messages to see what's wrong
			$this->error_found[] = "400";
			break;
			
		case "401": //Authentication error. Check that you've authenticated properly
			$this->error_found[] = "401";
			break;
			
		case "402": //Authorization error. Most likely, the sender ID is missing or incorrect
			$this->error_found[] = "402";
			break;
			
		case "404": //The resource you're trying to reach can not be found. This can occur if you're requesting a resource that belongs to a different sender
			$this->error_found[] = "404";
			break;
			
		case "500": //An error occured. This is most likely not your fault, but a bug, though sometimes missing or invalid parameters could cause this
			$this->error_found[] = "500";
			break;
			
		case "502": //Temporarily unavailable. This may happen during a deployment or configuration change. Wait a few seconds and try again
			$this->error_found[] = "502";
			break;
	}
	
	$this->parse_simple_xml_for_errors($this->sxml);
	
	if($sxml->getName() == "errors") {
		if($debug == 1) echo "SXML<br><pre>".print_r($sxml,1)."</pre>";
		$this->error_flag = 1;
		$this->errors['parsing'] .= $sxml."\n".print_r($this->data,1);
	} else {
		if($debug == 1) echo "SXML<br><pre>".print_r($sxml,1)."</pre>";
	}
	
	foreach($sxml->consignment as $consignment) {
		$this->pkg_number = (string)$consignment->{'number-with-checksum'};
		if($debug == 1) echo "PDF: ".$consignment->{'consignment-pdf'}."<br>\n";
		$this->urls['consignment-pdf'] = $consignment->{'consignment-pdf'};
		$this->urls['collection-pdf'] = (string)$consignment->{'collection-pdf'};
		$this->urls['waybill-pdf'] = (string)$consignment->{'waybill-pdf'};
		$this->urls['tracking-url'] = (string)$consignment->{'tracking-url'};
		if($debug == 1) echo "Values: ".print_r((string)$consignment->{'cost-estimate'}->gross,1)."<br>\n";
			$this->cost_estimate = (string)$consignment->{'cost-estimate'}->gross;
	}
}

public function parse_xml($xml){
	$xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $XML, $vals);
    xml_parser_free($xml_parser);
    // wyznaczamy tablice z powtarzajacymi sie tagami na tym samym poziomie
    $_tmp='';
    foreach ($vals as $xml_elem) {
        $x_tag=$xml_elem['tag'];
        $x_level=$xml_elem['level'];
        $x_type=$xml_elem['type'];
        if ($x_level!=1 && $x_type == 'close') {
            if (isset($multi_key[$x_tag][$x_level]))
                $multi_key[$x_tag][$x_level]=1;
            else
                $multi_key[$x_tag][$x_level]=0;
        }
        if ($x_level!=1 && $x_type == 'complete') {
            if ($_tmp==$x_tag)
                $multi_key[$x_tag][$x_level]=1;
            $_tmp=$x_tag;
        }
    }
    // jedziemy po tablicy
    foreach ($vals as $xml_elem) {
        $x_tag=$xml_elem['tag'];
        $x_level=$xml_elem['level'];
        $x_type=$xml_elem['type'];
        if ($x_type == 'open')
            $level[$x_level] = $x_tag;
        $start_level = 1;
        $php_stmt = '$xml_array';
        if ($x_type=='close' && $x_level!=1)
            $multi_key[$x_tag][$x_level]++;
        while ($start_level < $x_level) {
            $php_stmt .= '[$level['.$start_level.']]';
            if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
                $php_stmt .= '['.($multi_key[$level[$start_level]][$start_level]-1).']';
            $start_level++;
        }
        $add='';
        if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type=='open' || $x_type=='complete')) {
            if (!isset($multi_key2[$x_tag][$x_level]))
                $multi_key2[$x_tag][$x_level]=0;
            else
                $multi_key2[$x_tag][$x_level]++;
            $add='['.$multi_key2[$x_tag][$x_level].']';
        }
        if (isset($xml_elem['value']) && trim($xml_elem['value'])!='' && !array_key_exists('attributes', $xml_elem)) {
            if ($x_type == 'open')
                $php_stmt_main=$php_stmt.'[$x_type]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
            else
                $php_stmt_main=$php_stmt.'[$x_tag]'.$add.' = $xml_elem[\'value\'];';
            eval($php_stmt_main);
        }
        if (array_key_exists('attributes', $xml_elem)) {
            if (isset($xml_elem['value'])) {
                $php_stmt_main=$php_stmt.'[$x_tag]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                eval($php_stmt_main);
            }
            foreach ($xml_elem['attributes'] as $key=>$value) {
                $php_stmt_att=$php_stmt.'[$x_tag]'.$add.'[$key] = $value;';
                eval($php_stmt_att);
            }
        }
    }
    return $xml_array;
}

	/**
	 * this function is obsolite!
	 * Enter description here ...
	 * @param unknown_type $post_code
	 */
	function get_service_partner($post_code){
    	$url = "http://cargonizer.logistra.no/service_partners.xml?country=NO&postcode=$post_code";
    	$response = simplexml_load_file($url);
    	
    	$service_partner = array();
    	$service_partner['customer_number'] = (string) $response->{'service-partners'}->{'service-partner'}->{'customer-number'};
    	$service_partner['name'] = (string) $response->{'service-partners'}->{'service-partner'}->{'name'};
    	$service_partner['address1'] = (string) $response->{'service-partners'}->{'service-partner'}->{'address1'};
    	$service_partner['postcode'] = (string) $response->{'service-partners'}->{'service-partner'}->{'postcode'};
    	$service_partner['city'] = (string) $response->{'service-partners'}->{'service-partner'}->{'city'};
    	$service_partner['country'] = (string) $response->{'service-partners'}->{'service-partner'}->{'country'};
    	$service_partner['opening-hours'] = $response->{'service-partners'}->{'service-partner'}->{'opening-hours'};
    	
    	$opening_hours = array();
    	$oh = (array) $service_partner['opening-hours'];
    	foreach ($oh['day'] as $day){
    		foreach ((array) $day as $key=>$value){
    			if ($key == "@attributes"){
    				$day_name = $value['name'];
    			} else {
    				$value_array = (array) $value;
    				$opening_hours[$day_name] = $value_array['@attributes']['from'] . ' - ' . $value_array['@attributes']['to'];
    			}
    		}
    	}
    	$service_partner['opening-hours'] = $opening_hours;
    	return $service_partner;
    }
    
    /**
    	* check for timeout first
    */
    function check_timeout($url){
    	$ch = curl_init();
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    $tmp = curl_exec($ch);
	    curl_close($ch);
	    if (!$tmp) return false;
	    else return true;
    }
    
    function get_service_partners($post_code){
    	$url = "http://cargonizer.logistra.no/service_partners.json?country=NO&postcode=$post_code";
    	
    	if (!$this->check_timeout($url)) {
    		$service_partners = array();
    		return $service_partners;
    	}
    	
    	$response = json_decode(file_get_contents($url), true);
    	//echo "<pre>";var_dump($response);echo "</pre>";
    	
    	$service_partners = array(); 
    	
    	foreach ($response['service_partners'] as $key=>$value){
    		//echo "<pre>";var_dump($value);
    		$service_partners[$key]['customer_number'] = (string) $value['customer_number'];
    		$service_partners[$key]['name'] = (string) $value['name'];
    		$service_partners[$key]['address1'] = (string) $value['address1'];
    		$service_partners[$key]['postcode'] = (string) $value['postcode'];
    		$service_partners[$key]['city'] = (string) $value['city'];
    		$service_partners[$key]['country'] = (string) $value['country'];
    		
    		$opening_hours = array();
    		$weekdays = array(
    			0 => "Monday",
    			1 => "Tuesday",
    			2 => "Wednesday",
    			3 => "Thursday",
    			4 => "Friday",
    			5 => "Saturday",
    			6 => "Sunday"
    		);
    		$day_counter = 0;
    		
	    	$oh = $value['opening_hours'];
	    	foreach ($oh as $day){
	    		$day = $day[0];
	    		if ($day){
		    		$day_name = $weekdays[$day_counter];
		    		$from = $this->get_hours_from_array($day[0]);
		    		$to = $this->get_hours_from_array($day[1]);
		    		$opening_hours[$day_name] = $from . ' - ' . $to;
		    		$day_counter++;
	    		}
	    	}
	    	$service_partners[$key]['opening-hours'] = $opening_hours;
    	}
    	
    	return $service_partners;
    }
    
    function get_hours_from_array($hours){
    	$s = "";
    	$s = sprintf("%02s", $hours[0]) . ":" . sprintf("%02s", $hours[1]) ;
    	
    	return $s;
    }
    
	function _old_get_service_partners($post_code){
		
    	$url = "http://cargonizer.logistra.no/service_partners.xml?country=NO&postcode=$post_code";
    	$response = simplexml_load_file($url);
    	$response = (array) $response;
    	$sps = (array) $response['service-partners'];
    	$sps = $sps['service-partner'];
    	$service_partners = array(); 
    	foreach ($sps as $key=>$value){
    		$service_partners[$key]['customer_number'] = (string) $value->{'customer-number'};
    		$service_partners[$key]['name'] = (string) $value->{'name'};
    		$service_partners[$key]['address1'] = (string) $value->{'address1'};
    		$service_partners[$key]['postcode'] = (string) $value->{'postcode'};
    		$service_partners[$key]['city'] = (string) $value->{'city'};
    		$service_partners[$key]['country'] = (string) $value->{'country'};
    		
    		$opening_hours = array();
	    	$oh = (array) $value->{'opening-hours'};
	    	
	    	foreach ($oh['day'] as $day){
	    		foreach ((array) $day as $k=>$v){
	    			if ($k == "@attributes"){
	    				$day_name = $v['name'];
	    			} else {
	    				$value_array = (array) $v;
	    				$opening_hours[$day_name] = $value_array['@attributes']['from'] . ' - ' . $value_array['@attributes']['to'];
	    			}
	    		}
	    	}
	    	
	    	$service_partners[$key]['opening-hours'] = $opening_hours;
    	}

    	return $service_partners;
    }
}

/*
* Modified version of Xmlwriter
* ServiceLogistikk AS
*
* Modified from
* Simon Willison, 16th April 2003
* Based on Lars Marius Garshol's Python XMLWriter class
* See http://www.xml.com/pub/a/2003/04/09/py-xml.html
*
*/

class CRG_Xmlwriter {
    //private $xml;
    public $xml;
    private $indent;
    private $stack = array();

    function CRG_Xmlwriter($indent = ' ',$encoding = 'ISO-8859-1') {
        $this->indent = $indent;
        $this->xml = "<?xml version=\"1.0\" encoding=\"$encoding\"?>"."\n";
    }
    function _indent() {
        for ($i = 0, $j = count($this->stack); $i < $j; $i++) {
            $this->xml .= $this->indent;
        }
    }
    //* Push
    function push($element, $attributes = array(), $ns = "") {
        $this->_indent();
        $this->xml .= '<'.$element;
        if($ns != '') $this->xml .= " ".$ns;
        if ($attributes){
        	foreach ($attributes as $key => $value) {
	            $this->xml .= ' '.$key.'="'.$value.'"';
	        }
        }
        $this->xml .= ">\n";
        $this->stack[] = $element;
    }
    function push_cdata($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="<![CDATA['.$value.']]>"';
        }
        $this->xml .= ">\n";
        $this->stack[] = $element;
    }
    function push_htmlentities($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= ">\n";
        $this->stack[] = $element;
    }
    //* Element
    function element($element, $content = '', $attributes = array(), $ns = '', $nil = '') {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.$value.'"';
        }
        if($content == '') {
         if($nil != '') $this->xml .= " ".$nil;
         if($ns != '') $this->xml .= " ".$ns;
         $this->xml .= " />\n";
        } else {
         if($ns != '') $this->xml .= " ".$ns;
         $this->xml .= '>'.$content.'</'.$element.'>'."\n";
        }
    }
    function element_cdata($element, $content = '', $attributes = array(), $length = 0) {
    
     if($length > 0) {
		$c_len = strlen("![CDATA[]]");
		if(strlen($content)+$c_len > $length) {
		$real_length = $length-$c_len;
		$content = substr($content,0,$real_length);
		}
     }
    
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="<![CDATA['.$value.']]>"';
        }
        if($content == '') {
         $this->xml .= " />\n";
        } else {
         $this->xml .= '><![CDATA['.$content.']]></'.$element.'>'."\n";
        }
    }
    function element_htmlentities($element, $content = '', $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        if($content == '') {
         $this->xml .= " />\n";
        } else {
         $this->xml .= '>'.htmlentities($content).'</'.$element.'>'."\n";
        }
    }
    function pop() {
        $element = array_pop($this->stack);
        $this->_indent();
        $this->xml .= "</$element>\n";
    }
    function getXml() {
        return $this->xml;
    }
}
?>