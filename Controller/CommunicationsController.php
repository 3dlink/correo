<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Communications Controller
 *
 * @property Communication $Communication
 */
class CommunicationsController extends AppController {

	var $uses = array('Usermgmt.User', 'Entity', 'Communication', 'Message', 'Trace', 'CommunicationToken', 'CommunicationView', 'Tag', 'Redirection', 'CommunicationCategory', 'CommunicationType', 'Group', 'ControlView', 'CommunicationTrash', 'Circle','FileUpload.Upload','Acknowledgment','SignedCommunication');
    public $components = array('FileUpload.Upload','Email','Mpdf.Mpdf');
    public $helpers = array('FileUpload.UploadForm','Signed','Forward');
   // public $helpers = array('Minify.Minify');
	
    public function download($enlace, $id = null, $token = null) {
		$this->viewClass = 'Media';
	        
    	if ($token == null) {
	    	// Download app/outside_webroot_dir/example.zip
	        $file = $this->Upload->findByRealName($enlace);
	        $real_name = preg_split("/[.]/", $file['Upload']['real_name']);
	        $params = array(
	            'id'        => $enlace,
	            'name'      => $real_name[0],
	            'download'  => true,
	            'extension' => $real_name[1],
	            'path'      => '/var/repo/' . DS
	        );
	       $this->set($params);

    	}else {

			$file = $this->Upload->findById($id);
			if ($file['Upload']['locked'] == 1 && $file['Upload']['token'] == $token){
					
		        $claves = preg_split("/[.]/", $file['Upload']['real_name']);
		        $params = array(
		            'id'        => $enlace,
		            'name'      => $claves[0],
		            'download'  => true,
		            'extension' => $claves[1],
		            'path'      => '/var/repo/' . DS
		        );
		       $this->set($params);				
			
			}else{
				$this->redirect(array('action' => 'index'));
			}

    		//echo $token;
    	}	
        /*
    	$this->response->file('webroot\files'.DS.$enlace,array('download'=> true, 'name'=> $enlace));
  		return $this->response; 
  		*/
    }
    
    public function showfile($enlace) {
    	$this->viewClass = 'Media';
    	 
    	// Download app/outside_webroot_dir/example.zip
    	$claves = preg_split("/./", $enlace);
    	$params = array(
    			'id'        => $enlace,
    			'name'      => $claves[0],
    			'download'  => false,
    			'extension' => $claves[1],
    			'path'      => '/var/repo/' . DS
    	);
    	$this->set($params);
        
    }
    
    public function previewfile($enlace) {
    	$this->viewClass = 'Media';
    
    	// Download app/outside_webroot_dir/example.zip
    	$claves = preg_split("/./", $enlace);
    	$params = array(
    			'id'        => $enlace,
    			'name'      => $claves[0],
    			'download'  => false,
    			'extension' => $claves[1],
    			'path'      => '/var/repo/' . DS
    	);
    	$this->set($params);
    	 
    }

    function in_array_match($regex, $array) {
    	$arr = array();
	    foreach ($array as $k => $v) {
	        $match = preg_match('/'.$regex.'/', $v);
	        if ($match === 1) {
	            array_push($arr, $k);
	        }
	    }
	    return $arr;
	}

/**
 * index method
 *
 * @return void
 */
	public function index($page = 0) {
		$this->Communication->recursive = 0;
		$this->Trace->Behaviors->attach('Containable');
		$this->Trace->recursive = 2;
		$userId = $this->Session->read('UserAuth.User.id');
		$userEntityId = $this->Session->read('UserAuth.User.entity_id');

		$limit = 10;
		$offset = $page * $limit;

		$this->Trace->unbindModel(
	        array('belongsTo' => array('SenderUser', 'ReceiveUser', 'ReceiveEntitie' ))
	    );
		
		if(isset($_GET['x'])==1){
			$this->Session->setFlash("Comunicacion Enviada y Firmada Exitosamente", "m_success");
		}
	    $params = '';

	    if (count($_GET) > 0){
		    $cant = count($_GET);
			$key = array_keys($_GET);// obtiene los nombres de las varibles
			$val = array_values($_GET);
			for($i=0;$i<$cant;$i++){
				$params = $params.$key[$i].'='.$val[$i].'&';
			}
	    }

	    // para el caso de que se pidan los borradores
	    $draft = 0;
	    if (isset($_GET['draft'])){
	    	$draft = 1;
	    }

	    $trash = 0;
	    if (isset($_GET['trash'])){
	    	$trash = 1;
	    }

	    $sent = 0;
	    if (isset($_GET['sent'])){
	    	$sent = 1;
	    }

		$usersId = 0;
	    $messagesId = 0;
	    $actionsId = 0;
	    $categoriesId = 0;
	    $typesId = 0;
	    $communicationIdsTag = 0;

	    // buscar por nombre de usuario, titulo, contexto o entidades y que el usuario este incluido
	    if (isset($_GET['query'])) { 
	    	$query = $_GET['query'];
	    	// haciendo query sobre los enviados por mi
	    	if (isset($_GET['sent']) || isset($_GET['draft'])){
	    		$arrayIdCommunications = $this->Trace->find('list', array(
		    		'fields' => array('Trace.id'),
		    		'conditions' => array(
		    			'Trace.sender_user_id' => $userId,
		    			)
		    		)
		    	);
		    	$arrayIdMessages = $this->Trace->find('list', array(
		    		'fields' => array('Trace.message_id'),
		    		'conditions' => array(
		    			'Trace.sender_user_id' => $userId,
		    			)
		    		)
		    	);
	    	}
	    	// haciendo query sobre todos los enviados y dirigidos a mi
	    	else {
		    	$arrayIdCommunications = $this->Trace->find('list', array(
		    		'fields' => array('Trace.id'),
		    		'conditions' => array(
		    			'OR' => array(
		    				'Trace.sender_user_id' => $userId,
		    				'Trace.receive_user_id' => $userId
		    				)
		    			)
		    		)
		    	);
		    	$arrayIdMessages = $this->Trace->find('list', array(
		    		'fields' => array('Trace.message_id'),
		    		'conditions' => array(
		    			'OR' => array(
		    				'Trace.sender_user_id' => $userId,
		    				'Trace.receive_user_id' => $userId
		    				)
		    			)
		    		)
		    	);
	    	}
	    	$actions = array('','','aprobacion', 'devolver con observaciones', 'dar respuesta', 'confirmar asistencia');
	    	// busco mensajes
	    	$messagesId = $this->Message->findContent($query, $arrayIdMessages); // buscar contenido de msj
	    	$usersId = $this->User->findIdUsersByName($query); // buscar nombres
	    	$entitiesId = $this->Entity->findEntityIdsByName($query); // buscar entidades
	    	$categoriesId = $this->CommunicationCategory->findCategoryIdsByName($query); // buscar por categoria
	    	$typesId = $this->CommunicationType->findTypeIdsByName($query); // buscar por categoria
	    	$actionsId = $this->in_array_match($query, $actions);
	    	$communicationIdsTag = $this->Tag->findUCommunicationIdsByTagNameAndUserId($query, $userId);
	    	
			$usersId = implode(',', $usersId);
			$messagesId = implode(',', $messagesId);
			$typesId = implode(',', $typesId);
			$categoriesId = implode(',', $categoriesId);
			$actionsId = implode(',', $actionsId);
			$communicationIdsTag = implode(',', $communicationIdsTag);
			$arrayIdCommunications = implode(',', $arrayIdCommunications);
			if (empty($usersId)) $usersId = 0;
			if (empty($messagesId)) $messagesId = 0;
			if (empty($typesId)) $typesId = 0;
			if (empty($categoriesId)) $categoriesId = 0;
			if (empty($communicationIdsTag)) $communicationIdsTag = 0;
			if (empty($actionsId)) $actionsId = 0;
	    } 

	    // para el caso de buscar por nombre de un tag
	    if (isset($_GET['tn'])){
	    	$communicationsIds = $this->Tag->findCommunicationsIdsByName(trim($_GET['tn']));
			$communicationsIds = implode(',', $communicationsIds);

			$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId))) AND Trace.communication_id IN ($communicationsIds) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId 
				GROUP BY Trace.communication_id");

			$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId))) AND Trace.communication_id IN ($communicationsIds) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId 
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC 
				LIMIT $offset, $limit"
				);

			if (!empty($count))
				$count = count($count);
			else $count = 0;
	    } 
	    // para el caso de buscar por nombre de una categoria
	    else if (isset($_GET['ccn'])){
	    	$communicationsIds = $this->Communication->findIdsByCategoryId(trim($_GET['cci']));
			$communicationsIds = implode(',', $communicationsIds);

			$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
			LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
			LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
			LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
			LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
			WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId))) AND Trace.communication_id IN ($communicationsIds) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId 
			GROUP BY Trace.communication_id");

			$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
			FROM traces AS Trace 
			LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
			LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
			LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
			LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
			LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
			LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
			LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
			WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId))) AND Trace.communication_id IN ($communicationsIds) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId 
			GROUP BY Trace.communication_id 
			ORDER BY Trace.created DESC
			LIMIT $offset, $limit");

			if (!empty($count))
				$count = count($count);
			else $count = 0;
	    }
	    // para el caso de buscar por nombre de un tipo de comunicacion
	    else if (isset($_GET['ctn'])){
	    	$communicationsIds = $this->Communication->findIdsByTypeId(trim($_GET['cti']));
			$communicationsIds = implode(',', $communicationsIds);

			$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
			LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
			LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
			LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
			LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
			WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId))) AND Trace.communication_id IN ($communicationsIds) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId 
			GROUP BY Trace.communication_id");

			$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
			FROM traces AS Trace 
			LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
			LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
			LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
			LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
			LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
			LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
			LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
			WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId))) AND Trace.communication_id IN ($communicationsIds) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId 
			GROUP BY Trace.communication_id 
			ORDER BY Trace.created DESC
			LIMIT $offset, $limit");

			if (!empty($count))
				$count = count($count);
			else $count = 0;
	    }
	    // los que yo envie y no me han respondido
	    elseif (isset($_GET['nrm'])){
	    	$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE (Trace.sender_user_id IN ($userId)) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId AND Trace.sender_user_id != $userId
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE Communication.user_id = $userId AND Communication.draft = $draft AND CommunicationTrash.user_id = $userId  AND CommunicationTrash.trash = $trash AND NOT EXISTS (SELECT * FROM traces AS TraceA WHERE TraceA.sender_user_id != $userId AND TraceA.communication_id = Communication.id)
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");

			if (!empty($count))
				$count = count($count);
			else $count = 0;

	    }
	    elseif (isset($_GET['draft'])) {
	    	if (isset($_GET['query'])){
	    		$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE Trace.sender_user_id = $userId AND (Trace.receive_user_id IN ($usersId) OR Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_types AS CommunicationType ON (Communication.communication_type_id = CommunicationType.id) 
				LEFT JOIN communication_categories AS CommunicationCategory ON (Communication.communication_category_id = CommunicationCategory.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE Trace.sender_user_id = $userId AND (Trace.receive_user_id IN ($usersId) OR Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");
	    	}
	    	else {
		    	$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE Trace.sender_user_id = $userId AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE Trace.sender_user_id = $userId AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");
	    	}

			if (!empty($count))
				$count = count($count);
			else $count = 0;
	    }
	    elseif (isset($_GET['trash'])) {
	    	if (isset($_GET['query'])){
	    		
	    		
	    		
	    		$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE (Trace.sender_user_id IN ($usersId) OR Trace.receive_user_id IN ($usersId) OR Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND Trace.id IN ($arrayIdCommunications) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE (Trace.sender_user_id IN ($usersId) OR Trace.receive_user_id IN ($usersId) OR Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND Trace.id IN ($arrayIdCommunications) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");
	    	}
	    	else {
				$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId)))  AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId)))   AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");
	    	}
	
			if (!empty($count))
				$count = count($count);
			else $count = 0;
	    }
	    // enviados por mi
	    elseif (isset($_GET['sent'])) {
	    	if (isset($_GET['query'])){
	    		$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE Communication.user_id = $userId AND (Trace.receive_user_id IN ($usersId) OR  Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND Communication.draft = $draft AND CommunicationTrash.user_id = $userId  AND CommunicationTrash.trash = $trash
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE Communication.user_id = $userId AND (Trace.receive_user_id IN ($usersId) OR  Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND Communication.draft = $draft AND CommunicationTrash.user_id = $userId  AND CommunicationTrash.trash = $trash
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");
	    	}
	    	else {
				$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE (Trace.sender_user_id IN ($userId)) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash
				FROM traces AS Trace
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE Communication.user_id = $userId AND Communication.draft = $draft AND CommunicationTrash.user_id = $userId  AND CommunicationTrash.trash = $trash
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");
	    	}

			if (!empty($count))
				$count = count($count);
			else $count = 0;

	    }
	    //recibidos
	    else {
	    	if (isset($_GET['query'])){
		    	$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE (Trace.sender_user_id IN ($usersId) OR Trace.receive_user_id IN ($usersId) OR Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND 
				Trace.id IN ($arrayIdCommunications) AND 
				Communication.draft = $draft AND 
				CommunicationTrash.trash = $trash AND 
				CommunicationTrash.user_id = $userId 
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash, CommunicationToken.id, CommunicationToken.user_id, CommunicationToken.Communication_id
				FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN communication_tokens AS CommunicationToken ON (Communication.id = CommunicationToken.communication_id AND CommunicationToken.user_id = $userId) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE (Trace.sender_user_id IN ($usersId) OR Trace.receive_user_id IN ($usersId) OR Trace.message_id IN ($messagesId) OR Communication.communication_category_id IN ($categoriesId) OR Communication.communication_type_id IN ($typesId) OR Communication.action_id IN ($actionsId) OR Communication.id IN ($communicationIdsTag)) AND 
				Trace.id IN ($arrayIdCommunications) AND 
				Communication.draft = $draft AND 
				CommunicationTrash.trash = $trash AND 
				CommunicationTrash.user_id = $userId 
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC
				LIMIT $offset, $limit");
	    	}
	    	else {
		    	$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				WHERE ((Trace.sender_user_id IN ($userId)) OR (Trace.receive_user_id IN ($userId))) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId
				GROUP BY Trace.communication_id");

				$communications = $this->Trace->query ( "SELECT Trace.id, Trace.communication_id, Trace.message_id, Trace.sender_user_id, Trace.receive_user_id, Trace.sender_entity_id, Trace.receive_entity_id, Trace.read, Trace.read_datatime, Trace.created, Trace.modified, Trace.type_delivery, Trace.requires_approval, Trace.approval, Communication.id, Communication.entity_id, Communication.user_id, Communication.created, Communication.modified, Communication.expires, Communication.communication_type_id, Communication.communication_category_id, Communication.action_id, Communication.draft, Message.id, Message.title, Message.content, Message.private, Message.created, Message.modified, SenderUser.id, SenderUser.user_group_id, SenderUser.username, SenderUser.password, SenderUser.salt, SenderUser.email, SenderUser.first_name, SenderUser.last_name, SenderUser.email_verified, SenderUser.active, SenderUser.ip_address, SenderUser.created, SenderUser.modified, SenderUser.entity_id, SenderUser.first_time, SenderUser.telephone, SenderUser.celphone, SenderUser.group_id, ReceiveUser.id, ReceiveUser.user_group_id, ReceiveUser.username, ReceiveUser.password, ReceiveUser.salt, ReceiveUser.email, ReceiveUser.first_name, ReceiveUser.last_name, ReceiveUser.email_verified, ReceiveUser.active, ReceiveUser.ip_address, ReceiveUser.created, ReceiveUser.modified, ReceiveUser.entity_id, ReceiveUser.first_time, ReceiveUser.telephone, ReceiveUser.celphone, ReceiveUser.group_id, SenderEntity.id, SenderEntity.name, SenderEntity.description, SenderEntity.active, SenderEntity.website, SenderEntity.lft, SenderEntity.rght, SenderEntity.parent_id, ReceiveEntitie.id, ReceiveEntitie.name, ReceiveEntitie.description, ReceiveEntitie.active, ReceiveEntitie.website, ReceiveEntitie.lft, ReceiveEntitie.rght, ReceiveEntitie.parent_id, CommunicationTrash.id, CommunicationTrash.communication_id, CommunicationTrash.user_id, CommunicationTrash.trash, CommunicationToken.id, CommunicationToken.user_id, CommunicationToken.Communication_id
				FROM traces AS Trace 
				LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
				LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
				LEFT JOIN communication_tokens AS CommunicationToken ON (Communication.id = CommunicationToken.communication_id AND CommunicationToken.user_id = $userId) 
				LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
				LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
				LEFT JOIN users AS ReceiveUser ON (Trace.receive_user_id = ReceiveUser.id) 
				LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
				LEFT JOIN entities AS ReceiveEntitie ON (Trace.receive_entity_id = ReceiveEntitie.id) 
				WHERE (Trace.sender_user_id IN ($userId) OR Trace.receive_user_id IN ($userId)) AND Communication.draft = $draft AND CommunicationTrash.trash = $trash AND CommunicationTrash.user_id = $userId 
				GROUP BY Trace.communication_id 
				ORDER BY Trace.created DESC 
				LIMIT $offset, $limit");
	    	}

			if (!empty($count))
				$count = count($count);
			else $count = 0;
	    }
		foreach ($communications as $key => $communication) {
			// ver si tiene adjuntos
			$hasAtt = $this->Communication->hasAttachments($communication['Communication']['id']);
			$communications[$key]['Communication']['hasAttachments'] = $hasAtt;
			
			$communicationId = $communication['Communication']['id'];
			$communicationModified = $communication['Communication']['modified'];
			$communicationView = $this->CommunicationView->findByUserIdAndCommunicationId($userId, $communicationId);
			
			$isUpdate = false;
			
			// obtener la iteraciones de la comunicacion, si tiene lectores nuevos
			$controlViews = $this->ControlView->find('count', array(
				'conditions' => array(
					'communication_id' => $communicationId,
					'sender_user_id' => $userId,
					)
				)
			);

			if ($controlViews > 0) $isUpdate = true;

			if (!empty($communicationView)){
				$communicationLastView = $communicationView['CommunicationView']['last_view'];
				if ($communicationModified > $communicationLastView) $isUpdate = true;
			}


			$c = $this->Trace->find('count', array(
				'conditions' => array(
					'Trace.communication_id' => $communicationId,
					'Trace.receive_user_id' => $userId,
					'Trace.read' => 0
					)
				)
			);
			$read = true;
			if ($c > 0) $read = false;
			$this->Tag->recursive = -1;
			$this->CommunicationCategory->recursive = -1;
			$this->CommunicationType->recursive = -1;
			$tags = $this->Tag->findAllByCommunicationId($communicationId);
			
			$communicationCategoryId = 0;
			$communicationTypeId = 0;
			if (isset($communication['Communication']['communication_category_id'])) {
				$communicationCategoryId = $communication['Communication']['communication_category_id'];
				$communicationCategory = $this->CommunicationCategory->findById($communicationCategoryId);
				$communications[$key]['CommunicationCategory'] = $communicationCategory['CommunicationCategory'];
			}

			if (isset($communication['Communication']['communication_type_id'])) {
				$communicationTypeId = $communication['Communication']['communication_type_id'];
				$communicationType = $this->CommunicationType->findById($communicationTypeId);
				$communications[$key]['CommunicationType'] = $communicationType['CommunicationType'];
			}

			$communications[$key]['Tag'] = $tags;
			$communications[$key]['Communication']['read'] = $read;
			$communications[$key]['Communication']['is_update'] = $isUpdate;
		}


		$pagination['params'] = $params;
		$pagination['page'] = $page;
		$pagination['next_page'] = $page + 1;
		$pagination['total'] = $count;
		$pagination['page_init'] = ($page*$limit) + 1;
		// debug($page, $showHtml = null, $showFrom = true);
		// debug($count, $showHtml = null, $showFrom = true);
		// debug($limit, $showHtml = null, $showFrom = true);
		$pend = $count - ($page * $limit);
		$pagination['previous'] = true;
		$pagination['previous_page'] = $page - 1;
		if ($page==0) {
			$pagination['previous'] = false;
		}
		if ($pend > $limit) {
			$pagination['next'] = true;
			$pagination['page_end'] = ($page * $limit) + $limit;
		}
		else if ($pend == $limit) {
			$pagination['next'] = false;
			$pagination['page_end'] = ($page * $limit) + $limit;
		}
		else {
			$pagination['next'] = false;
			$pagination['page_end'] = ($page*$limit) + $pend;
		}
		
	
		
		
		$this->set('communications', $communications);
		$this->set('pagination', $pagination);
	}
	
	
	

	// function redirectMessage($user) {

	// }
/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		
		
		if ($this->request->is('post')) {
			
			
			$this->autoRender = false;
			$data = $this->request->data;
			
			
			
			$userId = $this->Session->read('UserAuth.User.id');
			$action = 0;

			if (isset($data['action'])) $action = $data['action'];

			$c['owner'] = $userId;
			$c['expires'] = $data['expires'];
			$c['entity_id'] = $data['entity_id'];
			$c['correlative']=$data['correlative'];
			$c['user_id'] = $data['user_id'];
			$c['communication_category_id'] = $data['communication_category_id'];
			$c['communication_type_id'] = $data['communication_type_id'];
			$c['action_id'] = $action;
			
			if(($c['action_id'] == 7 && $data['sendtype'] == 1) || $data['sendtype'] == 1){
				$c['draft'] = 1;
			}
			else{
			$c['draft'] = $data['draft'];
			}
				
			$m['title'] = $data['title'];
			$m['content'] = $data['content'];
			$m['private'] = $data['message_private'];
			$m['expires'] = $data['expires'];
			
			$nameOfGroup = "";
			
			if(isset($data['nameGroup'])){
				$nameOfGroup = $data['nameGroup'];
			}

			$message = '';
			$communication = '';
			
			
			$file_certification = $data['certificacion'];
			
			$this->Communication->create();
			if ($this->Communication->save($c)) {

				if(isset($data['history'])){
					$lastidComun = $this->Communication->find('first',array('order' => 'Communication.id DESC'));
					$lastidComun = $lastidComun['Communication']['id'];
					
					
					foreach ($data['history'] as $key => $value) {
						$mensajeH = $this->Message->find('first', array('conditions' => array('Message.id' => $value)));

						$TraceH = $this->Trace->find('first', array('conditions' => array('Message.id' => $value)));
						$mensajeH['Message']['forward'] = "1";
						unset($mensajeH['Message']['id']);
						$this->Message->create();
						if($this->Message->save($mensajeH)){
							$lastidMsg = $this->Message->find('first',array('order' => 'Message.id DESC'));
							$files_msj = $this->Upload->findDocumentsByMessage($value);

							foreach ($files_msj as $k => $v) {
								unset($v['Upload']['id']);
								$v['Upload']['message_id'] = $lastidMsg['Message']['id'];
								$this->Upload->addUploadRow($v);
									
							}

							$this->Trace->create();
							$newTrace['communication_id'] = $lastidComun; 
							$newTrace['read'] = 1;
							$newTrace['read_datatime'] = date('Y-m-d h:m:s');
							$newTrace['message_id'] = $lastidMsg['Message']['id'];
							$newTrace['sender_user_id'] = $TraceH['Trace']['sender_user_id'];
							$newTrace['receive_user_id'] = $TraceH['Trace']['receive_user_id'];
							$newTrace['sender_entity_id'] = $TraceH['Trace']['sender_entity_id'];
							$newTrace['receive_entity_id'] = $TraceH['Trace']['receive_entity_id'];
						
							$this->Trace->save($newTrace);

						}
					}

				}

				$communicationId = $this->Communication->getLastInsertID();
				$communication = $this->Communication->findById($communicationId);

				/**if($this->__move_file($file_certification, "correspondencia_certificada_$communicationId.pdf") && false){
					$nameFileLog = "info_services";
					CakeLog::write($nameFileLog, "CommunicationsController.add: Estamos adjuntando el resumen...");
					//$this->log("CommunicationsController.add: Estamos adjuntando el resumen...");
					$summaryCommunication = array();
					$summaryCommunication['Upload']['temporal'] = $data['temporal_id'];
					$summaryCommunication['Upload']['name'] = "correspondencia_certificada_$communicationId.pdf";
					$summaryCommunication['Upload']['real_name'] = "Correspondencia Certificada.pdf";
					$summaryCommunication['Upload']['size'] = filesize("../webroot/files/correspondencia_certificada_$communicationId.pdf");
					$respSave = $this->Upload->addUploadRow($summaryCommunication);
					if($respSave){
						CakeLog::write($nameFileLog, "CommunicationsController.add: Resumen de la correspondencia guardado");
					}else{
						CakeLog::write($nameFileLog, "CommunicationsController.add: Error: $respSave");
					}
					//$this->log("CommunicationsController.add: Resumen de la correspondencia guardado");
				}**/
				
				// guardo en la tabla communication_trash
				$communicationTrash['user_id'] = $userId;
				$communicationTrash['trash'] = 0;
				$communicationTrash['communication_id'] = $communicationId;
				$this->CommunicationTrash->create();
				if ($this->CommunicationTrash->save($communicationTrash)) {
					// exitoso
				}
				else {
					//error
					$this->deleteAll($communicationId);
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
					return json_encode($a);
				}

				// agregar en communicationview
				$this->CommunicationView->create();
				$cv['user_id'] = $userId;
				$cv['communication_id'] = $communicationId;
				if ($this->CommunicationView->saveCV($cv)){
					// exito
				}
				else {
					// error
					$this->deleteAll($communicationId);
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
					return json_encode($a);
				}
				// crear el mensaje 
				$this->Message->create();
				if ($this->Message->save($m)) {
					$messageId = $this->Message->getLastInsertID();
					$message = $this->Message->findById($messageId);
					// modificar los uploads
					if (isset($data['files'])){
						$idTemporal = $data['temporal_id'];
						$idFiles = $data['files'];
						$uploads = $this->Upload->findDocumentsByTemporal($idTemporal);

						foreach ($uploads as $key => $upload) {
							// chequeo 
							if (in_array($upload['Upload']['id'] , $idFiles)){
								$upload['Upload']['message_id'] = $messageId;
								$upload['Upload']['temporal'] = null;
								if ($this->Upload->saveChange($upload)){
									// bien
								}
								else {
									// error
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
									return json_encode($a);
								}
							}
							else {
								if($upload['Upload']['name'] != "correspondencia_certificada_$communicationId.pdf"){
									$this->Upload->deleteRegistre($upload);
								}else{
									$upload['Upload']['message_id'] = $messageId;
									$upload['Upload']['temporal'] = null;
									if ($this->Upload->saveChange($upload)){
										// bien
									}
									else {
										// error
										$this->deleteAll($communicationId, $messageId);
										$a['Request']['status'] = 300;
										$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
										return json_encode($a);
									}
								}
							}
						};
					}

					// guardar los tags
					if (isset($data['tags'])){
						$tags = $data['tags'];
						foreach ($tags as $key => $tag) {
							$t['name'] = $tag;
							$t['communication_id'] = $communicationId;
							$t['user_id'] = $userId;
							$this->Tag->create();
							if ($this->Tag->save($t)) {
								// bien
							}
							else {
								$this->deleteAll($communicationId, $messageId);
							}
						};
					}

					// guardar los formatos
					if (isset($data['formats'])){
						$formats = $data['formats'];
						foreach ($formats as $key => $idFormat) {
							if ($this->Upload->saveFormatToMessage($idFormat, $messageId)) {
								// bien
							}
							else {
								$this->deleteAll($communicationId, $messageId);
							}
						};
					}

					$t['communication_id'] = $communication['Communication']['id'];
					$t['message_id'] = $message['Message']['id'];
					$t['sender_user_id'] = $data['user_id'];
					$t['sender_entity_id'] = $data['entity_id'];
					// elimino el token de quien envia
					$this->CommunicationToken->deleteToken($communicationId, $data['user_id']);
					// guardar quienes reciben el mensaje
					foreach ($data['receivers'] as $key => $receive) {
						// si es to, es mensaje directo, si es cc es con copia 
						$deliveryType = ($receive['deliverytype'] == 'to') ? 0 : 1;
						// chequear si quien recibe es una entidad
						if ($receive['type'] == 'entity' || $receive['type'] == 'group' || $receive['type'] == 'circle'){
							
							if ($receive['type'] == 'entity'){
								$ents = $this->Entity->getAllDescentIds($receive['id']);
								// agrega la entidad tmb
								array_push($ents, $receive['id']);
								$users = $this->User->find('all', array('conditions' => array('entity_id' => $ents)));
							}
							elseif ($receive['type'] == 'group') {
								$groupId = $receive['id'];
								$users = $this->User->find('all', array(
									'conditions' => array(
										'group_id' => $groupId
										)
									)
								);
							}
							elseif ($receive['type'] == 'circle') {
								$circleId = $receive['id'];
								$usersId = $this->Circle->getIdUsersFromCircleId($circleId);
								$users = $this->User->find('all', array(
									'conditions' => array(
										'id' => $usersId
										)
									)
								);
							}	
							
							//echo "Los datos se cargaron correctamente.";
							foreach ($users as $key => $user) {
								// guardo en la tabla trash
								$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user['User']['id'], $communicationId);
								if (!$communicationTrash) {
									$this->CommunicationTrash->create();
									$communicationTrash['user_id'] = $user['User']['id'];
									$communicationTrash['trash'] = 0;
									$communicationTrash['communication_id'] = $communicationId;
									if ($this->CommunicationTrash->save($communicationTrash)) {
										// exitoso
									} else {
										//error
										$this->deleteAll($communicationId, $messageId);
										$a['Request']['status'] = 300;
										$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
										return json_encode($a);
									}
								}

								// lista de ids a quienes tambien se les debe enviar el mensaje
								
								$t['receive_user_id'] =$user['User']['id'];
								$t['receive_entity_id'] =$user['User']['entity_id'];
								$t['type_delivery'] = $deliveryType;

								// indicar si requiere aprobacion
								if ($action == 2){
									$t['requires_approval'] = 1;
									$t['approval'] = -2; // requiere aprobacion del usuario
								}
								
								
								if ($this->Trace->save($t)) {
									// exitoso
								} else {
									//error
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
									return json_encode($a);
								}
								$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
								// chequear si el mensaje es privado
								//if ($data['message_private'] == 0){
									
									$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
									
									if (!empty($redirecs)) {
										foreach ($redirecs as $key => $rd) {
											if ($rd == $userId) continue;
											$user2 = $this->User->findById($rd);

											// guardo en la tabla trash
											$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user2['User']['id'], $communicationId);
											if (!$communicationTrash) {
												$this->CommunicationTrash->create();
												$communicationTrash['user_id'] = $user2['User']['id'];
												$communicationTrash['trash'] = 0;
												$communicationTrash['communication_id'] = $communicationId;
												if ($this->CommunicationTrash->save($communicationTrash)) {
													// exitoso
												} else {
													//error
													$this->deleteAll($communicationId, $messageId);
													$a['Request']['status'] = 300;
													$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
													return json_encode($a);
												}
											}

											$t['receive_user_id'] =$user2['User']['id'];
											$t['receive_entity_id'] =$user2['User']['entity_id'];
											$t['type_delivery'] = $deliveryType;
											// los redirects nunca aprueban
											$t['requires_approval'] = 0;
											$t['approval'] = 0;

											$this->Trace->create();
											if ($this->Trace->save($t)) {
												// exitoso
											}
											else {
												//error
												$this->deleteAll($communicationId, $messageId);
												$a['Request']['status'] = 300;
												$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
												return json_encode($a);
											}
											$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
										}
									}
								//}
							}
						}
						// quien recibe es un grupo
						/*
						elseif ($receive['type'] == 'group') {
							$groupId = $receive['id'];
							$users = $this->User->find('all', array(
								'conditions' => array(
									'group_id' => $groupId
									)
								)
							);
							foreach ($users as $key => $user) {
								// guardo en la tabla trash
								$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user['User']['id'], $communicationId);
								if (!$communicationTrash) {
									$this->CommunicationTrash->create();
									$communicationTrash['user_id'] = $user['User']['id'];
									$communicationTrash['trash'] = 0;
									$communicationTrash['communication_id'] = $communicationId;
									if ($this->CommunicationTrash->save($communicationTrash)) {
										// exitoso
									}
									else {
										//error
										$this->deleteAll($communicationId, $messageId);
										$a['Request']['status'] = 300;
										$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
										return json_encode($a);
									}
								}

								// lista de ids a quienes tambien se les debe enviar el mensaje
								$t['receive_user_id'] =$user['User']['id'];
								$t['receive_entity_id'] =$user['User']['entity_id'];
								$t['type_delivery'] = $deliveryType;
								// indicar si requiere aprobacion
								if ($action == 2){
									$t['requires_approval'] = 1;
									$t['approval'] = -2;
								}

								$this->Trace->create();
								if ($this->Trace->save($t)) {
									// exitoso
								}
								else {
									//error
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
									return json_encode($a);
								}
								$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
								// chequear si el mensaje es privado
								if ($data['message_private'] == 0){
									$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
									if (!empty($redirecs)) {
										foreach ($redirecs as $key => $rd) {
											if ($rd == $userId) continue; // no me reenvio el msj
											$user2 = $this->User->findById($rd);

											// guardo en la tabla trash
											$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user2['User']['id'], $communicationId);
											if (!$communicationTrash) {
												$this->CommunicationTrash->create();
												$communicationTrash['user_id'] = $user2['User']['id'];
												$communicationTrash['trash'] = 0;
												$communicationTrash['communication_id'] = $communicationId;
												if ($this->CommunicationTrash->save($communicationTrash)) {
													// exitoso
												}
												else {
													//error
													$this->deleteAll($communicationId, $messageId);
													$a['Request']['status'] = 300;
													$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
													return json_encode($a);
												}
											}

											$t['receive_user_id'] =$user2['User']['id'];
											$t['receive_entity_id'] =$user2['User']['entity_id'];
											$t['type_delivery'] = $deliveryType;
											// los redirects nunca aprueban
											$t['requires_approval'] = 0;
											$t['approval'] = 0;

											$this->Trace->create();
											if ($this->Trace->save($t)) {
												// exitoso
											}
											else {
												//error
												$this->deleteAll($communicationId, $messageId);
												$a['Request']['status'] = 300;
												$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
												return json_encode($a);
											}
											$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
										}
									}
								}
							}
						}
						*/
						// quien recibe es un usuario
						else {
							$user = $this->User->findById($receive['id']);

							// guardo en la tabla trash
							$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user['User']['id'], $communicationId);
							if (!$communicationTrash) {
								$this->CommunicationTrash->create();
								$communicationTrash['user_id'] = $user['User']['id'];
								$communicationTrash['trash'] = 0;
								$communicationTrash['communication_id'] = $communicationId;
								if ($this->CommunicationTrash->save($communicationTrash)) {
									// exitoso
								}
								else {
									//error
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
									return json_encode($a);
								}
							}
							 
							//$pp = $this->User->find('first' , array ('conditions' => array ('id' => $user['User']['id'])));
							$reditectonly=$user['User']['redirect_only'];
							if($data['draft'] ==1){
								$reditectonly =0;
							}
							
							if($data['message_private'] == 1){
								$reditectonly =0;
							}
							if($reditectonly == 1){
								//echo 1;
							}
							else{
								//echo 2;
							
							
							
								$this->Trace->create();
								$t['receive_user_id'] =$user['User']['id'];
								$t['receive_entity_id'] =$user['User']['entity_id'];
								$t['type_delivery'] = $deliveryType;
								// indicar si requiere aprobacion
								if ($action == 2){
									$t['requires_approval'] = 1;
									$t['approval'] = -2;
								}
								
							
							
							
							if ($this->Trace->save($t)) {
									$theLastTrace = $this->Trace->find('first',array('order' => 'Trace.id DESC'));
									if(!empty($nameOfGroup)){
										$this->log($nameOfGroup);
										foreach ($nameOfGroup as $ey => $ue) {
											if($ey%2!=0){
												foreach ($ue as $y => $e) {
													$allTraceLast = $this->Trace->find('first',array('conditions' => array('Trace.message_id' => $theLastTrace['Trace']['message_id'], 'Trace.receive_user_id' => $e)));
													$allTraceLast['Trace']['namegroup'] = $nameOfGroup[$ey-1];
													$this->Trace->save($allTraceLast);
												}
											}
										}
									}

									
								 		
								 		
								 		
								}
							}	
								
								// se lo envio a quienes tengo en mi lista de redireccion
								// chequear si el mensaje es privado
							
										
								if ($data['message_private'] == 0){
									
									$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
									
									
									if (!empty($redirecs)) {
										foreach ($redirecs as $key => $rd) {
											//if ($rd == $userId) continue; // no me reenvio el msj
											$user2 = $this->User->findById($rd);
											
											
											
											// guardo en la tabla trash
											$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user2['User']['id'], $communicationId);
											if (!$communicationTrash) {
												$this->CommunicationTrash->create();
												$communicationTrash['user_id'] = $user2['User']['id'];
												$communicationTrash['trash'] = 0;
												$communicationTrash['communication_id'] = $communicationId;
												if ($this->CommunicationTrash->save($communicationTrash)) {
													// exitoso
												}
												else {
													//error
													$this->deleteAll($communicationId, $messageId);
													$a['Request']['status'] = 300;
													$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
													return json_encode($a);
												}
											}

											$t['receive_user_id'] =$user2['User']['id'];
											$t['receive_entity_id'] =$user2['User']['entity_id'];
											$t['type_delivery'] = $deliveryType;
											// los redirects nunca aprueban
											$t['requires_approval'] = 0;
											$t['approval'] = 0;

											$this->Trace->create();
											
											if ($this->Trace->save($t)) {
												

												// exito
											}
											else {
												//error
												$this->deleteAll($communicationId, $messageId);
												$a['Request']['status'] = 300;
												$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
												return json_encode($a);
											}
											$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
										}
										
										
									}
									if ($c['expires'] && $c['draft'] == 0) {
											$lastComun = $this->Communication->find('first',array('order' => 'Communication.id DESC'));
											$idlastComun = $lastComun['Communication']['id'];
											$Allusers = $this->Trace->find('all',array('conditions'=>array('Trace.communication_id'=>$idlastComun)));
											$toArray  = array();	
											foreach ($Allusers as $key => $value) {
												$use = $value['Trace']['receive_user_id'];
										
												$dataUse = $this->User->find('first',array('conditions'=>array('User.id'=>$use)));
										
												$toArray[$key] = $dataUse['User']['email'];
											}
												
											$usuar = $this->User->find('first',array('conditions' => array('User.id'=>$userId)));
											$nameUsuario = $usuar['User']['first_name']." ".$usuar['User']['last_name'];
											$correo = 'noreply@correspondenciaestatal.gob.pa';
											$subject= $m['title'];
												
											$content = nl2br("Has recibido un mensaje de ".$nameUsuario." a través del Servicio de Correspondencia Estatal Electrónica.\n Se requiere que lo responda antes del ".$c['expires']);
											$Email = new CakeEmail();
											$to = $toArray;
											$Email->config('_3tp');
											$Email->to($to);
											$Email->subject($subject);
											$Email->from($correo);
											$Email->template('default');
											$Email->emailFormat('html');
											$Email->send($content);
										}
								}
							
							else {
								//comentado por solucion
								//$this->deleteAll($communicationId, $messageId);
								//$a['Request']['status'] = 300;
								//$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
								//return json_encode($a);
							}
							$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
						}						
					}
				}
				else {
					// error
					$this->deleteAll($communicationId);
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
					return json_encode($a);
				}
				$message_t = 'La comunicación ha sido enviada';
				if ($c['draft'] == 1) {
					$message_t = 'La comunicación ha sido guardada en la carpeta Borradores';
				} 
				$element = 'm_success';
				$this->Session->setFlash($message_t, $element);
				$a['Message'] = $message['Message'];
				$a['Communication']['id'] = $communicationId;
				$a['Request']['status'] = 200;
				$a['Request']['message'] = $message_t	;
				return json_encode($a);
			} else {
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
				return json_encode($a);
			} 


		}
		if (isset($_GET['usrid'])) {
			$users = $this->User->find('all', array('conditions'=>array('User.id' => $_GET['usrid'])));
			$this->set(compact('users'));
		}
		$communicationTypes = $this->CommunicationType->find('all', array(
			'conditions' => array(
				'CommunicationType.active' => 1,
				)
			)
		);

		$this->set(compact('communicationTypes'));
	}

	/**
	 * Function to set required signature attribute to a file 
	 */
	public function add_required(){
		$this->autoRender = false;
		$id = $_POST['file_id'];
		$signature = $_POST['signature'];
		
		$file = $this->Upload->findById($id);
		
		$file['Upload']['signature'] = $signature;
		
		if($this->Upload->saveChange($file)){
			
			return 'Ok';
		
		}else{
			
			return 'error';
		
		}
		
	}
	

	/**
	 * Function to check if a file is available to download 
	 */
	public function check_file(){
		
		$this->autoRender = false;

		$id = $_POST['file_id'];
		$userId = $_POST['user_id'];
		$file = $this->Upload->findById($id);
		$locked = $file['Upload']['locked'];

		//if the file is blocked, check te timeout to unblock it or 
		//let the last user download again.
		if($locked == 1){
			$lockedUntil = $file['Upload']['locked_until'];
			$lockedDate = new datetime($lockedUntil);
			$nowDate = new datetime('now');
			$lastUserId = $file['Upload']['last_user_id'];
			
			if($nowDate >= $lockedDate){
				

				$file['Upload']['last_user_id'] = null;
				$file['Upload']['locked'] = 0;
				$file['Upload']['locked_until'] = null;
				$file['Upload']['token'] = null;
				$this->Upload->saveChange($file);

				return 'Ok';

			}elseif ($userId == $lastUserId) {
				
				return 'Ok';

			}else{

				$user = $this->User->findById($file['Upload']['last_user_id']);
				$username = $user['User']['first_name'] . ' ' . $user['User']['last_name']; 
				return "El archivo se encuentra bloqueado hasta que el usuario $username lo vuelva a cargar, o hasta que finalice el tiempo de espera ($lockedUntil)";
			
			}
			
		}else{
			return 'Ok';
		}
		
	}


	/**
	 * Function to block a file to prevent download it
	 */
	public function block_file(){
		$this->autoRender = false;
		$id = $_POST['file_id'];
		$userId = $_POST['user_id'];
		
		$file = $this->Upload->findById($id);
		$file['Upload']['locked'] = 1;
		$file['Upload']['locked_until'] = date('Y-m-d H:i:s', (time()+(60*60*2)));
		$file['Upload']['last_user_id'] = $userId;
		$file['Upload']['token'] = md5(uniqid(mt_rand(), true));

		if($this->Upload->saveChange($file)){
			
			return 'Ok';
		
		}else{
			
			return 'error';
		
		}
		
	}
	

	public function forward($idCommunication){

		# previamente se deberia chequear si quien esta logueado puede reenviar esta comunicacion
		//$this->Communication->recursive = -1;
		$communication = $this->Trace->find('first', array('conditions' => array('communication_id' => $idCommunication), 'order' => array('Message.id' => 'DESC')));
		$communicationTypes = $this->CommunicationType->find('all', array(
			'conditions' => array(
				'CommunicationType.active' => 1,
				)
			)
		);
		$uploads = $this->Upload->getDocuments($communication['Message']['id']);

		$all_messages = $this->Trace->find('all', array('conditions' => array('Trace.communication_id' =>  $idCommunication)));
		$this->set(compact('communicationTypes'));
		$this->set('message2', $communication['Message']);
		$this->set('uploads', $uploads);


		$id = $idCommunication;


		$this->Communication->unbindModel(
	        array('hasMany' => array('Trace', 'CommunicationToken'))
	    );
		$communication = $this->Communication->findById($id);
		$tokens = $this->CommunicationToken->getTokens($id);
		//  quien esté logueado y tenga que responder aparezcan los nombres en el TO
		$trcs = $this->Trace->find('list', array(
			'conditions' => array(
				'communication_id' => $id,
				//'receive_user_id' => $userId
				),
			'fields' => array('receive_user_id'),
			'group' => array('receive_user_id')
			)
		);
		$users = $this->User->find('all', array('conditions'=>array('User.id' => $trcs)));
		$userOwner = $this->User->findById($communication['Communication']['user_id']);
		$userOwner['User']['owner'] = true;
		array_push($users, $userOwner);
		// debug($users, $showHtml = null, $showFrom = true);
		$this->set(compact('users'));

		$communication['Tokens'] = $tokens;
		$this->Trace->recursive = 1;
		// para obtener los mensajes pertenecientes a la comunicacion solamente
		$traces = $this->Trace->find('all', array(
			'conditions' => array(
				'communication_id' => $id,
				),
			'group' => array('message_id')
			)
		);
		$messageApprovals['approved']['cant'] = 0;
		$messageApprovals['approved']['users'] = array();
		$messageApprovals['rejected']['cant'] = 0;
		$messageApprovals['rejected']['users'] = array();
		$messageApprovals['modified']['cant'] = 0;
		$messageApprovals['modified']['users'] = array();
		$messageApprovals['none']['cant'] = 0;
		$messageApprovals['none']['users'] = array();

		$canApprove = array();
		$messages = array();
		foreach ($traces as $key => $trace) {
			//debug($trace, $showHtml = null, $showFrom = true);
			$uploads = $this->Upload->getDocuments($trace['Message']['id']);
			$messages[$trace['Message']['id']]['approve'] = $trace['Trace']['approval'];
			$messages[$trace['Message']['id']]['Uploads'] = $uploads;
			$messages[$trace['Message']['id']]['Message'] = $trace['Message'];
			if ($trace['Trace']['approval'] == '-2') {
				$messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] + 1;
			}
			if ($trace['Trace']['approval'] == '-1') {
				$messageApprovals['rejected']['cant'] = $messageApprovals['rejected']['cant'] + 1;
				array_push($messageApprovals['rejected']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			if ($trace['Trace']['approval'] == 1) {
				$messageApprovals['approved']['cant'] = $messageApprovals['approved']['cant'] + 1;
				array_push($messageApprovals['approved']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			if ($trace['Trace']['approval'] == 2) {
				$messageApprovals['modified']['cant'] = $messageApprovals['modified']['cant'] + 1;
				array_push($messageApprovals['modified']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			
			$communication['Communication']['title'] = $trace['Message']['title'];
			$tracesm = $this->Trace->find('all', array(
				'conditions' => array(
					'communication_id' => $id,
					'message_id' => $trace['Message']['id']
					),
				)
			);
			$messages[$trace['Message']['id']]['UserReceivers'] = array();
			$messages[$trace['Message']['id']]['EntitiesReceivers'] = array();
			$messages[$trace['Message']['id']]['EntitySender'] = '';
			$messages[$trace['Message']['id']]['UserSender'] = '';

			foreach ($tracesm as $key => $tracem) {
				$ur['id'] = $tracem['ReceiveUser']['id'];
				$ur['username'] = $tracem['ReceiveUser']['username'];
				$ur['email'] = $tracem['ReceiveUser']['email'];
				$ur['first_name'] = $tracem['ReceiveUser']['first_name'];
				$ur['last_name'] = $tracem['ReceiveUser']['last_name'];
				$ur['position'] = $tracem['ReceiveUser']['position'];
				$ur['entity_id'] = $tracem['ReceiveUser']['entity_id'];
				$ur['type_delivery'] = $tracem['Trace']['type_delivery'];
				$ur['read'] = $tracem['Trace']['read'];
				$ur['read_datatime'] = $tracem['Trace']['read_datatime'];
				$messages[$trace['Message']['id']]['UserReceivers'][$ur['id']] = $ur;

				$us['id'] = $tracem['SenderUser']['id'];
				$us['username'] = $tracem['SenderUser']['username'];
				$us['email'] = $tracem['SenderUser']['email'];
				$us['first_name'] = $tracem['SenderUser']['first_name'];
				$us['last_name'] = $tracem['SenderUser']['last_name'];
				$us['entity_id'] = $tracem['SenderUser']['entity_id'];
				$us['position'] = $tracem['SenderUser']['position'];
				$messages[$trace['Message']['id']]['UserSender'] = $us;

				$er['id'] = $tracem['ReceiveEntitie']['id'];
				$er['name'] = $tracem['ReceiveEntitie']['name'];
				$er['description'] = $tracem['ReceiveEntitie']['description'];
				$messages[$trace['Message']['id']]['EntitiesReceivers'][$er['id']] = $er;

				$es['id'] = $tracem['SenderEntity']['id'];
				$es['name'] = $tracem['SenderEntity']['name'];
				$es['description'] = $tracem['SenderEntity']['description'];
				$messages[$trace['Message']['id']]['EntitySender'] = $es;
			}
		}

		// buscar quienes pueden aprobar en caso de que se pueda aprobar
		$this->Trace->recursive = -1;
	    $traces = $this->Trace->find('all', array(
	    	'conditions' => array(
				'communication_id' => $id,
				'requires_approval' => 1,
	    		),
	    	'fields' => array('receive_user_id')
	    	)
	    );
	    $messageApprovals['none']['cant'] = 0;
	    foreach ($traces as $key => $trace) {
			array_push($canApprove, $trace['Trace']['receive_user_id']);
			$messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] + 1;
	    }

	    $messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] - $messageApprovals['approved']['cant'] - $messageApprovals['rejected']['cant'] - $messageApprovals['modified']['cant'];

		krsort($messages);
		$communication['canApprove'] = $canApprove;
		$communication['Messages'] = $messages;
		$communication['MessagesApprovals'] = $messageApprovals;
		$this->set('communication', $communication);
		// debug($communication, $showHtml = null, $showFrom = true);
	}
/**
 * reply method
 *
 * @return void
 */
	public function reply($communicationId) {

		if ($this->request->is('post')) {

		
			$userId = $this->Session->read('UserAuth.User.id');
			$this->autoRender = false;
			$data = $this->request->data;
			
			$m['title'] = $data['title'];
			$m['content'] = $data['content'];
			$m['private'] = $data['message_private'];
			// $nameOfGroup = $data['nameGroup'];
			$nameOfGroup = "";

			$message = '';
			$communication = $this->Communication->findById($communicationId);
			$communication['Communication']['owner'] = $userId;
			$communication['Communication']['modified'] = date('Y-m-d H:i:s');
			if(!empty($data['fileReplace'])){
				$data['fileReplace'] = explode("-", $data['fileReplace']);
				unset($data['fileReplace'][count($data['fileReplace'])-1]);
				foreach ($data['fileReplace'] as $key => $value) {
					$Upload_data=$this->Upload->findDocumentsByName($value);
					$idUpload_data=$Upload_data[0]['Upload']['id'];
					$signature = $Upload_data[0]['Upload']['signature'];
					$update_data= array('Upload' => array('id' => $idUpload_data, 'message_id' =>0));
					$process_data=$this->Upload->saveChange($update_data);
					//el cero representa el numero de archivo que se subio
					$file_replace=$data['files'][$key];
					$file_data=$this->Upload->findDocumentsById($file_replace);
					$file_msjid=$Upload_data[0]['Upload']['message_id'];
						if($signature == 1){
							$update_file= array('Upload' => array('id' => $file_replace, 'message_id' =>$file_msjid, 'signature' => $signature));
						}else{
							$update_file= array('Upload' => array('id' => $file_replace, 'message_id' =>$file_msjid));
						}
					$process_file=$this->Upload->saveChange($update_file);
				}
			}

			$this->Communication->save($communication['Communication']);
			
			$this->Message->create();
			if ($this->Message->save($m)) {

				$messageId = $this->Message->getLastInsertID();
				$message = $this->Message->findById($messageId);			
				
				if(!empty($data['files'])){
					foreach ($data['files'] as $k => $v) {
						$UpFile = $this->Upload->findById($v);
						if($UpFile['Upload']['message_id'] == ''){
							$UpFile['Upload']['message_id'] = $messageId;
							$this->Upload->saveChange($UpFile);
						}
					}
				}

					
				// //modificar los uploads
				// if (isset($data['files'])){
				// 	$idFiles = $data['files'];
				// 	$uploads = $this->Upload->findById($idFiles);
				// 	foreach ($uploads as $key => $upload) {

				// 		if(!empty($data['fileReplace']))
				// 		{	
				// 			if (in_array($upload['id'] , $idFiles)){
				// 				$upload['message_id'] = $messageId;
				// 				$upload['temporal'] = null;
				// 				if ($this->Upload->saveChange($upload)){
				// 					// bien
				// 				}
				// 				else {
				// 					$this->deleteAll(null, $messageId);
				// 					$a['Request']['status'] = 300;
				// 					$a['Request']['message'] = 'Error tratando de enviar el mensaje';
				// 					return json_encode($a);
				// 				}
				// 			}
				// 			else {
				// 				$this->Upload->deleteRegistre($upload);
				// 			}
				// 		}
				// 		else{
				// 			$upload['message_id'] = $messageId;
				// 			$this->Upload->saveChange($upload);
				// 		}
				// 	}
				// }

				$t['communication_id'] = $communicationId;
				$t['message_id'] = $message['Message']['id'];
				$t['sender_user_id'] = $data['user_id'];
				$t['sender_entity_id'] = $data['entity_id'];
				$t['approval'] = $data['approval'];
				if(empty($data['asistencia'])){
					$t['asistencia'] = -1;
				}
				else{
					$t['asistencia'] = $data['asistencia'];
				}
				// indicar si requiere aprobacion
				//if ($data['action'] == 2){
				//	$t['requires_approval'] = 1;
				//}
				// elimino el token de quien envia
				$this->CommunicationToken->deleteToken($communicationId, $data['user_id']);

				foreach ($data['receivers'] as $key => $receive) {
					// chequeo si quien recibe es por to, por cc
					$deliveryType = ($receive['deliverytype'] == 'to') ? 0 : 1;
					// chequear si quien recibe es una entidad

					if ($receive['type'] == 'entity' || $receive['type'] == 'group' || $receive['type'] == 'circle'){
							
						if ($receive['type'] == 'entity'){
							$ents = $this->Entity->getAllDescentIds($receive['id']);
							// agrega la entidad tmb
							array_push($ents, $receive['id']);
							$users = $this->User->find('all', array('conditions' => array('entity_id' => $ents)));
						}
						elseif ($receive['type'] == 'group') {
							$groupId = $receive['id'];
							$users = $this->User->find('all', array(
								'conditions' => array(
									'group_id' => $groupId
									)
								)
							);
						}
						elseif ($receive['type'] == 'circle') {
							$circleId = $receive['id'];
							$usersId = $this->Circle->getIdUsersFromCircleId($circleId);
							$users = $this->User->find('all', array(
								'conditions' => array(
									'id' => $usersId
									)
								)
							);
						}
					
						foreach ($users as $key => $user) {

							// guardo en la tabla communication_trash
							$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user['User']['id'], $communicationId);
							if (!$communicationTrash) {
								$this->CommunicationTrash->create();
								$communicationTrash['user_id'] = $user['User']['id'];
								$communicationTrash['trash'] = 0;
								$communicationTrash['communication_id'] = $communicationId;
								if ($this->CommunicationTrash->save($communicationTrash)) {
									// exitoso
								}
								else {
									//error
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
									return json_encode($a);
								}
							}

							$t['receive_user_id'] =$user['User']['id'];
							$t['receive_entity_id'] =$user['User']['entity_id'];
							$t['type_delivery'] = $deliveryType;
							// indicar si requiere aprobacion
							//if ($data['action'] == 2){
							///	$t['requires_approval'] = 1;
							//}

							$this->Trace->create();
							if ($this->Trace->save($t)) {

							}
							else {
								$this->deleteAll(null, $messageId);
								$a['Request']['status'] = 300;
								$a['Request']['message'] = 'Error tratando de enviar el mensaje'	;
								return json_encode($a);
							}
							$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
							// chequear si el mensaje es privado
							if ($data['message_private'] == 0){
								$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
								if (!empty($redirecs)) {
									foreach ($redirecs as $key => $rd) {
										if ($rd == $userId) continue; // no me reenvio el msj
										$user2 = $this->User->findById($rd);

										// guardo en la tabla trash
										$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user2['User']['id'], $communicationId);
										if (!$communicationTrash) {
											$this->CommunicationTrash->create();
											$communicationTrash['user_id'] = $user2['User']['id'];
											$communicationTrash['trash'] = 0;
											$communicationTrash['communication_id'] = $communicationId;
											if ($this->CommunicationTrash->save($communicationTrash)) {
												// exitoso
											}
											else {
												//error
												$this->deleteAll($communicationId, $messageId);
												$a['Request']['status'] = 300;
												$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
												return json_encode($a);
											}
										}

										$t['receive_user_id'] =$user2['User']['id'];
										$t['receive_entity_id'] =$user2['User']['entity_id'];
										$t['type_delivery'] = $deliveryType;
										$t['requires_approval'] = 0;
										$t['approval'] = 0;

										$this->Trace->create();
										if ($this->Trace->save($t)) {
											// exitoso
										}
										else {
											//error
											$this->deleteAll($communicationId, $messageId);
											$a['Request']['status'] = 300;
											$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
											return json_encode($a);
										}
										$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
									}
								}
							}
						}
					}
					/*
					// quien recibe es un grupo
					elseif ($receive['type'] == 'group') {
						$groupId = $receive['id'];
						$users = $this->User->find('all', array(
							'conditions' => array(
								'group_id' => $groupId
								)
							)
						);
						foreach ($users as $key => $user) {

							// guardo en la tabla communication_trash
							$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user['User']['id'], $communicationId);
							if (!$communicationTrash) {
								$this->CommunicationTrash->create();
								$communicationTrash['user_id'] = $user['User']['id'];
								$communicationTrash['trash'] = 0;
								$communicationTrash['communication_id'] = $communicationId;
								if ($this->CommunicationTrash->save($communicationTrash)) {
									// exitoso
								}
								else {
									//error
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
									return json_encode($a);
								}
							}

							// lista de ids a quienes tambien se les debe enviar el mensaje
							$t['receive_user_id'] =$user['User']['id'];
							$t['receive_entity_id'] =$user['User']['entity_id'];
							$t['type_delivery'] = $deliveryType;

							// indicar si requiere aprobacion
							//if ($data['action'] == 2){
							//	$t['requires_approval'] = 1;
							//}

							$this->Trace->create();
							if ($this->Trace->save($t)) {
								// exitoso
							}
							else {
								//error
								$this->deleteAll($communicationId, $messageId);
								$a['Request']['status'] = 300;
								$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
								return json_encode($a);
							}
							$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
							// chequear si el mensaje es privado
							if ($data['message_private'] == 0){
								$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
								if (!empty($redirecs)) {
									foreach ($redirecs as $key => $rd) {
										if ($rd == $userId) continue; // no me reenvio el msj
										$user2 = $this->User->findById($rd);

										// guardo en la tabla trash
										$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user2['User']['id'], $communicationId);
										if (!$communicationTrash) {
											$this->CommunicationTrash->create();
											$communicationTrash['user_id'] = $user2['User']['id'];
											$communicationTrash['trash'] = 0;
											$communicationTrash['communication_id'] = $communicationId;
											if ($this->CommunicationTrash->save($communicationTrash)) {
												// exitoso
											}
											else {
												//error
												$this->deleteAll($communicationId, $messageId);
												$a['Request']['status'] = 300;
												$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
												return json_encode($a);
											}
										}
										$t['receive_user_id'] =$user2['User']['id'];
										$t['receive_entity_id'] =$user2['User']['entity_id'];
										$t['type_delivery'] = $deliveryType;
										// los redirects nunca aprueban
										$t['requires_approval'] = 0;
										$t['approval'] = 0;

										$this->Trace->create();
										if ($this->Trace->save($t)) {
											// exitoso
										}
										else {
											//error
											$this->deleteAll($communicationId, $messageId);
											$a['Request']['status'] = 300;
											$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
											return json_encode($a);
										}
										$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
									}
								}
							}
						}
					}
					*/
					// quien recibe es un usuario
					else {
						$user = $this->User->findById($receive['id']);
						$this->Trace->create();

						// guardo en la tabla communication_trash
						$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user['User']['id'], $communicationId);
						if (!$communicationTrash) {
							$this->CommunicationTrash->create();
							$communicationTrash['user_id'] = $user['User']['id'];
							$communicationTrash['trash'] = 0;
							$communicationTrash['communication_id'] = $communicationId;
							if ($this->CommunicationTrash->save($communicationTrash)) {
								// exitoso
							}
							else {
								//error
								$this->deleteAll($communicationId, $messageId);
								$a['Request']['status'] = 300;
								$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
								return json_encode($a);
							}
						}

						$t['receive_user_id'] =$user['User']['id'];
						$t['receive_entity_id'] =$user['User']['entity_id'];
						$t['type_delivery'] = $deliveryType;
						// indicar si requiere aprobacion
						//if ($data['action'] == 2){
						//	$t['requires_approval'] = 1;
						//}
						if ($this->Trace->save($t)) {
							// chequear si el mensaje es privado
							if ($data['message_private'] == 0){
								$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
								if (!empty($redirecs)) {
									foreach ($redirecs as $key => $rd) {
										if ($rd == $userId) continue; // no me reenvio el msj
										$user2 = $this->User->findById($rd);

										// guardo en la tabla trash
										$communicationTrash = $this->CommunicationTrash->findByUserIdAndCommunicationId($user2['User']['id'], $communicationId);
										if (!$communicationTrash) {
											$this->CommunicationTrash->create();
											$communicationTrash['user_id'] = $user2['User']['id'];
											$communicationTrash['trash'] = 0;
											$communicationTrash['communication_id'] = $communicationId;
											if ($this->CommunicationTrash->save($communicationTrash)) {
												// exitoso
											}
											else {
												//error
												$this->deleteAll($communicationId, $messageId);
												$a['Request']['status'] = 300;
												$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
												return json_encode($a);
											}
										}

										$t['receive_user_id'] =$user2['User']['id'];
										$t['receive_entity_id'] =$user2['User']['entity_id'];
										$t['type_delivery'] = $deliveryType;
										$t['requires_approval'] = 0;
										$t['approval'] = 0;

										$this->Trace->create();
										if ($this->Trace->save($t)) {
											


										}
										else {
											//error
											$this->deleteAll($communicationId, $messageId);
											$a['Request']['status'] = 300;
											$a['Request']['message'] = 'Error tratando de enviar la comunicación'	;
											return json_encode($a);
										}
										$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
									}
								}
							}
						}
						else {
							$this->deleteAll(null, $messageId);
							$a['Request']['status'] = 300;
							$a['Request']['message'] = 'Error tratando de enviar el mensaje';
							return json_encode($a);
						}
						$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
					}						
				}

				// preparando la salida
				$traces = $this->Trace->find('all', array(
					'conditions' => array(
						'communication_id' => $communicationId,
						'message_id' => $message['Message']['id']
						),
					'group' => array('message_id')
					)
				);
				
				$messages = array();
				foreach ($traces as $key => $trace) {

					$uploads = $this->Upload->getDocuments($trace['Message']['id']);

					$messages[$trace['Message']['id']]['approve'] = $trace['Trace']['approval'];
					$messages[$trace['Message']['id']]['Uploads'] = $uploads;
					$messages[$trace['Message']['id']]['Message'] = $trace['Message'];
					$tracesm = $this->Trace->find('all', array(
						'conditions' => array(
							'communication_id' => $communicationId,
							'message_id' => $trace['Message']['id']
							),
						)
					);
					$messages[$trace['Message']['id']]['UserReceivers'] = array();
					$messages[$trace['Message']['id']]['EntitiesReceivers'] = array();
					$messages[$trace['Message']['id']]['EntitySender'] = '';
					$messages[$trace['Message']['id']]['UserSender'] = '';

					foreach ($tracesm as $key => $tracem) {
						$ur['id'] = $tracem['ReceiveUser']['id'];
						$ur['username'] = $tracem['ReceiveUser']['username'];
						$ur['email'] = $tracem['ReceiveUser']['email'];
						$ur['first_name'] = $tracem['ReceiveUser']['first_name'];
						$ur['last_name'] = $tracem['ReceiveUser']['last_name'];
						$ur['entity_id'] = $tracem['ReceiveUser']['entity_id'];
						$ur['position'] = $tracem['ReceiveUser']['position'];
						$ur['type_delivery'] = $tracem['Trace']['type_delivery'];
						$messages[$trace['Message']['id']]['UserReceivers'][$ur['id']] = $ur;

						$us['id'] = $tracem['SenderUser']['id'];
						$us['username'] = $tracem['SenderUser']['username'];
						$us['email'] = $tracem['SenderUser']['email'];
						$us['first_name'] = $tracem['SenderUser']['first_name'];
						$us['last_name'] = $tracem['SenderUser']['last_name'];
						$us['position'] = $tracem['SenderUser']['position'];
						$us['entity_id'] = $tracem['SenderUser']['entity_id'];
						$messages[$trace['Message']['id']]['UserSender'] = $us;

						$er['id'] = $tracem['ReceiveEntitie']['id'];
						$er['name'] = $tracem['ReceiveEntitie']['name'];
						$er['description'] = $tracem['ReceiveEntitie']['description'];
						$messages[$trace['Message']['id']]['EntitiesReceivers'][$er['id']] = $er;

						$es['id'] = $tracem['SenderEntity']['id'];
						$es['name'] = $tracem['SenderEntity']['name'];
						$es['description'] = $tracem['SenderEntity']['description'];
						$messages[$trace['Message']['id']]['EntitySender'] = $es;
					}
				}


		$theLastTrace = $this->Trace->find('first',array('order' => 'Trace.id DESC'));
		$this->Trace->recursive = -1;
			if(isset($nameOfGroup)){
				foreach ($nameOfGroup as $ey => $ue) {
					if($ey%2!=0){
						foreach ($ue as $y => $e) {
							$allTraceLast = $this->Trace->find('first',array('conditions' => array('Trace.message_id' => $theLastTrace['Trace']['message_id'], 'Trace.receive_user_id' => $e)));
							$allTraceLast['Trace']['namegroup'] = $nameOfGroup[$ey-1];
							if($this->Trace->save($allTraceLast)){
							}
						}
					}
				}
			}
				krsort($messages);
				$m['Messages'] = $messages;
				$m['Communication']['id'] = $communicationId;
				$m['Request']['status'] = 200;
				$m['Request']['message'] = 'La respuesta ha sido enviada';
				return json_encode($m);
			}
			else {
				//error
				$this->deleteAll(null, $messageId);
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Error tratando de enviar el mensaje'	;
				return json_encode($a);
			}
		}

	}

	public function edit($communicationId) {
		
	
		if ($this->request->is('post')) {
			$this->autoRender = false;
			
			$data = $this->request->data;
			
			$userId = $this->Session->read('UserAuth.User.id');

			$action = 0;
			if (isset($data['action'])) $action = $data['action'];
			$c['id'] = $data['communication_id'];
			$c['entity_id'] = $data['entity_id'];
			$c['expires'] = $data['expires'];
			$c['correlative']=$data['correlative'];
			$c['created'] = date("Y-m-d H:i:s"); 
			$c['user_id'] = $data['user_id'];
			$c['communication_category_id'] = $data['communication_category_id'];
			$c['communication_type_id'] = $data['communication_type_id'];
			$c['action_id'] = $action;
			$c['draft'] = $data['draft'];
			$m['id'] = $data['message_id'];
			$m['title'] = $data['title'];
			$m['content'] = $data['content'];
			$m['private'] = $data['message_private'];

			$message = '';
			$communication = '';

			// editar la comunicacion
			if ($this->Communication->save($c)) {
				$communicationId = $c['id'];
				$communication = $this->Communication->findById($communicationId);

				// editar el mensaje 
				if ($this->Message->save($m)) {
					$messageId = $m['id'];
					$message = $this->Message->findById($messageId);

					// modificar los uploads
					if (isset($data['files'])){
						$idTemporal = $data['temporal_id'];
						$idFiles = $data['files'];
						$uploads = $this->Upload->findDocumentsByTemporal($idTemporal);

						foreach ($uploads as $key => $upload) {
							// chequeo 
							if (in_array($upload['Upload']['id'] , $idFiles)){
								$upload['Upload']['message_id'] = $messageId;
								$upload['Upload']['temporal'] = null;
								if ($this->Upload->saveChange($upload)){
									// bien
								}
								else {
									// error
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
									return json_encode($a);
								}
							}
							else {
								$this->Upload->deleteRegistre($upload);
							}
						};
					}

					// actualizar si se requiere aprobacion o no a los usuarios previos
					$traces = $this->Trace->find('all', array(
						'conditions' => array(
							'communication_id' => $communicationId,
							'message_id' => $messageId
							)
						)
					);
					foreach ($traces as $key => $trace) {
						// indicar si requiere aprobacion
						if ($action == 2){
							$trace['Trace']['requires_approval'] = 1;
						} else {
							$trace['Trace']['requires_approval'] = 0;
						}
						if ($this->Trace->save($trace)) {
							// exitoso
						}
						else {
							//error
							$this->deleteAll($communicationId, $messageId);
							$a['Request']['status'] = 300;
							$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
							return json_encode($a);
						}
					}

					// guardar los formatos
					if (isset($data['formats'])){
						$formats = $data['formats'];
						foreach ($formats as $key => $idFormat) {
							if ($this->Upload->saveFormatToMessage($idFormat, $messageId)) {
								// bien
							}
							else {
								$this->deleteAll($communicationId, $messageId);
							}
						};
					}

					$t['communication_id'] = $communication['Communication']['id'];
					$t['message_id'] = $message['Message']['id'];
					$t['sender_user_id'] = $data['user_id'];
					$t['sender_entity_id'] = $data['entity_id'];

					// elimino el token de quien envia
					$this->CommunicationToken->deleteToken($communicationId, $data['user_id']);
					if (isset($data['receivers']) && !empty($data['receivers'])){ 
					// guardar quienes reciben el mensaje
						foreach ($data['receivers'] as $key => $receive) {
							// si es to, es mensaje directo, si es cc es con copia 
							$deliveryType = ($receive['deliverytype'] == 'to') ? 0 : 1;
							// chequear si quien recibe es una entidad
							if ($receive['type'] == 'entity'){
								$ents = $this->Entity->getAllDescentIds($receive['id']);
								// agrega la entidad tmb
								array_push($ents, $receive['id']);
								$users = $this->User->find('all', array(
									'conditions' => array(
										'entity_id' => $ents
										)
									)
								);
								//$users = $this->User->getUsersFromEntity($receive['id']);
								foreach ($users as $key => $user) {
									// lista de ids a quienes tambien se les debe enviar el mensaje

									$t['receive_user_id'] =$user['User']['id'];
									$t['receive_entity_id'] =$user['User']['entity_id'];
									$t['type_delivery'] = $deliveryType;

									// indicar si requiere aprobacion
									if ($action == 2){
										$t['requires_approval'] = 1;
									}

									$this->Trace->create();
									if ($this->Trace->save($t)) {
										// exitoso
									}
									else {
										//error
										$this->deleteAll($communicationId, $messageId);
										$a['Request']['status'] = 300;
										$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
										return json_encode($a);
									}
									$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
									// chequear si el mensaje es privado
									if ($data['message_private'] == 0){
										$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
										if (!empty($redirecs)) {
											foreach ($redirecs as $key => $rd) {
												if ($rd == $userId) continue; // no me reenvio el msj
												$user2 = $this->User->findById($rd);
												$t['receive_user_id'] =$user2['User']['id'];
												$t['receive_entity_id'] =$user2['User']['entity_id'];
												$t['type_delivery'] = $deliveryType;
												// los redirects nunca aprueban
												$t['requires_approval'] = 0;
												$this->Trace->create();
												if ($this->Trace->save($t)) {
													// exitoso
												}
												else {
													//error
													$this->deleteAll($communicationId, $messageId);
													$a['Request']['status'] = 300;
													$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
													return json_encode($a);
												}
												$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
											}
										}
									}
								}
							}
							// quien recibe es un grupo
							elseif ($receive['type'] == 'group') {
								$groupId = $receive['id'];
								$users = $this->User->find('all', array(
									'conditions' => array(
										'group_id' => $groupId
										)
									)
								);
								foreach ($users as $key => $user) {
									// lista de ids a quienes tambien se les debe enviar el mensaje

									$t['receive_user_id'] =$user['User']['id'];
									$t['receive_entity_id'] =$user['User']['entity_id'];
									$t['type_delivery'] = $deliveryType;

									// indicar si requiere aprobacion
									if ($action == 2){
										$t['requires_approval'] = 1;
									}

									$this->Trace->create();
									if ($this->Trace->save($t)) {
										// exitoso
									}
									else {
										//error
										$this->deleteAll($communicationId, $messageId);
										$a['Request']['status'] = 300;
										$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
										return json_encode($a);
									}
									$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
									// chequear si el mensaje es privado
									if ($data['message_private'] == 0){
										$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
										if (!empty($redirecs)) {
											foreach ($redirecs as $key => $rd) {
												if ($rd == $userId) continue; // no me reenvio el msj
												$user2 = $this->User->findById($rd);
												$t['receive_user_id'] =$user2['User']['id'];
												$t['receive_entity_id'] =$user2['User']['entity_id'];
												$t['type_delivery'] = $deliveryType;
												// los redirects nunca aprueban
												$t['requires_approval'] = 0;
												$this->Trace->create();
												if ($this->Trace->save($t)) {
													// exitoso
												}
												else {
													//error
													$this->deleteAll($communicationId, $messageId);
													$a['Request']['status'] = 300;
													$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
													return json_encode($a);
												}
												$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
											}
										}
									}
								}
							}
							// quien recibe es un usuario
							else {
								$user = $this->User->findById($receive['id']);
								$this->Trace->create();
								$t['receive_user_id'] =$user['User']['id'];
								$t['receive_entity_id'] =$user['User']['entity_id'];
								$t['type_delivery'] = $deliveryType;
								// indicar si requiere aprobacion
								if ($action == 2){
									$t['requires_approval'] = 1;
								}

								if ($this->Trace->save($t)) {
									// se lo envio a quienes tengo en mi lista de redireccion
									// chequear si el mensaje es privado
									if ($data['message_private'] == 0){
										$redirecs = $this->Redirection->findUserIdRedirection($user['User']['id']);
										if (!empty($redirecs)) {
											foreach ($redirecs as $key => $rd) {
												if ($rd == $userId) continue; // no me reenvio el msj
												$user2 = $this->User->findById($rd);
												$t['receive_user_id'] =$user2['User']['id'];
												$t['receive_entity_id'] =$user2['User']['entity_id'];
												$t['type_delivery'] = $deliveryType;
												// los redirects nunca aprueban
												$t['requires_approval'] = 0;
												$this->Trace->create();
												if ($this->Trace->save($t)) {
													// exito
												}
												else {
													//error
													$this->deleteAll($communicationId, $messageId);
													$a['Request']['status'] = 300;
													$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
													return json_encode($a);
												}
												$this->CommunicationToken->createToken($communicationId, $user2['User']['id']);
											}
										}
									}
								}
								else {
									$this->deleteAll($communicationId, $messageId);
									$a['Request']['status'] = 300;
									$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
									return json_encode($a);
								}
								$this->CommunicationToken->createToken($communicationId, $user['User']['id']);
							}						
						}
					}
				}
				else {
					// error
					$this->deleteAll($communicationId);
					$a['Request']['status'] = 300;
					$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
					return json_encode($a);
				}
				$message_t = 'La comunicación ha sido enviada';
				if ($c['draft'] == 1) {
					$message_t = 'La comunicación ha sido guardada en la carpeta Borradores';
				} 
				$element = 'm_success';
				$this->Session->setFlash($message_t, $element);
				$a['Message'] = $message['Message'];
				$a['Request']['status'] = 200;
				
				
				$a['Communication']['id'] = $data['communication_id'];
				
				$a['Message']['id'] = $data['message_id'];
				
				
				
				$a['Request']['message'] = $message_t	;
				return json_encode($a);
			} else {
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente'	;
				return json_encode($a);
			} 
		}
		/*
		if (isset($_GET['usrid'])) {
			$users = $this->User->find('all', array('conditions'=>array('User.id' => $_GET['usrid'])));
			$this->set(compact('users'));
		}
		$communicationTypes = $this->CommunicationType->find('all', array(
			'conditions' => array(
				'CommunicationType.active' => 1,
				)
			)
		);

		$this->set(compact('communicationTypes'));
		*/
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		
		
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		
		//var_dump($this->Communication->find('count' ,array ('conditions' => array ('Communication.id' => $id , 'Communication.action_id' => 7))));
		if($this->Communication->find('count' ,array ('conditions' => array ('Communication.id' => $id , 'Communication.action_id' => 7)))){
		
		$c = $this->Trace->find('all' , array('conditions' => array('communication_id' => $id , 'Trace.sender_user_id != Trace.receive_user_id'), 'fields' => array('DISTINCT Trace.receive_user_id')));
		
		$communication = $this->Trace->find('first', array('conditions' => array('communication_id' => $id), 'order' => array('Trace.id' => 'DESC')));
		
		$this->set('message2', $communication);
		
		if(count($c) == 1){
			$c = count($c)+1;
		}
		else{
			$c = count($c);
		}
		
		
		$d = $this->SignedCommunication->find('count', array('conditions' => array('communication_id' => $id ,'status' => 'firmado')));
		
		
		$nowDate = date("Y-m-d H:i:s");
		$e = $this->Communication->find('count', array('conditions' => array('Communication.expires <=' => $nowDate , 'Communication.id' => $id , 'Communication.action_id' => 7)));
		
		
		if($c==$d || $e > 0){
				
			$blo = 1;
		}
		else{
			$blo = 0;
		}
		
		}
		else{
			
			$blo = 1;
		}
		
		function vFirma($filename){
		
			$firstChunkLength = 15;
			$lastChunkLength = 30;
			$result = false;
		
			try {
		
				if (file_exists($filename)){
		
					$size = filesize($filename);
					$handle = fopen($filename,'r');
					$firstChunk = fread($handle,$firstChunkLength);
					fseek($handle, $size - $lastChunkLength);
					$lastChunk = fread($handle, $lastChunkLength);
					fclose($handle);
		
					$check1 = preg_match('/%PDF\-(\d+)\.(\d+)[\\r|\\n]%/', $firstChunk, $matches);
					$check2 = preg_match('/(\\r*)(\\n*)startxref(\\r*)\\n(\d+)(\\r*)\\n%%EOF(\\r*)(\\n*)/', $lastChunk, $matches);
					$result = $check1 && $check2;
		
					//echo sprintf("%s-%b-%b-%b<br> %s<br> %s<br><br>",$filename,$result,$check1,$check2,$firstChunk,$lastChunk);
		
				}
		
			} catch (Exception $e){
				$result = false;
			}
		
			return $result;
		
		}
		
		$userId = $this->Session->read('UserAuth.User.id');

		$isTrash = false;
		if (isset($_GET['trash'])) $isTrash = true;
		// buscar en los traces que sean para mi y que no esten marcados como leidos y agregarlo al controlviews
		$traces = $this->Trace->find('all', array(
			'conditions' => array(
				'Trace.communication_id' => $id,
				'Trace.receive_user_id' => $userId,
				'Trace.read' => 0,
				'Communication.draft' => 0
				)
			)
		);
		foreach ($traces as $key => $trace) {
			$this->ControlView->create();
			$controlv['communication_id'] = $id;
			$controlv['sender_user_id'] = $trace['Trace']['sender_user_id'];
			$controlv['receive_user_id'] = $trace['Trace']['receive_user_id'];
			$this->ControlView->save($controlv);
		}

		// quitar del controlview los que yo envie
		$this->ControlView->deleteAll(array('communication_id' => $id, 'sender_user_id' => $userId));
		// agregar en communicationview
		$cv['user_id'] = $userId;
		$cv['communication_id'] = $id;
		if ($this->CommunicationView->saveCV($cv)){
			// exito
		}
		else {
			// error
		}
		//marco como leido el mensaje
		$this->Trace->markAsRead($id, $userId);

		$this->Communication->unbindModel(
	        array('hasMany' => array('Trace', 'CommunicationToken'))
	    );
		$communication = $this->Communication->findById($id);
		$tokens = $this->CommunicationToken->getTokens($id);
		//  quien esté logueado y tenga que responder aparezcan los nombres en el TO
		$trcs = $this->Trace->find('list', array(
			// 'order' => 'id ASC',
			'conditions' => array(
				'communication_id' => $id,
				//'receive_user_id' => $userId
				),
			'fields' => array('receive_user_id'),
			'group' => array('receive_user_id')
			)
		);
		// debug($id);
		// debug($trcs);
		$users = $this->User->find('all', array('conditions'=>array('User.id' => $trcs)));
		// debug($users);
		
		if($communication['Communication']['owner'] == $userId)	{
			$userOwner = $users[0];
		}
		else{
			$userOwner = $this->User->findById($communication['Communication']['owner']);
		}

		
		$userOwner['User']['owner'] = true;
				// debug($userOwner);

		array_push($users, $userOwner);
		// debug($users, $showHtml = null, $showFrom = true);
		$this->set(compact('users'));

		$communication['Tokens'] = $tokens;
		$this->Trace->recursive = 1;
		// para obtener los mensajes pertenecientes a la comunicacion solamente
		$traces = $this->Trace->find('all', array(
			'conditions' => array(
				'communication_id' => $id,
				),
			'group' => array('message_id')
			)
		);
		$messageApprovals['approved']['cant'] = 0;
		$messageApprovals['approved']['users'] = array();
		$messageApprovals['rejected']['cant'] = 0;
		$messageApprovals['rejected']['users'] = array();
		$messageApprovals['modified']['cant'] = 0;
		$messageApprovals['modified']['users'] = array();
		$messageApprovals['none']['cant'] = 0;
		$messageApprovals['none']['users'] = array();
		
		$asistencia['asistencia']['si'] = 0;
		$asistencia['asistencia']['siusers'] = array();
		$asistencia['asistencia']['no'] = 0;
		$asistencia['asistencia']['nousers'] = array();
		$asistencia['asistencia']['none'] = 0;
		
		$canApprove = array();
		$messages = array();
		foreach ($traces as $key => $trace) {
			//debug($trace, $showHtml = null, $showFrom = true);
			$uploads = $this->Upload->getDocuments($trace['Message']['id']);
			//debug($uploads);
			//die;
			$messages[$trace['Message']['id']]['approve'] = $trace['Trace']['approval'];
			$messages[$trace['Message']['id']]['asistencia'] = $trace['Trace']['asistencia'];
			$messages[$trace['Message']['id']]['Uploads'] = $uploads;
			$messages[$trace['Message']['id']]['Message'] = $trace['Message'];
			
			if ($trace['Trace']['asistencia'] == 1) {
				$asistencia['asistencia']['si']++;
				array_push($asistencia['asistencia']['siusers']  , $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}

			if ($trace['Trace']['asistencia'] == 0) {
				$asistencia['asistencia']['no']++;
				array_push($asistencia['asistencia']['nousers']  , $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			
			if ($trace['Trace']['approval'] == '-2') {
				$messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] + 1;
			}
			if ($trace['Trace']['approval'] == '-1') {
				$messageApprovals['rejected']['cant'] = $messageApprovals['rejected']['cant'] + 1;
				array_push($messageApprovals['rejected']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			if ($trace['Trace']['approval'] == 1) {
				$messageApprovals['approved']['cant'] = $messageApprovals['approved']['cant'] + 1;
				array_push($messageApprovals['approved']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			if ($trace['Trace']['approval'] == 2) {
				$messageApprovals['modified']['cant'] = $messageApprovals['modified']['cant'] + 1;
				array_push($messageApprovals['modified']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			
			$communication['Communication']['title'] = $trace['Message']['title'];
			$tracesm = $this->Trace->find('all', array(
				'conditions' => array(
					'communication_id' => $id,
					'message_id' => $trace['Message']['id']
					),
				)
			);
			$messages[$trace['Message']['id']]['UserReceivers'] = array();
			$messages[$trace['Message']['id']]['EntitiesReceivers'] = array();
			$messages[$trace['Message']['id']]['EntitySender'] = '';
			$messages[$trace['Message']['id']]['UserSender'] = '';

			foreach ($tracesm as $key => $tracem) {
				$ur['id'] = $tracem['ReceiveUser']['id'];
				$ur['username'] = $tracem['ReceiveUser']['username'];
				$ur['email'] = $tracem['ReceiveUser']['email'];
				$ur['first_name'] = $tracem['ReceiveUser']['first_name'];
				$ur['last_name'] = $tracem['ReceiveUser']['last_name'];
				$ur['position'] = $tracem['ReceiveUser']['position'];
				$ur['entity_id'] = $tracem['ReceiveUser']['entity_id'];
				$ur['type_delivery'] = $tracem['Trace']['type_delivery'];
				$ur['read'] = $tracem['Trace']['read'];
				$ur['read_datatime'] = $tracem['Trace']['read_datatime'];
				$messages[$trace['Message']['id']]['UserReceivers'][$ur['id']] = $ur;
				
				$us['id'] = $tracem['SenderUser']['id'];
				$us['username'] = $tracem['SenderUser']['username'];
				$us['email'] = $tracem['SenderUser']['email'];
				$us['first_name'] = $tracem['SenderUser']['first_name'];
				$us['last_name'] = $tracem['SenderUser']['last_name'];
				$us['entity_id'] = $tracem['SenderUser']['entity_id'];
				$us['position'] = $tracem['SenderUser']['position'];
				$messages[$trace['Message']['id']]['UserSender'] = $us;

				$er['id'] = $tracem['ReceiveEntitie']['id'];
				$er['name'] = $tracem['ReceiveEntitie']['name'];
				$er['description'] = $tracem['ReceiveEntitie']['description'];
				$messages[$trace['Message']['id']]['EntitiesReceivers'][$er['id']] = $er;

				$es['id'] = $tracem['SenderEntity']['id'];
				$es['name'] = $tracem['SenderEntity']['name'];
				$es['description'] = $tracem['SenderEntity']['description'];
				$messages[$trace['Message']['id']]['EntitySender'] = $es;
			}
		}

		// buscar quienes pueden aprobar en caso de que se pueda aprobar
		$this->Trace->recursive = -1;
	    $traces = $this->Trace->find('all', array(
	    	'conditions' => array(
				'communication_id' => $id,
				'requires_approval' => 1,
	    		),
	    	'fields' => array('receive_user_id')
	    	)
	    );

	     $traces2 = $this->Trace->find('all', array(
	    	'conditions' => array(
				'communication_id' => $id,
	    		)
	    	)
	    );

	     $traces3 = $this->Trace->find('all', array(
	     		'conditions' => array(
	     				'communication_id' => $id,
						'asistencia' => -1,
	     		),
				'group' => array('receive_user_id'),
	     		'fields' => array('receive_user_id')
	     	)
	     );
	     
	    $messageApprovals['none']['cant'] = 0;
	    foreach ($traces as $key => $trace) {
			array_push($canApprove, $trace['Trace']['receive_user_id']);
			$messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] + 1;
	    }

	    foreach ($traces3 as $key => $trace) {
	    	$asistencia['asistencia']['none']++;				
	    }
	    
	    $asistencia['asistencia']['none'] = $asistencia['asistencia']['none'] - $asistencia['asistencia']['si'] - $asistencia['asistencia']['no'];
	    
	    $messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] - $messageApprovals['approved']['cant'] - $messageApprovals['rejected']['cant'] - $messageApprovals['modified']['cant'];
	    
		krsort($messages);
		$communication['canApprove'] = $canApprove;
		
		
		$communication['Messages'] = $messages;
		$communication['MessagesApprovals'] = $messageApprovals;
		$this->set('communication', $communication);
		$this->set('isTrash', $isTrash);
		$this->set('trace', $traces2);
		$this->set('block',$blo);
		$this->set('asistencia',$asistencia);
		
		//var_dump($traces2);
	}

	public function draft($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		$userId = $this->Session->read('UserAuth.User.id');

		$this->Communication->unbindModel(
	        array('hasMany' => array('Trace', 'CommunicationToken'))
	    );
		$communication = $this->Communication->findById($id);
		
		// buscar los TO y CC de la comunicacion
		$this->Trace->recursive = 0;
		$traces = $this->Trace->find('all', array(
			'conditions' => array(
				'communication_id' => $id,
				),
			)
		);
		$communication['Trace'] = $traces;
		$uploads = $this->Upload->getDocuments($traces[0]['Message']['id']);
		$communication['Uploads'] = $uploads;

		$communicationTypes = $this->CommunicationType->find('list', array('conditions'=>array('active' => 1)));
		$communicationCategories = $this->CommunicationCategory->find('list', array(
			'conditions'=>array(
				'communication_type_id' => $communication['Communication']['communication_type_id'],
				'active' => 1
				)
			)
		);

		$this->set('communicationTypes', $communicationTypes);
		$this->set('communicationCategories', $communicationCategories);
		$this->set('communication', $communication);
	}

	public function setTrash() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$trash = $_POST['trash'];
			
			$ids = $_POST['ids'];
			$userId = $this->Session->read('UserAuth.User.id');

			foreach ($ids as $key => $value) {
				$communicationTrash = $this->CommunicationTrash->findByCommunicationIdAndUserId($value, $userId);
				//$this->Communication->id = $value;
				//$this->Communication->saveField('draft' , 0);
				if ($communicationTrash)
					$communicationTrash['CommunicationTrash']['trash'] = $trash;
				else {
					$communicationTrash['CommunicationTrash']['trash'] = $trash;
					$communicationTrash['CommunicationTrash']['user_id'] = $userId;
					$communicationTrash['CommunicationTrash']['communication_id'] = $value;
				}
				if ($this->CommunicationTrash->save($communicationTrash['CommunicationTrash'])){
					$good = true;
				} else {
					$good = false;
					break;
				}
			}

			if ($good) {
				$a['data'] = $ids; 
				$a['Request']['status'] = 200;
				$a['Request']['message'] = 'operación realizada con éxito';
			} else {
				$a['Request']['status'] = 300;
				$a['Request']['message'] = 'Ocurrió un error. Intente nuevamente.';
			}
		}
		return json_encode($a);
	}

	// buscar entidades o usuarios por nombre dado
	// si no esta seteado la variable all, busca las entidades que exista al menos un usuario 
	public function findUsersAndEntities($all = null){
		$this->autoRender = false;
		$name = $_POST['q'];
		$users = $this->User->findUsersByName($name);
		$userId = $this->Session->read('UserAuth.User.id');
		$userEntityId = $this->Session->read('UserAuth.User.entity_id');
		
		if ($all) $entities = $this->Entity->findEntityByNameAll($name);
		else $entities = $this->Entity->findEntityByName($name);

		$groups = $this->Group->find('list', array('conditions' => array('Group.active' => 1)));

		$circles = array();
		$path = $this->Entity->getPath($userEntityId);
		if (isset($path[1]['Entity']['id']) || !empty($path[1]['Entity']['id'])){
			$circles = $this->Circle->findCirclesByName($name, $userId, $path[1]['Entity']['id']);
		}

		$arr = array();
		foreach ($users as $key => $value) {
			$path = '';
			if (!empty($value['User']['entity_id'])){
				$paths = $this->Entity->getPath($value['User']['entity_id']);
				if (empty($paths)) continue;
				//debug($paths, $showHtml = null, $showFrom = true);
				unset($paths[0]);
				foreach ($paths as $key => $p) {
					$path = $path.' - '.$p['Entity']['name'];
				}
			}
			$e = '';
			$e['id'] = $value['User']['id'];
			$e['name'] = $value['User']['first_name'].' '.$value['User']['last_name'];
			$e['type'] = 'user';
			$e['path'] = $path;
			$arr[] = $e;
		}

		foreach ($entities as $key => $value) {
			$path = '';
			$paths = $this->Entity->getPath($value['Entity']['id']);
			unset($paths[0]);
			foreach ($paths as $key => $p) {
				$path = $path.' - '.$p['Entity']['name'];
			}
			$e = '';
			$e['id'] = $value['Entity']['id'];
			$e['name'] = $value['Entity']['name'];
			$e['type'] = 'entity';
			$e['path'] = $path;
			$arr[] = $e;
		}

		foreach ($groups as $key => $value) {
			$e = '';
			$e['id'] = $key;
			$e['name'] = $value;
			$e['type'] = 'group';
			$e['path'] = '';
			$arr[] = $e;
		}

		foreach ($circles as $key => $value) {
			$e = '';
			$e['id'] = $value['Circle']['id'];
			$e['name'] = $value['Circle']['name'];
			$e['type'] = 'circle';
			$e['path'] = '';
			$arr[] = $e;
		}

		return json_encode($arr);
	}

	// obtener nuevas notificaciones de nuevas comunicaciones
	public function getNewCommunications(){
		$this->autoRender = false;
		// ver primero si tengo nuevos correos
		$userId = $this->Session->read('UserAuth.User.id');
		$entityId = $this->Session->read('UserAuth.User.entity_id');

		$this->Trace->unbindModel(
	        array('belongsTo' => array( 'ReceiveUser', 'ReceiveEntitie' ))
	    );
/*
	    $count = $this->Trace->find('count', array(
			'conditions' => array(
				'Trace.receive_user_id' => $userId,
				'Trace.receive_entity_id' => $entityId,
				'Trace.read' => 0,
				'Communication.draft' => 0
				),
			'group' => array('Trace.communication_id'),

			)
		);

		$traces = $this->Trace->find('all', array(
			'fields' => array('Communication.id', 'SenderEntity.name', 'Message.title', 'Message.created'),
			'conditions' => array(
				'Trace.receive_user_id' => $userId,
				'Trace.receive_entity_id' => $entityId,
				'Trace.read' => 0,
				'Communication.draft' => 0
				),
			'group' => array('Trace.communication_id'),
			'order' => array('Communication.id DESC'),
			'limit' => 3
			)
		);
*/
		$count = $this->Trace->query ( "SELECT COUNT(*) AS count FROM traces AS Trace 
			LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
			LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
			LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
			LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
			WHERE Trace.receive_entity_id IN ($entityId) AND Trace.receive_user_id IN ($userId) AND Trace.read = 0 AND Communication.draft = 0 AND CommunicationTrash.trash = 0 AND CommunicationTrash.user_id = $userId
			GROUP BY Trace.communication_id");

		$traces = $this->Trace->query ( "SELECT Communication.id, Message.title, Message.created, SenderEntity.name
			FROM traces AS Trace 
			LEFT JOIN communications AS Communication ON (Trace.communication_id = Communication.id) 
			LEFT JOIN communication_trashs AS CommunicationTrash ON (Communication.id = CommunicationTrash.communication_id) 
			LEFT JOIN messages AS Message ON (Trace.message_id = Message.id) 
			LEFT JOIN users AS SenderUser ON (Trace.sender_user_id = SenderUser.id) 
			LEFT JOIN entities AS SenderEntity ON (Trace.sender_entity_id = SenderEntity.id) 
			WHERE Trace.receive_entity_id IN ($entityId) AND Trace.receive_user_id IN ($userId) AND Trace.read = 0 AND Communication.draft = 0 AND CommunicationTrash.trash = 0 AND CommunicationTrash.user_id = $userId
			GROUP BY Trace.communication_id 
			ORDER BY Trace.created DESC 
			LIMIT 3");

			if (!empty($count))
				$count = count($count);
			else $count = 0;

		$c['Count'] = $count;
		$c['Messages'] = $traces;
		return json_encode($c);
	}

	// obtener notificacion de nueva interaccion en una comunicacion
	public function getNewInteractions() {
		$this->autoRender = false;
		$userId = $this->Session->read('UserAuth.User.id');
		$communications = $this->request->data['ids'];
		$interactions = array();
		foreach ($communications as $key => $communicationId) {
			$c['id'] = $communicationId;
			$this->CommunicationView->recursive = -1;
			$this->Communication->recursive = -1;
			$communicationView = $this->CommunicationView->findByUserIdAndCommunicationId($userId, $communicationId);
			$communication = $this->Communication->findById($communicationId);

			// obtener la iteraciones de la comunicacion, si tiene lectores nuevos
			$controlViews = $this->ControlView->find('count', array(
				'conditions' => array(
					'communication_id' => $communicationId,
					'sender_user_id' => $userId,
					)
				)
			);

			if ($controlViews > 0){
				$c['has_interaction'] = true;
				array_push($interactions, $c);
			}
			else {
				if (!empty($communicationView)){
					if ($communicationView['CommunicationView']['last_view'] < $communication['Communication']['modified']){
						$c['has_interaction'] = true;
					}	
					else {
						$c['has_interaction'] = false;
					}
					array_push($interactions, $c);
				}
			}
		}
		return json_encode($interactions);
	}

	function deleteAll($idCommunication = null, $idMessage = null) {
		if ($idCommunication){
			$this->Communication->delete($idCommunication);
			$this->CommunicationView->deleteAll(array('CommunicationView.communication_id' => $idCommunication), false);
			$this->CommunicationToken->deleteAll(array('CommunicationToken.communication_id' => $idCommunication), false);
			$this->Trace->deleteAll(array('Trace.communication_id' => $idCommunication), false);
			$this->Tag->deleteAll(array('Communication.id' => $idCommunication), false);
		}
		if ($idMessage) {
			$this->Message->delete($idMessage);
			$this->Upload->deleteAll($idMessage);
		}
	}

	public function directory(){
		$this->autoRender = False;
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
			$r['Tab'] = 'p';
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
			$r['Tab'] = 'p';
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
			//$r['Tab'] = 'p';
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
		$entities = array();
		$new = "";
		//si la consulta viene de un circulo
		//echo($_GET['circle']);
		if (isset($_GET['circle'])) {
			$userEntityId = $this->Session->read('UserAuth.User.entity_id');
			$path = $this->Entity->getPath($userEntityId);
			if (isset($path[1]['Entity']['id']) || !empty($path[1]['Entity']['id'])){
				$entityParentId = $path[1]['Entity']['id'];
				$entities = $this->Entity->getParents($entityParentId);
			}
		}
		else {
			$entities=$this->Entity->getParents();
		}
		$userId = $this->Session->read('UserAuth.User.id');
		$userEntityId = $this->Session->read('UserAuth.User.entity_id');
		$path = $this->Entity->getPath($userEntityId);
		$entityParentId = $path[1]['Entity']['id'];
		$circles = $this->Circle->getCirclesByUserIdAndEntityId($userId, $entityParentId);

		$groups = $this->Group->find('list', array('conditions' => array('active' => 1, 'Group.type' => 1)));
		$parent = $this->Entity->getPath($this->Session->read('UserAuth.User.entity_id'));

		$groupsi = $this->Group->find('all', array('fields' => array('name' , 'id') ,'conditions' => array('Group.active' => 1, 'Group.type' => 2, 'Group.entity_id' => $parent[1]['Entity']['id'])));

		foreach ($groupsi as $k => $v) {
			$new[$v['Group']['id']] = $v['Group']['name']; 
		}

		$r['Users'] = $users;
		$r['Entities'] = $entities;
		$r['Groups'] = $groups;
		$r['Circles'] = $circles;

		$r['GroupsI'] = $new;

		//debug($entities);

		return json_encode($r);
	}

	public function deletePreUpload(){
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$idUpload = $this->request->data['id'];

			if ($this->Upload->deleteRegistreById($idUpload)){
				$message_t = 'Operación realizada con éxito';
				$a['Request']['status'] = 200;
				$a['Request']['message'] = $message_t;
				return json_encode($a);
			} else {
				$message_t = 'Error en la operación';
				$a['Request']['status'] = 300;
				$a['Request']['message'] = $message_t;
				return json_encode($a);
			}
		}
	}

	
	public function addPreUpload(){
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$idMessage = $this->request->data['message_id'];
			$idTemporal = $this->request->data['temporal_id'];
			$uploads = $this->Upload->findDocumentsByMessage($idMessage);
			$ids = array();
			foreach ($uploads as $key => $upload) {
				$upload['Upload']['id'] = null;
				$upload['Upload']['message_id'] = null;
				$upload['Upload']['temporal'] = $idTemporal;
				if ($id = $this->Upload->addUploadRow($upload)){
					array_push($ids, $id);
				} else {
					$message_t = 'Operación realizada con éxito';
					$a['Request']['status'] = 300;
					$a['Request']['message'] = $message_t;
					return json_encode($a);
				}
			}
			$message_t = 'Operación realizada con éxito';
			$a['Request']['status'] = 200;
			$a['Request']['message'] = $message_t;
			$a['ids'] = $ids;
			return json_encode($a);

		}
	}
	
	/**
	 * Function to generate a pdf file 
	 * @param integer $id
	 */
	function certificateCommunication($id){
		$this->autoRender = false;
		
		$fileName = 'correspondencia_certificada_123456.pdf';
		
		$this->__generatePDF($id, $fileName);
		
	}
	
	
	public function addPdfToCommunication($id){
		$this->autoRender = false;
		
		if (!$this->Message->exists($id)) {
			return __('La comunicacion no existe');
		}
		
		
	}
	
	public function viewpdf($id = null) {
		//App::uses('CakeTime', 'Utility');
			$this->layout = 'default2';
			// initializing mPDF
			$this->Mpdf->init();
			// setting filename of output pdf file
			$data = $this->request->data;
			$correlativo = $id;
			
			if(isset($data['bySigned'])){
				$correlativo = $data['correlativo'];
			}
			
			
			//$date = date('Y-m-d H:i:s');
			
			//$this->log("$date -- Generando PDF", LOG_INFO);
				
			//$this->Mpdf->setFilename("files/correspondencia_certificada_$correlativo.pdf");
			$this->Mpdf->setFilename("/var/repo/correspondencia_certificada_$correlativo.pdf");
	
			// setting content of pdf file
			$styles = '.icon-chevron-down, .icon-chevron-up{cursor: pointer;}
						.lista {max-width: 15em;max-height: 15em;border: 1px solid #ccc;padding: 0;margin: 0;overflow: scroll;overflow-x: hidden;}
						.liLista {border-top: 1px solid #ccc;}
						.ulLista  {text-indent: 1em;}';
						
			$stylesheet = file_get_contents('../webroot/css/bootstrap.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('../webroot/css/font-awesome.min.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('../webroot/css/ace.min.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('../webroot/css/ace-rtl.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('../webroot/css/ace-skins.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('../webroot/css/jquery.gritter.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('../webroot/css/main.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('../webroot/css/datepicker.css');
			$this->Mpdf->WriteHTML($stylesheet,1);
				
			$this->Mpdf->WriteHTML($styles, 1);
			
			// setting output to I, D, F, S
			//$this->Mpdf->setOutput('F');
	
			// you can call any mPDF method via component, for example:
			//$this->Mpdf->SetWatermarkText("Draft");
		

		$m['title'] = $data['title'];
		$m['content'] = $data['content'];
			
		$parentsPath = $this->Entity->getPath($this->Session->read('UserAuth.User.entity_id'));
		//$logo = $entity['Entity']['logo'];
		$logo = $parentsPath[1]['Entity']['logo'];
		
		
		if($id != null){
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		$userId = $this->Session->read('UserAuth.User.id');
		$this->pdfConfig = array(
				'orientation' => 'portrait',
				'filename' => 'Resumen_' . $id
		);
		$isTrash = false;
		if (isset($_GET['trash'])) $isTrash = true;
		// buscar en los traces que sean para mi y que no esten marcados como leidos y agregarlo al controlviews
		$traces = $this->Trace->find('all', array(
				'conditions' => array(
						'Trace.communication_id' => $id,
						'Trace.receive_user_id' => $userId,
						'Trace.read' => 0,
						'Communication.draft' => 0
				)
		)
		);
		foreach ($traces as $key => $trace) {
			$this->ControlView->create();
			$controlv['communication_id'] = $id;
			$controlv['sender_user_id'] = $trace['Trace']['sender_user_id'];
			$controlv['receive_user_id'] = $trace['Trace']['receive_user_id'];
			$this->ControlView->save($controlv);
		}
	
		// quitar del controlview los que yo envie
		$this->ControlView->deleteAll(array('communication_id' => $id, 'sender_user_id' => $userId));
		// agregar en communicationview
		$cv['user_id'] = $userId;
		$cv['communication_id'] = $id;
		if ($this->CommunicationView->saveCV($cv)){
			// exito
		}
		else {
			// error
		}
		//marco como leido el mensaje
		//$this->Trace->markAsRead($id, $userId);
	
		$entity = $this->Entity->findById($this->Session->read('UserAuth.User.entity_id'));
		$parentsPath = $this->Entity->getPath($this->Session->read('UserAuth.User.entity_id'));
		//$logo = $entity['Entity']['logo'];
		$logo = $parentsPath[1]['Entity']['logo'];
		
		$this->Communication->unbindModel(
				array('hasMany' => array('Trace', 'CommunicationToken'))
		);
		$communication = $this->Communication->findById($id);
		$tokens = $this->CommunicationToken->getTokens($id);
		//  quien esté logueado y tenga que responder aparezcan los nombres en el TO
		$trcs = $this->Trace->find('list', array(
				'conditions' => array(
						'communication_id' => $id,
						//'receive_user_id' => $userId
				),
				'fields' => array('receive_user_id'),
				'group' => array('receive_user_id')
		)
		);
		$users = $this->User->find('all', array('conditions'=>array('User.id' => $trcs)));
		$userOwner = $this->User->findById($communication['Communication']['user_id']);
		$userOwner['User']['owner'] = true;
		array_push($users, $userOwner);
		// debug($users, $showHtml = null, $showFrom = true);
		$this->set(compact('users'));
	
		$communication['Tokens'] = $tokens;
		$this->Trace->recursive = 1;
		// para obtener los mensajes pertenecientes a la comunicacion solamente
		$traces = $this->Trace->find('all', array(
				'conditions' => array(
						'communication_id' => $id,
				),
				'group' => array('message_id')
		)
		);
		$messageApprovals['approved']['cant'] = 0;
		$messageApprovals['approved']['users'] = array();
		$messageApprovals['rejected']['cant'] = 0;
		$messageApprovals['rejected']['users'] = array();
		$messageApprovals['modified']['cant'] = 0;
		$messageApprovals['modified']['users'] = array();
		$messageApprovals['none']['cant'] = 0;
		$messageApprovals['none']['users'] = array();
	
		$canApprove = array();
		$messages = array();
		foreach ($traces as $key => $trace) {
			//debug($trace, $showHtml = null, $showFrom = true);
			$uploads = $this->Upload->getDocuments($trace['Message']['id']);
			$messages[$trace['Message']['id']]['approve'] = $trace['Trace']['approval'];
			$messages[$trace['Message']['id']]['Uploads'] = $uploads;
			$messages[$trace['Message']['id']]['Message'] = $trace['Message'];
			if ($trace['Trace']['approval'] == '-2') {
				$messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] + 1;
			}
			if ($trace['Trace']['approval'] == '-1') {
				$messageApprovals['rejected']['cant'] = $messageApprovals['rejected']['cant'] + 1;
				array_push($messageApprovals['rejected']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			if ($trace['Trace']['approval'] == 1) {
				$messageApprovals['approved']['cant'] = $messageApprovals['approved']['cant'] + 1;
				array_push($messageApprovals['approved']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
			if ($trace['Trace']['approval'] == 2) {
				$messageApprovals['modified']['cant'] = $messageApprovals['modified']['cant'] + 1;
				array_push($messageApprovals['modified']['users'], $trace['SenderUser']['first_name'].' '.$trace['SenderUser']['last_name']);
			}
				
			$communication['Communication']['title'] = $trace['Message']['title'];
			$tracesm = $this->Trace->find('all', array(
					'conditions' => array(
							'communication_id' => $id,
							'message_id' => $trace['Message']['id']
					),
			)
			);
			$messages[$trace['Message']['id']]['UserReceivers'] = array();
			$messages[$trace['Message']['id']]['EntitiesReceivers'] = array();
			$messages[$trace['Message']['id']]['EntitySender'] = '';
			$messages[$trace['Message']['id']]['UserSender'] = '';
	
			foreach ($tracesm as $key => $tracem) {
				$ur['id'] = $tracem['ReceiveUser']['id'];
				$ur['username'] = $tracem['ReceiveUser']['username'];
				$ur['email'] = $tracem['ReceiveUser']['email'];
				$ur['first_name'] = $tracem['ReceiveUser']['first_name'];
				$ur['last_name'] = $tracem['ReceiveUser']['last_name'];
				$ur['position'] = $tracem['ReceiveUser']['position'];
				$ur['entity_id'] = $tracem['ReceiveUser']['entity_id'];
				$ur['type_delivery'] = $tracem['Trace']['type_delivery'];
				$ur['read'] = $tracem['Trace']['read'];
				$ur['read_datatime'] = $tracem['Trace']['read_datatime'];
				$messages[$trace['Message']['id']]['UserReceivers'][$ur['id']] = $ur;
	
				$us['id'] = $tracem['SenderUser']['id'];
				$us['username'] = $tracem['SenderUser']['username'];
				$us['email'] = $tracem['SenderUser']['email'];
				$us['first_name'] = $tracem['SenderUser']['first_name'];
				$us['last_name'] = $tracem['SenderUser']['last_name'];
				$us['entity_id'] = $tracem['SenderUser']['entity_id'];
				$us['position'] = $tracem['SenderUser']['position'];
				$messages[$trace['Message']['id']]['UserSender'] = $us;
	
				$er['id'] = $tracem['ReceiveEntitie']['id'];
				$er['name'] = $tracem['ReceiveEntitie']['name'];
				$er['description'] = $tracem['ReceiveEntitie']['description'];
				$messages[$trace['Message']['id']]['EntitiesReceivers'][$er['id']] = $er;
	
				$es['id'] = $tracem['SenderEntity']['id'];
				$es['name'] = $tracem['SenderEntity']['name'];
				$es['description'] = $tracem['SenderEntity']['description'];
				$messages[$trace['Message']['id']]['EntitySender'] = $es;
			}
		}
	
		// buscar quienes pueden aprobar en caso de que se pueda aprobar
		$this->Trace->recursive = -1;
		$traces = $this->Trace->find('all', array(
				'conditions' => array(
						'communication_id' => $id,
						'requires_approval' => 1,
				),
				'fields' => array('receive_user_id')
		)
		);
	
		$traces2 = $this->Trace->find('all', array(
				'conditions' => array(
						'communication_id' => $id,
				)
		)
		);
	
		$messageApprovals['none']['cant'] = 0;
		foreach ($traces as $key => $trace) {
			array_push($canApprove, $trace['Trace']['receive_user_id']);
			$messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] + 1;
		}
	
		$messageApprovals['none']['cant'] = $messageApprovals['none']['cant'] - $messageApprovals['approved']['cant'] - $messageApprovals['rejected']['cant'] - $messageApprovals['modified']['cant'];
		$message[0]['Message']['content'] = $m['content'];
		$message[0]['UserSender']['first_name'] =$this->Session->read('UserAuth.User.first_name');
		$message[0]['UserSender']['last_name']=$this->Session->read('UserAuth.User.last_name');
		krsort($messages);
		$communication['canApprove'] = $canApprove;
		$communication['Messages'] = $messages;
		$communication['MessagesApprovals'] = $messageApprovals;
		$this->set('communication', $communication);
		$this->set('isTrash', $isTrash);
		$this->set('trace', $traces2);

		}else{
			$communication['Communication']['title'] = $m['title'];

			$message[0]['Message']['content'] = $m['content'];
			$message[0]['UserSender']['first_name'] =$this->Session->read('UserAuth.User.first_name');
			$message[0]['UserSender']['last_name']=$this->Session->read('UserAuth.User.last_name');
			
			$communication['Messages'] = $message;
			
			$this->set('communication', $communication);
			
		}

		$this->set('logo', $logo);
		
		$this->Mpdf->setOutput('F');
	
	}
	
function verificarfirma($archivo = null){
		$this->autoRender=false;
		
		$nameFile = "info_services";
		$method = 'VerificarFirma';

		$message = " - $method: iniciando llamada al WS verificar...";
		CakeLog::write($nameFile, $message);

		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '512M');
		App::import('Vendor', 'nusoap');
		//$client = new nusoap_client('http://62.43.192.130:82/wsverificar/service.asmx?wsdl', 'WSDL');
		//$client = new nusoap_client('http://80.34.240.92:443/wsverificar/Service.asmx?wsdl', 'WSDL');
		//$client = new nusoap_client('http://62.43.192.130:443/wsverificar/servicewsdl.xml', 'WSDL');
		$client = new nusoap_client('http://62.43.192.130:443/wsauditoria/Service.xml', 'WSDL');
		
		//check if there were any instantiation errors, and if so stop execution with an error message:
		$error = $client->getError();
		if ($error) {

			$message = " - $method: ERROR estableciendo comunicacion al WS verificar";
			CakeLog::write($nameFile, $message);

			die("client construction error: {$error}\n");
		}
		
		$filename = $_GET['id'];
		
		//var_dump($filename);
		$file = DS . "var" . DS . "repo" . DS . $filename;
		
		
		$hash = $this->Upload->findByRealName($filename);
		$hash = $hash['Upload']['hashnopdf'];
		
		
		
		$handle = fopen($file, "rb");
		
		
		//$contents = utf8_encode(fread($handle, filesize($file)));
		$contents = base64_encode(fread($handle, filesize($file)));
		fclose($handle);
		
		
		$message = " - $method: leyendo archivo a verificar (" . $this->data['id'] . ")";
		CakeLog::write($nameFile, $message);

		$message = " - $method: Contenido del fichero: '$contents'";
		//CakeLog::write($nameFile, $message);
 
		$ext = explode(".", $filename);
		$ext = end($ext);
		
			$param = array(
					//'Usuario' => '3tech',
				'numCorrespondencia' => $_GET['correlative'],
				'fichero' => $contents,
				//'hash' => $hash,
		);
		
		

		$message = " - $method: Invocando llamada al metodo VerificarFirma dentro del WS";
		CakeLog::write($nameFile, $message);

		$answer = $client->call('auditoria',  $param);
		$error = $client->getError();
		


		if ($error) {
			/*print_r($client->response);
			print_r($client->getDebug());*/
			
			$message = " - $method: ERROR durante el llamado al metodo VerificarFirma del WS";
			CakeLog::write($nameFile, $message);

			return "Error del servidor";
			die();
		}

		$message = " - $method: Verificacion de firma finalizada.";
		CakeLog::write($nameFile, $message);

		//var_dump($answer['VerificarFirmaResult']);

		$message = " - $method: Respuesta del WS: " . $answer;
		CakeLog::write($nameFile, $message);
		//var_dump($answer);die;
		
		//$pdf_base64 = "base64pdf.txt";
		//Get File content from txt file
		//$pdf_base64_handler = fopen($pdf_base64,'r');
		//$pdf_content = fread ($pdf_base64_handler,filesize($pdf_base64));
		//fclose ($pdf_base64_handler);
		//Decode pdf content
		$pdf_decoded = base64_decode ($answer['auditoriaResult']);
		//Write data back to pdf file
		$pdf = fopen (WWW_ROOT . "files" . DS .'auditoria.pdf','w');
		//$pdf = fopen ('/var/repo/auditoria.pdf','w');
		
		fwrite ($pdf,$pdf_decoded);
		//close output file
		fclose ($pdf);
		//echo 'Done';
		
		/**if (file_exists(WWW_ROOT . "files" . DS .'auditoria.pdf')) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename(WWW_ROOT . "files" . DS .'auditoria.pdf'));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize(WWW_ROOT . "files" . DS .'auditoria.pdf'));
		    readfile(WWW_ROOT . "files" . DS .'auditoria.pdf');
		    //exit;
		}**/
		//return $answer['auditoriaResult'];
		//return "http://".$_SERVER['SERVER_NAME']. $this->webroot . "files" .'/auditoria.pdf';
		return "https://".$_SERVER['SERVER_NAME']. $this->webroot .'communications/previewfile/auditoria.pdf';
		
	}
	
	/**
	 * A helper function. DELETE!
	 */
	function testingCall($id = 'Default'){
		$this->autoRender = false;
		
		if($id == '0-0'){
			$nameFile = "info_services";
			$method = 'GeneraPDF';
			$data = $this->request->data;
				
			$message = " - $method: Llamando al applet...";
			CakeLog::write($nameFile, $message);
			//$this->log("$message", LOG_INFO);
			//error_log("$message\n", 3, "../../tmp/logs/info_services.log");
				
			$message = " - $method: Pasando los ids de los documentos";
			CakeLog::write($nameFile, $message);
			//$this->log("$message", LOG_INFO);
				
			$idCorrespondencia = $data['correspondencia'];
			$message = " - $method: $idCorrespondencia";
			//CakeLog::write($nameFile, $message);
			//$this->log("$message", LOG_INFO);
			
			$ids = $data['id'];
			
			$message = " - $method: $ids";
			CakeLog::write($nameFile, $message);
			//$this->log("$message", LOG_INFO);
			
			$communicationId = $data['idCommunication'];
			
			$doc = explode("|",$ids);
			
			$data2['SignedCommunication']['user_id'] = $this->Session->read('UserAuth.User.id');;
			$data2['SignedCommunication']['communication_id'] = $communicationId;
			$data2['SignedCommunication']['status'] = "pendiente";
				
			
			$this->SignedCommunication->save($data2);
			for($x=1; $x <= count($doc); $x++){
				
				$datos[$x-1]['Acknowledgment']['communication_id']=$communicationId;
 
				$datos[$x-1]['Acknowledgment']['document']=$doc[$x-1];
				
				$datos[$x-1]['Acknowledgment']['status']="pendiente";
			}
			$this->Acknowledgment->saveAll($datos);
			
			$messageId = $data['idMessage'];
			
			
			if($data['conpdf']){
			CakeLog::write($nameFileLog, "CommunicationsController.testingCall: Estamos adjuntando el resumen...");
			$this->log("CommunicationsController.add: Estamos adjuntando el resumen...");
			$summaryCommunication = array();
			$summaryCommunication['Upload']['message_id'] = $messageId;
			$summaryCommunication['Upload']['name'] = "correspondencia_certificada_$messageId.pdf";
			$summaryCommunication['Upload']['real_name'] = "Correspondencia Certificada.pdf";
			$summaryCommunication['Upload']['size'] = filesize("../webroot/files/correspondencia_certificada_$messageId.pdf");
			$respSave = $this->Upload->addUploadRow($summaryCommunication);
			if($respSave){
			  CakeLog::write($nameFile, "CommunicationsController.testingCall: Resumen de la correspondencia guardado");
			}else{
				//CakeLog::write($nameFile, "CommunicationsController.testingCall: Error: $respSave");
			}
			}
				
		}else{
				
		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '512M');
		App::import('Vendor', 'nusoap');

		$param = array( 'file' => $id);
		var_dump($id);
		$client = new nusoap_client('http://localhost/correspondencia/services/getServices.php?wsdl');
		
		$error = $client->getError();
		if ($error) {
			echo "<h2>Construct Error: </h2><pre>$err</pre>";
			die("client construction error: {$error}\n");
		}

		$response = $client->call('RecuperaDocumento',$param);
		
		$err = $client->getError();
		if($err){
			echo "<h2>Call Error:</h2><pre> $err </pre>";
			echo "<pre>";
			print_r($client->response);
			echo "</pre>";
			
			echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
			echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
			echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
			
			die();
		}
		 
		if($client->fault)
		{
		    echo "FAULT: <p>Code: (".$client->faultcode.")</p>";
		    echo "String: ".$client->faultstring;
		}
		else
		{	
			echo "file name: '$id'<br>";
			echo "file content: ";
			print_r($response);
		}
		
		/** -------------------- Enviamos el documento modificado -------------------- */
		if($response != 'File not found!'){
			
			//$id= 'MyPDF_0538340001414507386.pdf';
			
			$param = array( 'file' => $id, 'content'=>$response , 'hash' => 'hash-test-fff3');
			
			$response = $client->call('EnviaDocumento',$param);
				
			$err = $client->getError();
			if($err){
				echo "<h2>Call Error:</h2><pre> $err </pre>";
				echo "<pre>";
				print_r($client->response);
				echo "</pre>";
					
				echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
				echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
					
				die();
			}
				
			if($client->fault)
			{
				echo "FAULT: <p>Code: (".$client->faultcode.")</p>";
				echo "String: ".$client->faultstring;
			}
			else
			{
				echo "file name: '$id'<br>";
				echo "file content: ";
				print_r($response);
			}
		}
		}
		
	}
	
	function signedResumen($id = null){
		$this->autoRender = false;
		$data = array();
		$data['Acknowledgment']['document'] = $id;
		$data['Acknowledgment']['status'] = 'pendiente';
		if($this->Acknowledgment->save($data)){
			return 1;	
		}
		else{
			return 0;
		}
	}
	
	function signedResumenStatus($id = null){
	
		$this->autoRender = false;
		$data = $this->Acknowledgment->find('count', array ('conditions' =>  array ('OR' => array (array('status' => 'pendiente'), array('status' => 'enviado') ,), 'document' => $_POST['id'])));
		return $data;
	}
	
	function downloadResumen($archivo = null){
		
		$this->autoRender = false;
		//$archivo = '../webroot/files/'.$archivo;
		$archivo = '/var/repo/'.$archivo;
		//var_dump($archivo);
		//var_dump(file_exists($archivo));
		if (file_exists($archivo)) {
			header("Content-disposition: attachment; filename=".basename($archivo));
			header("Content-type: application/pdf");
			readfile($archivo);
			exit;
		}
		
	}
	function documentStatus($id = 0){
		
		$this->autoRender = false; 
		$data = $this->Acknowledgment->find('count', array ('conditions' =>  array ('OR' => array (array('status' => 'pendiente'), array('status' => 'enviado') ,), 'communication_id' => $_POST['id'])));
		if($data == 0){
			
			//$data = 1;
			$user = $this->Session->read('UserAuth.User.id');
			$data2 =  $this->SignedCommunication->find('first', array('conditions' => array('SignedCommunication.communication_id' => $_POST['id'] , 'SignedCommunication.user_id' => $user)));
			$this->SignedCommunication->id = $data2['SignedCommunication']['id'];
			$this->SignedCommunication->saveField('status', 'firmado');
			
			$this->Communication->id = $_POST['id'];
			$this->Communication->saveField('draft' , 0);
			 
			$this->Communication->recursive = 1;
			$lastComun = $this->Communication->find('first',array('conditions' => array ('Communication.id' => $_POST['id'])));
			
			
			if ($lastComun['Communication']['expires']) {
				
				$idlastComun = $lastComun['Communication']['id'];
				$Allusers = $this->Trace->find('all',array('conditions'=>array('Trace.communication_id'=>$idlastComun)));
				$toArray  = array();
				foreach ($Allusers as $key => $value) {
					$use = $value['Trace']['receive_user_id'];
			
					$dataUse = $this->User->find('first',array('conditions'=>array('User.id'=>$use)));
			
					$toArray[$key] = $dataUse['User']['email'];
				}
			
				$usuar = $this->User->find('first',array('conditions' => array('User.id'=>$userId)));
				$nameUsuario = $usuar['User']['first_name']." ".$usuar['User']['last_name'];
				$correo = 'noreply@correspondenciaestatal.gob.pa';
				$subject= "correspondenciaestatal.gob.pa";
			
				$content = nl2br("Has recibido un mensaje de ".$nameUsuario." a través del Servicio de Correspondencia Estatal Electrónica.\n Se requiere que lo responda antes del ".$lastComun['Communication']['expires']);
				$Email = new CakeEmail();
				$to = $toArray;
				$Email->config('_3tp');
				$Email->to($to);
				$Email->subject($subject);
				$Email->from($correo);
				$Email->template('default');
				$Email->emailFormat('html');
				$Email->send($content);
				
				
				
			}
			//var_dump($data2['SignedCommunication']['id']);
		}
		echo $data;
	}


	/**
	 * Function that generate a PDF file from a communication
	 * @param integer $id : communication's id
	 */
	function __generatePDF($id, $fileName){
		//$this->autoRender = false;
	
		// initializing mPDF
		$this->Mpdf->init();
	
		$this->Mpdf->debug = true;
		// setting filename of output pdf file
		$this->Mpdf->setFilename("files/$fileName");
		 
		// setting content of pdf file
		$styles = '.icon-chevron-down, .icon-chevron-up{cursor: pointer;}
						.lista {max-width: 15em;max-height: 15em;border: 1px solid #ccc;padding: 0;margin: 0;overflow: scroll;overflow-x: hidden;}
						.liLista {border-top: 1px solid #ccc;}
						.ulLista  {text-indent: 1em;}';
		 
		$content =
		'<div class="main-container-inner">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>
	
			<img alt="" src="http://127.0.0.1/correspondencia/img/logo_correspondencia.png" width="200" height="100">
	
			<div class="main-content" style="margin-bottom:60px; margin-left: 0px;">
	
				<div class="page-content" style="min-height:100%;">
	
					<div class="page-header">
						<h1>Firma de documento <span class="pull-right pop-help">
						    	<span class="btn  btn-sm tooltip-warning" data-rel="popover" data-placement="bottom" data-content="- Al colocar el puntero del rat&oacute;n sobre el nombre de algunos de los remitentes o destinatarios aparecer&aacute; sobre &eacute;l un cuadro indicando el nombre de la unidad a la que pertenece.<br><br>- El &iacute;cono <i class=\'icon-ok\'></i> indica que el mensaje fue le&iacute;do por esa persona. Al colocar el puntero del rat&oacute;n sobre el &iacute;cono aparecera un cuadro indicando la fecha y hora en la que fue le&iacute;do.<br><br>- El &iacute;cono <i class=\'icon-time\'></i> indica que el mensaje no ha sido le&iacute;do por la persona." data-original-title="Indicadores"><i class="icon-question-sign bigger-120"></i></span>
							</span>
						</h1>
						<br>
						<span class="pull-right">
							<span class="label label-danger arrowed"><strong>Acci&oacute;n </strong>Dar respuesta</span>
						</span>
					</div>
	
					<div class="row">
						<div class="col-sm-8">
							<div id="contentTags"></div>
						</div>
					</div>
	
					<div class="timeline-container" id="communication" data-communication-id="8">
			
						<div class="timeline-label">
							<span class="label label-primary arrowed-in-right label-lg">
								<b>Hoy</b>
							</span>
							<span class="pull-right">
								<div class="inline position-relative">
									<a id="opcCommunications" href="#" data-toggle="dropdown" class="dropdown-toggle">
										Opciones &nbsp;
										<i class="icon-caret-down bigger-125"></i>
									</a>
					
									<ul class="dropdown-menu dropdown-lighter pull-right dropdown-100">
										<li>
											<a href="8.pdf" id="">
												<i class="icon-reply blue icon-only bigger-130"></i> Exportar Pdf
											</a>
										</li>
										<li>
											<a href="" id="replyCommunication">
												<i class="icon-reply blue icon-only bigger-130"></i> Responder
											</a>
										</li>
										<li>
											<a href="" id="replyAllCommunication">
												<i class="icon-reply-all blue icon-only bigger-130"></i> Responder a todos
											</a>
										</li>
									</ul>
								</div>
							</span>
						</div>
				
						<div class="timeline-items">
							<div class="timeline-item clearfix">
				
								<div class="timeline-info pretty-date-date" data-date="2014-10-14 09:53:24">
									<div class="timeline-info-date">
										<span class="day">14</span>
										<span class="month">Oct</span>
										<span class="year">2014</span>
									</div>
								</div>
								<div class="widget-box transparent">
									<div class="widget-header widget-header-small">
										<h5 class="smaller">
											<span class="grey"><strong>De </strong>
												<span data-rel="tooltip" data-placement="top" title="" data-original-title="Consejo Econ&oacute;mico Nacional - Prueba">
													Alex Fradiani
						    					</span>
											</span>
										</h5>
										<h5 class="smaller" style="margin:0px;">
											<span class="grey"><strong>Para </strong>
												<span style="margin-right:2px;" class="label" data-rel="tooltip" data-placement="top" title="" data-original-title="">Alex Fradiani</span>
											</span>
										</h5>
	
										<span class="widget-toolbar no-border">
											<i class="icon-time bigger-110"></i>
											<span class="pretty-date-date" data-date="2014-10-14 09:53:24"><span class="hour">9:53 am</span></span>
										</span>
			
										<span class="widget-toolbar">
											<a data-action="collapse">
												<i class="icon-chevron-down"></i>
											</a>
										</span>
									</div>
			
									<div class="widget-body">
										<div class="widget-body-inner" style="">
											<div class="widget-main" style="padding:2px;">
												<div style="background-color:#ffffff; padding:5px;"></div>
												<div class="space-6"></div>
												<div class="hr hr-double"></div>
												<div class="widget-toolbox clearfix">
													<div class="attachment-title">
														<span class="blue bolder bigger-110">Adjuntos</span>
													</div>
													<ul class="attachment-list pull-left list-unstyled">
														<li><span class="attached-name middle">Documento prueba firma electr&oacute;nica.pdf</span></li>
														<li><span class="attached-name middle">SamplePDF.pdf</span></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="text-center white">
											<strong></strong>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
		 
		$stylesheet = file_get_contents('../webroot/css/bootstrap.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('../webroot/css/font-awesome.min.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('../webroot/css/ace.min.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('../webroot/css/ace-rtl.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('../webroot/css/ace-skins.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('../webroot/css/jquery.gritter.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('../webroot/css/main.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('../webroot/css/datepicker.css');
		$this->Mpdf->WriteHTML($stylesheet,1);
		 
		$this->Mpdf->WriteHTML($styles, 1);
		$this->Mpdf->WriteHTML($content, 2);
	
		// setting output to I, D, F, S
		// I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
		// D: send to the browser and force a file download with the name given by filename.
		// F: save to a local file with the name given by filename (may include a path).
		// S: return the document as a string. filename is ignored.
		$this->Mpdf->setOutput('F');
	
		// you can call any mPDF method via component, for example:
		$this->Mpdf->SetWatermarkText("Draft");
		 
	}
	
	function __move_file($file, $newName){
		$folder = '../webroot/files/';
		
		if(file_exists($folder . $file)){
			rename($folder.$file, $folder.$newName);
			return true;
		}
		
		return false;
	}
	
	function updateTemporal (){
		$this->autoRender = false;
		$this->Upload->updateTemporal($_POST['idFile'],$_POST['temporal']);		
	}
	
	
	function thisBeingSigned($id = 0){
		$this->autoRender = false;
		$count = $this->SignedCommunication->find('count', array('conditions' => array('communication_id' => $id ,'status' => 'pendiente' , 'TIMESTAMPDIFF(MINUTE, SignedCommunication.created, NOW()) < ' => 60)));
		return $count;
		
	}
	
	
	
	
}

	
