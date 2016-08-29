$.extend(CE.formats, {
	init: function(){
		// buscar la categoria de la comunicacion dependiendo del tipo
		$('#message-type').on('change', function(event) {
			event.preventDefault();
			var communicationTypeId = $(this).val();

			var _htmlOption = function (data) {
				return '<option value=';
			};
			
			$.ajax({
          		url: WEBROOT + 'communicationCategories/findByCommunicationTypeId/' + communicationTypeId,
          		type: 'post',
          		success: function(data){
          			var _html = '<option value="">Seleccione</option>';
          			$.each(data, function(index, val) {
          				_html = _html + '<option value="'+index+'">' + val + '</option>';
          			});
          			$('#message-category').html(_html);
          		}, 
          		dataType: 'json',
        	});
		});

		// control sobre los archivos
		$('.btn-fileup').on('click', function(){
	      	$('.btn-fileup-h').click();
	    });

	    $('#isDocument').val('1');

		$('.btn-fileup-h').on('change',function(event) {
			setTimeout(function(){
				$.each($('.table-documents tr'), function(index, tr) {
					var dT = new Date();
					var dateT = dT.getDate()+''+(dT.getMonth()+1)+''+dT.getFullYear()+''+dT.getHours()+''+dT.getMinutes()+''+dT.getSeconds();
					$('#description').val(dateT);
					$('#inf-format').attr('data-desc-upload', dateT);
					$('.btn-subir').click();
					$('.btn-fileup').hide();
				});
			},500);
		});

		$(document).on('click', '.btn-subir', function(event) {
			event.preventDefault();
			$('td.start').find('button').click();
		});

		// al presionar sobre eliminar un formato, mostrar la opcion de subir de nuevo
		$(document).on('click', '.btn-prueba', function(event) {
			event.preventDefault();
			$('.btn-fileup').show();
		});

		$('.btn-fileup-h').removeAttr('multiple');
	    $('.btn-fileup-h').attr('name', 'files');
	},
	index: function(){
		$(document).on('click', '[type="checkbox"] ', function(event) {
			_tr = $(this).parents('tr:first');
			_this = $(this);
			if ($(this).attr('checked')){
				$(this).removeAttr('checked');
			} else {
				$(this).attr('checked', 'checked');
			}
			var visible = $(this).attr('checked') ? '1' : '0';
			var doc = {
				id: $(this).parents('tr:first').attr('data-document-id'),
				visible: visible
			}
			$.ajax({
          		url: WEBROOT + 'formats/updateVisible/',
          		type: 'post',
          		data: doc,
          		success: function(data){
          			if (data['Request']['status'] == 200){
          				//
          			}
          			else {
          				m_error(data['Request']['message']);
          				$(_this).click();
          			}
          		}, 
          		dataType: 'json',
        	});
		});
	},
	add: function() {
	    // validar campos
	    $('#addFormat').on('click', function(event) {
	    	event.preventDefault();
	    	if ($('.btn-fileup').is(':visible')){
	    		m_error('Debe seleccionar el archivo');
	    		return false;
	    	}
	    	var name = $('#FormatName').val();
	    	var entity_id = $('#entity_id').val();
	    	var type = $('#message-type').val();
	    	var category = $('#message-category').val();
	    	var active = $('#formatVisible').val();
	    	var descUpload = $('#inf-format').attr('data-desc-upload')
	    	if (!name || ! category || !type || !active){
	    		m_error('Debe llenar todos los datos');
	    		return false;
	    	}
	    	var data = {
	    		name: name,
	    		communication_type_id: type,
	    		communication_category_id: category,
	    		visible: active,
	    		entity_id: entity_id,
	    		desc_upload: descUpload
	    	}
	    	$.ajax({
          		url: WEBROOT + 'formats/add/',
          		data: data,
          		type: 'post',
          		success: function(data){
          			if (data['Request']['status'] == 200){
						window.location = WEBROOT + 'formats/';
          			}
          			else {
          				m_error(data['Request']['message']);
          			}
          		}, 
          		dataType: 'json',
        	});
	    	
	    });
	},
	edit: function() {
	    
	    $('.in-edit').css('text-align','start');
		$('.btn-fileup').hide();
		$('#delete-prev-upload').on('click', function(event) {
			event.preventDefault();
			$('#prev-upload').fadeOut('fast', function () {
				$('.btn-fileup').show();
			});
		});

		$('#editFormat').on('click', function(event) {
	    	event.preventDefault();
	    	if ($('.btn-fileup').is(':visible')){
	    		m_error('Debe seleccionar el archivo');
	    		return false;
	    	}

	    	var id = $('#FormatId').val();
	    	var name = $('#FormatName').val();
	    	var type = $('#message-type').val();
	    	var category = $('#message-category').val();
	    	var active = $('#formatVisible').val();
	    	var descUpload = $('#inf-format').attr('data-desc-upload')
	    	if (!name || ! category || !type || !active){
	    		m_error('Debe llenar todos los datos');
	    		return false;
	    	}
	    	var data = {
	    		id: id,
	    		name: name,
	    		communication_type_id: type,
	    		communication_category_id: category,
	    		visible: active, 
	    		desc_upload: descUpload
	    	}
	    	$.ajax({
          		url: WEBROOT + 'formats/edit/'+id,
          		data: data,
          		type: 'post',
          		success: function(data){
          			if (data['Request']['status'] == 200){
						window.location = WEBROOT + 'formats/';
          			}
          			else {
          				m_error(data['Request']['message']);
          			}
          		}, 
          		dataType: 'json',
        	});
	    	
	    });
	}
});