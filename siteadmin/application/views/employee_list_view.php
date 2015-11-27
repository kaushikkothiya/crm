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
        <h1 class="page-header">Employee List
          <button class="btn btn-sm btn-info pull-right" type="button" onClick="window.location.href = 'add_employee';">Create Employee</button>
        </h1>
        <div class="row">   
          <div class="col-sm-12">
                    <div>
                        <table id="example">
                                <thead>
                                    <tr>
                                        <th hidden>Id</th>
                                        <th>Name</th>
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
                                        echo "<td data-th='Id.' hidden><div>" . $user[$i]->id. "</div></td>";
                                        echo "<td data-th='Name'><div>" . $user[$i]->fname." ".$user[$i]->lname . "</div></td>";
                                        echo "<td data-th='Email'><div>" . $user[$i]->email. "</div></td>";
                                        echo "<td data-th='Telephone'><div>" . $user[$i]->mobile_no. "</div></td>";
                                        echo "<td data-th='Status'><div>" . $user[$i]->status. "</div></td>";
                                        ?>
                                        <td data-th="Actions">
                                            <div>
                                                 <a href="add_employee/<?php echo $user[$i]->id; ?>" class="btn btn-default btn-xs action-btn" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></a> 
                                                <a href="delete_employee/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs action-btn" rel="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                            </div>
                                      </td>
                                        <?php
                                        //echo "<td>";
                                        //echo anchor('home/add_employee/'.$user[$i]->id, '<i class="icon-pencil"></i>', array("title"=>'Edit Employee','class'=>"btn btn-default btn-small",'title'=>'Edit Employee'));
                                       // echo anchor('home/delete_employee/'.$user[$i]->id, '<i class="icon-trash"></i>', array('onClick' => "return confirm('Are you sure want to delete this record?')",'class'=>"btn btn-default btn-small",'title'=>'Delete Employee'));
                                       // echo "</td>";
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



