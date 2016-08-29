<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1>
				Mi Perfil
				<small>
					<i class="icon-double-angle-right"></i>
					<?php echo $user['User']['first_name'].' '.$user['User']['last_name']?>
				</small>
			</h1>
		</div>
		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name"> Nombre(s) </div>
				<div class="profile-info-value">
					<?php echo $user['User']['first_name']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Apellido(s) </div>
				<div class="profile-info-value">
					<?php echo $user['User']['last_name'].'&nbsp'; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Usuario </div>
				<div class="profile-info-value">
					<?php echo $user['User']['username']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Rol </div>
				<div class="profile-info-value">
					<?php echo $user['UserGroup']['name']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Entidad </div>
				<div class="profile-info-value">
					<?php echo $user['path']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Cargo </div>
				<div class="profile-info-value">
					<?php echo $user['User']['position']; ?>&nbsp;
				</div> 
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Grupo </div>
				<div class="profile-info-value">
					<?php echo $user['Group']['name']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Correo </div>
				<div class="profile-info-value">
					<?php echo $user['User']['email']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Teléfono </div>
				<div class="profile-info-value">
					<?php echo $user['User']['telephone']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Teléfono Móvil </div>
				<div class="profile-info-value">
					<?php echo $user['User']['celphone']; ?>&nbsp;
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Estado</div>
				<div class="profile-info-value">
					<?php
					if ($user['User']['active']) echo 'Activo';
					else echo 'Inactivo';
					?>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Creado</div>
				<div class="profile-info-value">
					<?php echo date('d-M-Y',strtotime($user['User']['created']))?>
				</div>
			</div>
		</div>
	</div>
</div>
