<?php
App::uses('AppModel', 'Model');
/**
 * Redirection Model
 *
 * @property FromUser $FromUser
 * @property ToUser $ToUser
 */
class Redirection extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */	
	public $belongsTo = array(
		'FromUser' => array(
			'className' => 'User',
			'foreignKey' => 'from_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ToUser' => array(
			'className' => 'User',
			'foreignKey' => 'to_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function findToUsers($fromUserId){
		$redirections = $this->find('all', array(
			'conditions' => array( 
				'Redirection.from_user_id' => $fromUserId
				)
			)
		);
		return $redirections;
	}

	public function findUserIdRedirection($userId) {
		$list = $this->find('list', array(
			'fields' => array('to_user_id'),
			'conditions' => array(
				'from_user_id' => $userId
				)
			)
		);
		return $list;
	}
}
