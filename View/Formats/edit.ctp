<?php 
//debug($format, $showHtml = null, $showFrom = true);
echo $this->Session->flash(); ?>
<style>


</style>
<div class="page-header">
	<h1>
		Editar Formato
		<small>
			<i class="icon-double-angle-right"></i>
			Editar formato
		</small>
	</h1>
</div>

<div class="row" id="inf-format">
	<div class="col-sm-2">
		&nbsp;
	</div>
	<div class="col-sm-10">
		<?php $this->UploadForm->load();?>
	</div>
	<div id="prev-upload">
		<div class="col-sm-3">
			&nbsp;
		</div>
		<div class="col-sm-9">
			<?php echo $format['Upload']['real_name']?>&nbsp;&nbsp;
			<a href="<?php echo $this->webroot.'communications/download/'.$format['Upload']['name'];?>" title="Descargar" target="_blank"><i class="icon-download-alt bigger-125 blue"></i></a> &nbsp;&nbsp;
			<a href="" title="Eliminar" id="delete-prev-upload"><i class="icon-trash red bigger-130 middle"></i></a>
			<br><br>
		</div>

	</div>
	<div class="col-xs-12">
		<?php echo $this->Form->create('Format', array('action' => 'edit', 'class' => 'form-horizontal', 'role' => 'form')); ?>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Nombre </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("id" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5 hide" ))?>
				<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Tipo de Correspondencia </label>
			<div class="col-sm-9 ">
				<select id="message-type" name="data[Format][communication_type_id]" class="col-xs-10 col-sm-5 s-entity">
					<option value="">Seleccione</option>
					<?php foreach ($communicationTypes as $key => $communicationType) { ?>
					<option class="opt-entity" value="<?php echo $key; ?>" <?php if ($format['Format']['communication_type_id'] == $key) echo 'selected="selected"' ?>  ><?php echo $communicationType; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Categoria </label>
			<div class="col-sm-9 ">
				<select id="message-category" name="data[Format][communication_category_id]" class="col-xs-10 col-sm-5 s-entity">
					<option class="opt-entity" value="" >Seleccione</option>
					<option value="">Seleccione</option>
					<?php foreach ($communicationCategories as $key => $communicationCategory) { ?>
					<option class="opt-entity" value="<?php echo $key; ?>" <?php if ($format['Format']['communication_category_id'] == $key) echo 'selected="selected"' ?> ><?php echo $communicationCategory; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Activo </label>
			<div class="col-sm-9 ">
				<select name="data[Format][visible]" class="col-xs-10 col-sm-5 s-entity" id="formatVisible">
					<option class="opt-entity" value="1" <?php if ($format['Format']['visible'] == 1) echo 'selected="selected"' ?>>Si</option>
					<option class="opt-entity" value="0" <?php if ($format['Format']['visible'] == 0) echo 'selected="selected"' ?>>No</option>
				</select>
			</div>
		</div>
		<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
		
		<div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9 text-right">
				<button class="btn btn-info" type="submit" id="editFormat">
					<i class="icon-ok bigger-110"></i>
					Guardar
				</button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
