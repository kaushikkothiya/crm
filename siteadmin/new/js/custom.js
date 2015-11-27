$(document).ready(function () {
    $('.side-nav li a').on('click', function () {
    	 $(".navbar-collapse").collapse('hide');
        if ($(this).find('i.fa-angle-down').first().hasClass('fa-angle-down')) {
            $(this).find('i.fa-angle-down').first().removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $(this).find('i.fa-angle-up').first().removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });

/*===Tooltip Start===*/
	
	$("[rel='tooltip']").tooltip();
	
	
	$(function () { 
		$("[data-toggle='tooltip']").tooltip({html: true});
	});
	$(function () { 
		$("[data-toggle='popover']").popover();
	});
	/*===Tooltip end===*/
	
});