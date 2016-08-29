<div class="row">
	<?php //debug($communicationCategory, $showHtml = null, $showFrom = true)?>
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Detalle del Grupo
				<small>
					<i class="icon-double-angle-right"></i>
					detalle de <?php echo $group['Group']['name']?>
				</small>
			</h1>
		</div>
		<form class="form-horizontal" action="<?php echo $this->webroot.'groups/edit/'.$group['Group']['id'];?>" method="post" accept-charset="utf-8">
			<?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false, 'default' => $group['Group']['id']));?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nombre</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value' => $group['Group']['name'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Activo </label>
				<div class="col-sm-9 ">
					<select name="active" class="col-xs-10 col-sm-5 s-entity">
						<option class="opt-entity" value="1" <?php if ($group['Group']['active']==1) echo 'selected="selected"' ?> >Si</option>
						<option class="opt-entity" value="0" <?php if ($group['Group']['active']==0) echo 'selected="selected"' ?> >No</option>
					</select>
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
		</form>
	</div>
</div>



