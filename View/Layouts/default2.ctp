<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Correspondencia Estatal');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
	<?php
		echo $this->Html->meta('icon');

		//CSS
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('ace.min');
		echo $this->Html->css('ace-rtl');
		echo $this->Html->css('ace-skins');
		echo $this->Html->css('jquery.gritter');
		//echo $this->Html->css('main');
		echo $this->Html->css(array('main'));
		echo $this->Html->css('datepicker');


		echo $this->Html->script('lib/jquery-2.0.3.min');
		//echo '<script type="text/javascript" src="/correspondencia/js/jquery.gdocs.js"></script>';
		echo $this->Html->script('lib/bootstrap.min');
		echo $this->Html->script('lib/ace-extra.min');
		echo $this->Html->script('lib/typeahead-bs2.min');
		echo $this->Html->script('lib/ace-elements.min');
		echo $this->Html->script('lib/ace.min');
		echo $this->Html->script('lib/jquery.nestable.min');
		echo $this->Html->script('lib/jquery.gritter.min');
		echo $this->Html->script('lib/jquery.session');
		echo $this->Html->script('lib/bootbox.min');
		echo $this->Html->script('lib/markdown/markdown.min');
		echo $this->Html->script('lib/markdown/bootstrap-markdown.min'); 
		echo $this->Html->script('lib/bootstrap-wysiwyg.min');
		echo $this->Html->script('lib/bootstrap-tag');
		echo $this->Html->script('lib/jquery.hotkeys.min');
		echo $this->Html->script('lib/jquery.gdocsviewer');
		
		echo $this->fetch('script');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		//echo $this->fetch('script');
		$today = date('Y-m-d H:i:s');

		$liActive = '';
		// control del active 
		if (($this->params['controller'] == 'communications') && ($this->params['action'] == 'index')){
			$liActive = 'bandeja';
			if (isset($this->params->query) && isset($this->params->query['tn'])) $liActive = 'etiquetas';
			else if (isset($this->params->query) && isset($this->params->query['ccn'])) $liActive = 'etiquetas';
			else if (isset($this->params->query) && isset($this->params->query['ctn'])) $liActive = 'etiquetas';
			else if (isset($this->params->query) && isset($this->params->query['draft'])) $liActive = 'borradores';
			else if (isset($this->params->query) && isset($this->params->query['trash'])) $liActive = 'papelera';
			else if (isset($this->params->query) && isset($this->params->query['sent'])) $liActive = 'enviados';
		}
		else if (($this->params['controller'] == 'users') && ($this->params['action'] == 'directory')) $liActive = 'directorio';
		else if (($this->params['controller'] == 'communications') && ($this->params['action'] == 'add')) $liActive = 'nueva_comunicacion';
		else if (($this->params['controller'] == 'users') && ($this->params['action'] == 'myprofile')) $liActive = 'perfil';
		else if (($this->params['controller'] == 'users') && ($this->params['action'] == 'changePassword')) $liActive = 'perfil';
		else if (($this->params['controller'] == 'redirections') && ($this->params['action'] == 'index')) $liActive = 'perfil';
		else if (($this->params['controller'] == 'tags') && ($this->params['action'] == 'index')) $liActive = 'etiquetas';
		else if (($this->params['controller'] == 'user_group_permissions') && ($this->params['action'] == 'index')) $liActive = 'permisos';
		else if (($this->params['controller'] == 'entities')) $liActive = 'entidades';
		else if (($this->params['controller'] == 'communicationCategories') || ($this->params['controller'] == 'communicationTypes') || ($this->params['controller'] == 'formats')) $liActive = 'comunicaciones';
		else if (($this->params['controller'] == 'user_groups')) $liActive = 'roles';
		else if (($this->params['controller'] == 'groups')) $liActive = 'grupos';
		else if (($this->params['controller'] == 'users') && ($this->params['action'] == 'dashboard')) $liActive = 'dashboard';
		else if (($this->params['controller'] == 'users')) $liActive = 'usuarios';
		else if (($this->params['controller'] == 'circles')) $liActive = 'circulos';

	?>
</head>

<body data-controller="<?php echo $this->params['controller'];?>" data-action="<?php echo $this->params['action'];?>" data-user-id="<?php echo $this->Session->read('UserAuth.User.id');?>" data-user-group-id="<?php echo $this->Session->read('UserAuth.User.user_group_id');?>" data-user-entity-id="<?php echo $this->Session->read('UserAuth.User.entity_id');?>" data-today="<?php echo $today; ?>" data-user-name="<?php echo $this->Session->read('UserAuth.User.first_name').' '.$this->Session->read('UserAuth.User.last_name');?>">
	<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand" style="padding:0px 20px;">
						<small>
							<?php echo $this->Html->image('logo_correspondencia2.png', array('style' => 'max-width:45px;')); ?>
							<strong>Correspondencia </strong> Estatal Electrónica
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<?php if ( !in_array($this->Session->read('UserAuth.User.user_group_id'), array(1,3))) { ?>

						<li class="green" id="notification-new-communications"></li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1,2,3))) { ?>
						
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span class="user-info">
									<small>Bienvenido,</small>
									<?php echo $this->Session->read('UserAuth.User.first_name');?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="<?php echo $this->webroot.'changePassword'?>">
										<i class="icon-cog"></i>
										Cambiar contraseña
									</a>
								</li>

								<li>
									<a href="<?php echo $this->webroot.'myprofile'?>">
										<i class="icon-user"></i>
										Mi Perfil
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo $this->webroot.'logout'?>">
										<i class="icon-off"></i>
										Salir
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				<table style="width: 100%;">
					<tr>
						<!--<td>
							<!--<img alt="" src="<?php echo $this->webroot;?>img/logo_correspondencia.png" width="200" height="100">-- >
							<img alt="" src="<?php echo $this->webroot;?>img/CEE.png" width="200" height="100">
						</td>-->
						<td style="">
						<?php if ($logo != null) { ?>
							<img alt="" src="https://correspondenciaestatal.gob.pa/files/<?php echo $logo;?>" width="200" height="100">
						<?php }?>
						</td> 
						<!--  
						<td>
							<img alt="" src="<?php echo $this->webroot;?>img/AIG_logo.png" width="200" height="100">
						</td>-->
						<td style="text-align: right;">
							<img alt="" src="https://correspondenciaestatal.gob.pa/img/Gobierno_2014_logo.png" width="200" height="100">
						</td>
					</tr>
				</table>
				<div class="main-content" style="margin-bottom:60px; margin-left: 0px;">

					<div class="page-content" style="min-height:100%;">
						<?php echo $this->fetch('content'); ?>
					</div>
					<?php //echo $this->element('sql_dump'); ?>
				</div>
			</div>
		</div>
	<div class="navbar navbar-footer navbar-default " id="navbar">
		<div class="navbar-container container" id="navbar-container">
			<div class="n-f text-center">Todos los Derechos Reservados por la Autoridad Nacional para la lnnovación Gubernamental 2014.<br> Desarrollado por 3TECH - 3TECH Steps Enterprise </div>
		</div><!-- /.container -->
	</div>
	<?php 
	if ($this->Session->read('UserAuth.User.first_time')) {
		//$idUser = $this->UserAuth->User->id;
		//debug($this->Session->read('UserAuth.User.first_time'), $showHtml = null, $showFrom = true);
	?>
		<div class="modal fade" id="modalChangePassFirstTime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  	<div class="modal-dialog">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h4 class="modal-title" id="myModalLabel">Establecer Contraseña</h4>
		      		</div>
		      		<div class="modal-body">
		      			<div class="form-horizontal">
		      				Es primera vez que ingresas al sistema, por favor establece tu contraseña para poder ingresar
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Contraseña </label>
								<div class="col-sm-9">
									<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Confirmar contraseña </label>
								<div class="col-sm-9 umstyle4">
									<?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
								</div>
							</div>
			      		</div>
		      		</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-primary" id="savePasswordFirstTime">Guardar</button>
			      	</div>
		    	</div>
		  	</div>
		</div>
		<script type="text/javascript">
			$('#modalChangePassFirstTime').modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
		</script>
	<?php
	}
	?>	
</body>
<?php 


	
	echo $this->Html->script(array(
		'root',
		'commons',
		'exec',
		'CE.common', 
		'CE.users', 
		'CE.entities', 
		'CE.redirections', 
		'CE.usergroups',
		'CE.communications.add',
		'CE.communications.index',
		'CE.communications.view',
		'CE.communications.draft',
		'CE.communications.forward',
		'CE.tags',
		'CE.formats',
		'CE.htmls.directory',
		'CE.circles',
		'CE.circles.mycircles'
		));

	echo $this->Html->script('lib/fileupload/vendor/jquery.ui.widget');
	echo $this->Html->script('lib/fileupload/tmpl.min');
	echo $this->Html->script('lib/fileupload/load-image.min');
	echo $this->Html->script('lib/fileupload/canvas-to-blob.min');

	echo $this->Html->script(array('lib/fileupload/jquery.iframe-transport'));
	echo $this->Html->script(array('lib/fileupload/jquery.fileupload'));
	echo $this->Html->script(array('lib/fileupload/jquery.fileupload-fp'));
	echo $this->Html->script(array('lib/fileupload/jquery.fileupload-ui'));
	echo $this->Html->script(array('lib/fileupload/locale'));
	echo $this->Html->script(array('lib/fileupload/main'));
	echo $this->Html->script(array('lib/typeahead'));
	echo $this->Html->script(array('lib/tagmanager'));
	echo $this->Html->script('lib/jquery-ui-1.10.4');

?>
</html>