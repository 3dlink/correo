<?php
App::uses('AppModel', 'Model');
/**
 * ControlView Model
 *
 * @property Communication $Communication
 * @property SenderUser $SenderUser
 * @property ReceiveUser $ReceiveUser
 */
class ControlView extends AppModel {


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
		'SenderUser' => array(
			'className' => 'User',
			'foreignKey' => 'sender_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ReceiveUser' => array(
			'className' => 'User',
			'foreignKey' => 'receive_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
