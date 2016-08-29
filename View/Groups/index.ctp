<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Grupos
				<small>
					<i class="icon-double-angle-right"></i>
					Listado de los grupos de usuarios
				</small>
			</h1>
		</div>
		<div class="pull-right">
			<a href="<?php echo $this->webroot.'groups/add'?>" type="button" class="btn btn-sm btn-success"> Agregar Grupo</a>
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
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 8%;" aria-label=""></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 
					//debug($communicationCategories, $showHtml = null, $showFrom = true);
					foreach ($groups as $group) { ?>

						<tr class="odd">
							<td class="td-name"><?php echo $group['Group']['name']; ?></td>
							<td class="td-username"><?php if ($group['Group']['active'] == 1) echo 'Si'; else echo 'No'; ?></td>
							<td class=" " style="width:5%;">
								<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
									<a class="green" href="<?php echo $this->webroot.'groups/edit/'.$group['Group']['id'];?>" title="Editar grupo">
										<i class="icon-pencil bigger-130"></i>
									</a>
									<a class="green adm-members-circle" href="#" title="Administrar miembros" data-circle-id="<?php echo $group['Group']['id']; ?>">
										<i class="icon-group bigger-130"></i>
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
		        <h4 class="modal-title" id="myModalLabel">Búsqueda avanzada2</h4>
	      	</div>
      		<div class="modal-body">
        		Cargando directorio ...
      		</div>
    	</div>
  	</div>
</div>

<script type="text/javascript">
	var glo = "";

		// boton para administrar los usuarios en el circulo
		$(document).find('.adm-members-circle').on('click', function(event) {
			event.preventDefault();
			var idCircle = $(this).attr('data-circle-id');
			console.log(idCircle);
			$('#modalAdmMembersCircle').find('#btnDeleteUsers').addClass('hide');
			$('#modalAdmMembersCircle').attr('data-circle-id', idCircle);
			$('#modalAdmMembersCircle').modal('show');
			$.ajax({
				url: WEBROOT + 'groups/findPeopleByGoup/'+idCircle,
				type: 'get',
				success: function(data){
					var _html = _htmlTableMembers(data);
      				$('#table-members').html(_html);
				}, 
				dataType: 'json',
				async: false
			});
		});

	/**** INICIO MODAL MIEMBROS DEL CIRCULO *****/

		var _htmlTableMembers = function(data) {
			if (data.length < 1) return '<thead><tr><th colspan="6"> No hay datos </th></tr></thead>';
			var html = '<thead>';
			html = html + '<tr>';
			html = html + '<th class="center">'
			html = html + '<label>';
			html = html + '<input type="checkbox" class="ace" id="checkbox-select-all"><span class="lbl"></span>';
			html = html + '</label>'
			html = html + '	</th>';
			html = html +'<th>Nombre</th><th>Teléfono</th><th>Móvil</th></tr></thead>';
			html = html + '<tbody>';
			$.each(data, function(index, val) {
				console.log(val);
				telephone = val.User.telephone ? val.User.telephone : '';
				celphone = val.User.celphone ? val.User.celphone : '';
				html = html + '<tr data-user-id="'+val.User.id+'" data-user-name="'+val.User.first_name+' '+val.User.last_name+'" data-user-path="'+val.path+'" data-user-telephone="'+telephone+'" data-user-celphone="'+celphone+'">';
				html = html + '<td class="center"><label><input class="ace ckb" type="checkbox"><span class="lbl"></span></label></td>';
				html = html + '<td>'+val.User.first_name+' '+val.User.last_name +'</td>';
				html = html + '<td>'+telephone+'</td>';
				html = html + '<td>'+celphone+'</td>';
			});
			html = html + '</tbody>';
			return html;
		}

		$(document).on('click', '.btnFindByQ', function(event) {
			event.preventDefault();
			var query = $('#search-people').val();
			if (!query) return false;
			$.ajax({
          		url: WEBROOT + 'communications/directory/?q='+query,
          		type: 'post',
          		success: function(data){
					var html = CE.htmls.directory(data, 'circles');
					var h = $(html).height();
          			$('#modalDirectory').find('.modal-body').html(html);
          		}, 
          		dataType: 'json',
        	});
        	return false;
		});



		// boton para agregar nuevos usuarios en el circulo
		$('#btnFindUsers').on('click', function(event) {
			glo = "circles";

			event.preventDefault();
			// cargar directorio
			$('#modalDirectory').modal('show');
			$("input[type=checkbox]").prop('checked', false);
			$('#btnDeleteUsers').addClass('hide');
			$.ajax({
          		url: WEBROOT + 'communications/directory/?circle=1',
          		type: 'post',
          		success: function(data){
					var html = CE.htmls.directory(data, 'circles');
          			$('#modalDirectory').find('.modal-body').html(html);
          			$('#modalDirectory').find('button.btn-send-msg').attr('title', 'Agregar al grupo');
          			$('#modalDirectory').find('button.btn-send-msg').attr('data-original-title', 'Agregar al grupo');
          			$('#modalDirectory').find('button.btn-send-msg').html('Agregar al grupo');
          			$('#modalDirectory').attr('data-append-to', 'to');
          		}, 
          		dataType: 'json',
        	});
		});

		// eliminar usuarios de un circulo
		$('#btnDeleteUsers').on('click', function(event) {
			event.preventDefault();
			var idCircle = $('#modalAdmMembersCircle').attr('data-circle-id');
			var idsUserDelete = [];
			$("#modalAdmMembersCircle input[type=checkbox]:checked").each(function(k,v){
				if ($(v).attr('id') != 'checkbox-select-all') {
					idUser = $(v).parents('tr:first').attr('data-user-id');
					idsUserDelete.push(idUser);
				}
			});

			var data = {
				circle: idCircle,
				users: idsUserDelete,
			}
			if (idsUserDelete.length <= 0) return false;

			$.ajax({
          		url: WEBROOT + 'groups/eject/',
          		type: 'post',
          		data: data,
          		success: function(data){
					if (data.Request.status == 200){
						$("#modalAdmMembersCircle input[type=checkbox]:checked").each(function(k,v){
							if ($(v).attr('id') != 'checkbox-select-all') {
								$(v).parents('tr:first').remove();
								$('#btnDeleteUsers').addClass('hide');
							}
						});
						message('Mensaje', data.Request.message);
					} else {

					}
          		}, 
          		dataType: 'json',
        	});
		
		});

	/**** FIN MODAL MIEMBROS DEL CIRCULO *****/

	/**** INICIO MODAL DIRECTORIO *****/
		var _htmlSelect = function (entities) {
			var html = '<div class="form-group">';
			html = html + '<label class="col-sm-1 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>';
			html = html + '<div class="col-sm-11">';
			html = html + '<select name="entity_id" class="col-xs-10 col-sm-5 s-entity">';
			html = html + '<option value="0">Seleccione</option>';
			$.each(entities, function(index, entity) {
				var child = entity.ChildEntity;
				child = child.length;
				child = (child > 0) ? 1 : '';
				html = html + '<option class="opt-entity" value="'+entity.Entity.id+'" data-child="'+child+'">'+entity.Entity.name+'</option>';
			});
			html = html + '</select></div></div>';
			return html;
		}

		var _htmlTable = function(data) {
			if (data.length < 1) return '<thead><tr><th colspan="6"> No hay datos </th></tr></thead>';
			var html = '<thead>';
			html = html + '<tr>';
			html = html + '<th class="center">'
			html = html + '<label>';
			html = html + '<input type="checkbox" class="ace" id="checkbox-select-all"><span class="lbl"></span>';
			html = html + '</label>'
			html = html + '	</th>';
			html = html +'<th>Nombre</th><th>Cargo</th><th>Email</th><th>Teléfono</th><th>Móvil</th><th>Entidad</th><th>Web</th><th>Posee Firma</th></tr></thead>';
			html = html + '<tbody>';
			$.each(data, function(index, val) {
				telephone = val.User.telephone ? val.User.telephone : '';
				celphone = val.User.celphone ? val.User.celphone : '';
				website = val.Entity.website ? val.Entity.website : ' ';
				html = html + '<tr class="nUser'+(index)+'" data-user-id="'+val.User.id+'" data-user-name="'+val.User.first_name+' '+val.User.last_name+'" data-user-path="'+val.path+'" data-user-telephone="'+telephone+'" data-user-celphone="'+celphone+'" >';
				html = html + '<td class="center"><label><input class="ace ckb" type="checkbox"><span class="lbl"></span></label></td>';
				html = html + '<td class="nUser">'+val.User.first_name+' '+val.User.last_name +'</td>';
				html = html + '<td>'+val.User.position+'</td>';
				html = html + '<td>'+val.User.email+'</td>';
				html = html + '<td>'+telephone+'</td>';
				html = html + '<td>'+celphone+'</td>';
				html = html + '<td>'+val.path+'</td>';
				if (website != ' ')	html = html + '<td><a href="'+website+'" target="_blank"> Ver </a></td>';
				else html = html + '<td>&nbsp;</td>';
				if(val.User.signed == 1){
				    html = html + '<td>Si</td>';
				}
				else{
				    html = html + '<td>No</td>';
				}
			});
			html = html + '</tbody>';
			return html;
		}

		// al seleccionar una entidad buscar sus hijos
		$(document).on('change', 'select.s-entity', function () {
			_this = this;
			_opt = $(_this).find('option:selected');
			var hasChild = $(_opt).attr('data-child');
			var parentId = $(_opt).attr('value');
			var userGroupId = $('#UserUserGroupId').val();

			$(_this).parents('.form-group:first').nextAll('.form-group').remove();

			if (hasChild && userGroupId != 3){
				$('.selects-entity').find('.i-load').removeClass('hide');
				$.ajax({
          			url: WEBROOT + 'entities/children/'+parentId+'/',
          			type: 'get',
          			success: function(data){
          				var htmlSelect = _htmlSelect(data);
          				$('.selects-entity').find('div.form-group:last').after(htmlSelect);
          			}, 
          			dataType: 'json',
          			complete: function(){
          				$('.selects-entity').find('.i-load').addClass('hide');
          			}
        		});
			} 
		});



		// btn para buscar a todos los usuarios que estan bajo una entidad
		$(document).on('click','#btn-find-by-entity', function() {
			event.preventDefault();
			var entity = $('option.opt-entity:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'entities/findAllPeople/'+entity+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#searchName').css('display','block');
      				$('#count2').html('<span style="background-color:orange !important;" class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');
      				$('#table-2').html(_html);

      			}, 
      			dataType: 'json',
    		});
		});	

		$(document).on('keyup','#searchName', function() {
			var qstr = $('#searchName').val().toLowerCase();
			if(qstr.length >= 2){
				$(".nUser").each(function(k, v) {
					var txt = $(v).text().toLowerCase();
					var n = txt.indexOf(qstr);
					if(n == -1){
						$('.nUser'+k).css('visibility','hidden');
						$('.nUser'+k).css('position','absolute');
					}
					else{
						$('.nUser'+k).css('visibility','');
						$('.nUser'+k).css('position','');
					}
				});
			}
			if(qstr.length == 0){
				$(".nUser").each(function(k, v) {
					$('.nUser'+k).css('visibility','');
					$('.nUser'+k).css('position','');
				});
			}
		});



		// marcar o desmarcar todos los chekbox
	    $(document).on('click', 'table th input:checkbox', function(){
			var that = this;
			$(this).closest('table').find('tr > td:first-child input:checkbox')
			.each(function(){
				this.checked = that.checked;
				$(this).closest('tr').toggleClass('selected');
			});
		});

	    // al pisar sobre un checkbox 
		$(document).on('click', '[type="checkbox"]', function(event) {
			var active = false;
			$.each($('[type="checkbox"]'), function(index, val) {
				if ($(this).is(':checked')) {
					active = true;
					return false;
				}
			});
			
			if (active) {
				$('.spn-send-msg').removeClass('hide');
				$('#btnDeleteUsers').removeClass('hide');
			}
			else { 
				$('.spn-send-msg').addClass('hide');
				$('#btnDeleteUsers').addClass('hide');
			}
		});


		
		// agregar al circulo
		$(document).on('click','.btn-send-msg', function(event) {
			event.preventDefault();
			var idCircle = $('#modalAdmMembersCircle').attr('data-circle-id');
			var idsToAdd = [];
			var toUserAdd = [];
			$("input[type=checkbox]:checked").each(function(k,v){
				if ($(v).attr('id') != 'checkbox-select-all') {
					idUser = $(v).parents('tr:first').attr('data-user-id');
					var dt = {
						id: idUser,
						name: $(v).parents('tr:first').attr('data-user-name'),
						telephone: $(v).parents('tr:first').attr('data-user-telephone'),
						celephone: $(v).parents('tr:first').attr('data-user-celphone')
					}
					toUserAdd.push(dt);
					idsToAdd.push(idUser);
				}
			});
			var data = {
				circle: idCircle,
				users: idsToAdd,
			}
			$.ajax({
          		url: WEBROOT + 'groups/addPeopleGroup/',
          		type: 'post',
          		data: data,
          		success: function(data){
					if (data.Request.status == 200){
						var _htmlrow = '';
						$.each(toUserAdd, function(index, user) {
							_htmlrow = _htmlrow + '<tr data-user-id="'+user.id+'" data-user-name="'+user.name+'" data-user-telephone="'+user.telephone+'" data-user-celphone="'+user.celephone+'">';
							_htmlrow = _htmlrow + '<td class="center"><label><input class="ace ckb" type="checkbox"><span class="lbl"></span></label></td>';
							_htmlrow = _htmlrow + '<td>' + user.name + '</td>';
							_htmlrow = _htmlrow + '<td>' + user.telephone + '</td>';
							_htmlrow = _htmlrow + '<td>' + user.celephone + '</td>';
							_htmlrow = _htmlrow + '</tr>';
						});
						$('#table-members').find('tbody').append(_htmlrow);
						message('Mensaje', data.Request.message);
						$('#modalDirectory').modal('hide');
						$('#btnDeleteUsers').addClass('hide');
					} else {
						message('Mensaje', data.Request.message);
					}
          		}, 
          		dataType: 'json',
        	});
		});	



</script>