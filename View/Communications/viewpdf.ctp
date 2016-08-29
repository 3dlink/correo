	
		<style type="text/css">
			.icon-chevron-down, .icon-chevron-up{
				cursor: pointer;
			}

	.lista {
	max-width: 15em;
    max-height: 15em;
    border: 1px solid #ccc;
    padding: 0;
    margin: 0;
    overflow: scroll;	
    overflow-x: hidden;
	}

	.liLista {
	    border-top: 1px solid #ccc;
	}

	.ulLista  {
	    text-indent: 1em;
	}
	
	
	
		</style>
<?php
	$file_locked = false;
	$history = false;
	$actions = array('','','Aprobación', 'Devolver con observaciones', 'Dar respuesta', 'Confirmar asistencia', 'Informativo' , 'Require Firma Electrónica');


$cuentaCuenta = 0;
foreach ($trace as $keys => $values) {
	$groupAll[$values['Trace']['message_id']][$values['Trace']['namegroup']][$keys] = $values; 
}

foreach ($trace as $ky => $ve) {
	$newArray[$ve['Trace']['namegroup']][$cuentaCuenta] = $ve['Trace']['receive_user_id'];
	$cuentaCuenta ++;
}
foreach ($groupAll as $ky => $vl) {
 	$ks = array_keys($vl);
}


$keys = array_keys($communication['Messages']);
	foreach ($communication['Messages'][$keys[count($keys)-1]]['Uploads'] as $key => $value) {
		if($value['Upload']['locked'] == 1){
			$file_locked = true;
		}
	}
?>

<script type="text/javascript">
$(document).ready(function(){
	$('.edit-file').click(function(){
		$("#numberfile").val($('#fileupload .row .files >tr').length);
		var fileNma = $(this).attr('id');
		$( "#namefile" ).val( function( index, val ) {
  			return val + fileNma + "-";
		});
		//$("#namefile").val($(this).attr('id'));
		$('.btn-fileup').click();
	});
});
</script>
<div class="page-header">
	<h1>
		<?php if($this->Signed->signed($communication['Communication']['id']) > 0){?>
		<i class="message-star c-interaction" title="" data-original-title="Comunicacion Certificada" style=""><img src="https://correspondenciaestatal.gob.pa/img/award.png" alt="Certificar" height="40" width="40"></i>
		<?php }?>
		<?php echo $communication['Communication']['title'] ?>
		<span class="pull-right pop-help">
					<span class="btn  btn-sm tooltip-warning" data-rel="popover" data-placement="bottom" data-content="- Al colocar el puntero del ratón sobre el nombre de algunos de los remitentes o destinatarios aparecerá sobre él un cuadro indicando el nombre de la unidad a la que pertenece.&lt;br&gt;&lt;br&gt;- El ícono &lt;i class='icon-ok'&gt;&lt;/i&gt; indica que el mensaje fue leído por esa persona. Al colocar el puntero del ratón sobre el ícono aparecera un cuadro indicando la fecha y hora en la que fue leído.&lt;br&gt;&lt;br&gt;- El ícono &lt;i class='icon-time'&gt;&lt;/i&gt; indica que el mensaje no ha sido leído por la persona." data-original-title="Indicadores"><i class="icon-question-sign bigger-120"></i></span>
		</span>
	</h1>
	<?php if($communication['Communication']['correlative'] != null){?>
	<h1>
		
		N° de Correspondecia: <?php echo $communication['Communication']['correlative'] ?>
		<input type="hidden" id="correlative"  value="<?php echo $communication['Communication']['correlative'] ?>" />
		
	</h1>
	<?php }?>
	<br>
	<span class="pull-right">
		<span class="label label-danger arrowed"><strong>Acción </strong><?php echo $actions[$communication['Communication']['action_id']] ?></span>
	</span>
</div>

<?php // reply communication ?>
<div id="contentReplyCommunication" class="hide" data-requires-approval="<?php if ($communication['Communication']['action_id'] == '2' && in_array($this->Session->read('UserAuth.User.id'), $communication['canApprove'])) echo '1'; else echo '0';?>">
	<div class="row" id="">
		<div class="col-xs-12">
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>
				<div class="col-sm-11">
					&nbsp;
					<div id="content-receivers">
					<?php 
					$ids_user = array();
					if (isset($users)) {
						foreach ($users as $key => $user) {
							if(isset($user['User']['owner']) &&  $user['User']['owner'] == 1){
								array_push($newArray[''], $user['User']['id']);
							}
							if($user['User']['id'] != $this->Session->read('UserAuth.User.id') && !in_array($user['User']['id'], $ids_user) && @in_array($user['User']['id'], $newArray[''])){
								array_push($ids_user, $user['User']['id']);
							?>
							<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag" id="undefined_0" data-type="user" data-owner="<?php if (isset($user['User']['owner'])) echo 1; else echo 0; ?>" data-id="<?php echo $user['User']['id']?>"><span><?php echo $user['User']['first_name'].' '.$user['User']['last_name'] ?>&nbsp;&nbsp;</span><a href="#" class="myTagRemover rm-nw" id="undefined_Remover_0" tagidtoremove="0" title="Remove">x</a></span>
						<?php } 
							}
					}?>

					<?php 
					$ids_user = array();
					if (isset($users)) {
						foreach ($newArray as $ky => $vl) {
							if($ky != '' && $ky != 'null'){ ?>
								<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag more" id="undefined_0" data-type="user" data-owner="0" ><select style="color: white; background-color: #8CBAD1; border:0px;"><option disabled><?php echo $ky;?></option>
										<?php
								foreach ($users as $key => $user) { 
							
									if(in_array($user['User']['id'], $vl)){
										?>
										<option data-type="user"  data-id="<?php echo $user['User']['id']?>" disabled><?php echo $user['User']['first_name'].' '.$user['User']['last_name']?></option>
										<?php
									}
								}
								?></select><a href="#" class="myTagRemover" id="" tagidtoremove="1" title="" data-original-title="Eliminar">x</a></span><?php
							}
						}
					} ?>

					</div>
				</div>
			</div>
			<br>
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Para</label>
				<div class="col-sm-11">
					<input style="margin-top:5px;" type="text" id="prueba" placeholder="agregar persona o entidad" class="col-xs-10 col-sm-10" data-items="4">
				</div>
			</div>
			<div class="form-group hide"  id="content-tags-receivers-cc">
				<br><br>
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>
				<div class="col-sm-11">
					&nbsp;
					<div id="content-receivers-cc"></div>
				</div>
			</div>
			<br>
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> C.C. </label>
				<div class="col-sm-11">
					<input style="margin-top:5px;" type="text" id="cc" placeholder="agregar persona o entidad" class="col-xs-10 col-sm-10" data-items="4">
				</div>
			</div>
			<div class="form-group hide">
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Asunto </label>
				<div class="col-sm-11">
					<input type="text" id="message-title" placeholder="asunto" class="col-xs-10 col-sm-10" value="<?php echo $communication['Communication']['title'] ?>">
				</div>
			</div>
			<br><br>
			<div class="row">
			<div class="form-group">
				<div class="col-sm-1">&nbsp;</div>
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Privado </label>

				<div class="col-sm-1">
					<label class="middle">
						<input class="ace" type="checkbox" id="id-private-message">
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
			</div>

			<div class="form-group">

				<div class="col-sm-4">&nbsp;</div>
				<div class="col-sm-7">
					<?php 
					// si la comunicacion requiere de aprobacion
					if (($communication['Communication']['action_id'] == 2) && in_array($this->Session->read('UserAuth.User.id'), $communication['canApprove']) ) { 
					?>
					<div class="pull-right">
						<label>
							<input name="RApproval" type="radio" class="ace" id="approvalYes" value="1">
							<span class="lbl"> <i class="icon-ok icon-white"></i> Aprobar</span>
						</label>&nbsp;
						<label>
							<input name="RApproval" type="radio" class="ace" id="approvalNo" value="-1">
							<span class="lbl"> <i class="icon-remove icon-white"></i> Rechazar</span>
						</label>
						<label>
							<input name="RApproval" type="radio" class="ace" id="approvalNo" value="2">
							<span class="lbl"> <i class="icon-edit icon-white"></i> Modificar</span>
						</label>
					</div>
					<?php } ?>
				</div>
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> &nbsp; </label>
			</div>
			<br><br>
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> &nbsp; </label>
				<div class="col-sm-10">
					<div class="wysiwyg-editor" id="message-content"></div>
				</div>
			</div>
		</div>
		<br><br>
		<div class="col-sm-10">
			<?php $this->UploadForm->load();?>
		</div>		
	</div>
	<div class="attachment-title">
									<span class="blue bolder bigger-110">Archivos adjuntos del correo recibido:</span>
							
								</div>
		<?php foreach ($communication['Messages'] as $key => $message) { ?>	
<?php 

if($message['Uploads']){?>
		<div class="widget-toolbox clearfix">
								
								<ul class="attachment-list pull-left list-unstyled">
								<?php

								foreach ($message['Uploads'] as $key => $upload) { 

									$id_file= $upload['Upload']['message_id'];
									$file_name =  $upload['Upload']['real_name'];
									$name_user=$communication['Messages'][$id_file]['UserSender']['first_name']." ".$communication['Messages'][$id_file]['UserSender']['last_name'];
									$last_user_id = $upload['Upload']['last_user_id'];
									$locked = $upload['Upload']['locked'];						
									?>

									<li>
										<a class="<?php if($upload['Upload']['signature'] == 1){ 
												if($upload['Upload']['locked'] == 0 || $upload['Upload']['last_user_id'] == $this->Session->read('UserAuth.User.id')){
													echo 'file';
												} else {
													echo 'linkFile';
												}} ?> attached-file inline" 
											target="_blank" 
											href="<?php //echo $this->webroot.'communications/showfile/'.$upload['Upload']['name']; //$upload['Upload']['url']; ?>" 
											title="<?php //echo $file_name ?>" 
											data-file-id="<?php echo $upload['Upload']['id'] ?>">
											<i class="icon-file-alt bigger-110 middle"></i>
											<span class="attached-name middle"><?php //echo $upload['Upload']['real_name']; ?></span>
										</a>

										<div class="action-buttons inline">
											<?php //echo $this->Html->link('<i class="icon-download-alt bigger-125 blue"></i>', array('controller' => 'communications', 'action'=>'download', $upload['Upload']['name']));
											?>
											<a class="<?php 
													if($upload['Upload']['signature'] == 1){ 
															echo 'file';
														}
													?>" 
												href="<?php 
													$paramFile = '';
													if($upload['Upload']['signature'] == 1){ 
														if($upload['Upload']['locked'] == 1 && $upload['Upload']['last_user_id'] != $this->Session->read('UserAuth.User.id')){
															$paramFile = $upload['Upload']['id'].'/'.$upload['Upload']['token'];
														} 
													}

													echo $this->webroot.'communications/download/'.$upload['Upload']['name'].'/'.$paramFile;
													?>"
												title="Descargar" 
												target="_blank" 
												data-file-id="<?php echo $upload['Upload']['id'] ?>"
											>
											<!--a class="<?php /*if($upload['Upload']['signature'] == 1){ if($upload['Upload']['locked'] == 0 || $upload['Upload']['last_user_id'] == $this->Session->read('UserAuth.User.id')){echo 'file';} else {echo 'linkFile';} }  ?>" href="<?php echo $this->webroot.'communications/download/'.$upload['Upload']['name'];?>" title="Descargar" target="_blank" data-file-id="<?php echo $upload['Upload']['id'] */?>" -->
												<i class="icon-download-alt bigger-125 blue"></i>
											</a>
											<?php if( ($locked == 1 && $this->Session->read('UserAuth.User.id') == $last_user_id) || $locked == 0){ ?>
												<i id="<?php echo $upload['Upload']['name']; ?>" value="hola" title="Reemplazar archivo" class="icon-pencil bigger-125 blue edit-file"></i>
										
												<input id="namefile" type="hidden">
												<input id="numberfile" type="hidden">
											<?php } ?>
										</div>
									</li>
								<?php } ?>
								</ul>
							</div>
		<?php }?>
<?php }?>
	<div class="row">
		<div class="col-xs-11">
			<button id="btn-send-message" class="btn btn-info pull-right " type="button">
				<i class="icon-ok bigger-110"></i>
				Enviar
			</button>
		</div>
	</div>
	<div class="hr hr-double"></div>
</div>

<?php // end reply communication ?>
<div class="row">
	<div class="col-sm-8">
		<div id="contentTags"></div>
	</div>
</div>

<div class="timeline-container" id="communication" data-communication-id="<?php echo $communication['Communication']['id'] ?>">

	<div class="timeline-label">
		<span class="label label-primary arrowed-in-right label-lg">
			<b>Hoy</b>
		</span>
		<span class="pull-right">
			<?php if ($communication['Communication']['action_id'] == 2) {?>
			<span class="badge badge-success apr-apr" data-rel="tooltip" data-original-title="<?php foreach ($communication['MessagesApprovals']['approved']['users'] as $key => $user) {
				echo ' - '.$user;
			}?>">
				<?php echo $communication['MessagesApprovals']['approved']['cant'] ?>
			</span> Aprobado
			<span class="badge badge-danger apr-rej" data-rel="tooltip" data-original-title="<?php foreach ($communication['MessagesApprovals']['rejected']['users'] as $key => $user) {
				echo ' - '.$user;
			}?>">
				<?php echo $communication['MessagesApprovals']['rejected']['cant'] ?>
			</span> Rechazado
			<span class="badge badge-warning apr-mod" data-rel="tooltip" data-original-title="<?php foreach ($communication['MessagesApprovals']['modified']['users'] as $key => $user) {
				echo ' - '.$user;
			}?>">
				<?php echo $communication['MessagesApprovals']['modified']['cant'] ?>
			</span> Modificar
			<span class="badge apr-none">
				<?php echo $communication['MessagesApprovals']['none']['cant'] ?>
			</span> Sin Responder	
			<?php } ?>
<?php //if($user_locked != true){ ?>

		<?php //if (in_array($this->Session->read('UserAuth.User.id'), $communication['Tokens']) && !$isTrash) {?>
			<div class="inline position-relative" >
				<a id="opcCommunications" href="#" data-toggle="dropdown" class="dropdown-toggle">
					Opciones &nbsp;
					<i class="icon-caret-down bigger-125"></i>
				</a>
				
				<ul class="dropdown-menu dropdown-lighter pull-right dropdown-100">
					<li>
						<a href="<?php echo $communication['Communication']['id'];?>.pdf" id="">
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
					<?php if($file_locked != true){ ?>
					<li>
						<a href="<?php echo $this->webroot.'communications/forward/'.$communication['Communication']['id']; ?>">
							<i class="icon-mail-forward blue icon-only bigger-130"></i> Reenviar
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<a href="" id="cancelReplyCommunication" class="hide">
				Cancelar envío
			</a>
		<?php //} ?>
		<?php //} ?>
		</span>
	</div>

	<?php foreach ($communication['Messages'] as $key => $message) { 
		//debug($message);

		?>
	
	<div class="timeline-items">
		<div class="timeline-item clearfix">
		<?php if ($message['Message']['forward'] == 1 && $history == false){?>
			<div style= "color: #2679b5;margin-left: 5%;">
				<h4>
					Mensajes previos al reenvio:
				</h4>
			</div>
		<?php $history = true; }?>

			<div class="timeline-info pretty-date-date" data-date="<?php echo $message['Message']['created'] ?>">
				<div class="timeline-info-date">
					<span class="day"></span>
					<span class="month"></span>
					<span class="year"></span>
				</div>
			</div>
			<div class="widget-box transparent  <?php if ($message['approve'] == '-1') echo 'border-reject'?> <?php if ($message['approve'] == '1') echo 'border-approve'?> <?php if ($message['approve'] == '2') echo 'border-modify'?>">
				<div class="widget-header widget-header-small">
					<h5 class="smaller">
						<span class="grey"><strong>De </strong>
							<span data-rel="tooltip" data-placement="top" title="" data-original-title="<?php echo $message['EntitySender']['name'].' - '.$message['UserSender']['position'] ;?>">
							<?php  echo $message['UserSender']['first_name'].' '.$message['UserSender']['last_name'] ?>
							</span>
						</span>
					</h5>
					<h5 class="smaller" style="margin:0px;">
						<span class="grey"><strong>Para </strong>

							<?php 
							$llaves = array_keys($groupAll[$message['Message']['id']]);
							$hasCC = false;
							$contador = 0;
							foreach ($llaves as $ky => $ve) {
								foreach ($groupAll[$message['Message']['id']][$ve] as $ke => $va) {
									$inside[$ve][$contador] = $va['Trace']['receive_user_id'];
									$contador ++;
								}
							}

										//debug($groupAll[$message['Message']['id']]);

							foreach ($groupAll[$message['Message']['id']] as $keyx => $valuex) {
									foreach ($message['UserReceivers'] as $key => $entity) {
									if($keyx == '' && in_array($entity['id'], $inside[$keyx])){
										if ($entity['type_delivery'] == 0) { 
										?>
										<span style="margin-right:2px;" class="label" data-rel="tooltip" data-placement="top" title="" data-original-title="<?php //echo $message['EntitiesReceivers'][$entity['entity_id']]['name'].' - '.$entity['position'];?>"><?php echo $entity['first_name'].' '.$entity['last_name'];?>
											<?php if ($entity['read'] == 1) { ?>
											<span class="pretty-date-date" data-date="<?php echo $entity['read_datatime'] ?>" ><span class="full-date-title" data-placement="bottom" data-rel="tooltip"><i class="icon-ok bigger-120"></i></span></span>
											<?php } else { ?>
											<span data-placement="bottom" data-rel="tooltip" data-original-title="No lo ha leído" ><i class="icon-time bigger-120"></i></span>
											<?php } ?>
										</span>

									<?php }
										else {
											$hasCC = true;
										}
									} 
								}
									if($keyx != ''){?>

									<div class="widget-toolbar no-border" style="float:none;">
				<button class="btn btn-xs bigger dropdown-toggle" style="background-color: #ABBABD!important; border-color: gray;" data-toggle="dropdown">
					<?php echo $keyx;?>
					<i class="ace-icon fa fa-chevron-down icon-on-right"></i>
				</button>
				<ul class="dropdown-menu dropdown-grey lista dropdown-caret dropdown-close disabled">
					<li class="liLista">
								<?php
								foreach ($message['UserReceivers'] as $key => $entity) {
									//debug($entity, $showHtml = null, $showFrom = true);
									if(in_array($entity['id'], $inside[$keyx])){
										if ($entity['type_delivery'] == 0) { 
										?>
											<span style="margin-left:10px;" class="label" data-rel="tooltip" data-placement="top" title="" ><?php echo $entity['first_name'].' '.$entity['last_name'];?>
												<?php if ($entity['read'] == 1) { ?>
												<span class="pretty-date-date" data-date="<?php echo $entity['read_datatime'] ?>" ><span class="full-date-title" data-placement="bottom" data-rel="tooltip"><i class="icon-ok bigger-120"></i></span></span>
												<?php } else { ?>
												<span data-placement="bottom" data-rel="tooltip" data-original-title="No lo ha leído" ><i class="icon-time bigger-120"></i></span>
												<?php } ?>
											</span>
										<?php }
										}
										else {
											$hasCC = true;
										}
								} ?>
					</li>
				</ul>
			</div>

										<?php }
								
							}


							if ($message['Message']['group'] == 'null'){
							
							}
							else{ ?>

<!-- 	<div class="widget-toolbar no-border" style="float:none;">
				<button class="btn btn-xs bigger btn-grey dropdown-toggle" data-toggle="dropdown">
					<?php echo $message['Message']['group'];?>
					<i class="ace-icon fa fa-chevron-down icon-on-right"></i>
				</button>
				<ul class="dropdown-menu dropdown-grey lista dropdown-caret dropdown-close disabled">
					<li class="liLista">
								<?php
								foreach ($message['UserReceivers'] as $key => $entity) {
									//debug($entity, $showHtml = null, $showFrom = true);
									if ($entity['type_delivery'] == 0) { 
									?>
										<span style="margin-left:10px;" class="label" data-rel="tooltip" data-placement="top" title="" ><?php echo $entity['first_name'].' '.$entity['last_name'];?>
											<?php if ($entity['read'] == 1) { ?>
											<span class="pretty-date-date" data-date="<?php echo $entity['read_datatime'] ?>" ><span class="full-date-title" data-placement="bottom" data-rel="tooltip"><i class="icon-ok bigger-120"></i></span></span>
											<?php } else { ?>
											<span data-placement="bottom" data-rel="tooltip" data-original-title="No lo ha leído" ><i class="icon-time bigger-120"></i></span>
											<?php } ?>
										</span>
								<?php }
									else {
										$hasCC = true;
									}
								} ?>
					</li>
				</ul>
			</div> -->

								<?php }
							?>

						</span>
					</h5>
					<?php if ($hasCC) {?>
					<h5 class="smaller" style="margin:0px; margin-top:5px;">
						<span class="grey"><strong>C.C. </strong>
							<?php foreach ($message['UserReceivers'] as $key => $entity) { 
								if ($entity['type_delivery'] == 1) { ?>
								<span style="margin-right:2px;" class="label" data-rel="tooltip" data-placement="top" title="" data-original-title="<?php echo $message['EntitiesReceivers'][$entity['entity_id']]['name'].' - '.$entity['position'];?>"><?php echo $entity['first_name'].' '.$entity['last_name'];?>
									<?php if ($entity['read'] == 1) { ?>
									<span class="pretty-date-date" data-date="<?php echo $entity['read_datatime'] ?>" ><span class="full-date-title" data-placement="bottom" data-rel="tooltip"><i class="icon-ok bigger-120"></i></span></span>
									<?php } else { ?>
									<span data-placement="bottom" data-rel="tooltip" data-original-title="No lo ha leído" ><i class="icon-time bigger-120"></i></span>
									<?php } ?>
								</span>
							<?php } } ?>
						</span>
					</h5>
					<?php } ?>

					<span class="widget-toolbar no-border">
						<i class="icon-time bigger-110"></i>
						<span class="pretty-date-date" data-date="<?php echo $message['Message']['created'] ?>"><span class="hour"></span></span>
					</span>

					<span class="widget-toolbar">
						<a data-action="collapse">
							<i class="icon-chevron-down"></i>
						</a>
					</span>
				</div>

				<div class="widget-body">
					<div class="widget-body-inner" style="">
						<div class="widget-main" style="padding:2px;" >
							<div style="background-color:#ffffff; padding:5px;">
							<?php echo $message['Message']['content'] ?>
							</div>
							<div class="space-6"></div>
							<div class="hr hr-double"></div>
							<?php if (!empty($message['Uploads'])) {?>
							<div class="widget-toolbox clearfix">
								<div class="attachment-title">
									<span class="blue bolder bigger-110">Adjuntos</span>
								</div>
								<ul class="attachment-list pull-left list-unstyled">
								<?php foreach ($message['Uploads'] as $key => $upload) { ?>
									<li>
											<span class="attached-name middle"><?php echo $upload['Upload']['real_name'] ?></span>
																				
									</li>
								<?php } ?>
								</ul>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php if ($message['approve'] != '0') ?>
					<div class="text-center white <?php if ($message['approve'] == '-1') echo 'label-reject'?> <?php if ($message['approve'] == '1') echo 'label-approve'?> <?php if ($message['approve'] == '2') echo 'label-modify'?>">
						<strong>
						<?php if ($message['approve'] == '1') echo 'Aprobado'?> 
						<?php if ($message['approve'] == '-1') echo 'Rechazado'?>
						<?php if ($message['approve'] == '2') echo 'Modificar'?>
						</strong>
					</div>
					<?php ?>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<script type="text/javascript">
	
	</script>
	<div class="modal fade" id="modalConfirmDownload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">Confirmar descarga de archivo</h4>
	      		</div>
	      		<div class="modal-body" style="text-align:justify;">
	        		Al descargar este archivo quedar&aacute; bloqueado para el resto de los participantes en la comunicaci&oacute;n hasta que usted lo suba nuevamente
	        		o luego de transcurridas 2 horas a partir de este momento, si no se ha subido el archivo, se desbloqueará auntomáticamente.
	        		&iquest;Desea continuar?
	        		<span style="display:none;" id="idUser"><?php echo $this->Session->read('UserAuth.User.id') ?></span> 
	      		</div>
	      		<div class="modal-footer">
		        	<button type="button" class="btn btn-primary" id="btn-download-confirm">Aceptar</button>
		        	<button type="button" class="btn btn-default" id="btn-download-cancel">Cancelar</button>
	      		</div>
	    	</div>
	  	</div>
	</div>

	<div class="modal fade" id="modalCustomMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">Atenci&oacute;n</h4>
	      		</div>
	      		<div class="modal-body" style="text-align:justify;">
	        		Insert text here... 
	      		</div>
	      		<div class="modal-footer">
		        	<button type="button" class="btn btn-primary" id="btn-custom-acept">Aceptar</button>
	      		</div>
	    	</div>
	  	</div>
	</div>
	<div class="modal fade" id="modalPreviewFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-dialog" style="width: 660px;">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel"></h4>
	      		</div>
	      		<div class="modal-body" style="text-align:justify;">
	      			<a id="linkFileModal" href="" style="display:none;"></a>
	      			<div class="block_fill" style="height: 30px;width: 35px;position: relative;z-index: 10000;background: #f5f5f5;left: 565px;top: -704px;"></div>
	      		</div>
	      		<div class="modal-footer" style="margin-top: 0px;">
		        	<button type="button" class="btn btn-primary" id="btn-custom-cerrar" data-dismiss="modal">Cerrar</button>
	      		</div>
	    	</div>
	  	</div>
	</div>
</div>
<script>
//javascript:window.print();
//javascript:window.close();

	</script>
	