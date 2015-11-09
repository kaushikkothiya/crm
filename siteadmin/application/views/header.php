<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <title>Monopolion Management</title> -->
<!doctype html>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>monopolion</title>
</head>
<body>
<!-- <!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>monopolion</title>
 -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.css" />
         <link href="<?php echo base_url(); ?>css/bootstrap.min_new.css" rel="stylesheet">
         
        <link class="theme-css" href="<?php echo base_url(); ?>css/utopia-white3a1a.css?v99" rel="stylesheet">
<!-- validation css start-->
    <!-- validation css end-->
        <link href="<?php echo base_url(); ?>css/utopia-responsive.css" rel="stylesheet">

                        

        <link href="<?php echo base_url(); ?>css/ie.css" rel="stylesheet">

        
        <link href="<?php echo base_url(); ?>css/calender.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/gallery/modal.css" rel="stylesheet">

       
         <link href="<?php echo base_url(); ?>css/toaster.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/jquery.cleditor.css" rel="stylesheet" type="text/css"/>

       
        
        <link href="<?php echo base_url(); ?>css/loader/demo.css" rel="stylesheet">

        

        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>
       <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>-->
       <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js">
        </script>
        
        <!--validation js start -->
        <!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/validation-min.js"></script>-->
        <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.toaster.js"></script>-->
        <!--validation js end -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/toaster.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cookie.js">

        </script>
        
        <script>if($.cookie("css")){$('link[href*="utopia-white.css"]').attr("href",$.cookie("css"));$('link[href*="utopia-dark.css"]').attr("href",$.cookie("css"))}$(document).ready(function(){$(".theme-changer a").live("click",function(){$('link[href*="utopia-white.css"]').attr("href",$(this).attr("rel"));$('link[href*="utopia-dark.css"]').attr("href",$(this).attr("rel"));$.cookie("css",$(this).attr("rel"),{expires:365,path:"/"});return false})});
        var baseurl = '<?php echo base_url(); ?>';
        </script>

            

        <!--[if IE 8]>

        <link href="css/ie8.css" rel="stylesheet"><![endif]-->

        <!--[if lt IE 9]>

        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">

        </script><![endif]-->

        <!--[if gte IE 9]>

        <style type="text/css">.gradient{filter:none}

        </style><![endif]-->

        

        <!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.datetimepicker.css">

        <script src="<?php echo base_url(); ?>js/jquery.datetimepicker.js"></script>-->

        <link rel="stylesheet" href="<?php echo base_url(); ?>css/datetimepicker/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/datetimepicker/jquery-ui-timepicker-addon.css">

        <script src="<?php echo base_url(); ?>js/datetimepicker/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datetimepicker/jquery-ui-timepicker-addon.js"></script>
        <script src="<?php echo base_url(); ?>js/datetimepicker/jquery-ui-timepicker-addon-i18n.min.js"></script>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../media/css/jquery.dataTables.css">

        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>../media/js/jquery.dataTables.js"></script>

        <script type="text/javascript" language="javascript" class="init">

       

            $.fn.dataTable.ext.type.order['salary-grade-pre'] = function ( d ) {

                    switch ( d ) {

                            case 'Low':    return 1;

                            case 'Medium': return 2;

                            case 'High':   return 3;

                    }

                    return 0;

            };



            $(document).ready(function() {
$('#example,#example1').dataTable({"order": [[ 0, "desc" ]],'lengthMenu': [30, 60, 90, 150, 300],});
                    $('#example2').dataTable( {
                        
"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
    
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                	
                    return intVal(a) + intVal(b);
                } );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            
            $( api.column( 3 ).footer() ).html(
                pageTotal 
            );
        },
                   } );

            } );



        </script>

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

        </head>

        <body>
        <div class="modal"></div>
         <link rel="stylesheet" href="<?php echo base_url(); ?>css/menu/menustyles.css">
  