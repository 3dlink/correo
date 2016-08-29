<?php echo $this->Session->flash(); ?>
<div class="page-header">
	<h1>
		Redireccionamiento
		<small>
			<i class="icon-double-angle-right"></i>
			Lista de personas a quienes serán redirigidas todos las comunicaciones entrantes
		</small>
	</h1>
</div>
<div class="row">
	<div class="col-xs-12">
		<!--
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>
			<div class="col-sm-11">
				&nbsp;
				<div id="content-receivers"></div>
			</div>
		</div>
		<br>
	-->
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1"> Buscar </label>
			<div class="col-sm-11">
				<input style="margin-top:5px;" type="text" id="msg-redirect" placeholder="agregar persona o entidad" class="col-xs-10 col-sm-10" data-items="4">
				<label>Que las comunicaciones las reciba solo mi redireccionado. </label>	<input style="margin-top:5px;" type="checkbox" id="redirect" placeholder="agregar persona o entidad" class="col-xs-2 col-sm-2" data-items="4" <?php if($this->Session->read('UserAuth.User.redirect_only')==1){echo "checked";}?>>
			</div>
			
		</div>
		<br><br>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div id="lista">
			<div class="table-responsive">
				<table id="sample-table-1" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Entidad y Cargo</th>
							<th></th>
						</tr>
					</thead>

					<tbody class="to-redirect">
						<?php if (!empty($users)) {?>
						<?php foreach ($users as $key => $user) { ?>
						<tr data-type="user" data-id="<?php echo $user['ToUser']['id']; ?>">
							<td >
								<?php echo $user['ToUser']['first_name'].' '.$user['ToUser']['last_name']; ?>
							</td>
							<td>
								<?php 
									echo ' - ';
									if (isset($user['Path'])) {
										foreach ($user['Path'] as $key => $path) {
										echo $path['Entity']['name'].' - ';
									}
								} ?>
							</td>
							<td class="center redirection-delete">
								<a href="#">Eliminar</a>
							</td>
						</tr>
						<?php } ?>
						<?php } else { ?>
							<tr><td colspan="3" class="text-center"> No hay datos que mostrar </td> </tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	