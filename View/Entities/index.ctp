
<script>
	 	var positions = [];
function saveData(cant){

	 	$('#click').on("click",function(){
	 		var childrensEdit = $('.ChildrenEdit');
	 		childrensEdit.children('li').each(function(k,v){console.log(
	 			positions[k] = $(v).attr("data-id")
	 		)});

	 		$.ajax({
                url:   'entities/orderTree/'+positions,
                type:  'get',
                dataType: "json",
                beforeSend: function () {
                        $("#msj2").css("display","block");
                },
                success:  function (response) {
                	if(response == 1){
                		 $("#msj2").css("display","none");
                		$('#msj').css("display","block");
                		 setTimeout(function(){
        					$('#msj').css("display","none");
							$("#click").css("display","none");
        				}, 5000);
                		
                	}
                }
       		});
	 	});
	}
	$(document).ready(function(){

	$("#checkEntity").click(function() {  
        if($("#checkEntity").is(':checked')) {  
           $("#selectEntity").css('display','block');
        } else {  
           $("#selectEntity").css('display','none');
        }  
    });  

	 saveData();
	 	$( "#mainList" ).on( "mouseover", function() {	 		
	  		for (var i = 1; i <= $(".dd-list").size(); i++) {
	 		  $(function() {
			    $( "._"+i ).sortable({
			      revert: true,
			      axis: "y",
			      stop: function( event, ui ) { $("#click").css("display","block"); 
			      	$(this).addClass("ChildrenEdit");
			  		}
			    });
			  });

	 		} 
		});


		$('.btn-fileup').on('click', function(){
	      	$('.btn-fileup-h').click();
	    });

		// detectar cuando un se ha cargado un elemento
		$('.btn-fileup-h').on('change',function(event) {
			$('.btn-fileup').hide();
			setTimeout(function(){
				$.each($('.table-documents tr'), function(index, tr) {
					$(tr).find('td .btn-start-preupload').click();
				});
			},500);
		});

		/*$('.btn-fileup-e').on('click', function(){
	      	$('.btn-fileup-h-e').click();
	    });

		// detectar cuando un se ha cargado un elemento
		$('.btn-fileup-h-e').on('change',function(event) {
			$('.btn-fileup-e').hide();
			setTimeout(function(){
				$.each($('.table-documents-e tr'), function(index, tr) {
					$(tr).find('td .btn-start-preupload-e').click();
				});
			},500);
		});*/

		$('body').on('click','.delete', function(){
			$('.btn-fileup').show();
			$('.btn-fileup-e').show();
	    });

		//Limpiamos el modal cuando se cierre.
		$('body').find(".modal").on("hide",function(){
			//alert('');
			//$('.modal').find(".delete").click();
		});
		
 	});

	  $(function() {
	    $( ".drop" ).sortable({
	      revert: true,
	      axis: "y",
	       stop: function( event, ui ) { $("#click").css("display","block"); 
		      	$(this).addClass("ChildrenEdit");
		  		}
	    });
	    $( ".ui-state-default" ).disableSelection();
	  });
 	
	</script>
<style>
.files{
	margin-bottom: 20px;
}
</style>
<div class="page-header">
	<h1>
		Entidades
		<small>
			<i class="icon-double-angle-right"></i>
			Listado de entidades registradas en el sistema
		</small>
	</h1>
	
</div>
<div id="msj2" class="col-xs-12" style="text-align: center; background-color: rgb(121, 168, 238); width: 50%; left: 10%; display: none;">
	<i class="i-load icon-refresh icon-spin white"></i>
	<b>Guardando...</b>
</div>

<div id="msj" class="col-xs-12" style="text-align: center; background-color: rgb(141, 248, 184); width: 50%; left: 10%; display: none;"><b>Nuevo orden guardado.</b></div>
<div class="col-xs-12" id="father">
	<div class="dd dd-draghandle">
		<?php if($this->Session->read('UserAuth.User.user_group_id') == 1) {?>
		<div class="new-entity-master">&nbsp;<i class="new-entity pull-right bigger-130 icon-plus-sign-alt m-hover orange2" title="Agregar nueva entidad"></i></div>
		<?php } ?>
		<ol class="dd-list drop" id="mainList">
			<?php 
			$kesy=0;
			//debug($entitie['people']);
			
			foreach ($entities as $key => $entitie) { 
				$children = ! empty($entitie['ChildEntity']);
				$hasUsers = ! empty($entitie['User']);
				$hasVisibles = false;
				if ($hasUsers){
					foreach ($entitie['User'] as $key => $user) {
						if ($user['visible'] == 1) {
							$hasVisibles = true;
							break;
						} 
					}
				}
			?>
			
			<?php $kesy = $kesy+1;?>

			<li class="-<?php echo $kesy; ?> ols dd-item dd2-item ui-state-default" data-id="<?php echo $entitie['Entity']['id']; ?>" data-parent-id="<?php echo $entitie['Entity']['parent_id']; ?>" data-children="<?php echo $children ?>">
				<div class="dd2-content">
					<?php if ($children && $this->Session->read('UserAuth.User.user_group_id') != 2) { ?>
					<span class="i-plus-entity m-hover"><i class="icon-plus"></i>&nbsp;</span>
					<span class="i-minus-entity m-hover"><i class="icon-minus "></i>&nbsp;</span>
					<?php } ?>
					<span class="pull-right badge"><?php echo $entitie['people'];?><i class="icon-user" style="color:black;" title="Usuarios Activos"></i></span>
					<span class="e-name"><?php echo $entitie['Entity']['name']; ?></span>
					<i class="i-load icon-refresh icon-spin blue hide"></i>
					<?php if ($this->Session->read('UserAuth.User.user_group_id') == 1) { ?>
					<i class="edit-entity icon-edit pull-right bigger-130 m-hover blue" title="Editar entidad"></i>
					<?php } ?>
					<?php 

					if ((!$hasUsers && !$children) || ($hasUsers && !$children && !$hasVisibles) || ( $entitie['people']==0)) { ?>
					<i class="delete-entity icon-trash pull-right bigger-130 m-hover red" title="Eliminar esta entidad y toda su decendencia"></i>
					<?php } else { ?>
					<i class="delete-entity-w icon-trash pull-right bigger-130 m-hover orange2" title="Eliminar esta entidad y toda su decendencia"></i>
					<?php } ?>
					<?php if ($this->Session->read('UserAuth.User.user_group_id') == 3) { ?>
					<i class="new-entity pull-right bigger-130 icon-plus-sign-alt m-hover orange2" title="Agregar nueva entidad a <?php echo $entitie['Entity']['name']; ?>"></i>
					<?php } ?>
				</div>
			</li>
			<?php } ?>
		</ol>
	</div>
	<button type="button" id="click" style="display:none;" class="btn btn-success">Guardar Cambios</button>
</div>

<div id="modalNewEntity" class="modal" tabindex="-1" aria-hidden="true" style="display: none;" data-entity-id="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="blue bigger">Nueva entidad </h4>
			</div>

			<div class="modal-body overflow-visible">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="form-group">
							<label for="form-field-username">Nombre</label>
							<div>
								<input class="input-large" type="text" id="name" placeholder="Nombre de la entidad">
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label for="form-field-first">Descripción</label>
							<div>
								<textarea class="form-control" id="description" placeholder="Breve descripción de la entidad"></textarea>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label for="form-field-username">Página Web</label>
							<div>
								<input class="input-large" type="text" id="website" placeholder="Página web">
							</div>
						</div>
						<div class="space-4"></div>
						<!--<div class="form-group">
							<label for="form-field-username">Logo de la entidad</label>
							<div>
								<div class="col-sm-10">
									<?php //$this->UploadForm->load('/file_upload/handler', true ,true);?>
									
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal">
					<i class="icon-remove"></i>
					Cancelar
				</button>

				<button class="btn btn-sm btn-primary" id="btnSaveNewEntity">
					<i class="icon-ok"></i>
					Guardar
				</button>
			</div>
		</div>
	</div>
</div>

<div id="modalEditEntity" class="modal" tabindex="-1" aria-hidden="true" style="display: none;" data-entity-id="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="blue bigger">Editar entidad </h4>
			</div>

			<div class="modal-body overflow-visible">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="form-group">
							<label for="form-field-username">Nombre</label>
							<div>
								<input class="input-large" type="text" id="editNameEntity" placeholder="Nombre de la entidad">
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label for="form-field-first">Descripción</label>
							<div>
								<textarea class="form-control" id="editDescriptionEntity" style="max-width: 542px;" placeholder="Breve descripción de la entidad"></textarea>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label for="form-field-username">Página Web</label>
							<div>
								<input class="input-large" type="text" id="editWebsiteEntity" placeholder="Página web">
							</div>
						</div>
						<div class="form-group logo-entity-form">
							<label for="form-field-username">Logo de la entidad</label>
							<div>
								<!--<input class="input-large" type="text" id="editWebsiteEntity" placeholder="Logo">-->
								<div class="col-sm-10">
									<?php $this->UploadForm->load('/file_upload/handler', true ,true ,false);?>
									<!-- <form id="editphoto" method="post" action="upload.php" enctype="multipart/form-data">
									  <input type="file" name="uploadctl" multiple />
									  <ul id="fileList">
									    The file list will be shown here
									  </ul>
									</form> -->
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="form-field-username">Mover de Entidad</label> <input id="checkEntity" type="checkbox">
							<div style = "display: none" id = "selectEntity">
								<select  class="form-control" id = "ImYourFather">	
								</select>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal">
					<i class="icon-remove"></i>
					Cancelar
				</button>

				<button class="btn btn-sm btn-primary" id="btnSaveEditEntity">
					<i class="icon-ok"></i>
					Guardar
				</button>
			</div>
		</div>
	</div>
</div>


<div id="modalNoDeleteEntity" class="modal" tabindex="-1" aria-hidden="true" style="display: none;" data-entity-id="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="blue bigger">Atención </h4>
			</div>

			<div class="modal-body overflow-visible">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						Esta entidad posee usuarios activos, para poder eliminarla debe colocar a todos sus usuarios como inactivos y eliminar las entidades dependientes de esta.
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal">
					Entiendo
				</button>
			</div>
		</div>
	</div>
</div>

<script>

</script>