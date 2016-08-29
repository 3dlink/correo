<?php echo $this->Session->flash(); ?>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Detalle de Usuario
				<small>
					<i class="icon-double-angle-right"></i>
					detalle de <?php echo $user['User']['first_name'].' '.$user['User']['last_name']?>
				</small>
			</h1>
		</div>
		<form class="form-horizontal" action="<?php echo $this->webroot.'editUser/'.$user['User']['id'];?>" id="UserEditUserForm" method="post" accept-charset="utf-8" data-user-id="<?php echo $user['User']['id'];?>">
					<input type="hidden" name="script" id="script" value="0">

			<?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false, 'default' => $user['User']['id'])) ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nombre(s) </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("first_name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value' => $user['User']['first_name'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Apellido(s) </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("last_name" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value' => $user['User']['last_name'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Usuario </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("username" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value' => $user['User']['username'] ))?>
				</div> 
			</div>
			<?php   if (count($userGroups) >2) { ?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Rol </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("user_group_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'default' => $user['User']['user_group_id']))?>
				</div>
			</div>
			<?php } ?>
			<div class="selects-entity">
				<?php if (isset($tree)){ 
					$first = true;
					foreach ($tree as $key => $node) {
						?>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1">
								<?php if ($first) {
									$first = false;
									echo 'Entidad';
								} else {
									echo '&nbsp;';
								}
								?>
							</label>
							<div class="col-sm-9 ">
								<select name="entity_id" class="col-xs-10 col-sm-5 s-entity">
								<option value="0">Seleccione</option>
								<?php  
									foreach ($node['Brothers'] as $key => $entity) {
									$child = !empty($entity['ChildEntity']);
								?>		
								<option class="opt-entity" value="<?php echo $entity['Entity']['id'] ?>" data-child="<?php echo $child; ?>" <?php if ($entity['Entity']['id'] == $node['Entity']['id']) echo 'selected="selected"' ?>><?php echo $entity['Entity']['name'] ?></option>
								<?php 
									}
								?>
								</select>
							</div>
						</div>
						<?php
					}
				}
				else {
					?>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Cargo </label>
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
					<?php
				}
			?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Cargo </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("position" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value'=>$user['User']['position'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Grupo Estatal</label>
				<div class="col-sm-9">
						<?php echo $this->Form->input("group_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'default' => $user['User']['group_id']))?>
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1"> Posee Firma</label>
			<div class="col-sm-9">
				<select name="data[signed]" id="signed" class="col-xs-10 col-sm-5" id="UserSigned">
					<option value="" <?php echo  $this->data['User']['signed']=="" ? 'selected' : '';?>>Seleccione</option>
					<option value="0" <?php echo  $this->data['User']['signed']==0 ? 'selected' : '';?>>No Posee</option>
					<option value="1" <?php echo  $this->data['User']['signed']==1 ? 'selected' : '';?>>Si Posee</option>
				</select>
			</div>
			</div>
			

<!-- 			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Grupo Institucional</label>
				<div class="col-sm-9">
						<?php echo $this->Form->input("groupi_id" ,array('type' => 'select', 'options' => $groups_i, 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'default' => $user['User']['groupi_id']))?>
				</div>
			</div> -->

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Correo </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value'=>$user['User']['email'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Teléfono </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("telephone" ,array('type'=>'text', 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value'=>$user['User']['telephone'] ))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Teléfono Móvil</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("celphone" ,array('type'=>'text', 'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5", 'value'=>$user['User']['celphone'] ))?>
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