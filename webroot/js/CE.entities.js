$.extend(CE.entities, {
	index: function() {
		var ch=0;
		var _htmlEntityLI = function(entity) {

			if (typeof entity.people == 'undefined'){
				entity.people=0;
			}
			var child = entity.ChildEntity;
			var hasusers = entity.User;
			var allusers=entity.User;
			var hasVisibles = false;
			var userGroupId = $('body').attr('data-user-group-id');
			if (child != null )
				child = child.length;
			else 
				child = 0
			hasusers = hasusers.length;
			child = (child > 0) ? 1 : 0;
			hasusers = (hasusers > 0) ? 1 : 0;
			if (hasusers){
				$.each(entity.User, function(index, user) {
					if (user['active'] == 1){
						hasVisibles = true;
						return false;
					}
				});
			}
			var html = '<li class="Cchild'+ch+' dd-item dd2-item" data-id="'+entity.Entity.id+'" data-parent-id="'+entity.Entity.parent_id+'" data-children="'+child+'">'
			html = html + '<div class="dd2-content">';
			if (child){
				html = html + '<span class="i-plus-entity m-hover"><i class="icon-plus"></i>&nbsp;</span>';
				html = html + '<span class="i-minus-entity m-hover"><i class="icon-minus "></i>&nbsp;</span>';

			}
			html = html + '<span class="e-name">' + entity.Entity.name + "</span>";		
			
			html = html + '<i class="i-load hide icon-refresh icon-spin blue"></i>'
			if (userGroupId == '3') {
				html = html + '<i class="edit-entity pull-right bigger-130 icon-edit m-hover blue" title="Editar entidad"></i>';
			}

			if (userGroupId == '3' && ((entity.people==0))){
				html = html + '<span style="margin-left: 5px;" class="pull-right badge">'+entity.people+'<i class="pull-right icon-user" style="color:black;" title="Usuarios Activos"></i></span>';
				html = html + '<i class="delete-entity icon-trash pull-right bigger-130 m-hover red" title="Eliminar esta entidad y toda su decendencia"></i>';
				html = html + '<i class="new-entity pull-right bigger-130 icon-plus-sign-alt m-hover orange2" title="Agregar nueva entidad a '+entity.Entity.name+'"></i>';
			} else  if (userGroupId == '3') {
				html = html + '<span style="margin-left: 5px;" class="pull-right badge">'+entity.people+'<i class="pull-right icon-user" style="color:black;" title="Usuarios Activos"></i></span>';
				html = html + '<i class="delete-entity-w icon-trash pull-right bigger-130 m-hover orange2" title="Eliminar esta entidad y toda su decendencia"></i>';
				html = html + '<i class="new-entity pull-right bigger-130 icon-plus-sign-alt m-hover orange2" title="Agregar nueva entidad a '+entity.Entity.name+'"></i>';
			}
			if (userGroupId == '1') {
				html = html + '<span style="margin-left: 5px;" class="pull-right badge">'+entity.people+'<i class="pull-right icon-user" style="color:black;" title="Usuarios Activos"></i></span>';
			}

			html = html + '</div>';
			html = html + '</li>';
			return html;
		};

		var _htmlEntity = function(data) {

				if($('body').attr('data-user-group-id') == 3)
				{
					ch = ch + 1;
					var html = '<ol class="dd-list _'+ch+'" style="">';
				}
				else{
					var html = '<ol class="dd-list" style="">';
				}
			
			$.each(data, function(index, entity) {
				html = html + _htmlEntityLI(entity);
			});
			html = html + '</ol>';	
			return html;
		};
		// desplegar lista de entidades
		$(document).on('click', '.i-plus-entity', function(event) {
			_this = this;
			event.preventDefault();
			parentId = $(_this).parents('li').attr('data-parent-id');
			id = $(_this).parents('li').attr('data-id');
			if ($(_this).parents('li').attr('open')) {
				$(_this).hide();
          		$(_this).parent('.dd2-content').find('.i-minus-entity').show();
          		$(_this).parents('li:first').find('ol').show();
          		return false;
			}
			$(_this).parents('li:first').find('.i-load').removeClass('hide');
			$.ajax({
          		url: WEBROOT + 'entities/children/'+id+'/',
          		type: 'get',
          		success: function(data){
          			$(_this).parents('li').attr('open', 'true');
          			$(_this).hide();
          			$(_this).parent('.dd2-content').find('.i-minus-entity').show();
          			
          			
          			var content = _htmlEntity(data);
          			$(_this).parents('li[data-id="'+id+'"]').find('div.dd2-content').after(content);
          		}, 
          		dataType: 'json',
          		complete: function(){
					$(_this).parents('li:first').find('.i-load').addClass('hide');
          		}
        	});
		});
function countUser(datos){
	var arreglo=[];
          		for (var i = 0; i <= datos.length - 1; i++) {
          			//console.log(datos[i]['Entity']['id']);
					$.ajax({
		          		url: WEBROOT + 'entities/findAllPeople/'+datos[i]['Entity']['id']+'/',
		          		type: 'get',
		          		dataType: 'json',
		          		success: function(conten){
		          			arreglo[i] = conten.length;
		          			return (arreglo[i]);
		          		}, 
		          		error: function(param1, hola){
		          			return(0);
		          		},
		        	});	
				};

}
		// minimizar lista de entidades
		$(document).on('click', '.i-minus-entity', function(event) {
			_this = this;
			event.preventDefault();
			$(_this).hide();
          	$(_this).parent('.dd2-content').find('.i-plus-entity').show();
          	$(_this).parents('li:first').find('ol').hide();
		});
		// eliminar una entidad
		$(document).on('click', '.delete-entity-w', function(event) {
			event.preventDefault();
			_this = this;
			$('#modalNoDeleteEntity').modal('show');
		});

		$(document).on('click', '.delete-entity', function(event) {
			event.preventDefault();
			_this = this;
			var entityId = $(_this).parents('li:first').attr('data-id');
			bootbox.dialog({
				message: "<span class='bigger-110'>Si elimina esta entidad, todas las entidades descendentes también serán eliminadas. Desea continuar?</span>",
				buttons: 			
				{
					"success" :
					 {
						"label" : 'Si',
						"className" : "btn-sm btn-success",
						"callback": function(){
							$.ajax({
				          		url: WEBROOT + 'entities/delete/'+entityId,
				          		type: 'post',
				          		success: function(data){
				          			message('Mensaje', data['Request']['message']);
				          			$(_this).parents('li:first').remove();
				          		}, 
				          		dataType: 'json',
				        	});
						}
					}, 
					"button" :
					{
						"label" : 'No',
						"className" : "btn-sm"
					}
				}
			});
		});

		// levantar modal para nueva entidad
		$(document).on('click','.new-entity', function(event) {
			_this = this;
			event.preventDefault();
			var entityId = $(_this).parents('li:first').attr('data-id');
			if (!entityId) entityId = 1;
			$('#modalNewEntity').modal('show');
			$('#modalNewEntity').attr('data-entity-id', entityId);
			$('#modalNewEntity').find('#name').val('');
			$('#modalNewEntity').find('#description').val('');
			$('#modalNewEntity').find('#website').val('');

		});

		// levantar modal para editar entidad
		$(document).on('click','.edit-entity', function(event) {
			_this = this;
			event.preventDefault();
			var entityId = $(_this).parents('li:first').attr('data-id');
			if (!entityId) entityId = 1;
			$('#modalEditEntity').find('.btn-fileup').show();
			$('#modalEditEntity').find('.files').html('');
			$.ajax({
          		url: WEBROOT + 'entities/edit/' + entityId,
          		dataType: 'json',
          		type: 'get',
          		success: function(data){
					$('#modalEditEntity').attr('data-entity-id', entityId);
					$('#modalEditEntity').find('#editNameEntity').val(data.Entity.name);
					$('#modalEditEntity').find('#editDescriptionEntity').val(data.Entity.description);
					$('#modalEditEntity').find('#editWebsiteEntity').val(data.Entity.website);
					
					if(data.Entity.logo != null){
						$('#modalEditEntity').find('.btn-fileup').hide();
						$('#modalEditEntity').find('.files').html(__add_logo(data.Entity.logo));
					}
					
					if(data.Entity.parent_id == 1){
						$('.logo-entity-form').show();
					}else{
						$('.logo-entity-form').hide();
					}

					$('#modalEditEntity').modal('show');
          		}, 
        	});
        	$.ajax({
          		url: WEBROOT + 'entities/newParent',
          		dataType: 'json',
          		type: 'get',
          		success: function(data){
          			$('#ImYourFather').empty();
          			$('#ImYourFather').append('<option class="parent" id='+data[2]+'>'+data[3]+'</option>');
          				var parentSelect = $(".parent").attr('id');
          				if(data[0] != null){
        					for (var i = (data[0]).length - 1; i >= 0; i--) {
        						if (entityId != data[1][i] && data[1][i] != parentSelect) {
        							console.log(i);
        							$('#ImYourFather').append('<option id='+data[1][i]+'>'+data[0][i]+'</option>');
        						}
        					};
          				}
          		}, 
        	});
		});

		// guadar nueva enidad
		$('#btnSaveNewEntity').on('click', function(event) {
			event.preventDefault();
			_modal = $('#modalNewEntity');
			var entityId = $(_modal).attr('data-entity-id');
			var url = domainRegex = /[^w{3}\.]([a-zA-Z0-9]([a-zA-Z0-9\-]{0,65}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}/igm;
			var website = $(_modal).find('#website').val();
			var name = $(_modal).find('#name').val();
			if (!name) {
				m_error('Debe colocar el nombre de la entidad');
				return false;
			}
			if (!website.match(url)) {
				m_error('La direccion del sitio Web no es válido. No debe colocar la expresión "http://" ');
				return false;
			}
			var newEntity = {
				name: name,
				website: 'http://'+website,
				description: $(_modal).find('#description').val(),
				parent_id: entityId,
				active: 1
			};
			$.ajax({
          		url: WEBROOT + 'entities/add/',
          		type: 'post',
          		data: newEntity,
          		success: function(data){
          			$(_modal).modal('hide');
          			// Chequeo si tiene un ol
          			message('Mensaje', data['Request']['message']);
          			if (entityId==1) {
	          			var html = _htmlEntityLI(data);
          				$('#mainList').append(html);
          				return false;
          			}
	          		var ol = $('li[data-id="'+entityId+'"]').find('ol');
	          		ol = ol.length;
	          		// ya tiene ol
	          		if (ol > 0) {
	          			var html = _htmlEntityLI(data);
	          			$('li[data-id="'+entityId+'"]').find('.i-plus-entity:first').click();
	          			$('li[data-id="'+entityId+'"]').find('ol:first').append(html);
	          		}
	          		// no tiene ol
	          		else {
	          			var aux = {
	          				out: data,
	          			}
	          			var html = _htmlEntity(aux);
	          			var auxHtml = '<span class="i-plus-entity m-hover" style="display:none;"><i class="icon-plus"></i>&nbsp;</span>';
						auxHtml = auxHtml + '<span class="i-minus-entity m-hover" style="display:inline;"><i class="icon-minus "></i>&nbsp;</span>';
	          			$('li[data-id="'+entityId+'"]').find('div:first').prepend(auxHtml);
	          			$('li[data-id="'+entityId+'"]').append(html);
	          			$('li[data-id="'+entityId+'"]').attr('open', 'open');
	          		}

          		}, 
          		dataType: 'json',
        	});
		});

		// Editar entidad
		$('#btnSaveEditEntity').on('click', function(event) {
			event.preventDefault();
			_modal = $('#modalEditEntity');
			var entityId = $(_modal).attr('data-entity-id');
			var url = domainRegex = /[^w{3}\.]([a-zA-Z0-9]([a-zA-Z0-9\-]{0,65}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}/igm;
			var website = $(_modal).find('#editWebsiteEntity').val();
			var name = $(_modal).find('#editNameEntity').val();
			var logo = $('.files').find('.template-download').length > 0 ? $('.files').find('.name').find('img').attr('src') : '';
			
			if(logo != '') logo = logo.split("files/")[1];
			
			if($("#checkEntity").is(':checked')) {  
		         var Newfather = $('#ImYourFather :selected').attr('id');
		         var entity = {
						id: entityId,
						name: name,
						website: website,
						description: $(_modal).find('#editDescriptionEntity').val(),
						active: 1,
						logo: logo,
						parent_id: Newfather
					}
	        } else {  
	           		var entity = {
					id: entityId,
					name: name,
					website: website,
					description: $(_modal).find('#editDescriptionEntity').val(),
					active: 1,
					logo: logo
				}
	        }  
			if (!name) {
				m_error('Debe colocar el nombre de la entidad');
				return false;
			}
			if (!website.match(url)) {
				m_error('La direccion del sitio Web no es válido. No debe colocar la expresión "http://" ');
				return false;
			}
			$.ajax({
          		url: WEBROOT + 'entities/edit/',
          		type: 'post',
          		data: entity,
          		success: function(data){
          			location.reload();
          			$(_modal).modal('hide');
          			message('Mensaje', data['Request']['message']);
          			if (data.Request.status == '200'){
						$('li[data-id="'+entityId+'"]').find('span.e-name').html(name);
          			}
          		}, 
          		dataType: 'json',
        	});
		});
		
		function __add_logo(name){
			
			name_sample = WEBROOT+'webroot/files/'+name;
			
			return '<tr class="template-download fade in" data-file-id="294" style="height: 44px;">'+
				        '<td class="preview"></td>'+
			            '<td class="name">'+
			                '<img src="'+name_sample+'" title="" rel="" download="CASA DE PLAYA ASIA 04.jpg" style="width:60%;">'+
			            '</td>'+
			            '<td class="size" style="width:65px; display:none;"><span>&nbsp;&nbsp;<small>1.04 MB</small></span></td>'+
			            '<td colspan="2"></td>'+
			        
			        '<td class="delete" style="position:absolute;">'+
			            '<button class="btn btn-whites btn-prueba" data-type="DELETE" data-url="'+WEBROOT+'file_upload/handler?file='+name+'" style="margin-left:-165px; background-color: rgba(255, 255, 255, 0) !important;">'+
			                '<i class="icon-trash red bigger-130 middle"></i>'+
			                '<span class="hide">Delete</span>'+
			            '</button>'+
			            '<input class="hide" type="checkbox" name="delete" value="1">'+
			        '</td>'+
					'<td class="signature" style="display:none;">'+
			            '<input type="checkbox" name="signature[]" class="signature-check" value="1"> Requiere Firma'+
			        '</td>'+
			    '</tr>';
		}
		
	},
	add: function() {

	}
});