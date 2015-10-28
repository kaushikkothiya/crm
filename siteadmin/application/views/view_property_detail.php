<?php

$this->load->view('header');

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />

</head>

<body>
<div class="wrapper">
	<div class="header">
		<div class="logo"><img src="<?php echo base_url(); ?>img/cmr.png" /></div>
		<div class="clear"></div>
	</div>
	<style>
	.imageBox{
				width:100px;height:100px;float:left;
				margin:0px 7px 7px 0px;vertical-align:middle;
				display:inline-block;position:relative;
			}
	</style>
	
	
	<div class="formmain">
		<div class="title"><?php if(!empty($data[0]->bathroom)){echo $data[0]->bathroom;}else{ echo "-"; } ?> Bedroom <?php  if(!empty($property_type)){echo $property_type; }else{ echo "-";} ?> for <?php if($data[0]->type ==1){ echo "Sale"; }else if($data[0]->type ==2){ echo "Rent"; }elseif($data[0]->type ==3) { echo "Sale/Rent"; }else{ echo "";} ?></div>
		<div class="frmpadd">
			<?php if(!empty($data[0]->image)){ ?>
			<div class="fldimg"><img src="<?php echo base_url().'upload/property/100x100/'.$data[0]->image; ?>" /></div>
			<?php }else{ ?>
			<div class="fldimg"><img src="<?php echo base_url().'upload/property/100x100/noimage.jpg'; ?>" /></div>
			<?php } ?>
			
			<div class="fldimg-txt">
				<?php if(!empty($data[0]->CityTitle)){ ?>	
					<div class="lable">City:</div>
					<div class="data"><?php echo $data[0]->CityTitle; ?></div>
				<?php } ?>
				
				<?php if(!empty($data[0]->CityareaTitle)){ ?>	
					<div class="lable">City area:</div>
					<div class="data"><?php echo $data[0]->CityareaTitle; ?></div>
				<?php } ?>
				
			</div>

			<div class="fldimg-txt1">
				<?php if(!empty($data[0]->reference_no)){ ?>	
					<div class="lable">Reference number:</div>
					<div class="data"><?php echo $data[0]->reference_no ; ?></div>
				<?php } ?>

				<?php if(!empty($data[0]->type)){ ?>	
					<div class="lable">Type:</div>
					<div class="data sep"><?php if($data[0]->type ==1){ echo "Sale"; }else if($data[0]->type ==2){ echo "Rent"; }else { echo "Sale/Rent"; } ?></div>
				<?php } ?>
				
				<?php if(!empty($data[0]->address)){ ?>	
					<div class="lable">Address:</div>
					<div class="data"><?php echo $data[0]->address; ?></div>
				<?php } ?>
			</div>

			<div class="clear"></div>
			<?php if(!empty($image)){ ?>
				<div class="description">
					<div class="lable">Extra images:</div>
					<div class="data">
						<?php
						foreach ($image as $key => $value)
						{ ?>
							<div class="thumbnail imageBox image">
							    <img src='<?php echo base_url() ?>upload/property/100x100/<?php echo $value->image_name ?>'>
				            </div>
							<?php
						}
					?>
					<div class="clear"></div>
					</div>
				</div> 
			<?php } ?>

			<?php if(!empty($genral_facilities)){ ?>
			<div class="clear"></div>
			<div class="description">
				<div class="lable">Property Facilities Indoor:</div>
				<div class="data">
					<?php 
					foreach ($genral_facilities as $key => $value)
					{
						//echo '<span style="width:100px;height:100px;padding:30px 0px;margin:0px 5px 20px 0px;border:1px solid #ccc"><img src='.base_url().'upload/property/100x100/'.$value->image_name.' style="padding:5px"></span>';
					echo $value->title;?> <br><?php
					}
				?>
				</div>
			</div>
			<?php } ?>

			<?php if(!empty($instrumental_facilities)){ ?>
			<div class="clear"></div>
			<div class="description">
				<div class="lable">Other Faciliies:</div>
				<div class="data">
					<?php 
					foreach ($instrumental_facilities as $key => $value)
					{
						//echo '<span style="width:100px;height:100px;padding:30px 0px;margin:0px 5px 20px 0px;border:1px solid #ccc"><img src='.base_url().'upload/property/100x100/'.$value->image_name.' style="padding:5px"></span>';
					echo $value->title; ?> <br><?php
					}
				?>
				</div>
			</div>
			<?php } ?>

			<?php if(!empty($data[0]->short_decs)){ ?>
			<div class="clear"></div>
			<div class="description">
				<div class="lable">Property Description:</div>
				<div class="data"><?php echo $data[0]->short_decs; ?></div>
			</div>
			<?php } ?>
			<div class="clear"></div>
			<div class="leftpart">
				<?php if($data[0]->sale_price !='0'){ ?>
				 <div class="fild">
					<div class="lable">Selling Price (€):</div>
					<div class="data"><?php if($data[0]->sale_price !='0' ){echo $data[0]->sale_price;}else{ echo ""; } ?></br><?php if($data[0]->rent_val =='0'){ echo " No V.A.T ";}else{ echo "Plus V.A.T";}?></div>
				</div> 
				<?php } ?>
				<?php if($data[0]->rent_price !='0'){ ?>
				<div class="fild">
					<div class="lable">Rental Price (€):</div>
					<div class="data"><?php if($data[0]->rent_price !='0' ){ echo $data[0]->rent_price;}else{ echo "";} ?></br><?php if($data[0]->rent_val =='0'){ echo "incl. common expenses";}else{ echo "Plus common expenses";}?></div>
				</div> 
				<?php } ?>
				<?php if(!empty($data[0]->bedroom)){ ?>
				<div class="fild">
					<div class="lable">Bedroom:</div>
					<div class="data"><?php echo $data[0]->bedroom; ?></div>
				</div>
				<?php } ?>
				<?php if(!empty($data[0]->bathroom)){ ?>
				<div class="fild">
					<div class="lable">Bathroom:</div>
					<div class="data"><?php echo $data[0]->bathroom; ?></div>
				</div>
				<?php } ?>
				
				<?php if(!empty($architectural_design)){ ?>
				<div class="fild">
					<div class="lable">Architectural Design:</div>
					<div class="data"><?php echo $architectural_design; ?></div>
				</div> 
				<?php } ?>
				<div class="fild">
					<div class="lable">From Playground:</div>
					<div class="data"><?php echo $data[0]->from_playground; ?></div>
				</div> 
				<div class="fild">
					<div class="lable">From Sea:</div>
					<div class="data"><?php echo $data[0]->from_sea; ?></div>
				</div> 
				<div class="fild">
					<div class="lable">From Cafeteria:</div>
					<div class="data"><?php echo $data[0]->from_cafeteria; ?></div>
				</div> 
				<div class="fild">
					<div class="lable">From Restaurent:</div>
					<div class="data"><?php echo $data[0]->from_restaurent; ?></div>
				</div> 
			</div>
			
			<div class="rightpart">
					<?php if($data[0]->cover_area !='0' && !empty($data[0]->cover_area)){ ?>
				<div class="fild">
					<div class="lable">Cover Area (m²):</div>
					<div class="data"><?php echo $data[0]->cover_area; ?></div>
				</div>
				<?php } ?>
				<?php if($data[0]->uncover_area !='0' && !empty($data[0]->uncover_area)){ ?>
				<div class="fild">
					<div class="lable">Uncover Area (m²):</div>
					<div class="data"><?php echo $data[0]->uncover_area; ?></div>
				</div>
				<?php } ?>
				<?php if($data[0]->plot_lan_area !='0' && !empty($data[0]->plot_lan_area)){ ?>
				<div class="fild">
					<div class="lable">Plot/land Area (m²):</div>
					<div class="data"><?php echo $data[0]->plot_lan_area; ?></div>
				</div>
				<?php } ?>
				<?php if(!empty($data[0]->kitchen)){ ?>
				<div class="fild">
					<div class="lable">Kitchen:</div>
					<div class="data"><?php echo $data[0]->kitchen; ?></div>
				</div>
				<?php } ?>
				<?php if(!empty($room_size)){ ?>
				<div class="fild">
					<div class="lable">Room Size:</div>
					<div class="data"><?php echo $room_size; ?></div>
				</div>
				<?php } ?>
			
				<div class="fild">
					<div class="lable">From Supermarket:</div>
					<div class="data"><?php echo $data[0]->from_supermarket; ?></div>
				</div>
				<div class="fild">
					<div class="lable">From Bus Station:</div>
					<div class="data"><?php echo $data[0]->from_bus_station; ?></div>
				</div>
				<div class="fild">
					<div class="lable">From School:</div>
					<div class="data"><?php echo $data[0]->from_school; ?></div>
				</div>
				<div class="fild">
					<div class="lable">From Highway:</div>
					<div class="data"><?php echo $data[0]->from_high_way; ?></div>
				</div>
			
			</div>
		<div class="clear"></div>
	</div>
	<br /><br />
	
</div>
</body>
</html>