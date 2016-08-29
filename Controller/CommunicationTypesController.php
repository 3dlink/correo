<?php
App::uses('AppController', 'Controller');
/**
 * CommunicationTypes Controller
 *
 * @property CommunicationType $CommunicationType
 */
class CommunicationTypesController extends AppController {
	//public $helpers = array('Minify.Minify' );
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CommunicationType->recursive = 0;
		$this->set('communicationTypes', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CommunicationType->create();
			if ($this->CommunicationType->save($this->request->data)) {
				$message = 'El tipo de comunicación ha sido guardado';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'El tipo de comunicación no pudo ser guardado. Por favor, intente nuevamente.';
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
		if (!$this->CommunicationType->exists($id)) {
			throw new NotFoundException(__('Invalid communication type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CommunicationType->save($this->request->data)) {
				$message = 'El tipo de comunicación ha sido guardado';
				$element = 'm_success';
				$this->Session->setFlash($message, $element);
				$this->redirect(array('action' => 'index'));
			} else {
				$message = 'El tipo de comunicación no pudo ser guardado. Por favor, intente nuevamente.';
				$element = 'm_error';
				$this->Session->setFlash($message, $element);
			}
		} else {
			$options = array('conditions' => array('CommunicationType.' . $this->CommunicationType->primaryKey => $id));
			$communicationType = $this->CommunicationType->find('first', $options);
			$this->set('communicationType', $communicationType);
		}
	}
}
