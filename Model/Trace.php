<?php
App::uses('AppModel', 'Model');
/**
 * Trace Model
 *
 * @property Communication $Communication
 * @property Messages $Messages
 * @property Sender $Sender
 * @property Receive $Receive
 */
class Trace extends AppModel {


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
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'message_id',
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
			'className' => 'Users',
			'foreignKey' => 'receive_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SenderEntity' => array(
			'className' => 'Entity',
			'foreignKey' => 'sender_entity_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ReceiveEntitie' => array(
			'className' => 'Entities',
			'foreignKey' => 'receive_entity_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function markAsRead($communicationId, $userId){
		//$this->recursive = -1;
		$traces = $this->find('all', array(
			'conditions' => array(
				'communication_id' => $communicationId,
				'receive_user_id' => $userId
				)
			)
		);
		foreach ($traces as $key => $trace) {
			$trace['Trace']['read'] = 1;
			$trace['Trace']['read_datatime'] =  date('Y-m-d H:i:s');
			$this->save($trace['Trace']);
		};
	}

}
