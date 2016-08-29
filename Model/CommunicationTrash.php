<?php
App::uses('AppModel', 'Model');
/**
 * CommunicationTrash Model
 *
 * @property Communication $Communication
 * @property User $User
 */
class CommunicationTrash extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'communication_trashs';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Communication' => array(
			'className' => 'Communication',
			'foreignKey' => 'communication_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
