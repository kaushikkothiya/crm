<?php $this->load->view('header'); ?>
<?php $this->load->view('leftmenu'); ?>
<?php $Action = array('1' => 'Register', '2' => 'Text-Send', '3' => 'Follow-Up', '4' => 'Appointment', '5' => 'Complete'); ?>
<?php $Agent_Action = array('0' => 'Pending', '1' => 'Confirmed', '2' => 'Rechedule', '3' => 'Cancel'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="main">
            <h1 class="page-header">Property Report</h1>
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
                                                                <option <?php echo ( isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 2 && isset($_REQUEST['agent_user_id']) && !empty($_REQUEST['agent_user_id']) && $_REQUEST['agent_user_id'] == 'all' ) ? ' selected="selected" ' : ''; ?> value="all">All</option>
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
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="employee_user_id" id="employee_user_id" >
                                                                <option value="">Select</option>
                                                                <option <?php echo ( (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 3) && isset($_REQUEST['employee_user_id']) && $_REQUEST['employee_user_id'] == 'all' ) ? ' selected="selected" ' : ''; ?> value="all">All</option>
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
                                                <input type="radio" name="report_type" data-text="monthly" <?php echo ( (isset($_REQUEST['report_type']) && $_REQUEST['report_type'] == "monthly") || !isset($_REQUEST['report_type'])) ? ' checked="checked" ' : ''; ?> id="report_type_monthly" value="monthly" > Monthly
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
                                        <div class="form-group report_type monthly">
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <div class="btn-group" role="group" aria-label="...">
                                                    <a type="button" class="btn btn-default report-prev-month"> <span class="glyphicon glyphicon-chevron-left"></span> Prev </a>
                                                    <a type="button" class="btn btn-default"><?php echo isset($_REQUEST['from_date']) ? date('F, Y',  strtotime($_REQUEST['from_date'])) : date('F, Y'); ?></a>
                                                    <a type="button" class="btn btn-default report-next-month <?php echo (date('Y-m') == date('Y-m',  strtotime($_REQUEST['from_date']))) ? 'disabled' : ''; ?>" > Next <span class="glyphicon glyphicon-chevron-right"></span></a>
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
                                        <div class="col-sm-12">
                                            <ul class="list-group">
                                                <li class="list-group-item"><span class="badge" data-toggle="tooltip" title="Total Inquiries posted by you"><?php echo count($reporting['added_properties']); ?></span>Added Properties</li>
                                                <li class="list-group-item"><span class="badge" data-toggle="tooltip" title="Count of Inquiries assigned to agent by you"><?php echo count($reporting['assigned_properties']); ?></span>Assigned Properties</li>
                                                <li class="list-group-item"><span class="badge" data-toggle="tooltip" title="Count of Inquiries assigned to agent by you"><?php echo count($reporting['agent_properties']); ?></span>Agent Properties</li>
                                                <li class="list-group-item"><span class="badge" data-toggle="tooltip" title="Count of Inquiries completed and posted by you"><?php echo count($reporting['active_properties']); ?></span>Active Properties</li>
                                                <li class="list-group-item"><span class="badge" data-toggle="tooltip" title="Count of Inquiries completed and posted by you"><?php echo count($reporting['inactive_properties']); ?></span>Inactive Properties</li>
                                            </ul>
                                        </div>
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
                                            <li role="presentation" class="active"><a href="#added_properties" aria-controls="added_properties" role="tab" data-toggle="tab">Added Properties (<?php echo count($reporting['added_properties']); ?>)</a></li>
                                            <li role="presentation"><a href="#assigned_properties" aria-controls="assigned_properties" role="tab" data-toggle="tab">Assigned Properties (<?php echo count($reporting['assigned_properties']); ?>)</a></li>
                                            <li role="presentation"><a href="#active_properties" aria-controls="active_properties" role="tab" data-toggle="tab">Active Properties (<?php echo count($reporting['active_properties']); ?>)</a></li>
                                            <li role="presentation"><a href="#inactive_properties" aria-controls="inactive_properties" role="tab" data-toggle="tab">Inactive Properties (<?php echo count($reporting['inactive_properties']); ?>)</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="added_properties">
                                                <table class="table table-striped responsive-table">
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
                                                            <th style="min-width: 135px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($reporting['added_properties']) > 0) { ?>
                                                            <?php foreach ($reporting['added_properties'] as $inquiry) { ?>
                                                                <tr>
                                                                    <td data-th='ID' hidden><div><?php echo $inquiry->id; ?></div></td>
                                                                    <td data-th='Reference No.'><div><?php echo $inquiry->reference_no; ?><br />Created on <?php echo date("d-M-Y", strtotime($inquiry->created_date)); ?><br /> Updated on  <?php echo date("d-M-Y", strtotime($inquiry->updated_date)); ?></div></td>
                                                                    <td data-th='Agent Name'><div><?php echo $inquiry->fname . ' ' . $inquiry->lname; ?></div></td>
                                                                    <td data-th='Property Area'><div><?php echo $inquiry->title; ?></div></td>
                                                                    <td data-th='Property Status'><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo "Sale";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Rent";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Both(Sale/Rent)";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Price(€)" style="text-align: right"><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo (!empty($inquiry->sale_price)) ? '€ ' . number_format($inquiry->sale_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '2':
                                                                                    echo (!empty($inquiry->rent_price)) ? '€ ' . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '3':
                                                                                    echo (!empty($inquiry->sale_price) || !empty($inquiry->rent_price)) ? 'SP. € ' . number_format($inquiry->sale_price, 0, ".", ",") . " <br /> RP. € " . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Furnish Type" style="min-width:60px"><div><?php
                                                                            switch ($inquiry->furnished_type) {
                                                                                case '1':
                                                                                    echo "Furnished";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Semi-Furnished";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Un-Furnished";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th='Image'><div><?php
                                                                            echo (!empty($inquiry->image_name)) ? '<img src="' . base_url() . 'img_prop/100x100/' . $inquiry->image_name . '" width="75" height="75">' : '<img src="' . base_url() . 'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                                                            ?></div></td>
                                                                    <td data-th="Status"><div><?php
                                                                            echo ($inquiry->status == 'Active') ? '<span style="width:10px;height:10px;display:inline-block;background:#5cb85c;"></span> Active' : '<span style="width:10px;height:10px;display:inline-block;background:#d9534f;"></span> Inactive';
                                                                            ?></div></td>
                                                                    <td data-th="Actions">
                                                                        <a href="<?php echo base_url(); ?>home/view_property/<?php echo $inquiry->id; ?>"  target='_blank' class="btn btn-default btn-xs action-btn" rel="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <tr><td colspan="9">No Properties Found</td></tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="assigned_properties">
                                                <table class="table table-striped responsive-table">
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
                                                            <th style="min-width: 135px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($reporting['assigned_properties']) > 0) { ?>
                                                            <?php foreach ($reporting['assigned_properties'] as $inquiry) { ?>
                                                                <tr>
                                                                    <td data-th='ID' hidden><div><?php echo $inquiry->id; ?></div></td>
                                                                    <td data-th='Reference No.'><div><?php echo $inquiry->reference_no; ?><br />Created on <?php echo date("d-M-Y", strtotime($inquiry->created_date)); ?><br /> Updated on  <?php echo date("d-M-Y", strtotime($inquiry->updated_date)); ?></div></td>
                                                                    <td data-th='Agent Name'><div><?php echo $inquiry->fname . ' ' . $inquiry->lname; ?></div></td>
                                                                    <td data-th='Property Area'><div><?php echo $inquiry->title; ?></div></td>
                                                                    <td data-th='Property Status'><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo "Sale";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Rent";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Both(Sale/Rent)";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Price(€)" style="text-align: right"><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo (!empty($inquiry->sale_price)) ? '€ ' . number_format($inquiry->sale_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '2':
                                                                                    echo (!empty($inquiry->rent_price)) ? '€ ' . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '3':
                                                                                    echo (!empty($inquiry->sale_price) || !empty($inquiry->rent_price)) ? 'SP. € ' . number_format($inquiry->sale_price, 0, ".", ",") . " <br /> RP. € " . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Furnish Type" style="min-width:60px"><div><?php
                                                                            switch ($inquiry->furnished_type) {
                                                                                case '1':
                                                                                    echo "Furnished";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Semi-Furnished";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Un-Furnished";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th='Image'><div><?php
                                                                            echo (!empty($inquiry->image_name)) ? '<img src="' . base_url() . 'img_prop/100x100/' . $inquiry->image_name . '" width="75" height="75">' : '<img src="' . base_url() . 'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                                                            ?></div></td>
                                                                    <td data-th="Status"><div><?php
                                                                            echo ($inquiry->status == 'Active') ? '<span style="width:10px;height:10px;display:inline-block;background:#5cb85c;"></span> Active' : '<span style="width:10px;height:10px;display:inline-block;background:#d9534f;"></span> Inactive';
                                                                            ?></div></td>
                                                                    <td data-th="Actions">
                                                                        <a href="<?php echo base_url(); ?>home/view_property/<?php echo $inquiry->id; ?>"  target='_blank' class="btn btn-default btn-xs action-btn" rel="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <tr><td colspan="9">No Properties Found</td></tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="active_properties">
                                                <table class="table table-striped responsive-table">
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
                                                            <th style="min-width: 135px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($reporting['active_properties']) > 0) { ?>
                                                            <?php foreach ($reporting['active_properties'] as $inquiry) { ?>
                                                                <tr>
                                                                    <td data-th='ID' hidden><div><?php echo $inquiry->id; ?></div></td>
                                                                    <td data-th='Reference No.'><div><?php echo $inquiry->reference_no; ?><br />Created on <?php echo date("d-M-Y", strtotime($inquiry->created_date)); ?><br /> Updated on  <?php echo date("d-M-Y", strtotime($inquiry->updated_date)); ?></div></td>
                                                                    <td data-th='Agent Name'><div><?php echo $inquiry->fname . ' ' . $inquiry->lname; ?></div></td>
                                                                    <td data-th='Property Area'><div><?php echo $inquiry->title; ?></div></td>
                                                                    <td data-th='Property Status'><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo "Sale";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Rent";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Both(Sale/Rent)";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Price(€)" style="text-align: right"><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo (!empty($inquiry->sale_price)) ? '€ ' . number_format($inquiry->sale_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '2':
                                                                                    echo (!empty($inquiry->rent_price)) ? '€ ' . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '3':
                                                                                    echo (!empty($inquiry->sale_price) || !empty($inquiry->rent_price)) ? 'SP. € ' . number_format($inquiry->sale_price, 0, ".", ",") . " <br /> RP. € " . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Furnish Type" style="min-width:60px"><div><?php
                                                                            switch ($inquiry->furnished_type) {
                                                                                case '1':
                                                                                    echo "Furnished";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Semi-Furnished";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Un-Furnished";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th='Image'><div><?php
                                                                            echo (!empty($inquiry->image_name)) ? '<img src="' . base_url() . 'img_prop/100x100/' . $inquiry->image_name . '" width="75" height="75">' : '<img src="' . base_url() . 'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                                                            ?></div></td>
                                                                    <td data-th="Status"><div><?php
                                                                            echo ($inquiry->status == 'Active') ? '<span style="width:10px;height:10px;display:inline-block;background:#5cb85c;"></span> Active' : '<span style="width:10px;height:10px;display:inline-block;background:#d9534f;"></span> Inactive';
                                                                            ?></div></td>
                                                                    <td data-th="Actions">
                                                                        <a href="<?php echo base_url(); ?>home/view_property/<?php echo $inquiry->id; ?>"  target='_blank' class="btn btn-default btn-xs action-btn" rel="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <tr><td colspan="9">No Properties Found</td></tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="inactive_properties">
                                                <table class="table table-striped responsive-table">
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
                                                            <th style="min-width: 135px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($reporting['inactive_properties']) > 0) { ?>
                                                            <?php foreach ($reporting['inactive_properties'] as $inquiry) { ?>
                                                                <tr>
                                                                    <td data-th='ID' hidden><div><?php echo $inquiry->id; ?></div></td>
                                                                    <td data-th='Reference No.'><div><?php echo $inquiry->reference_no; ?><br />Created on <?php echo date("d-M-Y", strtotime($inquiry->created_date)); ?><br /> Updated on  <?php echo date("d-M-Y", strtotime($inquiry->updated_date)); ?></div></td>
                                                                    <td data-th='Agent Name'><div><?php echo $inquiry->fname . ' ' . $inquiry->lname; ?></div></td>
                                                                    <td data-th='Property Area'><div><?php echo $inquiry->title; ?></div></td>
                                                                    <td data-th='Property Status'><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo "Sale";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Rent";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Both(Sale/Rent)";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Price(€)" style="text-align: right"><div><?php
                                                                            switch ($inquiry->type) {
                                                                                case '1':
                                                                                    echo (!empty($inquiry->sale_price)) ? '€ ' . number_format($inquiry->sale_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '2':
                                                                                    echo (!empty($inquiry->rent_price)) ? '€ ' . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                                case '3':
                                                                                    echo (!empty($inquiry->sale_price) || !empty($inquiry->rent_price)) ? 'SP. € ' . number_format($inquiry->sale_price, 0, ".", ",") . " <br /> RP. € " . number_format($inquiry->rent_price, 0, ".", ",") : '';
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th="Furnish Type" style="min-width:60px"><div><?php
                                                                            switch ($inquiry->furnished_type) {
                                                                                case '1':
                                                                                    echo "Furnished";
                                                                                    break;
                                                                                case '2':
                                                                                    echo "Semi-Furnished";
                                                                                    break;
                                                                                case '3':
                                                                                    echo "Un-Furnished";
                                                                                    break;
                                                                            }
                                                                            ?></div></td>
                                                                    <td data-th='Image'><div><?php
                                                                            echo (!empty($inquiry->image_name)) ? '<img src="' . base_url() . 'img_prop/100x100/' . $inquiry->image_name . '" width="75" height="75">' : '<img src="' . base_url() . 'upload/property/100x100/noimage.jpg" width="75" height="75">';
                                                                            ?></div></td>
                                                                    <td data-th="Status"><div><?php
                                                                            echo ($inquiry->status == 'Active') ? '<span style="width:10px;height:10px;display:inline-block;background:#5cb85c;"></span> Active' : '<span style="width:10px;height:10px;display:inline-block;background:#d9534f;"></span> Inactive';
                                                                            ?></div></td>
                                                                    <td data-th="Actions">
                                                                        <a href="<?php echo base_url(); ?>home/view_property/<?php echo $inquiry->id; ?>"  target='_blank' class="btn btn-default btn-xs action-btn" rel="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <tr><td colspan="9">No Properties Found</td></tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
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

    Date.prototype.addDays = function (days) {
        var dat = new Date(this.valueOf());
        dat.setDate(dat.getDate() + days);
        return dat;
    }
    
    function addMonths(dateObj, num) {

        var currentMonth = dateObj.getMonth();
        dateObj.setMonth(dateObj.getMonth() + num)

        if (dateObj.getMonth() != ((currentMonth + num) % 12)){
            dateObj.setDate(0);
        }
        return dateObj;
    }

    $(document).ready(function () {
        $('input[name=user_type]').on('click', function () {
            $('.user_type').hide();
            $('input[name=user_type]').each(function(){
                if($(this).is(":checked")){
                    $('.user_type.' + $(this).data('text')).show();
                }
            });
        });

<?php if (!isset($_REQUEST['user_type']) || (isset($_REQUEST['user_type']) && $_REQUEST['user_type']==1)) { ?>
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
        $('.report-prev').click(function () {
            if ($("#from").val() != $("#to").val()) {
                dt = new Date();
            } else {
                dt = new Date(phpdate.split("/")[2], (phpdate.split("/")[0]-1), phpdate.split("/")[1]);
            }

            dt = dt.addDays(-1);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + d + '/' + y;
            $("#from").val(dt);
            $("#to").val(dt);
            $("#sub_report").trigger("click");
        });

        $('.report-next').click(function () {
            if ($("#from").val() != $("#to").val()) {
                dt = new Date();
            } else {
                dt = new Date(phpdate.split("/")[2], (phpdate.split("/")[0]-1), phpdate.split("/")[1]);
            }

            dt = dt.addDays(1);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + d + '/' + y;
            $("#from").val(dt);
            $("#to").val(dt);
            $("#sub_report").trigger("click");
        });
        
        $('.report-prev-month').click(function () {
            <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']!='monthly'){ ?>
                dt = new Date();
            <?php } else { ?>
                dt = new Date(phpdate.split("/")[2], (phpdate.split("/")[0]-1), phpdate.split("/")[1]);
            <?php } ?>

            dt = addMonths(dt,-1);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + '01' + '/' + y;
            $("#from").val(dt);
            console.log(dt);
            
            dt = new Date(y, parseInt(m) + 1, 0);
            //console.log(m);
            m = dt.getMonth().toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + d + '/' + y;
            $("#to").val(dt);
            //console.log(dt);
            $("#sub_report").trigger("click");
        });

        $('.report-next-month').click(function () {
            <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']!='monthly'){ ?>
                dt = new Date();
            <?php } else { ?>
                dt = new Date(phpdate.split("/")[2], (phpdate.split("/")[0]-1), phpdate.split("/")[1]);
            <?php } ?>

            dt = addMonths(dt,1);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + '01' + '/' + y;
            $("#from").val(dt);
            //console.log(dt);
            dt = new Date(y, parseInt(m), 0);
            m = (dt.getMonth()+1).toString();
            m = (m.length < 2) ? ('0' + m) : m;
            d = dt.getDate().toString();
            d = (d.length < 2) ? ('0' + d) : d;
            y = dt.getFullYear();
            dt = m + '/' + d + '/' + y;
            $("#to").val(dt);
            //console.log(dt);
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