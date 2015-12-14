$(document).ready(function () {
    /* -- menu start-- */
    $(document).on('click', '[ui-nav] a', function (e) {
        var $this = $(e.target), $active;
        $this.is('a') || ($this = $this.closest('a'));
        
        $active = $this.parent().siblings( ".active" );
        $active && $active.toggleClass('active').find('> ul:visible').slideUp(200);
        $active.find('i.fa-angle-up').first().removeClass('fa-angle-up').addClass('fa-angle-down');
        
        ($this.parent().hasClass('active') && $this.next().slideUp(200)) || $this.next().slideDown(200);
        $this.parent().toggleClass('active');
        
        if ($this.find('i.fa-angle-down').first().hasClass('fa-angle-down')) {
            $this.find('i.fa-angle-down').first().removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $this.find('i.fa-angle-up').first().removeClass('fa-angle-up').addClass('fa-angle-down');
        }
        $this.next().is('ul') && e.preventDefault();
    });
    
    $this = $('[ui-nav] li.active').find('a').first();
    if ($this.find('i.fa-angle-down').first().hasClass('fa-angle-down')) {
        $this.find('i.fa-angle-down').first().removeClass('fa-angle-down').addClass('fa-angle-up');
    } else {
        $this.find('i.fa-angle-up').first().removeClass('fa-angle-up').addClass('fa-angle-down');
    }
    /* -- menu end  -- */
    
    /* -loader start- */
    $(window).on('unload', function(){
        $("div.overlay").show();
    });
    $('form').on('submit', function(){
        $("div.overlay").show();
    });
    $( document ).ajaxStart(function() {
        $("div.overlay").show();
    });
    $( document ).ajaxComplete(function() {
        $("div.overlay").hide();
    });
    /* -loader end- */

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