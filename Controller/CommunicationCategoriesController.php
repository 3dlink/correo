<?php
App::uses('AppController', 'Controller');
/**
 * CommunicationCategories Controller
 *
 * @property CommunicationCategory $CommunicationCategory
 */
class CommunicationCategoriesController extends AppController {
	var $uses = array('CommunicationCategory', 'CommunicationType');
	//public $helpers = array('Minify.Minify' );
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CommunicationCategory->recursive = 0;
		$this->set('communicationCategories', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CommunicationCategory->create();
			if ($this->CommunicationCategory->save($this->request->data)) {
				$message = 'La categoría ha sido guardada';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'La categoría no pudo ser guardada. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
			}
		} else {
			$communicationTypes = $this->CommunicationType->find('list', array('conditions' => array('active' => 1)));
			$this->set('communicationTypes', $communicationTypes);
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
		if (!$this->CommunicationCategory->exists($id)) {
			throw new NotFoundException(__('Invalid communication category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CommunicationCategory->save($this->request->data)) {
				$message = 'La categoría ha sido guardada';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'La categoría no pudo ser guardada. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
			}
		} else {
			$options = array('conditions' => array('CommunicationCategory.' . $this->CommunicationCategory->primaryKey => $id));
			$this->CommunicationCategory->unbindModel(array('hasMany' => array('Communication')));
			$communicationCategory= $this->CommunicationCategory->find('first', $options);
			$communicationTypes = $this->CommunicationType->find('list', array('conditions' => array('active' => 1)));
			$this->set('communicationCategory', $communicationCategory);
			$this->set('communicationTypes', $communicationTypes);
		}
	}

	public function findByCommunicationTypeId($id = null) {
		$this->autoRender = false;
		$communicationCategories = $this->CommunicationCategory->find('list', array(
			'conditions' => array(
				'CommunicationCategory.active' => 1,
				'CommunicationCategory.communication_type_id' => $id
				)
			)
		);
		return json_encode($communicationCategories);
	}
}


