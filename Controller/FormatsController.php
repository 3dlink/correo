<?php
App::uses('AppController', 'Controller');
/**
 * Formats Controller
 *
 * @property Format $Format
 */
class FormatsController extends AppController {

	var $uses = array('Format','CommunicationCategory', 'CommunicationType','Entity');
	public $components = array('FileUpload.Upload');
    public $helpers = array('FileUpload.UploadForm');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Format->recursive = 0;
		//$this->set('formats', $this->paginate());
		$this->paginate = array ('conditions' => array('Format.entity_id' => $this->Session->read('UserAuth.User.entity_id')));
		//var_dump($this->paginate);
		$data = $this->paginate();
		//var_dump($data);
		$this->set('formats', $data);

		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->autoRender = false;
			$data = $this->request->data;
			//var_dump($data);die;
			$format = $this->Upload->getLastFormat($data['desc_upload']);
			$data['upload_id'] = $format['Upload']['id'];
			$data['entity_id'] = $this->Session->read('UserAuth.User.entity_id');
			$this->Format->create();
			if ($this->Format->save($data)) {
				$message_t = 'Formato guardado con éxito';
				$element = 'm_success';
				$this->Session->setFlash($message_t, $element);
				$a['Request']['status'] = 200;
				$a['Request']['message'] = $message_t;
				return json_encode($a);
			} else {
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Error tratando de guardar el formato. Intente nuevamente'	;
				return json_encode($a);
			}
		}
		$communicationTypes = $this->Format->CommunicationType->find('list');
		$this->set(compact('communicationTypes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Format->exists($id)) {
			throw new NotFoundException(__('Invalid format'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->autoRender = false;
			$data = $this->request->data;
			if (!empty($data['desc_upload'])){
				$f = $this->Format->findById($data['id']);
				$idUploadPrev = $f['Format']['upload_id'];
				$this->Upload->deleteRegistreById($idUploadPrev);
				$format = $this->Upload->getLastFormat($data['desc_upload']);
				$data['upload_id'] = $format['Upload']['id'];
			}
			if ($this->Format->save($data)) {
				$message_t = 'Formato actualizado con éxito';
				$element = 'm_success';
				$this->Session->setFlash($message_t, $element);
				$a['Request']['status'] = 200;
				$a['Request']['message'] = $message_t;
				return json_encode($a);
			} else {
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Error tratando de guardar el formato. Intente nuevamente'	;
				return json_encode($a);
			}
		} else {
			$options = array('conditions' => array('Format.' . $this->Format->primaryKey => $id));
			$this->request->data = $this->Format->find('first', $options);
			$format = $this->request->data;
		}
		$communicationTypes = $this->Format->CommunicationType->find('list');
		$communicationCategories = $this->CommunicationCategory->find('list', array(
			'conditions' => array(
				'CommunicationCategory.communication_type_id' => $format['Format']['communication_type_id']
				)
			)
		);
		$this->set(compact('communicationTypes', 'communicationCategories', 'format'));
	}

	public function updateVisible() {
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$idDocument = $this->request->data['id'];
			$visible = $this->request->data['visible'];
			if ($this->Format->makeVisible($idDocument, $visible)) {
				$a['Request']['status'] = 200;
				$a['Request']['message'] = 'Estado actualizado'	;
				return json_encode($a);
			}
			else {
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Error tratando de actualizar';
				return json_encode($a);
			}
		}
	}

	public function documentsVisible(){
		$this->autoRender = false;
		$idCategory = $this->request->data['category_id'];
		$parentsPath = $this->Entity->getPath($this->Session->read('UserAuth.User.entity_id'));
		//var_dump($parentsPath[1]['Entity']['id']);
		$documents = $this->Format->find('all', array(
			'conditions' => array(
				'Format.communication_category_id' => $idCategory,
				'Format.visible' => 1,
				'Format.entity_id' => $parentsPath[1]['Entity']['id']
				)
			)
		);
		return json_encode($documents);
	}

}
