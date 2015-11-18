
<?php $this->load->view('header'); ?>
<?php $this->load->view('leftmenu'); ?>
<?php $Action = array('1' => 'Register', '2' => 'Text-Send', '3' => 'Follow-Up', '4' => 'Appointment', '5' => 'Complete'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="main">
            <h1 class="page-header">Reports</h1>
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="row">
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        </div>
                    <?php } else if ($this->session->flashdata('error')) { ?>
                        <div class="row">
                            <div class="alert alert-error" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Filters</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="post">
                                        <?php if ($user['type'] == 1) { ?>
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">View Report For : </label>
                                                <div class="col-sm-10">
                                                    <input type="radio" name="user_type" data-text="agent" <?php echo ( (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 2) || !isset($_REQUEST['user_type'])) ? ' checked="checked" ' : ''; ?> id="user_type_2" value="2" > Agent
                                                    <input type="radio" name="user_type" data-text="employee" <?php echo ( isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 3 ) ? ' checked="checked" ' : ''; ?>  id="user_type_3" value="3" class="ML20" style="margin-left:20px;"> Employee
                                                </div>
                                            </div>
                                            <div class="form-group user_type agent">
                                                <label for="" class="col-sm-2 control-label">Select Agent : </label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <select class="form-control " name="agent_user_id" id="agent_user_id" >
                                                                <option value="">Select</option>
                                                                <?php foreach ($agents as $key => $agent) { ?>
                                                                    <option <?php echo ( isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 2 && isset($_REQUEST['agent_user_id']) && !empty($_REQUEST['agent_user_id']) && $_REQUEST['agent_user_id'] == $agent->id ) ? ' selected="selected" ' : ''; ?> value="<?php echo $agent->id; ?>" ><?php echo $agent->fname . ' ' . $agent->lname; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group user_type employee">
                                                <label for="" class="col-sm-2 control-label">Select Employee : </label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <select class="form-control" name="employee_user_id" id="employee_user_id" >
                                                                <option value="">Select</option>
                                                                <?php foreach ($employees as $employee) { ?>
                                                                    <option <?php echo ( (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 3) && isset($_REQUEST['employee_user_id']) && $_REQUEST['employee_user_id'] == $employee->id ) ? ' selected="selected" ' : ''; ?> value="<?php echo $employee->id; ?>"><?php echo $employee->fname . ' ' . $employee->lname; ?></option>
                                                                <?php } ?> 
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="" class="col-sm-2 control-label">Report Type: </label>
                                            <div class="col-sm-10">
                                                <input type="radio" name="report_type" data-text="daily" <?php echo ( (isset($_REQUEST['report_type']) && $_REQUEST['report_type'] == "daily") || !isset($_REQUEST['report_type'])) ? ' checked="checked" ' : ''; ?> id="report_type_daily" value="daily" > Daily
                                                <input type="radio" name="report_type" data-text="date_range" <?php echo ( (isset($_REQUEST['report_type']) && $_REQUEST['report_type'] == "date_range") ) ? ' checked="checked" ' : ''; ?>  id="report_type_date_range" value="date_range" class="ML20" style="margin-left:20px;"> Date Range
                                            </div>
                                        </div>
                                        <div class="form-group report_type daily">                                           
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <div class="btn-group" role="group" aria-label="...">
                                                    <a type="button" class="btn btn-default report-prev"> <span class="glyphicon glyphicon-chevron-left"></span> Prev </a>
                                                    <a type="button" class="btn btn-default"><?php echo isset($_REQUEST['from_date']) ? $_REQUEST['from_date'] : date('m/d/Y'); ?></a>
                                                    <a type="button" class="btn btn-default report-next <?php echo (date('m/d/Y') == $_REQUEST['from_date']) ? 'disabled' : ''; ?>" > Next <span class="glyphicon glyphicon-chevron-right"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group report_type date_range">
                                            <label for="" class="col-sm-2 control-label">Select Date Range : </label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-sm-4"><input class="form-control" value="<?php echo isset($_REQUEST['from_date']) ? $_REQUEST['from_date'] : ''; ?>" type="text" id="from" name="from_date"></div>
                                                    <div class="col-sm-1 date-to" style="text-align:center; padding: 5px 0;">to</div>
                                                    <div class="col-sm-4"><input class="form-control" value="<?php echo isset($_REQUEST['to_date']) ? $_REQUEST['to_date'] : ''; ?>" type="text" id="to" name="to_date"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">                                           
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <input type="submit" value="Go" id="sub_report" class="btn btn-default" />
                                            </div>
                                        </div>   
                                    </form>
                                </div>
                            </div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Summary</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-<?php echo ($user['type'] == 3) ? '12' : '6'; ?>">
                                            <ul class="list-group">
                                                <li class="list-group-item disabled">Inquiries</li>
                                                <li class="list-group-item"><span class="badge"><?php echo count($reporting['inquiries']); ?></span>Total</li>
                                                <li class="list-group-item"><span class="badge"><?php echo $reporting['summery']['appointments_assigned']; ?></span>Appointments Assigned</li>
                                                <li class="list-group-item"><span class="badge"><?php echo $reporting['summery']['inquiry_completed']; ?></span>Inquiries Completed</li>
                                            </ul>
                                        </div>
                                        <?php if ($user['type'] == 1 || $user['type'] == 2) { ?>
                                            <div class="col-sm-6">
                                                <ul class="list-group">
                                                    <li class="list-group-item disabled">Appointments</li>
                                                    <li class="list-group-item"><span class="badge"><?php echo count($reporting['appointments']); ?></span>Total</li>
                                                    <li class="list-group-item"><span class="badge"><?php echo $reporting['summery']['appointments_completed']; ?></span>Appointments Completed</li>
                                                    <li class="list-group-item"><span class="badge"><?php echo $reporting['summery']['appointments_canceled']; ?></span>Appointments Canceled</li>
                                                    <li class="list-group-item"><span class="badge"><?php echo $reporting['summery']['appointments_reschedule']; ?></span>Appointments Reschedule</li>
                                                    <li class="list-group-item"><span class="badge"><?php echo $reporting['summery']['appointments_confirmed']; ?></span>Appointments Confirmed</li>
                                                </ul>  
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Details</h3>
                                </div>
                                <div class="panel-body">
                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#inquiries" aria-controls="inquiries" role="tab" data-toggle="tab">Inquiries</a></li>
                                            <?php if ($user['type'] == 1 || $user['type'] == 2) { ?>
                                                <li role="presentation"><a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab">Appointments</a></li>
                                            <?php } ?>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="inquiries">
                                                <table class="table table-striped responsive-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Reference No</th>
                                                            <th>Inquiry No</th>
                                                            <th>Property Status</th>
                                                            <th>Agent Name</th>
                                                            <th>Created by</th>
                                                            <th>Date Created</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($reporting['inquiries']) > 0) { ?>
                                                            <?php foreach ($reporting['inquiries'] as $inquiry) { ?>
                                                                <tr>
                                                                    <td data-th="Reference No"><div><?php echo $inquiry->property_ref_no ?></div></td>
                                                                    <td data-th="Inquiry No"><div><?php echo $inquiry->incquiry_ref_no ?></div></td>
                                                                    <td data-th="Property Status"><div><?php echo ucfirst($inquiry->aquired); ?></div></td>
                                                                    <td data-th="Agent Name"><div><?php echo ucfirst($inquiry->a_fname . ' ' . $inquiry->a_lname); ?></div></td>
                                                                    <td data-th="Created by"><div><?php echo ucfirst($inquiry->u_fname . ' ' . $inquiry->u_lname); ?></div></td>
                                                                    <td data-th="Date Created"><div><?php echo date("d-M-Y", strtotime($inquiry->created_date)); ?></div></td>
                                                                    <td data-th="Status"><div><?php echo $Action[$inquiry->status]; ?><?php if (!empty($inquiry->diff_ass_conf) && $inquiry->diff_ass_conf != 0) { ?>&nbsp;&nbsp;<span class="badge"><?php echo $inquiry->diff_ass_conf; ?></span><?php } ?></div></td> 
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <tr><td colspan="7">No Inquiries</td></tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php if ($user['type'] == 1 || $user['type'] == 2) { ?>
                                                <div role="tabpanel" class="tab-pane" id="appointments">
                                                    <table class="table table-striped responsive-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Reference No</th>
                                                                <th>Inquiry No</th>
                                                                <th>Property Status</th>
                                                                <th>Agent Name</th>
                                                                <th>Created by</th>
                                                                <th>Date Created</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (count($reporting['appointments']) > 0) { ?>
                                                                <?php foreach ($reporting['appointments'] as $inquiry) { ?>
                                                                    <tr>
                                                                        <td data-th="Reference No"><div><?php echo $inquiry->property_ref_no ?></div></td>
                                                                        <td data-th="Inquiry No"><div><?php echo $inquiry->incquiry_ref_no ?></div></td>
                                                                        <td data-th="Property Status"><div><?php echo ucfirst($inquiry->aquired); ?></div></td>
                                                                        <td data-th="Agent Name"><div><?php echo ucfirst($inquiry->a_fname . ' ' . $inquiry->a_lname); ?></div></td>
                                                                        <td data-th="Created by"><div><?php echo ucfirst($inquiry->u_fname . ' ' . $inquiry->u_lname); ?></div></td>
                                                                        <td data-th="Date Created"><div><?php echo date("d-M-Y", strtotime($inquiry->created_date)); ?></div></td>
                                                                        <td data-th="Status"><div><?php echo $Action[$inquiry->status]; ?><?php if (!empty($inquiry->diff_ass_conf) && $inquiry->diff_ass_conf != 0) { ?>&nbsp;&nbsp;<span class="badge"><?php echo $inquiry->diff_ass_conf; ?></span><?php } ?></div></td> 
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <tr><td colspan="7">No Appointments</td></tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sep"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>
<script type="text/javascript">
    
    Date.prototype.addDays = function(days) {
        var dat = new Date(this.valueOf());
        dat.setDate(dat.getDate() + days);
        return dat;
    }
    
    $(document).ready(function () {
        $('input[name=user_type]').on('click', function () {
            $('.user_type').hide();
            $('.user_type.' + $('input[name=user_type]:checked').data('text')).show();
        });

<?php if (!isset($_REQUEST['user_type'])) { ?>
            $('input[name=user_type]').first().trigger('click');
<?php } else { ?>
            $('input[name=user_type][value=<?php echo $_REQUEST['user_type']; ?>]').trigger('click');
<?php } ?>

        $('input[name=report_type]').on('click', function () {
            $('.report_type').hide();
            $('.report_type.' + $('input[name=report_type]:checked').data('text')).show();
        });

<?php if (!isset($_REQUEST['report_type'])) { ?>
            $('input[name=report_type]').first().trigger('click');
<?php } else { ?>        
    
            $('input[name=report_type][value=<?php echo $_REQUEST['report_type']; ?>]').trigger('click');
<?php } ?>
        var phpdate = '<?php echo $_REQUEST['from_date']; ?>';
        $('.report-prev').click(function(){
            if($("#from").val()!=$("#to").val()){
                dt = new Date();
            }else{
                dt = new Date(phpdate.split("/")[2],phpdate.split("/")[0],phpdate.split("/")[1]);
            }
            
            dt = dt.addDays(-1);
            m = dt.getMonth().toString();
            m = (m.length<2)?('0'+m):m;
            d = dt.getDate().toString();
            d = (d.length<2)?('0'+d):d;
            y = dt.getFullYear();
            dt = m+'/'+d+'/'+y;
            $("#from").val(dt);
            $("#to").val(dt);
            $("#sub_report").trigger("click");
        });
        
        $('.report-next').click(function(){
            if($("#from").val()!=$("#to").val()){
                dt = new Date();
            }else{
                dt = new Date(phpdate.split("/")[2],phpdate.split("/")[0],phpdate.split("/")[1]);
            }
            
            dt = dt.addDays(1);
            m = dt.getMonth().toString();
            m = (m.length<2)?('0'+m):m;
            d = dt.getDate().toString();
            d = (d.length<2)?('0'+d):d;
            y = dt.getFullYear();
            dt = m+'/'+d+'/'+y;
            $("#from").val(dt);
            $("#to").val(dt);
            $("#sub_report").trigger("click");
        });

        $("#from").datepicker({
            defaultDate: "-1m",
            changeMonth: true,
            maxDate: new Date,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });

        $("#to").datepicker({
            changeMonth: true,
            maxDate: new Date,
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>