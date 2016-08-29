<div id="message-error" style="left:29%;">
	<div id="gritter-item-4" class="gritter-item-wrapper gritter-success gritter-center" style="">
		<div class="gritter-top"></div>
		<div class="gritter-item">
			<div id="m-close">
				<i class="icon-remove bigger-110"></i>
			</div>
			<div class="gritter-without-image">
				<span class="gritter-title">Alerta</span>
				<p><?php echo $message; ?></p>
			</div>
			<div style="clear:both"></div>
		</div>
		<div class="gritter-bottom"></div>
	</div>
</div>
<script>
	var removeMsg = function(){
		$('#message-error').fadeOut('fast', function() {
			$('#message-error').remove();
		});
	};
	var prueba = setTimeout(function() {
		removeMsg();
	}, 4000);
	$("#message-error")
 		.on("mouseenter", function() {
 			clearTimeout(prueba);
 			$('#message-error').stop();
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
</script>