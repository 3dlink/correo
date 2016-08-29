<?php
App::uses('AppController', 'Controller');
/**
 * Redirections Controller
 *
 * @property Redirection $Redirection
 */
class RedirectionsController extends AppController {

	var $uses = array('Usermgmt.User', 'Entity', 'Redirection');
   // public $helpers = array('Minify.Minify' );

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$userId = $this->Session->read('UserAuth.User.id');
		$users = $this->Redirection->findToUsers($userId);

		foreach ($users as $key => $user) {
			$path = $this->Entity->getPath($user['ToUser']['entity_id']);
			unset($path[0]);
			$users[$key]['Path'] = $path;
		}
		$this->set('users', $users);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$userId = $this->Session->read('UserAuth.User.id');

			if ($data['type'] == 'entity'){
				$ents = $this->Entity->getAllDescentIds($data['to_user_id']);
				$users = $this->User->find('all', array(
					'conditions' => array(
						'entity_id' => $ents
						)
					)
				);
				
				//$users = $this->User->getUsersFromEntity($receive['id']);
				foreach ($users as $key => $user) {

					$t['to_user_id'] =$user['User']['id'];
					$t['from_user_id'] = $userId;
					$this->Redirection->create();
					if ($this->Redirection->save($t)) {
					}
					else {
						//error
						$a['Request']['status'] = 300;
						$a['Request']['message'] = 'Error tratando de guardar. Intente de nuevo.';
						return json_encode($a);
					}
				}
				$a['Request']['status'] = 200;
				$a['Request']['message'] = 'Operación realizada con éxito';
				return json_encode($a);
			}
			else {
				$t['to_user_id'] =$data['to_user_id'];
				$t['from_user_id'] = $userId;
				if ($this->Redirection->save($t)) {
					$a['Request']['status'] = 200;
					$a['Request']['message'] = 'Operación realizada con éxito';
					return json_encode($a);
				}
				else {
					//error
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error tratando de guardar. Intente de nuevo.';
					return json_encode($a);
				}
			}
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->autoRender = false;
		$new = $this->request->data['new'];
		$type = $this->request->data['type'];
		$data = $this->request->data;
		$userId = $this->Session->read('UserAuth.User.id');

		if ($type == 'entity') {
			$ents = $this->Entity->getAllDescentIds($data['to_user_id']);
			$users = $this->User->find('all', array(
				'conditions' => array(
					'entity_id' => $ents
					)
				)
			);
			
			//$users = $this->User->getUsersFromEntity($receive['id']);
			foreach ($users as $key => $user) {
				if ($this->Redirection->deleteAll(array('to_user_id' => $user['User']['id'], 'from_user_id' => $userId))) {
					// exito
				}
				else {
					//error
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error tratando de eliminar. Intente de nuevo.';
					return json_encode($a);
				}
			}
			$a['Request']['status'] = 200;
			$a['Request']['message'] = 'Operación realizada con éxito';
			return json_encode($a);

		}
		else {
			if ($this->Redirection->deleteAll(array('to_user_id' => $id, 'from_user_id' => $userId))) {
				$a['Request']['status'] = 200;
				$a['Request']['message'] = 'Operación realizada con éxito';
				return json_encode($a);
			}
		}
		$a['Request']['status'] = 300;
		$a['Request']['message'] = 'No se pudo culminar la operación. Intentelo de nuevo.';
		return json_encode($a);
	}
	
	public function redirectCommunication ($id = null){
		$this->autoRender = false;
		$this->User->id = $this->Session->read('UserAuth.User.id');
		$this->User->savefield("redirect_only",$id);
		$this->Session->write('UserAuth.User.redirect_only', $id);
		return $id;
	}
}
