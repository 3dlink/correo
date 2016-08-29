<?php echo $this->Session->flash(); ?>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Detalle del Rol de Usuario
				<small>
					<i class="icon-double-angle-right"></i>
					detalle de <?php echo $group['UserGroup']['name'].' '?>
				</small>
			</h1>
		</div>
		<?php echo $this->Form->create('UserGroup', array('action' => 'editGroup/<?php echo $group["UserGroup"]["id"] ?>', 'class'=>'form-horizontal')); ?>

			<?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false, 'default' => $group['UserGroup']['id'])) ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nombre </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value'=> $group['UserGroup']['name']))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alias </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("alias_name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value' => $group['UserGroup']['alias_name'] ))?>
				</div>
			</div>
			
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9 text-right">
					<button id="editGroup" class="btn btn-info" type="submit">
						<i class="icon-ok bigger-110"></i>
						Guardar
					</button>
					&nbsp; &nbsp; &nbsp;
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
