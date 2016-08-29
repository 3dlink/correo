<?php

App::uses('Helper', 'View');
class ForwardHelper extends AppHelper {
	
	public $uses = array('Upload');
	
 public function __construct() {
        foreach($this->uses as $model) {
            $this->$model = ClassRegistry::init($model);
        }
    }
    
	
	public function upload($realname , $filename){
		
		$this->Upload->create();
		$data['Upload']['real_name'] = $realname;
		$data['Upload']['name'] = $filename;
		$this->Upload->save($data);
		$id = $this->Upload->getLastInsertID();
		
		 return $id;
	}
}
