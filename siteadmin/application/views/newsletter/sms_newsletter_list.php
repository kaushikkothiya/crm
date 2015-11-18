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
    <?php } else if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php } ?>
    <div class="row">
      <div class="main">
        <h1 class="page-header">SMS Newsletter
          <button class="btn btn-sm btn-success pull-right" type="button" onClick="window.location.href = 'smsnewsletter';">Add New</button>
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
                                        <th><a href="#receivers" data-id>Receivers</a></th>
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
                                                <td data-th='Receivers'><div><a href="#receivers" class="show-receivers" data-id="<?php echo $value->id; ?>">Receivers</a></div></td>
                                                <td data-th='Created'><div><?php echo date("m/d/Y", strtotime($value->created)); ?></div></td>
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
        <div class="row sms_receivers">
                <div class="col-sm-12"><section>
                        <div class="heddidng">
                            <span>SMS Newsletter - Receivers of <label id="sms_newsletter_name"></label> </span>
                        </div>
                        <div>
                            <table class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: left">First Name</th>
                                        <th style="text-align: left">Last Name</th>
                                        <th style="text-align: left">Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </body>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
    </div>
<?php
$this->load->view('footer');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".sms_receivers").hide();
        $(".show-receivers").on('click', function () {
            var id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url(); ?>newsletter/ajax_get_receivers',
                data: {id: id},
                dataType:'json'
            }).done(function (data) {
                if (data.length > 0) {
                    $(".sms_receivers tbody").empty();
                    var html = [];
                    for (var i = 0; i < data.length; i++) {
                        if($.isArray(data[i])){
                            html.push("<tr><td>"+data[i][2]+"</td><td>"+data[i][3]+"</td><td>"+data[i][0]+"</td></tr>");
                        }else{
                            html.push("<tr><td>"+data[2]+"</td><td>"+data[3]+"</td><td>"+data[0]+"</td></tr>");
                            break;
                        }
                    }
                    $(".sms_receivers tbody").html(html.join(''));
                    $(".sms_receivers").show();
                } else {
                    alert("No receivers found!");
                }

            });
        });
    });
</script>