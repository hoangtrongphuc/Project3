// JavaScript Document
	
	$(document).ready(function(e) {
		
                   
				  $("#new").click(function() {
				
					$.fancybox.open({
					href : '../newroom/index.php',
					type : 'iframe',
					padding : 0,
					height: 300,
					width :500,
					
				});
			});
			
			$("#shop").click(function() {
				
					$.fancybox.open({
					href : '../layout/update.php',
					type : 'iframe',
					padding : 0,
					height: 300,
					width :500,
					
				});
			});
			
			$("a.fr").click(function() {
				
					$.fancybox.open({
					href : '../layout/profile.php',
					type : 'iframe',
					padding : 0,
					height: 340,
					width :290,
					
				});
			});
			
                        });
						
	