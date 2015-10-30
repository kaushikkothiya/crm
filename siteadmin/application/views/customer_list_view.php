<?php

$this->load->view('header');

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
        <div class="span10 body-container">
            <div class="row-fluid">
                <div class="span12">
                    <ul class="breadcrumb">
                        <li><?php echo anchor('home', 'Home', "title='Home'"); ?>
                            <span class="divider">/
                            </span></li>
                        <li><?php echo anchor('home/customer_manage', 'Client Management', "title='Client Management'"); ?>
                            <span class="divider">
                            </span></li>
								<li style="float:right;"><a href="add_customer"><input type="button" value="Add New" /></a></li>
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
                            <span>Client Management </span>
                        </div>
                        <div class="utopia-widget-content">
                            <div class="table-responsive">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th hidden>Id</th>
                                        <th>Registered Date</th>
                                        <th>Name/Surname</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                     					<th>Reference From</th>
                                        <th>Property Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    for ($i = 0; $i < count($user); $i++) {
                                        echo "<tr>";
                                        echo "<td hidden>" . $user[$i]->id. "</td>";
                                        echo "<td>" . date("d-M-Y", strtotime($user[$i]->created_date)). "</td>";
                                        echo "<td>" . $user[$i]->fname." ".$user[$i]->lname . "</td>";
                                        echo "<td>" . $user[$i]->email. "</td>";
                                        echo "<td>" . $user[$i]->mobile_no. "</td>";
                                        if($user[$i]->reference_from =='1'){
                                        echo "<td>Phone</td>";    
                                        }elseif ($user[$i]->reference_from=='2') {
                                        echo "<td>Facebook</td>";    
                                        }elseif ($user[$i]->reference_from=='3') {
                                        echo "<td>Website</td>";    
                                        }else{
                                        echo "<td></td>";    
                                        }
                                        if($user[$i]->aquired =="sale"){
                                        echo "<td>Sale</td>";    
                                        }elseif ($user[$i]->aquired=="rent") {
                                        echo "<td>Rent</td>";    
                                        }elseif ($user[$i]->aquired=="both") {
                                        echo "<td>Sale/Rent</td>";    
                                        }else{
                                        echo "<td></td>";    
                                        }
                                        
     									echo "<td>" . $user[$i]->status. "</td>";
                                        echo "<td>";
                                            echo anchor('home/add_customer/'.$user[$i]->id, '<i class="icon-pencil"></i>', array('title'=>'Edit Client','class'=>"btn btn-default btn-small"));
                                            echo anchor('inquiry/inquiry_manage?view_client='.$user[$i]->id, '<i class="icon-zoom-in"></i>',array('title'=>'View Inquiry','class'=>'btn btn-default btn-small'));
                                            echo anchor('home/delete_customer/'.$user[$i]->id, '<i class="icon-trash"></i>', array('onClick' => "return confirm('Are you sure want to delete this record?')",'title'=>'Delete Inquiry','class'=>'btn btn-default btn-small'));
                                        echo "</tr>";

                                    }

                                    ?>
                                </tbody>
                            </table>
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



