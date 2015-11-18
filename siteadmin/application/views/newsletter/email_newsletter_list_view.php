<?php

$this->load->view('header');
$this->load->view('leftmenu');
?>
<div class="container-fluid">
     <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php }else if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>
    <div class="row">
      <div class="main">
        <h1 class="page-header">Email Newsletter
          <button class="btn btn-sm btn-success pull-right" type="button" onClick="window.location.href = 'emailnewsletter';">Add New</button>
        </h1>
        <div class="row">   
          <div class="col-sm-12">
                    <div>
                        <table id="example">
                                <thead>
                                    <tr>
                                        <th hidden>id</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Campaign ID</th>
                                        <th>Type</th>
                                        <th>Schedule</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($newsletters)) {
                                        foreach ($newsletters as $key => $value) {
                                            ?>
                                            <tr>
                                                <td data-th='id.' hidden><div><?php echo $value->id; ?></div></td>
                                                <td data-th='Title'><div><?php echo $value->title; ?></div></td>
                                                <td data-th='Content'><div><?php echo $value->content; ?></div></td>
                                                <td data-th='Campaign ID'><div><?php echo $value->campaign_id; ?></div></td>
                                                <td data-th='Type'><div><?php echo $value->type; ?></div></td>
                                                <td data-th='Schedule'><div><?php if($value->type=='date'){ echo date("m/d/Y",strtotime($value->schedule)); }else{ echo $value->schedule; } ?></td>
                                                <td data-th='Created'><div><?php echo date("m/d/Y",strtotime($value->created)); ?></div></td>
                                            </tr>
                                                    <?php
                                                }
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
<?php
$this->load->view('footer');
?>