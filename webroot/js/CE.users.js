$.extend(CE.users, {
	adduser: function() {
		var _htmlSelect = function (entities) {
			var html = '<div class="form-group">';
			html = html + '<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>';
			html = html + '<div class="col-sm-9">';
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
		$('#addUser').on('click', function(event) {

			event.preventDefault();
			var cleanAll = function(){
				$('#UserUsername').val('');
				
				$('#UserUserGroupId').find('option:first').attr('selected', 'selected');
				//$('#UserGroupiId').find('option:first').attr('selected', 'selected');

				$('#UserFirstName').val('');
				$('#UserLastName').val('');
				$('#UserEmail').val('');
				$('#signed').val('');
				
				$('#UserTelephone').val('');
				$('#UserCelphone').val('');
				$('#UserPosition').val('');
				$('#UserCpassword').val('');
				$('#UserPassword').val('');
				$('.selects-entity').find('.form-group:first').nextAll('.form-group').remove();
				$('.selects-entity .form-group:first').find('option:first').attr('selected', 'selected');
				$('#UserGroupId').find('option:first').attr('selected', 'selected');
			};
			var username = $('#UserUsername').val();
			var group = $('#UserUserGroupId').val();
			//var groupi = $('#UserGroupiId').val();
			var name = $('#UserFirstName').val();
			var lastName = $('#UserLastName').val();
			var email = $('#UserEmail').val();
			var password = $('#UserPassword').val();
			var cpassword = $('#UserCpassword').val();
			var signed = $('#signed').val();
			var telephone = $('#UserTelephone').val();
			var celphone = $('#UserCelphone').val();
			var position = $('#UserPosition').val();
			var script = 1;
			var entity = $('option.opt-entity:selected:last').val();
			var groupId = $('#UserGroupId').val();
			if (!username || !entity || entity==0 || !name || !lastName || !email || !password || !cpassword) {
				m_error('Debe llenar todos los campos');
				return false;
			}
			var MLetras = new RegExp("([A-Z])");//letras Mayusculas
			var mletras = new RegExp("([a-z])");//letras minusculas
			var numeros = new RegExp("([0-9])");//numeros
			var specials = new RegExp("([-#&@!?_.])");//caracteres especiales
			var valorP= $('#UserPassword').val();
			if(!(valorP.match(MLetras) && valorP.match(mletras) && valorP.match(numeros) && valorP.match(specials) && valorP.length >= 8 && valorP.length <= 15)){

				$('#UserPassword').addClass('inputErrorE');
				$('#UserPassword').focus();
				$('.validateErrorMsj').html('La contraseña debe cumplir los siguientes requisitos <br>'+
											'<ul>'+
												'<li>Debe contener al menos una letra mayúscula.</li>'+
												'<li>Debe contener al menos una letra minúscula.</li>'+
												'<li>Debe contener al menos un número o carácter especial (<b>- # & @ ! ? _ .</b>).</li>'+
												'<li>Su longitud debe contener como mínimo 8 caracteres.</li>'+
											'</ul>');
				$(".validateErrorMsj").show();
				setTimeout(function() {$(".validateErrorMsj").fadeOut();}, 8000);
				return false;
			}else{
				$('#UserPassword').removeClass('inputErrorE');
				// return true;
			}

			if (password != cpassword) {
				m_error('Las contraseñas no coinciden');
				return false;
			}

			var user = {
				script : script,
				username: username,
				user_group_id: group,
				first_name: name,
				last_name: lastName,
				email: email,
				password: password,
				cpassword: cpassword,
				entity_id: entity,
				celphone: celphone,
				telephone: telephone,
				group_id: groupId,
				signed:signed,
				position: position
			}
			$.ajax({
				url: WEBROOT + 'addUser/',
				type: 'post',
				data: user,
				success: function(data){
					if (data.Request.status == 300){
						m_error(data.Request.message);
						return false;
          			}
          			message(data.Request.message);
          			cleanAll();
          		}, 
          		dataType: 'json',
          		error: function(x,v){
          			c(x);
          			c(v);
          		}
        	});
		});
	},
	edituser: function(){
		var _htmlSelect = function (entities) {
			var html = '<div class="form-group">';
			html = html + '<label class="col-sm-3 control-label no-padding-right text-right" for="form-field-1">&nbsp;</label>';
			html = html + '<div class="col-sm-9">';
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

		$(document).on('change', 'select.s-entity', function () {
			_this = this;
			_opt = $(_this).find('option:selected');
			var hasChild = $(_opt).attr('data-child');
			var parentId = $(_opt).attr('value');
			$(_this).parents('.form-group:first').nextAll('.form-group').remove();
			if (hasChild){
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
		
		$('#editUser').on('click', function(event) {
			event.preventDefault();
			var userId = $('#UserEditUserForm').attr('data-user-id');
			var username = $('#username').val();
			var group = $('#user_group_id').val();
			var name = $('#first_name').val();
			var  signed = $('#signed').val();
			var lastName = $('#last_name').val();
			var email = $('#email').val();
			var telephone = $('#telephone').val();
			var celphone = $('#celphone').val();
			var position = $('#position').val();
			var entity = $('option.opt-entity:selected:last').val();
			var groupId = $('#group_id').val();
			var script = 1;
			//var groupi = $('#groupi_id').val();


			if (!username || !entity || entity==0 || !name || !lastName || !email) {
				m_error('Debe llenar todos los campos');
				return false;
			}
			
			var user = {
				script: script,
				id: userId,
				username: username,
				user_group_id: group,
				first_name: name,
				last_name: lastName,
				email: email,
				celphone: celphone,
				telephone: telephone,
				entity_id: entity,
				group_id: groupId,
				position: position,
				signed : signed,
				//groupi_id : groupi

			}

			$.ajax({
          		url: WEBROOT + 'editUser/' + userId,
          		type: 'post',
          		data: user,
          		success: function(data){
          			if (data.Request.status == 300){
          				m_error(data.Request.message);
          				return false;
          			}
          			var m = {
						flash: {
							message: data.Request.message,
							element: 'm_success',
							params: ''
						}
					}
          			window.location.href = WEBROOT + 'allUsers';
          		}, 
          		dataType: 'json',
          		error: function(x,v){
          			c(x);
          			c(v);
          		}
        	});
		});
	},
	index: function(){
		var filter = "";
		$('.status').click(function(){
			if($('.status').is(':checked')){
				filter = $(this).val();
				$('#searchUser').val('');
				filterUserByName($(this).val());
			}
		});

		var filterUserByName = function(text){
            $.each($('tbody tr'),function(){
                var name = $(this).find('.td-name').attr('data-user-name');
                var username = $(this).find('.td-username').attr('data-user-username');
                var entity = $(this).find('.td-entity').attr('data-entity-name');
                var group = $(this).find('.td-group').attr('data-group-name');
                
                var status = $(this).find('.td-state').attr('data-state-name');
                var rol = $(this).find('.td-rol').attr('data-rol-name');
                
                var firma = $(this).find('.td-firma').attr('data-signed');
              
               
                if (name || username || entity || group || status || rol) {
	                if (name.match(text) && status.match(filter)) $(this).fadeIn();
	                else if (username.match(text) && status.match(filter)) $(this).fadeIn();
	                else if (entity.match(text) && status.match(filter)) $(this).fadeIn();
	                else if (group.match(text) && status.match(filter)) $(this).fadeIn();
	                else if (rol.match(text) && status.match(filter)) $(this).fadeIn();	                
	                else if (status.match(text)) $(this).fadeIn();
	                else if (firma == 1 && filter == 3) $(this).fadeIn();
	                else if (firma == 0 && filter == 4) $(this).fadeIn();
	                else $(this).fadeOut();
                }
            })
        };
        var timer = 0;
		$('#searchUser').keyup(function(){
			clearTimeout(timer);
			timer = setTimeout(function(){
				var q = $('#searchUser').val();
				q = q.toLowerCase();
				filterUserByName(q);
			}, 250)
		});

		$('.btn-delete-user').on('click', function(event) {
			event.preventDefault();
			var _tr = $(this).parents('tr:first');
			var userId = $(this).attr('data-user-id');
			var data = {
				id: userId,
			}
			$.ajax({
      			url: WEBROOT + 'usermgmt/users/deleteUser/'+userId+'/',
      			type: 'post',
      			data: data,
      			success: function(data){
      				if (data.Request.status == 200) {
      					$(_tr).fadeOut('fast');
			        	message('Mensaje', data['Request']['message']);
      				}
      				else {
      					m_error(data['Request']['message']);
      				}
      			}, 
      			dataType: 'json'
    		});
		});

	},
	directory: function(){
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
			html = html +'<th>Nombre</th><th>Cargos</th><th>Email</th><th>Teléfono</th><th>Móvil</th><th>Entidad</th><th>Web</th><th>Posee Firma</th></tr></thead>';
			html = html + '<tbody>';
			$.each(data, function(index, val) {
				telephone = val.User.telephone ? val.User.telephone : ' ';
				celphone = val.User.celphone ? val.User.celphone : ' ';
				website = val.Entity.website ? val.Entity.website : ' ';
				html = html + '<tr class="nUser'+(index)+'" data-user-id="'+val.User.id+'">';
				html = html + '<td class="center"><label><input class="ace ckb" type="checkbox"><span class="lbl"></span></label></td>';
				html = html + '<td class="nUser">'+val.User.first_name+' '+val.User.last_name +'</td>';
				html = html + '<td>'+val.User.position+'</td>';
				html = html + '<td>'+val.User.email+'</td>';
				html = html + '<td>'+telephone+'</td>';
				html = html + '<td>'+celphone+'</td>';
				html = html + '<td>'+val.path+'</td>';
				if (website != ' ')	html = html + '<td><a href="'+website+'" target="_blank"> Ver </a></td>';
				else html = html + '<td>&nbsp;</td>';
				if(val.User.signed == 1)html = html + '<td>Si</td>';
				else html = html + '<td>No</td>';
			});
			html = html + '</tbody>';
			return html;
		}

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

		$("#searchName").keyup(function(e) {
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

		// btn para buscar a todos los usuarios que estan bajo una entidad
		$('#btn-find-by-entity').on('click', function() {
			event.preventDefault();
			var entity = $('option.opt-entity:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'entities/findAllPeople/'+entity+'/',
      			type: 'get',
      			dataType: 'json',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#searchName').css('display','block');
      				$('#table-2').html(_html);
      				$('#count2').html('<span style="background-color:orange !important;" class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');

      			}
    		});
		});	

		// btn para buscar a todos los usuarios que estan bajo una entidad
		$('#btn-find-by-group').on('click', function() {
			event.preventDefault();
			var group = $('option.opt-group:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'groups/findPeopleByGoup/'+group+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#table-3').html(_html);
      				$('#count3').html('<span style="background-color:orange !important;" class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');

      			}, 
      			dataType: 'json',
    		});
		});	

		$('#btn-find-by-groupi').on('click', function() {
			event.preventDefault();
			var group = $('option.opt-groupi:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'groups/findPeopleByGoup/'+group+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#table-3i').html(_html);
      				$('#count3i').html('<span style="background-color:orange !important;" class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');

      			}, 
      			dataType: 'json',
    		});
		});	

		// btn para buscar a todos los usuarios que estan bajo una entidad
		$('#btn-find-by-circle').on('click', function() {
			event.preventDefault();
			var circle = $('option.opt-circle:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'circles/findPeopleByCircle/'+circle+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#table-4').html(_html);
      				$('#count4').html('<span style="background-color:orange !important;" class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');

      			}, 
      			dataType: 'json',
    		});
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
			if (active) $('.spn-send-msg').removeClass('hide');
			else $('.spn-send-msg').addClass('hide');
		});

		$('.btn-send-msg').on('click', function(event) {
			event.preventDefault();
			var arr = [];
			var txt = '?';
			$("input[type=checkbox]:checked").each(function(){
				if ($(this).attr('id') != 'checkbox-select-all') {
					var id = $(this).parents('tr:first').attr('data-user-id');
					if (id) arr.push(id);
					txt = txt + 'usrid[]=' + id + '&'
				}
			});
			location.href = WEBROOT + 'communications/add/' + txt;
		});		
	}
});