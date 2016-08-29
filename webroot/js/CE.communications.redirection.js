$.extend(CE.communications, {

	redirection:function(){

		var _htmlTr = function(data){
			var html = '<tr>';
			html = html + '<td data-type="'+data.type+'" data-id="'+data.id+'">'+data.name+'</td>';
			html = html + '<td>'+data.path+'</td>';
			html = html + '<td class="center">Eliminar</td>';
			html = html + '</tr>';
			return html;
		}
		
		var url = WEBROOT + 'communications/findUsersAndEntities'
		$('#msg-redirect').tagsManager({
            preventSubmitOnEnter: true,
            typeahead: true,    
            typeaheadSource: function(query, process){
                $.post(url,{q:query},function(data) {
                    process ($.map(data, function(item) {
                        var name = item.id+'--'+item.name+'--'+item.type+'--'+item.path;
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
                },
                this.updater=function(item){
                    var sp = item.split('--');
                    var path = sp[3].split('-');
                    var userLogged = $('body').attr('data-user-id');
                    var element = {
                    	'id': sp[0],
                    	'name': sp[1],
                    	'type': sp[2],
                    	'path': sp[3]+' -'
                    };

                    var toSave = {
                    	to_user_id: sp[0],
                    	type: sp[2],
                    }
                    var error = false;
                    $.ajax({
		          		url: WEBROOT + 'redirections/add/',
		          		type: 'post',
		          		data: toSave,
		          		success: function(data){
		          			if (data['Request']['status'] == 200){
				          		message('Mensaje', data['Request']['message']);
							}
							else {
								m_error(data['Request']['message']);
							}
		          		}, 
		          		dataType: 'json',
		        	});

                    var htmlTr = _htmlTr(element);
                    $('.to-redirect').append(htmlTr);
                }
            },
        });
	},
});