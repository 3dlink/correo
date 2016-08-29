<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Etiquetas
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de mis etiqeutas
				</small>
			</h1>
		</div>
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
				<div class="row">
					<div class="col-sm-12">
						<div class="dataTables_filter" id="sample-table-2_filter">
							<label>Buscar: <input id="searchTag" type="text" aria-controls="sample-table-2"></label>
						</div>
					</div>
				</div>
				<table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th class="" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 255px;">Etiqueta</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($tags as $tag) { ?>

						<tr class="odd">
							<td class="td-name" data-tag-name="<?php echo $tag['Tag']['name']?>"><a href="<?php echo $this->webroot.'communications/index?tn='.$tag['Tag']['name'].'&ti='.$tag['Tag']['id'] ?>"><?php echo $tag['Tag']['name'] ?></a></td>
						</tr>
					<?php } ?>
					<?php foreach ($communicationTypes as $communicationType) { ?>

						<tr class="odd">
							<td class="td-name" data-tag-name="<?php echo $communicationType['CommunicationType']['name']?>"><a href="<?php echo $this->webroot.'communications/index?ctn='.$communicationType['CommunicationType']['name'].'&cti='.$communicationType['CommunicationType']['id'] ?>"><?php echo $communicationType['CommunicationType']['name'] ?></a></td>
						</tr>
					<?php } ?>
					<?php foreach ($communicationCategories as $communicationCategory) { ?>

						<tr class="odd">
							<td class="td-name" data-tag-name="<?php echo $communicationCategory['CommunicationCategory']['name']?>"><a href="<?php echo $this->webroot.'communications/index?ccn='.$communicationCategory['CommunicationCategory']['name'].'&cci='.$communicationCategory['CommunicationCategory']['id'] ?>"><?php echo $communicationCategory['CommunicationCategory']['name'] ?></a></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


