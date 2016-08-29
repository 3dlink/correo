<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Usuarios
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de los usuarios registrados en el sistema
				</small>
			</h1>
		</div>
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
				<div class="row">
					<div class="col-sm-12">
						<div class="dataTables_filter" id="sample-table-2_filter">
							<label>Filtrar <input id="searchUser" type="text" aria-controls="sample-table-2"></label>
								<div>
								<label><input class="status" name="radio" value="0" type="radio"> Inactivo</label>
								<label><input class="status" name="radio" value="1" type="radio"> Activo</label>
								<label><input class="status" name="radio" value="" type="radio"> Todos</label>
								<label><input class="status" name="radio" value="3" type="radio">Posee Firma</label>
								<label><input class="status" name="radio" value="4" type="radio">No Posee Firma</label>
							</div>
						</div>
					</div>
				</div>
				<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 55px;">Nombre</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 50px;">Usuario</th>
							<th class="hidden-480 " role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 75px;" >Rol</th>
							<th class="hidden-480 " role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 202px;" >Entidad</th>
							<th class="hidden-480 " role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 245px;">Grupo</th>
							<th class="hidden-480 " role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 45px;">Estado</th>
								<th class="hidden-480 " role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 45px;">Posee Firma</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 130px;">Creado</th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 263px;" aria-label=""></th>
						</tr>
					</thead> 
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($users as $row) { ?>

						<tr class="odd">
							<td class="td-name" data-user-name="<?php echo strtolower($row['User']['first_name'].' '.$row['User']['last_name']); ?>"><?php echo $row['User']['first_name'].' '.$row['User']['last_name'] ?></td>
							<td class="td-username" data-user-username="<?php echo strtolower($row['User']['username']) ?>"><?php echo $row['User']['username'] ?></td>
							<td class="td-rol" data-rol-name="<?php echo strtolower($row['UserGroup']['name']) ?>"><?php echo $row['UserGroup']['name'] ?></td>
							<td class="td-entity" data-entity-name="<?php echo strtolower($row['Entity']['name']) ?>"><?php echo $row['Entity']['name'] ?></td>
							<td class="td-group" data-group-name="<?php echo strtolower($row['Group']['name']) ?>"><?php echo $row['Group']['name'] ?></td>
							<?php 
								if ($row['User']['active']==1) echo '<td class="td-state" data-state-name="1">Activo</td>';
								else echo '<td class="td-state" data-state-name="0">Inactivo</td>';
							?>
							<?php 
								if ($row['User']['signed']==1) echo '<td class="td-firma" data-signed="1">Si</td>';
								else echo '<td class="td-firma" data-signed="0">No</td>';
							?>
							<td class=""><?php echo date('d-M-Y',strtotime($row['User']['created'])); ?></td>
							<td class=" ">
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons" style="text-align: center;">
									<a class="blue" href="<?php echo $this->webroot.'viewUser/'.$row['User']['id'];?>" title="Ver detalle de usuario">
										<i class="icon-zoom-in bigger-130"></i>
									</a>

									<a class="green" href="<?php echo $this->webroot.'editUser/'.$row['User']['id'];?>" title="Editar usuario">
										<i class="icon-pencil bigger-130"></i>
									</a>
									<?php if ($row['User']['active']==0) { ?>
									<a class="red" href="<?php echo $this->webroot.'usermgmt/users/makeActiveInactive/'.$row['User']['id'].'/1';?>" title="Activar usuario">
										<i class="icon-lock bigger-130"></i>
									</a>
									<?php } else { ?>
									<a class="red" href="<?php echo $this->webroot.'usermgmt/users/makeActiveInactive/'.$row['User']['id'].'/0';?>" title="Desactivar usuario">
										<i class="icon-unlock bigger-130"></i>
									</a>
									<?php } ?>
									<?php ?>
									<a class="orange" href="<?php echo $this->webroot.'changeUserPassword/'.$row['User']['id'] ?>" title="Cambiar la clave del usuario">
										<i class="icon-key bigger-130"></i>
									</a>
									<!--<a class="pink btn-delete-user" title="Eliminar usuario" data-user-id="<?php echo $row['User']['id'];?>">
										<i class="icon-trash bigger-130"></i>
									</a>-->
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>



