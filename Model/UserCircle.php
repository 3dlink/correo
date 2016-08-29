<?php
App::uses('AppModel', 'Model');
/**
 * UserCircle Model
 *
 * @property User $User
 * @property Circle $Circle
 */
class UserCircle extends AppModel {


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
		'Circle' => array(
			'className' => 'Circle',
			'foreignKey' => 'circle_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
