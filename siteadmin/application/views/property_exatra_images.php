<?php
	$id = $this->uri->segment(3);
	$this->load->view('header');
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<?php $this->load->view('admin_top_nav'); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span2 sidebar-container">
			<div class="sidebar">
				<div class="navbar sidebar-toggle">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
					</div>
				</div>
				<?php
				$this->load->view('leftmenu');
				?>
			</div>
		</div>
		<style type="text/css">
			a.delete { 
				background-color: white;
				display:none;position:absolute;
				top:0;right:0;width:30px;height:30px;
				text-indent:-999px;
				background-image:url("../../../img/icons/close.png");
				background-repeat:  no-repeat;
				background-position: center; 
			}
			.image:hover a.delete { display:block; }
			.imageBox{
				width:100px;height:100px;float:left;
				margin:0px 7px 7px 0px;vertical-align:middle;
				display:inline-block;position:relative;
			}
		</style>
		<div class="span10 body-container">
			<div class="row-fluid">
				<div class="span12">
					<ul class="breadcrumb">
						<li>
							<?php echo anchor('home', 'Home', "title='Home'"); ?>
							<span class="divider">/</span>
						</li>
						<li>
							<?php echo anchor('home/property_manage', 'Manage Property', "title='Manage Property'"); ?>
							<span class="divider">/</span>
						</li>
						<li>
							<?php echo anchor('home/propertyExatraImages/'.$id, 'Add Property Extra Images', "title='Add Property Extra Images'"); ?> 
						</li>
						<!-- <li style="float:right;"><a href="add_customer"><input type="button" value="" /></a></li> -->
					</ul>
				</div>
			</div>
            <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php } ?>

			<div class="row-fluid">
				<div class="span12">
					<section id="formElement" class="utopia-widget utopia-form-box section">
						<div class="utopia-widget-title">
						<span>
						    Add Property Extra Images
						</span>
						</div>
						
						<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/multifileuplod/uploadfile.css">
						<script src="<?php echo base_url(); ?>js/multifileuplod/jquery.uploadfile.min.js" type="text/javascript"></script>
						
						<div class="row-fluid">
							<div class="utopia-widget-content">
								<div class="span6 utopia-form-freeSpace">
									<?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
									<fieldset>
										<!-- <input type="hidden" id="property_id" name="property_id" value="<?php if(isset($id) && !empty($id)){ echo $id; } ?>"> -->
										
										<div class="control-group">
											<label class="control-label" for=""><h3>Property Reference No :	</h3></label>
											<div class="controls">
											<?php
												if(!empty($getPropertyDetails))
												{
												?>
													<label style="margin-top:11px;"><?php echo $getPropertyDetails[0]->reference_no; ?></label>
												<?php
												}
												?>
											</div>
										</div>
										<hr/>
										<div class="control-group">
											<label class="control-label" for=""><h3>Upload Images :	</h3></label>
											<div class="controls">
												<div id="fileuploader">Upload</div>
												<div id="extrabutton" class="ajax-file-upload-green">Start Upload</div>
											</div>
										</div>
										<hr/>
										<div class="control-group">
											<label class="control-label" for=""><h3>Property All Images :	</h3></label>
											<div class="controls">
												<div id="propertyExImages">
													<?php
														if(!empty($allPropertyImages))
														{
															foreach ($allPropertyImages as $key => $value)
															{
																//echo '<span style="width:100px;height:100px;padding:30px 0px;margin:0px 5px 20px 0px;border:1px solid #ccc"><img src='.base_url().'upload/property/100x100/'.$value->image_name.' style="padding:5px"></span>';
																?>
																<div class="thumbnail imageBox image" id="thumbnail<?php echo $value->id?>">
																    <img src='<?php echo base_url() ?>upload/property/100x100/<?php echo $value->image_name ?>'>
													            	<a href="#" class="delete" onclick="deletePropertyExtraImg(<?php echo $value->id; ?>)">Delete</a>
													            </div>
																<?php
															}
														}
														?>
												</div>
												<div id="modal-gallery" class="modal modal-gallery hide fade">
													<div class="modal-header"><a class="close" data-dismiss="modal">&times;</a><h3 class="modal-title">Image Gallery</h3>
													</div>
													<div class="modal-body">
														<div class="modal-image"></div>
													</div>
												</div>
												<div id="gallery" data-toggle="" data-target="">
														
													<a>
														<!-- <img src="<?php echo base_url().'upload/property/'.$image; ?>" width="100" height="100"> -->
													</a>
												</div>
												<div class="error"><?php //if (isset($msg)) //echo $msg; ?></div>
											</div>
										</div>
									</fieldset>
									</form>
								</div>
								<div class="span6 utopia-form-freeSpace"></div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

$this->load->view('footer');

?>

<script type="text/javascript">

function numbersonly(e){ 	 
    var unicode=e.charCode? e.charCode : e.keyCode;    
    
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    
        if ((unicode<48||unicode>57) && unicode!=46 ) //if not a number
            return false //disable key press
    }
}

function deletePropertyExtraImg(propertyImgId)
{
	var confirmImg = confirm("Are you sure to delete?");
	if(confirmImg == true)
	{
		$.ajax({
		    url : baseurl+"index.php/home/deletePropertyExtImg",
		    type: "POST",
		    data : {propertyImgId: propertyImgId},
		    success: function(data, textStatus, jqXHR)
		    {
		    	if(data == 1)
		    	{
		    		$("#thumbnail"+propertyImgId).remove();
		    	}
		    },
		    error: function (jqXHR, textStatus, errorThrown)
		    {
		 
		    }
		});
	}

}

$(document).ready(function () {
	 var extraObj = $("#fileuploader").uploadFile({url: baseurl+"index.php/home/addpropertyExatraImagesByAjax/<?php echo $id?>",
	dragDrop: true,
	fileName: "myfile",
	//multiple:true,
	acceptFiles:"image/*",
	returnType: "json",
	//showCancel: true,
	showDelete: true,
	//showDownload:true,
	statusBarWidth:600,
	dragdropWidth:600,
	autoSubmit:false,
	onSuccess:function(files,data,xhr,pd)
	{
		$("#propertyExImages").append("<div class='thumbnail imageBox image' id='thumbnail"+data['fileId']+"'><img src='<?php echo base_url() ?>upload/property/100x100/"+data['filename']+"' ><a href='#'' class='delete' onclick='deletePropertyExtraImg("+data['fileId']+")'>Delete</a></div>");
	},
	afterUploadAll:function(obj)
	{
		$("div.ajax-file-upload-statusbar").remove();
	},
	// deleteCallback: function (data, pd) {
	// 	for (var i = 0; i < data.length; i++) {
	//         $.post("delete.php", {op: "delete",name: data[i]},
	//             function (resp,textStatus, jqXHR) {
	//                 //Show Message	
	//                 alert("File Deleted");
	//             });
	//     }
	//     pd.statusbar.hide(); //You choice.

	// },
	// downloadCallback:function(filename,pd)
	// 	{
	// 		location.href="download.php?filename="+filename;
	// 	}
	}); 
	$("#extrabutton").click(function()
	{
		extraObj.startUpload();
	}); 
});

</script>