<?php echo $this->Session->flash(); ?>
<div class="page-header">
	<h1>
		Nuevo Formato
		<small>
			<i class="icon-double-angle-right"></i>
			Agregar nuevo formato
		</small>
	</h1>
</div>

<div class="row" id="inf-format">
	<div class="col-sm-2">
		&nbsp;
	</div>
	<div class="col-sm-10" style="margin-right: 50px;">
		<?php $this->UploadForm->load('/file_upload/handler', true ,false, true);?>
	</div>
	<div class="col-xs-12">
		<?php echo $this->Form->create('Format', array('action' => 'add', 'class' => 'form-horizontal', 'role' => 'form')); ?>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Nombre </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
				<input type="hidden" name="data[Format][entity_id]" id="entity_id" value="<?php echo $this->Session->read('UserAuth.User.entity_id');?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Tipo de Correspondencia </label>
			<div class="col-sm-9 ">
				<select id="message-type" name="data[Format][communication_type_id]" class="col-xs-10 col-sm-5 s-entity">
					<option value="">Seleccione</option>
					<?php foreach ($communicationTypes as $key => $communicationType) { ?>
					<option class="opt-entity" value="<?php echo $key; ?>" ><?php echo $communicationType; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Categoria </label>
			<div class="col-sm-9 ">
				<select id="message-category" name="data[Format][communication_category_id]" class="col-xs-10 col-sm-5 s-entity">
					<option class="opt-entity" value="" >Seleccione</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Activo </label>
			<div class="col-sm-9 ">
				<select name="data[Format][visible]" class="col-xs-10 col-sm-5 s-entity" id="formatVisible">
					<option class="opt-entity" value="1">Si</option>
					<option class="opt-entity" value="0">No</option>
				</select>
			</div>
		</div>
		<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
		
		<div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9 text-right">
				<button class="btn btn-info" type="submit" id="addFormat">
					<i class="icon-ok bigger-110"></i>
					Guardar
				</button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>

