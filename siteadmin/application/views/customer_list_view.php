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
        <h1 class="page-header">Client List
          <button class="btn btn-sm btn-info pull-right" type="button" onClick="window.location.href = 'add_customer';">Create Client</button>
        </h1>
        <div class="row">   
          <div class="col-sm-12">
                    <div>
                        <table id="example">
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
                                        <th style="width: 187px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    for ($i = 0; $i < count($user); $i++) {
                                        echo "<tr>";
                                        echo "<td data-th='Id.' hidden><div>" . $user[$i]->id. "</div></td>";
                                        echo "<td data-th='Registered Date'><div>" . date("d-M-Y", strtotime($user[$i]->created_date)). "</div></td>";
                                        echo "<td data-th='Name/Surname'><div>" . $user[$i]->fname." ".$user[$i]->lname . "</div></td>";
                                        echo "<td data-th='Email'><div>" . $user[$i]->email. "</div></td>";
                                        echo "<td data-th='Telephone'><div>" . $user[$i]->mobile_no. "</div></td>";
                                        if($user[$i]->reference_from =='1'){
                                        echo "<td data-th='Reference From'><div>Phone</div></td>";    
                                        }elseif ($user[$i]->reference_from=='2') {
                                        echo "<td data-th='Reference From'><div>Facebook</div></td>";    
                                        }elseif ($user[$i]->reference_from=='3') {
                                        echo "<td data-th='Reference From'><div>Website</div></td>";    
                                        }else{
                                        echo "<td data-th='Reference From'><div></div></td>";    
                                        }
                                        if($user[$i]->aquired =="sale"){
                                        echo "<td data-th='Property Status'><div>Sale</div></td>";    
                                        }elseif ($user[$i]->aquired=="rent") {
                                        echo "<td data-th='Property Status'><div>Rent</div></td>";    
                                        }elseif ($user[$i]->aquired=="both") {
                                        echo "<td data-th='Property Status'><div>Sale/Rent</div></td>";    
                                        }else{
                                        echo "<td data-th='Property Status'><div></div></td>";    
                                        }
                                        
                                        echo "<td data-th='Status'><div>" . $user[$i]->status. "</div></td>";
                                        ?>
                                        <td data-th="Actions">
                                            <div>
                                                <a href="<?php echo base_url(); ?>inquiry/inquiry_manage/?view_client=<?php echo $user[$i]->id; ?>" class="btn btn-default btn-xs action-btn" rel="tooltip" title="View"><i class="fa fa-eye"></i></a> 
                                                <a href="add_customer/<?php echo $user[$i]->id; ?>" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></a> 
                                                <a href="delete_customer/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs action-btn" rel="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                        <?php
                                        //echo "<td>";
                                          //  echo anchor('home/add_customer/'.$user[$i]->id, '<i class="icon-pencil"></i>', array('title'=>'Edit Client','class'=>"btn btn-default btn-small"));
                                            //echo anchor('inquiry/inquiry_manage?view_client='.$user[$i]->id, '<i class="icon-zoom-in"></i>',array('title'=>'View Inquiry','class'=>'btn btn-default btn-small'));
                                            //echo anchor('home/delete_customer/'.$user[$i]->id, '<i class="icon-trash"></i>', array('onClick' => "return confirm('Are you sure want to delete this record?')",'title'=>'Delete Inquiry','class'=>'btn btn-default btn-small'));
                                        echo "</tr>";

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
