<?php  
App::uses('AppHelper', 'View/Helper');

/**
* Helper to load the upload form
*
* NOTE: If you want to use it out of this plugin you NEED to include the CSS files in your Application.
* The files are loaded in `app/Plugins/FileUpload/View/Layouts/default.ctp` starting at line 16
*
*/
class UploadFormHelper extends AppHelper {

	/**
	*	Load the form
	* 	@access public
	*	@param String $url url for the data handler
	*   @param Boolean $loadExternal load external JS files needed
	* 	@return void
	*/
	public function load( $url = '/file_upload/handler', $loadExternal = true ,$imgForm = false, $edit = false)
	{
		// Remove the first `/` if it exists.
	    if( $url[0] == '/' )
	    {
	        $url = substr($url, 1);
	    }


		if($imgForm){
			$this->_loadTemplateImg( $url , $edit);

			$this->_loadScriptsImg($edit);
		}
		else{
			$this->_loadTemplate( $url , $edit);

			$this->_loadScripts();
		}
		
		if( $loadExternal )
		{
			//$this->_loadExternalJsFiles();	
		}
		
	}

	/**
	*	Load the scripts needed.
	* 	@access private
	* 	@return void
	*/
	private function _loadScripts()
	{
		echo '<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    
		    <tr class="template-upload fade" style="width:100%;">
		    	<td> 
	                <input id="description" class="hide cdescription" type="text" name="description" placeholder="Nombre del formato">
	            </td>
		        <td class="prreview"><span class="fade"></span></td> 
		        <td class="name" style="padding-left:10px;"><i class="icon-file">&nbsp;&nbsp;</i><span>{%=file.name%}</span></td>
		        <td class="size"><span>&nbsp;&nbsp;<small>{%=o.formatFileSize(file.size)%}</small>&nbsp;&nbsp;</span></td>
		        {% if (file.error) { %}
		            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
		        {% } else if (o.files.valid && !i) { %}
		            <td style="width:100px;">
		            	<div style="margin:0px;" class="progress" data-percent="cargando ..." >
							<div class="progress-bar bar" style="width:0%;"></div>
						</div>
		            </td>
		            <td class="subir hide">
		            	<button class="btn btn-xs btn-primary btn-subir">
		                    <i class="icon-upload icon-white"></i>
		                    <span>Subir</span>
		                </button>
		            </td>
		            <td class="start hide">{% if (!o.options.autoUpload) { %}
		            	
		                <button class="btn btn-xs btn-primary btn-start-preupload hide">
		                    <i class="icon-upload icon-white"></i>
		                    <span>Subir</span>
		                </button>
		            {% } %}</td>
		        {% } else { %}
		            <td colspan="2"></td>
		        {% } %}

		        <td class="cancel">{% if (!i) { %}
		            <button class="btn btn-whites">
		        	&nbsp;&nbsp;&nbsp;<i class="icon-trash red bigger-130 middle" title="{%=locale.fileupload.cancel%}"></i>
		            </button>
		        {% } %}</td>	
		    </tr>
		{% } %}

			
		</script>';
		///formatos y al parecer correspondencia
		echo'<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-download fade" data-file-id="{%=file.id%}">
		        {% if (file.error) { %}
		            <td></td>
		            <td class="name"><span>{%=file.name%}</span></td>
		            <td class="size" style="width:65px"><span>&nbsp;&nbsp;<small>{%=o.formatFileSize(file.size)%}</small></span></td>
		            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error]%}</td>
		        {% } else { %}
		            <td class="preview">{% if (file.thumbnail_url) { %}
		                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
		            {% } %}</td>
		            <td class="name">
		                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&\'gallery\'%}" download="{%=file.name%}"><i class="icon-file">&nbsp;&nbsp;</i>{%=file.name%}</a>
		            </td>
		            <td class="size" style="width:65px"><span>&nbsp;&nbsp;<small>{%=o.formatFileSize(file.size)%}</small></span></td>
		            <td colspan="2"></td>
		        {% } %}
		        <td class="delete">
		            <button class="btn btn-whites btn-prueba" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
		                <i class="icon-trash red bigger-130 middle"></i>
		                <span class="hide">{%=locale.fileupload.destroy%}</span>
		            </button>
		            <input class="hide" type="checkbox" name="delete" value="1">
		        </td>
				<td class="signature" style="display:none;">
		            <input type="checkbox" name="signature[]" class="signature-check" value="1"> Requiere Firma
		        </td>
		    </tr>

		{% } %}
		</script>';

	}

	/**
	*	Load the entire form structure.
	* 	@access private
	* 	@return void
	*/
	private function _loadTemplate( $url = null , $format = false)
	{

		$display = 'display:none;'; 
		if($format){$display = 'display:none;';}
			
		echo '<div class="col-sm-12 col-sm-offset-1">
		<form id="fileupload" style="padding-left:15px;" action="'.Router::url('/', true).$url.'" method="POST" enctype="multipart/form-data">
	        <div class=" fileupload-buttonbar">
	        	<div class="hide">

	        		<div class="progress" data-percent="0%" active fade>
						<div class="progress-bar bar" style="width:0%;"></div>
					</div>

	            </div>
	            <div class="add-file pull-right in-edit" style="width:35%; display:inline-block; text-align:right;">
	        		<span class="btnf btn-warningf fileinput-button btn-fileup btn btn-success">
	                    <i class="icon-paperclip icon-white" style="color:white;"></i>
	                    <span>Adjuntar Documento</span>
	                </span>
	            </div>
				<div class="signing-file" style="width:64%; '.$display.' text-align: right;">
	        		<span class="btn-file-sign btn btn-info" style="margin-right: -22px;">
	                    <!--<i class="icon-pencil icon-white" style=""></i>-->
						<img src="'.$this->webroot.'img/Award_ribbon_cup.png" alt="Certificar" height="21" width="21">
	                    <span>Firmar Correspondencia Electr&oacute;nicamente</span>
	                </span>
	            </div>
	            <div class="">
	                <input class="hide btn-fileup-h" type="file" name="files[]" multiple>
	                <input id="txtIdMessage" class="hide" type="text" name="messageid">
	                <input id="isDocument" class="hide" type="text" name="isdocument">
	                
	                <button type="submit" class="btn btn-primary start hide" id="btn-upload-files">
	                    <i class="icon-upload icon-white"></i>
	                    <span>Iniciar Subida</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel hide">
	                    <i class="icon-ban-circle icon-white"></i>
	                    <span>Cancelar Subida</span>
	                </button>
	                <button type="button" class="btn btn-danger delete hide" id="deleteDocuments">
	                    <i class="icon-trash icon-white"></i>
	                    <span>Eliminar</span>
	                </button>
	                <input type="checkbox" class="toggle hide" id="selectAllDocuments">
	            </div>
	        </div>
	        <div class="fileupload-loading"></div>
	        <br>
	        <div class="row">
	        	<div class="span11">
		        	<div class="table-documents">
			        	<div class="files">
			        	</div>
		        	</div>
	        	</div>
	        </div>
	    </form>
	    </div>
	';	
	/*
		echo '<div class="container">
		<form id="fileupload" action="'.Router::url('/', true).$url.'" method="POST" enctype="multipart/form-data">
	        <div class="row fileupload-buttonbar">
	        	<div class="span5">
	                <div class="progress progress-success progress-striped active fade">
	                    <div class="bar" style="width:0%;"></div>
	                </div>
	            </div>
	            <div class="span6">
	        		<span class="btn btn-success fileinput-button btn-fileup pull-right">
	                    <i class="icon-plus icon-white"></i>
	                    <span>Agregar Documento</span>
	                </span>
	            </div>
	            <div class="span11">
	                <input class="hide btn-fileup-h" type="file" name="files[]" multiple>
	                <input id="txtEntity" class="hide" type="text" name="entity">
	                <input id="txtIdEntity" class="hide" type="text" name="message_id">
	                
	                <button type="submit" class="btn btn-primary start">
	                    <i class="icon-upload icon-white"></i>
	                    <span>Iniciar Subida</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel">
	                    <i class="icon-ban-circle icon-white"></i>
	                    <span>Cancelar Subida</span>
	                </button>
	                <button type="button" class="btn btn-danger delete" id="deleteDocuments">
	                    <i class="icon-trash icon-white"></i>
	                    <span>Eliminar</span>
	                </button>
	                <input type="checkbox" class="toggle" id="selectAllDocuments">
	            </div>
	        </div>
	        <div class="fileupload-loading"></div>
	        <br>
	        <div class="row">
	        	<div class="span11">
		        	<table class="table table-striped table-documents">
			        	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
			        	</tbody>
		        	</table>
	        	</div>
	        </div>
	    </form>
	</div>
	
	';	
	*/	
	}
	
	
	/**
	 *	Load the scripts needed.
	 * 	@access private
	 * 	@return void
	 */
	private function _loadScriptsImg($edit)
	{
		$e = $edit ? '-e' : '';
		echo '<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
	
		    <tr class="template-upload fade" style="width:100%;">
		    	<td>
	                <input id="description" class="hide cdescription" type="text" name="description" placeholder="Nombre del formato">
	            </td>
		        <td class="prreview"><span class="fade"></span></td>
		        <td class="name" style="padding-left:10px;"><i class="icon-file">&nbsp;&nbsp;</i><span>{%=file.name%}</span></td>
		        <td class="size"><span>&nbsp;&nbsp;<small>{%=o.formatFileSize(file.size)%}</small>&nbsp;&nbsp;</span></td>
		        {% if (file.error) { %}
		            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
		        {% } else if (o.files.valid && !i) { %}
		            <td style="width:100px;">
		            	<div style="margin:0px;" class="progress" data-percent="cargando ..." >
							<div class="progress-bar bar" style="width:0%;"></div>
						</div>
		            </td>
		            <td class="subir hide">
		            	<button class="btn btn-xs btn-primary btn-subir">
		                    <i class="icon-upload icon-white"></i>
		                    <span>Subir</span>
		                </button>
		            </td>
		            <td class="start hide">{% if (!o.options.autoUpload) { %}
		      
		                <button class="btn btn-xs btn-primary btn-start-preupload'.$e.' hide">
		                    <i class="icon-upload icon-white"></i>
		                    <span>Subir</span>
		                </button>
		            {% } %}</td>
		        {% } else { %}
		            <td colspan="2"></td>
		        {% } %}
	
		        <td class="cancel">{% if (!i) { %}
		            <button class="btn btn-whites">
		        	&nbsp;&nbsp;&nbsp;<i class="icon-trash red bigger-130 middle" title="{%=locale.fileupload.cancel%}"></i>
		            </button>
		        {% } %}</td>
		    </tr>
		{% } %}
	
		
		</script>';
		echo'<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-download fade" data-file-id="{%=file.id%}">
		        {% if (file.error) { %}
		            <td></td>
		            <td class="name"><span>{%=file.name%}</span></td>
		            <td class="size" style="width:65px; display:none;"><span>&nbsp;&nbsp;<small>{%=o.formatFileSize(file.size)%}</small></span></td>
		            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error]%}</td>
		        {% } else { %}
		            <td class="preview">{% if (file.thumbnail_url) { %}
		                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
		            {% } %}</td>
		            <td class="name">
		                <img src="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&\'gallery\'%}" download="{%=file.name%}" style="width:60%;">
		            </td>
		            <td class="size" style="width:65px; display:none;"><span>&nbsp;&nbsp;<small>{%=o.formatFileSize(file.size)%}</small></span></td>
		            <td colspan="2"></td>
		        {% } %}
		        <td class="delete" style="position:absolute;">
		            <button class="btn btn-whites btn-prueba" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" style="margin-left:-165px; background-color: rgba(255, 255, 255, 0) !important;">
		                <i class="icon-trash red bigger-130 middle"></i>
		                <span class="hide">{%=locale.fileupload.destroy%}</span>
		            </button>
		            <input class="hide" type="checkbox" name="delete" value="1">
		        </td>
				<td class="signature" style="display:none;">
		            <input type="checkbox" name="signature[]" class="signature-check" value="1"> Requiere Firma
		        </td>
		    </tr>
	
		{% } %}
		</script>';
	
	}
	
	/**
	 * Load the entire form structure
	 * @param string $url
	 * @access private
	 * @return void
	 */
	private function _loadTemplateImg($url = null, $edit){

		$e = $edit ? '-e' : '';
		echo '<div class="col-sm-10">
		<form id="fileupload" style="padding-left:15px;" action="'.Router::url('/', true).$url.'" method="POST" enctype="multipart/form-data">
	        <div class=" fileupload-buttonbar" style="margin-left: -30px;">
	        	<div class="hide">
		
	        		<div class="progress" data-percent="0%" active fade>
						<div class="progress-bar bar" style="width:0%;"></div>
					</div>
		
	            </div>
	            <div class="add-file" style="width:35%; display:inline-block;">
	        		<span class="btnf btn-warningf fileinput-button btn-fileup'.$e.' btn btn-success">
	                    <i class="icon-paperclip icon-white" style="color:white;"></i>
	                    <span>Cargar logo</span>
	                </span>
	            </div>
	            <div class="">
	                <input class="hide btn-fileup-h'.$e.'" type="file" name="files" accept="image/*">
	                <input id="txtIdMessage" class="hide" type="text" name="messageid">
	                <input id="isDocument" class="hide" type="text" name="isdocument">
	        
	                <button type="submit" class="btn btn-primary start hide" id="btn-upload-files">
	                    <i class="icon-upload icon-white"></i>
	                    <span>Iniciar Subida</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel hide">
	                    <i class="icon-ban-circle icon-white"></i>
	                    <span>Cancelar Subida</span>
	                </button>
	                <button type="button" class="btn btn-danger delete hide" id="deleteDocuments">
	                    <i class="icon-trash icon-white"></i>
	                    <span>Eliminar</span>
	                </button>
	                <input type="checkbox" class="toggle hide" id="selectAllDocuments">
	            </div>
	        </div>
	        <div class="fileupload-loading"></div>
	        <br>
	        <div class="row">
	        	<div class="span11">
		        	<div class="table-documents'.$e.'">
			        	<div class="files">
			        	</div>
		        	</div>
	        	</div>
	        </div>
	    </form>
	    </div>
	';
	}

	/**
	*	Load external JS files needed.
	* 	@access private
	* 	@return void
	*/
	private function _loadExternalJsFiles()
	{
		//echo $this->Html->script('jquery-1.7.1.min');
		//echo '<script type="text/javascript" src="'.Router::url('/', true).'jquery-1.7.1.min"></script>';

		echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/vendor/jquery.ui.widget.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/tmpl.min.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/load-image.min.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/canvas-to-blob.min.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.iframe-transport.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.fileupload.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.fileupload-fp.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.fileupload-ui.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/locale.js"></script>';
		echo '<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/main.js"></script>';	
	}

}
?>