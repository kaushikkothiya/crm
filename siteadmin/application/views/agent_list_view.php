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
        <h1 class="page-header">Agent List
          <button class="btn btn-sm btn-success pull-right" type="button" onClick="window.location.href = 'add_agent';">Create Agent</button>
        </h1>
        <div class="row">   
          <div class="col-sm-12">
                    <div>
                        <table id="example">
                            <thead>
                                <tr>
                                    <th hidden>id</th>
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
                                        echo "<td data-th='id.' hidden><div>" . $user[$i]->id. "</div></td>";
                                        echo "<td data-th='Name'><div>" . $user[$i]->fname." ".$user[$i]->lname . "</div></td>";
                                        echo "<td data-th='Email'><div>" . $user[$i]->email. "</div></td>";
                                        echo "<td data-th='Telephone'>" . $user[$i]->mobile_no. "</div></td>";
                                        echo "<td data-th='Status'><div>" . $user[$i]->status. "</div></td>";
                                        ?>
                                        <td data-th="Actions">
                                            <div>
                                                <a href="add_agent/<?php echo $user[$i]->id; ?>" class="btn btn-info btn-xs">Edit</a> 
                                                &nbsp;<a href="delete_agent/<?php echo $user[$i]->id; ?>" onclick="return confirm('Are you sure want to delete this record?');" class="btn btn-danger btn-xs">Delete</a>
                                            </div>
                                        </td>
                                        <?php
                                        //echo '<td>';
                                        //echo anchor('home/add_agent/'.$user[$i]->id, '<i class="icon-pencil"></i>', array('title'=>'Edit agent','class'=>'btn btn-default btn-small'));
                                        //echo anchor('home/delete_agent/'.$user[$i]->id, '<i class="icon-trash"></i>', array('onclick' => "return confirm('Are you sure want to delete this record?')",'class'=>'btn btn-default btn-small','title'=>'Delete Agent'));
                                        //echo '</td>';
                                        echo '</tr>';

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



