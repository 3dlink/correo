<?php
App::uses('AppModel', 'Model');
/**
 * Entity Model
 *
 * @property Entity $ParentEntity
 * @property Communication $Communication
 * @property Entity $ChildEntity
 * @property User $User
 */
class Entity extends AppModel {

    var $actsAs = array('Tree');

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
		'ParentEntity' => array(
			'className' => 'Entity',
			'foreignKey' => 'parent_id',
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
			'foreignKey' => 'entity_id',
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
		'ChildEntity' => array(
			'className' => 'Entity',
			'foreignKey' => 'parent_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'entity_id',
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

	// obtiene los entidades iniciales del arbol
	public function getParents($idParent = null){
		if ($idParent){
			$entities = $this->find('all', array(
				'conditions' => array(
					'Entity.id' => $idParent,
					'Entity.parent_id' => 1,
					'Entity.active' => 1
					)
				)
			);
		}
		else {
			$entities = $this->find('all', array(
				'conditions' => array(
					'Entity.parent_id' => 1,
					'Entity.active' => 1
					),
				'order' => array('Entity.order' => 'ASC') 
				)
			);
		}
		return $entities;
	}

	// obtiene los hijos directos de un nodo
	public function getChildren($idParent) {
		$entities = $this->find('all', array(
			'conditions' => array(
				'Entity.parent_id' => $idParent,
				'Entity.active' => 1
				),
			'order' => array('Entity.order' => 'ASC') 
			)
		);
		return $entities ;
	}

	// obtiene toda la familia antecesora de un nodo
	public function getPathComplete($idEntity) {
		$simplePath = $this->getPath($idEntity);
		foreach ($simplePath as $key => $node) {
			//$this->recursive = -1;
			$child = $this->getChildren($node['Entity']['id']);
			$simplePath[$key+1]['Brothers'] = $child; 
		}
		unset($simplePath[0]);
		$cant = count($simplePath);
		unset($simplePath[$cant]);

		return $simplePath;
	}

	// obtiene una lista de los nodos id descendientes inmediatos de un nodo
	public function getAllDescentIds($idParent){
		$tree = $this->generateTreeList();
		$cant_parent = 0;
		$find = false;
		$arr =  array( );
		foreach ($tree as $key => $node) {
			if ($find){
				$cant = substr_count($node, '_');
				if ($cant > $cant_parent){
					$arr[] = $key;
				}
				else {
					break;
				}
			}
			if ($key == $idParent){
				$find = true;
				$cant_parent = substr_count($node, '_');
			}
		}
		return $arr;
	}



	public function getCompleteTree(){
		$conditions = array('fields' => array('id', 'name', 'description', 'parent_id'));
		$nodes = $this->Entity->generateTreeList($conditions);
		
		$nodes = $this->Entity->children();
		$tree = array();
		foreach ($nodes as $key => $node) {
			$id = $node['Entity']['id'];
			$parent = $node['Entity']['parent_id'];
			if ($parent == 0) {
				$tree[$id] = $node;
				$tree['chidren'] = array();
			}
			else {
				$tree[$parent]['chidren'];
			}
		}
		return $entities;
	}

	// buscar entidades por nombre parecidos y que tengan personas 
	public function findEntityByName($q){
		$this->recursive = 0;
		/*
		$entities = $this->query("SELECT * 
			FROM entities AS Entity 
			WHERE Entity.name LIKE '%$q%'");
		*/
		$entities = $this->query("SELECT * 
			FROM entities AS Entity 
			WHERE Entity.name LIKE '%$q%' 
			AND EXISTS (SELECT u.id FROM users AS u WHERE u.entity_id = Entity.id)");
		
		return $entities;
	}

	// buscar entidades por nombre parecidos y que tengan personas 
	public function findEntityByNameAll($q){
		$this->recursive = 0;
		$entities = $this->query("SELECT * 
			FROM entities AS Entity 
			WHERE Entity.name LIKE '%$q%' AND Entity.active = '1'");
		/*
		$entities = $this->query("SELECT * 
			FROM entities AS Entity 
			WHERE Entity.name LIKE '%$q%' 
			AND EXISTS (SELECT u.id FROM users AS u WHERE u.entity_id = Entity.id)");
		
		*/
		return $entities;
	}

	//  entidades por nombre parecidos y obtner solo los ids
	public function findEntityIdsByName($q){
		$this->recursive = 0;
		$entities = $this->find('list', array(
			'fields' => array('Entity.id'),
			'conditions' => array(
				'Entity.name LIKE' => '%'.$q.'%',
				'Entity.active' => 1,
				),
			)
		);
		return $entities;
	}

	public function getAllEntitiesDescendents($entityId){
		$entities = $this->getAllDescentIds($entityId);
		return $entities;
	}
}

