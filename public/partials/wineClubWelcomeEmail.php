<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo esc_attr($membershipLevel->emailTitle) ?></title>
<style type="text/css">
body { width: 100%; background-color: #e9e9e9; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; font-family: Arial }
table { border-collapse: collapse; }

@media only screen and (max-width: 640px) {
body[yahoo] .deviceWidth { width: 440px!important; padding: 0; }
body[yahoo] .center { text-align: center!important; }
}

@media only screen and (max-width: 479px) {
body[yahoo] .deviceWidth { width: 280px!important; padding: 0; }
body[yahoo] .center { text-align: center!important; }
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family:Arial; background: #e9e9e9;">
<!-- Wrapper -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
  <tr>
    <td width="100%" valign="top" bgcolor="#e9e9e9"><!-- Start Header-->
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td bgcolor="#777990" style="padding-top: 10px;"><table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
              <tr>
                <td width="100%" bgcolor="#fff"><!-- Logo -->
                  
                  <table border="0" cellpadding="0" cellspacing="0" align="center" style="padding:5px 0;">
                    <tr>
                      <td style="padding:10px 20px 10px;" colspan="2" class="center"><a href="#" style="display: block;"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'admin/images/wineclubconnection.png'; ?>" alt="wine club connection" border="0" /></a></td>
                    </tr>
                  </table>                  
                  <!-- End Logo --> 
                  <!-- Nav -->                  
                  <!-- End Nav --></td>
              </tr>
            </table></td>
        </tr>
        <!-- End Header --> 
        
        <!-- One Column -->
      </table>

      <table width="600"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#eeeeed">
          <tr>
    <td style="border-top: solid 2px #6f496f;">
      <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'admin/images/logo.png'; ?>" alt="wine logo" width="100%" border="0" style="vertical-align: top;" /> 
    </td>
  </tr>
        <td>
   <table class="row" width="600" bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; text-align:left; border-spacing:0; max-width:100%;">
        <tbody>
          <tr>
          <td  class="title" colspan="2" style="padding-top: 10px;
    border-top: 1px dotted #dddddd; padding-right: 30px; padding-bottom: 10px;
    padding-left: 30px; font-size: 22px; line-height: 30px; color: #fff; font-weight: 400;
    text-align: center;background: #c78105;"><?php echo esc_attr($membershipLevel->emailTitle) ?></td>
        </tr>
        <tr>
         
        </tr>
      </tbody></table> 
  </td>  
  </tr>

        <tr>
          <td valign="top" style="padding:0" bgcolor="#ffffff"></td>
        </tr>
        <tr>
          <td style="font-size: 13px; color: #333; border-top:1px dotted #dddddd; font-weight: normal; text-align: left; font-family:Arial; line-height: 24px; vertical-align: top; padding:20px 20px 20px" bgcolor="#fff"><table>
            </table>
            <p style="color:#666;font-size:15px; text-align: center; margin-top: 0;"> <?php echo esc_textarea($membershipLevel->emailText) ?></p>
            <br />
            <br />
            </td>
        </tr>
        <tr>
        <td style=" background:#f4f4f4;font-size: 13px; padding:20px;">
    <table width="100%">
                <tbody><tr>
                  <td style="width:80%"></td>
                    <td valign="top" align="left">
                      <p style="color: #413e3e;font-size: 18px;
    margin-top: 0;margin: 0; padding: 0 0 8px 0;"><strong><?php _e('Thank you!'); ?></strong></p> 
                      <p style="color: #666; text-align: left;padding: 0 5px 0;
    margin: 0; font-size: 15px;"><strong><?php _e('Wine Club Connection'); ?></strong> <br><a href="#" style="display: inline-block;
    text-decoration: none;
    padding: 8px 0 0;color: #666;">707 293 3731</a></p>
                    </td>
                </tr>
     </tbody></table>
        </td>
        </tr>
      </table>
      
      <!-- End One Column --> 
      
      <!-- 4 Columns -->
    
      <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="margin-top: 30px;">
        <tr>
          <td bgcolor="#777990" style="padding:10px 0 10px"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
              <tr>
                <td><table width="100%" cellpadding="0" cellspacing="0"  border="0" align="left" class="deviceWidth">
                    <tr>
                      <td valign="top" style="font-size: 12px; color: #fff;font-family: Arial; padding-bottom:0px;text-align:center" class="center"><?php _e('Copyright 2019 © Wine Club Connection, All Rights Reserved'); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table> 
      
      <!-- End 4 Columns --></td>
  </tr>
</table>
<!-- End Wrapper -->

</body>
</html>
