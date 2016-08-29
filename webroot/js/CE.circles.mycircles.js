$.extend(CE.circles, {
	mycircles: function() {

		// salir de un circulo al que pertence
		$('.out-from-circle').on('click', function(event) {
			event.preventDefault();
			_this = this;
			var idCircle = $(this).attr('data-circle-id');

			$.ajax({
          		url: WEBROOT + 'circles/outFromCircle/',
          		type: 'post',
          		data: {circle:idCircle},
          		success: function(data){
					if (data.Request.status == 200){
						$(_this).parents('tr:first').remove();
						message('Mensaje', data.Request.message);
					} else {
						message('Mensaje', data.Request.message);
					}
          		}, 
          		dataType: 'json',
        	});
		});
	}
});