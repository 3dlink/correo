<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Roles de Usuarios
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de los tipos de roles usuarios
				</small>
			</h1>
		</div>
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
				<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 255px;">Nombre</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 186px;">Alias</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 298px;">Creado</th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 263px;" aria-label=""></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($userGroups as $row) { ?>

						<tr class="odd">
							<td ><?php echo $row['UserGroup']['name'].' ' ?></td>
							<td ><?php echo $row['UserGroup']['alias_name'] ?></td>
							<td class=""><?php echo date('d-M-Y',strtotime($row['UserGroup']['created'])); ?></td>
							<td class=" ">
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
									<a class="green" href="<?php echo $this->webroot.'editGroup/'.$row['UserGroup']['id'];?>" title="Editar grupo">
										<i class="icon-pencil bigger-130"></i>
									</a>
									<?php if ( !in_array($row['UserGroup']['id'], array(1,2,3))) {?>
									<a class="red delete-group" data-group-id="<?php echo $row['UserGroup']['id']; ?>" href="#">
										<i class="icon-trash bigger-130"></i>
									</a>
									<?php } ?>
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
