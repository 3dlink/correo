<?php
/*
 * jQuery File Upload Plugin PHP Class 5.9.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
App::uses('Component', 'Controller');
class UploadComponent extends Component
{
	public $components = array('Session','Auth');
	public $helpers = array('Session','Auth');
	
	public $STR_TO_REPLACE = array(
		array("á","a"),
		array("é","e"),
		array("í","i"),
		array("ó","o"),
		array("ú","u"),
		array("Á","A"),
		array("É","E"),
		array("Í","I"),
		array("Ó","O"),
		array("Ú","U"),
		array("Ñ","N"),
		array("ñ","n"),
		array("#","")
	);
	
	protected $options;

	/*
	* $options = array()
	* Avaliable Options:
	*
	*
	* $options => array(
	*   'upload_dir' => 'files/{your-new-upload-dir}' // Default 'files/'
	* )
	*/
	function __construct( ComponentCollection $collection, $options = null ) {

		$this->UploadModel = ClassRegistry::init('FileUpload.Upload');

		 $this->options = array(
			'script_url' => Router::url('/', true).'file_upload/handler',
		
			'upload_dir' => WWW_ROOT.'files/',
			'repo_dir' => '/var/repo/',
			'upload_url' => $this->getFullUrl().'/files/',

			// Produccion!!!!!!!
			// 'upload_dir' => '/var/repo/',
			// 'repo_dir' => '/var/repo/',
			// 'upload_url' => '/var/repo/',
			'param_name' => 'files',
			// Set the following option to 'POST', if your server does not support
			// DELETE requests. This is a parameter sent to the client:
			'delete_type' => 'DELETE',
			// The php.ini settings upload_max_filesize and post_max_size
			// take precedence over the following max_file_size setting:
			'max_file_size' => null,
			'min_file_size' => 1,
			'accept_file_types' =>  '/(\.|^image\/)(doc|docx|xls|xlsx|ppt|pptx|pdf|txt|jpg|jpeg|png|gif)$/i', //'([^\s]+(\.(?i)(jpg|png|gif|bmp))$)' //'/.+$/i', // For only accept images use this: ([^\s]+(\.(?i)(jpg|png|gif|bmp))$)
			'max_number_of_files' => null,
			// Set the following option to false to enable resumable uploads:
			'discard_aborted_uploads' => true,
			// Set to true to rotate images based on EXIF meta data, if available:
			'orient_image' => false,
			'image_versions' => array()
		);
		
		/*$date = date('Y-m-d H:i:s');
		$method = 'UploadComponent'; 
		$message = "$date - $method: Entre a _constuct";
		error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
		*/
		
		# Check if exists new options
		if( $options )
		{
			# Change the upload dir. If it doesn't exists, create it.
			if( $options['upload_dir'] )
			{

				// Remove the first `/` if it exists.
				if( $options['upload_dir'][0] == '/' )
				{
					$options['upload_dir'] = substr($options['upload_dir'], 1);
				}


				$dir = WWW_ROOT.$options['upload_dir'];

				// Create the directory if doesn't exists.
				if( !file_exists( $dir) )
				{
					@mkdir( $dir );
				}

				$this->options['upload_url'] = $this->getFullUrl().'/'.$dir;
				$this->options['upload_dir'] = $dir;
			}
		}

	}

	public function getFullUrl() {
		return
			(isset($_SERVER['HTTPS']) ? 'https://' : 'http://').
			(isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
			(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
			(isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
			$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
			substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
	}

	protected function set_file_delete_url($file) {
		$file->delete_url = $this->options['script_url']
			.'?file='.rawurlencode($file->name);
		$file->delete_type = $this->options['delete_type'];
		if ($file->delete_type !== 'DELETE') {
			$file->delete_url .= '&_method=DELETE';
		}
	}


	protected function get_file_object($file_name) {
		$file_path = $this->options['upload_dir'].$file_name;
		if (is_file($file_path) && $file_name[0] !== '.') {
			$file = new stdClass();
			$file->name = $file_name;
			$file->size = filesize($file_path);
			$file->url = $this->options['upload_url'].rawurlencode($file->name);
			//$file->id = $this->options['upload_url'].rawurlencode($file->name);
			foreach($this->options['image_versions'] as $version => $options) {
				if (is_file($options['upload_dir'].$file_name)) {
					$file->{$version.'_url'} = $options['upload_url']
						.rawurlencode($file->name);
				}
			}
			$this->set_file_delete_url($file);
			return $file;
		}
		return null;
	}

	protected function get_file_objects() {
		return array_values(array_filter(array_map(
			array($this, 'get_file_object'),
			scandir($this->options['upload_dir'])
		)));
	}

	protected function create_scaled_image($file_name, $options) {
		$file_path = $this->options['upload_dir'].$file_name;
		$new_file_path = $options['upload_dir'].$file_name;
		list($img_width, $img_height) = @getimagesize($file_path);
		if (!$img_width || !$img_height) {
			return false;
		}
		$scale = min(
			$options['max_width'] / $img_width,
			$options['max_height'] / $img_height
		);
		if ($scale >= 1) {
			if ($file_path !== $new_file_path) {
				return copy($file_path, $new_file_path);
			}
			return true;
		}
		$new_width = $img_width * $scale;
		$new_height = $img_height * $scale;
		$new_img = @imagecreatetruecolor($new_width, $new_height);
		switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
			case 'jpg':
			case 'jpeg':
				$src_img = @imagecreatefromjpeg($file_path);
				$write_image = 'imagejpeg';
				$image_quality = isset($options['jpeg_quality']) ?
					$options['jpeg_quality'] : 75;
				break;
			case 'gif':
				@imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
				$src_img = @imagecreatefromgif($file_path);
				$write_image = 'imagegif';
				$image_quality = null;
				break;
			case 'png':
				@imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
				@imagealphablending($new_img, false);
				@imagesavealpha($new_img, true);
				$src_img = @imagecreatefrompng($file_path);
				$write_image = 'imagepng';
				$image_quality = isset($options['png_quality']) ?
					$options['png_quality'] : 9;
				break;
			default:
				$src_img = null;
		}
		$success = $src_img && @imagecopyresampled(
			$new_img,
			$src_img,
			0, 0, 0, 0,
			$new_width,
			$new_height,
			$img_width,
			$img_height
		) && $write_image($new_img, $new_file_path, $image_quality);
		// Free up memory (imagedestroy does not delete files):
		@imagedestroy($src_img);
		@imagedestroy($new_img);
		return $success;
	}

	protected function has_error($uploaded_file, $file, $error) {
			
			$message = $uploaded_file;
			// error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
			
		if ($error) {
			return $error;
		}
		if (!preg_match($this->options['accept_file_types'], $file->name)) {
			return 'acceptFileTypes';
		}
		if ($uploaded_file && is_uploaded_file($uploaded_file)) {
			$file_size = filesize($uploaded_file);
		} else {
			$file_size = $_SERVER['CONTENT_LENGTH'];
		}
		if ($this->options['max_file_size'] && (
				$file_size > $this->options['max_file_size'] ||
				$file->size > $this->options['max_file_size'])
			) {
			return 'maxFileSize';
		}
		if ($this->options['min_file_size'] &&
			$file_size < $this->options['min_file_size']) {
			return 'minFileSize';
		}
		if (is_int($this->options['max_number_of_files']) && (
				count($this->get_file_objects()) >= $this->options['max_number_of_files'])
			) {
			return 'maxNumberOfFiles';
		}
		return $error;
	}

	protected function upcount_name_callback($matches) {
		$index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
		$ext = isset($matches[2]) ? $matches[2] : '';
		return ' ('.$index.')'.$ext;
	}

	protected function upcount_name($name) {
		return preg_replace_callback(
			'/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
			array($this, 'upcount_name_callback'),
			$name,
			1
		);
	}
	protected function get_unique_filename($name,$type) {
		$tmp_path = $this->options['upload_dir'].$name;
		if(file_exists($tmp_path)) {
			$name = $this->upcount_name($name);
		}
		return $name;
	}

	 protected function get_file_name($name,$type) {
		return $this->get_unique_filename(
			$this->trim_file_name($name, $type),
			$type
		);
	}

	protected function trim_file_name($name, $type) {
		// Remove path information and dots around the filename, to prevent uploading
		// into different directories or replacing hidden system files.
		// Also remove control characters and spaces (\x00..\x20) around the filename:
		$name = trim(basename(stripslashes($name)), ".\x00..\x20");
		// Add missing file extension for known image types:
		if (strpos($name, '.') === false &&
			preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
			$name .= '.'.$matches[1];
		}
		$name = preg_replace('[\s+]','', $name);
		return $name;
	}

	protected function orient_image($file_path) {
		$exif = @exif_read_data($file_path);
		if ($exif === false) {
			return false;
		}
		$orientation = intval(@$exif['Orientation']);
		if (!in_array($orientation, array(3, 6, 8))) {
			return false;
		}
		$image = @imagecreatefromjpeg($file_path);
		switch ($orientation) {
			  case 3:
				$image = @imagerotate($image, 180, 0);
				break;
			  case 6:
				$image = @imagerotate($image, 270, 0);
				break;
			  case 8:
				$image = @imagerotate($image, 90, 0);
				break;
			default:
				return false;
		}
		$success = imagejpeg($image, $file_path);
		// Free up memory (imagedestroy does not delete files):
		@imagedestroy($image);
		return $success;
	}

	/**
	 * Function to replace many caracters into a string
	 * @param array $leters list of letters to replace 
	 * @param string $name String to replace
	 * @param number $idx Counter, default 0
	 * @return string
	 */
	function __replace_special_name($leters = array(),$name = "", $idx = 0){
		
		if(count($leters) > $idx){
			$name = str_replace($leters[$idx][0], $leters[$idx][1], $name);
			return $this->__replace_special_name($leters,$name,++$idx);
		}else{
			return $name;
			
		}	
		
	}
	
	
	protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $temporal_id, $is_document, $description) {
		
		$file = new stdClass();
		//cambio
		$date = date('Y-m-d H:i:s');
		$method = 'UploadComponent'; 
		$message = "$date - $method: Entre a handle_file_upload";
		error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
		
		$name = $this->__replace_special_name($this->STR_TO_REPLACE,$name);
		
		$date = date('Y-m-d H:i:s');
		$method = 'UploadComponent'; 
		$message = "$date - $method: cambie el nombre a '$name'";
		error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
		
		$real_name = $name;
		$time_name = microtime(false);
		$time_name = str_replace(" ", "", $time_name);
		$time_name = str_replace(".", "", $time_name);
		$ext = explode('.', $name);
		$extension = end($ext);
		$n = '';
		for ($i=0; $i < count($ext) - 1; $i++) { 
			$n = $n.$ext[$i];
		}
		$time_name = $n.'_'.$time_name;
		if(strlen($extension) == 3 || strlen($extension) == 4)
			$time_name = $time_name.'.'.$extension;
		$file->name = $this->trim_file_name($time_name, $type);
		//Fin
		//$file->name = $this->get_file_name($name, $type);
		$file->size = intval($size);
		$file->type = $type;
		$error = $this->has_error($uploaded_file, $file, $error);
		if (!$error && $file->name) {
			$file_path = $this->options['upload_dir'].$file->name;
			$append_file = !$this->options['discard_aborted_uploads'] &&
				is_file($file_path) && $file->size > filesize($file_path);
			clearstatcache();
			if ($uploaded_file && is_uploaded_file($uploaded_file)) {
				// multipart/formdata uploads (POST method uploads)

				// File information to save on database
				$data = array(
						'Upload' => array(
							'name' => $file->name,
							'size' => $size,
							'message_id' => null,
							'real_name' => $real_name,
							'url' => $this->options['upload_url'].rawurlencode($file->name),
							'temporal' => $temporal_id
						)
					);

				if ($is_document == '1'){
					$data = array(
						'Upload' => array(
							'name' => $file->name,
							'size' => $size,
							'message_id' => null,
							'real_name' => $real_name,
							'url' => $this->options['upload_url'].rawurlencode($file->name),
							'temporal' => $temporal_id,
							'document' => 1,
							'visible' => 1,
							'description' => $description
						)
					);
				}
				
				// Save on database
				$this->UploadModel->save( $data );
				$file->id = $this->UploadModel->id;
				
				$fileName = $file->name;
				
				
				if ($append_file) {
					file_put_contents(
						$file_path,
						fopen($uploaded_file, 'r'),
						FILE_APPEND
					);
				} else {
					move_uploaded_file($uploaded_file, $file_path);
				}
			} else {
				// Non-multipart uploads (PUT method support)
				file_put_contents(
					$file_path,
					fopen('php://input', 'r'),
					$append_file ? FILE_APPEND : 0
				);
			}
			$file_size = filesize($file_path);
			if ($file_size === $file->size) {
				if ($this->options['orient_image']) {
					$this->orient_image($file_path);
				}
				$file->url = $this->options['upload_url'].rawurlencode($file->name);
				foreach($this->options['image_versions'] as $version => $options) {
					if ($this->create_scaled_image($file->name, $options)) {
						if ($this->options['upload_dir'] !== $options['upload_dir']) {
							$file->{$version.'_url'} = $options['upload_url']
								.rawurlencode($file->name);
						} else {
							clearstatcache();
							$file_size = filesize($file_path);
						}
					}
				}
			} else if ($this->options['discard_aborted_uploads']) {
				unlink($file_path);
				$file->error = 'abort';
			}
			$file->size = $file_size;
			$this->set_file_delete_url($file);
		} else {
			$file->error = $error;
		}
		
		if($file->name){
			$fileName = $file->name;
		/**************** Move file to /var/repo ********************/
			$date = date('Y-m-d H:i:s');
			$method = 'CargaDocumento'; 
			$message = "$date - $method: Subiendo documento '$fileName'";
			error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
			//chown($this->options['upload_dir'], 'apache');
			chmod($this->options['upload_dir'].$fileName, 0777);
			$result = $this->__move_file($fileName, $this->options['upload_dir'], $this->options['repo_dir']);
			
			$date = date('Y-m-d H:i:s');
			$method = 'CargaDocumento'; 
			$message = "$date - $method: resultado: '$result'";
			error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
		/********************** End move file ***********************/
		}

		// $this->log($file);
		return $file;

		// $fi = array();
	 //    $fi['id'] = $file['id'];
	 //    $fi['delete_type'] = DELETE;
		// return $fi;
	}

	/**
	 * Function that move a file from a folder to other
	 * @param string $file
	 * @param string $from
	 * @param string $to
	 */
	function __move_file($file, $from, $to){
		
		$date = date('Y-m-d H:i:s');
		$method = 'UploadComponent'; 
		$message = "$date - $method: __move_file: moving... $from$file";
		error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
				
				
		if(file_exists($from . $file)){
			$date = date('Y-m-d H:i:s');
			$method = 'UploadComponent'; 
			$message = "$date - $method: __move_file: file exists!!";
			error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
				
			//$resp = copy($from.$file, $to.'temp_local.pdf');
			$resp = copy($from.$file, $to.$file);
			
			$content = file_get_contents($to.'temp_local.pdf');
			//file_put_contents('/10.252.76.182'.$to.'temp.pdf', $content);
			//$resp = copy($from.$file, '/10.252.76.182'.$to.'temp.pdf');
			
			$date = date('Y-m-d H:i:s');
			$method = 'UploadComponent'; 
			$message = "$date - $method: __move_file: copying file... $to$file -$resp-";
			error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
				
			return $resp;
		}
		
			$date = date('Y-m-d H:i:s');
			$method = 'UploadComponent'; 
			$message = "$date - $method: __move_file: file no exists :(";
			error_log("$message\n", 3, "/var/www/correspondenciaestatal.gob.pa/html/tmp/logs/info_uploads.log");
		return false;
	}
	
	public function get() {
		$file_name = isset($_REQUEST['file']) ?
			basename(stripslashes($_REQUEST['file'])) : null;
		if ($file_name) {
			$info = $this->get_file_object($file_name);
		} else {
			//$info = $this->get_file_objects();
			$info = '';
		}
		header('Content-type: application/json');
		echo json_encode($info);
	}

	public function post() {
		if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
			return $this->delete();
		}
		//$entity = $_POST['entity'];
		//$idEntity = $_POST['id_entity'];
		$temporalId = $_POST['messageid'];
		$isDocument = $_POST['isdocument'];
		$description = $_POST['description'];
		$upload = isset($_FILES[$this->options['param_name']]) ?
			$_FILES[$this->options['param_name']] : null;
		$info = array();

		if ($upload && is_array($upload['tmp_name'])) {
			// param_name is an array identifier like "files[]",
			// $_FILES is a multi-dimensional array:
			foreach ($upload['tmp_name'] as $index => $value) {
				$name_real = $upload['name'][$index];
				$info[] = $this->handle_file_upload(
					$upload['tmp_name'][$index],
					isset($_SERVER['HTTP_X_FILE_NAME']) ?
						$_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
					isset($_SERVER['HTTP_X_FILE_SIZE']) ?
						$_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
					isset($_SERVER['HTTP_X_FILE_TYPE']) ?
						$_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
					$upload['error'][$index]
					//$entity,
					//$idEntity
					// $temporalId,
					// $isDocument,
					// $description
				);
			}
		} elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
			$name_real = $upload['name'];
			// param_name is a single object identifier like "file",
			// $_FILES is a one-dimensional array:
			$info[] = $this->handle_file_upload(
				isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
				isset($_SERVER['HTTP_X_FILE_NAME']) ?
					$_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
						$upload['name'] : null),
				isset($_SERVER['HTTP_X_FILE_SIZE']) ?
					$_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
						$upload['size'] : null),
				isset($_SERVER['HTTP_X_FILE_TYPE']) ?
					$_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
						$upload['type'] : null),
				isset($upload['error']) ? $upload['error'] : null
				//$entity,
				//$idEntity
				// $temporalId,
				// $isDocument,
				// $description

			);
		}
		header('Vary: Accept');
		$this->log($info);

		$json = json_encode($info);
		$redirect = isset($_REQUEST['redirect']) ?
			stripslashes($_REQUEST['redirect']) : null;
		if ($redirect) {
			header('Location: '.sprintf($redirect, rawurlencode($json)));
			return;
		}
		if (isset($_SERVER['HTTP_ACCEPT']) &&
			(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}
		$json = json_decode($json, true);
		$json[0]['name'] = $name_real;
		// $json[0]['url'] = "";
		$json[0]['delete_url'] = "";
		$json = json_encode($json);

		echo $json;
	}

	public function findByRealName($real_name){
		$result = $this->UploadModel->find('first', array('conditions'=>array('Upload.name' => $real_name)));
		return $result;
	}

	public function delete() {
		$file_name = isset($_REQUEST['file']) ?
			basename(stripslashes($_REQUEST['file'])) : null;
		$file_path = $this->options['upload_dir'].$file_name;
		$success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
		if ($success) {

			## Delete file from database
			$aux = $this->UploadModel->findByName( $file_name );
			$this->UploadModel->delete( $aux['Upload']['id'] );


			foreach($this->options['image_versions'] as $version => $options) {
				$file = $options['upload_dir'].$file_name;
				if (is_file($file)) {
					unlink($file);
				}
			}
		}
		header('Content-type: application/json');
		echo json_encode($success);
	}

	public function findDocumentsByMessage($idMessage){
		$uploads = $this->UploadModel->find('all', array(
			'conditions' => array(
				'message_id' => $idMessage,
				)
			)
		);
		return $uploads;
	}

	public function findDocumentsByTemporal($idTemporal){
		$uploads = $this->UploadModel->find('all', array(
			'conditions' => array(
				'temporal' => $idTemporal,
				)
			)
		);
		return $uploads;
	}

		public function findDocumentsByName($name){
		$uploads = $this->UploadModel->find('all', array(
			'conditions' => array(
				'name' => $name,
				)
			)
		);
		return $uploads;
	}

		public function findDocumentsById($id){
		$uploads = $this->UploadModel->find('all', array(
			'conditions' => array(
				'id' => $id,
				)
			)
		);
		return $uploads;
	}
	
	public function findById($id){
		return $this->UploadModel->findById($id);
	}

	public function findTemplatesVisible(){
		$uploads = $this->UploadModel->find('all', array(
			'conditions' => array(
				'document' => 1,
				'visible' => 1
				)
			)
		);
		return $uploads;
	}

	public function findAllTemplates(){
		$uploads = $this->UploadModel->find('all', array(
			'conditions' => array(
				'document' => 1,
				)
			)
		);
		return $uploads;
	}

	public function saveChange($upload){
		if ($this->UploadModel->save($upload)){
			return true;
		}
		else {
			return false;
		}
	}

	public function deleteRegistre($upload){
		if ($this->UploadModel->delete($upload['Upload']['id'])){
			return true;
		}
		else {
			return false;
		}
	}

	public function deleteRegistreById($idUpload){
		if ($this->UploadModel->delete($idUpload)){
			return true;
		}
		else {
			return false;
		}
	}

	public function getDocuments($idmessage) {
       	$documents = $this->UploadModel->find('all',
          	array(
          		'conditions' => array(
          			'message_id' => $idmessage
          		)
          	)
        );
        $this->autoRender = false;
        return $documents;
    }

    public function deleteAll($idMessage){
    	$this->UploadModel->deleteAll(array('message_id' => $idMessage), false);
    	return true;
    }

    public function makeVisible($idUpload, $visible) {
    	$upload = $this->UploadModel->findById($idUpload);
    	$upload['Upload']['visible'] = $visible;
    	if ($this->UploadModel->save($upload)) return true;
    	return false;
    }

    public function saveFormatToMessage($idUpload, $messageid) {
    	$upload = $this->UploadModel->findById($idUpload);
		$upload['Upload']['id'] = '';    	
		$upload['Upload']['document'] = 0;    	
		$upload['Upload']['visible'] = 0;    	
		$upload['Upload']['description'] = '';    	
    	$upload['Upload']['message_id'] = $messageid;
    	$this->UploadModel->create();
    	if ($this->UploadModel->save($upload)) return true;
    	return false;
    }

    public function addUploadRow($upload) {
    	$this->UploadModel->create();
    	if ($this->UploadModel->save($upload)) {
    		$id = $this->UploadModel->getLastInsertID();
    		return $id;
    	}
    	return false;
    }

    public function getLastFormat($descUpload){
    	$lastCreated = $this->UploadModel->find('first', array(
        	'order' => array('id' => 'desc'),
        	'conditions' => array('document' => 1, 'visible' => 1, 'description' => $descUpload)
    	));
    	return $lastCreated;
    }
    
    public function updateTemporal($id,$temporal){
    	
    	$this->UploadModel->id = $id;
    	$this->UploadModel->saveField('temporal', $temporal);
    }
}
