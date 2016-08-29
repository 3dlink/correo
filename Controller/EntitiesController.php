<?php
App::uses('AppController', 'Controller');
/**
 * Entities Controller
 *
 * @property Entity $Entity
 */
class EntitiesController extends AppController {

	var $uses = array('Usermgmt.User', 'Entity');
	public $helpers = array('FileUpload.UploadForm');
	public $components = array('FileUpload.Upload');
	//public $helpers = array('Minify.Minify' );

/**
 * index method
 *
 * @return void
 */
	public function index() {
if ($this->Session->read('UserAuth.User.user_group_id') == 1){
			$entities=$this->Entity->getParents();
		}
		if ($this->Session->read('UserAuth.User.user_group_id') == 3){
			$entityIdAdmin = $this->Session->read('UserAuth.User.entity_id');
			$entities=$this->Entity->getParents($entityIdAdmin);
		}
		for ($i=0; $i < count($entities) ; $i++) { 
			$idEntity = $entities[$i]['Entity']['id'];
			$entities2 = $this->Entity->getAllEntitiesDescendents($idEntity);
				$arr = $this->User->find('all', array('conditions' => array('AND'=>array('User.entity_id' => $idEntity, 'User.active'=>1, 'User.user_group_id'=>'2'))));
				foreach ($entities2 as $key => $entity) {
					$users = $this->User->find('all', array('conditions' => array('AND'=>array('User.entity_id' => $entity, 'User.active'=>1, 'User.user_group_id'=>'2'))));
					
					$arr = array_merge($arr, $users);
				}
				foreach ($arr as $key => $user) {
					$paths = $this->Entity->getPath($user['User']['entity_id']);
					$path = '';
					unset($paths[0]);
					if (!empty($paths)) { 
						foreach ($paths as $k => $p) {
							$path = $path.' - '.$p['Entity']['name'];
						}
					}
					$arr[$key]['path'] = $path;
				}
			if ($arr == null) {
				$entities[$i]['people']=0;
			}
			else{
				$entities[$i]['people']=(count($arr));
			}
		}


	$this->set('entities', $entities);
	}

	public function orderTree($order){
		$this->autoRender = false;
		$order=explode(",", $order);
		foreach ($order as $key => $value) {
			$this->Entity->recursive = 0;
			$entidad = $this->Entity->find('first', array('conditions'=>array('Entity.id'=>$value)));
			$entidad['Entity']['order'] = $key+1;
			$this->Entity->save($entidad);
		}
		return json_encode("1");
	}

	public function newParent(){
		$this->autoRender = false;
		$userEntity = $this->Session->read('UserAuth.User.entity_id');
		
		$children = $this->Entity->getAllEntitiesDescendents($userEntity);

		foreach ($children as $key => $value) {
			$entitys = $this->Entity->find('first',array('conditions'=>array('Entity.id' => $value)));
			$name[$key] = $entitys['Entity']['name'];
			$id[$key] = $entitys['Entity']['id'];
		}
		arsort($name);
		$xx = 0;
		foreach ($name as $key => $value) {
			$name2[$xx] =$value;
			$id2[$xx] = $id[$key]; 
			$xx = $xx +1; 
		}

		$compact[0] = $name2;
		$compact[1] = $id2;
		$this->Entity->recursive = 0;
		$compact[2] = $userEntity;
		$nameEntity = $this->Entity->find('first' , array('conditions' => array('Entity.id' => $userEntity), 'fields' => array('Entity.name')));
		$compact[3] = $nameEntity['Entity']['name'];
	
		return json_encode($compact);  
	}

	public function children($idParent){
		$this->autoRender = false;
		if ($this->request->is('get')) {
			$children = $this->Entity->getChildren($idParent);
			for ($i=0; $i < count($children) ; $i++) { 
				$idEntity = $children[$i]['Entity']['id'];
				$entities = $this->Entity->getAllEntitiesDescendents($idEntity);
				$arr = $this->User->find('all', array('conditions' => array('AND'=>array('User.entity_id' => $idEntity, 'User.active'=>1, 'User.user_group_id'=>'2'))));
				foreach ($entities as $key => $entity) {
					$users = $this->User->find('all', array('conditions' => array('AND'=>array('User.entity_id' => $entity, 'User.active'=>1, 'User.user_group_id'=>'2'))));
					$arr = array_merge($arr, $users);
				}
				foreach ($arr as $key => $user) {
					$paths = $this->Entity->getPath($user['User']['entity_id']);
					$path = '';
					unset($paths[0]);
						if (!empty($paths)) { 
							foreach ($paths as $k => $p) {
							$path = $path.' - '.$p['Entity']['name'];
						}
						}
					$arr[$key]['path'] = $path;
					}
				if ($arr == null) {
					$children[$i]['people']=0;
				}
				else{
					$children[$i]['people']=(count($arr));
				}
			}
			return json_encode($children);
		}
			return json_encode('error');
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$this->Entity->create();
			if ($this->Entity->save($this->request->data)) {
				$idEntity = $this->Entity->getLastInsertID();
				$entity = $this->Entity->findById($idEntity);
				$entity['Request']['status'] = 200;
				$entity['Request']['message'] = 'La entidad ha sido guardada';
			} else {
				$entity['Request']['status'] = 300;
				$entity['Request']['message'] = 'La entidad no pudo ser guardada. Intente nuevamente.';
			}
		}
		return json_encode($entity);
	}

	public function edit($id = null) {
		$this->autoRender = false;
		if ($this->request->is('get')) {
			//$id = $this->request->data['id'];
			$this->Entity->recursive = -1;
			$entity = $this->Entity->findById($id);
			if (!empty($entity)) {
				$entity['Request']['status'] = 200;
				$entity['Request']['message'] = 'Entidad encontrada';
				$entity['Entity'] = $entity['Entity'];
			} else {
				$entity['Request']['status'] = 300;
				$entity['Request']['message'] = 'Error al encontrar la entidad';
			}
			return json_encode($entity);
		}

		if ($this->request->is('post')) {
			if ($this->Entity->save($this->request->data)) {
				$idEntity = $this->Entity->getLastInsertID();
				$entity = $this->Entity->findById($idEntity);
				$entity['Request']['status'] = 200;
				$entity['Request']['message'] = 'La entidad ha sido guardada';
			} else {
				$entity['Request']['status'] = 300;
				$entity['Request']['message'] = 'La entidad no pudo ser guardada. Intente nuevamente.';
			}
		}
		return json_encode($entity);
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
		$admin = $this->User->find('first', array('conditions' => array('AND'=>array('User.entity_id' => $id, 'User.user_group_id'=>3))));
		if ($admin) {
			$this->User->delete($admin['User']['id']);
		}
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$entity = $this->Entity->findById($id);
			$entity['Entity']['active'] = 0;
			$entity['Entity']['parent_id']=0;
			if ($this->Entity->save($entity)) {
				$out['Request']['status'] = 200;
				$out['Request']['message'] = 'La entidad ha sido eliminada';
			} else {
				$out['Request']['status'] = 300;
				$out['Request']['message'] = 'No se pudo eliminar la entidad. Intente nuevamente';
			}
		}
		else {
			$out['Request']['status'] = 300;
			$out['Request']['message'] = 'Operación no permitida';
		}
		return json_encode($out);
	}

	// buscar entidades por nombre parecidos
	public function find(){
		$q = $_POST['q'];
		$this->autoRender = false;
		$entities = $this->Entity->find('all', array(
			'conditions' => array(
				'Entity.name LIKE' => '%'.$q.'%',
				),
			)
		);
		return json_encode($entities);
	}

	// obtiene todas las personas bajo un nodo padre. 
	// Incluye hijos de los hijos y asi
	public function findAllPeople($idEntity){
		$usuario = array();
		$count = -1;
		$this->autoRender = false;
			# code...
		$childrens = $this->Entity->children($idEntity);
		if(!empty($childrens)){
			end($childrens);         // move the internal pointer to the end of the array
			$lastkey = key($childrens);
			$childrens[$lastkey+1]['Entity']['id'] = $idEntity;
			foreach ($childrens as $keys => $value) {
				$users = $this->User->find('all', array('conditions' => array('User.active' =>1 ,'User.entity_id' => $value['Entity']['id'])));
				
				foreach ($users as $key => $user) {
					$count ++;
					$paths = $this->Entity->getPath($user['User']['entity_id']);
					$path = '';
					unset($paths[0]);
					unset($paths[1]);
					if (!empty($paths)) { 
						foreach ($paths as $k => $p) {
							$path = $path.' - '.$p['Entity']['name'];
						}
					}
					$usuario[$count] = $user;
					$usuario[$count]['path'] = $path;
				}
			}
				return json_encode($usuario);
		}
		else{
			$users = $this->User->find('all', array('conditions' => array('User.active' =>1, 'User.entity_id' => $idEntity)));
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
	
	public function uploadImage(){
		$this->autoRender = false;
	
	}
}
