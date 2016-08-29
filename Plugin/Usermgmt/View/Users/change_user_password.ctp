<?php
echo $this->Session->flash(); ?>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Cambio de Contraseña
				<small>
					<i class="icon-double-angle-right"></i>
					cambiar contraseña de <?php echo $user['User']['first_name'].' '.$user['User']['last_name']?>
				</small>
			</h1>
		</div>
		<form class="form-horizontal" action="<?php echo $this->webroot.'changeUserPassword/'.$user['User']['id']?>" id="UserChangeUserPasswordForm" method="post" accept-charset="utf-8">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Contraseña </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
					<div class="validateErrorMsj" style="float:inherit;"></div>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Confirmar contraseña </label>
				<div class="col-sm-9 umstyle4">
					<?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5" ))?>
				</div>
			</div>
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9 text-right">
					<button id="saveUserPassword" class="btn btn-info" type="">
						<i class="icon-ok bigger-110"></i>
						Guardar
					</button>
					&nbsp; &nbsp; &nbsp;
				</div>
			</div>
		</form>
	</div>	
</div> 

<script type="text/javascript">

$('#saveUserPassword').click(function(){
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
		$('#UserChangeUserPasswordForm').submit();
		// return true;
	}

})



</script>