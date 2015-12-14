<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico">
<title><?php echo $this->config->item('TITLE'); ?>Monopolion - Real Estate</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datatable/jquery.dataTables.min.css">

<link href="<?php echo base_url(); ?>new/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>new/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>new/css/style.css" rel="stylesheet" type="text/css" charset="utf-8" />

<link href="<?php echo base_url(); ?>css/ie.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/calender.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/gallery/modal.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/toaster.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/jquery.cleditor.css" rel="stylesheet" type="text/css"/>
<!-- <link href="<?php echo base_url(); ?>css/loader/demo.css" rel="stylesheet"> -->

<link rel="stylesheet" href="<?php echo base_url(); ?>css/datetimepicker/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datetimepicker/jquery-ui-timepicker-addon.css">

<!-- Custom styles for this template -->
<?php
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
?>

<link href="<?php echo base_url(); ?>css/fullcalendar.css" rel="stylesheet">

<style type="text/css">
<?php if($controller=="calendar" && $action=="index"){ ?>
    .fc{
        width: 100% !important;
    }
    .fc-today-button, .fc-prev-button, .fc-next-button, .fc-month-button, .fc-agendaWeek-button, .fc-agendaDay-button, .fc-popover{
        width:auto !important;
    }
    .resize {
        width: auto !important;
        margin: 0 auto;
    }
    .fc-time{
        display : none;
    }
<?php } ?>
</style>
</head>
<body>
    <div class="overlay"><span class="loader">&nbsp;</span></div>
<div class="app">
	<div class="modal"></div>
    