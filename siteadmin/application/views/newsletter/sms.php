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
                        <li><?php echo anchor('newsletter/smsnewsletter', 'SMS Newsletter', array('title' => "SMS Newsletter")); ?>
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
            <?php } ?>
            <div class="row-fluid">
                <div class="span12"><section id="formElement" class="utopia-widget utopia-form-box section">
                        <div class="utopia-widget-title">
                            <span>SMS Newsletter</span>
                        </div>
                        <div class="row-fluid">
                            <div class="utopia-widget-content">
                                <div class="span6 utopia-form-freeSpace">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <form class="form-horizontal" id="form-search">
                                                <fieldset>
                                                    <legend>Filters</legend>
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
                                                            <input type="text" class="ajax_change" name="price_min" value=""> Min<br />
                                                            To <br />
                                                            <input type="text" class="ajax_change" name="price_max" value=""> Max
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            <form class="form-horizontal" id="form-send" method="post">
                                                <fieldset>
                                                    <legend>Details</legend>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">Title</label>
                                                        <div class="controls">
                                                            <input type="text" name="title" id="sms_title" value="" class="" />
                                                            <div class="error"></div>
                                                        </div>
                                                    </div>
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
                                                        <label class="control-label" for="">SMS Content</label>
                                                        <div class="controls">
                                                            <textarea name="content" id="sms_content" rows="5" cols="50"></textarea>
                                                            <div class="error">Note: Use <b><i>{first_name}</i></b>, <b><i>{last_name}</i></b> as name placeholder</div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="">&nbsp;</label>
                                                        <div class="controls">
                                                            <input type="button" onclick="sendBulkMessage()" value="Send Newsletter" class="btn btn-primary" />
                                                        </div>
                                                    </div>
                                                </fieldset>
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
        $(".ajax_click").on('click', function () {
            ajax_call();
        });

        $(".ajax_change").on('change', function () {
            ajax_call();
        });
    });

    function sendBulkMessage() {
        $("#receivers option").prop("selected", "selected");
        if ($("#sms_title").val() != '') {
            if ($("#receivers option").length > 0) {
                if ($("#sms_content").val() != '') {
                    $("#form-send").submit();
                } else {
                    alert("SMS Content is not provided!");
                }
            } else {
                alert("No recipients!");
            }
        }else{
            alert("SMS Title is not provided!");
        }
    }

    function ajax_call() {
        //console.log();
        $.ajax({
            url: '<?php echo base_url(); ?>newsletter/ajax_get_receviers',
            method: 'POST',
            data: $('#form-search').serialize(),
            dataType: 'json'
        }).done(function (data) {
            $("#hash_recipient").html(data.length);
            $("#receivers").html('');
            var opts = [];
            for (var i = 0; i < data.length; i++) {
                data[i].prefix_code = (data[i].prefix_code[0] == '+') ? data[i].prefix_code.substring(1, data[i].prefix_code.length) : data[i].prefix_code;
                opts.push('<option value="' + ('00' + data[i].prefix_code + data[i].mobile_no + '|' + data[i].email + '|' + data[i].fname + '|' + data[i].lname) + '">' + data[i].fname + ' ' + data[i].lname + '( +' + (data[i].prefix_code + ' ' + data[i].mobile_no) + ')</option>');
            }
            $("#receivers").html(opts.join(''));
        });
    }
</script>
<?php $this->load->view('footer'); ?>