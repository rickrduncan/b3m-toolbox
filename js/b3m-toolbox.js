jQuery(function($){
	$(document).ready(function(){
		// Toggle
		$(".toggle_container").hide(); 
		$("h3.trigger").click(function(){
			$(this).toggleClass("active").next().slideToggle("normal");
			return false; //Prevent the browser jump to the link anchor
		});
	}); // END doc ready
}); // END function