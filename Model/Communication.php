<?php
App::uses('AppModel', 'Model');
/**
 * Communication Model
 *
 * @property Entity $Entity
 * @property User $User
 * @property Tag $Tag
 * @property Trace $Trace
 */
class Communication extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Entity' => array(
			'className' => 'Entity',
			'foreignKey' => 'entity_id',
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
		),
		'CommunicationCategory' => array(
			'className' => 'CommunicationCategory',
			'foreignKey' => 'communication_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CommunicationType' => array(
			'className' => 'CommunicationType',
			'foreignKey' => 'communication_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'communication_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Trace' => array(
			'className' => 'Trace',
			'foreignKey' => 'communication_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CommunicationToken' => array(
			'className' => 'CommunicationToken',
			'foreignKey' => 'communication_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CommunicationTrash' => array(
			'className' => 'CommunicationTrash',
			'foreignKey' => 'communication_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	// buscar ids de las comunicaciones por id de categoria
	public function findIdsByCategoryId($communicationCategoryId){
		$this->recursive = -1;
		$communications = $this->find('all', array(
			'fields' => array('Communication.id'),
			'conditions' => array(
				'Communication.communication_category_id' => $communicationCategoryId,
				),
			)
		);
		$arr = array();
		foreach ($communications as $key => $c) {
			$arr[] = $c['Communication']['id'];
		}
		return $arr;
	}

	// buscar ids de las comunicaciones por id del tipo de comunicacion
	public function findIdsByTypeId($communicationTypeId){
		$this->recursive = -1;
		$communications = $this->find('all', array(
			'fields' => array('Communication.id'),
			'conditions' => array(
				'Communication.communication_type_id' => $communicationTypeId,
				),
			)
		);
		$arr = array();
		foreach ($communications as $key => $c) {
			$arr[] = $c['Communication']['id'];
		}
		return $arr;
	}

	// buscar ids de las comunicaciones por id del tipo de comunicacion
	public function hasAttachments($communicationId){
		$this->recursive = -1;
		$count = $this->query("SELECT COUNT(*) AS count
			FROM traces AS Trace, messages AS Message, uploads AS Upload
			WHERE Trace.communication_id = $communicationId AND Trace.message_id = Message.id AND Upload.message_id = Message.id");
		
		return $count[0][0]['count'];
	}

}
