<?php
/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php echo $this->Session->flash(); ?>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Reestablecer mi Contraseña
				<small>
					<i class="icon-double-angle-right"></i>
					reestablecer contraseña
				</small>
			</h1>
		</div>
		<?php echo $this->Form->create('User', array('action' => 'activatePassword')); ?>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Contraseña </label>
			<div class="col-sm-9">
				<div class="umstyle4">
					<?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"umstyle5" ))?>
					<div class="validateErrorMsj" style="float:inherit;" ></div>
				</div>
				<?php //echo $this->Form->input("oldpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5 umstyle5" ))?>
			</div>
		</div><br><br>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Confirmar Contraseña </label>
			<div class="col-sm-9">
				<div class="umstyle4"><?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"umstyle5" ))?></div>
				<?php //echo $this->Form->input("oldpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"col-xs-10 col-sm-5 umstyle5" ))?>
			</div>
		</div>
		<div>
			<div class="umstyle3"></div>
			<div class="umstyle4">
			<?php   if (!isset($ident)) {
					$ident='';
				}
				if (!isset($activate)) {
					$activate='';
				}   ?>
				<?php echo $this->Form->hidden('ident',array('value'=>$ident))?>
				<?php echo $this->Form->hidden('activate',array('value'=>$activate))?>

				<button  class="btn btn-info" id="changeUserPassword" type="">
						<i class="icon-ok bigger-110"></i>
						Cambiar
					</button>
				<div style="clear:both"></div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
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
		return true;
	}
	});

</script>