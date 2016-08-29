<?php
App::uses('AppController', 'Controller');
/**
 * Circles Controller
 *
 * @property Circle $Circle
 */
class CirclesController extends AppController {
	var $uses = array('Circle', 'UserCircle', 'Entity', 'Usermgmt.User');


/**
 * listado de los circulos que ha creado el usuario logueado
 *
 * @return void
 */
	public function index() {
		$this->Circle->recursive = 0;
		$userId = $this->Session->read('UserAuth.User.id');
		$circles = $this->Circle->find('all', array(
			'conditions' => array(
				'Circle.user_id' => $this->Session->read('UserAuth.User.id'),
				)
			)
		);
		$this->set('circles', $circles);
	}

/**
 * listado de los circulos a los que soy dueño y pertenezco
 *
 * @return void
 */
	public function myCircles() {
		$this->Circle->Recursive = 2;
		$userId = $this->Session->read('UserAuth.User.id');
		$circles = $this->Circle->query("SELECT Circle.id, Circle.name, Circle.active, Circle.user_id, Circle.type, Circle.created, User.id, User.username, User.first_name, User.last_name 
			FROM user_circles AS UserCircle 
			LEFT JOIN circles AS Circle ON (UserCircle.circle_id = Circle.id) 
			LEFT JOIN users AS User ON (Circle.user_id = User.id) 
			WHERE  UserCircle.user_id = $userId");
		$this->set('circles', $circles);
	}

/**
 * agregar un circulo nuevo
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Circle->create();
			$data = $this->request->data;
			$userEntityId = $this->Session->read('UserAuth.User.entity_id');
			$path = $this->Entity->getPath($userEntityId);
			if (!isset($path[1]['Entity']['id']) || empty($path[1]['Entity']['id'])){
				$message = 'El círculo no pudo ser guardado. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			}
			$data['Circle']['user_id'] = $this->Session->read('UserAuth.User.id');
			$data['Circle']['entity_id'] = $path[1]['Entity']['id'];
			if ($this->Circle->save($data)) {
				$uc['user_id'] = $this->Session->read('UserAuth.User.id');
				$uc['circle_id'] = $this->Circle->getLastInsertID();
				$this->UserCircle->create();
				$this->UserCircle->save($uc);
				$message = 'El círculo ha sido guardado';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'El círculo no pudo ser guardado. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			}
		}
	}

/**
 * editar un circulo creado por el usuario logueado
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Circle->exists($id)) {
			throw new NotFoundException(__('Invalid circle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Circle->save($this->request->data)) {
				$message = 'El círculo ha sido guardado';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'El círculo no pudo ser guardado. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
			}
		} else {
			$options = array('conditions' => array('Circle.' . $this->Circle->primaryKey => $id));
			$circle =  $this->Circle->find('first', $options);
			$this->set('circle', $circle);
		}
	}

	/*
	 * obtener un circulo por el id obtenido por get
	 */
	public function getCircleById(){
		$this->autoRender = false;
		$this->Circle->recursive = 2;
		if ($this->request->is('post')) {
			$id = $this->request->data['id'];
			$circle = $this->Circle->find('all', array(
				'conditions' => array(
					'Circle.id' => $id
					)
				)
			);
			return json_encode($circle);
		}
	}
	
	/*
	 * agregar un usuario al circulo
	 */
	public function addUserToCircle(){
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$this->UserCircle->recursive = -1;
			$data = $this->request->data;
			$circleId = $data['circle'];
			foreach ($data['users'] as $key => $userId) {
				$ud['user_id'] = $userId;
				$ud['circle_id'] = $circleId;
				$ucId = $this->UserCircle->find('count' , array ('conditions' => array ('UserCircle.circle_id' => $circleId , 'UserCircle.user_id' => $userId)));
				if ($ucId){
					
				}
				else{
				$this->UserCircle->create();
				if ($this->UserCircle->save($ud)){

				}
				else {
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error en la operación. Intente de nuevo.';
					return json_encode($a);
				}
				}
			}
			$a['Request']['status'] = 200;
			$a['Request']['message'] = 'Usuarios agregados sastifactoriamente';
			return json_encode($a);
		}
	}

	/*
	 * eliminar un usuario del circulo
	 */
	public function deleteUserFromCircle(){
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$circleId = $data['circle'];
			$this->UserCircle->recursive = -1;
			foreach ($data['users'] as $key => $userId) {
				$ucId = $this->UserCircle->findByCircleIdAndUserId($circleId, $userId);
				if ($this->UserCircle->delete($ucId['UserCircle']['id'])){

				}
				else {
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error en la operación. Intente de nuevo.';
					return json_encode($a);
				}
			}
			$a['Request']['status'] = 200;
			$a['Request']['message'] = 'Usuarios eliminados sastifactoriamente del círculo';
			return json_encode($a);
		}
	}

	/*
	 * salirse del circulo el usuario logueado
	 */
	public function outFromCircle(){
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$circleId = $data['circle'];
			$userId = $this->Session->read('UserAuth.User.id');
			$this->UserCircle->recursive = -1;
			$ucId = $this->UserCircle->findByCircleIdAndUserId($circleId, $userId);
			if ($this->UserCircle->delete($ucId['UserCircle']['id'])){
				$a['Request']['status'] = 200;
				$a['Request']['message'] = 'Has salido del círculo sastifactoriamente.';
				return json_encode($a);
			}
			else {
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Error en la operación. Intente de nuevo.';
				return json_encode($a);
			}
		}
	}

	/*
	 * encontrar los usuarios de un circulo
	 */
	public function findPeopleByCircle($idCircle) {
		$this->autoRender = false;
		
		$usersid = $this->Circle->getIdUsersFromCircleId($idCircle);
		
		$users = $this->User->find('all', array('conditions' => array('User.id' => $usersid, 'User.active' => 1)));

		foreach ($users as $key => $user) {
			$paths = $this->Entity->getPath($user['User']['entity_id']);
			$path = '';
			unset($paths[0]);
			unset($paths[1]);
			if (!empty($paths)) { 
				foreach ($paths as $k => $p) {
					$path = $path.' - '.$p['Entity']['name'];
				}
			}
			$users[$key]['path'] = $path;
		}
		return json_encode($users);
	}
}
