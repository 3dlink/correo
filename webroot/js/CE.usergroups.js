$.extend(CE.user_groups, {
	index: function() {
		$('.delete-group').on('click', function(event) {
			event.preventDefault();
			var groupId =  $(this).attr('data-group-id');
			bootbox.dialog({
				message: "<span class='bigger-110'>Eliminará el grupo de usuario. Desea continuar?</span>",
				buttons: 			
				{
					"success" :
					 {
						"label" : 'Si',
						"className" : "btn-sm btn-success",
						"callback": function(){
							$.ajax({
				          		url: WEBROOT + 'deleteGroup/'+groupId,
				          		type: 'post',
				          		success: function(data){
				          			if (data.Request.status == 200) {
          			 					window.location.href = WEBROOT + 'allGroups';
				          			}
				          			else {
				          				m_error(data.Request.message);
          								return false;
				          			}
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
	}
});