<?php //echo'<pre>';print_r($data);exit;  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <title>Monopolion</title>
    </head>
    <body bgcolor="#f0f3f4" style="margin:0; padding:0; font-family:Arial, Helvetica, sans-serif;font-size:12px; color:#000;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f0f3f4">
            <tr>
                <td>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:600px; margin-top:20px; display:block;">
                        <!--Email header start-->
                        <tbody>
                        <tr>
                            <td height="40" align="left" valign="top" bgcolor="#ffffff" style="border-bottom: solid 1px #eeeeee;">
                                <img src="<?php echo base_url(); ?>img/cmr.png" height="24" alt="Monopolion" style="padding-top:8px; padding-left:8px; border:0;" alt=""/>
                            </td>
                        </tr>
                        <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#ffffff"></td>
                        </tr>
                        <!--Email header end-->





                         <!--Email body start-->
                        <tr>
                            <td align="center" valign="top" bgcolor="#FFFFFF"><table width="94%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px;">
                                            <p style="margin: 0px; width:600px;" >Dear <b><?php echo $customer_name;?></b>,</p>
                                            <!-- <p>Your inquiry for <?php echo $bedroom; ?>Bathrooms <?php echo $property_category; ?>for <?php if($property_type ==1){ echo "Sale"; }else if($property_type ==2){ echo "Rent"; }elseif($property_type ==3) { echo "Sale/Rent"; }else{ echo "- ";}?> and check below link for more details,</p>  -->
                                            <p>Thank you for contacting us!</p>    
                                            <p>Following we attach link for property as per your requirements:<p>
                                            <?php
                                            if (!empty($property_title))
                                            {
                                                foreach ($property_title as $key => $value) 
                                                {
                                                     $property_title[$key] = $value;
                                                }   
                                            }
                                            if (!empty($property_link_url))
                                            {
                                                foreach ($property_link_url as $key => $value) 
                                                {
                                                     $property_link_url[$key] = $value;
                                                }   
                                            }
                                            if(!empty($property_links))
                                            {
                                                foreach ($property_links as $key => $value) {
                                                ?>
                                                        <p><?php echo "Reference No :".$property_title[$key]; ?></p>
                                                    <?php if(!empty($property_link_url[$key]) && trim($property_link_url[$key]) !=""){ ?>
                                                        <a href="<?php echo $property_link_url[$key]; ?>"><?php echo $property_link_url[$key]; ?></a><br>
                                                    <?php }else{ ?>
                                                        <a href="<?php echo $value; ?>"><?php echo $value; ?></a><br>
                                                    <?php }
                                                }
                                            }
                                            ?>
                                            <p>For any further information please call: 8000 7000</p>
                                            <p>Thanks & Regards</p>
                                            <p>Monopolion Team</p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" height="30">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left" height="50">&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <!--Email body end-->


                        <!--Email footer Start-->
                        <tr>
                            <td align="left" bgcolor="#f6f8f8" style="border-bottom:solid 1px #fff; padding:10px 15px; line-height:16px; font-family:Arial, Helvetica, sans-serif; font-size:11px;">

                                <div style="padding-bottom: 5px;">For help, please send an email to <a href="#" style="color:#f8941e; text-decoration:none;">info@monopolion.com</a>.</div>
                                <a href="#" style="color:#f8941e;  text-decoration:none;"><!-- Terms and Conditions --></a><!--  |  --><a href="#" style="color:#f8941e; text-decoration:none;" ><!-- Privacy Policy --></a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" height="26" bgcolor="#dddddd" style="color:#333333; font-family:Arial, Helvetica, sans-serif;">
                                <p style="margin: 0px; line-height: 26px; font-size: 11px;" >Copyright &copy; 2015 Monopolion, Inc., All rights reserved.</p>
                            </td>
                        </tr>
                        <!--Email footer end-->
                    </tbody>
                    </table>

                </td>
            </tr>
        </table>
    </body>
</html>