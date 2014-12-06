// JavaScript Document
$(document).ready(function(e) {
	enable_cb();
	$('#checkbox1').click(enable_cb);
    function enable_cb() {
  if (this.checked) {
    $("input#pass").removeAttr("disabled");
  } else {
    $("input#pass").attr("disabled", true);
  }
}
});