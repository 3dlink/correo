<?php
/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

App::uses('UserMgmtAppController', 'Usermgmt.Controller');

class UsersController extends UserMgmtAppController {
	/**
	 * This controller uses following models
	 * 
	 * @var array
	 */
	public $uses = array('Usermgmt.User', 'Usermgmt.UserGroup', 'Usermgmt.LoginToken', 'Entity', 'Communication', 'Tag','CommunicationCategory','CommunicationType', 'Group', 'Circle');
	//public $helpers = array('Minify.Minify' );
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->User->userAuth=$this->UserAuth;
	}
	/**
	 * Used to display all users by Admin
	 *
	 * @access public
	 * @return array
	 */
	public function index() {
		// si es el super admin, busco todos los usuarios
		if ($this->Session->read('UserAuth.User.user_group_id') == 1){
			$this->User->unbindModel( array('hasMany' => array('LoginToken')));
			$users=$this->User->find('all', array(
				'conditions'=> array(
					'user_group_id' => 3,
					'visible' => 1
					),
				'order'=>'User.first_name ASC',
				)
			);
		}
		// si es un administrador, busco sus usuarios
		if ($this->Session->read('UserAuth.User.user_group_id') == 3){
			$this->User->unbindModel( array('hasMany' => array('LoginToken')));
			$entityIdAdmin = $this->Session->read('UserAuth.User.entity_id');

			$listEntities = $this->Entity->getAllDescentIds($entityIdAdmin);
			
			array_push($listEntities, $entityIdAdmin);
			
			$users = array();
			foreach ($listEntities as $key => $idEntity) {
				$usrs = $this->User->getUsersFromEntity($idEntity);
				$users = array_merge($users, $usrs);
			}
			foreach ($users as $key => $value) {
				$names[$key]= $value['User']['first_name'];
			}
			array_multisort($names, SORT_ASC,  $users);
		}
		$this->set('users', $users);
	}
	/**
	 * Used to display detail of user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return array
	 */
	public function viewUser($userId=null) {
		if (!empty($userId)) {
			$user = $this->User->read(null, $userId);
			$this->set('user', $user);
		} else {
			$this->redirect('/allUsers');
		}
	}
	/**
	 * Used to display detail of user by user
	 *
	 * @access public
	 * @return array
	 */
	public function myprofile() {
		$userId = $this->UserAuth->getUserId();
		$user = $this->User->read(null, $userId);
		$paths = $this->Entity->getPath($user['User']['entity_id']);
		$path = '';
		unset($paths[0]);
		if (!empty($paths)){
			foreach ($paths as $k => $p) {
				$path = $path.' - '.$p['Entity']['name'];
			}
		}
		$user['path'] = $path;
		$this->set('user', $user);
	}
	/**
	 * Used to logged in the site
	 *
	 * @access public
	 * @return void
	 */
	public function login() {
		$this->layout = false;
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if($this->User->LoginValidate()) {
				$email  = $this->data['User']['email'];
				$password = $this->data['User']['password'];

				$user = $this->User->findByUsername($email);
				if (empty($user)) {
					$user = $this->User->findByEmail($email);
					if (empty($user)) {
						$message = 'Correo/Usuario o contraseña invalidos';
						$element = 'm_error_login';
						$this->Session->setFlash($message, $element);
						$this->redirect('/login');
						$this->redirect('/');

						//return;
					}
				}
				// check for inactive account
				if ($user['User']['id'] != 1 and $user['User']['active']==0) {
					$message = 'Cuenta inactiva, contacta al administrador del sistema';
					$element = 'm_error_login';
					$this->Session->setFlash($message, $element);
					return;
				}
				// check for verified account
				if ($user['User']['id'] != 1 and $user['User']['email_verified']==0) {
					$this->Session->setFlash(__('Your registration has not been confirmed please verify your email or contact to Administrator'));
					return;
				}
				if(empty($user['User']['salt'])) {
					$hashed = md5($password);
				} else {
					$hashed = $this->UserAuth->makePassword($password, $user['User']['salt']);
				}
				if ($user['User']['password'] === $hashed) {
					
					$user['User']['attempts'] = 0;
					
					if(empty($user['User']['salt'])) {
						$salt=$this->UserAuth->makeSalt();
						$user['User']['salt']=$salt;
						$user['User']['password']=$this->UserAuth->makePassword($password, $salt);
					}
					$this->UserAuth->login($user);
					
					$this->User->save($user,false);

					$remember = (!empty($this->data['User']['remember']));
					if ($remember) {
						$this->UserAuth->persist('2 weeks');
					}
					$this->Session->delete('tags');
					$tags = $this->Tag->findPopularTagsByUser($user['User']['id']);
					$this->Session->write('tags', $tags);
					/*
					$this->Session->delete('communicationCategories');
					$communicationCategories = $this->CommunicationCategory->find('all', array(
						'conditions' => array('CommunicationCategory.active' => '1' ))
					);
					$this->Session->write('communicationCategories', $communicationCategories);

					$this->Session->delete('communicationTypes');
					$communicationTypes = $this->CommunicationType->find('all', array(
						'conditions' => array('CommunicationType.active' => '1' ))
					);
					$this->Session->write('communicationTypes', $communicationTypes);
					*/
					if ($user['User']['user_group_id'] == 2) {
						$this->redirect('/communications/index');
					}
					elseif($user['User']['user_group_id'] == 1 || $user['User']['user_group_id'] == 3) {
						$this->redirect('/dashboard/');
					}
					
				} else {
					// debug($user);
					$user['User']['attempts'] = $user['User']['attempts'] + 1;
					if($user['User']['attempts'] >= 3){
						$user['User']['active'] = 0;
						$message = 'Usuario inactivo, por favor comuniquese con el administrador del sistema para la reactivación del mismo.';
						$userAdmin = $this->User->find('first', array('conditions' => array('User.entity_id' => $user['User']['entity_id'], 'User.user_group_id' => 3)));
						$this->User->sendMailActive($user, $userAdmin);
					}
					else{
						$message = 'Correo/usuario o contraseña incorrectos';
					}
					$this->User->save($user);

					$element = 'm_error_login';
					$this->Session->setFlash($message, $element);
					return;
				}
			}
		}
	}
	/**
	 * Used to logged out from the site
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->UserAuth->logout();
		//$this->Session->setFlash(__('You are successfully signed out'));
		$this->redirect(LOGOUT_REDIRECT_URL);
	}
	/**
	 * Used to register on the site
	 *
	 * @access public
	 * @return void
	 */
	public function register() {
		$userId = $this->UserAuth->getUserId();
		if ($userId) {
			$this->redirect("/dashboard");
		}
		if (SITE_REGISTRATION) {
			$userGroups=$this->UserGroup->getGroupsForRegistration();
			$this->set('userGroups', $userGroups);
			if ($this->request -> isPost()) {
				if(USE_RECAPTCHA && !$this->RequestHandler->isAjax()) {
					$this->request->data['User']['captcha']= (isset($this->request->data['recaptcha_response_field'])) ? $this->request->data['recaptcha_response_field'] : "";
				}
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {
					if (!isset($this->data['User']['user_group_id'])) {
						$this->request->data['User']['user_group_id']=DEFAULT_GROUP_ID;
					} elseif (!$this->UserGroup->isAllowedForRegistration($this->data['User']['user_group_id'])) {
						$this->Session->setFlash(__('Please select correct register as'));
						return;
					}
					$this->request->data['User']['active']=1;
					if (!EMAIL_VERIFICATION) {
						$this->request->data['User']['email_verified']=1;
					}
					$ip='';
					if(isset($_SERVER['REMOTE_ADDR'])) {
						$ip=$_SERVER['REMOTE_ADDR'];
					}
					$this->request->data['User']['ip_address']=$ip;
					$salt=$this->UserAuth->makeSalt();
					$this->request->data['User']['salt'] = $salt;
					$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password'], $salt);
					$this->User->save($this->request->data,false);
					$userId=$this->User->getLastInsertID();
					$user = $this->User->findById($userId);
					if (SEND_REGISTRATION_MAIL && !EMAIL_VERIFICATION) {
						$this->User->sendRegistrationMail($user);
					}
					if (EMAIL_VERIFICATION) {
						$this->User->sendVerificationMail($user);
					}
					if (isset($this->request->data['User']['email_verified']) && $this->request->data['User']['email_verified']) {
						$this->UserAuth->login($user);
						$this->redirect('/');
					} else {
						$this->Session->setFlash(__('Please check your mail and confirm your registration'));
						$this->redirect('/register');
					}
				}
			}
		} else {
			$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
			$this->redirect('/login');
		}
	}
	/**
	 * Used to change the password by user
	 *
	 * @access public
	 * @return void
	 */
	public function changePassword() {
		$userId = $this->UserAuth->getUserId();
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if ($this->User->RegisterValidate()) {
				if(strlen($this->data['User']['password']) < 8 && ereg("([A-Z])", $this->request->data['User']['password']) && ereg("([a-z])", $this->request->data['User']['password']) && ereg("([0-9])", $this->request->data['User']['password']) && ereg("([-#&@!?_.])", $this->request->data['User']['password'])){
					$user=array();
					$user['User']['id']=$userId;
					$salt=$this->UserAuth->makeSalt();
					$user['User']['salt'] = $salt;
					$user['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password'], $salt);
					$this->User->save($user,false);
					$this->LoginToken->deleteAll(array('LoginToken.user_id'=>$userId), false);
					$message = 'Contraseña cambiada correctamente';
					$element = 'm_success';
					$this->Session->setFlash($message, $element);
					$this->redirect('/dashboard');
				}
				else{
					$message = 'La contraseña debe al menos una letra mayúscula, una letra minúscula, un número o carácter especial (<b>- # & @ ! ? _ .</b>), como mínimo 8 caracteres';
					// $element = 'bad';
					$this->Session->setFlash($message);
				}
			}
		}
	}
	/**
	 * Used to change the user password by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function changeUserPassword($userId=null) {
		if (!empty($userId)) {
			$userA = $this->User->findById($userId);
			$user['User']['id'] = $userId;
			$user['User']['first_name'] = $userA['User']['first_name'];
			$user['User']['last_name'] = $userA['User']['last_name'];
			$name=$this->User->getNameById($userId);
			$this->set('user', $user);
			if ($this->request -> isPost()) {
				if(strlen($this->data['password']) < 8 && ereg("([A-Z])", $this->request->data['password']) && ereg("([a-z])", $this->request->data['password']) && ereg("([0-9])", $this->request->data['password']) && ereg("([-#&@!?_.])", $this->request->data['password'])){
					
					if ($this->data['password'] == '' || $this->data['password'] == ''){
						$message = 'Debe llenar los campos';
						$element = 'm_error';
						$this->Session->setFlash($message, $element);
					}
					if ($this->data['password'] != $this->data['cpassword']){
						$message = 'La contraseñas no coinciden';
						$element = 'm_error';
						$this->Session->setFlash($message, $element);
					}
					$this->User->set($this->data);

					if($this->User->RegisterValidate()) {
						$user=array();
						$user['User']['id']=$userId;
						$salt=$this->UserAuth->makeSalt();
						$user['User']['salt'] = $salt;
						$user['User']['password'] = $this->UserAuth->makePassword($this->request->data['password'], $salt);
						$this->User->save($user,false);
						$this->LoginToken->deleteAll(array('LoginToken.user_id'=>$userId), false);
						$message = 'Contraseña de '.$name.' cambiada correctamente';
						$element = 'm_success';
						$this->Session->setFlash($message, $element);
						$this->redirect('/allUsers');
					}
				}
				else{
					$message = 'La contraseña debe al menos una letra mayúscula, una letra minúscula, un número o carácter especial (<b>- # & @ ! ? _ .</b>), como mínimo 8 caracteres';
					$this->Session->setFlash($message);
				}			
			}
		} else {
			$this->redirect('/allUsers');
		}
	}
	/**
	 * Used to change the user password first time
	 *
	 * @access public
	 * @return void
	 */
	public function setPassword() {
		$this->autoRender = false;
		$userId = $this->Session->read('UserAuth.User.id');
		if (!empty($userId)) {
			$userA = $this->User->findById($userId);
			$user['User']['id'] = $userId;
			$user['User']['first_name'] = $userA['User']['first_name'];
			$user['User']['last_name'] = $userA['User']['last_name'];
			//$name=$this->User->getNameById($userId);
			$this->set('user', $user);
			if ($this->request -> isPost()) {
				if(strlen($this->data['password']) < 8 && ereg("([A-Z])", $this->request->data['password']) && ereg("([a-z])", $this->request->data['password']) && ereg("([0-9])", $this->request->data['password']) && ereg("([-#&@!?_.])", $this->request->data['password'])){
					if ($this->data['password'] == '' || $this->data['password'] == ''){
						$r['Request']['status'] = 300;
						$r['Request']['message'] = 'Debe llenar los campos';
						return json_encode($r);
					}
					if ($this->data['password'] != $this->data['cpassword']){
						$r['Request']['status'] = 300;
						$r['Request']['message'] = 'La contraseñas no coinciden';
						return json_encode($r);
					}

					if(empty($userA['User']['salt'])) {
						$hashed = md5($password);
					} else {
						$hashed = $this->UserAuth->makePassword($this->data['password'], $userA['User']['salt']);
					}
					if ($userA['User']['password'] === $hashed) {
						$r['Request']['status'] = 300;
						$r['Request']['message'] = 'La contraseñas no debe ser igual a la asignada.';
						return json_encode($r);
					}

					$this->User->set($this->data);

					if($this->User->RegisterValidate()) {
						$user=array();
						$user['User']['id']=$userId;
						$user['User']['first_time']= 0;
						$this->Session->write('UserAuth.User.first_time', '0');
						$salt=$this->UserAuth->makeSalt();
						$user['User']['salt'] = $salt;
						$user['User']['password'] = $this->UserAuth->makePassword($this->request->data['password'], $salt);
						$this->User->save($user,false);
						$this->LoginToken->deleteAll(array('LoginToken.user_id'=>$userId), false);
						$r['Request']['status'] = 200;
						$r['Request']['message'] = 'La contraseña ha sido establecida correctamente';
						return json_encode($r);
					}
				}else{
					$message = 'La contraseña debe al menos una letra mayúscula, una letra minúscula, un número o carácter especial (<b>- # & @ ! ? _ .</b>), como mínimo 8 caracteres';
					$this->Session->setFlash($message);
				}
			}
		} else {
			// $this->autoRender = false;
			$r['Request']['status'] = 300;
			$r['Request']['message'] = 'No es posible realizar esta accion';
			return json_encode($r);
		}
	}
	/**
	 * Used to add user on the site by Admin
	 *
	 * @access public
	 * @return void
	 */
	public function addUser(){

		if ($this->Session->read('UserAuth.User.user_group_id') == 3){
			$userGroups=$this->UserGroup->find('list', array(
				'fields' => array('name'),
				'conditions' => array(
					'UserGroup.id !=' => '1')
				)
			);
		}
		if ($this->Session->read('UserAuth.User.user_group_id') == 1){
			$userGroups=$this->UserGroup->find('list', array(
				'fields' => array('name'),
				'conditions' => array(
					'UserGroup.id !=' => '2')
				)
			);
		}
		
		if ($this->Session->read('UserAuth.User.user_group_id') == 1){
			$entities=$this->Entity->getParents();
		}
		if ($this->Session->read('UserAuth.User.user_group_id') == 3){
			$entityIdAdmin = $this->Session->read('UserAuth.User.entity_id');
			$entities=$this->Entity->getParents($entityIdAdmin);
		}
		$this->Group->recursive = -1;

		$groups = $this->Group->find('list', array('conditions' => array('Group.active' => 1, 'Group.type' => 1)));
		$groups = array_merge(array('0' => 'Seleccione'), $groups);

		// $parent = $this->Entity->getPath($this->Session->read('UserAuth.User.entity_id'));
		// $groupsi = $this->Group->find('all', array('fields' => array('name' , 'id') ,'conditions' => array('Group.active' => 1, 'Group.type' => 2, 'Group.entity_id' => $parent[1]['Entity']['id'])));
		// $new[0] = 'Seleccione';

		// foreach ($groupsi as $k => $v) {
		// 	$new[$v['Group']['id']] = $v['Group']['name']; 
		// }

		$this->set('userGroups', $userGroups);
		$this->set('entities', $entities);
		$this->set('groups', $groups);
		//$this->set('groupsi', $new);


		if ($this->request -> isPost()) {

			if($_POST['script'] == 1){
				$this->autoRender = false;
				$user = $this->User->findByUsername($this->request->data['username']);
				if (!empty($user)){
					$usr['Request']['status'] = 300;
					$usr['Request']['message'] = 'Ya existe un registro con este nombre de usuario';
					return json_encode($usr);
				}
				$user = $this->User->findByEmail($this->data['email']);
				if (!empty($user)){
					$usr['Request']['status'] = 300;
					$usr['Request']['message'] = 'Ya existe un registro con este correo de usuario';
					return json_encode($usr);
				}
				$this->User->set($this->data);

				$pre = preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $this->data['email']);

				if($pre) {

				} else {
					$usr['Request']['message'] = 'Correo invalido.';
					$usr['Request']['status'] = 300;
					return json_encode($usr);
				} 
				$this->request->data['User']['email_verified']=1;
				$this->request->data['User']['active']=1;
				$salt=$this->UserAuth->makeSalt();
				$this->request->data['User']['salt'] = $salt;
				$this->request->data['User']['first_time'] = 1;
				$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['password'], $salt);
				$this->User->save($this->request->data,false);
				$usr['Request']['status'] = 200;
				$usr['Request']['message'] = 'Usuario creado satisfactoriamente';
				return json_encode($usr);
			}	
			else{
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {
					$this->request->data['User']['email_verified']=1;
					$this->request->data['User']['active']=1;
					$salt=$this->UserAuth->makeSalt();
					$this->request->data['User']['salt'] = $salt;
					$this->request->data['User']['first_time'] = 1;
					$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['password'], $salt);
					$message = 'Usuario creado satisfactoriamente';
					$this->Session->setFlash($message);
					$this->redirect('/addUser');
				}

			}		
		}
	}

	/**
	 * Used to edit user on the site by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function editUser($userId=null) {
		if (!empty($userId)) {
			$userGroups=$this->UserGroup->getGroups();
			$this->set('userGroups', $userGroups);
			$entities=$this->Entity->getParents();
			$this->set('entities', $entities);
			$user = $this->User->findById($userId);
			$this->set('user', $user);
			if ($this->request -> isPost()) {
				if($_POST['script'] == 1){
					$this->autoRender = false;
					$user = $this->User->findByUsername($this->request->data['username']);
					if (!empty($user) && $user['User']['id'] != $userId){
						$usr['Request']['status'] = 300;
						$usr['Request']['message'] = 'Ya existe un registro con este nombre de usuario';
						return json_encode($usr);
					}
					$user = $this->User->findByEmail($this->data['email']);
					if (!empty($user) && $user['User']['id'] != $userId){
						$usr['Request']['status'] = 300;
						$usr['Request']['message'] = 'Ya existe un registro con este correo de usuario';
						return json_encode($usr);
					}
					$this->User->set($this->data);
						$this->User->save($this->request->data,false);
						$usr['Request']['pepe'] = $this->request->data;
						$usr['Request']['status'] = 200;
						$usr['Request']['message'] = 'Usuario modificado satisfactoriamente';
						$message = 'Usuario actualizado satisfactoriamente';
						$element = 'm_success';
						$this->Session->setFlash($message, $element);
						return json_encode($usr);
				}
				else{
					$this->User->set($this->data);
					if ($this->User->RegisterValidate()) {
						$this->User->save($this->request->data,false);
						$message = 'Usuario actualizado satisfactoriamente';
						$this->Session->setFlash($message);
						$this->redirect('/allUsers');
					}
				}
			} else {
				$groups = $this->Group->find('list', array('conditions'=>array('Group.active' => 1)));
				$this->set('groups', $groups);
				$user = $this->User->findById($userId);
				$entityId = $user['User']['entity_id'];
				// buscar el path completo hasta el nodo raiz
				if (!empty($entityId)){
					$tree = $this->Entity->getPathComplete($entityId);
					$this->set('tree', $tree);
				}
				$this->request->data=null;
				if (!empty($user)) {
					$user['User']['password']='';
					$this->request->data = $user;
					$this->Group->recursive = -1;
					$grupi = $this->Group->find('first', array('conditions' => array('Group.id' => $user['User']['group_id']), 'fields' => array('id','name')));
					if (!empty($grupi)) {
						$groupi[$grupi['Group']['id']] = $grupi['Group']['name'];
						$user['Grupi'] = $groupi;

					}
					$parent = $this->Entity->getPath($this->Session->read('UserAuth.User.entity_id'));
					$grupoIns = $this->Group->find('all', array('fields' => array('name' , 'id') ,'conditions' => array('Group.active' => 1, 'Group.entity_id' => $parent[1]['Entity']['id'], 'Group.type' => 2)));
					$new = "";
					foreach ($grupoIns as $k => $v) {
						$new[$v['Group']['id']] = $v['Group']['name']; 
					}
					$this->set('groups_i', $new);
					$this->set('user', $user);
					
				}
			}
		} else {
			$this->redirect('/allUsers');
		}
	}
	/**
	 * Used to delete the user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function deleteUser($id = null) {
		if ($this->request -> isPost()) {
			$this->autoRender = false;
			$data = $this->request->data;
			$userId = $data['id'];
			$user = $this->User->findById($userId);
			$userx['User']['id'] = $userId;
			$userx['User']['active'] = 0;
			$userx['User']['visible'] = 0;
			$userx['User']['email'] = $user['User']['email'].'-delete';
			$userx['User']['username'] = $user['User']['username'].'-delete';
			if ($this->User->save($userx['User'])) {
				$usr['Request']['status'] = 200;
				$usr['Request']['message'] = 'Usuario eliminado satisfactoriamente';
			}
			else {
				$usr['Request']['status'] = 300;
				$usr['Request']['message'] = 'Error al tratar de eliminar el usuario';
			}
			return json_encode($usr);
		}
		$this->redirect('/allUsers');
	}
	/**
	 * Used to show dashboard of the user
	 *
	 * @access public
	 * @return array
	 */
	public function dashboard() {
		$userGroupId = $this->Session->read('UserAuth.User.user_group_id');
		if ($userGroupId == 2) {
			return $this->redirect('../../communications/index');
		}
		$userId=$this->UserAuth->getUserId();
		$user = $this->User->findById($userId);
		$this->set('user', $user);
	}
	/**
	 * Used to activate or deactivate user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @param integer $active active or inactive
	 * @return void
	 */
	public function makeActiveInactive($userId = null, $active=0) {
		if (!empty($userId)) {
			$user=array();
			$user['User']['id']=$userId;

			$user['User']['attempts']=0;

			$user['User']['active']=($active) ? 1 : 0;
			$this->User->save($user,false);
			if($active) {
				$message = 'Usuario activado satisfactoriamente';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
			} else {
				$message = 'Usuario desactivado satisfactoriamente';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
			}
		}
		$this->redirect('/allUsers');
	}
	/**
	 * Used to verify email of user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function verifyEmail($userId = null) {
		if (!empty($userId)) {
			$user=array();
			$user['User']['id']=$userId;
			$user['User']['email_verified']=1;
			$this->User->save($user,false);
			$this->Session->setFlash(__('User email is successfully verified'));
		}
		$this->redirect('/allUsers');
	}
	/**
	 * Used to show access denied page if user want to view the page without permission
	 *
	 * @access public
	 * @return void
	 */
	public function accessDenied() {

	}
	/**
	 * Used to verify user's email address
	 *
	 * @access public
	 * @return void
	 */
	public function userVerification() {
		if (isset($_GET['ident']) && isset($_GET['activate'])) {
			$userId= $_GET['ident'];
			$activateKey= $_GET['activate'];
			$user = $this->User->read(null, $userId);
			if (!empty($user)) {
				if (!$user['User']['email_verified']) {
					$password = $user['User']['password'];
					$theKey = $this->User->getActivationKey($password);
					if ($activateKey==$theKey) {
						$user['User']['email_verified']=1;
						$this->User->save($user,false);
						if (SEND_REGISTRATION_MAIL && EMAIL_VERIFICATION) {
							$this->User->sendRegistrationMail($user);
						}
						$this->Session->setFlash(__('Thank you, your account is activated now'));
					}
				} else {
					$this->Session->setFlash(__('Thank you, your account is already activated'));
				}
			} else {
				$this->Session->setFlash(__('Sorry something went wrong, please click on the link again'));
			}
		} else {
			$this->Session->setFlash(__('Sorry something went wrong, please click on the link again'));
		}
		$this->redirect('/login');
	}
	/**usuario
	 * Used to send forgot password email to user
	 *
	 * @access public
	 * @return void
	 */
	public function forgotPassword() {
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if ($this->User->LoginValidate()) {
				$email  = $this->data['User']['email'];
				$user = $this->User->findByUsername($email);
				if (empty($user)) {
					$user = $this->User->findByEmail($email);
					if (empty($user)) {
						$message_t = 'Correo incorrecto';
						$element = 'm_error_login';
						$this->Session->setFlash($message_t, $element);
						$this->redirect('/login');
					}
				}
				// check for inactive account
				if ($user['User']['id'] != 1 and $user['User']['email_verified']==0) {
					$message_t = 'Tu registro no ha sido confirmado. Por favor, verifica tu correo antes de reestablecer tu contraseña ';
					$element = 'm_success_login';
					$this->Session->setFlash($message_t, $element);
					return;
				}
				$this->User->forgotPassword($user);
				$message_t = 'Te hemos enviado un correo electrónico.Ingresa a tu buzón y sigue las instrucciones';
				$element = 'm_success_login';
				$this->Session->setFlash($message_t, $element);
				$this->redirect('/login');
			}
		}
	}
	/**
	 *  Used to reset password when user comes on the by clicking the password reset link from their email.
	 *
	 * @access public
	 * @return void
	 */
	public function activatePassword() {
		if ($this->request -> isPost()) {
			if (!empty($this->data['User']['ident']) && !empty($this->data['User']['activate'])) {
				$this->set('ident',$this->data['User']['ident']);
				$this->set('activate',$this->data['User']['activate']);
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {
					$userId= $this->data['User']['ident'];
					$activateKey= $this->data['User']['activate'];
					$user = $this->User->read(null, $userId);
					if (!empty($user)) {
						$password = $user['User']['password'];
						$thekey =$this->User->getActivationKey($password);
						if ($thekey==$activateKey) {
							if(strlen($this->data['password']) < 8 && ereg("([A-Z])", $this->request->data['password']) && ereg("([a-z])", $this->request->data['password']) && ereg("([0-9])", $this->request->data['password']) && ereg("([-#&@!?_.])", $this->request->data['password'])){
								$user['User']['password']=$this->data['User']['password'];
								$salt=$this->UserAuth->makeSalt();
								$user['User']['salt'] = $salt;
								$user['User']['password'] = $this->UserAuth->makePassword($user['User']['password'], $salt);
								$this->User->save($user,false);
								$message_t = 'Tu contraseña ha sido reestablecida correctamente';
								$element = 'm_success_login';
								$this->Session->setFlash($message_t, $element);
								$this->redirect('/login');
							}else{
								$message_t = 'La contraseña debe al menos una letra mayúscula, una letra minúscula, un número o carácter especial (<b>- # & @ ! ? _ .</b>), como mínimo 8 caracteres';
								$this->Session->setFlash($message_t);
							}
						} else {
							$message_t = 'Hubo un error, por favor envía de nuevo el link de activación';
							$element = 'm_error_login';
							$this->Session->setFlash($message_t, $element);
						}
					} else {
						$message_t = 'Hubo un error, por haz click sobre el link de reactivación de contraseña desde tu correo';
						$element = 'm_error_login';
						$this->Session->setFlash($message_t, $element);
					}
				}
			} else {
				$message_t = 'Hubo un error, por haz click sobre el link de reactivación de contraseña desde tu correo';
				$element = 'm_error_login';
				$this->Session->setFlash($message_t, $element);
			}
		} else {
			if (isset($_GET['ident']) && isset($_GET['activate'])) {
				$this->set('ident',$_GET['ident']);
				$this->set('activate',$_GET['activate']);
			}
		}
	}
	/**
	 * Used to send email verification mail to user
	 *
	 * @access public
	 * @return void
	 */
	public function emailVerification() {
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if ($this->User->LoginValidate()) {
				$email  = $this->data['User']['email'];
				$user = $this->User->findByUsername($email);
				if (empty($user)) {
					$user = $this->User->findByEmail($email);
					if (empty($user)) {
						$this->Session->setFlash(__('Incorrect Email/Username'));
						return;
					}
				}
				if($user['User']['email_verified']==0) {
					$this->User->sendVerificationMail($user);
					$this->Session->setFlash(__('Please check your mail to verify your email'));
				} else {
					$this->Session->setFlash(__('Your email is already verified'));
				}
				$this->redirect('/login');
			}
		}
	}

	// buscar usuarios con nombres parecidos
	public function findUsers($q){
		$this->User->autoRender = false;
		$this->recursive = -1;
		$users = $this->User->find('all', array(
			'options' => array(
				'OR' => array(
					'User.first_name LIKE' => '%'.$q.'%',
					'User.last_name LIKE' => '%'.$q.'%'
					),
				)
			)
		);
		return json_encode($users);
	}

	public function directory(){
		// query particluar
		if (isset($_GET['q'])){
			$q = $_GET['q'];
			$users = $this->User->find('all', array(
				'conditions' => array(
					'OR' => array(
						'User.first_name LIKE' => '%'.$q.'%',
						'User.last_name LIKE' => '%'.$q.'%'
						),
					'User.active' => '1'
					)
				)
			);
			$this->set('tab','p');
		}
		// por letra de apellido
		else if (isset($_GET['l'])){
			$l = $_GET['l'];
			$users = $this->User->find('all', array(
				'conditions' => array(
					'User.last_name LIKE' => $l.'%',
					'User.active' => '1'
					)
				)
			);
			$this->set('tab','p');
		}
		else {
			$users = $this->User->find('all', array(
				'conditions' => array(
					'User.last_name LIKE' => 'a%',
					'User.active' => '1'
					)
				)
			);
			$this->set('tab','p');
		};
		foreach ($users as $key => $user) {
			$paths = $this->Entity->getPath($user['User']['entity_id']);
			$path = '';
			unset($paths[0]);
			if (!empty($paths)) { 
				foreach ($paths as $k => $p) {
					$path = $path.' - '.$p['Entity']['name'];
				}
			}
			$users[$key]['path'] = $path;
		}

		//si la consulta viene de un circulo

		$userId = $this->Session->read('UserAuth.User.id');
		$userEntityId = $this->Session->read('UserAuth.User.entity_id');
		$path = $this->Entity->getPath($userEntityId);
		$entityParentId = $path[1]['Entity']['id'];
		$circles = $this->Circle->getCirclesByUserIdAndEntityId($userId, $entityParentId);
		$entities=$this->Entity->getParents();
		$groups = $this->Group->find('list', array('conditions' => array('active' => 1, 'type' => 1)));

		$parent = $this->Entity->getPath($this->Session->read('UserAuth.User.entity_id'));

		$groupsi = $this->Group->find('list', array('conditions' => array('Group.entity_id' => $parent[1]['Entity']['id'], 'Group.type' => 2)));

		$this->set('users',$users);
		$this->set('entities',$entities);
		$this->set('groups',$groups);

				$this->set('groupsi',$groupsi);

		$this->set('circles',$circles);
	}
}