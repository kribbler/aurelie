<?php
class Product extends AppModel{
	
	public $name = 'product';
	
	public $belongsTo = array(
		'Url'
		);

}