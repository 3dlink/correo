<?php //debug($communications, $showHtml = null, $showFrom = true);

$actions = array('','','Aprobación', 'Devolver con observaciones', 'Dar respuesta', 'Confirmar asistencia', 'Informativo' , 'Requiere Firma Electrónica');
$draft = 0;
if (isset($_GET['draft'])){
	$draft = 1;
}
?>
<style type="text/css">
	.expires{
		background-color: rgb(255, 152, 152); 
	}

	.normal{
		background-color: white;	
	}

	.almost{
		background-color: rgb(255, 245, 129);

	}
</style>
<div class="page-header" id="pisame">
	<h1>
		Comunicaciones 
		<?php if (isset($_GET['nrm'])){ ?>
			no respondidas
		<?php } ?>
		<small>
			<i class="icon-double-angle-right"></i>
			<?php if (isset($_GET['nrm'])){ ?>
			listado de comunicaciones enviadas que no han sido respondidas
		<?php } else { ?>
			listado de comunicaciones en la que estoy participando
		<?php } ?>
		</small>
		<span class="pull-right pop-help">
			<span class="btn  btn-sm tooltip-warning" data-rel="popover" data-placement="bottom" data-content="- El ícono &lt;i class='icon-certificate orange2'&gt;&lt;/i&gt; indica que esa comunicación no ha sido leída o que contiene una respuesta que no ha sido leída.<br><br>- El ícono &lt;i class='icon-bookmark green'&gt;&lt;/i&gt; indica que la comunicación ha sido leída por algún destinatario.<br><br>- El ícono &lt;span class='badge badge-important mail-tag'&gt;&lt;/span&gt; indica que la comunicación esta por responder." data-original-title="Indicadores"><i class="icon-question-sign bigger-120"></i></span>
		</span>
	</h1>
</div>

<div class="col-xs-12">
	<div class="message-container">
		<div id="id-message-list-navbar" class="message-navbar align-center clearfix">
			<div class="message-bar">
				<div class="message-infobar" id="id-message-infobar">
					<span class="blue bigger-150">&nbsp;</span>
				</div>
			</div>
			<div>
				<div class="messagebar-item-left">
					<label class="inline middle">
						<input type="checkbox" id="select-all-communications" class="ace">
						<span class="lbl"></span>
					</label>
				</div>
				<div class="nav-search minimized">
					<?php
						$env = '';
						$url = $this->webroot.'communications/';
						if (isset($_GET['sent'])) {
							$env = 'sent';
						}
						if (isset($_GET['trash'])) {
							$env = 'trash';
						}
						if (isset($_GET['draft'])) {
							$env = 'draft';
						}
					?>
					<form id="form-search" class="form-search" action="<?php echo $url;?>" data-enviroment="<?php echo $env;?>">
						<span class="input-icon" >
							<input id="search-communications" name="query" type="text" autocomplete="off" class="nav-search-input" style="width:300px;"  placeholder="Buscar..." />
							<i class="icon-search nav-search-icon"></i>
						</span>
					</form>
				</div>
						<span id="help-find-text" class="hide" style="position:absolute;z-index:1030;top:29px;left:60px;color: #114157;font-size: 10px;">Ingrese el nombre de la persona, entidad, tag, categoría, tipo de corespondencia, acción de la correspondencia o parte del contenido de la correspondencia que desea buscar</span>
				<div class="messagebar-item-right">
					<div class="inline position-relative">
						<?php if ($env == 'sent') {?> 
						<span class="" id="" style="" title="No respondidas">
							<a href="<?php echo $this->webroot.'communications/?nrm=1'?>">No respondidas</a>
						</span>
						<?php }?> 
						<span class="btn btn-danger btn-xs set-trash-communications" data-trash="delete" id="btn-delete-communications" style="display:none;" title="Eliminar comunicaciones">
							<i class="icon-trash bigger-125"></i>
						</span>
						<span class="btn btn-success btn-xs set-trash-communications" data-trash="restore" id="btn-restore-communications" style="display:none;" title="Restaurar comunicaciones">
							<i class="icon-refresh bigger-125"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="message-list-container">
			<div class="message-list" id="message-list" data-communication-draft="<?php echo $draft; ?>"> 
				<?php 
				$today = date('Y-m-d H:i:s');
				foreach ($communications as $row) { ?>
				<?php //echo $this->SignedCommunication->findSigned($row['Communication']['id']);?>
				<?php 
					$day = explode("-",date('Y-m-d'));
					$date= explode("-",$row['Communication']['expires']);
					$style="normal";
						if($row['Communication']['expires'] && $row['Communication']['is_update'] == false){
						//calculo timestam de las dos fechas 
						$timestamp1 = mktime(0,0,0,$day[1],$day[2],$day[0]); 
						$timestamp2 = mktime(4,12,0,$date[1],$date[2],$date[0]); 
						//resto a una fecha la otra 
						$segundos_diferencia = $timestamp1 - $timestamp2; 
						//echo $segundos_diferencia; 
						//convierto segundos en días 
						$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
						//obtengo el valor absoulto de los días (quito el posible signo negativo) 
						$dias_diferencia = $dias_diferencia-1;
							if($dias_diferencia >= 0){
								$style = "expires";
							}
							elseif ($dias_diferencia <=1 && $dias_diferencia >= -3) {
								$style = "almost";
							}
						}
				?> 
				<div class="message-item <?php echo $style; ?> <?php if ($row['Communication']['read'] == false)  echo 'message-unread';?>" data-communication-id="<?php echo $row['Communication']['id'] ?>">
					<label class="inline">
						<input type="checkbox" class="ace check-communication">
						<span class="lbl"></span>
					</label>
					
					<?php if($this->Signed->signed($row['Communication']['id']) > 0){?>
						<i class="message-star c-interaction" title="Comunicacion Certificada" ><img src="<?php echo $this->webroot;?>img/award.png" alt="Certificar" height="21" width="21"></i>	
					<?php }?>
					<?php if ($row['Communication']['read'] == false)  {?>
					<i class="message-star icon-certificate orange2 c-interaction" title="Nueva Comunicación"></i>
					<?php } else if ($row['Communication']['is_update']) {?>
					<i class="message-star icon-bookmark green n-green c-interaction" title="Nueva Interacción"></i>
					<?php } else {?>
					<i class="message-star icon-bookmark green n-green hide c-interaction" title="Nueva Interacción"></i>
					<span class="c-no-interaction" style="width:23px; display:inline-block;">&nbsp;</span>
					<?php } ?>
					<span class="sender view-cmt" title="<?php echo $row['SenderEntity']['name'] ?>"><small><?php echo $row['SenderEntity']['name'] ?></small></span>

					<span class="summary view-cmt">
							<?php
							if($row['Communication']['expires'] && $row['Communication']['is_update'] == false){ ?>
								<i class="icon-time bigger-110" title="<?php echo 'Responder antes del: '.$row['Communication']['expires'];?>"></i>
						<?php }	?>

						<?php if (!isset($_GET['draft']) && !isset($_GET['sent']) && !isset($_GET['trash']) && !isset($_GET['nrm']) && !isset($_GET['vtn']) && !isset($_GET['ccn']) && !isset($_GET['tn']) && $row['CommunicationToken']['user_id'] != null ) { ?>

						<span class="badge badge-important mail-tag" title="Por Responder"></span>
						<?php } ?>

						<span class="text">
							<?php echo $row['Message']['title'] ?>
						</span>
					
					</span>
					<span class="times pull-right pretty-date-date" data-date="<?php echo $row['Trace']['created'] ?>">
						<span class="email-date"></span>
					</span>
					<?php if (isset($row['Communication']['hasAttachments']) && $row['Communication']['hasAttachments'] > 0) {?>
					<span class="pull-right">
						&nbsp;<i class="icon-paper-clip"></i>&nbsp;
					</span>
					<?php } ?>

					<?php if (isset($row['CommunicationType'])) {?>
						<span class="label label-success pull-right tag-communication" style="margin: 0 2px;">
							<a href="<?php echo $this->webroot.'communications/index/?ctn='.$row['CommunicationType']['name'].'&cti='.$row['CommunicationType']['id']; ?>"><?php echo $row['CommunicationType']['name'] ?></a>
						</span>
					<?php } ?>
					<?php if (isset($row['CommunicationCategory'])) {?>
						<span class="label label-info pull-right tag-communication" style="margin: 0 2px;">
							<a href="<?php echo $this->webroot.'communications/index/?ccn='.$row['CommunicationCategory']['name'].'&cci='.$row['CommunicationCategory']['id']; ?>"><?php echo $row['CommunicationCategory']['name'] ?></a>
						</span>
					<?php } ?>
					<?php 
						$maxTags = 3;
						$canTag = 0;
						foreach ($row['Tag'] as $key => $tag) { 
							if ($tag['Tag']['user_id'] == $this->Session->read('UserAuth.User.id')) { 
								$canTag++;
						?>

						<span class="label label-warning pull-right tag-communication" style="margin: 0 2px;">
							<a href="<?php echo $this->webroot.'communications/index/?tn='.$tag['Tag']['name'].'&ti='.$tag['Tag']['id']; ?>"><?php echo $tag['Tag']['name'] ?></a>
						</span>
						<?php } 
						if ($canTag >= $maxTags) break;
						?>
					<?php } ?>
					<div>
						<span class="label label-danger pull-right" style="margin: 0 60px 0 0;"><?php echo $actions[$row['Communication']['action_id']]; ?></span>
						<?php /*if (!isset($_GET['draft']) && !isset($_GET['sent']) && !isset($_GET['trash']) && !isset($_GET['nrm']) && !isset($_GET['vtn']) && !isset($_GET['ccn']) && !isset($_GET['tn'])) { ?>
						<span class=" pull-left text-danger" style="margin: 0 0 0 50px;"><?php if ($row['CommunicationToken']['user_id'] != null) echo 'Por responder'; ?></span> 
						<?php } */?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="message-footer clearfix">
			<div class="pull-left">
				Viendo <?php echo $pagination['page_init'] ?> - <?php echo $pagination['page_end'] ?> de <?php echo $pagination['total'] ?> comunicaciones
			</div>
			<div class="pull-right">
				&nbsp; &nbsp;
				<ul class="pagination">
					<li class="prev <?php if($pagination['previous'] == false) echo 'disabled'; ?>">
						<?php if($pagination['previous'] == true) {
							$p = $pagination['previous_page']?>
							<a href="<?php echo $this->webroot.'communications/index/'.$p.'?'.$pagination['params'] ?>">
							<i class="icon-caret-left bigger-140 middle"></i>
							</a>
						<?php }  else {?>
							<span><i class="icon-caret-left bigger-140 middle"></i></span>
						<?php } ?>
					</li>

					<li class="next <?php if($pagination['next'] == false) echo 'disabled'; ?>">
						<?php if($pagination['next'] == true) {
						$n = $pagination['next_page']; ?>
						<a href="<?php echo $this->webroot.'communications/index/'.$n.'?'.$pagination['params'] ?>"><i class="icon-caret-right bigger-140 middle"></i></a>
					<?php }  else {?>
						<span><i class="icon-caret-right bigger-140 middle"></i></span>
					<?php } ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

