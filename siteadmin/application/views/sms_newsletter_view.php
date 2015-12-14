<?php
	$id = $this->uri->segment(3);
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
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
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
						<li>
							<?php echo anchor('home', 'Home', "title='Home'"); ?>
							<span class="divider">/</span>
						</li>
						<li>
							<span style="color:#08c">SMS Newsletter</span>
						</li>
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
				<div class="span12">
					<section id="formElement" class="utopia-widget utopia-form-box section">
						<div class="utopia-widget-title">
						<span>
						    SMS Newsletter
						</span>
						</div>
						<div class="row-fluid">
							<div class="utopia-widget-content">
								<div class="span6 utopia-form-freeSpace">
									<?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
									<fieldset>
										<div class="control-group">
											<label class="control-label" for="">User List :	</label>
											<div class="controls">
												<?php
													$user_list = $this->config->item("user_list");
													$device = 'id="user_list" style="width: 255px"';
													echo form_dropdown('user_list', $user_list, "1",  $device);
												?>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="">Send From :	</label>
											<div class="controls">
												<?php
													$sendFrom = array(
														'name' => 'sendFrom',
														'id' => 'sendFrom',
														//'value' => set_value('fname', $fname),
														'size' => '30',
														'class' => 'span10',
													);
													echo form_input($sendFrom);
												?>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="">Send To :	</label>
											<div class="controls">
												<?php
													$sendTo = array(
														'name' => 'sendTo',
														'id' => 'sendTo',
														//'value' => set_value('fname', $fname),
														'size' => '30',
														'class' => 'span10',
													);
													echo form_input($sendTo);
												?>
												<span style="margin-left:127px;">(for example: 97888555)</span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="">SMS :	</label>
											<div class="controls">
												<?php
													$smsText = array(
														'name' => 'smsText',
														'id' => 'smsText',
														//'value' => set_value('fname', $fname),
														'size' => '30',
														'class' => 'span10',
													);
													echo form_textarea($smsText);
												?>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for=""></label>
											<div class="controls">
												<?php echo form_submit('submit', 'Send SMS', "class='btn span5'"); ?>
											</div>
										</div>
									</fieldset>
									</form>
								</div>
								<div class="span6 utopia-form-freeSpace"></div>
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

<script type="text/javascript">

</script>