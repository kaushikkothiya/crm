<script type="text/javascript" src="<?php echo base_url(); ?>js/utopia.js">

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/chosen.jquery.js">

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cleditor.js">

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/upload/load-image.min.js">

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/upload/image-gallery.min.js">

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.queryloader2.js">

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/header.js">

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/sidebar.js">

</script>

<script src="<?php echo base_url(); ?>js/jquery.knob.js">

</script>



<!--<![endif]-->

<script type="text/javascript">

$(document).ready(function() {

    if (window.DeviceOrientationEvent) {

        window.addEventListener("orientationchange", myOrientResizeFunction, false)

    }

    $.cleditor.defaultOptions.width = "";

    $.cleditor.defaultOptions.height = "250";

    $("#input").cleditor(); 

});



function myOrientResizeFunction() {

    $.cleditor.refresh();

    $.cleditor.defaultOptions.height = "250";

    $.cleditor.updateFrame();

    $("#input").cleditor()

}

$(document).ready(function() {

    $(".nobs").trigger("mousedown")

});

$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});

</script>





</body>





</html>