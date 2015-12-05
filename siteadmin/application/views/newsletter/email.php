<?php
$this->load->view('header');
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
    
            <h1 class="page-header">E-mail Newsletter</h1>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
                    <div class="panel-heading">Create E-mail Newsletter</div>
              <div class="panel-body">
               <form class="form-horizontal" id="form-send" method="post">
                <legend>Filters</legend>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">Select user type :</label>
                    <div class="col-sm-6">
                        <input type="checkbox" class="ajax_click" name="user_type[]" value="administrator"> Administrator
                        <input type="checkbox" class="ajax_click" name="user_type[]" value="agents"> Agents
                        <input type="checkbox" class="ajax_click" name="user_type[]" value="employees"> Employees
                        <input type="checkbox" class="ajax_click" name="user_type[]" value="customers"> Customers
                        <div class="error"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">Client Specification</label>
                    <div class="col-sm-6">
                        <input type="radio" checked="checked" class="ajax_click" name="client_specification" value="both"> Both
                        <input type="radio" class="ajax_click" name="client_specification" value="sale"> Sale
                        <input type="radio" class="ajax_click" name="client_specification" value="rent"> Rent
                        <div class="error"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">Rent Range :</label>
                    <div class="col-sm-4 rent both">
                         <select class="sub-field form-control ajax_change " name="rent_range">
                            <option value="">Select</option>
                            <?php foreach($rent_group as $rng){ ?>
                            <option value="<?php echo $rng['name'] ?>"><?php echo $rng['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                   </div> 
                    <div class="form-group">    
                         <label class="col-md-3 col-sm-4  control-label">Sale Range :</label>
                        <div class="col-sm-4 sale both"> 
                            <select class="sub-field form-control ajax_change" name="sale_range">
                            <option value="">Select</option>
                            <?php foreach($sale_group as $rng){ ?>
                            <option value="<?php echo $rng['name'] ?>"><?php echo $rng['name'] ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="error"></div>
                    </div>
                    <legend>Newsletter Details</legend>
                    <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">#Recipient :</label>
                    <div class="col-sm-6">
                        <label id="hash_recipient">0</label>
                        <div class="error"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">Receivers(S)</label>
                    <div class="col-sm-4">
                        <select name="receivers[]" class="form-control" multiple="multiple" id="receivers">
                        </select>
                        <div class="error"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">E-mail Content :</label>
                    <div class="col-sm-4 rent both">
                          <textarea name="content" class="form-control" id="email_content" rows="5" cols="50"></textarea>
                          <div class="error">Note: Use <b><i>{first_name}</i></b>, <b><i>{last_name}</i></b> as name placeholder</div>
                    </div>
                   </div>
                   <legend>Newsletter Schedule</legend> 
                    
                    <div class="form-group">    
                         <label class="col-md-3 col-sm-4  control-label">Campaign Name :</label>
                        <div class="col-sm-4 sale both"> 
                           <input id="newsletter_campaign_name" type="text" value="" class="form-control" name="campaign_name" />
                        </div>
                    </div>
                    <div class="form-group">    
                         <label class="col-md-3 col-sm-4  control-label">Schedule</label>
                        <div class="col-sm-4 sale both"> 
                            <input type="radio" checked="checked" class="" name="schedule" value="now"> Send Now
                            <input type="radio" class="" name="schedule" value="date"> Set Date
                        <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group schedule date">    
                         <label class="col-md-3 col-sm-4  control-label">Set Date :</label>
                        <div class="col-sm-4 sale both"> 
                          <input type="text" value="" name="schedule_date" class="form-control txt_date" />
                        </div>
                    </div>
                    <div class="form-group schedule repetitive">    
                         <label class="col-md-3 col-sm-4  control-label">Duration :</label>
                        <div class="col-sm-6 sale both"> 
                            <input type="radio" checked="checked" name="duration" class="" name="day"> Day
                            <input type="radio" class="" name="duration" value="week"> Week
                            <input type="radio" class="" name="duration" value="month"> Month
                            <input type="radio" class="" name="duration" value="year"> Year
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <input type="button" onclick="sendBulkEmail()" value="Send Newsletter" class="btn btn-sm btn-primary" />
                    </div>
                  </div>
                      
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $this->load->view('footer'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $( ".txt_date" ).datepicker();
        //$("#email_content").cleditor();
        $('input[name=schedule]').on('click',function(){
            $(".form-group.schedule").hide();
            $('.form-group.schedule.'+$(this).val()).show();
        });
        $('input[name=schedule]').first().trigger('click');
        
        $(".ajax_click").on('click', function () {
            ajax_call();
        });

        $(".ajax_change").on('change', function () {
            ajax_call();
        });
        
        $('input[name=client_specification]').on('click',function(){
            $(".sub-field.client_specification").hide();
            $('.sub-field.client_specification.'+$(this).val()).show();
        });
        $('input[name=schedule]').first().trigger('click');
        
    });

    function sendBulkEmail() {
        $("#receivers option").prop("selected", "selected");
        if ($("#newsletter_campaign_name").val() != '') {
            if ($("#receivers option").length > 0) {
                if ($("#email_content").val() != '') {
                    $("#form-send").submit();
                } else {
                    alert("No E-email Content!");
                }
            } else {
                alert("No recipients!");
            }
        }else{
            alert("Campaign Name is not provided!");
        }
    }

    function ajax_call() {
        //console.log();
        $.ajax({
            url: '<?php echo base_url(); ?>newsletter/ajax_get_receviers',
            method: 'POST',
            data: $('#form-send').serialize(),
            dataType: 'json'
        }).done(function (data) {
            $("#hash_recipient").html(data.length);
            $("#receivers").html('');
            var opts = [];
            for (var i = 0; i < data.length; i++) {
                data[i].prefix_code = (data[i].prefix_code[0] == '+') ? data[i].prefix_code.substring(1, data[i].prefix_code.length) : data[i].prefix_code;
                opts.push('<option value="' + ('00' + data[i].prefix_code + data[i].mobile_no + '|' + data[i].email + '|' + data[i].fname + '|' + data[i].lname) + '">' + data[i].fname + ' ' + data[i].lname + ' ( ' + (data[i].email) + ' )</option>');
            }
            $("#receivers").html(opts.join(''));
        });
    }
</script>