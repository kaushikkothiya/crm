<?php
$this->load->view('header');?>
<link href="<?php echo base_url(); ?>css/selectmulcheck/multiple-select.css" rel="stylesheet">
<?php
$this->load->view('leftmenu');
?>

 <div class="container-fluid">
    <div class="row">
      <div class="main">
        <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
        <?php } ?>
        <h1 class="page-header">Property Search</h1>

        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
              <div class="panel-heading">Property Search 
             <div class="text-center"><?php echo $this->session->userdata('customer_name_property'); ?></div>
              </div>

              <div class="panel-body">
                <?php echo form_open_multipart('inquiry/property', array('class' => 'form-horizontal search-property-form')); ?>
                <ul class="nav nav-tabs">
                    <li class="active buybtn<?php echo (!empty($post_property_data['property_type']) && $post_property_data['property_type']=='2') ? '-select' : empty($post_property_data['property_type']) ? '-select' : ''; ?> rent_sale" id="2" ><a data-toggle="tab" aria-controls="rent" href="#rent" aria-expanded="true">RENT</a></li>
                    <li><a data-toggle="tab" class="buybtn<?php echo (!empty($post_property_data['property_type']) && $post_property_data['property_type']=='1') ? '-select' : ''; ?> rent_sale" id="1"  aria-controls="buy" href="#buy" aria-expanded="false">BUY</a></li>
                </ul>
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
                <div class="large-input"><input type="text" class="form-control" placeholder="Enter reference number here" name="reference_no" id="reference_no" value="<?php echo !empty($post_property_data['reference_no']) ? $post_property_data['reference_no'] : '';  ?>"></div>
                
                <div class="tab-content">
                    <div class="sep"></div>
                    <div class="row">
                    <div class="col-md-4">
                      <p class="title-text">Property Location :</p>
                      
                      <div class="form-group">
                        <div class="col-md-12">
                          <label class="col-md-4  control-label">Country:</label>
                            <div class="col-md-8">
                             <?php
                              $countrydata =array(0 => 'Select country',1 => 'Cyprus');
                              $device = 'id="country_id" class="form-control"';
                              echo form_dropdown('country_id', $countrydata, '', $device);
                            ?>
                              </select>
                          </div>
                        </div>
                     </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <label class="col-md-4  control-label">City:</label>
                            <div class="col-md-8">
                              <select class="form-control" name="city"  id="city" onchange="get_city_area();">
                                  <?php foreach($city as $key => $value){ ?>
                                          <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['city']) && $post_property_data['city']== $key) ? 'selected' : '';  ?>><?php echo $value;?></option>
                                   <?php }?>
                              </select>
                          </div>
                        </div>
                     </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <label class="col-md-4  control-label">City area:</label>
                          <div class="col-md-8">
                            <input type="hidden" id="city_area_selected_ids" value="<?php echo !empty($post_property_data['selectItemcity_area']) ? implode(",", $post_property_data['selectItemcity_area']) : "0"; ?>" >
                            <select name="city_area[]"  id="city_area" class="form-control multiselect" multiple>
                            </select>
                          </div>
                        </div>  
                      </div>
                      
                     </div>

                     <div class="col-md-4">
                        <p class="title-text">Property Type :</p>
                        <div class="form-group">
                            <div class="col-md-12">
                              <div class="fild">
                                <div class="scroll-box">
                                    <?php
                                    asort($category);
                                   //echo'<pre>';print_r($post_property_data);exit;
                                    if(!isset($post_property_data['property_category'])){
                                        $post_property_data['property_category']=array();
                                    }
                                     $count=0;
                                    foreach($category as $key => $value){
                                     if(in_array($key, $post_property_data['property_category'])){
                                        $selected = "checked";      
                                    }else{
                                        $selected = ""; 
                                    }
                                    if(empty($post_property_data['property_category'])){
                                        $selected = "checked";
                                    }   
                                    if ( $count % 2 == 0) {
                                      $style="style=background:#dddddd";
                                     } else {
                                      $style="style=background:";
                                    }
                                    ?>
                                     <div class="checkbox" <?php echo $style; ?>>
                                      <label>
                                    <input type="checkbox" class="checkboxall"  <?php echo $selected; ?> value="<?php echo $key;?>" name="property_category[]"  id="property_category"><?php echo $value; ?><br>
                                     </label>
                                    </div>
                                    <?php $count++; }?>
                                </div>
                              </div>
                          </div>

                        </div>
                     </div>
                    
                    <div class="col-md-4">
                        <p class="title-text">Property Details :</p>
                      <div class="form-group">
                        <label class="col-md-4  control-label">Bedroom(s):</label>
                        <div class="col-md-8">
                        <input  type="text" name="bedroom"  id="bedroom" value="<?php echo (!empty($post_property_data['bedroom'])) ? $post_property_data['bedroom'] : '';  ?>" class="form-control" />
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-md-4  control-label">Bathroom(s):</label>
                        <div class="col-md-8">
                            <select name="bathroom"  id="bathroom" class="form-control">
                               <option value="">Please select</option>
                                <?php foreach($bathroom as $key => $value){?>
                                    <option value="<?php echo $key;?>" <?php echo (!empty($post_property_data['bathroom']) && $post_property_data['bathroom']== $key) ? 'selected' : '';  ?>><?php echo $value;?></option>
                                <?php }?>
                            </select>
                          
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4  control-label">Furnished Type:</label>
                        <div class="col-md-8">
                        <select name="furnished_type"  id="furnished_type" class="form-control">
                            <option value="">Please select</option>
                            <option value="1" <?php echo (!empty($post_property_data['furnished_type']) && $post_property_data['furnished_type']== 1) ? 'selected' : '';  ?>>Furnished</option>
                            <option value="2" <?php echo (!empty($post_property_data['furnished_type']) && $post_property_data['furnished_type']== 2) ? 'selected' : '';  ?>>Semi-Furnished</option>
                            <option value="3" <?php echo (!empty($post_property_data['furnished_type']) && $post_property_data['furnished_type']== 3) ? 'selected' : '';  ?>>Un-Furnished</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4  control-label">Price (€):</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                <input type="text" class="form-control" name="min_price" id="min_price" value="<?php echo (!empty($post_property_data['min_price'])) ? $post_property_data['min_price'] : '';  ?>" placeholder="Minimum">
                                </div>
                                <div class="visible-xs visible-sm sep"></div>
                                <div class="col-md-6">
                                      <input type="text" class="form-control" name="max_price" id="max_price" value="<?php echo (!empty($post_property_data['max_price'])) ? $post_property_data['max_price'] : '';  ?>" placeholder="Maximum">
                        
                                </div>
                            </div>
                        </div>
                        
                      </div>
                      
                      <div class="form-group">
                        <label class="col-md-4  control-label">Reason:</label>
                        <div class="col-md-8">
                          <label class="radio-inline">
                            <input type="radio" name="inq_apment"  <?php if($inquiry_flag == "1"){ echo "checked"; } ?> value="inquiry"> Inquiry
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="inq_apment" <?php if($inquiry_flag == "0" || $this->session->userdata('appointment_selected') == "1"){ echo "checked"; } ?> value="appointment"> Appointment
                          </label>
                        </div>
                      </div>
                     </div>
                 </div>
                  <hr>
                  <div class="form-group">
                    <div class="col-md-12 text-center">
                    <input class="btn btn-md btn-primary" type="submit" name="btnSearch" id="btnSearch" value="Find Property" />
                   <!--  <button class="btn btn-md btn-default"  type="button" onClick="window.history.back();">Cancel</button> -->
                    </div>
                  </div>
                </div>
                </form>
                <hr>
                <?php
                if(!empty($search_detail)){
                ?> 
                 <div id="property_search_result">
                <div class="row">   
                    <div class="col-sm-12">
                        <div>
                        <?php 
                        if($inquiry_flag == "1")
                            echo form_open_multipart('inquiry/sendMultipleInquiry', array('class' => 'form-horizontal'));
                        else
                            echo form_open_multipart('inquiry/agent_calendar', array('name'=>'agentCalendar','class' => 'form-horizontal'));
                        ?>
                            <table id="example">
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
                                    <tbody>
                                    <?php for ($i = 0; $i < count($search_detail); $i++) {
                                        //$short_decs   = substr($search_detail[$i]->short_decs, 0, 20);
                                    ?>
                                        <tr>
                                            <?php if(isset($search_detail[$i]->short_decs) && !empty($search_detail[$i]->short_decs)){ ?>
                                            <td data-th='Property Description'><div><?php echo substr($search_detail[$i]->short_decs, 0, 20) ?></div></td>
                                            <?php }else{
                                            echo "<td data-th='Property Description'><div></div> </td>";  
                                            } ?>
                                            
                                            <?php if(isset($search_detail[$i]->reference_no) && !empty($search_detail[$i]->reference_no)){ ?>
                                            <td data-th='Reference No'><div><?php echo $search_detail[$i]->reference_no ?></div></td>
                                            <?php }else{
                                            echo "<td data-th='Reference No'><div></div> </td>";  
                                            } ?>
                                            
                                            <?php if(isset($search_detail[$i]->title) && !empty($search_detail[$i]->title)){ ?>
                                            <td data-th='Property Area'><div><?php echo $search_detail[$i]->title ?></div></td>
                                            <?php }else{
                                            echo "<td data-th='Property Area'><div></div> </td>";  
                                            } ?>
                                            
                                            <?php if(isset($search_detail[$i]->address) && !empty($search_detail[$i]->address)){ ?>
                                            <td data-th='Address'><div><?php echo $search_detail[$i]->address ?></div></td>
                                            <?php }else{
                                            echo "<td data-th='Address'><div></div> </td>";  
                                            } ?>
                                          
                                          <?php  if($search_detail[$i]->type =='1'){
                                            echo "<td data-th='Property Status'><div>" .'Sale'. "</div></td>";
                                            if (!empty($search_detail[$i]->sale_price)) {
                                                echo "<td data-th='Price(€)'><div>" .'€'. number_format($search_detail[$i]->sale_price, 0, ".", ","). "</div></td>";
                                            }else{
                                                echo "<td data-th='Price(€)'><div></div> </td>";    
                                            }
                                        }elseif ($search_detail[$i]->type =='2') {
                                           echo "<td data-th='Property Status'><div>" .'Rent'. "</div></td>";
                                           
                                           if (!empty($search_detail[$i]->rent_price)) {
                                                echo "<td data-th='Price(€)'><div>" .'€'.number_format($search_detail[$i]->rent_price, 0, ".", ","). "</div></td>";    
                                           }else{
                                            echo "<td data-th='Price(€)'><div></div> </td>";
                                           }
                                           
                                        }elseif ($search_detail[$i]->type =='3') {
                                           echo "<td data-th='Property Status'><div>" .'Both(Sale/Rent)'. "</div></td>";
                                           if (!empty($search_detail[$i]->sale_price) || !empty($search_detail[$i]->rent_price)) {
                                                echo "<td data-th='Price(€)'><div> SP. €".number_format($search_detail[$i]->sale_price, 0, ".", ",")." / RP. €".number_format($search_detail[$i]->rent_price, 0, ".", ","). "</div></td>";
                                            }else{
                                                echo "<td data-th='Price(€)'><div></div> </td>";    
                                            }                                      
                                        }else{
                                            echo "<td data-th='Property Status'><div></div> </td>";
                                            echo "<td data-th='Price(€)'><div></div></td>";
                                        }?>
                                            <!-- <td>€<?php echo $search_detail[$i]->rent_price ?></td> -->
                                         <?php if(isset($search_detail[$i]->image) && !empty($search_detail[$i]->image)){ ?>   
                                            <td data-th='image'>
                                                <div>
                                                    <img src="<?php echo base_url().'upload/property/'.$search_detail[$i]->image; ?>" width="75" height="75">
                                                </div>
                                            </td>
                                            <?php }else{ 
                                                echo "<td data-th='image'><div>";
                                                echo '<img src="'.base_url().'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                                echo "</div></td>";                                                  
                                             } ?>
                                            <td data-th='Action'><div>
                                                <?php
                                                if($inquiry_flag == "1")
                                                {?>
                                                    <input type="checkbox" id="" name="pro_checkbox" class="propertyIdArr"  value="<?php echo trim($search_detail[$i]->id); ?>" >
                                                    <a href="<?php echo base_url(); ?>home/view_property/<?php echo $search_detail[$i]->id; ?>" target='_blank' class="btn btn-success btn-xs">View</a>
                                                <?php
                                                 //$arrayName = array('target' => '_blank','title'=>'View Property Details' );?>&nbsp;&nbsp;&nbsp;<?php
                                                //echo "<i class='icon-zoom-in'></i>&nbsp;" . anchor('home/view_property/'.$search_detail[$i]->id, 'View',$arrayName )."  ";
                                                   
                                                }else{?>
                                                    <input type="radio" id="property_id" name="property_id" checked value="<?php echo trim($search_detail[$i]->id); ?>" />
                                                    <?php
                                                   // $arrayName = array('target' => '_blank','title'=>'View Property Details' );?>&nbsp;&nbsp;&nbsp;<?php
                                                    // echo "<i class='icon-zoom-in'></i>&nbsp;" . anchor('home/view_property/'.$search_detail[$i]->id, 'View',$arrayName )."  ";
                                                     echo anchor('home/view_property/'.$search_detail[$i]->id, '<i class="icon-zoom-in"></i>',array('target' => '_blank','title'=>'View Property Details','class'=>"btn btn-default btn-small" ));
                                                }
                                                ?>
                                            </div></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
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
                                        <hr>
                                        <?php
                                            if($inquiry_flag == "1")
                                            {
                                                ?>
                                                <div class="form-group">
                                                <label class="col-md-3 col-sm-4 control-label">Send Via :</label>
                                                <div class="col-md-6">
                                                  <select name="sendInquiryBy" class="form-control">
                                                    <option value="sendEmail">Email</option>
                                                    <option value="sendSms">SMS</option>
                                                    <option value="sendBoth">Both</option>
                                                  </select>
                                                </div>
                                                </div>
                                                 <div class="form-group">
                                                  <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                                                  <div class="col-sm-6">
                                                  <br><input type="submit" class="btn btn-sm btn-primary" id="Proceed" name="Proceed" value="Proceed" onclick="getAllPropertyIds();">
                                                  </div>
                                                  </div>     
                                            <?php
                                            }else{
                                                ?>
                                                <div class="form-group">
                                                <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                                                <div class="col-sm-6">
                                                 <input type="submit" id="next" name="next" class="btn btn-sm btn-primary" value="Next" onclick="handleChange2();">
                                                </div>
                                                </div>
                                            <?php        
                                            }
                                            ?>       
                                        </center>
                                    </ul>
                                 </form>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/selectmulcheck/jquery.multiple.select.js"></script>
 <script>
                        $(document).ready(function () {
                            // 
                            $(".checkboxall").change(function() {
                            
                           if($(this).val() =='0'){
                            if(this.checked){
                            $('input:checkbox').prop('checked','checked');
                            }else{
                                $('input:checkbox').removeAttr('checked');
                            }
                        }
                    });
                          
                            $('.propertyIdArr').on('click',function(){
                                var totle_count= $('input[name=pro_checkbox]:checked').length;
                                if(totle_count >'3'){
                                    alert('You can not select more then three property.');
                                    $(this).removeAttr('checked');
                                }
                            });
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
                    if(selected_city_area.length < 1)
                    {
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