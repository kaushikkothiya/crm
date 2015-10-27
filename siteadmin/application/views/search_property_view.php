<?php

$this->load->view('header');

//$fDate = $this->input->post('txtFrom');
//$tDate = $this->input->post('txtTo');
//$drpUser = $this->input->post('drpUser');
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
<div class="span10 body-container">
<div class="row-fluid">
<div class="span12">
<ul class="breadcrumb">
<li><?php echo anchor('home', 'Home', "title='Home'"); ?>
<span class="divider">/ 
</span></li>
<li><?php echo anchor('inquiry/property', ' Property Search ', "title='Property Search '"); ?>
<span class="divider">
</span></li>
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
                        <span>Property Search </span>
                    </div>
                        
                        <div class="utopia-widget-content">
							<h3>&nbsp;</h3></br>
							
                            <?php echo form_open_multipart('inquiry/property', array('class' => 'form-horizontal')); ?>
							<fieldset>
                                <?php //echo'<pre>';print_r($post_property_data);exit; ?>
                                <div class="control-group">
                                    Reference No : 
                                    <input type="text"  name="reference_no" style="width:200px" id="reference_no" value="<?php echo !empty($post_property_data['reference_no']) ? $post_property_data['reference_no'] : '';  ?>"/>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
                                    <!--  Size : 
                                    <input type="text"  name="size" style="width:200px" id="size" value=""/>&nbsp; -->
                                
                                    <!--<input type="submit" name="btnSearch" id="btnSearch" value="Search" />
                                    <input type="reset" name="btnSearch" id="btnSearch" value="Clear" />-->
                                </div>
                                <?php if($this->session->userdata('customer_property_buy_sale')){
                                    $aquired_val=$this->session->userdata('customer_property_buy_sale');
                                    //$this->session->unset_userdata('customer_property_buy_sale');
                                   }else{
                                    $aquired_val='';
                                } ?>
                                <div class="control-group">
                                    <input type="radio" name="property_type" checked value="3" <?php echo (!empty($post_property_data['property_type']) && $post_property_data['property_type']=='3' || $aquired_val=='both') ? 'checked' : '';  ?>> Both&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="property_type" value="1" <?php echo (!empty($post_property_data['property_type']) && $post_property_data['property_type']=='1' ||  $aquired_val=='sale') ? 'checked' : '';  ?>> Sale &nbsp;&nbsp;&nbsp; 
                                    <input type="radio" name="property_type" value="2" <?php echo (!empty($post_property_data['property_type']) && $post_property_data['property_type']=='2' ||  $aquired_val=='rent') ? 'checked' : '';  ?>> Rent &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<!-- Location : 
									<input type="text"  name="location" style="width:200px" id="location" value=""/>&nbsp; -->
            						City : 
                                    <!--<input type="text"  name="city" style="width:200px" id="city" value=""/>&nbsp;
                                    -->
                                    <select name="city"  id="city" style="width:200px" onchange="get_city_area();">
                                    <!--<option value="">Please Select City</option>-->   
                                    <?php foreach($city as $key => $value){ ?>
                                    <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['city']) && $post_property_data['city']== $key) ? 'selected' : '';  ?>><?php echo $value;?></option>
                                    <?php }?>                                           
                                    </select>
                                    City Area : 
                                    <!--<input type="text"  name="city_area" style="width:200px" id="city_area" value=""/>&nbsp;
                                   -->
                                   <input type="hidden" id="city_area_selected_ids" value="<?php echo !empty($post_property_data['selectItemcity_area']) ? implode(",", $post_property_data['selectItemcity_area']) : "0"; ?>" >
                                   <select name="city_area[]"  id="city_area" class="multiselect" style="width:200px">
                                    <!-- <option value="0">Select city area</option> -->
                                    <!--<?php foreach($city_area as $key => $value){ ?>
                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                    <?php }?>-->                                           
                                    </select>
                                </div></br>

                                <div class="control-group">
                                    
                                    <!--Criteria : 
                                    <input type="text"  name="criteria" style="width:80px" id="criteria" value=""/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                    Property Type :
                                     <select name="inc_id"  id="property_category" style="width:105px">
                                    <option value="">Please select</option>
                                    <?php
                                    asort($category);
                                    foreach($category as $key => $value){ ?>
                                    <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['inc_id']) && $post_property_data['inc_id']== $key) ? 'selected' : '';  ?> ><?php echo $value;?></option>
                                    <?php }?>                                           
                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Min Price:
                                    <input type="text"  name="min_price" style="width:100px" id="min_price" value="<?php echo (!empty($post_property_data['min_price'])) ? $post_property_data['min_price'] : '';  ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Max Price:                                          
                                    <input type="text"  name="max_price" style="width:100px" id="max_price" value="<?php echo (!empty($post_property_data['max_price'])) ? $post_property_data['max_price'] : '';  ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Bedrooms:                                          
                                    <input type="text"  name="bedroom" style="width:100px" id="bedroom" value="<?php echo (!empty($post_property_data['bedroom'])) ? $post_property_data['bedroom'] : '';  ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    
                                    <!-- Bedrooms:                                          
                                    <select name="bedroom"  id="bedroom" style="width:105px">
                                    <option value="">Please select</option>
                                    <?php foreach($bedroom as $key => $value){ ?>
                                    <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['bedroom']) && $post_property_data['bedroom']== $key) ? 'selected' : '';  ?>><?php echo $value;?></option>
                                    <?php }?>                                           
                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     -->Bathrooms:                                          
                                    <select name="bathroom"  id="bathroom" style="width:105px">
                                    <option value="">Please select</option>
                                    <?php foreach($bathroom as $key => $value){?>
                                    <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['bathroom']) && $post_property_data['bathroom']== $key) ? 'selected' : '';  ?>><?php echo $value;?></option>
                                    <?php }?>                                           
                                    </select>
                                    <!--<input type="submit" name="btnSearch" id="btnSearch" value="Search" />
                                    <input type="reset" name="btnSearch" id="btnSearch" value="Clear" />-->
                               
                                </div></br>

                                <div class="control-group">
                                    <!--Reference No : 
                                    <input type="text"  name="reference_no" style="width:83px" id="reference_no" value=""/>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; -->
                                    <input type="radio" name="time_section" checked value="all" <?php echo (!empty($post_property_data['time_section']) && $post_property_data['time_section']=='all') ? 'checked' : '';  ?>> All&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="time_section" value="day" <?php echo (!empty($post_property_data['time_section']) && $post_property_data['time_section']=='day') ? 'checked' : '';  ?>> Day &nbsp;&nbsp;&nbsp; 
                                    <input type="radio" name="time_section" value="week" <?php echo (!empty($post_property_data['time_section']) && $post_property_data['time_section']=='week') ? 'checked' : '';  ?>> Week &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="time_section" value="month" <?php echo (!empty($post_property_data['time_section']) && $post_property_data['time_section']=='month') ? 'checked' : '';  ?>> Month&nbsp;&nbsp;&nbsp;
                                    
                                    
                                    <!--<input type="submit" name="btnSearch" id="btnSearch" value="Search" />
                                    <input type="reset" name="btnSearch" id="btnSearch" value="Clear" />-->
                                </div>
                                </br></br>

                                <center>
                                    <div>
                                        <input type="radio" name="inq_apment"  <?php if($inquiry_flag == "1"){ echo "checked"; } ?> value="inquiry"> Inquiry&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="inq_apment" <?php if($inquiry_flag == "0" || $this->session->userdata('appointment_selected') == "1"){ echo "checked"; } ?> value="appointment"> Appointment &nbsp;&nbsp;&nbsp; 
                                    </div>
                                    <br><input type="submit" name="btnSearch" id="btnSearch" value="Search Property" />
                                </center>
                            </fieldset>
							</form>

                            <!-- Search Results parts here -->
                            <?php
                            if(!empty($search_detail))
                            {
                            ?> 
                             <div id="property_search_result">
                                <div class="table-responsive">
                            <table class="table table-bordered" id="ani_bas_info">
                                <thead>
                                        <th class="dashboard_main_heading" colspan="2"><h3>Appointment / Inquiry</h3></th>
                                </thead>
                                <tbody>
                                <div class="row-fluid">
                                    <div class="utopia-widget-content">
                           <!-- <form name="selected_property_frm" id="selected_property_frm" method="post" action="agent_calendar"> -->
                            
                                    <?php 
                                    if($inquiry_flag == "1")
                                        echo form_open_multipart('inquiry/sendMultipleInquiry', array('class' => 'form-horizontal'));
                                    else
                                        echo form_open_multipart('inquiry/agent_calendar', array('name'=>'agentCalendar','class' => 'form-horizontal'));
                                    ?>
                            
                                    <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Property Description</th>
                                            <th>Reference No</th>
                                            <th>Property Area</th>
                                            <th>Address</th>
                                            <th>Property Status</th>
                                            <th>Price(€)</th>
                                            <th>image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    
                                    <?php
                                   
                                    for ($i = 0; $i < count($search_detail); $i++) {

                                        //$short_decs   = substr($search_detail[$i]->short_decs, 0, 20);
                                    ?>
                                        <tr>
                                            <?php if(isset($search_detail[$i]->short_decs) && !empty($search_detail[$i]->short_decs)){ ?>
                                            <td><?php echo substr($search_detail[$i]->short_decs, 0, 20) ?></td>
                                            <?php }else{
                                            echo "<td> </td>";  
                                            } ?>
                                            
                                            <?php if(isset($search_detail[$i]->reference_no) && !empty($search_detail[$i]->reference_no)){ ?>
                                            <td><?php echo $search_detail[$i]->reference_no ?></td>
                                            <?php }else{
                                            echo "<td> </td>";  
                                            } ?>
                                            
                                            <?php if(isset($search_detail[$i]->title) && !empty($search_detail[$i]->title)){ ?>
                                            <td><?php echo $search_detail[$i]->title ?></td>
                                            <?php }else{
                                            echo "<td> </td>";  
                                            } ?>
                                            
                                            <?php if(isset($search_detail[$i]->address) && !empty($search_detail[$i]->address)){ ?>
                                            <td><?php echo $search_detail[$i]->address ?></td>
                                            <?php }else{
                                            echo "<td> </td>";  
                                            } ?>
                                          
                                          <?php  if($search_detail[$i]->type =='1'){
                                            echo "<td>" .'Sale'. "</td>";
                                            if (!empty($search_detail[$i]->sale_price)) {
                                                echo "<td>" .'€'.$search_detail[$i]->sale_price. "</td>";
                                            }else{
                                                echo "<td> </td>";    
                                            }
                                        }elseif ($search_detail[$i]->type =='2') {
                                           echo "<td>" .'Rent'. "</td>";
                                           
                                           if (!empty($search_detail[$i]->rent_price)) {
                                                echo "<td>" .'€'.$search_detail[$i]->rent_price. "</td>";    
                                           }else{
                                            echo "<td> </td>";
                                           }
                                           
                                        }elseif ($search_detail[$i]->type =='3') {
                                           echo "<td>" .'Both(Sale/Rent)'. "</td>";
                                           if (!empty($search_detail[$i]->sale_price) || !empty($search_detail[$i]->rent_price)) {
                                                echo "<td> SP. €". $search_detail[$i]->sale_price." / RP. €".$search_detail[$i]->rent_price. "</td>";
                                            }else{
                                                echo "<td> </td>";    
                                            }                                      
                                        }else{
                                            echo "<td> </td>";
                                            echo "<td> </td>";
                                        }?>
                                            <!-- <td>€<?php echo $search_detail[$i]->rent_price ?></td> -->
                                         <?php if(isset($search_detail[$i]->image) && !empty($search_detail[$i]->image)){ ?>   
                                            <td>
                                                <img src="<?php echo base_url().'upload/property/'.$search_detail[$i]->image; ?>" width="75" height="75">
                                            </td>
                                            <?php }else{ 
                                                 echo "<td></td>";                                                   
                                             } ?>
                                            <td>
                                                <?php
                                                if($inquiry_flag == "1")
                                                {?>
                                                    <input type="checkbox" id="" name="" class="propertyIdArr"  value="<?php echo trim($search_detail[$i]->id); ?>" >
                                                <?php
                                                 $arrayName = array('target' => '_blank','title'=>'View Property Details' );?>&nbsp;&nbsp;&nbsp;<?php
                                                echo "<i class='icon-zoom-in'></i>&nbsp;" . anchor('home/view_property/'.$search_detail[$i]->id, 'View',$arrayName )."  ";
                                                   
                                                }else{?>
                                                    <input type="radio" id="property_id" name="property_id" checked value="<?php echo trim($search_detail[$i]->id); ?>" />
                                                    <?php
                                                    $arrayName = array('target' => '_blank','title'=>'View Property Details' );?>&nbsp;&nbsp;&nbsp;<?php
                                                     echo "<i class='icon-zoom-in'></i>&nbsp;" . anchor('home/view_property/'.$search_detail[$i]->id, 'View',$arrayName )."  ";
                                        
                                                        
                                                }
                                                ?>
                                                
                                            </td>
                                        </tr>
                                    
                                    <?php
                                    }

                                    ?>
                                    
                                    </table>
                                
                                    <ul  class="sendBox">
                                        <center>
                                        <input type="hidden" id="reference_number" name="reference_number">
                                        <input type="hidden" id="property_status" name="property_status">
                                        <input type="hidden" id="city_id" name="city_id">
                                        <input type="hidden" id="city_area_id" name="city_area_id">
                                        <input type="hidden" id="property_category_id" name="property_category_id">
                                        <input type="hidden" id="min" name="min">
                                        <input type="hidden" id="max" name="max">
                                        <input type="hidden" id="bedroom_no" name="bedroom_no">
                                        <input type="hidden" id="bathroom_no" name="bathroom_no">
                                        <input type="hidden" id="time_section_id" name="time_section_id">    
                                            
                                        <input type="hidden" id="property_name" name="property_name">
                                        <input type="hidden" id="allPropertyIds" name="allPropertyIds">
                                        <input type="hidden" id="allPropertyIds" name="propertyAcquired" value="<?php echo $this->session->userdata('customer_property_buy_sale');?>">
                                        <?php
                                            if($inquiry_flag == "1")
                                            {
                                                ?>
                                                <label>Send Via</label>
                                                <select name="sendInquiryBy">
                                                    <option value="sendEmail">Email</option>
                                                    <option value="sendSms">SMS</option>
                                                    <option value="sendBoth">Both</option>
                                                </select>
                                                <br><input type="submit" id="Proceed" name="Proceed" value="Proceed" style="width:87px" onclick="getAllPropertyIds();">
                                                <?php
                                            }else{
                                                ?>
                                                <input type="submit" id="next" name="next" value="Next" style="width:87px" onclick="handleChange2();">
                                                <?php        
                                            }
                                        ?>       
                                        </center>
                                    </ul>
                                    </div>
                                    </form>
                                    </div>   
                                </div>
                                </tbody>
                                
                            </table>
                             <?php } ?>
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
<link href="<?php echo base_url(); ?>css/selectmulcheck/multiple-select.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>js/selectmulcheck/jquery.multiple.select.js"></script>
 <script>
                        $(document).ready(function () {
                             
                             $('#example')
                                //.on( 'order.dt',  function () { eventFired( 'Order' ); } )
                                .on( 'search.dt', function () {
                                    // eventFired( 'Search' );
                                    var oTable = $('#example').dataTable();
                                    var filterCount = oTable.$('tr', {"filter":"applied"}).length;
                                    
                                    if(filterCount == 0)
                                    {
                                        $(".sendBox").hide();
                                    }else{
                                        $(".sendBox").show();
                                    }
                                })
                                //.on( 'page.dt',   function () { eventFired( 'Page' ); } )
                                .DataTable();
                            });


                            $('select.multiselect').multipleSelect({
                                filter: true,
                            });
                             get_city_area();
                             
                             $('input[type=radio][name=inq_apment]').change(function() {
                                $("#property_search_result").remove();
                            });   
                          
                          });
 
                        </script>
<script>
function get_city_area()
 {
    $('#city_area').html('');
    $.ajax({
        type: "post",
        url:baseurl+"index.php/home/get_city_area",
        data: 'city_id=' +$("#city option:selected").val(),
        success: function(msg){
        var jason = $.parseJSON(msg);
        var city_area_Ids = $("#city_area_selected_ids").val();
        //alert(city_area_Ids);
        var city_area_IdArr = [];   
        if(city_area_Ids !="0")
        {
            city_area_IdArr = city_area_Ids.split(',');
             
        }
        for (var i  in jason) 
        {
            if($.inArray(jason[i].id, city_area_IdArr) != -1)
            {
                selectedAreaId = "selected";   
            }else{
                selectedAreaId = "";   
            }

           $('#city_area').append("<option value='"+jason[i].id+"' "+selectedAreaId+">"+jason[i].title+'</option>');
        }
 $('#city_area.multiselect').multipleSelect({
                                filter: true,
                            });
           }

         });
 }
function getAllPropertyIds()
{
    var allVals = [];
    $('.propertyIdArr:checked').each(function() {
       allVals.push($(this).val());
    });
    allValsStr = allVals.join(",");
    
    $("#allPropertyIds").val(allValsStr);

    $("#reference_number").val($('#reference_no').val());
    $("#property_status").val($('input:radio[name=property_type]:checked').val());
    $("#city_id").val($('#city').val());
    $("#city_area_id").val($('#city_area_selected_ids').val());
    $("#property_category_id").val($('#property_category').val());
    $("#min").val($('#min_price').val());
    $("#max").val($('#max_price').val());
    $("#bedroom_no").val($('#bedroom').val());
    $("#bathroom_no").val($('#bathroom').val());
    $("#time_section_id").val($('input:radio[name=time_section]:checked').val());
} 
function handleChange2()
{   
    //alert($('#property_id:checked').val());
    $("#property_name").val($('#property_id:checked').val());
}
window.onload = function() {
                        
};
</script>
<script>
</script>
