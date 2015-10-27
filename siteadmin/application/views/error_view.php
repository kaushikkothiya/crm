<?php

$this->load->view('header');

$session_data = $this->session->userdata('logged_in_user');

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



<div class="span12"><section class="utopia-widget">



<div class="utopia-widget-title">

<span>Error!

</span>

</div>



<div class="utopia-widget-content">

<p>You are looking for <strong>Wrong</strong> Information.. <br/>Please check again..</p>

</div></section>

</div>

</div>

</div>

</div>

</div>



<?php

$this->load->view('footer');

?>

