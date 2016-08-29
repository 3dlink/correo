<?php
App::uses('AppModel', 'Model');
/**
 * CommunicationCategory Model
 *
 * @property CommunicationType $CommunicationType
 * @property Communication $Communication
 */
class CommunicationCategory extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CommunicationType' => array(
			'className' => 'CommunicationType',
			'foreignKey' => 'communication_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Communication' => array(
			'className' => 'Communication',
			'foreignKey' => 'communication_category_id',
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

	// buscar vcategorias por nombre parecidos y obtner solo los ids
	public function findCategoryIdsByName($q) {
		$this->recursive = 0;
		$categories = $this->find('list', array(
			'fields' => array('CommunicationCategory.id'),
			'conditions' => array(
				'CommunicationCategory.name LIKE' => '%'.$q.'%',
				'CommunicationCategory.active' => 1,
				),
			)
		);
		return $categories;
	}

}
