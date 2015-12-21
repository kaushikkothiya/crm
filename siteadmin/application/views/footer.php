<!--Footer-->

  <div class="sep clearfix"></div>
  <footer class="text-center app-footer"> <small class="text-muted">&copy; <?php echo date('Y'); ?> Monopolion - Real Estate.</small> </footer>
  <!--Footer end--> 
</div>
<script type="text/javascript">var baseurl = '<?php echo base_url(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/datetimepicker/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.queryloader2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>new/js/custom.js"></script>

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
    
    function getPrice(name) {
        var rankNumber;

        rankNumber = replaceAll(name,"<div>","");
        rankNumber = replaceAll(rankNumber,"</div>","");
        rankNumber = replaceAll(rankNumber,"€","");
        rankNumber = replaceAll(rankNumber,",","");
        rankNumber = replaceAll(rankNumber,"SP.","");
        rankNumber = replaceAll(rankNumber,"RP.","");
        rankNumber = replaceAll(rankNumber,"<br>","");
        rankNumber = replaceAll(rankNumber," ","");
        rankNumber = replaceAll(rankNumber,"/","");

        if(!isNaN(rankNumber) && rankNumber!=""){
            rankNumber = parseInt(rankNumber);
        }else{
            rankNumber = 0;
        }
        return rankNumber;
    }
    
    function getRefno(val) {
        var rankNumber;

        rankNumber = replaceAll(val,"<div>","");
        rankNumber = replaceAll(rankNumber,"</div>","");
        rankNumber = rankNumber.split("<br>");
        rankNumber = rankNumber[0];

        if(!isNaN(rankNumber) && rankNumber!=""){
            rankNumber = parseInt(rankNumber);
        }else{
            rankNumber = 0;
        }
        return rankNumber;
    }
    
    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find, 'g'), replace);
    }
    
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
                     
            jQuery.fn.dataTableExt.oSort["price-desc"] = function (x, y) {
                var xVal = getPrice(x);
                var yVal = getPrice(y);

                if (xVal < yVal) {
                    return 1;
                } else if (xVal > yVal) {
                    return -1;
                } else {
                    return 0;
                }  
            };

            jQuery.fn.dataTableExt.oSort["price-asc"] = function (x, y) {
                var xVal = getPrice(x);
                var yVal = getPrice(y);

                if (xVal < yVal) {
                    return -1;
                } else if (xVal > yVal) {
                    return 1;
                } else {
                    return 0;
                }
            }
                        
            jQuery.fn.dataTableExt.oSort["refno-desc"] = function (x, y) {
                var xVal = getRefno(x);
                var yVal = getRefno(y);

                if (xVal < yVal) {
                    return 1;
                } else if (xVal > yVal) {
                    return -1;
                } else {
                    return 0;
                }
            };

            jQuery.fn.dataTableExt.oSort["refno-asc"] = function (x, y) {
                var xVal = getRefno(x);
                var yVal = getRefno(y);

                if (xVal < yVal) {
                    return -1;
                } else if (xVal > yVal) {
                    return 1;
                } else {
                    return 0;
                }
            }
            
            $.fn.dataTable.moment('D-MMM-YYYY');
            
            $('#example').DataTable({
              "lengthMenu": [ 15, 30, 45, 60, 75 ],
                "order": [[ 0, "desc" ]],
		"columnDefs": [
            	{
                "targets": [ 0 ],
                "visible": false
            	}
        	]	
             });
             
            $('#property-list').DataTable({
                "lengthMenu": [ 15, 30, 45, 60, 75 ],
                "aoColumnDefs": [{ "sType": 'price', "aTargets": [5] }],
                "aoColumnDefs": [{ "sType": 'refno', "aTargets": [1] }],
                "order": [[ 0, "desc" ]],
                "columnDefs": [{
                    "targets": [ 0 ],
                    "visible": false
                }]
            });
            
            $('#search-property-list').DataTable({
                "lengthMenu": [ 15, 30, 45, 60, 75 ],
                "aoColumnDefs": [{ "sType": 'price', "aTargets": [5] }],
                "aoColumnDefs": [{ "sType": 'refno', "aTargets": [1] }],
                "order": [[ 0, "desc" ]],
                "columnDefs": [{
                    "targets": [ 0 ],
                    "visible": false
                }]
            });
             
             $('#inquiry_list').DataTable({
              "lengthMenu": [ 15, 30, 45, 60, 75 ],
                "order": [[ 7, "desc" ]],
		"columnDefs": [
            	{
                "targets": [ 0 ],
                "visible": false
            	}
        	]	
             });
             $('#inquiry_list')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered responsive-table');
            
            $('#inquiry_list')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered responsive-table');
            
            $('#example')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered responsive-table');
            
            $('#property-list')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered responsive-table');
    
            $('#search-property-list')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered responsive-table');

             jQuery.validator.addMethod("noHTML", function(value, element) {
                return this.optional(element) || /^([A-Za-z0-9]+)$/.test(value);
            }, "Please enter valid text!");
            
        });

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


