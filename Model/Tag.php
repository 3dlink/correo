<?php
App::uses('AppModel', 'Model');
/**
 * Tag Model
 *
 * @property Communication $Communication
 * @property User $User
 */
class Tag extends AppModel {

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

	public function findUCommunicationIdsByTagNameAndUserId($q, $userId){
		$this->recursive = -1;
		$tags = $this->find('list', array(
			'fields' => array('Tag.communication_id'),
			'conditions' => array(
				'Tag.name LIKE' => '%'.$q.'%',
				'Tag.user_id' => $userId
				),
			)
		);
		return $tags;
	}


	// buscar tags por nombres y usuario
	public function findUTagByNameAndUserId($q, $userId){
		$this->recursive = -1;
		$tags = $this->find('all', array(
			'conditions' => array(
				'Tag.name LIKE' => '%'.$q.'%',
				'Tag.user_id' => $userId
				),
			'group' => array('Tag.name')
			)
		);

		return $tags;
	}

	// ultimos 5 tags mas usuados de un usuario
	public function findPopularTagsByUser($userId){
		$this->recursive = -1;
		$tags = $this->query("SELECT Tag.name, Tag.id, COUNT(Tag.name) AS count_tag 
			FROM tags AS Tag 
			WHERE Tag.user_id = $userId 
			GROUP BY Tag.name 
			ORDER BY count_tag DESC 
			LIMIT 5"
			);
		return $tags;
	}

	// buscar los ids de una comunicacion que tengan un tag
	public function findCommunicationsIdsByName($name){
		$this->recursive = -1;
		$tags = $this->query("SELECT DISTINCT communication_id
			FROM tags 
			WHERE name = '$name'
			");
		$arr = array();
		foreach ($tags as $key => $tag) {
			$arr[] = $tag['tags']['communication_id'];
		}
		return $arr;
	}

}
