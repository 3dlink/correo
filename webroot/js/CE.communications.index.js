$.extend(CE.communications, {
	index: function() {

		var _htmlNewMessage = function (data) {

			var read = (data.Communication.read)? ' ': 'message-unread';
			
			var html = '<div class="message-item '+read+'" data-communication-id="'+data.Communication.id+'">';
			html = html + '<label class="inline">';
			html = html + '<input type="checkbox" class="ace">';
			html = html + '<span class="lbl"></span>';
			html = html + '</label>';
			if (data.Communication.is_update) {
				html = html + '<i class="message-star icon-circle orange2 c-interaction"></i>';
			}
			else {
				html = html + '<i class="message-star icon-circle orange2 hide c-interaction"></i>';
				html = html + '<span class="c-no-interaction" style="width:23px; display:inline-block;">&nbsp;</span>';
			}
			html = html + '<span class="sender view-cmt" title="'+data.SenderEntity.name+'"><small>'+data.SenderEntity.name+'</small></span>';
			html = html + '<span class="summary view-cmt">';
			html = html + '<span class="text">'+data.Message.title+'</span>';
			html = html + '</span>';
			html = html + '<span class="times pull-right pretty-date-date" data-date="'+data.Trace.created+'"><span class="email-date"><span></span>';
			html = html + '</div>';
			return html;
		}

		$('[data-rel=popover]').popover({html:true});

		// checkbos de seleccionar todas las comunicaciones
		$('#select-all-communications').on('click', function(event) {
			if ($(this).is(':checked')) {
		        $('.check-communication').each(function() {
		            this.checked = true;
		            $('#btn-delete-communications').show();  
					var opc = $.getParam('trash') ? 1 : 0;
					if (opc) {
		            	$('#btn-restore-communications').show();  
					}
		        });
		    }
		    else {
		    	$('.check-communication').each(function() {
		            this.checked = false;                        
		            $('#btn-delete-communications').hide();                        
		            $('#btn-restore-communications').hide();                        
		        });
		    }
		});

		// checkbox de comunicaciones indivisuales
		$('.check-communication').on('click', function(event) {
		    var opc = $.getParam('trash') ? 1 : 0;
			if ($(this).is(':checked')) {
		        $('#btn-delete-communications').show(); 
				if (opc) {
	            	$('#btn-restore-communications').show();  
				}                       
		    }
		    else {
		    	var ch = $('.check-communication:checked');
		    	if (ch.length) {
		    		$('#btn-delete-communications').show();
		    		if (opc) {
		            	$('#btn-restore-communications').show();  
					}
		    	}
		    	else {
		    		$('#btn-delete-communications').hide();
		    		$('#btn-restore-communications').hide();
		    	}
		    }
		});

		// eliminar communication
		$('.set-trash-communications').on('click', function(event) {
			event.preventDefault();
			// si estoy en trash eliminar por completo, si no enviar a trash
			var isDelete = $(this).attr('data-trash');
			isDelete = (isDelete == 'delete') ? 1 : 0;

			if (isDelete==1) 
				var opc = $.getParam('trash') ? 2 : 1;
			else 
				var opc = 0;

			var ids = [];

			// agrupo los ids
			$('.check-communication:checked').each(function() {
				var id = $(this).parents('div.message-item').attr('data-communication-id');
		        ids.push(id);
		    });
			var inf = {
				'ids': ids,
				'trash': opc,
			}
			$.ajax({
          		url: WEBROOT + 'communications/setTrash/',
          		type: 'post',
          		data: inf,
          		success: function(data){
          			if (data.Request.status == 200){
	          			$.each(data.data, function(index, id) {
	          				$('.check-communication').parents('div.message-item[data-communication-id="'+id+'"]').fadeOut('fast');
	          			});
				        message('Mensaje', data['Request']['message']);
          			}
          			else {
          				m_error(data['Request']['message']);
          			}
			        $('#btn-delete-communications').hide();                        
	            	$('#btn-restore-communications').hide();
          		}, 
          		dataType: 'json',
        	});
			
		});

		// efecto de colocar el mouse sobre el campo de busqueda para que aparezca el texto de ayuda
		$('#search-communications').mouseenter( function(){
			$('#help-find-text').removeClass('hide');
		}).mouseleave(function(){
			$('#help-find-text').addClass('hide');
		});

		// ver el detalle de una comunicacion
		$('.view-cmt').on('click', function(event) {
			event.preventDefault();
			_this = this;
			var opc = $.getParam('trash') ? '?trash' : '';
			var draft = $('#message-list').attr('data-communication-draft');
			var idCommunication = $(this).parent().attr('data-communication-id');
			if (draft == 1) window.location = WEBROOT + 'communications/draft/' + idCommunication;
			else window.location = WEBROOT + 'communications/view/' + idCommunication + opc;
		});


		(function notificationInteractions() {
	        var datos = [];
			$.each($('#message-list .message-item'), function(index, message) {
				var id = $(message).attr('data-communication-id');
				datos.push(id);
			});

			var ca = {
				'ids': datos,
			}

			$.ajax({
          		url: WEBROOT + 'communications/getNewInteractions/',
          		type: 'post',
          		data: ca,
          		success: function(data){
          			$.each(data, function(index, com) {
          				if (com.has_interaction) {
          					id = com.id;
          					$('.message-item[data-communication-id="'+id+'"] ').find('.c-no-interaction').addClass('hide');
          					$('.message-item[data-communication-id="'+id+'"] ').find('.c-interaction').removeClass('hide');
          				}
          			});
          		}, 
          		dataType: 'json',
          		complete: setTimeout(function() {notificationInteractions()}, 5000),
            	timeout: 2000

        	});
	    })();
	}
});	