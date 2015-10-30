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
<style>
.rent_sale{
    cursor: pointer;
}
</style>
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
                               <div class="wrapper">
    
                                <div class="propertymain">
                                    <div class="buybtn<?php echo (!empty($post_property_data['property_type']) && $post_property_data['property_type']=='2') ? '-select' : empty($post_property_data['property_type']) ? '-select' : ''; ?> rent_sale" id="2">RENT</div>
                                    <div class="buybtn<?php echo (!empty($post_property_data['property_type']) && $post_property_data['property_type']=='1') ? '-select' : ''; ?> rent_sale" id="1">BUY</div>
                                    <?php
                                        if(empty($post_property_data['property_type']))
                                        {
                                            $defId = "2";
                                        }
                                        else{
                                            $defId = $post_property_data['property_type'];
                                        }
                                    ?>
                                    <input type="hidden" name="property_type" id="property_type" value="<?php echo $defId; ?>">
                                    <div class="largefd"><input class="largefd-type" type="text" name="reference_no" id="reference_no" value="<?php echo !empty($post_property_data['reference_no']) ? $post_property_data['reference_no'] : '';  ?>" placeholder="Enter reference number Here" /></div>
                                    
                                    <div class="clear"></div>
                                    
                                    <div class="propertypadd border">
                                        <div class="col-1">
                                            <div class="bold">Property Location :</div>
                                            <div class="fild">
                                                <div class="data">
                                                    <select class="inpselect-full" name="city"  id="city" onchange="get_city_area();">
                                                        <?php foreach($city as $key => $value){ ?>
                                                                <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['city']) && $post_property_data['city']== $key) ? 'selected' : '';  ?>><?php echo $value;?></option>
                                                         <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <input type="hidden" id="city_area_selected_ids" value="<?php echo !empty($post_property_data['selectItemcity_area']) ? implode(",", $post_property_data['selectItemcity_area']) : "0"; ?>" >
                                               <select name="city_area[]"  id="city_area" class="inpselect-full multiselect" multiple>
                                               </select>
                                                            
                                        </div>
                                        
                                        <div class="col-2">
                                            <div class="bold">Property Type :</div>
                                            <div class="scroll-1 height cktxt">
                                                <?php
                                                asort($category);
                                               //echo'<pre>';print_r($post_property_data);exit;
                                                if(!isset($post_property_data['property_category'])){
                                                    $post_property_data['property_category']=array();
                                                }
                                                foreach($category as $key => $value){
                                                 if(in_array($key, $post_property_data['property_category'])){
                                                    $selected = "checked";      
                                                }else{
                                                    $selected = ""; 
                                                }   
                                                 ?>
                                                <input type="checkbox" style="margin-right:5px;" <?php echo $selected; ?> value="<?php echo $key;?>" name="property_category[]"  id="property_category"><?php echo $value; ?><br>
                                                <?php }?>
                                            </div>
                                                            
                                        </div>
                                        
                                        <div class="col-2">
                                            <div class="bold">Property Details :</div>
                                            <div class="fild">
                                                <div class="smfildleft"><strong>Bedroom(s):</strong></div>
                                                <div class="smfildright">
                                                    <input  type="text" name="bedroom"  id="bedroom" value="<?php echo (!empty($post_property_data['bedroom'])) ? $post_property_data['bedroom'] : '';  ?>" class="sminpselect" />
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            
                                            <div class="fild">
                                                <div class="smfildleft"><strong>Bathroom(s):</strong></div>
                                                <div class="smfildright">
                                                    <select name="bathroom"  id="bathroom" class="sminpselect1">
                                                       <option value="">Please select</option>
                                                        <?php foreach($bathroom as $key => $value){?>
                                                            <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['bathroom']) && $post_property_data['bathroom']== $key) ? 'selected' : '';  ?>><?php echo $value;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            
                                            <div class="fild">
                                                <div class="smfildleft"><strong>Furnished Type:</strong></div>
                                                <div class="smfildright">
                                                    <select name="furnished_type"  id="furnished_type" class="sminpselect1">
                                                        <option value="">Please select</option>
                                                        <option value="1" <?php echo (!empty($post_property_data['furnished_type']) && $post_property_data['furnished_type']== 1) ? 'selected' : '';  ?>>Furnished</option>
                                                        <option value="2" <?php echo (!empty($post_property_data['furnished_type']) && $post_property_data['furnished_type']== 2) ? 'selected' : '';  ?>>Semi-Furnished</option>
                                                        <option value="3" <?php echo (!empty($post_property_data['furnished_type']) && $post_property_data['furnished_type']== 3) ? 'selected' : '';  ?>>Un-Furnished</option>
                                                    </select>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            
                                            <div class="fild">
                                                <div class="smfildleft">Price ($):</div>
                                                <div class="clear"></div>
                                                
                                                <div class="smfild"><input type="text" class="sminpselect" name="min_price" id="min_price" value="<?php echo (!empty($post_property_data['min_price'])) ? $post_property_data['min_price'] : '';  ?>" placeholder="Minimum"></div>
                                                <div class="smfild"><input type="text" class="sminpselect" name="max_price" id="max_price" value="<?php echo (!empty($post_property_data['max_price'])) ? $post_property_data['max_price'] : '';  ?>" placeholder="Maximum"></div>
                                                <div class="clear"></div>
                                                
                                                <div class="cktxt fleft"><label><input type="radio" name="inq_apment"  <?php if($inquiry_flag == "1"){ echo "checked"; } ?> value="inquiry"> Inquiry</label></div>
                                                <div class="cktxt fleft"><label><input type="radio" name="inq_apment" <?php if($inquiry_flag == "0" || $this->session->userdata('appointment_selected') == "1"){ echo "checked"; } ?> value="appointment"> Appointment</label></div>
                                                
                                            </div>
                                            <div class="clear"></div>
                                            

                                            <!-- <button class="button" >Find Property</button> -->
                                             <input class="button" type="submit" name="btnSearch" id="btnSearch" value="Find Property" />                 
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    
                                </div>
                               
                            </div>
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
                                                   // $arrayName = array('target' => '_blank','title'=>'View Property Details' );?>&nbsp;&nbsp;&nbsp;<?php
                                                    // echo "<i class='icon-zoom-in'></i>&nbsp;" . anchor('home/view_property/'.$search_detail[$i]->id, 'View',$arrayName )."  ";
                                                     echo anchor('home/view_property/'.$search_detail[$i]->id, '<i class="icon-zoom-in"></i>',array('target' => '_blank','title'=>'View Property Details','class'=>"btn btn-default btn-small" ));
                                       
                                                        
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
                            
                            $('select.multiselect').multipleSelect({
                                filter: true,
                            });
                             get_city_area();
                             
                             $('input[type=radio][name=inq_apment]').change(function() {
                                $("#property_search_result").remove();
                            });   

                             $('.rent_sale').click(function(){
                                var property_type_id=$(this).attr('id');
                               $('#property_type').val(property_type_id);
                               $(".buybtn-select").addClass("buybtn");
                               $(".buybtn-select").removeClass("buybtn-select");

                               $(this).removeClass("buybtn");
                               $(this).addClass("buybtn-select");

                             });
                          
                          });
 
                        </script>
<script>
function get_city_area() {
        $('#city_area').html('');
        $.ajax({
            type: "post",
            url:baseurl + "index.php/home/get_city_area",
            data: 'city_id=' + $("#city option:selected").val(),
            dataType:'json',
            success: function(msg){
                var selected_city_area = <?php echo (isset($_POST['selectItemcity_area']))?json_encode($_POST['selectItemcity_area']):"[]"; ?>;
                
                for(var i=0;i<msg.length;i++){
                    var selected = '';
                    if($.inArray(msg[i].id,selected_city_area)!=-1){
                        selected = 'selected="selected"';
                    }
                    $('#city_area').append("<option value='" + msg[i].id + "' " + selected + ">" + msg[i].title + '</option>');
                }
                
                $('#city_area.multiselect').multipleSelect({
                    filter: true,
                });
            }
        });
    }
// function get_city_area()
//  {
//     $('#city_area').html('');
//     $.ajax({
//         type: "post",
//         url:baseurl+"index.php/home/get_city_area",
//         data: 'city_id=' +$("#city option:selected").val(),
//         success: function(msg){
//         var jason = $.parseJSON(msg);
//         var city_area_Ids = $("#city_area_selected_ids").val();
//         //alert(city_area_Ids);
//         var city_area_IdArr = [];   
//         if(city_area_Ids !="0")
//         {
//             city_area_IdArr = city_area_Ids.split(',');
             
//         }
//         for (var i  in jason) 
//         {
//             if($.inArray(jason[i].id, city_area_IdArr) != -1)
//             {
//                 selectedAreaId = "selected";   
//             }else{
//                 selectedAreaId = "";   
//             }

//            $('#city_area').append("<option value='"+jason[i].id+"' "+selectedAreaId+">"+jason[i].title+'</option>');
//         }
//  $('#city_area.multiselect').multipleSelect({
//                                 filter: true,
//                             });
//            }

//          });
//  }
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
