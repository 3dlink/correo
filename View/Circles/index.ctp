<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Círculos
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de mis círculos
				</small>
			</h1>
		</div>
		<div class="pull-right">
			<a href="<?php echo $this->webroot.'circles/add'?>" type="button" class="btn btn-sm btn-success"> Agregar Círculo</a>
		</div>
		<br>
		<br>
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
				<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 255px;">Nombre</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 186px;">Tipo</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 186px;">Visible</th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%;" aria-label=""></th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%;" aria-label=""></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 
					foreach ($circles as $circle) { ?>
						<tr class="odd">
							<td class="td-name"><?php echo $circle['Circle']['name']; ?></td>
							<td class=""><?php if ($circle['Circle']['type'] == 1) echo 'Privado'; else echo 'Público'; ?></td>
							<td class="td-username"><?php if ($circle['Circle']['active'] == 1) echo 'Si'; else echo 'No'; ?></td>
							<td class=" " style="width:5%;">
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
									<a class="green" href="<?php echo $this->webroot.'circles/edit/'.$circle['Circle']['id'];?>" title="Editar círculo">
										<i class="icon-pencil bigger-130"></i>
									</a>
								</div>
							</td>
							<td class=" " style="width:5%;">
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
									<a class="green adm-members-circle" href="#" title="Administrar miembros" data-circle-id="<?php echo $circle['Circle']['id'] ?>">
										<i class="icon-group bigger-130"></i>
									</a>
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
<div class="modal fade" id="modalAdmMembersCircle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-append-to="">
  	<div class="modal-dialog" style="width:1000px;">
    	<div class="modal-content">
    		<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Administrar Miembros</h4>
	      	</div>
      		<div class="modal-body">
      			<span id="btnFindUsers" class="btn">Agregar Miembro</span>
      			<span id="btnDeleteUsers" class="btn btn-danger pull-right hide"><i class="icon-trash bigger-110"></i></span>
      			<br><br>
				<table id="table-members" class="table table-striped table-bordered table-hover"></table>

      		</div>
    	</div>
  	</div>
</div>
<div class="modal fade" id="modalDirectory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-append-to="">
  	<div class="modal-dialog" style="width:1000px;">
    	<div class="modal-content">
    		<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Búsqueda avanzada</h4>
	      	</div>
      		<div class="modal-body">
        		Cargando directorio ...
      		</div>
    	</div>
  	</div>
</div>

