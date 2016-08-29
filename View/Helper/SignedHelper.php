<?php

App::uses('Helper', 'View');
class SignedHelper extends AppHelper {
	
	public $uses = array('SignedCommunication' , 'Acknowledgment');
	
 public function __construct() {
        foreach($this->uses as $model) {
            $this->$model = ClassRegistry::init($model);
        }
    }
    
	
	public function signed($id = 0){
			
		
		

		$count = $this->SignedCommunication->find('count', array ('conditions' => array ('communication_id' => $id , 'status' => 'firmado')));
		
		 return $count;
	}
	
	public function signedDocument($document = null){
			
	
	
	
		$count = $this->Acknowledgment->find('count', array ('conditions' => array ('document' => $document , 'status' => 'recibido')));
	
		return $count;
	}
}
