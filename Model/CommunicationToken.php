<?php
App::uses('AppModel', 'Model');
/**
 * CommunicationToken Model
 *
 * @property Communication $Communication
 * @property User $User
 */
class CommunicationToken extends AppModel {


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

	public function deleteToken($idCommunication, $idUser){
		$tokens = $this->find('all', array(
			'conditions' => array(
				'CommunicationToken.communication_id' => $idCommunication,
				'CommunicationToken.user_id' => $idUser
				)
			)
		);
		
		if (!empty($tokens)){
			foreach ($tokens as $key => $token) {
				$this->delete($token['CommunicationToken']['id']);
			}
		}
	}

	public function createToken($idCommunication, $idUser){
		$t['communication_id'] = $idCommunication;
		$t['user_id'] = $idUser;
		$this->create();
		if ($this->save($t)) return true;
		else return false;
	}

	public function getTokens($idCommunication){
		$tokens = $this->find('list', array(
			'fields' => array('user_id'),
			'conditions' => array(
				'communication_id' => $idCommunication
				)
			)
		);
		return $tokens;
	}
}
