<!--Footer-->
  <div class="sep clearfix"></div>
  <footer class="text-center app-footer"> <small class="text-muted">&copy; 2015 Monopolion - Real Estate.</small> </footer>
  <!--Footer end--> 
</div>
<script type="text/javascript">var baseurl = '<?php echo base_url(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.queryloader2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/custom.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/datetimepicker/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datetimepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datetimepicker/jquery-ui-timepicker-addon-i18n.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/datatable/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/toaster.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cleditor.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/upload/load-image.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/upload/image-gallery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.knob.js"></script>

<script type="text/javascript" charset="utf-8">
    function strip(html) {
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
     }
        $(document).ready(function() {
            
            $.fn.dataTable.moment = function ( format, locale ) {
                var types = $.fn.dataTable.ext.type;

                // Add type detection
                types.detect.unshift( function ( d ) {
                    return moment( strip(d), format, locale, true ).isValid() ?
                        'moment-'+format :
                        null;
                } );

                // Add sorting method - use an integer for the sorting
                types.order[ 'moment-'+format+'-pre' ] = function ( d ) {
                    return moment( d, format, locale, true ).unix();
                };
            };
            
            $.fn.dataTable.moment('D-MMM-YYYY');
            
            $('#example').DataTable({
              "lengthMenu": [ 15, 30, 45, 60, 75 ],
                "order": [[ 0, "desc" ]]
             });
             
             $('#inquiry_list').DataTable({
              "lengthMenu": [ 15, 30, 45, 60, 75 ],
                "order": [[ 7, "desc" ]]
             });
             $('#inquiry_list')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered responsive-table');
            
            
            $('#example')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered responsive-table');
            
            
            
        } );

function myOrientResizeFunction() {
    //$.cleditor.refresh();
    //$.cleditor.defaultOptions.height = "250";
    //$.cleditor.updateFrame();
    //$("#input").cleditor()
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


