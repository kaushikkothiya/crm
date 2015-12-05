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
    
            <h1 class="page-header">SMS Newsletter</h1>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
                    <div class="panel-heading">Create SMS Newsletter</div>
              <div class="panel-body">
               <form class="form-horizontal" id="form-search">
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
                    <label class="col-md-3 col-sm-4  control-label">Price Range</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control ajax_change" name="price_min" value=""> Min<br />
                        To <br />
                        <input type="text" class="form-control ajax_change" name="price_max" value=""> Max
                        <div class="error"></div>
                    </div>
                  </div>
                </form>
                <form class="form-horizontal" id="form-send" method="post">
                <legend>Details</legend>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">Title</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="title" id="sms_title" value="" class="" />
                        <div class="error"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">#Recipient</label>
                    <div class="col-sm-6">
                      <label id="hash_recipient">0</label>
                       <div class="error"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">Recipient(s)</label>
                    <div class="col-sm-4">
                        <select name="receivers[]" class="form-control" multiple="multiple" id="receivers">
                        </select>
                        <div class="error"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 col-sm-4  control-label">SMS Content</label>
                    <div class="col-sm-4">
                        <textarea name="content" class="form-control" id="sms_content" rows="5" cols="50"></textarea>
                        <div class="error">Note: Use <b><i>{first_name}</i></b>, <b><i>{last_name}</i></b> as name placeholder</div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <input type="button" onclick="sendBulkMessage()" value="Send Newsletter" class="btn btn-sm btn-primary" />
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