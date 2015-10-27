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
     									echo "<td>" . $user[$i]->status. "</td>";
                                        echo "<td><span style='text-align:left;width: 30%;float: left;'><i class='icon-pencil'></i>&nbsp;" . anchor('home/add_customer/'.$user[$i]->id, 'Edit', "title='Edit Client'"). "</span>";
                                        echo "<span style='text-align:left;width: 30%;float: left;'><i class='icon-zoom-in'></i>&nbsp;" . anchor('inquiry/inquiry_manage?view_client='.$user[$i]->id, 'View Inquiry'). "</span>";
                                        echo "<span style='text-align:left;width: 30%;float: left;'><i class='icon-trash'></i>&nbsp;" . anchor('home/delete_customer/'.$user[$i]->id, 'Delete', array('onClick' => "return confirm('Are you sure want to delete this record?')")). "</span>";
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



