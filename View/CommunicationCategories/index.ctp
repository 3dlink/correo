<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Categorias
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de las categorias
				</small>
			</h1>
		</div>
		<div class="pull-right">
			<a href="<?php echo $this->webroot.'communicationCategories/add'?>" type="button" class="btn btn-sm btn-success"> Agregar Categoría</a>
		</div>
		<br>
		<br>
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
				<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 255px;">Nombre</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 255px;">Tipo de Correspondencia</th>
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 186px;">Visible</th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%;" aria-label=""></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 
					//debug($communicationCategories, $showHtml = null, $showFrom = true);
					foreach ($communicationCategories as $communicationCategory) { ?>

						<tr class="odd">
							<td class="td-name"><?php echo $communicationCategory['CommunicationCategory']['name']; ?></td>
							<td class="td-name"><?php echo $communicationCategory['CommunicationType']['name']; ?></td>
							<td class="td-username"><?php if ($communicationCategory['CommunicationCategory']['active'] == 1) echo 'Si'; else echo 'No'; ?></td>
							<td class=" " style="width:5%;">
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
									<a class="green" href="<?php echo $this->webroot.'CommunicationCategories/edit/'.$communicationCategory['CommunicationCategory']['id'];?>" title="Editar categoría">
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
			<p>
	<?php
	//echo $this->Paginator->counter(array('format' => __('Página {:page} de {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	//echo $this->Paginator->counter(array('format' => __('Página {:page} de {:pages}')));
	?>	</p>
	<div class="paging">
	<?php
		//echo $this->Paginator->prev('<i class="icon-double-angle-left"></i>' . __('previous'), array(), null, array('class' => 'prev disabled'));
		//echo $this->Paginator->numbers(array('separator' => ''));
		//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>