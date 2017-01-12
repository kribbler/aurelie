<?php
class Product extends AppModel{
	
	public $name = 'Product';
        
        public $hasMany = array(
            'ProductImage'
        );
        
}