<?php echo $this->Session->flash(); 
//debug($communication, $scope = array());
?>
<div class="page-header">
	<h1>
		Nueva Comunicación
		<small>
			<i class="icon-double-angle-right"></i>
			Crear una nueva comunicación
		</small>
	</h1>
	
</div>
<div class="row" id="communication" data-communication-id="<?php  echo $communication['Communication']['id'] ?>" data-message-id="<?php  echo $communication['Trace'][0]['Message']['id'] ?>">
	<div class="col-xs-12">
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>
			<div class="col-sm-11">
				&nbsp;
				<div id="content-receivers">
					<?php
						$hasCC = false;
					 foreach ($communication['Trace'] as $key => $trace) { 
						if ($trace['Trace']['type_delivery'] == 0) {
						?>
						<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag" id="undefined_0" data-type="user" data-id="<?php echo $trace['ReceiveUser']['id']?>" data-pre="true"><span><?php echo $trace['ReceiveUser']['first_name'].' '.$trace['ReceiveUser']['last_name'] ?>&nbsp;&nbsp;</span><a href="#" class="myTagRemover rm-nw" id="undefined_Remover_0" tagidtoremove="0" title="Eliminar" data-trace-id="<?php echo $trace['Trace']['id'] ?>">x</a></span>
					<?php }
						else {
							$hasCC = true;
						} } ?>
				</div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Para </label>
			<div class="col-sm-11">
				<input style="margin-top:5px;" type="text" id="prueba" placeholder="agregar persona o entidad" class="col-xs-10 col-sm-10" data-items="4">
				<span class="input-group-btn">
					<button id="btnShowModalCategoryTo" class="btn btn-sm btn-default" type="button" title="Búsqueda avanzada">
						<i class="icon-search bigger-110"></i>
					</button>
				</span>
			</div>
		</div>
		<br><br>
		<div class="form-group <?php if (!$hasCC) echo 'hide' ?>" id="content-tags-receivers-cc">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>
			<div class="col-sm-11">
				&nbsp;
				<div id="content-receivers-cc">
					<?php foreach ($communication['Trace'] as $key => $trace) { 
						if ($trace['Trace']['type_delivery'] == 1) { 
						?>
						<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag" id="undefined_0" data-type="user" data-id="<?php echo $trace['ReceiveUser']['id']?>" data-pre="true"><span><?php echo $trace['ReceiveUser']['first_name'].' '.$trace['ReceiveUser']['last_name'] ?>&nbsp;&nbsp;</span><a href="#" class="myTagRemover rm-nw" id="undefined_Remover_0" tagidtoremove="0" title="Eliminar" data-trace-id="<?php echo $trace['Trace']['id'] ?>">x</a></span>
					<?php } } ?>
				</div>
			</div>
		<br>
		<br>
		</div>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> C.C. </label>
			<div class="col-sm-11">
				<input style="margin-top:5px;" type="text" id="cc" placeholder="agregar persona o entidad" class="col-xs-10 col-sm-10" data-items="4">
				<span class="input-group-btn">
					<button id="btnShowModalCategoryCC" class="btn btn-sm btn-default" type="button" title="Búsqueda avanzada2">
						<i class="icon-search bigger-110"></i>
					</button>
				</span>
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> N°  </label>
			<div class="col-sm-11">
				<input type="text" id="message-correlative" placeholder="N° de Correspondecia" class="col-xs-10 col-sm-10" required>
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Asunto </label>
			<div class="col-sm-11">
				<input type="text" id="message-title" placeholder="asunto" class="col-xs-10 col-sm-10" value="<?php echo $communication['Trace'][0]['Message']['title'] ?>">
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">Fecha tope</label>
			<div class="col-sm-11">
				<input style="width:280px;"  type="text" placeholder="Fecha de vencimiento para la respuesta" readonly  id="expires">
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-2 control-label no-padding-right text-right" for="form-field-1"> Tipo de Correspondencia</label>
			<div class="col-sm-4">
				<select class="form-control" id="message-type">
					<option value="">Seleccione</option>
					<?php foreach ($communicationTypes as $key => $communicationType) {
					 ?>
					<option value="<?php echo $key ?>" <?php if ($key == $communication['Communication']['communication_type_id']) echo 'selected="selected"'; ?>><?php echo $communicationType?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-2 control-label no-padding-right text-right" for="form-field-1"> Categoría </label>
			<div class="col-sm-4">
				<select class="form-control" id="message-category">
					<option value="">Seleccione</option>
					<?php 

					foreach ($communicationCategories as $key => $communicationCategory) {
					 ?>
					<option value="<?php echo $key; ?>" <?php if ($key == $communication['Communication']['communication_category_id']) echo 'selected="selected"'; ?> ><?php echo $communicationCategory;?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-xs-5">
				<div class="pull-right">
					<button id="btn-add-format" class="btn btn-grey btn-xs <?php if (empty($communication['Communication']['communication_category_id'] ) ) echo 'hide' ?>" title="Formatos">
						<i class="icon-file-text  icon-2x icon-only"></i>
					</button>
				</div>
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Etiquetas </label>

			<div class="col-sm-4">
				<input type="text" name="" id="pruebados" value="" placeholder="Agregar etiqueta" />
			</div>
			<div class="col-sm-6">
				<div id="contentTags">
					<?php foreach ($communication['Tag'] as $key => $tag) { ?>
						<span class="tag label pull-right label-warning" style="margin: 2px 1px; padding:2px 3px;" data-tag-id="<?php echo $tag['id'] ; ?>" data-pre="true"><?php echo $tag['name']; ?> <button type="button" class="close" data-tag-id="<?php echo $tag['id'] ; ?>">&times;</button></span>
					<?php } ?>
				</div>
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Privado </label>

			<div class="col-sm-1">
				<label class="middle">
					<input class="ace" type="checkbox" id="id-private-message" <?php if ($communication['Trace'][0]['Message']['private'] == 1) echo 'checked="checked"';?>>
					<span class="lbl"> &nbsp; </span>
				</label>
			</div>
			<!-- 
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Confirmación de Lectura </label>

			<div class="col-sm-1">
				<label class="middle">
					<input class="ace" type="checkbox" id="e">
					<span class="lbl"> &nbsp; </span>
				</label>
			</div>
			 -->
		</div>
		
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> &nbsp; </label>
			<div class="col-sm-10">
				<div class="wysiwyg-editor" id="message-content"><?php echo $communication['Trace'][0]['Message']['content'] ?></div>
			</div>
		</div>
	</div>
	<br><br>
	<div class="col-sm-10">
		<?php $this->UploadForm->load();?>
	</div>
	<div class="widget-toolbox" style="display: none;">							
		<ul class="attachment-list pull-left list-unstyled" style="width: 95%;background: #EEE;padding-top: 5px;padding-bottom: 5px;">
		</ul>
	</div>
	<br><br>
	
	<div class="col-xs-12">
		<div class="col-xs-1">&nbsp;</div>
		<div class="col-xs-11">
			<div class="files-preuploads">
				<table>
			<?php foreach ($communication['Uploads'] as $key => $upload) { ?>
				<tr class="template-download" data-file-id="<?php echo $upload['Upload']['id']; ?>" data-pre="true" style="height: 32px;">
					<td style="width:10%;">&nbsp;</td>
		            <td class="name">
		                <a href="<?php echo "http://localhost/correspondencia/webroot/files/".$upload['Upload']['name']; ?>" title="" rel="" download="<?php echo $upload['Upload']['name']; ?>" data-original-title="<?php echo $upload['Upload']['name']; ?>"><i class="icon-file">&nbsp;&nbsp;</i><?php echo $upload['Upload']['real_name']; ?>
		                </a>
		            </td>
		            <td class="size" style="width:65px">
		            	<span>&nbsp;&nbsp;<small><?php echo $upload['Upload']['size']; ?> Kb</small></span>
		            </td>
			        <td class="delete">
			            <button data-file-id="<?php echo $upload['Upload']['id']; ?>" class="btn btn-whites btn-delete-preupload" >
			                <i class="icon-trash red bigger-130 middle"></i>
			                <span class="hide">Eliminar</span>
			            </button>
			        </td>
			    </tr>
			<?php } ?>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Acción </label>
			<div class="col-sm-9">
				<div class="control-group">
					<div class="col-sm-6">

						
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="2" <?php if ($communication['Communication']['action_id'] == 2) echo 'checked="checked"';?>>
								<span class="lbl"> Aprobación</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="3" <?php if ($communication['Communication']['action_id'] == 3) echo 'checked="checked"';?>>
								<span class="lbl"> Devolver con observaciones</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="7">
								<span class="lbl"> Requiere Firma Electronica</span>
							</label>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="4" <?php if ($communication['Communication']['action_id'] == 4) echo 'checked="checked"';?>>
								<span class="lbl"> Dar respuesta</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="5" <?php if ($communication['Communication']['action_id'] == 5) echo 'checked="checked"';?>>
								<span class="lbl"> Confirmar Asistencia</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="5" <?php if ($communication['Communication']['action_id'] == 6) echo 'checked="checked"';?>>
								<span class="lbl"> Informativo</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>
</div>
<div class="row">
	<div class="col-xs-11">
		<button id="btn-send-message" class="btn btn-info pull-right " type="button">
			<i class="icon-ok bigger-110"></i>
			Enviar
		</button> 
		<span style="width:5px;" class="pull-right">&nbsp;</span>
		<button id="btn-send-draft" class="btn btn-warning pull-right " type="button">
			Guardar como Borrador
		</button> &nbsp;&nbsp;
		 
			<?php if($this->Session->read('UserAuth.User.signed') == 1 ){?>
		<div class="signing-file" style="width:63%; display:inline-block; text-align: right;">
	    	<span class="btn-file-sign btn btn-info" style="margin-right: 0px;">
	        	<img src="<?php echo $this->webroot;?>img/Award_ribbon_cup.png" alt="Certificar" height="18" width="18">
	        
	            <span>Firmar Electr&oacute;nicamente y Enviar</span>
	        </span>
	    </div>
	    	<?php }?> 
	</div>
</div>

<div class="modal fade" id="modalAddFormat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="myModalLabel">Formatos</h4>
      		</div>
      		<div class="modal-body">
        		Cargando formatos ...
      		</div>
      		<div class="modal-footer">
	        	<button type="button" class="btn btn-primary" id="btn-append-format">Cerrar</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal fade" id="modalCertificateCommunication" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="myModalLabel">Certificando Correspondencia</h4>
      		</div>
      		<div class="modal-body">
        		Esta correspondencia será firmada electrónicamente y redirigida a la bandeja una vez se finalice el proceso de la Firma. Se está generando el resumen de la correspondencia como un adjunto de “Correspondencia Certificada”, esto puede tomar unos minutos mientras se certifican todos los documentos generados y sus adjuntos. 
      		</div>
      		<div class="modal-footer">
	        	<!--<button type="button" class="btn btn-primary" id="btn-cancel-certificate" data-dismiss="modal">Cerrar</button>-->
	        	<button type="button" class="btn btn-primary" id="btn-acept-certificate" data-dismiss="modal">Aceptar</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal fade" id="modalDirectory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-append-to="">
  	<div class="modal-dialog" style="width:1000px;">
    	<div class="modal-content">
    		<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Búsqueda avanzada2</h4>
	      	</div>
      		<div class="modal-body">
        		Cargando formatos ...
      		</div>
    	</div>
  	</div>
</div>
<?php echo $this->Html->script('lib/bootstrap-datepicker.js'); ?>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#expires').datepicker({
                	format: "yyyy-mm-dd",
                	startDate: '+0d',
                	autoclose: true
                });  
            
            });
        </script>
