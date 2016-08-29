<?php //debug($circles, $showHtml = null, $showFrom = true) ?>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Círculos
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de los círculos a los que pertenezco
				</small>
			</h1>
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
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 186px;">Creado por</th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%;" aria-label=""></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 
					foreach ($circles as $circle) { ?>
						<tr class="odd">
							<td class="td-name"><?php echo $circle['Circle']['name']; ?></td>
							<td class=""><?php if ($circle['Circle']['type'] == 1) echo 'Privado'; else echo 'Público'; ?></td>
							<td class="td-username"><?php  echo $circle['User']['first_name'].' '.$circle['User']['last_name'];  ?></td>
							<td class=" " style="width:5%;">
								<?php if ($this->Session->read('UserAuth.User.id') != $circle['Circle']['user_id']) {?>
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
									<a class="red out-from-circle" data-circle-id="<?php echo $circle['Circle']['id']; ?>" href="" title="Salir del círculo">
										<i class="icon-minus bigger-130"></i>
									</a>
								</div>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

