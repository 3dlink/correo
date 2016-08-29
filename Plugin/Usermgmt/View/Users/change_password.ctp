<?php
echo $this->Session->flash(); ?>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Cambiar mi Contraseña
				<small>
					<i class="icon-double-angle-right"></i>
					cambio contraseña
				</small>
			</h1>
		</div>

					
		<?php echo $this->Form->create('User', array('action' => 'changePassword', 'class' => 'form-horizontal')); ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Contraseña actual </label>
				<div class="col-sm-9">
					<div class="umstyle4"><?php echo $this->Form->input("oldpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"umstyle5" ))?></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nueva Contraseña </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5 umstyle5" ))?>
					<div class="validateErrorMsj" style="float:inherit;" ></div>
				</div> 
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Confirmar contraseña </label>
				<div class="col-sm-9 umstyle4">
					<?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5 umstyle5" ))?>
				</div>
			</div>
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9 text-right">
					<button id="changeUserPassword" class="btn btn-info" type="">
						<i class="icon-ok bigger-110"></i>
						Cambiar
					</button>
					&nbsp; &nbsp; &nbsp;
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>	
</div>

<div class="umtop">
	<?php echo $this->Session->flash(); ?>
	<div class="um_box_up"></div>
	<div class="um_box_mid">
		
	</div>
	<div class="um_box_down"></div>
</div>
<script>
document.getElementById("UserPassword").focus();

$('#changeUserPassword').click(function(){
	var MLetras = new RegExp("([A-Z])");//letras Mayusculas
	var mletras = new RegExp("([a-z])");//letras minusculas
	var numeros = new RegExp("([0-9])");//numeros
	var specials = new RegExp("([-#&@!?_.])");//caracteres especiales
	var valorP= $('#UserPassword').val();
	if(!(valorP.match(MLetras) && valorP.match(mletras) && valorP.match(numeros) && valorP.match(specials) && valorP.length >= 8 && valorP.length <= 15)){

		$('#UserPassword').addClass('inputErrorE');
		$('#UserPassword').focus();
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
		$('#UserPassword').removeClass('inputErrorE');
		$('#UserChangeUserPasswordForm').submit();
		// return true;
	}

})




</script>