$.extend(CE.tags, {
	index: function() {
		var filterTag = function(text){
            $.each($('tbody tr'),function(){
                var name = $(this).find('.td-name').attr('data-tag-name');
                if (name) {
                	name = name.toLowerCase();
               		if (name.match(text)) $(this).fadeIn();
               		else $(this).fadeOut();
                }
            })
        };
        var timer = 0;
		$('#searchTag').keyup(function(){
			clearTimeout(timer);
			timer = setTimeout(function(){
				var q = $('#searchTag').val();
				filterTag(q);
			}, 250)
		});
	}
});