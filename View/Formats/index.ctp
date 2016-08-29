<div class="page-header">
	<h1>
		Formatos
		<small>
			<i class="icon-double-angle-right"></i>
			Listado de los documentos con formatos disponibles
		</small>
	</h1>
</div>
<div class="pull-right">
	<a href="<?php echo $this->webroot.'formats/add'?>" type="button" class="btn btn-sm btn-success"> Agregar Formato</a>
</div>
<br><br><br>
<div class="table-responsive">
	<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
		<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
			<thead>
				<tr role="row">
					<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">Nombre</th>
					<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 30%;">Tipo de Correspondencia</th>
					<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 20%;">Categoria</th>
					<th class="" role="columnheader" rowspan="1" colspan="1" style="width: 10%;" aria-label="">Visible</th>
					<th class="" role="columnheader" rowspan="1" colspan="1" style="width: 5%;" aria-label=""></th>
				</tr>
			</thead>
			<tbody role="alert" aria-live="polite" aria-relevant="all">
			<?php foreach ($formats as $format) { ?>
				<tr class="odd" data-document-id="<?php echo $format['Format']['id'] ?>">
					<td class="td-name"><?php echo $format['Format']['name']; ?></td>
					<td class="td-name"><?php echo $format['CommunicationType']['name']; ?></td>
					<td class="td-name"><?php echo $format['CommunicationCategory']['name']; ?></td>
					<td class=" " style="width:5%;">
						<label>
							<input type="checkbox" class="ace" <?php if ($format['Format']['visible'] == 1) echo 'checked="checked"'; else echo ''; ?>>
							<span class="lbl"></span>
						</label>
					</td>
					<td class=" " style="width:5%;">
						<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
							<a class="green" href="<?php echo $this->webroot.'formats/edit/'.$format['Format']['id'];?>" title="Editar Formato">
								<i class="icon-pencil bigger-130"></i>
							</a>
						</div>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<div class="row">
					<div class="col-sm-6">
						<div class="dataTables_info" id="sample-table-2_info"><?php echo $this->Paginator->counter(array('format' => __('Página {:page} de {:pages}'))); ?></div>
					</div>
					<div class="col-sm-6">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination">
								<?php echo $this->Paginator->prev(' ' . __('Anterior').'  ', array(), null, array('class' => 'prev disabled')); ?>
								<?php echo $this->Paginator->next(__('Siguiente') . ' ', array(), null, array('class' => 'next disabled')); ?>
							</ul>
						</div>
					</div>
				</div>
	</div>
</div>