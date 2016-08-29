$.extend(CE.common, {
	init: function() {
          // guardar la clave cuando entra por primera vez que entra al sistema
		$(document).on('click', '#savePasswordFirstTime', function(event) {
			event.preventDefault();

               var idUser = $('body').attr('data-user-id');
               var MLetras = new RegExp("([A-Z])");//letras Mayusculas
               var mletras = new RegExp("([a-z])");//letras minusculas
               var numeros = new RegExp("([0-9])");//numeros
               var specials = new RegExp("([-#&@!?_.])");//caracteres especiales
               var valorP= $('#password').val();
               if(!(valorP.match(MLetras) && valorP.match(mletras) && valorP.match(numeros) && valorP.match(specials) && valorP.length >= 8 && valorP.length <= 15)){

                    $('#password').addClass('inputErrorE');
                    $('#password').focus();
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
                    $('#password').removeClass('inputErrorE');
               }


			var data = {
				password: $('#password').val(),
				cpassword: $('#cpassword').val()
			};
			$.ajax({
          		url: WEBROOT + 'setPassword',
          		type: 'post',
          		data: data,
          		success: function(data){
          			if (data.Request.status == '200'){
          				$('#modalChangePassFirstTime').modal('hide');
          				message('Mensaje', data['Request']['message']);
          			}
          			else {
                              $('#password').val('');
                              $('#cpassword').val('');
						m_error(data['Request']['message']);
          			}
          		}, 
          		dataType: 'json',
        	      });
		});

          // busqueda de comunicaciones por titulo, cuerpo, tag, tipo, categoria, accion, persona          
          $(document).on('submit', '#form-search', function(event) {
               event.preventDefault();
               query = $(this).find('#search-communications').val();
               env = $(this).attr('data-enviroment');
               if (env) env = env + '=1';
               window.location = WEBROOT + 'communications/?query='+query+'&'+env;
               q = {
                    query: query,
                    enviroment: env
               }
               $.ajax({
                    url: WEBROOT + 'communications',
                    type: 'get',
                    data: q,
                    success: function(data){
                    }, 
                    dataType: 'json',
                });
          });
	}
});