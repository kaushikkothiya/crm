<?php

$this->load->view('header');
?><link href="<?php echo base_url(); ?>css/popupbox.css" rel="stylesheet">
<?php
$this->load->view('leftmenu');
?>
<div class="container-fluid">
     <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
    <?php } ?>
    <div class="row">
      <div class="main">
        <h1 class="page-header">Property List
             <?php if ($this->session->userdata('logged_in_super_user')) { ?>
          <a href="#popup2"><button class="btn btn-sm btn-success pull-right" style="margin-left:5px;" type="button">Import Excel File</button></a>
          <?php } ?>
          <button class="btn btn-sm btn-success pull-right" type="button" onClick="window.location.href = 'add_property';">Create Property</button>
        </h1>
        <div class="row">   
          <div class="col-sm-12">
                    <div>
                        <table id="example">
                                <thead>
                                    <tr>
                                       <th hidden>Id</th>
                                       <th>Reference No</th>
                                       <th>Agent Name</th>
                                       <th>Property Area</th>
                                       <th style="max-width: 70px">Property Status</th>
                                       <th style="text-align: center; max-width: 80px">Price(€)</th>
                                       <th style="min-width: 60px">Furnish Type</th>
                                       <th>Image</th>
                                       <th style="width: 55px">Status</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //echo'<pre>';print_r($user);exit;
                                    for ($i = 0; $i < count($user); $i++) {
                                        echo "<tr>";
                                        echo "<td data-th='id.' hidden><div>" . $user[$i]->id. "</div></td>";
                                        echo "<td data-th='Reference No.'><div>" . $user[$i]->reference_no.'</br></br>Created on '.date("d-M-Y", strtotime($user[$i]->created_date)). "</div></td>";
                                        echo "<td data-th='Agent Name'><div>" . $user[$i]->fname.' '.$user[$i]->lname. "</div></td>";
                                        echo "<td data-th='Property Area'><div>" . $user[$i]->title. "</div></td>";
                                        
                                        if($user[$i]->type =='1'){
                                            echo "<td data-th='Property Status'><div>" .'Sale'. "</div></td>";
                                            if(!empty($user[$i]->sale_price)){
                                                echo '<td data-th="Price(€)" style="text-align: right"><div>' .'€ '.number_format($user[$i]->sale_price, 0, ".", ",") . '</div></td>';
                                            }else{
                                                echo "<td data-th='Price(€)'><div></div> </td>";
                                            }
                                        }elseif ($user[$i]->type =='2') {
                                           echo "<td data-th='Property Status'><div>" .'Rent'. "</div></td>";
                                           if(!empty($user[$i]->rent_price)){
                                                echo '<td data-th="Price(€)" style="text-align: right"><div>' .'€ '.number_format($user[$i]->rent_price, 0, ".", ","). '</div></td>';
                                            }else{
                                                echo "<td data-th='Price(€)'><div></div> </td>";   
                                            }
                                        }elseif ($user[$i]->type =='3') {
                                           echo "<td data-th='Property Status'><div>" .'Both(Sale/Rent)'. "</div></td>";
                                           if(!empty($user[$i]->sale_price) || !empty($user[$i]->rent_price)){
                                                echo '<td data-th="Price(€)" style="text-align: min-width:85px" ><div> SP. € '. number_format($user[$i]->sale_price, 0, ".", ",")." <br /> RP. € ".number_format($user[$i]->rent_price, 0, ".", ","). '</div></td>';
                                            }else{
                                             echo "<td data-th='Price(€)'><div></div> </td>";      
                                            }
                                        }else{
                                            echo "<td data-th='Property Status'><div></div> </td>"; 
                                            echo "<td data-th='Price(€)'><div> </div></td>"; 
                                        }
                                        echo '<td data-th="Furnish Type" style="min-width:60px"><div>';
                                        if($user[$i]->furnished_type =='1'){
                                             echo "Furnished";
                                        }elseif ($user[$i]->furnished_type =='2') {
                                            echo 'Semi-Furnished';
                                        }elseif ($user[$i]->furnished_type =='3') {
                                            echo 'Un-Furnished'; 
                                        }
                                        echo "</div></td>";
                                        //echo "<td>" . substr($user[$i]->short_decs, 0, 20).".....</td>";
                                        if(!empty($user[$i]->image)){
                                            echo "<td data-th='Image'><div>";
                                            echo '<img src="'.base_url().'upload/property/100x100/'.$user[$i]->image.'" width="75" height="75">';
                                            echo "</div></td>";
                                        }else{
                                            echo "<td data-th='Image'><div>";
                                            echo '<img src="'.base_url().'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                            echo "</div></td>";

                                        } ?>
                                        <td data-th="Status">
                                            <div>
                                                <div class="sep"></div><div class="sep"></div><div class="sep"></div>
                                                <?php if($user[$i]->status=='Active'){ ?>
                                                <span style="width:10px;height:10px;display:inline-block;background:#5cb85c;"></span> Active
                                                <?php }else{ ?>
                                                <span style="width:10px;height:10px;display:inline-block;background:#d9534f;"></span> Inactive
                                                <?php } ?>
                                            </div>    
                                        </td>
                                        <td data-th="Actions">
                                            <div>
                                                <a href="add_property/<?php echo $user[$i]->id; ?>" class="btn btn-success btn-xs">Edit</a> 
                                                &nbsp;<a href="view_property/<?php echo $user[$i]->id; ?>" target='_blank' class="btn btn-success btn-xs">View</a> 
                                                &nbsp;<a href="#popup1" class="btn btn-success btn-xs"  onclick="setPropertyId(<?php echo $user[$i]->id; ?>)">Send Inquiry</a> 
                                                <?php if ($this->session->userdata('logged_in_super_user')) { ?>
                                                &nbsp;<a href="delete_property/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs">Delete</a>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <?php
                                        //echo "<td>";
                                        
                                            //echo "<span style='text-align:left;width: 50%;float: left;'><div class='box'><a class='button' href='#popup1' onclick='setPropertyId(".$user[$i]->id.")'>Send Inquiry</a></div><br>";
                                        //echo '<a class="btn btn-default btn-small" href="#popup1" title="Send Inquiry" onclick="setPropertyId('.$user[$i]->id.')"><i class="icon-fast-forward"></i></a>';
                                        //echo anchor('home/add_property/'.$user[$i]->id, '<i class="icon-pencil"></i>', array('title'=>"Edit property",'class'=>"btn btn-default btn-small")). "";
                                        //echo anchor('home/view_property/'.$user[$i]->id, '<i class="icon-zoom-in"></i>',array('target' => '_blank','title'=>'View Property Details','class'=>"btn btn-default btn-small" ));
                                        //if ($this->session->userdata('logged_in_super_user')) {
                                          //  echo anchor('home/delete_property/'.$user[$i]->id, '<i class="icon-trash"></i>', array('class'=>'btn btn-default btn-small','title'=>'Delete Property','onclick' => "return confirm('Are you sure want to delete this record?')"));
                                        //}
                                        //echo '</td>';
                                        echo '</tr>';

                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
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
$(".new_exist_button").on("click",function(event){
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