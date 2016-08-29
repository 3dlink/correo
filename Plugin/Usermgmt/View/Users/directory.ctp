<?php //debug($users, $showHtml = null, $showFrom = true) 
 $l = '';
 if (isset($_GET['l'])){
 	$l = $_GET['l'];
 }
 if (isset($_GET['tab'])){
 	$tab = $_GET['tab'];
 }
?>
<div class="page-header" id="pisame">
	<h1>
		Directorio
		<small>
			<i class="icon-double-angle-right"></i>
			listado de personas registradas en el sistema
		</small>
	</h1>
</div>
<div class="col-xs-12">
	<div class="widget-box transparent">
		<div class="widget-header">

			<div class="widget-toolbar no-border" style="float:left;">
				<ul class="nav nav-tabs" id="myTab2">
					<li class="<?php if ($tab == 'e') echo 'active'; ?>">
						<a data-toggle="tab" href="#profile2">Entidades</a>
					</li>
					<li class="<?php if ($tab == 'g') echo 'active'; ?>">
						<a data-toggle="tab" href="#groups">Grupos Estatales</a>
					</li>

					<li class="<?php if ($tab == 'gi') echo 'active'; ?>">
						<a data-toggle="tab" href="#groupsi">Grupos Institucionales</a>
					</li>

					<li class="<?php if ($tab == 'c') echo 'active'; ?>">
						<a data-toggle="tab" href="#circles">Círculos</a>
					</li>
			<!-- 		<li class="<?php if ($tab == 'p') echo 'active'; ?>">
						<a data-toggle="tab" href="#persons">Personas</a>
					</li> -->
				</ul>
			</div>
		</div>
 
		<div class="widget-body">
			<div class="widget-main padding-12 no-padding-left no-padding-right">
				<div class="tab-content padding-4">
					<div id="persons" class="tab-pane in <?php if ($tab == 'p') echo 'active'; ?>">
						<div class="col-xs-12">
							<form class="form-search pull-right" action="<?php echo $this->webroot.'directory/' ?>">
								<span class="input-icon">
									<input type="text" placeholder="Buscar ..." class="nav-search-input" id="search-people" autocomplete="off" name="q">
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
						<br><br>
						<div class="col-xs-12">
							<div class="message-container">
								<div id="id-message-list-navbar" class="message-navbar align-center clearfix">
									<div class="message-bar">
										<div class="message-infobar" id="id-message-infobar">
											<span class="blue bigger-150">&nbsp;</span>
										</div>
									</div>
									<div>
										<div>
											<span class="abc <?php if ($l=='a') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=a&tab=p'?>">A</a></span>
											<span class="abc <?php if ($l=='b') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=b&tab=p'?>">B</a></span>
											<span class="abc <?php if ($l=='c') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=c&tab=p'?>">C</a></span>
											<span class="abc <?php if ($l=='d') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=d&tab=p'?>">D</a></span>
											<span class="abc <?php if ($l=='e') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=e&tab=p'?>">E</a></span>
											<span class="abc <?php if ($l=='f') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=f&tab=p'?>">F</a></span>
											<span class="abc <?php if ($l=='g') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=g&tab=p'?>">G</a></span>
											<span class="abc <?php if ($l=='h') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=h&tab=p'?>">H</a></span>
											<span class="abc <?php if ($l=='i') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=i&tab=p'?>">I</a></span>
											<span class="abc <?php if ($l=='j') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=j&tab=p'?>">J</a></span>
											<span class="abc <?php if ($l=='k') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=k&tab=p'?>">K</a></span>
											<span class="abc <?php if ($l=='l') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=l&tab=p'?>">L</a></span>
											<span class="abc <?php if ($l=='m') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=m&tab=p'?>">M</a></span>
											<span class="abc <?php if ($l=='n') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=n&tab=p'?>">N</a></span>
											<span class="abc <?php if ($l=='ñ') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=ñ&tab=p'?>">Ñ</a></span>
											<span class="abc <?php if ($l=='o') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=o&tab=p'?>">O</a></span>
											<span class="abc <?php if ($l=='p') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=p&tab=p'?>">P</a></span>
											<span class="abc <?php if ($l=='q') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=q&tab=p'?>">Q</a></span>
											<span class="abc <?php if ($l=='r') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=r&tab=p'?>">R</a></span>
											<span class="abc <?php if ($l=='s') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=s&tab=p'?>">S</a></span>
											<span class="abc <?php if ($l=='t') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=t&tab=p'?>">T</a></span>
											<span class="abc <?php if ($l=='u') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=u&tab=p'?>">U</a></span>
											<span class="abc <?php if ($l=='v') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=v&tab=p'?>">V</a></span>
											<span class="abc <?php if ($l=='w') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=w&tab=p'?>">W</a></span>
											<span class="abc <?php if ($l=='x') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=x&tab=p'?>">X</a></span>
											<span class="abc <?php if ($l=='y') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=y&tab=p'?>">Y</a></span>
											<span class="abc <?php if ($l=='z') echo 'active' ?>"><a href="<?php echo $this->webroot.'directory/?l=z&tab=p'?>">Z</a></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Apellidos</th>
														<th>Teléfono</th>
														<th>Móvil</th>
														<th>Posee Firma</th>
														<th>Entidad</th>
														<th>Correo</th>
														<th>&nbsp;</th>
													</tr>
												</thead>
												<tbody>
													<?php if (!empty($users)) {?>
													<?php foreach ($users as $key => $user) {  ?>
													<tr>
														<td><?php echo $user['User']['first_name'] ?></td>
														<td><?php echo $user['User']['last_name'] ?></td>
														<td><?php echo $user['User']['telephone'] ?></td>
														<td><?php echo $user['User']['celphone'] ?></td>
														<td><?php echo $user['User']['signed'] ?></td>
														<td><?php echo $user['path']?></td>
														<td><?php echo $user['User']['email']?></td>
														<td class="text-center">
															<a href="<?php echo $this->webroot.'communications/add/?usrid='.$user['User']['id'] ?>" class="btn btn-xs btn-info">
																<i class="icon-envelope bigger-120"></i>
															</a>
														</td>
													</tr>
													<?php } ?>
													<?php } else { ?>
													<tr>
														<td colspan="7" class="text-center"> No hay datos que mostrar </td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
								</div>
							</div>
						</div>
					</div>
					<div id="profile2" class="tab-pane <?php if ($tab == 'e') echo 'active'; ?>">
						<div class="selects-entity">
							<div class="form-group">
								<label class="col-sm-2 	 control-label no-padding-right text-right" for="form-field-1"> Entidad </label>
								<div class="col-sm-10 ">
									<select name="entity_id" class="col-xs-10 col-sm-5 s-entity">
									<option value="0">Seleccione</option>
									<?php  
										foreach ($entities as $key => $entity) {
										$child = !empty($entity['ChildEntity']);
									?>		
									<option class="opt-entity" value="<?php echo $entity['Entity']['id'] ?>" data-child="<?php echo $child; ?>"><?php echo $entity['Entity']['name'] ?></option>
									<?php 
										}
									?>
									</select>
								</div>
							</div>
							<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
						</div>
						<div class=" btns">
							<span class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<span class="pull-right">
								<button id="btn-find-by-entity" class="btn btn-info" type="button">
									Buscar
								</button>&nbsp;
							</span>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<br>	
								<div class="table-responsive">
									<div id="count2"></div>
									<input style="display:none;" type="text" placeholder="Buscar por nombre" id="searchName">

									<table id="table-2" class="table table-striped table-bordered table-hover">
										
									</table>
								</div><!-- /.table-responsive -->
							</div><!-- /span -->
						</div>
						<div class="pull-right btns">
							<span id="" class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<br><br>	
						</div>
					</div>

					<div id="groups" class="tab-pane <?php if ($tab == 'g') echo 'active'; ?>">
						<div class="selects-group">
							<div class="form-group">
								<label class="col-sm-2 	 control-label no-padding-right text-right" for="form-field-1"> Grupo Estatal</label>
								<div class="col-sm-10 ">
									<select name="group_id" class="col-xs-10 col-sm-5 s-entity">
									<option value="0">Seleccione</option>
									<?php  
										foreach ($groups as $key => $group) {
									?>		
									<option class="opt-group" value="<?php echo $key ?>"><?php echo $group ?></option>
									<?php 
										}
									?>
									</select>
								</div>
							</div>
							<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
						</div>
						<div class=" btns">
							<span class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<span class="pull-right">
								<button id="btn-find-by-group" class="btn btn-info" type="button">
									Buscar
								</button>&nbsp;
							</span>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<br>	
								<div class="table-responsive">
									<div id="count3"></div>
									<table id="table-3" class="table table-striped table-bordered table-hover">
										
									</table>
								</div><!-- /.table-responsive -->
							</div><!-- /span -->
						</div>
						<div class="pull-right btns">
							<span id="" class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<br><br>	
						</div>
					</div>



					<div id="groupsi" class="tab-pane <?php if ($tab == 'g') echo 'active'; ?>">
						<div class="selects-group">
							<div class="form-group">
								<label class="col-sm-2 	 control-label no-padding-right text-right" for="form-field-1"> Grupo Institucional</label>
								<div class="col-sm-10 ">
									<select name="group_id" class="col-xs-10 col-sm-5 s-entity">
									<option value="0">Seleccione</option>
									<?php  
										foreach ($groupsi as $key => $group) {
									?>		
									<option class="opt-groupi" value="<?php echo $key ?>"><?php echo $group ?></option>
									<?php 
										}
									?>
									</select>
								</div>
							</div>
							<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
						</div>
						<div class=" btns">
							<span class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<span class="pull-right">
								<button id="btn-find-by-groupi" class="btn btn-info" type="button">
									Buscar
								</button>&nbsp;
							</span>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<br>	
								<div class="table-responsive">
									<div id="count3i"></div>
									<table id="table-3i" class="table table-striped table-bordered table-hover">
										
									</table>
								</div><!-- /.table-responsive -->
							</div><!-- /span -->
						</div>
						<div class="pull-right btns">
							<span id="" class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<br><br>	
						</div>
					</div>


					<div id="circles" class="tab-pane <?php if ($tab == 'c') echo 'active'; ?>">
						<div class="selects-group">
							<div class="form-group">
								<label class="col-sm-2 	 control-label no-padding-right text-right" for="form-field-1"> Círculo </label>
								<div class="col-sm-10 ">
									<select name="circle_id" class="col-xs-10 col-sm-5 s-entity">
									<option value="0">Seleccione</option>
									<?php  
										foreach ($circles as $key => $circle) {
									?>		
									<option class="opt-circle" value="<?php echo $key ?>"><?php echo $circle ?></option>
									<?php 
										}
									?>
									</select>
								</div>
							</div>
							<div style="text-align:center;"><i class="i-load hide icon-refresh icon-spin blue"></i></div>
						</div>
						<div class=" btns">
							<span class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<span class="pull-right">
								<button id="btn-find-by-circle" class="btn btn-info" type="button">
									Buscar
								</button>&nbsp;
							</span>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<br>	
								<div class="table-responsive">
									<div id="count4"></div>
									<table id="table-4" class="table table-striped table-bordered table-hover">
										
									</table>
								</div><!-- /.table-responsive -->
							</div><!-- /span -->
						</div>
						<div class="pull-right btns">
							<span id="" class="spn-send-msg pull-right hide">
								<button class="btn-send-msg btn btn-info" type="button" title="Enviar Comunicación">
									<i class=" icon-envelope bigger-130"></i>
								</button>&nbsp;
							</span>
							<br><br>	
						</div>
					</div>
				</div>

				</div>
			</div>
		</div>
	</div>
</div>


