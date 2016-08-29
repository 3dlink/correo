<?php
App::uses('AppModel', 'Model');
/**
 * Circle Model
 *
 * @property User $User
 */
class Circle extends AppModel {

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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'UserCircle' => array(
			'className' => 'UserCircle',
			'foreignKey' => 'circle_id',
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

	// buscar circulos por nombre. que sean publicos o que yo pertenezca o sea el dueno.
	public function findCirclesByName($q, $userId = null, $idEntityParentUser){
		$this->recursive = -1;
		$ucs = $this->query("SELECT circle_id as id FROM user_circles as UserCircle WHERE UserCircle.user_id = $userId;");
		$circlesId = array();
		foreach ($ucs as $key => $uc) {
			array_push($circlesId, $uc['UserCircle']['id']);
		}
		//$circlesId = implode(',', $circlesId);
		$circles = $this->find('all', array(
			'conditions' => array(
				'Circle.name LIKE' => '%'.$q.'%',
				'Circle.entity_id' => $idEntityParentUser,
				'OR' => array(
					'Circle.user_id' => $userId,
					'Circle.type' => 2,
					'Circle.id' => $circlesId
					),
				'Circle.active' => 1
				)
			)
		);
		return $circles;
	}

	// obtener los usuarios de un circulo
	public function getIdUsersFromCircleId($id){
		if($id == 0){
			
			$userId = $_SESSION['UserAuth']['User']['id'];
			$ucs = $this->query("SELECT user_id as id FROM user_circles as UserCircle WHERE UserCircle.user_id = $userId;");
		}
		else{
			$ucs = $this->query("SELECT user_id as id FROM user_circles as UserCircle WHERE UserCircle.circle_id = $id;");
		}
		
		$circlesId = array();
		foreach ($ucs as $key => $uc) {
			array_push($circlesId, $uc['UserCircle']['id']);
		}
		return $circlesId;
	}

	// obtener los circulos de un usuario
	public function getCirclesByUserId($id){
		$ucs = $this->query("SELECT circle_id as id FROM user_circles as UserCircle WHERE UserCircle.user_id = $id;");
		$circlesId = array();
		foreach ($ucs as $key => $uc) {
			array_push($circlesId, $uc['UserCircle']['id']);
		}
		$circles = $this->find('all', array(
			'conditions' => array(
				'Circle.id' => $circlesId,
				'Circle.active' => 1
				)
			)
		);
		return $circles;
	}

	// obtener los circulos de un usuario y los de la entidad publicos
	public function getCirclesByUserIdAndEntityId($userId, $idEntityParentUser){
		$this->recursive = -1;
		$ucs = $this->query("SELECT circle_id as id FROM user_circles as UserCircle WHERE UserCircle.user_id = $userId;");
		$circlesId = array();
		foreach ($ucs as $key => $uc) {
			array_push($circlesId, $uc['UserCircle']['id']);
		}
		//$circlesId = implode(',', $circlesId);
		$circles = $this->find('list', array(
			'conditions' => array(
				'Circle.entity_id' => $idEntityParentUser,
				'OR' => array(
					'Circle.user_id' => $userId,
					'Circle.type' => 2,
					'Circle.id' => $circlesId
					),
				'Circle.active' => 1
				)
			)
		);
		return $circles;
	}
}
