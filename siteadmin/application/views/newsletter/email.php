<?php $this->load->view('header'); ?>
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
                        <li><?php echo anchor('newsletter/emailnewsletter', 'E-mail Newsletter', array('title' => "E-mail Newsletter")); ?>
                            <span class="divider">/</span></li>

                    </ul>
                </div>
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    </div>
                </div>
            <?php }else if ($this->session->flashdata('error')) { ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row-fluid">
                <div class="span12"><section id="formElement" class="utopia-widget utopia-form-box section">
                        <div class="utopia-widget-title">
                            <span>E-mail Newsletter</span>
                        </div>
                        <div class="row-fluid">
                            <div class="utopia-widget-content">
                                <div class="span6 utopia-form-freeSpace">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <form class="form-horizontal" id="form-send" method="post">
                                                <fieldset>
                                                    <legend>Newsletter Filters</legend>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">Select user type :</label>
                                                        <div class="controls">
                                                            <input type="checkbox" class="ajax_click" name="user_type[]" value="administrator"> Administrator
                                                            <input type="checkbox" class="ajax_click" name="user_type[]" value="agents"> Agents
                                                            <input type="checkbox" class="ajax_click" name="user_type[]" value="employees"> Employees
                                                            <input type="checkbox" class="ajax_click" name="user_type[]" value="customers"> Customers
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">Client Specification</label>
                                                        <div class="controls">
                                                            <input type="radio" checked="checked" class="ajax_click" name="client_specification" value="both"> Both
                                                            <input type="radio" class="ajax_click" name="client_specification" value="sale"> Sale
                                                            <input type="radio" class="ajax_click" name="client_specification" value="rent"> Rent
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">Price Range</label>
                                                        <div class="controls">
                                                            <div class="sub-field client_specification rent both">Rent Range : <select class="ajax_change " name="rent_range">
                                                                <option value="">Select</option>
                                                                <?php foreach($rent_group as $rng){ ?>
                                                                <option value="<?php echo $rng['name'] ?>"><?php echo $rng['name'] ?></option>
                                                                <?php } ?>
                                                            </select></div>
                                                            <br />
                                                            <div class="sub-field client_specification sale both">Sale Range : <select class="ajax_change" name="sale_range">
                                                                <option value="">Select</option>
                                                                <?php foreach($sale_group as $rng){ ?>
                                                                <option value="<?php echo $rng['name'] ?>"><?php echo $rng['name'] ?></option>
                                                                <?php } ?>
                                                            </select></div>
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            
                                                <fieldset>
                                                    <legend>Newsletter Details</legend>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">#Recipient</label>
                                                        <div class="controls">
                                                            <label id="hash_recipient">0</label>
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">Recipient(s)</label>
                                                        <div class="controls">
                                                            <select name="receivers[]" multiple="multiple" id="receivers">
                                                            </select>
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">E-mail Content</label>
                                                        <div class="controls">
                                                            <textarea name="content" id="email_content" rows="5" cols="50"></textarea>
                                                            <div class="error">Note: Use <b><i>{first_name}</i></b>, <b><i>{last_name}</i></b> as name placeholder</div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <legend>Newsletter Schedule</legend>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">Campaign Name</label>
                                                        <div class="controls">
                                                            <input id="newsletter_campaign_name" type="text" value="" class="" name="campaign_name" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">Schedule</label>
                                                        <div class="controls">
                                                            <input type="radio" checked="checked" class="" name="schedule" value="now"> Send Now
                                                            <input type="radio" class="" name="schedule" value="date"> Set Date
                                                            <!--<input type="radio" class="" name="schedule" value="repetitive"> Repetitive-->
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group schedule date">
                                                        <label class="control-label" for="">Set Date</label>
                                                        <div class="controls">
                                                            <input type="text" value="" name="schedule_date" class="txt_date" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group schedule repetitive">
                                                        <label class="control-label" for="">Duration</label>
                                                        <div class="controls">
                                                            <input type="radio" checked="checked" name="duration" class="" name="day"> Day
                                                            <input type="radio" class="" name="duration" value="week"> Week
                                                            <input type="radio" class="" name="duration" value="month"> Month
                                                            <input type="radio" class="" name="duration" value="year"> Year
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <div class="control-group">
                                                    <label class="control-label" for="">&nbsp;</label>
                                                    <div class="controls">
                                                        <input type="button" onclick="sendBulkEmail()" value="Send Newsletter" class="btn btn-primary" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $( ".txt_date" ).datepicker();
        $("#email_content").cleditor();
        $('input[name=schedule]').on('click',function(){
            $(".control-group.schedule").hide();
            $('.control-group.schedule.'+$(this).val()).show();
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
<?php $this->load->view('footer'); ?>