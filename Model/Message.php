<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 */
class Message extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

	/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Upload' => array(
			'className' => 'FileUpload.Upload',
			'foreignKey' => 'message_id',
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

	// mmensajes que contengan parte del texto en un grupo de mensajes
	public function findContent($query, $arrayIds){
		$this->recursive = -1;
		$messages = $this->find('list', array(
			'fields' => array('id'),
			'conditions' => array(
				'OR' => array(
					'Message.title LIKE' => '%'.$query.'%',
					'Message.content LIKE' => '%'.$query.'%',
					),
				'Message.id' => $arrayIds
				)
			)
		);
		return $messages;
	}

}
