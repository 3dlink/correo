$.extend(CE.communications, {

	addcommon:function(){
		function showErrorAlert (reason, detail) {
			var msg='';
			if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
			else {
				console.log("error uploading file", reason, detail);
			}
			$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
			 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
		}

		var randomm = function(X) {
            return Math.floor(X * (Math.random() % 1));
        };

        var randomBetween = function(MinV, MaxV) {
        	r = randomm(MaxV - MinV + 1);
          	return MinV + r;
        };

        var ramdonString = function(){
        	var str = '';
	        for (i = 0; i < 4; i++) {
	        	str = str + randomBetween(10, 99);
		    }
		    return str;
        };

		var url = WEBROOT + 'communications/findUsersAndEntities'
		$('#prueba').tagsManager({
            preventSubmitOnEnter: true,
            typeahead: true,    
            typeaheadSource: function(query, process){
                $.post(url,{q:query},function(data) {
                    process ($.map(data, function(item) {
                        var name = item.id+'--'+item.name+'--'+item.type+'--'+item.path+'--to';
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
                    html = html + '<div class="bx-path">' + path + '</div>';
                    html = html + '</div>';
                    html = html + '</div>';
                    return html
                }
                this.updater = function (item) {
                	$('span[rel="tooltip"]').tooltip('show');               
                }
            },
        });

		$('#cc').tagsManager({
            preventSubmitOnEnter: true,
            typeahead: true,    
            typeaheadSource: function(query, process){
                $.post(url,{q:query},function(data) {
                    process ($.map(data, function(item) {
                        var name = item.id+'--'+item.name+'--'+item.type+'--'+item.path+'--cc';
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
                    html = html + '<div class="bx-path">' + path + '</div>';
                    html = html + '</div>';
                    html = html + '</div>';
                    return html
                }
                this.updater = function (item) {
                	$('span[rel="tooltip"]').tooltip('show');               
                }
            },
        });

		$('.btn-fileup').on('click', function(){
	      	$('.btn-fileup-h').click();
	    });

		
		$('#message-content').ace_wysiwyg({
			toolbar:
			[
				'font',
				null,
				'fontSize',
				null,
				{name:'bold', className:'btn-info'},
				{name:'italic', className:'btn-info'},
				{name:'strikethrough', className:'btn-info'},
				{name:'underline', className:'btn-info'},
				null,
				{name:'insertunorderedlist', className:'btn-success'},
				{name:'insertorderedlist', className:'btn-success'},
				{name:'outdent', className:'btn-purple'},
				{name:'indent', className:'btn-purple'},
				null,
				{name:'justifyleft', className:'btn-primary active'},
				{name:'justifycenter', className:'btn-primary'},
				{name:'justifyright', className:'btn-primary'},
				{name:'justifyfull', className:'btn-inverse'},
				null,
				{name:'createLink', className:'btn-pink'},
				{name:'unlink', className:'btn-pink'},
				null,
				null, //{name:'insertImage', className:'btn-success'},
				null,
				'foreColor',
				null,
				null, //{name:'undo', className:'btn-grey'},
				null//{name:'redo', className:'btn-grey'}
			],
			'wysiwyg': {
				fileUploadError: showErrorAlert
			}
		}).prev().addClass('wysiwyg-style2');

		$('[data-toggle="buttons"] .btn').on('click', function(e){
			var target = $(this).find('input[type=radio]');
			var which = parseInt(target.val());
			var toolbar = $('#message-content').prev().get(0);
			if(which == 1 || which == 2 || which == 3) {
				toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
				if(which == 1) $(toolbar).addClass('wysiwyg-style1');
				else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
			}
		});

		// creo un id ficticio mientras tanto 
		var idTemporalRamdon = ramdonString();
        $('#txtIdMessage').val(idTemporalRamdon);

        // detectar cuando un se ha cargado un elemento
		$('.btn-fileup-h').on('change',function(event) {
		    if(click == 1){
		        $('#btn-send-message').prop( "disabled", true ); 
		        $('.signing-file').attr( "disabled", "disabled" );
		        $('.btn-info').attr("style", "background-color: #A1CEEB!important; border-color: #A1CEEB;");
		        
		    }
			setTimeout(function(){
				$.each($('.table-documents tr'), function(index, tr) {
					$(tr).find('td .btn-start-preupload').click();
					
				});
			},500);
		});


		// eliminar un rec
		$(document).on('click', '.myTagRemover', function(event) {
			var traceId = $(this).attr('data-trace-id');
			if (traceId){
				var communicationId = $('#communication').attr('data-communication-id');
				var userId = $(this).parents('.myTag:first').attr('data-id');
				var data =  {
					communication_id: communicationId,
					user_id: userId,
					trace_id: traceId,
				}
				$.ajax({
	      			url: WEBROOT + 'traces/delete/'+traceId+'/',
	      			type: 'post',
	      			data: data,
	      			success: function(data){
	      				if (data.Request.status == 200) {
							$(_tag).parents('.tag').remove();
						}
	      			}, 
	      			dataType: 'json',
	    		});
			}
			else {
				$(this).parents('.myTag').remove();
			}

		});
	},

	add: function() {

		CE.communications.addcommon();

		$(document).on('click', '.rm-nw', function(event) {
			event.preventDefault();
			$(this).parent('span').remove();
		});

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
                } ,//defined in ace.js >> ace.enable_search_ahead
			});
		}
		else {
			//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
			tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
			//$('#form-field-tags').autosize({append: "\n"});
		}

		// al enviar el mensaje
		$('#btn-send-message').on('click', function(event) {
			event.preventDefault();
			__sendComunication(false);
		});

		$('.btn-file-sign').on('click', function(){
		    
			
		   
		    var r = confirm("¿Desea enviar y firmar el resumen de la comunicación?");
		    if (r == true) {
		       
		        conPdf = 1;
		        sendType = 1;
	             __sendComunication(true);
		    }else{
		        
		     
		    if ($('.name').length == 0) {
                m_error('Debe haber al menos un adjunto para poder enviar y firmar');
            } 
		    else{
		        sendType = 1;
			 __sendComunication(true);
		    }
		    }   
	    });
		
		
		var __sendComunication =  function (certificated){
			//var _btn = this;
			var _btn = $('#btn-send-message');
			var btnHtml = $(_btn).html();
			if ($(_btn).attr('disabled')) return false;
			$(_btn).html('Enviando...');
			$(_btn).attr('disabled', 'disabled');
			$('.btn-fileup').hide();
			//$('.btn-file-sign').hide();
			$('.btn-file-sign').addClass('disabled');
			var receivers = [];
			var receiverscc = [];
			var files = [];
			var tags = [];
			var formats = [];
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
			if (!$('#message-title').val()){
				m_error('Debe colocar el asunto de la comunicación');
				$(_btn).html(btnHtml);
				$(_btn).removeAttr('disabled');
				$('.btn-fileup').show();
				//$('.btn-file-sign').show();
				$('.btn-file-sign').removeClass('disabled');
				return false;
			}
			if (!$('#message-category').val()){
				m_error('Debe indicar la categoría de la comunicación');
				$(_btn).html(btnHtml);
				$(_btn).removeAttr('disabled');
				$('.btn-fileup').show();
				//$('.btn-file-sign').show();
				$('.btn-file-sign').removeClass('disabled');
				return false;
			}
			if (!$('#message-type').val()){
				m_error('Debe indicar el tipo de comunicación');
				$(_btn).html(btnHtml);
				$(_btn).removeAttr('disabled');
				$('.btn-fileup').show();
				//$('.btn-file-sign').show();
				$('.btn-file-sign').removeClass('disabled');
				
				return false;
			}
			if (!$('input[name="message-action"]:checked').val()){
				m_error('Debe indicar la acción que requiere el envío de la comunicación');
				$(_btn).html(btnHtml);
				$(_btn).removeAttr('disabled');
				$('.btn-fileup').show();
				//$('.btn-file-sign').show();
				$('.btn-file-sign').removeClass('disabled');
				return false;
			}
			// creo una lista con los ids
			$.each($('.files tr'), function(index, file) {
				var idFile = $(file).attr('data-file-id');
				files.push(idFile);
			});
			// creo la lista con quien recibe la comunicacion
			var nameGroup = [];

			$.each($('#content-receivers .myTag'), function(index, receiver) {
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

			// creo la lista con quien recibe la comunicacion como CC
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
			// creo una lista con los tags a agregar
			$.each($('#contentTags .tag'), function(index, span) {
				var tag = $(span).html();
				var aux = tag.split('<button');
				tags.push(aux[0]);
			});
			// creo una lista con los formatos seleccionados
			$.each($('#tbl-formats tr'), function(index, tr) {
				var id = $(tr).attr('data-document-id');
				formats.push(id);
			});

			// chequear si es privado
			var m_private = 0;
			var namefile = 'nulo'; 
			if($('#correspondenciaCertificada').length > 0){
				var aux = $('#correspondenciaCertificada').find('a').attr('href').split('showfile/');
				namefile = aux[1];
			}
			
			//console.log(receivers);
			if ($('#id-private-message').is(':checked')) m_private = 1;
			var communication = {
				expires: $('#expires').val(),
				user_id: $('body').attr('data-user-id'),
				entity_id: $('body').attr('data-user-entity-id'),
				title: $('#message-title').val(),
				correlative: $('#message-correlative').val(),
				content: $('#message-content').html(),
				receivers: receivers,
				files: files,
				temporal_id: $('#txtIdMessage').val(),
				communication_category_id: $('#message-category').val(),
				communication_type_id: $('#message-type').val(),
				tags: tags,
				formats: formats,
				action: $('input[name="message-action"]:checked').val(),
				message_private: m_private,
				draft: 0,
				nameGroup:nameGroup,
				certificacion: namefile,
			    sendtype : sendType
			
			}
			   
			$.ajax({
          		url: WEBROOT + 'communications/add/',
          		type: 'post',
          		data: communication,
          		success: function(data){
          			if (data['Request']['status'] == 200){
          				if(!certificated){
    						window.location = WEBROOT + 'communications/';
          				}else{
//          					alert('Hola');
          					certificateCommunication(data['Message']['id'],data['Communication']['id']);
          				}
          			}
          			else {
          				m_error(data['Request']['message']);
          				// elimino los adjuntos
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
        	});
		};
		
		
		// guardar como borrador
		$('#btn-send-draft').on('click', function(event) {
			event.preventDefault();
			var _btn = this;
			var btnHtml = $(_btn).html();
			if ($(_btn).attr('disabled')) return false;
			$(_btn).html('Enviando...');
			$(_btn).attr('disabled', 'disabled');
			$('.btn-fileup').hide();
			//$('.btn-file-sign').hide();
			$('.btn-file-sign').addClass('disabled');
			var receivers = [];
			var receiverscc = [];
			var files = [];
			var tags = [];
			var formats = [];
			var error = false;
			if (($('#content-receivers > span').length < 1) && !$('#message-title').val()){
				m_error('Debe indicar a quien o quienes va dirigido la comunicación y el asunto de la comunicación');
				$(_btn).html(btnHtml);
				$(_btn).removeAttr('disabled');
				$('.btn-fileup').show();
				$('.btn-file-sign').show();
				$('.btn-file-sign').addClass('disabled');
				return false;
			}
			// creo una lista con los ids
			$.each($('.files tr'), function(index, file) {
				var idFile = $(file).attr('data-file-id');
				files.push(idFile);
			});
			// creo la lista con quien recibe la comunicacion
			$.each($('#content-receivers .myTag'), function(index, receiver) {
				var r = {
					id: $(receiver).attr('data-id'),
					type: $(receiver).attr('data-type'),
					deliverytype: 'to',
				};
				receivers.push(r);
			});
			// creo la lista con quien recibe la comunicacion como CC
			$.each($('#content-receivers-cc .myTag'), function(index, receiver) {
				var r = {
					id: $(receiver).attr('data-id'),
					type: $(receiver).attr('data-type'),
					deliverytype: 'cc',
				};
				receivers.push(r);
			});
			// creo una lista con los tags a agregar
			$.each($('#contentTags .tag'), function(index, span) {
				var tag = $(span).html();
				var aux = tag.split('<button');
				tags.push(aux[0]);
			});
			// creo una lista con los formatos seleccionados
			$.each($('#tbl-formats tr'), function(index, tr) {
				var id = $(tr).attr('data-document-id');
				formats.push(id);
			});

			// chequear si es privado
			var m_private = 0;
			if ($('#id-private-message').is(':checked')) m_private = 1;

			var communication = {
				user_id: $('body').attr('data-user-id'),
				entity_id: $('body').attr('data-user-entity-id'),
				title: $('#message-title').val(),
				content: $('#message-content').html(),
				expires: $('#expires').val(),
	            correlative: $('#message-correlative').val(),
				receivers: receivers,
				files: files,
				temporal_id: $('#txtIdMessage').val(),
				communication_category_id: $('#message-category').val(),
				communication_type_id: $('#message-type').val(),
				tags: tags,
				formats: formats,
				action: $('input[name="message-action"]:checked').val(),
				message_private: m_private,
				draft: 1,
			}

			$.ajax({
          		url: WEBROOT + 'communications/add/',
          		type: 'post',
          		data: communication,
          		success: function(data){
          		   
          			if (data['Request']['status'] == 200){
          			    window.location = WEBROOT + 'communications/';
          			}
          			else {
          				m_error(data['Request']['message']);
          				// elimino los adjuntos
          				$.each($('.files tr'), function(index, tr) {
          					$(tr).find('.delete button').click();
          				});
          				$(_btn).html(btnHtml);
						$(_btn).removeAttr('disabled');
						$('.btn-fileup').show();
						$('.btn-file-sign').show();
						$('.btn-file-sign').addClass('disabled');
          			}
          		}, 
          		dataType: 'json',
        	});
		});

		// html de la tabla donde se muestran los formatos disponibles
		var _htmlDocuments = function(data){
			var _html = '';
			$.each(data, function(index, val) {
				data = val.Upload;
				description = val.Format.name;
				var html = '<tr class="tr-format" data-document-id="'+data.id+'" data-document-name="'+data.description+'">';
				html = html + '<td>';
				html = html + '<a target="_blank" href="'+data.url+'" class="attached-file inline" title="'+data.description+'">';
				html = html + '<i class="icon-file-alt bigger-110 middle"></i>';
				html = html + '<span class="attached-name middle">'+description+'</span>';
				html = html + '</a>&nbsp;';
				html = html + '<a href="'+WEBROOT+'communications/download/'+data.name+'" title="Descargar" target="_blank">';
				html = html + '<i class="icon-download-alt bigger-125 blue"></i>';
				html = html + '</a>';
				html = html + '</tr>'
				_html = _html + html;
			});
			return _html;
		};
		
		// modal agregar formato
		$('#btn-add-format').on('click', function(event) {
			event.preventDefault();
			var categoryId = $('#message-category').val();
			if (!categoryId) return false;

			$('#modalAddFormat').modal('show');

			var data = {
				category_id: categoryId,
			}

			$.ajax({
          		url: WEBROOT + 'formats/documentsVisible/',
          		data: data,
          		type: 'post',
          		success: function(data){
          			if (data.length <= 0) {
          				var _html = '<p> No hay formatos para esta categoria </p>';
          			} else {
	          			var _html = _htmlDocuments(data);
          			}
	          		$('#modalAddFormat').find('div.modal-body').html(_html);
          		}, 
          		dataType: 'json',
        	});
		});

		//cerrar modal
		$('#btn-append-format').on('click', function(event) {
			event.preventDefault();
			$('#modalAddFormat').modal('hide');
		});

		// buscar la categoria de la comunicacion dependiendo del tipo
		$('#message-type').on('change', function(event) {
			event.preventDefault();

			$('#btn-add-format').addClass('hide');
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

		// mostrar el boton de formatos al seleccionar la categoria
		$(document).on('change', '#message-category',function(event) {
			if ($.trim($(this).val())) $('#btn-add-format').removeClass('hide');
			else $('#btn-add-format').addClass('hide');
		});

		// modal del directorio
		$('#btnShowModalCategoryTo').on('click', function(event) {
			event.preventDefault();
			$('#modalDirectory').modal('show');
			$.ajax({
          		url: WEBROOT + 'communications/directory/',
          		type: 'post',
          		success: function(data){
          		    console.log(data);
					var html = CE.htmls.directory(data);
          			$('#modalDirectory').find('.modal-body').html(html);
          			$('#modalDirectory').attr('data-append-to', 'to');
          		}, 
          		dataType: 'json',
        	});
		});

		// modal del directorio
		$('#btnShowModalCategoryCC').on('click', function(event) {
			event.preventDefault();
			$('#modalDirectory').modal('show');
			$.ajax({
          		url: WEBROOT + 'communications/directory/',
          		type: 'post',
          		success: function(data){
					var html = CE.htmls.directory(data);
          			$('#modalDirectory').find('.modal-body').html(html);
          			$('#modalDirectory').attr('data-append-to', 'cc');
          		}, 
          		dataType: 'json',
        	});
		});

		
		// checkbox requiere firma
		$(document).on('click','.signature-check', function() {
			
			var id = $(this).parent().parent().attr('data-file-id');
			var signature = ($(this).is(':checked') ? 1 : 0);
			
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
		
		
		// directorio al seleccionar una letra del abecedario
		$(document).on('click', '.abcd', function(event) {
			event.preventDefault();
			var letter = $(this).attr('data-letter');
			/* Act on the event */
			$.ajax({
          		url: WEBROOT + 'communications/directory/?l='+letter,
          		type: 'post',
          		success: function(data){
					var html = CE.htmls.directory(data);
          			//$('#modalDirectory').find('.modal-body').html('');
          			$('#modalDirectory').find('.modal-body').html(html);
          		}, 
          		dataType: 'json',
        	});
        	return false;
		});

		// dalr click sobre el boton de buscar en el directorio
		$(document).on('click', '.btnFindByQ', function(event) {
			event.preventDefault();
			var query = $('#search-people').val();
			if (!query) return false;
			$.ajax({
          		url: WEBROOT + 'communications/directory/?q='+query,
          		type: 'post',
          		success: function(data){
          		    console.log(data);
					var html = CE.htmls.directory(data);
					var h = $(html).height();
          			$('#modalDirectory').find('.modal-body').html(html);
          		}, 
          		dataType: 'json',
        	});
        	return false;
		});

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
			html = html + '<th class="center">';
			html = html + '<label>';
			html = html + '<input type="checkbox" class="ace" id="checkbox-select-all"><span class="lbl"></span>';
			html = html + '</label>';
			html = html + '	</th>';
			html = html +'<th>Nombre</th><th>Cargo</th><th>Email</th><th>Teléfono</th><th>Móvil</th><th>Entidad</th><th>Web</th><th>Posee Firma</th></tr></thead>';
			html = html + '<tbody>';
			$.each(data, function(index, val) {
				telephone = val.User.telephone ? val.User.telephone : ' ';
				celphone = val.User.celphone ? val.User.celphone : ' ';
				website = val.Entity.website ? val.Entity.website : ' ';
				html = html + '<tr class="nUser'+(index)+'" data-user-id="'+val.User.id+'" data-user-name="'+val.User.first_name+' '+val.User.last_name+'" data-user-path="'+val.path+'">';
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

		$(document).on('keyup', '#searchName', function(){
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

		// al seleccionar una entidad, mostrar sus hijos
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
		$(document).on('click','#btn-find-by-entity', function(e) {

			e.preventDefault();
			var entity = $('option.opt-entity:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'entities/findAllPeople/'+entity+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#searchName').css('display','block');
      				$('#table-2').html(_html);
      				$('#count2').html('<span style="background-color:orange !important;"  class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');

      			}, 
      			dataType: 'json',
    		});
		});	

		// btn para buscar a todos los usuarios que estan en el grupo
		$(document).on('click','#btn-find-by-group', function(e) {
			e.preventDefault();
			var group = $('option.opt-group:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'groups/findPeopleByGoup/'+group+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#table-3').html(_html);
					$('#count3').html('<span style="background-color:orange !important;"  class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');
      			}, 
      			dataType: 'json',
    		});
		});	

		// btn para buscar a todos los usuarios que estan en el grupo
		$(document).on('click','#btn-find-by-groupi', function(e) {
			e.preventDefault();
			var group = $('option.opt-groupi:selected:last').val();
			$.ajax({
      			url: WEBROOT + 'groups/findPeopleByGoup/'+group+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#count3i').html('<span style="background-color:orange !important;"  class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');
      				$('#table-3i').html(_html);
      			}, 
      			dataType: 'json',
    		});
		});	


		// btn para buscar a todos los usuarios que estan en el grupo
		$(document).on('click','#btn-find-by-circle', function(e) {
			e.preventDefault();
			c('piese');
			var circle = $('option.opt-circle:selected:last').val();
			
			if(circle == undefined){
			    circle = 0;
		    }
			$.ajax({
      			url: WEBROOT + 'circles/findPeopleByCircle/'+circle+'/',
      			type: 'get',
      			success: function(data){
      				var _html = _htmlTable(data);
      				$('#count4').html('<span style="background-color:orange !important;" class="badge pull-right">'+data.length+'<i class="icon-user" style="color:black;" title="" data-original-title="Usuarios"></i></span>');
      				$('#table-4').html(_html);
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
			var html;

		
		var _htmlTag = function(data) {
			//var html = '<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag" id="undefined_1" data-type="user" data-id="'+data.id+'">';
			html = html + '<option disabled data-type="user" data-id="'+data.id+'">';
			html = html + data.name + ' &nbsp;&nbsp;';
			html = html + '</option>';
			// html = html + '<a href="#" class="myTagRemover" id="undefined_Remover_1" tagidtoremove="1" title="" data-original-title="Eliminar">x</a>';
			// hmtl = html + '</span>';
			return html;
		}

		var _htmlTagSingle = function(data) {
		    alert();
			html = '<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag" id="undefined_1" data-type="user" data-id="'+data.id+'">';
			html = html + '<span data-rel="tooltip" data-placement="top" title="" data-original-title="'+data.path+'">';
			html = html + data.name + ' &nbsp;&nbsp;';
			html = html + '</span>';
			html = html + '<a href="#" class="myTagRemover" id="undefined_Remover_1" tagidtoremove="1" title="" data-original-title="Eliminar">x</a>';
			hmtl = html + '</span>';
			return html;
		}

		var path;
		// agregar los seleccionados al mensaje
		$(document).on('click','.btn-send-msg', function(event) {
			event.preventDefault();
			var tag2;
			var windows;
			if($( "#profile2" ).hasClass( "active" )) windows = 4;
			if($( "#groups" ).hasClass( "active" )) windows = 3;
			if($( "#groupsi" ).hasClass( "active" )) windows = 2;
			if($( "#circles" ).hasClass( "active" )) windows = 1;
			var realPositions;
			var positions = [];
			var idx = 0;
			$('.s-entity option:selected').each(function(){
				positions[idx] = $(this).text();
				idx++;
			});

			if(positions[positions.length - windows] == 'Seleccione'){
				realPositions = positions[positions.length - windows -1];
			}
			else{
				realPositions = positions[positions.length - windows];
			}

			$("input[type=checkbox]:checked").each(function(k){
				if(k == 0){
					if ($(this).attr('id') == 'checkbox-select-all') {
						tag2 = true;
					}
					else{
						tag2 = false;
					}
				}

				if ($(this).attr('id') != 'checkbox-select-all') {
					path = $(this).parents('tr:first').attr('data-user-path');
					var dt = {
						id: $(this).parents('tr:first').attr('data-user-id'),
						name: $(this).parents('tr:first').attr('data-user-name'),
						path: $(this).parents('tr:first').attr('data-user-path')
					}
					if (tag2 == true){
						htmlT = _htmlTag(dt);
					}
					else{
						htmlT = _htmlTagSingle(dt);
						var appendTo = $('#modalDirectory').attr('data-append-to');
						if (appendTo == 'to') $('#content-receivers').append(htmlT);
						if (appendTo == 'cc') {
						$('#content-tags-receivers-cc').removeClass('hide');
						$('#content-receivers-cc').append(htmlT);
					}
					}
				}
			});

				if (tag2 == true){
					var appendTo = $('#modalDirectory').attr('data-append-to'); 
					if (appendTo == 'to') $('#content-receivers').append('<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag more"><select style="color: white; background-color: #8CBAD1; border:0px;"><option>'+realPositions+'</option>'+htmlT+'</select><a href="#" class="myTagRemover" id="" tagidtoremove="1" title="" data-original-title="Eliminar">x</a></span>');
					if (appendTo == 'cc') {
						$('#content-tags-receivers-cc').removeClass('hide');
						$('#content-receivers-cc').append('<span style="margin-top:2px; padding-top:2px; display:inline-block;" class="myTag"><select style="color: white; background-color: #8CBAD1; border:0px;"><option>'+realPositions+'</option>'+htmlT+'</select><a href="#" class="myTagRemover" id="" tagidtoremove="1" title="" data-original-title="Eliminar">x</a></span>');
				}				}
				else{
					
				}
			html = "";
			message('Mensaje', 'Usuario(s) agregado(s)');
		});	

		// al cambiar de pestaña desmarcar todos los checkbox y cocultar boton
		$(document).on('click', '#modalDirectory ul.nav li a', function(event) {
			event.preventDefault();
			$("input[type=checkbox]:checked").removeAttr("checked");
			$('.spn-send-msg').addClass('hide');
		});

		// eliminar tag
		$(document).on('click', '.tag .close', function(event) {
			event.preventDefault();
			_tag = this;
			$(_tag).parents('.tag').remove();
		});
	},
});