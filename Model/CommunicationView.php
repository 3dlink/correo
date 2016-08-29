<?php
App::uses('AppModel', 'Model');
/**
 * CommunicationView Model
 *
 */
class CommunicationView extends AppModel {

	public function saveCV($communicationView){

		$cv = $this->find('first', array(
			'conditions' => array(
				'communication_id' => $communicationView['communication_id'],
				'user_id' => $communicationView['user_id']
				)
			)
		);
		if (empty($cv)){
			$communicationView['last_view'] = date('Y-m-d H:i:s');
			$this->create();
			if ($this->save($communicationView)){
				return true;
			}
			else {
				return false;
			}
		}
		else {
			$cv['CommunicationView']['last_view'] = date('Y-m-d H:i:s');
			if ($this->save($cv['CommunicationView'])){
				return true;
			}
			else {
				return false;
			}
		}
	}
}
