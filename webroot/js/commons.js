var click = "";
var sendType = 0;
var conPdf = 0;

var c = function(a) {
    console.log(a);
};

function message(title, text){
	$.gritter.add({
		title: title,
		text: text,
		image: false,
		sticky: false,
		time: '',
		class_name: 'gritter-success'
	});
};

function dialog(message, fun, params, btn1, btn2){
	if (!btn1) btn1 = 'Aceptar';
	if (!btn2) btn2 = 'Cancelar';

	bootbox.dialog({
		message: "<span class='bigger-110'>"+message+"</span>",
		buttons: 			
		{
			"success" :
			 {
				"label" : btn1,
				"className" : "btn-sm btn-success",
				"callback": fun(params)
			}, 
			"button" :
			{
				"label" : btn2,
				"className" : "btn-sm"
			}
		}
	});
}

function m_error(message){
	var funHtml = function(message) {
		var html = '<div id="msg-error">';
		html = html +'<div id="gritter-item-4" class="gritter-item-wrapper gritter-error gritter-center">'
		html = html +'<div class="gritter-top"></div>';
		html = html + '<div class="gritter-item">';		
		html = html + '<div id="m-close">';		
		html = html + '<i class="icon-remove bigger-110"></i>';		
		html = html + '</div>';		
		html = html + '<div class="gritter-without-image">';		
		html = html + '<span class="gritter-title">Alerta</span>';		
		html = html + '<p>'+message+'</p>';		
		html = html + '</div>';		
		html = html + '<div style="clear:both"></div>';		
		html = html + '</div>';		
		html = html + '<div class="gritter-bottom"></div>';		
		html = html + '</div>';		
		html = html + '</div>';		
		html = html + '</div>';		
		return html;
	}
	var hatmA = funHtml(message);		
	$('body').prepend(hatmA);
	var removeMsg = function(){
		$('#msg-error').fadeOut('fast', function() {
			$('#msg-error').remove();
		});
	};
	var prueba = setTimeout(function() {
		removeMsg();
	}, 4000);
    
	$("#msg-error")
 		.on("mouseenter", function() {
 			clearTimeout(prueba);
 			$('#msg-error').stop();
  		})
  		.on("mouseleave", function() {
    		setTimeout(function() {
				removeMsg();
			}, 4000);
  		});
  	$('#m-close i').on('click', function( ) {
  		event.preventDefault();
  		removeMsg();
  	});
}

function prettydate(){
	$.each($('.pretty-date-date'), function(index, val) {
    	var months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    	var dateTime = $(val).attr('data-date');
    	if (!dateTime) return false;
    	var arrDate = dateTime.split(' ');
    	var date = arrDate[0].split('-');
    	var hours = arrDate[1].split(':');
    	var day = parseInt(date[2]);
    	var month = parseInt(date[1]); 
    	var year = date[0].slice(-2);
    	var hour = parseInt(hours[0]);
    	var min = hours[1];
    	var sec = hours[2];
    	var meridiam = (hour >= 12) ? 'pm' : 'am';
    	hour = (hour > 12) ? parseInt(hour - 12) :  parseInt(hour);
    	$(val).find('.day').html(day);
    	$(val).find('.month').html(months[month-1]);
    	$(val).find('.year').html(year);
    	$(val).find('.hour').html(hour+':'+min+' '+meridiam);
        $(val).find('.full-date').html('<strong>'+day+' '+months[month-1]+' '+year+'</strong> '+hour+':'+min+' '+meridiam);
    	var fullD = 'Leído el '+day+' de '+months[month-1]+' de '+year+' a las '+hour+':'+min+' '+meridiam;
        $(val).find('.full-date-title').attr('data-original-title', fullD);
    	if ($(val).find('.email-date').length > 0) {
    		var today = $('body').attr('data-today');
			if (!today) return false;
			var arrDateT = today.split(' ');
	    	var dateT = arrDateT[0].split('-');
    		var hoursT = arrDateT[1].split(':');
	    	var dayT = parseInt(dateT[2]);
			var monthT = parseInt(dateT[1]); 
			var yearT = dateT[0].slice(-2);
			var hourT = parseInt(hoursT[0]);
	    	var minT = hoursT[1];
	    	var secT = hoursT[2];
    		var meridiamT = (hourT >= 12) ? 'pm' : 'am';
    		hourT = (hourT > 12) ? parseInt(hourT - 12) :  parseInt(hourT);
			var show = '';
			if (yearT != year){
				show = day+'/'+months[month-1]+'/'+year;
			}
			else if (dayT==day && monthT==month){
				show = hour+':'+min+' '+meridiam;
			}
			else {
				show = day+' '+months[month-1];
			}
    		$(val).find('.email-date').html(show);
    	}
    	
    });
}

function execTooltipe() {
    $(document.body).tooltip({selector: '[title]'})
    .on('click mouseenter mouseleave','[title]', function(ev) {
        $(this).tooltip('mouseenter' === ev.type? 'show': 'hide');
    });
}

function getParam(key){
    key = key.replace(/[\[]/, '\\[');  
    key = key.replace(/[\]]/, '\\]');  
    var pattern = "[\\?&]" + key + "=([^&#]*)";  
    var regex = new RegExp(pattern);  
    var url = unescape(window.location.href);  
    var results = regex.exec(url);  
    if (results === null) {  
        return null;  
    } else {  
        return results[1];  
    }  
}


var ventanaApplet;

function abrirVentana(data){ 
//guardo la referencia de la ventana para poder utilizarla luego 
//ventana_secundaria = window.open("cerrar_window2.html","miventana","width=300,height=200,menubar=no")
ventanaApplet = window.open(WEBROOT+"appletFirma/index.html?idDoc="+data, "Firma","height=500,width=920");
} 

function cerrarVentana(){ 
//la referencia de la ventana es el objeto window del popup. Lo utilizo para acceder al método close 
    ventanaApplet.close() 
} 

(function($) {  
    $.getParam = function(key)   {  
        key = key.replace(/[\[]/, '\\[');  
        key = key.replace(/[\]]/, '\\]');  
        var pattern = "[\\?&]" + key + "=([^&#]*)";  
        var regex = new RegExp(pattern);  
        var url = unescape(window.location.href);  
        var results = regex.exec(url);  
        if (results === null) {  
            return null;  
        } else {  
            return results[1];  
        }  
    }  
})(jQuery);  
  
function appletFirma(data,idMessage,idCommunication) {
    //window.open("http://62.43.192.130:82/workflow/appletFirma/index.html", "Firma","height=200,width=820");
    //window.open("http://62.43.192.130:82/workFlow/AppletFirmaAIG/index.html?idDoc="+data, "Firma","height=500,width=820");
    //ventanaApplet = window.open(WEBROOT+"appletFirma/index.html?idDoc="+data, "Firma","height=500,width=920");
    //console.log(ventanaApplet);
    abrirVentana(data);
    data = {
    		id: data,
    		correspondencia: null,
    		idMessage: idMessage,
    		idCommunication:idCommunication,
    		conpdf:conPdf
    }
  
    $.post(WEBROOT+'communications/testingCall/0-0', data, function(resp) {
        var startID;
        
        startID = setInterval(function() {
			//window.location = WEBROOT + 'communications/';
    	    $.post(WEBROOT+'communications/documentStatus',  data = { id: idCommunication }, function(resp) {
    	        
    	        
    	         if(resp==0){
    	             
    	             cerrarVentana();
    	             window.location = WEBROOT + 'communications/index?x=1';
    	             clearInterval(startID);
    	             
    	         }
    	    });
    	    
    	}, 1000);
    });
    
}
function exportresumen(idCommunication,data){
    
    
    $.post(WEBROOT+'communications/viewpdf/' + idCommunication, data, function(resp) {
            
            
            var str = resp.split(" ");

            if(str[1] == 'error:') {
                alert("ERROR");
            }
            else{
                
                //$('.attachment-list').find('#correspondenciaCertificada').remove();
                $('.attachment-list').append(builtAttachmentElem('correspondencia_certificada_'+correlativo+'.pdf'));
                $('.widget-toolbox').show();
            }
            
            
            //$('.btn-file-sign').removeClass('disabled');
        });
        
}

function certificateCommunication(idMessage,idCommunication){
	//alert('Certificando..');

	//var id = $('#communication').attr('data-communication-id');
	var id = $('#communication').attr('data-communication-id');
	var correlativo = idMessage;
	var receivers = [];
	
	if(!id){
		id = '';
		var d = new Date();
		//correlativo =  "" + d.getFullYear() + d.getMonth() + d.getDate() + d.getHours() + d.getMinutes() + d.getSeconds();
		//alert(correlativo);
	}


	var data = {
			title: $('#message-title').val(),
			content: $('#message-content').html(),
			correlativo: correlativo,
			receivers:receivers,
			bySigned : 1
	};
		

	
	
	
	
	if (conPdf) {
	   

	     $('.btn-file-sign').addClass('disabled');
         $("#modalCertificateCommunication").modal('show');
  $.post(WEBROOT+'communications/viewpdf/' + idCommunication, data, function(resp) {
            
            
            var str = resp.split(" ");

            if(str[1] == 'error:') {
                alert("ERROR");
            }
            else{
                
                //$('.attachment-list').find('#correspondenciaCertificada').remove();
                $('.attachment-list').append(builtAttachmentElem('correspondencia_certificada_'+correlativo+'.pdf'));
                $('.widget-toolbox').show();
            }
            
            
            //$('.btn-file-sign').removeClass('disabled');
       
            sendIdFiles(idMessage,idCommunication);
        });
	
	} 
	else {
	  
	        $('.btn-file-sign').addClass('disabled');
            $("#modalCertificateCommunication").modal('show');
           sendIdFiles(idMessage,idCommunication);
	    
	}
	//$('.attachment-list').find('#correspondenciaCertificada').remove();
	

}

function certificateCommunication2(idMessage,idCommunication){
  
    $("#modalCertificateCommunication").modal('show');
  
    var id = $('#communication').attr('data-communication-id');
    var correlativo = idMessage;
    var receivers = [];
    
    if(!id){
        id = '';
        var d = new Date();
      
    }
   

    var data = {
            title: $('#message-title').val(),
            content: $('#message-content').html(),
            correlativo: correlativo,
            receivers:receivers,
            bySigned : 1
    };
        

    $('.btn-file-sign').addClass('disabled');
    
 
    sendIdFiles(idMessage,idCommunication);

}

function resumenNoCertificado(idCommunication){
    var data = {
            title: $('#message-title').val(),
            content: $('#message-content').html(),
            //correlativo: correlativo,
            //receivers:receivers,
            //bySigned : 1
    };   
    message('Mensaje', 'En segundos el sistema generar&aacute; un pdf con el resumen de esta correspondencia. ');
$.post(WEBROOT+'communications/viewpdf/' + idCommunication, data, function(resp) {
        
       
        window.location = WEBROOT + 'communications/downloadResumen/correspondencia_certificada_'+idCommunication+'.pdf';
    });
    
}

function resumenCertificado(idCommunication){
    var data = {
            title: $('#message-title').val(),
            content: $('#message-content').html(),
            //correlativo: correlativo,
            //receivers:receivers,
            //bySigned : 1
    };    
$.post(WEBROOT+'communications/viewpdf/' + idCommunication, data, function(resp) {
        
        console.log(resp);
        
    });
var doc = "correspondencia_certificada_"+idCommunication+".pdf";
$.post(WEBROOT+'communications/signedResumen/' + doc, function(resp) {
    
    console.log(resp);
    
});

var startID;

startID = setInterval(function() {
    //window.location = WEBROOT + 'communications/';
    $.post(WEBROOT+'communications/signedResumenStatus',  data = { id: doc }, function(resp) {
        
        
         if(resp==0){
             
             cerrarVentana();
             window.location = WEBROOT + 'communications/downloadResumen/'+ doc;
             clearInterval(startID);
             
         }
    });
    
}, 1000);

    abrirVentana(doc);
}

function sendIdFiles(idMessage,idCommunication) {
	var id = $('#communication').attr('data-communication-id');
	var data = '';
	var separator = '';
	var nameFile = '';
	var ext = ''
	
	    
	if ($('.attachment-list').length > 0) {
		var $attach = $('.attachment-list:first');
		
		$attach.find('.attached-file').each(function(){
		   
			nameFile = $(this).attr('href').split("showfile/");
			
			
			ext = nameFile[1].split('.');
			//if(ext[1] == 'pdf'){
				data += separator + nameFile[1];
				separator = '|';
			//}
		});
	}
	
	if ($('.name').length > 0){
		//alert('Estamos en nuevo');
		var $attach = $('.name');
		$attach.each(function(){
			nameFile = $(this).find('a').attr('href').split("files/");
			if(nameFile.length > 1){
			ext = nameFile[1].split('.');
			//if(ext[1] == 'pdf'){
				data += separator + nameFile[1];
				separator = '|';
			//}
			}	
		});
	}
	
	if ($('.name').length > 0){
        //alert('Estamos en nuevo');
        var $attach = $('.name');
        $attach.each(function(){
            nameFile = $(this).find('a').attr('href').split("showfile/");
            if(nameFile.length > 1){
            ext = nameFile[1].split('.');
            //if(ext[1] == 'pdf'){
                data += separator + nameFile[1];
                separator = '|';
            //}
            }
        });
    }
	
	       //console.log(data); 
	    appletFirma(data,idMessage,idCommunication); 
	
	
}

function builtAttachmentElem(name){
	
	return '<li id="correspondenciaCertificada">'+
				'<a class=" attached-file inline" target="_blank" href="'+WEBROOT+'communications/showfile/'+name+'" title="" data-file-id="275" data-original-title="Correspondencia Certificada.pdf">'+
				'<i class="icon-file-alt bigger-110 middle"></i>'+
				'<span class="attached-name middle">Correspondencia Certificada.pdf</span>'+
				'</a>'+
				'<div class="action-buttons inline">'+
					'<a class="" href="'+WEBROOT+'communications/download/'+name+'/" title="" target="_blank" data-file-id="275" data-original-title="Descargar">'+
						'<i class="icon-download-alt bigger-125 blue"></i>'+
					'</a>'+
					'<input id="namefile" type="hidden">'+
					'<input id="numberfile" type="hidden">'+
				'</div>'+
			'</li>';
}

$(document).ready(function(){

	$(document).on('keydown','.only-numbers', function(e){
        if((event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 110 && event.keyCode != 8 && event.keyCode != 37 && event.keyCode != 38 && event.keyCode != 39 && event.keyCode != 40 && event.keyCode != 190 && event.keyCode != 46){
            if((event.keyCode < 96 || event.keyCode > 105)){
                return false;
            }
        }
    });


	$(".modal").on("hidden",function(){
		alert('Cerro modal');
	});
	
	var notificationCommunications = function() {
        $.ajax({
            url: WEBROOT+'communications/getNewCommunications',
            type: "GET",
            success: function(data) {
                var _li = $('#notification-new-communications');
                var html = '';
                if (data.Count > 0){
                	html = html + '<a data-toggle="dropdown" class="dropdown-toggle" href="#">';
                	html = html + '<i class="icon-envelope icon-animated-vertical"></i>';
                	html = html + '<span class="badge badge-success">'+data.Count+'</span>';
                	html = html + '</a>';
                	html = html + '<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">';
                	html = html + '<li class="dropdown-header"><i class="icon-envelope-alt"></i>'+data.Count+' Notificaciones</li>';
                	$.each(data.Messages, function(index, message) {
                		html = html + '<li><a href="'+WEBROOT+'communications/view/'+message.Communication.id+'">';
                		html = html + '<div class="msg-title">';
                		html = html + '<div class="blue" style="width:220px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+message.SenderEntity.name+'</div>';
                		html = html + '<div style="width:220px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+message.Message.title+'</div>';
                		html = html + '</div>';
                		html = html + '<div style="margin: 5px; text-align:right;"><span class="msg-time pretty-date-date" data-date="'+message.Message.created+'"><span class="email-date"></span></span></div>';
                		html = html + '</a></li>';
                	});
                	html = html + '<li><a href="'+WEBROOT+'communications'+'">Bandeja de comunicaciones</a></li>';
                	html = html + '</ul>';
                }
                else {
                	html = html + '<a data-toggle="dropdown" class="dropdown-toggle" href="#">';
                	html = html + '<i class="icon-envelope icon-animated-vertical"></i>';
                	html = html + '<span class="badge badge-success">0</span>';
                	html = html + '</a>';
                	html = html + '<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">';
                	html = html + '<li><a href="'+WEBROOT+'communications'+'">Bandeja de comunicaciones</a></li>';
                	html = html + '</ul>';
                }
                $(_li).html(html);
   				prettydate();
            },
            dataType: "json",
            complete: setTimeout(function() {notificationCommunications()}, 5000),
            timeout: 2000
        })
    };

   	prettydate();
    var groupUserId = $('body').data('user-group-id');
    if (groupUserId != 1 && groupUserId != 3) 
        setTimeout(function() {notificationCommunications()}, 3000);
        //notificationCommunications();

    execTooltipe();
    /*
    $(document.body).tooltip({selector: '[title]'})
    .on('click mouseenter mouseleave','[title]', function(ev) {
        $(this).tooltip('mouseenter' === ev.type? 'show': 'hide');
    });

*/
})      
