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
		/*
		//JS
    	
    	//echo $this->Html->script('commons');
    	//echo $this->Html->script('exec');
    	//echo $this->Html->script('CE.common');
    	//echo $this->Html->script('CE.users');
    	//echo $this->Html->script('CE.entities');
    	//echo $this->Html->script('CE.redirections');
    	//echo $this->Html->script('CE.usergroups');

    	echo $this->Minify->script(array('commons'));
    	echo $this->Minify->script(array('exec'));
    	echo $this->Minify->script(array('CE.common'));
    	echo $this->Minify->script(array('CE.users'));
    	echo $this->Minify->script(array('CE.entities'));
    	echo $this->Minify->script(array('CE.redirections'));
    	echo $this->Minify->script(array('CE.usergroups'));
    	echo $this->Minify->script(array('CE.communications.add'));
    	echo $this->Minify->script(array('CE.communications.add'));
    	echo $this->Minify->script(array('CE.communications.view'));
    	echo $this->Minify->script(array('CE.communications.draft'));
    	echo $this->Minify->script(array('CE.tags'));
    	echo $this->Minify->script(array('CE.formats'));
    	echo $this->Minify->script(array('CE.htmls.directory'));

    	echo $this->Minify->script(array('lib/fileupload/jquery.iframe-transport'));
    	echo $this->Minify->script(array('lib/fileupload/jquery.fileupload'));
    	echo $this->Minify->script(array('lib/fileupload/jquery.fileupload-fp'));
    	echo $this->Minify->script(array('lib/fileupload/jquery.fileupload-ui'));
    	echo $this->Minify->script(array('lib/fileupload/locale'));
    	echo $this->Minify->script(array('lib/fileupload/main'));
    	echo $this->Minify->script(array('lib/typeahead'));
    	echo $this->Minify->script(array('lib/tagmanager'));

*/
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
	<div class="navbar navbar-default navbar-header-2" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand" style="padding:0px 20px;">
						<small>
							<?php //echo $this->Html->image('logo_correspondencia2.png', array('style' => 'max-width:45px;')); ?>
							<?php echo $this->Html->image('CEE.png', array('style' => 'max-width:220px;')); ?>
							<!--<strong>Correspondencia </strong> Estatal Electrónica -->
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation" style="margin-top: 49px !important;">
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

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<ul class="nav nav-list">
						
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1,3))) { ?>
						<li class="<?php if($liActive == 'dashboard') echo 'active '?>">
							<a href="<?php echo $this->webroot;?>dashboard/">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> Dashboard </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'nueva_comunicacion') echo 'active '?>">
							<a href="<?php echo $this->webroot.'communications/add' ?>">
								<i class="icon-envelope"></i>
								<span class="menu-text"> Nueva Comunicación </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'bandeja') echo 'active '?>">
							<a href="<?php echo $this->webroot.'communications/' ?>">
								<i class="icon-inbox"></i>
								<span class="menu-text"> Bandeja </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'enviados') echo 'active '?>">
							<a href="<?php echo $this->webroot.'communications/?sent=1' ?>">
								<i class="icon-external-link"></i>
								<span class="menu-text"> Enviados </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'borradores') echo 'active '?>">
							<a href="<?php echo $this->webroot.'communications/?draft=1' ?>">
								<i class="icon-folder-close"></i>
								<span class="menu-text"> Borradores </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'papelera') echo 'active '?>">
							<a href="<?php echo $this->webroot.'communications/?trash=1' ?>">
								<i class="icon-trash"></i>
								<span class="menu-text"> Papelera </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'directorio') echo 'active '?>">
							<a href="<?php echo $this->webroot;?>directory/?tab=e">
								<i class="icon-book"></i>
								<span class="menu-text"> Directorio </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'circulos') echo 'active '?>">
							<a href="#" class="dropdown-toggle">
								<i class="icon-group"></i>
								<span class="menu-text"> Círculos </span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								<li>
									<a href="<?php echo $this->webroot;?>circles">
										<i class="icon-double-angle-right"></i>
										Mis círculos
									</a>
								</li>

								<li>
									<a href="<?php echo $this->webroot;?>circles/myCircles">
										<i class="icon-double-angle-right"></i>
										Círculos a los que pertenezco
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
						<li class="<?php if($liActive == 'etiquetas') echo 'active '?>">
							<a href="#" class="dropdown-toggle">
								<i class="icon-tags"></i>
								<span class="menu-text"> Etiquetas </span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								<?php 
								//debug($tags, $showHtml = null, $showFrom = true);
								$tags = $this->Session->read('tags');
								if (!empty($tags)) { 
									foreach ($tags as $key => $tag) { ?>
									<li data-tag-id="<?php echo $tag['Tag']['id']; ?>">
										<a href="<?php echo $this->webroot.'communications/index?tn='.$tag['Tag']['name'].'&ti='.$tag['Tag']['id']; ?>">
											<i class="icon-double-angle-right"></i>
											<?php echo $tag['Tag']['name']; ?>
										</a>
									</li>
									<?php } ?>
									<li class="view-all-tags">
										<a href="<?php echo $this->webroot.'tags' ?>">
											<i class="icon-double-angle-right"></i>
											<strong>Ver más etiquetas</strong>
										</a>
									</li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1,3))) { ?>

						<li class="<?php if($liActive == 'usuarios') echo 'active '?>">
							<a href="#" class="dropdown-toggle">
								<i class="icon-group"></i>
								<span class="menu-text"> Usuarios </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="<?php echo $this->webroot;?>addUser">
										<i class="icon-double-angle-right"></i>
										Nuevo Usuario
									</a>
								</li>

								<li>
									<a href="<?php echo $this->webroot;?>allUsers">
										<i class="icon-double-angle-right"></i>
										Todos
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1,3))) { ?>
						<li class="<?php if($liActive == 'grupos') echo 'active '?>">
							<a href="<?php echo $this->webroot;?>groups">
								<i class="icon-th-large"></i>
								<span class="menu-text"> Grupos </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1))) { ?>

						<li class="<?php if($liActive == 'roles') echo 'active '?>">
							<a href="#" class="dropdown-toggle">
								<i class="icon-circle-blank"></i>
								<span class="menu-text"> Roles </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="<?php echo $this->webroot;?>addGroup">
										<i class="icon-double-angle-right"></i>
										Nuevo Rol
									</a>
								</li>

								<li>
									<a href="<?php echo $this->webroot;?>allGroups">
										<i class="icon-double-angle-right"></i>
										Todos
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php 
						if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1))) { ?>
						<li class="<?php if($liActive == 'comunicaciones') echo 'active '?>">
							<a href="#" class="dropdown-toggle">
								<i class="icon-folder-open"></i>
								<span class="menu-text"> Comunicaciones </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="<?php echo $this->webroot;?>communicationTypes">
										<i class="icon-double-angle-right"></i>
										Tipo de Correspondencia
									</a>
								</li>
								<li>
									<a href="<?php echo $this->webroot;?>communicationCategories">
										<i class="icon-double-angle-right"></i>
										Categorias
									</a>
								</li>
								
							</ul>
						</li>
						<?php } ?>
						<?php 
						if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1,3))) { ?>
						<li class="<?php if($liActive == 'entidades') echo 'active '?>">
							<a href="<?php echo $this->webroot;?>entities" class="dropdown-toggle">
								<i class="icon-sitemap"></i>
								<span class="menu-text"> Entidades </span>

							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(3))) { ?>
						<li>
							<a href="<?php echo $this->webroot;?>formats">
								<i class="icon-file"></i>
									Formatos
							</a>
						</li>
						<?php }?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1))) { ?>
						<li class="<?php if($liActive == 'permisos') echo 'active '?>">
							<a href="<?php echo $this->webroot;?>permissions">
								<i class="icon-lock"></i>
								<span class="menu-text"> Permisos </span>
							</a>
						</li>
						<?php } ?>
						<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(1,2,3))) { ?>

						<li class="<?php if($liActive == 'perfil') echo 'active '?>">
							<a href="#" class="dropdown-toggle">
								<i class="icon-user"></i>
								<span class="menu-text"> Perfil </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="<?php echo $this->webroot.'myprofile';?>">
										<i class="icon-double-angle-right"></i>
										Mi perfil
									</a>
								</li>

								<li>
									<a href="<?php echo $this->webroot.'changePassword';?>">
										<i class="icon-double-angle-right"></i>
										Cambiar Contraseña
									</a>
								</li>
								<?php if ( in_array($this->Session->read('UserAuth.User.user_group_id'), array(2))) { ?>
								<li>
									<a href="<?php echo $this->webroot.'redirections/index';?>">
										<i class="icon-double-angle-right"></i>
										Redireccionamiento
									</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				<div class="main-content" style="margin-bottom:60px;">

					<div class="page-content" style="min-height:100%;">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php echo $this->Session->flash(); ?>

								<?php echo $this->fetch('content'); ?>
								<!-- PAGE CONTENT ENDS -->
							</div>
						</div>
					</div>
					<?php echo $this->element('sql_dump'); ?>
				</div>
			</div>
		</div>
	<div class="navbar navbar-footer navbar-default " id="navbar">
		<div class="navbar-container container" id="navbar-container">
			<div class="n-f text-center">Todos los Derechos Reservados por la Autoridad Nacional para la lnnovación Gubernamental 2014.<br> <!-- Desarrollado por 3TECH - 3TECH Steps Enterprise  --></div>
		</div><!-- /.container -->
	</div>
	<style>
	.gritter-item-wrapper.gritter-error {
		background: rgba(229,151,41,0.92);
	}
	.navbar-header-2{background: linear-gradient(to right,white, #438eb9);}
	</style>
	<?php 
	// debug($this->Session->read('UserAuth.User.first_time'));
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
									<div class="validateErrorMsj" style="float:inherit;"></div>
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
		'CE.'.$this->params['controller'].'.'.$this->params['action'],
		'CE.communications.add',
		//'CE.communications.index',
		'CE.communications.view',
		//'CE.communications.draft',
		//'CE.communications.forward',
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
