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
                        <li><?php echo anchor('newsletter/sms_newsletter_list', 'SMS Newsletter', "title='SMS Newsletter'"); ?>
                            <span class="divider">
                            </span></li>
                        <li style="float:right;"><a href="<?php echo base_url(); ?>newsletter/smsnewsletter"><input type="button" value="Add New" /></a></li>
                    </ul>
                </div>
            </div>
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
            <div class="row-fluid">
                <div class="span12"><section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <span>SMS Newsletter </span>
                        </div>
                        <div class="utopia-widget-content">
                            <table id="example" class="display" cellspacing="0" width="100%">
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
                                                <td hidden><?php echo $value->id; ?></td>
                                                <td><?php echo $value->title; ?></td>
                                                <td><?php echo $value->content; ?></td>
                                                <td><a href="#receivers" class="show-receivers" data-id="<?php echo $value->id; ?>">Receivers</a></td>
                                                <td><?php echo date("m/d/Y", strtotime($value->created)); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>   
                    </section>
                </div>
            </div>
            <div class="row-fluid sms_receivers">
                <div class="span12"><section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <span>SMS Newsletter - Receivers of <label id="sms_newsletter_name"></label> </span>
                        </div>
                        <div class="utopia-widget-content">
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
                    </section></div>
            </div>
        </div>
    </div>
</div>
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
<?php
$this->load->view('footer');
?>



