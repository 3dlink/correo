<script type="text/javascript">
$( document ).ready(function() {
	$(".verificar").click(function() {
		 var doc = $(this).attr('value');
		 var nro = $("#correlative").val();
		 message('Mensaje', 'En segundos el sistema generar&aacute; un pdf con la auditor&iacute;a de este archivo. ');
		 //doc = doc.replace("#","%23"); 
		 //console.log(doc);
		 //$(this).attr('style','display: inline-block; pointer-events: none;'); 
		 //$(".pdf").html("consultando firma..."); 
		 http://localhost/correspondencia/communications/verificarfirma?id 
		     //document.location = WEBROOT+"communications/verificarfirma?id="+doc+"&correlative="+nro;
		     $( ".verificar" ).css(  'pointer-events', 'none' );
		 
	
		$.ajax({type: "POST", 
			url: WEBROOT+"communications/verificarfirma?id="+doc+"&correlative="+nro,
	       	//data: ({id: doc}),
            cache: false,
            dataType: "text",
            success: function(data) {
                if(data == 'Error del servidor'){
                    m_error(data);
                    $( ".verificar" ).css(  'pointer-events', 'all' );
                }
                else{
                $( ".verificar" ).css(  'pointer-events', 'all' );
             
                //window.open("data:application/pdf;base64," + data);
                $('#smallModal').modal('show');
                $('.gdocsviewer').remove();
                $('a.embed').attr({target: '_blank','href' :  data});
                $('a.embed').gdocsViewer({ width: 560 });
                }
            }       
              });
	});

	//$('a.embed').gdocsViewer();
	
	//$('#embedURL').gdocsViewer();
});
</script>
<?php
function randomStr($length) {
	$str = '';
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	$size = strlen ( $chars );
	for($i = 0; $i < $length; $i ++) {
		$str .= $chars [rand ( 0, $size - 1 )];
	}

	return $str;
}
function forwardDocument($file){
$archivo = '/var/repo/'.$file;




	   $time = strtotime ( "now" );


		$fileParts = pathinfo ($file);
		
			$name = "file" . $time . randomStr ( 3 );
			

			$namepath = $name . "." . $fileParts ['extension'];
			
	

$nuevo_archivo = '/var/repo/'.$namepath;

if (!copy($archivo, $nuevo_archivo)) {
	return "Error al copiar $archivo...\n";
}

return $namepath;
}
echo "<table class='padre'>";
foreach ($communication['Messages'] as $key => $message) { 
foreach ($message['Uploads'] as $key => $upload) {

	$id_file= $upload['Upload']['message_id'];
	$file_name =  $upload['Upload']['real_name'];
	$name_user=$communication['Messages'][$id_file]['UserSender']['first_name']." ".$communication['Messages'][$id_file]['UserSender']['last_name'];
	$last_user_id = $upload['Upload']['last_user_id'];
	$locked = $upload['Upload']['locked'];
	
	$name_file = forwardDocument($upload['Upload']['name']);
	
	$id_archivo = $this->Forward->upload($file_name,$name_file);
	
		echo '<tr class="archivos template-download fade in" data-file-id="'.$id_archivo.'" style="height: 33px;">
		        
		            <td class="preview"></td>
		            <td class="name">
		                <a href="http://localhost/correspondencia/webroot/files/'.$name_file.'" title="" rel="" download="git.pdf" data-original-title="git.pdf"><i class="icon-file">&nbsp;&nbsp;</i>'.$file_name.'</a>
		            </td>
		            <td class="size" style="width:65px"><span>&nbsp;&nbsp;<small>'.filesize("../webroot/files/".$name_file).'KB</small></span></td>
		            <td colspan="2"></td>
		        
		        <td class="delete">
		            <button class="btn btn-whites btn-prueba" data-type="DELETE" data-url="'.$this->webroot.'/file_upload/handler?file='.$name_file.'">
		                <i class="icon-trash red bigger-130 middle"></i>
		                <span class="hide">Delete</span>
		            </button>
		            <input class="hide" type="checkbox" name="delete" value="1">
		        </td>';
				echo '<td>';
		 if($this->Signed->signedDocument($upload['Upload']['name']) > 0){
												echo 	'<a data-toggle="modal" data-target="" class="verificar" onclick="" style="margin-top: 4px;position: absolute; cursor: pointer;" title="Verificar Firma" value="'
														.$upload['Upload']['name'].'">';
												
												echo '<img src="'.$this->webroot.'img/award.png" style="height: 25px;" alt="Certificar" height="20" width="20" class="icon-firma-electronica">';
												echo '	</a>';
												 }
					echo "</td>";
		
				
		   echo  '</tr>';

}
}
echo "</table>";
?>
<script type="text/javascript">


$(window).load(function(){ 
    
    //$(".files").append('<div class="padre"><div class="milku">asdasdasdas</div></div>');
    var a = $(".padre .archivos").clone(true);
    $.each($('.padre tr'), function(index, file) {
		var idFile = $(file).attr('data-file-id');
		$.ajax({
  			url: WEBROOT + 'Communications/updateTemporal/',
  			type: 'post',
  			data: { idFile: idFile, temporal: $("#txtIdMessage").val() },
  			success: function(data){
  				
  			}, 
  		
		});
		console.log(idFile);
	});
    //console.log($("#txtIdMessage").val());
    $(".padre").html("");
    $(".files").html(a);
    
});

</script>
<style type="text/css">
			.icon-chevron-down, .icon-chevron-up{
				cursor: pointer;
			}
		</style>
<?php echo $this->Session->flash(); 
$countHistory = 0;
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
<div class="row">
	
	<div class="col-xs-12">
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>
			<div class="col-sm-11">
				&nbsp;
				<div id="content-receivers">

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
		<div class="form-group hide" id="content-tags-receivers-cc">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>
			<div class="col-sm-11">
				&nbsp;
				<div id="content-receivers-cc"></div>
			</div>
		<br>
		<br>
		</div>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> C.C. </label>
			<div class="col-sm-11">
				<input style="margin-top:5px;" type="text" id="cc" placeholder="agregar persona o entidad" class="col-xs-10 col-sm-10" data-items="4">
				<span class="input-group-btn">
					<button id="btnShowModalCategoryCC" class="btn btn-sm btn-default" type="button" title="Búsqueda avanzada">
						<i class="icon-search bigger-110"></i>
					</button>
				</span>
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> N° </label>
			<div class="col-sm-11">
				<input type="text" id="message-correlative" placeholder="N° de Correspondecia" class="col-xs-10 col-sm-10" required>
			</div>
		</div>
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Asunto </label>
			<div class="col-sm-11">
				<input type="text" id="message-title" placeholder="asunto" class="col-xs-10 col-sm-10" value="<?php echo $message2['title'] ?>">
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
					<option value="<?php echo $communicationType['CommunicationType']['id'] ?>"><?php echo $communicationType['CommunicationType']['name'];?></option>
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
				</select>
			</div>
			<div class="col-xs-5">
				<div class="pull-right">
					<button id="btn-add-format" class="btn btn-grey btn-xs hide" title="Formatos">
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
				<div id="contentTags"></div>
			</div>
		</div>
		<br><br>
		<div class="form-group">
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
		
		<br><br>
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> &nbsp; </label>
			<div class="col-sm-10">
				<div class="wysiwyg-editor" id="message-content">
				<!-- <table border="1">
					<tr><td  colspan='10'><p>--Mensaje Anterior</p></td></tr>
					
					<?php 
					//var_dump($communication);
					$message_content = reset($communication['Messages']);
					//var_dump($message_content);
					echo "<tr><td>Usuario </td><td>".$message_content['UserSender']['username']."</td></tr>";
					echo "<tr><td style='vertical-align: top;'>Mensaje </td><td  style='width: 100%; vertical-align: top;'>". $message_content['Message']['content']."</td></tr>";
					//echo $message_content['approve'];
					if ($message_content['approve'] == '-2') {
						echo "<tr><td>Estatus </td><td> Sin Responder</td><tr>";
					}
					if ($message_content['approve'] == '-1') {
						echo "<tr><td>Estatus </td><td> <div class='text-center white  label-reject'><strong>Rechazado</div></td><tr>";
					}
					if ($message_content['approve'] == 1) {
						echo "<tr><td>Estatus </td><td> <div class='text-center white  label-approve'><strong>Aprobado</div></td><tr>";
					}
					if ($message_content['approve'] == 2) {
						echo "<tr><td>Estatus </td><td> <div class='text-center white  label-modify'><strong>Modificar</div></td><tr>";
					}
					
					?>
					
					</table> -->
			
				</div>
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
								<input name="message-action" type="radio" class="ace" value="2">
								<span class="lbl"> Aprobación</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="3">
								<span class="lbl"> Devolver con observaciones</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="7">
								<span class="lbl"> Require Firma Electronica</span>
							</label>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="4">
								<span class="lbl"> Dar respuesta</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="5">
								<span class="lbl"> Confirmar Asistencia</span>
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="message-action" type="radio" class="ace" value="6">
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
	<?php foreach ($communication['Messages'] as $key => $message) {
		$countHistory++; 
		?>
		<div>
			<input style="display:none;" class="HistoryMessage" id="M<?php echo $countHistory;?>" value="<?php echo $message['Message']['id']?>">
		</div>
	<div class="timeline-items">
		<div class="timeline-item clearfix">
			<div class="timeline-info pretty-date-date" data-date="<?php echo $message['Message']['created'] ?>">
				<div class="timeline-info-date">
					<span class="day"></span>
					<span class="month"></span>
					<span class="year"></span>
				</div>
			</div>
			<div class="widget-box transparent collapsed <?php if ($message['approve'] == '-1') echo 'border-reject'?> <?php if ($message['approve'] == '1') echo 'border-approve'?> <?php if ($message['approve'] == '2') echo 'border-modify'?>">
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
							$hasCC = false;
							foreach ($message['UserReceivers'] as $key => $entity) {
								//debug($entity, $showHtml = null, $showFrom = true);
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
							} ?>
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
					<div class="widget-body-inner" style="display: none;">
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
								<ul class=" pull-left list-unstyled">
								<?php foreach ($message['Uploads'] as $key => $upload) { ?>
									<li>
										<a class="<?php if($upload['Upload']['signature'] == 1){ 
															if($upload['Upload']['locked'] == 0 || $upload['Upload']['last_user_id'] == $this->Session->read('UserAuth.User.id')){
																echo 'file';
															} else {
																echo 'linkFile';
															}
														}  ?> attached-file inline" 
											target="_blank" 
											href="<?php echo $this->webroot.'communications/showfile/'.$upload['Upload']['name']; //$upload['Upload']['url']; ?>" 
											title="<?php echo $upload['Upload']['real_name'] ?>" 
											data-file-id="<?php echo $upload['Upload']['id'] ?>">
											<i class="icon-file-alt bigger-110 middle"></i>
											<span class="attached-name middle"><?php echo $upload['Upload']['real_name'] ?></span>
										</a>

										<div class="action-buttons inline">
											<?php //echo $this->Html->link('<i class="icon-download-alt bigger-125 blue"></i>', array('controller' => 'communications', 'action'=>'download', $upload['Upload']['name']));
											?>
											<a class="<?php if($upload['Upload']['signature'] == 1){echo 'file';} ?>" 
												href="<?php 
													$paramFile = '';
													if($upload['Upload']['signature'] == 1){ 
														if($upload['Upload']['locked'] == 1 && $upload['Upload']['last_user_id'] != $this->Session->read('UserAuth.User.id')){
															$paramFile = $upload['Upload']['id'].'/'.$upload['Upload']['token'];
														} 
													}
													echo $this->webroot.'communications/download/'.$upload['Upload']['name'].'/'.$paramFile;?>"
												title="Descargar" 
												target="_blank" 
												data-file-id="<?php echo $upload['Upload']['id'] ?>"
											>
												<i class="icon-download-alt bigger-125 blue"></i>
											</a>
										</div>
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
<div class="row">
	<div class="col-xs-12">
		<button id="btn-send-message" class="btn btn-info pull-right " type="button" data-message-id="<?php echo $message2['id'] ?>">
			<i class="icon-ok bigger-110"></i>
			Enviar
		</button> 
		<?php if($this->Session->read('UserAuth.User.signed') == 1 ){?>
		<div class="signing-file" style="width:88%; display:inline-block; text-align: right;">
	    	<span class="btn-file-sign1 btn btn-info" style="margin-right: 0px;">
	        	<img src="<?php echo $this->webroot;?>img/Award_ribbon_cup.png" alt="Certificar" height="18" width="18">
	        
	            <span>Firmar Electr&oacute;nicamente y Enviar</span>
	        </span>
	    </div>
	    	<?php }?>
		<span style="width:5px;" class="pull-right">&nbsp;</span>
		
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
		        <h4 class="modal-title" id="myModalLabel">Búsqueda avanzada</h4>
	      	</div>
      		<div class="modal-body">
        		Cargando directorio ...
      		</div>
    	</div>
  	</div>
</div>

									<div class="modal fade" id="smallModal" tabindex="-1" role="dialog"
		aria-labelledby="smallModal" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content" style="">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Auditor&iacute;a de Firma</h4>
				</div>
				<div class="modal-body pdf" style="padding: 10px;">
					 <a href="" style="margin-left : 40%;" class="embed">Descargar</a>
				
				</div>
				<div class="modal-footer"
					style="margin-top: 0px; background: white; display: none;">
					<div style="display: inline-block;">Validado por:</div>
					<div style="display: inline-block;"><?php echo $this->Html->image('CEE.png', array('style' => 'max-width:100px; border: 0px solid #AAA; padding: 0px;background-color:none;')); ?></div>
					<div></div>
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
