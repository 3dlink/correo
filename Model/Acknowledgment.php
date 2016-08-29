<?php
App::uses('AppModel', 'Model');
/**
 * Acknowledgment Model
 *
 * @property Upload $Upload
 * @property Communication $Communication
 */
class Acknowledgment extends AppModel {


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
		)
	);
}
