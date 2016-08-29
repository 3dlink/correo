<?php
App::uses('AppController', 'Controller');
/**
 * Traces Controller
 *
 * @property Trace $Trace
 */
class TracesController extends AppController {
	var $uses = array('Trace', 'CommunicationToken');
   // public $helpers = array('Minify.Minify' );

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Trace->id = $id;
		if (!$this->Trace->exists()) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->autoRender = false;
		$this->request->onlyAllow('post', 'delete');
		if ($this->Trace->delete()) {
			$data = $this->request->data;
			$communicationToken =  $this->CommunicationToken->findByCommunicationIdAndUserId($data['communication_id'], $data['user_id']);
			if ($this->CommunicationToken->delete($communicationToken['CommunicationToken']['id'])){
				$t['Request']['status'] = 200;
				$t['Request']['message'] = 'Operación realizada con éxito';
				return json_encode($t);
			}
			else {
				$t['Request']['status'] = 300;
				$t['Request']['message'] = 'Error en la operación';
				return json_encode($t);
			}
		}
		$t['Request']['status'] = 300;
		$t['Request']['message'] = 'Error en la operación';
		return json_encode($t);
	}
}
