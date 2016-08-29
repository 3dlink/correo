<?php
App::uses('AppController', 'Controller');
/**
 * Tags Controller
 *
 * @property Tag $Tag
 */
class TagsController extends AppController {
	var $uses = array('Tag', 'CommunicationCategory', 'CommunicationType');
   // public $helpers = array('Minify.Minify' );


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tag->recursive = 0;
		$userId = $this->Session->read('UserAuth.User.id');
		$tags = $this->Tag->find('all', array(
			'conditions' => array(
				'Tag.user_id' => $userId
				),
			'group' => array('Tag.name'),
			)
		);
		$communicationCategories = $this->CommunicationCategory->find('all', array(
			'conditions' => array('CommunicationCategory.active' => '1' ))
		);
		$communicationTypes = $this->CommunicationType->find('all', array(
			'conditions' => array('CommunicationType.active' => '1' ))
		);
		$this->set('tags', $tags);
		$this->set('communicationTypes', $communicationTypes);
		$this->set('communicationCategories', $communicationCategories);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$tag = $this->Tag->findByUserIdAndCommunicationIdAndName($this->request->data['user_id'], $this->request->data['communication_id'], $this->request->data['name']);
			if (!empty($tag)){
				$t['Tag'] = $tag['Tag'];
				$t['Request']['status'] = 200;
				$t['Request']['message'] = 'Etiqueta creada';
				return json_encode($t);
			}
			$this->Tag->create();
			if ($this->Tag->save($this->request->data)) {
				$idTag = $this->Tag->getLastInsertID();
				$tag = $this->Tag->findById($idTag);
				$t['Tag'] = $tag['Tag'];
				$t['Request']['status'] = 200;
				$t['Request']['message'] = 'Etiqueta creada';
			} else {
				$t['Request']['status'] = 300;
				$t['Request']['message'] = 'Error creando la etiqueta';
			}
			return json_encode($t);
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
		$this->Tag->id = $id;
		if (!$this->Tag->exists()) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->autoRender = false;
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tag->delete()) {
			$t['Request']['status'] = 200;
			$t['Request']['message'] = 'Etiqueta eliminada';
			return json_encode($t);
		}
		$t['Request']['status'] = 300;
		$t['Request']['message'] = 'Error eliminando la etiqueta';
		return json_encode($t);
	}


	// buscar entidades o usuarios por nombre dado
	public function findTags(){
		$this->autoRender = false;
		$name = $_POST['q'];
		$userId = $_POST['user_id'];
		$tags = $this->Tag->findUTagByNameAndUserId($name, $userId);

		return json_encode($tags);
	}
}
