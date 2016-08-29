<?php
App::uses('AppModel', 'Model');
/**
 * Format Model
 *
 * @property Upload $Upload
 * @property CommunicationType $CommunicationType
 * @property CommunicationCategory $CommunicationCategory
 */
class Format extends AppModel {

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
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'upload_id',
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
		'CommunicationCategory' => array(
			'className' => 'CommunicationCategory',
			'foreignKey' => 'communication_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function makeVisible($idFormat, $visible) {
    	$format = $this->findById($idFormat);
    	$format['Format']['visible'] = $visible;
    	if ($this->save($format)) return true;
    	return false;
    }
}
