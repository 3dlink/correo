<style type="text/css">

.inputErrorE{
	border: 1px red solid;
}

.error-message{
	width: 100%;
	float:left;
}

.alertE{
	width: 40%;
}

</style>
<?php echo $this->Session->flash(); ?>
<div class="page-header">
	<h1>
		Nuevo Usuario
		<small>
			<i class="icon-double-angle-right"></i>
			Agregar nuevo usuario al sistema
		</small>
	</h1>
</div>
<div class="row">
	<div class="col-xs-12">

		<?php echo $this->Form->create('User', array('action' => 'addUser', 'class' => 'form-horizontal', 'role' => 'form')); ?>
		<input type="hidden" name="script" id="script" value="0">
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Usuario </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("username" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Rol </label> 
			<div class="col-sm-9">
				<?php echo $this->Form->input("user_group_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="selects-entity">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Entidad </label>
				<div class="col-sm-9 ">
					<select name="entity_id" class="col-xs-10 col-sm-5 s-entity">
					<option value="0">Seleccione</option>
					<?php  
						foreach ($entities as $key => $entity) {
						$child = !empty($entity['ChildEntity']);
					?>		
					<option class="opt-entity" value="<?php echo $entity['Entity']['id'] ?>" data-child="<?php echo $child; ?>"><?php echo $entity['Entity']['name'] ?></option>
					<?php 
						}
					?>
					</select>
				</div>
			</div>
			<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Cargo </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("position" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Grupo Estatal</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("group_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Posee Firma</label>
			<div class="col-sm-9">
				<select name="signed" id="signed" class="col-xs-10 col-sm-5" id="UserSigned">
					<option value="">Seleccione</option>
					<option value="0">No Posee</option>
					<option value="1">Si Posee</option>
				</select>
			</div>
		</div>
<!-- 		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Grupo Institucional</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("groupi_id" ,array('type' => 'select', 'options' => $groupsi, 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div> -->

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Nombre(s) </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("first_name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Apellido(s) </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("last_name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Correo electrónico </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Teléfono </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("telephone" ,array('type'=>'text', 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Teléfono Móvil </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("celphone" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Contraseña </label>
			<div class="col-sm-9">

				<?php echo $this->Form->input("password" ,array( "type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5",'error' => array('attributes' => array('class' => 'alertE')) ))?>

				<!-- <div class="validateErrorMsj" style="float: inherit;"></div> -->
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Confirmar contraseña </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("cpassword" ,array('type' => 'password','label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9 text-right">
				<button class="btn btn-info" type="submit" id="addUser">
					<i class="icon-ok bigger-110"></i>
					Guardar
				</button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>