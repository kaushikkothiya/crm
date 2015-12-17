<?php
$url_mothod = $this->uri->segment(2);
$this->load->view('header');
?>
<link href="<?php echo base_url(); ?>css/selectmulcheck/multiple-select.css" rel="stylesheet">
<?php $this->load->view('leftmenu'); ?>
<!--<style>
.ms-drop ul {
    max-height: 230px!important;
}
</style>-->
<div class="container-fluid">
    <div class="row">
        <div class="main">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
            <h1 class="page-header clearfix"><span><?php
                    echo ($url_mothod == 'property_manage') ? "Property List" : "Registed Property";
                    ?></span>
                <?php if ($this->session->userdata('logged_in_super_user')) { ?>
                    <button data-toggle="modal" data-target="#myModal1" class="btn btn-sm btn-info pull-right fluid-btn" style="margin-left:5px;" type="button">Import Excel File</button>
                    <a href="<?php echo base_url(); ?>Excelread/export_data"><button class="btn btn-sm btn-info pull-right fluid-btn" style="margin-left:5px;" type="button">Export Property</button></a>
                <?php } ?>
                    <?php if ($url_mothod == 'property_manage') { ?>
                <button class="btn btn-sm btn-info pull-right fluid-btn" type="button" style="margin-left:5px;" onClick="window.location.href = 'add_property';">Create Property</button>
                    <?php } ?>
                <button class="btn btn-sm btn-danger pull-right property_next fluid-btn"  type="button">Search</button>
            </h1>
            <!-- property search code start -->
            <div class="panel-body" id="property_search" style="display:none;">

                <form  class="form-horizontal search-property-form">
                    <ul class="nav nav-tabs">
                        <li class="active"><a class="rent_sale" data-toggle="tab" data-rentsleid="2" aria-controls="rent" href="#rent" aria-expanded="true">RENT</a></li>
                        <li><a class="rent_sale" data-toggle="tab"  aria-controls="buy" data-rentsleid="1" href="#buy" aria-expanded="false">BUY</a></li>
                    </ul>
                    <input type="hidden" name="property_type" id="property_type" value="2">
                    <div class="large-input"><input type="text" value="" name="reference_no" id="reference_no" class="form-control" placeholder="Enter reference number here"></div>
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
                                            $countrydata = array(0 => 'Select country', 1 => 'Cyprus');
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
                                                <?php foreach ($city as $key => $value) { ?>
                                                    <option value="<?php echo $key; ?>" <?php echo (!empty($post_property_data['city']) && $post_property_data['city'] == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="col-md-4  control-label">City area:</label>
                                        <div class="col-md-8">
                                            <input type="hidden" id="city_area_selected_ids" value="" >
                                            <select name="city_area[]"  id="city_area" class="form-control multiselect">
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

                                                if (!isset($post_property_data['property_category'])) {
                                                    $post_property_data['property_category'] = array();
                                                }
                                                $count = 0;
                                                foreach ($category as $key => $value) {
                                                    if (in_array($key, $post_property_data['property_category'])) {
                                                        $selected = "checked";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    if (empty($post_property_data['property_category'])) {
                                                        $selected = "checked";
                                                    }
                                                    if ($count % 2 == 0) {
                                                        $style = "style=background:#dddddd";
                                                    } else {
                                                        $style = "style=background:";
                                                    }
                                                    ?>
                                                    <div class="checkbox" <?php echo $style; ?>>
                                                        <label>
                                                            <input type="checkbox" class="checkboxall"  <?php echo $selected; ?> value="<?php echo $key; ?>" name="property_category[]"  id="property_category"><?php echo $value; ?><br>
                                                        </label>
                                                    </div>
                                                    <?php
                                                    $count++;
                                                }
                                                ?>
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
                                        <input  type="text" name="bedroom"  id="bedroom" value="" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4  control-label">Bathroom(s):</label>
                                    <div class="col-md-8">
                                        <select name="bathroom"  id="bathroom" class="form-control">
                                            <option value="">Please select</option>
                                            <?php foreach ($bathroom as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  control-label">Furnished Type:</label>
                                    <div class="col-md-8">
                                        <select name="furnished_type"  id="furnished_type" class="form-control">
                                            <option value="">Please select</option>
                                            <option value="1">Furnished</option>
                                            <option value="2">Semi-Furnished</option>
                                            <option value="3">Un-Furnished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  control-label">Price (€):</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="min_price" id="min_price" value="" placeholder="Minimum">
                                            </div>
                                            <div class="visible-xs visible-sm sep"></div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="max_price" id="max_price" value="" placeholder="Maximum">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-md btn-primary" type="button" onclick="search_result();">Find Property</button>
                                <!-- <button class="btn btn-md btn-default property_cancel"  type="button">Cancel</button> -->
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <!-- property search code end-->
            <div class="row"> 
                <div class="col-md-6">
                    <?php if ($url_mothod == 'property_manage') { ?>
                        <span>View Property By :  &nbsp;&nbsp;
                            <select name="view_inc"  id="view_inc" class="form-control" style="width:200px" onchange="view_property_agent(this.value);">
                                <option value="" <?php
                                if (empty($_GET['view'])) {
                                    echo "selected";
                                }
                                ?>>All</option>
                                <?php foreach ($agent as $key => $value) { ?>
                                    <option value="<?php echo $value->id; ?>" <?php
                                    if (!empty($_GET['view_agent']) && $_GET['view_agent'] == $value->id) {
                                        echo "selected";
                                    }
                                    ?> ><?php echo $value->fname . ' ' . $value->lname; ?></option>
    <?php } ?>
                            </select>
                        </span> 
<?php } ?>
                    <div class="sep"></div> <div class="clearfix"></div>
                </div>

                <div class="col-sm-12">
                    <div>
                        <table id="property-list">
                            <thead>
                                <tr>
                                    <th hidden>Id</th>
                                    <th>Reference No</th>
                                    <th>Title</th>
                                    <th>Agent Name</th>
                                    <th>Property Area</th>
                                    <!-- <th>Property Status</th> -->
                                    <th>Price(€)</th>
                                    <th>Furnish Type</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th style="min-width: 70px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="property_search_result">
                                <?php
                                for ($i = 0; $i < count($user); $i++) {
                                    echo "<tr>";
                                    echo "<td data-th='id.' hidden><div>" . $user[$i]->id . "</div></td>";
                                    echo "<td data-th='Reference No.'><div>" . $user[$i]->reference_no . '</br></br>Created on ' . date("d-M-Y", strtotime($user[$i]->created_date)) . '</br></br>Updated on  ' . date("d-M-Y", strtotime($user[$i]->updated_date)) . "</div></td>";
                                    ?>
                                <td data-th='Title'><div><?php
                                        if (!empty($user[$i]->bedroom) && $user[$i]->bedroom != 0) {
                                            echo $user[$i]->bedroom . ' Bedroom ';
                                        }
                                        if (!empty($user[$i]->property_type) && $user[$i]->property_type != 0) {
                                            echo $property_types[$user[$i]->property_type];
                                        }
                                        if (!empty($user[$i]->type) && $user[$i]->type != 0) {
                                            echo ' for ' . $aquired_types[$user[$i]->type];
                                        }
                                        ?></div></td>
                                <?php
                                echo "<td data-th='Agent Name'><div>" . $user[$i]->fname . ' ' . $user[$i]->lname . "</div></td>";
                                echo "<td data-th='Property Area'><div>" . $user[$i]->title . "</div></td>";

                                if ($user[$i]->type == '1') {
                                    //echo "<td data-th='Property Status'><div>" . 'Sale' . "</div></td>";
                                    if (!empty($user[$i]->sale_price)) {
                                        echo '<td data-th="Price(€)" style="text-align: right"><div> SP. ' . '€ ' . number_format($user[$i]->sale_price, 0, ".", ",") . '</div></td>';
                                    } else {
                                        echo "<td data-th='Price(€)'><div></div> </td>";
                                    }
                                } elseif ($user[$i]->type == '2') {
                                    //echo "<td data-th='Property Status'><div>" . 'Rent' . "</div></td>";
                                    if (!empty($user[$i]->rent_price)) {
                                        echo '<td data-th="Price(€)" style="text-align: right"><div> RP. ' . '€ ' . number_format($user[$i]->rent_price, 0, ".", ",") . '</div></td>';
                                    } else {
                                        echo "<td data-th='Price(€)'><div></div> </td>";
                                    }
                                } elseif ($user[$i]->type == '3') {
                                    //echo "<td data-th='Property Status'><div>" . 'Both(Sale/Rent)' . "</div></td>";
                                    if (!empty($user[$i]->sale_price) || !empty($user[$i]->rent_price)) {
                                        echo '<td data-th="Price(€)" style="text-align: min-width:85px" ><div> SP. € ' . number_format($user[$i]->sale_price, 0, ".", ",") . " <br /> RP. € " . number_format($user[$i]->rent_price, 0, ".", ",") . '</div></td>';
                                    } else {
                                        echo "<td data-th='Price(€)'><div></div> </td>";
                                    }
                                } else {
                                    //echo "<td data-th='Property Status'><div></div> </td>";
                                    echo "<td data-th='Price(€)'><div> </div></td>";
                                }
                                echo '<td data-th="Furnish Type" style="min-width:60px"><div>';
                                if ($user[$i]->furnished_type == '1') {
                                    echo "Furnished";
                                } elseif ($user[$i]->furnished_type == '2') {
                                    echo 'Semi-Furnished';
                                } elseif ($user[$i]->furnished_type == '3') {
                                    echo 'Un-Furnished';
                                }
                                echo "</div></td>";
                                //echo "<td>" . substr($user[$i]->short_decs, 0, 20).".....</td>";
                                if (!empty($user[$i]->extra_image)) {
                                    echo "<td data-th='Image'><div>";
                                    echo '<img src="' . base_url() . 'img_prop/100x100/' . $user[$i]->extra_image . '" width="75" height="75">';
                                    echo "</div></td>";
                                } else {
                                    echo "<td data-th='Image'><div>";
                                    echo '<img src="' . base_url() . 'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                    echo "</div></td>";
                                }
                                ?>
                                <td data-th="Status">
                                    <div>
                                        <div class="sep"></div><div class="sep"></div><div class="sep"></div>
                                        <?php if ($user[$i]->status == 'Active') { ?>
                                            <span style="width:10px;height:10px;display:inline-block;background:#5cb85c;"></span> Active
                                        <?php } else { ?>
                                            <span style="width:10px;height:10px;display:inline-block;background:#d9534f;"></span> Inactive
    <?php } ?>
                                    </div>    
                                </td>
                                <td data-th="Actions">
                                    <div>
                                        <?php if ($user[$i]->status == 'Active') { ?>
                                            <a data-toggle="modal" data-target="#myModal" onclick="setPropertyId(<?php echo $user[$i]->id; ?>)" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Send Inquiry"><i class="fa fa-paper-plane"></i></a> 
                                        <?php } else { ?>
                                            <a onclick="sendinquiry_inactive(<?php echo $user[$i]->id; ?>)" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Send Inquiry"><i class="fa fa-paper-plane"></i></a> 
    <?php } ?>
                                        <a href="view_property/<?php echo $user[$i]->id; ?>"  target='_blank' class="btn btn-default btn-xs action-btn" rel="tooltip" title="View"><i class="fa fa-eye"></i></a> 
                                        <a href="add_property/<?php echo $user[$i]->id; ?>" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></a> 


                    <!-- <a href="add_property/<?php echo $user[$i]->id; ?>" class="btn btn-info btn-xs">Edit</a>  -->
                    <!-- &nbsp;<a href="view_property/<?php echo $user[$i]->id; ?>" target='_blank' class="btn btn-info btn-xs">View</a>  -->
                   <!--  &nbsp;<a data-toggle="modal" data-target="#myModal" class="btn btn-info btn-xs"  onclick="setPropertyId(<?php echo $user[$i]->id; ?>)">Send Inquiry</a>  -->
    <?php if ($this->session->userdata('logged_in_super_user')) { ?>
                                            <a href="delete_property/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs action-btn" rel="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                            <!-- &nbsp;<a href="delete_property/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs">Delete</a> -->
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
<!-- Modal -->
<div  class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">New or Existing Client</h4>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Import Property Details</h4>
            </div>
            <form name="excel_form" id="excel_form" method="post" action="<?php echo base_url(); ?>index.php/Excelread/" enctype="multipart/form-data">
                <fieldset>         
                    <div class="modal-body">
                        <input type="file" name="xls_files" id="xls_files"><br>
                        Download Format Excel File:
                        <a class="" href="<?php echo base_url(); ?>files/example_file/property-import-sample.xlsx">Click Here</a>
                        <br><br>
                        <div id="message_sub">
                        </div>
                    </div>
                    <div class="modal-footer" id="hd_sub">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" width="" value="Submit" >
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<!-- <div id="popup2" class="overlay">
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
                            <input type="submit" class="btn" value="Add Inquiry" name="inquiry_form" id="inquiry_form">
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
                            <input type="submit" class="btn" value="Add Inquiry" name="inquiry_form" id="inquiry_form">
                        </div>
                    </div>
                </fieldset>
            </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div> -->
<?php
$this->load->view('footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/selectmulcheck/jquery.multiple.select.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/property_excel_filel.js"></script>

<script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('#property_search').hide();

                                                    $(".checkboxall").change(function () {

                                                        if ($(this).val() == '0') {
                                                            if (this.checked) {
                                                                $('input:checkbox').prop('checked', 'checked');
                                                            } else {
                                                                $('input:checkbox').removeAttr('checked');
                                                            }
                                                        }
                                                    });
                                                    $('.rent_sale').click(function () {
                                                        var property_type_id = $(this).data('rentsleid');
                                                        $('#property_type').val(property_type_id);
                                                        // $(".buybtn-select").addClass("buybtn");
                                                        // $(".buybtn-select").removeClass("buybtn-select");

                                                        // $(this).removeClass("buybtn");
                                                        // $(this).addClass("buybtn-select");
                                                    });
                                                    $('.rent_sale').first().trigger('click');

                                                });

                                                function replaceAll(str, find, replace) {
                                                    return str.replace(new RegExp(find, 'g'), replace);
                                                }

                                                function search_result() {

                                                    var city_area_id = [];
                                                    $('.multiselect :checked').each(function () {
                                                        city_area_id.push($(this).val());
                                                    });
                                                    var property_category_id = [];
                                                    $('.scroll-box :checked').each(function () {
                                                        property_category_id.push($(this).val());
                                                    });
                                                    var property_type = $("#property_type").val();
                                                    var reference_no = $("#reference_no").val();
                                                    var country_id = $("#country_id").val();
                                                    var city = $("#city").val();
                                                    var bedroom = $("#bedroom").val();
                                                    var bathroom = $("#bathroom").val();
                                                    var furnished_type = $("#furnished_type").val();
                                                    var min_price = $("#min_price").val();
                                                    var max_price = $("#max_price").val();
                                                    var agent_properties = 0;
<?php if (isset($agent_properties)) { ?>
                                                        agent_properties = 1;
<?php } ?>
                                                    $.ajax({
                                                        type: "post",
                                                        url: baseurl + "index.php/inquiry/property_search_result?time=" + Math.random() + '&agent_properties=' + agent_properties,
                                                        data: {city: city, selectItemcity_area: city_area_id, property_category: property_category_id, property_type: property_type, reference_no: reference_no, country_id: country_id, bedroom: bedroom, bathroom: bathroom, furnished_type: furnished_type, min_price: min_price, max_price: max_price},
                                                        //dataType:'json',
                                                        success: function (msg) {
                                                            $('#property-list').dataTable().fnDestroy();

                                                            //$('#property-list').empty();
                                                            $('#property_search_result').html(msg);



                                                            $.fn.dataTable.moment = function (format, locale) {
                                                                var types = $.fn.dataTable.ext.type;

                                                                // Add type detection
                                                                types.detect.unshift(function (d) {
                                                                    return moment(strip(d), format, locale, true).isValid() ?
                                                                            'moment-' + format :
                                                                            null;
                                                                });

                                                                // Add sorting method - use an integer for the sorting
                                                                types.order[ 'moment-' + format + '-pre' ] = function (d) {
                                                                    return moment(d, format, locale, true).unix();
                                                                };
                                                            };

                                                            function getPrice(name) {
                                                                var rankNumber;

                                                                rankNumber = replaceAll(name, "<div>", "");
                                                                rankNumber = replaceAll(rankNumber, "</div>", "");
                                                                rankNumber = replaceAll(rankNumber, "€", "");
                                                                rankNumber = replaceAll(rankNumber, ",", "");
                                                                rankNumber = replaceAll(rankNumber, "SP.", "");
                                                                rankNumber = replaceAll(rankNumber, "RP.", "");
                                                                rankNumber = replaceAll(rankNumber, "<br>", "");
                                                                rankNumber = replaceAll(rankNumber, " ", "");
                                                                rankNumber = replaceAll(rankNumber, "/", "");

                                                                if (!isNaN(rankNumber) && rankNumber != "") {
                                                                    rankNumber = parseInt(rankNumber);
                                                                } else {
                                                                    rankNumber = 0;
                                                                }
                                                                return rankNumber;
                                                            }

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


                                                            $.fn.dataTable.moment('D-MMM-YYYY');

                                                            $('#property-list').DataTable({
                                                                "lengthMenu": [15, 30, 45, 60, 75],
                                                                "aoColumnDefs": [{"sType": 'price', "aTargets": [5]}],
                                                                "order": [[0, "desc"]]
                                                            });

                                                            $('#property-list')
                                                                    .removeClass('display')
                                                                    .addClass('table table-striped table-bordered responsive-table');
                                                        }
                                                    });
                                                }
                                                function get_city_area() {
                                                    $('#city_area').html('');
                                                    $.ajax({
                                                        type: "post",
                                                        url: baseurl + "index.php/home/get_city_area",
                                                        data: 'city_id=' + $("#city option:selected").val(),
                                                        dataType: 'json',
                                                        success: function (msg) {
                                                            var selected_city_area = <?php echo (isset($_POST['selectItemcity_area'])) ? json_encode($_POST['selectItemcity_area']) : "[]"; ?>;

                                                            for (var i = 0; i < msg.length; i++) {
                                                                var selected = '';

                                                                if ($.inArray(msg[i].id, selected_city_area) != -1) {
                                                                    selected = 'selected="selected"';
                                                                }
                                                                if (selected_city_area.length < 1)
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
                                                function setPropertyId(propertyId)
                                                {

                                                    //var '<%Session["send_property_id"] = "' + propertyId + '"; %>';
                                                    $("#property_id").val(propertyId);
                                                }
                                                $(".property_next").click(function () {
                                                    $("#property_search").toggle();
                                                });
// $(".property_next").on("click", function (event) {
//     event.preventDefault();
//     $('#property_search').show();
//     //exit;
// });
// $(".property_cancel").on("click", function (event) {
//     event.preventDefault();
//     //$('#property_search').hide(); 
//     location.reload();

//     //exit;
// });
                                                $(".new_exist_button").on("click", function (event) {
                                                    event.preventDefault();
                                                    var propertyIs = $("#property_id").val();
                                                    var new_exist_value = $(this).attr("href");
                                                    //alert(new_exist_value);
                                                    window.location = new_exist_value + "/" + propertyIs;

                                                    //exit;
                                                });

                                                function numbersonly(e) {
                                                    var unicode = e.charCode ? e.charCode : e.keyCode;

                                                    if (unicode != 8) { //if the key isn't the backspace key (which we should allow)

                                                        if ((unicode < 48 || unicode > 57) && unicode != 46) //if not a number
                                                            return false //disable key press
                                                    }
                                                }
                                                $("#excel_form").submit(function (event) {

                                                    if ($("#xls_files").val() != "") {
                                                        var ext = $('#xls_files').val().split('.').pop().toLowerCase();

                                                        if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
                                                            alert('Please Only Upload Excel Files.');
                                                            return false;
                                                        } else {
                                                            $('#hd_sub').hide();
                                                            $('#message_sub').text("System processing your data, please wait for few mins.........................");
                                                            $("#excel_form").submit();
                                                        }
                                                    } else {
                                                        alert("Please Upload Import Property Details.");
                                                        return false;
                                                    }
                                                });
                                                function sendinquiry_inactive() {
                                                    alert('You can not send inquiry beacuse your property is inactive');
                                                }
                                                function view_property_agent(proview_agent) {
                                                    window.location = "<?php echo base_url(); ?>index.php/home/property_manage?view_agent=" + proview_agent;
                                                }
// $(".pushme").click(function () {
//     $('#hd_sub').hide();

//     $('#message_sub').text("System processing your data, please wait for few mins.........................");
//     });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/customer.js"></script>