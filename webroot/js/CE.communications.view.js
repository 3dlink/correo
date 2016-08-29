$.extend(CE.communications, {
	addTag: function(value){
		var name = value;
    	var id = '';
	    if (value.match('--')){
		    var str = value.split('--');
		    id = str[0];
		    name = str[1];
	    }
	    var communicationId = $('#communication').data('communication-id');
	    var userId = $('body').data('user-id');
	    var tag = {
	    	'user_id': userId,
	    	'name': name,
	    	'communication_id': communicationId
	    }
	    var rTag = '';
	    // esta linea se coloco para saber si el tag se esta agregando
	    // desde una nueva comunicaion
	    if (!communicationId) return false;
	    $.ajax({
			url: WEBROOT + 'tags/add/',
			type: 'post',
			data: tag,
			success: function(data){
				if (data['Request']['status'] == 200){
					rTag = data.Tag;
				}
				else {
					m_error(data['Request']['message']);
				}
			}, 
			dataType: 'json',
			async: false,
			error: function(c,v){
				c(c);
				c(v);
			}
		});
	    return rTag;
	},
	view: function() {

		var _htmlComment = function(data){
			var html = '<div class="timeline-items" style="display:none">';
			html = html + '<div class="timeline-item clearfix">';
			html = html + '<div class="timeline-info pretty-date-date" data-date="'+data.Message.created+'">';
			html = html + '<div class="timeline-info-date">';
			html = html + '<span class="day"></span>';
			html = html + '<span class="month"></span>';
			html = html + '<span class="year"></span>';
			html = html + '</div>';
			html = html + '</div>';
			html = html + '<div class="widget-box transparent collapsed';
			if (data.approve == '-1') html = html + ' border-reject';
			else if (data.approve == '1') html = html + ' border-approve';
			else if (data.approve == '2') html = html + ' border-modify';
			html = html + '">';
			html = html + '<div class="widget-header widget-header-small">';
			html = html + '<h5 class="smaller">';
			html = html + '<span class="grey"><strong>De </strong>'+data.UserSender.first_name+' '+data.UserSender.last_name+'</span>';
			html = html + '</h5>';
			// to
			html = html + '<h5 class="smaller" style="margin:0px;">';
			html = html + '<span class="grey"><strong>Para </strong>';
			var hasCC = false;
			$.each(data.UserReceivers, function(index, entity) {
				if (entity.type_delivery == '0'){
					position = entity.position ? entity.position : ' ';
					html = html + '<span style="margin-right:2px;" class="label" data-rel="tooltip" data-placement="top" title="" data-original-title="'+data.EntitiesReceivers[entity.entity_id].name +' - '+ position +'">'+entity.first_name+' '+entity.last_name+'&nbsp;<span data-placement="bottom" data-rel="tooltip" data-original-title="No lo ha leído" ><i class="icon-time bigger-120"></i></span></span>&nbsp;';
				} else {
					hasCC = true;
				}
			});
			html = html + '</span>';
			html = html + '</h5>';
			// cc
			if (hasCC){
				html = html + '<h5 class="smaller" style="margin:0px; margin-top:5px;">';
				html = html + '<span class="grey"><strong>C.C. </strong>';
				$.each(data.UserReceivers, function(index, entity) {
					if (entity.type_delivery == '1'){
						position = entity.position ? entity.position : ' ';
						html = html + '<span style="margin-right:2px;" class="label" data-rel="tooltip" data-placement="top" title="" data-original-title="'+data.EntitiesReceivers[entity.entity_id].name +' - '+position+'">'+entity.first_name+' '+entity.last_name+'&nbsp;<span data-placement="bottom" data-rel="tooltip" data-original-title="No lo ha leído" ><i class="icon-time bigger-120"></i></span></span>&nbsp;';
					}
				});
				html = html + '</span>';
				html = html + '</h5>';
			}

			html = html + '<span class="widget-toolbar no-border">';
			html = html + '<i class="icon-time bigger-110"></i>';
			html = html + '<span class="pretty-date-date" data-date="'+data.Message.created+'"><span class="hour"></span></span>';
			html = html + '</span>';
			html = html + '<span class="widget-toolbar">';
				html = html + '<a href="#" data-action="collapse">';
				html = html + '<i class="icon-chevron-down"></i>';
				html = html + '</a>';
			html = html + '</span>';
			html = html + '</div>';
			html = html + '<div class="widget-body">';
				html = html + '<div class="widget-body-inner" style="display: none;">';
					html = html + '<div class="widget-main" style="padding:2px;" >';
						html = html + '<div style="background-color:#ffffff; padding:5px;">' + data.Message.content + '</div>';
						html = html + '<div class="space-6"></div>';
						html = html + '<div class="hr hr-double"></div>';
						if (data.Uploads.length > 0) { 
							html = html + '<div class="widget-toolbox clearfix">';
							html = html + '<div class="attachment-title">';
							html = html + '<span class="blue bolder bigger-110">Adjuntos</span>';
							html = html + '</div>';
							html = html + '<ul class="attachment-list pull-left list-unstyled">';
							$.each(data.Uploads, function(index, upload) {
								html = html + '<li>';
								html = html + '<a target="_blank" href="'+upload.Upload.url+'" class="attached-file inline" title="'+upload.Upload.real_name+'">';
								html = html + '<i class="icon-file-alt bigger-110 middle"></i>';
								html = html + '<span class="attached-name middle">'+upload.Upload.real_name+'</span>';
								html = html + '</a>';
								html = html + '<div class="action-buttons inline">';
								html = html + '<a href="'+WEBROOT+'communications/download/'+ upload.Upload.name+'" title="Descargar" target="_blank">';
								html = html + '<i class="icon-download-alt bigger-125 blue"></i>';
								html = html + '</a>';
								html = html + '</div>';
								html = html + '</li>';
							});
							html = html + '</ul>';
							html = html + '</div>';
						}
					html = html + '</div>';
				html = html + '</div>';
				if (data.approve != 0) {
					html = html + '<div class="text-center white ';
					if (data.approve == '-1') html = html + ' label-reject ';
					else if (data.approve == '1') html = html + ' label-approve ';
					else if (data.approve == '2') html = html + ' label-modify ';
					html = html + '"> ';
					html = html + '<strong>';
					if (data.approve == '-1') html = html + ' Rechazado ';
					else if (data.approve == '1') html = html + ' Aprobado ';
					else if (data.approve == '2') html = html + ' Modificar ';
					html = html + '</strong>';
				}
			html = html + '</div>';
			html = html + '</div>';
			html = html + '</div>';
			html = html + '</div>';
			return html;			
		};

		var htmlContentUsers = $('#content-receivers').clone();
		var htmlContentUsersReply = $('#content-receivers').clone();
		var replyAll = 0;

		$('[data-rel=popover]').popover({html:true});

		$('.icon-chevron-down').on('click',function(event){
			event.preventDefault();
		});

		$('#cancelReplyCommunication').on('click', function(event) {
			event.preventDefault();
			var _this = this;
			$(_this).addClass('hide');
			$('#contentReplyCommunication').addClass('hide');
			$('#opcCommunications').removeClass('hide');
		});

		$('#replyCommunication').on('click', function(event) {
			replyAll = 0;
			event.preventDefault();
			var _this = this;
			console.log($(htmlContentUsers).html());
			 $('#content-receivers').html($(htmlContentUsers).html());
			// //$('#content-receivers-cc').html($(htmlContentUsers).html());
			// //$('#content-receivers').find('span[data-owner="0"]').remove();
			$('#opcCommunications').addClass('hide');
			$('#content-tags-receivers-cc').addClass('hide');
			$('#contentReplyCommunication').removeClass('hide');
			$('#cancelReplyCommunication').removeClass('hide');
		});

		$('#replyAllCommunication').on('click', function(event) {
			replyAll = 1;
			event.preventDefault();
			var _this = this;
			$('#content-receivers').html($(htmlContentUsers).html());
			$('#opcCommunications').addClass('hide');
			$('#contentReplyCommunication').removeClass('hide');
			$('#content-tags-receivers-cc').removeClass('hide');
			$('#cancelReplyCommunication').removeClass('hide');
		});

		$('#forwardCommunication').on('click', function(event) {
			event.preventDefault();
			var _this = this;
			//$('#content-receivers').html($(htmlContentUsers).html());
			$('#opcCommunications').addClass('hide');
			$('#contentForwardCommunication').removeClass('hide');
			$('#cancelReplyCommunication').removeClass('hide');
		});

		CE.communications.addcommon();
		$('.wysiwyg-speech-input').hide();

		$('[data-rel=tooltip]').tooltip();

		// al enviar el mensaje
		$('#btn-send-message').on('click', function(event) {
			event.preventDefault();
			__sendComunication(false);
		});

		$('.btn-file-sign').on('click', function(){
			//appletFirma();
			//certificateCommunication();
		  
		    if ($('.attachment-list').length == 0 && $('.name').length == 0) {
		        m_error('Debe haber al menos un adjunto para poder enviar y firmar');
		    }
		   
            else{
            
		   
		    $.ajax({
                url: WEBROOT + 'communications/thisBeingSigned/'+ $("#communication").data("communication-id"),
                type: 'post',
                //data: communication,
                success: function(data){
                    if(data == 0){
                        __sendComunication(true);
                      }
                      else{
                          
                          m_error('Hay una Persona Actualmente Firmando esta Comunicacion Intente mas Tarde'); 
                      }
                 }
		    });
		    
		    
            }
		   
	    });
		
			
		var __sendComunication =  function (certificated){
			
			var _btn = $('#btn-send-message');
			var btnHtml = $(_btn).html();
			if ($(_btn).attr('disabled')) return false;
			$(_btn).html('Enviando...');
			$(_btn).attr('disabled', 'disabled');
			$('.btn-fileup').hide();
			//$('.btn-file-sign').hide();
			$('.btn-file-sign').addClass('disabled');
			var receivers = [];
			var files = [];
			var error = false;
			if ($('#content-receivers > span').length < 1){
				m_error('Debe indicar a quien o quienes va dirigido la comunicación');
				$(_btn).html(btnHtml);
				$(_btn).removeAttr('disabled');
				$('.btn-fileup').show();
				//$('.btn-file-sign').show();
				$('.btn-file-sign').removeClass('disabled');
				return false;
			}

			// determinar si se requiere de aprobacion
			var approvalAnswer = '0';
			var requireApproval = $('#contentReplyCommunication').attr('data-requires-approval');
			if (requireApproval == '1') {
				approvalAnswer = $("input[name='RApproval']:checked").val();
				if (!approvalAnswer) {
					m_error('Debe indicar si aprueba o rechaza la acción');
					$(_btn).html(btnHtml);
					$(_btn).removeAttr('disabled');
					$('.btn-fileup').show();
					//$('.btn-file-sign').show();
					$('.btn-file-sign').removeClass('disabled');
					return false;
				}
			}
			
			var asistencia = '';
			//si la comunicacion requiere confirmacion de asistencia
			if($("#asistenciaH").val() == 5){
            asistencia = $("input[name='asistencia']:checked").val();
            
            if(asistencia == 0 || asistencia == 1){
               
            }
            else{
                
                m_error('Debe indicar si confirma o no la asistencia');
                $(_btn).html(btnHtml);
                $(_btn).removeAttr('disabled');
                $('.btn-fileup').show();
                //$('.btn-file-sign').show();
                $('.btn-file-sign').removeClass('disabled');
                return false;
            }
			}
			// creo una lista con los ids
			$.each($('.files tr'), function(index, file) {
				var idFile = $(file).attr('data-file-id');
				files.push(idFile);
			});

			var nameGroup = [];

			// creo la lista con quien recibe la comunicacion
			$.each($('#content-receivers .myTag'), function(index, receiver) {
				console.log(receiver);
				var idsGroup = []; 
				if($(receiver).hasClass('more')){
					$.each($(receiver).find('option'), function(k,v){
						if(k != 0){
							var r = {
								id: $(v).attr('data-id'),
								type: $(v).attr('data-type'),
								deliverytype: 'to',
							};
							receivers.push(r);
							idsGroup.push($(v).attr('data-id'));	
							}
						else{
							nameGroup.push($(v).text());
						}
					});
					nameGroup.push(idsGroup);
				}
				else{
					var r = {
						id: $(receiver).attr('data-id'),
						type: $(receiver).attr('data-type'),
						deliverytype: 'to',
					};
					receivers.push(r);
				}
			});

			// creo la lista con quien recibe la comunicacion con CC

		if(replyAll == 1){
			$.each($('#content-receivers-cc .myTag'), function(index, receiver) {
				if($(receiver).hasClass('more')){
					$.each($(receiver).find('option'), function(k,v){
						if(k != 0){
							var r = {
								id: $(receiver).attr('data-id'),
								type: $(receiver).attr('data-type'),
								deliverytype: 'cc',
							};
							receivers.push(r);
						}
					});
				}
				else{
					var r = {
						id: $(receiver).attr('data-id'),
						type: $(receiver).attr('data-type'),
						deliverytype: 'cc',
					};
					receivers.push(r);
				}
			});
		}

			var idCommunication = $('#communication').attr('data-communication-id');

			// chequear si es privado
			var m_private = 0;
			if ($('#id-private-message').is(':checked')) m_private = 1;

			var communication = {
				user_id: $('body').attr('data-user-id'),
				entity_id: $('body').attr('data-user-entity-id'),
				title: $('#message-title').val(),
				content: $('#message-content').html(),
				receivers: receivers,
				files: files,
				temporal_id: $('#txtIdMessage').val(),
				communication_id: idCommunication,
				message_private: m_private,
				approval: approvalAnswer,
				fileReplace: $('#namefile').val(),
				file_number: $('#numberfile').val(),
				nameGroup:nameGroup,
				asistencia : asistencia 

			}

			$.ajax({
          		url: WEBROOT + 'communications/reply/'+ idCommunication,
          		type: 'post',
          		data: communication,
          		success: function(data){
          		    
          			if(!certificated){
      					location.reload(true);
      				}
          			
          			if (data['Request']['status'] == 200){

          				if(certificated){
          					//alert(data['Messages']);
          					$.each(data['Messages'],function(k,value){
                  				certificateCommunication2(value['Message']['id'],data['Communication']['id']);
          						
          					});
          				}
          				
          				$('#contentReplyCommunication').hide();
          				$('#cancelReplyCommunication').hide();
          				var html = '';
          				$.each(data.Messages, function(index, val) {
          					html = html + _htmlComment(val);
          				});

          				$('#communication').find('.timeline-label:first').after(html);
          				$('#communication').find('.timeline-items:first').fadeIn('fast', function() {
          					
          				});
          				
          				prettydate();
   						execTooltipe();

						if (requireApproval == '1') {
							if (approvalAnswer == '1') {
								ans = parseInt($('.apr-apr').html());
								$('.apr-apr').html(ans + 1);
								usr = $('body').attr('data-user-name');
								c(usr);
								c($('.timeline-label .apr-apr').attr('data-original-title'));
								$('.timeline-label .apr-apr').attr('data-original-title', $('.timeline-label .apr-apr').attr('data-original-title') + ' - ' + usr);
								c($('.timeline-label .apr-apr').attr('data-original-title'));
							}
							if (approvalAnswer == '-1') {
								ans = parseInt($('.apr-rej').html());
								$('.apr-rej').html(ans + 1);
								usr = $('body').attr('data-user-name');
								$('.apr-rej').attr('data-original-title', $('.apr-rej').attr('data-original-title') + ' - ' + usr);
							}
							if (approvalAnswer == '2') {
								ans = parseInt($('.apr-mod').html());
								$('.apr-mod').html(ans + 1);
								usr = $('body').attr('data-user-name');
								$('.apr-mod').attr('data-original-title', $('.apr-mod').attr('data-original-title') + ' - ' + usr);
							}
							ans = parseInt($('.apr-none').html());
							$('.apr-none').html(ans-1);
						}


          				//message('Mensaje', data['Request']['message']);
						//window.location = WEBROOT + 'communications/';
          			}
          			else {
          				m_error(data['Request']['message']);
          				$.each($('.files tr'), function(index, tr) {
          					$(tr).find('.delete button').click();
          				});
          				$(_btn).html(btnHtml);
						$(_btn).removeAttr('disabled');
						$('.btn-fileup').show();
						//$('.btn-file-sign').show();
						$('.btn-file-sign').removeClass('disabled');
          			}
          		}, 
          		dataType: 'json',
          		complete: function(){
					//$(_this).parents('li:first').find('.i-load').addClass('hide');
          		}
        	});
		};
	
		var userId = $('body').data('user-id');

		var tag_input = $('#pruebados');
		if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) ) {
			tag_input.tag({
				placeholder:tag_input.attr('placeholder'),
				//enable typeahead by specifying the source array
				source: function(query, process){
	                $.post(WEBROOT + 'tags/findTags',{q:query, user_id:userId},function(data) {
	                    process ($.map(data, function(item) {
	                        var name = item.Tag.id+'--'+item.Tag.name;
	                        return name; 
	                    }));
	                },'json');
	                this.highlighter= function(item){
	                    var elemento = item.split('--');
	                    var id = elemento[0];
	                    var name = elemento[1];
	                    var type = elemento[2];
	                    var path = elemento[3];
	                    var html = '<div class="box-hl" data-id="'+id+'">';
	                    html = html + '<div class="box-hl-content">';
	                    html = html + '<div class="bx-name">' + name + '</div>';
	                    html = html + '</div>';
	                    html = html + '</div>';
	                    return html
	                }
                } ,
			});
		}
		else {
			//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
			tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
			//$('#form-field-tags').autosize({append: "\n"});
		}

		var actionFile = '';
		var idFile = null;
		//Modal confirmaci�n de descarga y bloqueo de adjunto
		$(document).on('click','.file',function(event){
			// modal agregar formato
			event.preventDefault();

			actionFile = $(this).attr('href');
			idFile = $(this).attr('data-file-id');			
			var userId = $('#modalConfirmDownload').find('#idUser').text();
			
			var data = {
					file_id : idFile,
					user_id : userId		
			}
			
			
			$.ajax({
          		url: WEBROOT + 'communications/check_file/',
          		type: 'post',
          		data: data,
          		success: function(data){
          			if(data == 'Ok'){
          				//alert('Changed status file required signature!');
          				$('#modalConfirmDownload').modal('show');
          			}
          			else{
          				//alert('FAILED Changed status file required signature!');
          				$('#modalCustomMessage').find('.modal-body').html(data);
          				$('#modalCustomMessage').modal('show');          				
          			}
          		}, 
        	});
			
	
		});

		$(document).on('click','.linkFile',function(event){
			// modal previsualizar documentos
			event.preventDefault();
			//var pre = $(this).attr('href').split('/webroot');
			var pre = location.hostname;
			var aux = $(this).parent().find('.file').attr('href');
			var ext = aux.split('.')[1].split('/')[0]; 
			//var url = pre[0] + aux;			
			var url = pre + aux;			
			var titleFile = $(this).attr('data-original-title');
			
			$('#modalPreviewFile').find('.gdocsviewer').remove();
			$('#modalPreviewFile').find('.modal-title').html(titleFile);
			$('#modalPreviewFile').find('#linkFileModal').attr('href', url);
			$('#modalPreviewFile').find('#linkFileModal').gdocsViewer({width:'600',height:'700',ext:ext});
			$('#modalPreviewFile').find('.gdocsviewer').find('iframe').contents().find('#controlbarOpenInViewerButton').hide();
			$('#modalPreviewFile').modal('show');

			
		});		


		//cerrar modal, aceptar descarga
		$(document).on('click','#btn-download-confirm', function(event) {
			event.preventDefault();

			var userId = $('#modalConfirmDownload').find('#idUser').text();
			
			var data = {
					file_id : idFile,
					user_id : userId		
			}
			
			
			$.ajax({
          		url: WEBROOT + 'communications/block_file/',
          		type: 'post',
          		data: data,
          		success: function(data){
          			if(data == 'Ok'){
          				console.log('Changed status file to blocked!');
          				
          			}
          			else{
          				//alert('FAILED Changed status file required signature!');
          				console.log('Error: the file can\'t be blocked');          				
          			}
          		}, /*
          		dataType: 'json',*/
        	});

			$('#modalConfirmDownload').modal('hide');
			window.open(actionFile, '_blank');
			location.reload(true);
		});
		
		//cerrar modal, cancelar descarga
		$(document).on('click','#btn-download-cancel', function(event) {
			event.preventDefault();
			$('#modalConfirmDownload').modal('hide');
		});

		//cerrar modal mensaje personalizado
		$(document).on('click','#btn-custom-acept', function(event) {
			event.preventDefault();
			$('#modalCustomMessage').modal('hide');
		});

		// checkbox requiere firma
		$(document).on('click','.signature-check', function() {
			
			var id = $(this).parent().parent().attr('data-file-id');
			var signature = ($(this).is(':checked') ? 1 : 0);
			//alert('checking file');
			var data = {
					file_id : id,
					signature : signature
			}
			
			$.ajax({
          		url: WEBROOT + 'communications/add_required/',
          		type: 'post',
          		data: data,
          		success: function(data){
          			if(data == 'Ok'){
          				alert('Changed status file required signature!');
          			}
          			else{
          				alert('FAILED Changed status file required signature!');          				
          			}
          		}, 
          		dataType: 'json',
        	});
		});
		
		
		// eliminar tag
		$(document).on('click', '.tag .close', function(event) {
			event.preventDefault();
			_tag = this;
			var tagId = $(_tag).parent().data('id');
			$.ajax({
				url: WEBROOT + 'tags/delete/'+tagId,
				type: 'post',
				success: function(data){
					if (data['Request']['status'] != 200){
						m_error(data['Request']['message']);
					} else {
						$(_tag).parents('.tag').remove();
					}
				}, 
				dataType: 'json',
				async: false
			});
		});
	}
});	