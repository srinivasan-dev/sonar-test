<script type="text/javascript">

$(document).ready(function () {
    $(document).click(function (event) {
        var clickover = $(event.target);

        console.log(clickover.closest('.navbar-toggle').length);

        if (clickover.closest('.navbar-toggle').length > 0){
        	return false;
        }

        // if ($("#demo-list").css("display") == 'block') {
        	if ($("#demo-list").css("display") == 'block'  && $(window).outerWidth()<=767) {
            $("button.navbar-toggle").trigger('click');
        }
    });
});

jQuery(document).ready(function () {
	//jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
	
});

$(function(){
	$("#demo-list li").click(function(){
		$("#demo-list li.active").removeClass("active")
		$(this).addClass("active");
	});
	$('button.navbar-toggle').click(function(){
		$('#demo-list').toggle();
	});
	
});
function isNumberKey(evt) {
		if(evt.which!=0) {
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
		} else {
			return true;
		}
	}
</script>

</body>
</html>
