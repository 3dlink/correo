<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {
	var $uses = array('Group','Groupi' ,'Usermgmt.User', 'Entity');
   // public $helpers = array('Minify.Minify' );

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Group->recursive = 0;
		$user = $this->Session->read('UserAuth.User.entity_id');
		if($user == 0){
			$this->set('groups', $this->paginate());
		}
		else{
			$grup = array('Group.entity_id' => $user);
			$this->set('groups', $this->paginate($grup));
		}
		
	}


/**
 * add method
 *
 * @return void
 */
	public function eject() {


		$this->autoRender = false;

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$circleId = $data['circle'];
			$this->User->recursive = -1;
			foreach ($data['users'] as $key => $userId) {
				$ucId = $this->User->findById($userId);
				$ucId['User']['groupi_id'] = '';
				if ($this->User->save($ucId)){

				}
				else {
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error en la operación. Intente de nuevo.';
					return json_encode($a);
				}
			}
			$a['Request']['status'] = 200;
			$a['Request']['message'] = 'Usuario(s) eliminado(s) sastifactoriamente del grupo';
			return json_encode($a);
		}

		// $this->autoRender = false;
		// $user = $this->User->findById($id);
		// $user['User']['group_id'] = 'null';  
		// if($this->User->save($user)){
		// 	$message = 'El usuario ya no pertenece al grupo';
		// 	$element = 'm_success';
		// 	$this->Session->setFlash($message, $element);
		// 	//$this->redirect(array('action' => 'index'));
		// }
	}

public function addPeopleGroup(){
	$this->autoRender = false;
		if ($this->request->is('post')) {
			$this->Groupi->recursive = -1;
			$data = $this->request->data;
			$circleId = $data['circle'];
			foreach ($data['users'] as $key => $userId) {
				$exist = $this->Groupi->find('first', array('conditions' => array('Groupi.user_id' => $userId, 'Groupi.group_id' => $circleId)));
				if(empty($exist)){
					$ucId['Groupi']['user_id'] = $userId;
					$ucId['Groupi']['group_id'] = $circleId;
						if ($this->Groupi->save($ucId)){

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

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$user = $this->Session->read('UserAuth.User.entity_id');
			if($user != 0){
				$parent = $this->Entity->getPath($user);
				$this->request->data['Group']['entity_id'] = $parent[1]['Entity']['id'];
				$this->request->data['Group']['type'] = 2;
			}
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$message = 'El grupo ha sido guardado';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'El grupo no pudo ser guardado. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$message = 'El grupo ha sido guardado';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'El grupo no pudo ser guardado. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$group =  $this->Group->find('first', $options);
			$this->set('group', $group);
			
		}
	}


	public function findPeopleByGoup($idGroup) {
		# code...
		$this->autoRender = false;
		$users = $this->User->find('all', array('conditions' => array('User.active' => 1 , 'group_id' => $idGroup)));
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
		$findIds = $this->Groupi->find('all', array( 'fields' => array('user_id') ,'conditions' => array('Groupi.group_id' => $idGroup)));
		foreach ($findIds as $ki => $v) {
			$usersi = $this->User->findById($v['Groupi']['user_id']);
			$paths = $this->Entity->getPath($usersi['User']['entity_id']);
			$path = '';
			unset($paths[0]);
			unset($paths[1]);
			if (!empty($paths)) { 
				foreach ($paths as $k => $p) {
					$path = $path.' - '.$p['Entity']['name'];
				}
			}
			$usersi['path'] = $path;
			array_push($users, $usersi);

		}
		return json_encode($users);
	}
}
