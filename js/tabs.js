jQuery(document).ready(function($){
	$(".nav-tabs a").click(function(){
		$(this).tab('show');
	});

	$(".tab_drawer_heading").click(function() {
		$(this).tab('show');

		$(".tab_drawer_heading").removeClass("d_active");
		$(this).addClass("d_active");

	});
});