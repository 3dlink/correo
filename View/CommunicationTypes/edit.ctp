<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Detalle del Tipo de Correspondencia
				<small>
					<i class="icon-double-angle-right"></i>
					detalle de <?php echo $communicationType['CommunicationType']['name']?>
				</small>
			</h1>
		</div>
		<form class="form-horizontal" action="<?php echo $this->webroot.'communicationTypes/edit/'.$communicationType['CommunicationType']['id'];?>" method="post" accept-charset="utf-8">
			<?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false, 'default' => $communicationType['CommunicationType']['id']));?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nombre</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value' => $communicationType['CommunicationType']['name'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Activo </label>
				<div class="col-sm-9 ">
					<select name="active" class="col-xs-10 col-sm-5 s-entity">
						<option class="opt-entity" value="1" <?php if ($communicationType['CommunicationType']['active']==1) echo 'selected="selected"' ?> >Si</option>
						<option class="opt-entity" value="0" <?php if ($communicationType['CommunicationType']['active']==0) echo 'selected="selected"' ?> >No</option>
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

