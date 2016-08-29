<?php
App::uses('AppModel', 'Model');
/**
 * CommunicationType Model
 *
 * @property Communication $Communication
 */
class CommunicationType extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Communication' => array(
			'className' => 'Communication',
			'foreignKey' => 'communication_type_id',
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

	// buscar tipos de categori por nombre parecidos y obtner solo los ids
	public function findTypeIdsByName($q){
		$this->recursive = 0;
		$types = $this->find('list', array(
			'fields' => array('CommunicationType.id'),
			'conditions' => array(
				'CommunicationType.name LIKE' => '%'.$q.'%',
				'CommunicationType.active' => 1,
				),
			)
		);
		return $types;
	}

}
