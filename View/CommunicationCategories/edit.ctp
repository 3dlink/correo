<div class="row">
	<?php //debug($communicationCategory, $showHtml = null, $showFrom = true)?>
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Detalle de la Categoria
				<small>
					<i class="icon-double-angle-right"></i>
					detalle de <?php echo $communicationCategory['CommunicationCategory']['name']?>
				</small>
			</h1>
		</div>
		<form class="form-horizontal" action="<?php echo $this->webroot.'communicationCategories/edit/'.$communicationCategory['CommunicationCategory']['id'];?>" method="post" accept-charset="utf-8">
			<?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false, 'default' => $communicationCategory['CommunicationCategory']['id']));?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nombre</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value' => $communicationCategory['CommunicationCategory']['name'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Tipo de Correspondencia </label>
				<div class="col-sm-9 ">
					<select name="communication_type_id" class="col-xs-10 col-sm-5 s-entity">
						<?php foreach ($communicationTypes as $key => $communicationType) { ?>
						<option class="opt-entity" value="<?php echo $key; ?>" <?php if ($communicationCategory['CommunicationCategory']['communication_type_id']==$key) echo 'selected="selected"' ?> ><?php echo $communicationType; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Activo </label>
				<div class="col-sm-9 ">
					<select name="active" class="col-xs-10 col-sm-5 s-entity">
						<option class="opt-entity" value="1" <?php if ($communicationCategory['CommunicationCategory']['active']==1) echo 'selected="selected"' ?> >Si</option>
						<option class="opt-entity" value="0" <?php if ($communicationCategory['CommunicationCategory']['active']==0) echo 'selected="selected"' ?> >No</option>
					</select>
				</div>
			</div>
			
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9 text-right">
					<button id="editUser" class="btn btn-info" type="submit">
						<i class="icon-ok bigger-110"></i>
						Guardar
					</button>
					&nbsp; &nbsp; &nbsp;
				</div>
			</div>
		</form>
	</div>
</div>

