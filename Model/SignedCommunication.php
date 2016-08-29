<?php
App::uses('AppModel', 'Model');
/**
 * SignedCommunication Model
 *
 * @property User $User
 * @property Communication $Communication
 */
class SignedCommunication extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Communication' => array(
			'className' => 'Communication',
			'foreignKey' => 'communication_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function findSigned($id){
		
		
			$count = $this->SignedCommunication->find('count', array ('conditions' => array ('communication_id' => $id)));
		
		
		return $count;
	}
}
