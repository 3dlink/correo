<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Tipos  de Correspondencia
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de los tipos de correspondencias
				</small>
			</h1>
		</div>
		<div class="pull-right">
			<a href="<?php echo $this->webroot.'communicationTypes/add'?>" type="button" class="btn btn-sm btn-success"> Agregar Tipo</a>
		</div>
		<br>
		<br>
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
				<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 255px;">Nombre</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 186px;">Visible</th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%;" aria-label=""></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($communicationTypes as $communicationType) { ?>

						<tr class="odd">
							<td class="td-name"><?php echo $communicationType['CommunicationType']['name']; ?></td>
							<td class="td-username"><?php if ($communicationType['CommunicationType']['active'] == 1) echo 'Si'; else echo 'No'; ?></td>
							<td class=" " style="width:5%;">
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
									<a class="green" href="<?php echo $this->webroot.'CommunicationTypes/edit/'.$communicationType['CommunicationType']['id'];?>" title="Editar categoría">
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
	</div>
</div>