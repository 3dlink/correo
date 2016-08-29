<div class="page-header">
	<h1>
		Nueva Tipo de Correspondencia
		<small>
			<i class="icon-double-angle-right"></i>
			Agregar nuevo tipo de correspondencia
		</small>
	</h1>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php echo $this->Form->create('CommunicationType', array('action' => 'add', 'class' => 'form-horizontal', 'role' => 'form')); ?>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Nombre </label>
			<div class="col-sm-9">
				<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Activo </label>
			<div class="col-sm-9 ">
				<select name="active" class="col-xs-10 col-sm-5 s-entity">
					<option class="opt-entity" value="1">Si</option>
					<option class="opt-entity" value="0">No</option>
				</select>
			</div>
		</div>
		<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
		
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
