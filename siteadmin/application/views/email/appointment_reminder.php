<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Monopolion</title>
    </head>
    <body bgcolor="#f0f3f4" style="margin:0; padding:0; font-family:Arial, Helvetica, sans-serif;font-size:12px; color:#000;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f0f3f4">
            <tr>
                <td>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px; display:block; max-width: 600px">
                        <!--Email header start-->
                        <tbody>
                            <tr>
                                <td height="70" align="left" valign="top" bgcolor="#ffffff" style="border-bottom: solid 1px #eeeeee;">
                                    <img src="<?php echo base_url(); ?>img/cmr.png" height="70" alt="Monopolion" style="padding-top:8px; padding-left:8px; border:0;" alt="" />
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
                                        <?php if(isset($agent) && !empty($agent)){ ?>
                                            <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px;">
                                            <p style="margin: 0px;" >REMINDER: Dear <b><?php echo $agent['agent_name'];?></b>,</p>
                                            <p>You have an appointment in 1 hour at the property with Reference No :<?php echo $agent['property_ref_no']; ?>, Inquiry from: <?php echo $agent['customer_name'].', Mobile Number: +'.$agent['customer_mobile']; ?> Please be on time!</p>
                                            <p>Thanks & Regards</p>
                                            <p>Monopolion Team</p>
                                          </td>   
                                        <?php }elseif (isset($customer) && !empty($customer)) { ?>
                                            <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px;">
                                            <p style="margin: 0px;" >REMINDER: Dear <b><?php echo $customer['customer_name'];?></b>,</p>
                                            <p>You have an appointment in 1 hour at the property with Reference No :<?php echo $customer['property_ref_no']; ?>, with our Agent:  <?php echo $customer['agent_name'].', Mobile Number: +'.$customer['agent_mobile']; ?> or 8000 7000</p>
                                            <p>Thanks & Regards</p>
                                            <p>Monopolion Team</p>
                                        <?php } ?>
                                            </td>
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
                                <a href="#" style="color:#f8941e;  text-decoration:none;"><!-- Terms and Conditions --></a><!--  | --> <a href="#" style="color:#f8941e; text-decoration:none;" ><!-- Privacy Policy --></a>
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