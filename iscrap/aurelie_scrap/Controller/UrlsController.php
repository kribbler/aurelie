<?php

class UrlsController extends AppController {
    public $name = "Urls";

    public function index(){
        $elements = $this->Url->find('all'); 
        $this->set('elements', $elements);
    }

    public function edit($id){
		if (!empty($this->request->data)) {
			
			$this->Url->create();
			if ($this->Url->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
		} else {
			$this->Url->locale = 'eng';
			$this->data = $this->Url->read(null, $id);
		}
	}
	
	public function add(){
		if (!empty($this->request->data)) {
            $this->Url->create();
            if ($this->Url->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
        }
	}

	public function delete($website_id) {
		$this->Url->delete($website_id);
		$this->Session->setFlash(__('The url is deleted!'));
		$this->redirect($this->referer());

	}

}
