<?php

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
                    <div class="container"><a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar">
                            </span>
                            <span class="icon-bar">
                            </span>
                            <span class="icon-bar">
                            </span></a>
                    </div>
                </div>
                <?php
                $this->load->view('leftmenu');
                ?>
            </div>
        </div>
        <link href="<?php echo base_url(); ?>css/popupbox.css" rel="stylesheet">
        <div class="span10 body-container">
            <div class="row-fluid">
                <div class="span12">
                    <ul class="breadcrumb">
                        <li><?php echo anchor('home', 'Home', "title='Home'"); ?>
                            <span class="divider">/
                            </span></li>
                        <li><?php echo anchor('home/property_manage', 'Property Management', "title='Property Management'"); ?>
                            <span class="divider">
                            </span></li>
                        		<li style="float:right;"><a href="add_property"><input type="button" value="Add New" /></a></li>
                                <?if ($this->session->userdata('logged_in_super_user')) { ?>
                                    <li style="float:right;  margin-right:10px;"><a href='#popup2'><input type="button" value="Import Excel File" /></a></li>
                                <?php } ?>
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
                <div class="span12"><section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <span>Property Management </span>
                            
                        </div>
                        <div class="utopia-widget-content">
                            <div class="table-responsive">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                       <th hidden>Id</th>
                                       <th>Reference No</th>
                                       <th>Agent Name</th>
                                       <th>Property Area</th>
                                       <th>Property Status</th>
                                       <th>Price(€)</th>
                                       <th>Furnish Type</th>
                                       <th>Image</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($user); $i++) {
                                        echo "<tr>";
                                        echo "<td hidden>" . $user[$i]->id. "</td>";
                                        echo "<td>" . $user[$i]->reference_no.'</br></br>Created on '.date("d-M-Y", strtotime($user[$i]->created_date)). "</td>";
                                        echo "<td>" . $user[$i]->fname.' '.$user[$i]->lname. "</td>";
                                        echo "<td>" . $user[$i]->title. "</td>";
                                        
                                        if($user[$i]->type =='1'){
                                            echo "<td>" .'Sale'. "</td>";
                                            if(!empty($user[$i]->sale_price)){
                                                echo "<td>" .'€'.$user[$i]->sale_price. "</td>";
                                            }else{
                                                echo "<td> </td>";
                                            }
                                        }elseif ($user[$i]->type =='2') {
                                           echo "<td>" .'Rent'. "</td>";
                                           if(!empty($user[$i]->rent_price)){
                                                echo "<td>" .'€'.$user[$i]->rent_price. "</td>";
                                            }else{
                                                echo "<td> </td>";   
                                            }
                                        }elseif ($user[$i]->type =='3') {
                                           echo "<td>" .'Both(Sale/Rent)'. "</td>";
                                           if(!empty($user[$i]->sale_price) || !empty($user[$i]->rent_price)){
                                                echo "<td> SP. €". $user[$i]->sale_price." / RP. €".$user[$i]->rent_price. "</td>";
                                            }else{
                                             echo "<td> </td>";      
                                            }
                                        }else{
                                            echo "<td> </td>"; 
                                            echo "<td> </td>"; 
                                        }
                                        if($user[$i]->furnished_type =='1'){
                                            echo "<td> Furnished </td>";
                                            
                                        }elseif ($user[$i]->furnished_type =='2') {
                                           echo "<td> Semi-Furnished</td>";
                                        }elseif ($user[$i]->furnished_type =='3') {
                                           echo "<td>Un-Furnished </td>";
                                          
                                        }else{
                                           echo "<td> </td>";  
                                        }
                                        //echo "<td>" . substr($user[$i]->short_decs, 0, 20).".....</td>";
     									if(!empty($user[$i]->image)){
                                            echo "<td>";
                                            echo '<img src="'.base_url().'upload/property/100x100/'.$user[$i]->image.'" width="75" height="75">';
                                            echo "</td>";
                                        }else{
                                            echo "<td>";
                                            echo '<img src="'.base_url().'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                            echo "</td>";

                                        }
                                        echo "<td>";
                                        //echo "<span style='text-align:left;width: 50%;float: ;'><i class='icon-plus-sign'></i>".anchor('home/propertyExatraImages/'.$user[$i]->id, 'Extra Images')."<div class='box'><i class='icon-fast-forward'></i><a class='button' href='#popup1' onClick='setPropertyId(".$user[$i]->id.")'>Send Inquiry</a></div><br><i class='icon-pencil'></i>&nbsp;" . anchor('home/add_property/'.$user[$i]->id, 'Edit', "title='Edit agent'"). "</span>";    
                                        echo "<span style='text-align:left;width: 50%;float: ;'><div class='box'><i class='icon-fast-forward'></i><a class='button' href='#popup1' onClick='setPropertyId(".$user[$i]->id.")'>Send Inquiry</a></div><br><i class='icon-pencil'></i>&nbsp;" . anchor('home/add_property/'.$user[$i]->id, 'Edit', "title='Edit agent'"). "</span>";
                                        $arrayName = array('target' => '_blank','title'=>'View Property Details' );?>&nbsp;&nbsp;&nbsp;<?php
                                        echo "<i class='icon-zoom-in'></i>&nbsp;" . anchor('home/view_property/'.$user[$i]->id, 'View',$arrayName )."  ";
                                        
                                        if ($this->session->userdata('logged_in_super_user')) {
                                        echo "<span style='text-align:left;width: 50%;float: ;'><i class='icon-trash'></i>&nbsp;" . anchor('home/delete_property/'.$user[$i]->id, 'Delete', array('onClick' => "return confirm('Are you sure want to delete this record?')")). "</span></td>";
                                        }
                                        echo "</tr>";

                                    }

                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>   
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup2" class="overlay">
    <div class="popup">
        <h2>Import Property Details</h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="">
                <div class="">
                    <form name="excel_form" id="excel_form" method="post" action="<?php echo base_url(); ?>index.php/Excelread/" enctype="multipart/form-data">
                
                <fieldset>
                    <hr>
                    <input type="file" name="xls_files" id="xls_files"><br>
                    Download Format Excel File:
                    <a class="" href="<?php echo base_url(); ?>files/example_file/property-import-sample.xlsx">Click Here</a>
                    <br><br>
                    <div id="hd_sub">
                    <input type="submit" class="pushme btn span2" width="" value="Submit" >
                    </div>
                    <div id="message_sub">
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <!--<input type="submit" class="btn" value="Add Inquiry" name="inquiry_form" id="inquiry_form">-->
                        </div>
                    </div>
                </fieldset>
            </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div id="popup1" class="overlay">
    <div class="popup">
        <h2>New or Existing Client </h2>
        <a class="close" href="#">×</a>
        <div class="content">
            <div class="row-fluid">
              <div class="">
                <div class="">
                <?php echo form_open_multipart('home/sendNewClientInquiry', array('class' => 'form-horizontal')); ?>
                <fieldset>
                    <input type="hidden" id="property_id" name="property_id" value="">
                    


<div  style="padding:20px 10px 0px 0px!important; float:left; width:43%;">
<a href="<?php echo base_url(); ?>inquiry/new_client" class="new_exist_button" data-value="new">
    <img src="<?php echo base_url(); ?>img/icons2/new-client.png" style="width:100%;"></a>&nbsp;&nbsp;&nbsp;
</div>



<div  style="padding:20px 0px 0px 10px!important; float:left; width:43%;" >
<a href="<?php echo base_url(); ?>inquiry/exist_client" class="new_exist_button" data-value="exist">
    <img src="<?php echo base_url(); ?>img/icons2/exist-client.png" style="width:100%;"></a>
</div>

                    <div class="control-group">
                        <div class="controls">
                            <!--<input type="submit" class="btn" value="Add Inquiry" name="inquiry_form" id="inquiry_form">-->
                        </div>
                    </div>
                </fieldset>
            </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/property_excel_filel.js"></script>

<script type="text/javascript">
function setPropertyId(propertyId)
{

   //var '<%Session["send_property_id"] = "' + propertyId + '"; %>';
    $("#property_id").val(propertyId);
}
$(".new_exist_button").live("click",function(event){
     event.preventDefault();
    var propertyIs = $("#property_id").val();
    var new_exist_value = $(this).attr("href");
    //alert(new_exist_value);
    window.location= new_exist_value+"/"+propertyIs;

    //exit;
});

function numbersonly(e){     
    var unicode=e.charCode? e.charCode : e.keyCode;    
    
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    
        if ((unicode<48||unicode>57) && unicode!=46 ) //if not a number
            return false //disable key press
    }
}
$("#excel_form").submit(function( event ) {

    if($("#xls_files").val() != ""){
        var ext = $('#xls_files').val().split('.').pop().toLowerCase();
        
        if($.inArray(ext, ['xls','xlsx']) == -1) {
            alert('Please Only Upload Excel Files.');
            return false;
        }else{
             $('#hd_sub').hide();
            $('#message_sub').text("System processing your data, please wait for few mins.........................");
            $("#excel_form").submit();
        }
    }else{
        alert("Please Upload Import Property Details.");
        return false;
    }
});
// $(".pushme").click(function () {
//     $('#hd_sub').hide();
    
//     $('#message_sub').text("System processing your data, please wait for few mins.........................");
//     });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/customer.js"></script>


