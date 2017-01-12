<?php

class ProductsController extends AppController {
    public $name = "Products";

    public function index(){
        $elements = $this->Product->find('all'); 
        $this->set('elements', $elements);
    }
}
