/**
 * 
 */
$(document).ready(function(){
	function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ')
                c = c.substring(1);
            if (c.indexOf(name) !== -1)
                return c.substring(name.length, c.length);
        }
        return "";
    }
	
	$("#submit_card").click(function(){
		var id = getCookie("cookie_id");
		var provider = $("#provider").val();
		var code = $("#code").val();
		var serial = $("#serial").val();
		var xu = 1;
		var date = new Date();
		ngay = date.getDate();
		
		$.ajax({
			url : "http://localhost:8080/rest/index.php?api=napxu",
			type : "post",
			dataType : "json",
			data : "xu="+xu+"&user_id="+id+"&provider="+provider+"&code="+code+"&serial="+serial+"&date="+ngay,
			async : false,
			success : function(result){
				alert(JSON.stringify(result));
			},
			error : function(err){
				alert(JSON.stringify(err));
			}
		});
	});
});
