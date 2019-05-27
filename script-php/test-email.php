<?php
$to = 'infoofajit@gmail.com';
$subject = 'Order confirmation email';

$headers = "From: ajit.singh@ampliedtech.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = '
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <title> </title>
    <!--[if !mso]><!-- -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
      #outlook a {
      padding: 0;
      }
      .ReadMsgBody {
      width: 100%;
      }
      .ExternalClass {
      width: 100%;
      }
      .ExternalClass * {
      line-height: 100%;
      }
      body {
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      }
      table,
      td {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
      }
      img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
      }
      p {
      display: block;
      margin: 13px 0;
      }
    </style>
    <!--[if !mso]><!-->
    <style type="text/css">
      @media only screen and (max-width:480px) {
      @-ms-viewport {
      width: 320px;
      }
      @viewport {
      width: 320px;
      }
      }
    </style>
    <!--<![endif]-->
    <!--[if mso]>
    <xml>
      <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if lte mso 11]>
    <style type="text/css">
      .outlook-group-fix { width:100% !important; }
    </style>
    <![endif]-->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
      @import url(https://fonts.googleapis.com/css?family=Lato:300,400,500,700);
    </style>
    <!--<![endif]-->
    <style type="text/css">
      .thanks-text {
         padding: 0px 25px;
      }
      .text-center {
        text-align: center !important;
      }
      @media only screen and (min-width:480px) {
       .thanks-text {
        padding:18px 0px
      } 
      .mj-column-per-33 {
      width: 33.333333333333336% !important;
      max-width: 33.333333333333336%;
      }
      .mj-column-per-66 {
      width: 66% !important;
      max-width: 66%;
      }
      .mj-column-per-100 {
      width: 100% !important;
      max-width: 100%;
      }
      .mj-column-per-40 {
      width: 40% !important;
      max-width: 40%;
      }
      .mj-column-per-60 {
      width: 60% !important;
      max-width: 60%;
      }
      }
    </style>
    <style type="text/css">
      @media only screen and (max-width:480px) {
      table.full-width-mobile {
      width: 100% !important;
      }
      td.full-width-mobile {
      width: auto !important;
      }
      }
    </style>
  </head>
  <body style="background-color:#ffffff;">
    <div style="background-color:#ffffff;">
      <!--[if mso | IE]>
      <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
        >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
            <![endif]-->
            <div style="background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#F5F5DC;background-color:#ffffff;width:100%;">
                <tbody>
                  <tr>
                    <td style="direction:ltr;font-size:0px;padding:0px;padding-top:0px;text-align:center;vertical-align:top;">
                      <!--[if mso | IE]>
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td
                            class="" style="vertical-align:top;width:600px;"
                            >
                            <![endif]-->
                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
                                        <tr>
                                          <td align="left" style="font-size:0px;padding:10px 0;word-break:break-word;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                                              <tbody>
                                                <tr>
                                                  <td style="width:200px;"> <img alt="logo" height="auto" src="http://admin-dev.dastjar.com/images/cmarkplatf.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;" width="200"> </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if mso | IE]>
                          </td>
                        </tr>
                      </table>
                      <![endif]-->
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
        >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
            <![endif]-->
            <div style="background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                  <tr>
                    <td style="direction:ltr;font-size:0px;padding:10px 0;text-align:center;vertical-align:top;">
                      <!--[if mso | IE]>
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td
                            class="" style="vertical-align:top;width:198px;"
                            >
                            <![endif]-->
                            <div class="mj-column-per-40 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
                                        <tr>
                                          <td align="center" vertical-align="top" style="font-size:0px;padding:20px 25px;word-break:break-word;">
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:12px;line-height:1;text-align:left;color:#444444;">
                                              <div>
                                                Invoice No.: #xxxxxx-xxx
                                              </div>
                                              <div>
                                                Organization Number: #xxxxxx-xxx
                                              </div>
                                              <div>
                                                <p>
                                                  Bill to Address:<br>
                                                  ATTN: Kent Bogestam<br>
                                                  Hagersten 175,<br>
                                                  Stockholm, Stockholm, 12543, SE
                                                </p>
                                              </div>
                                            </div>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if mso | IE]>
                          </td>
                          <td
                            class="" style="vertical-align:top;width:396px;"
                            >
                            <![endif]-->
                            <div class="mj-column-per-60 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
                                        <tr>
                                          <td align="left" class="thanks-text" style="font-size:0px;word-break:break-word;">
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:16px;text-align:left;color:#222222;">Thank you for your order</div>
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;text-align:left;color:#222222;">This is an order confirmation for your knowledge</div>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if mso | IE]>
                          </td>
                        </tr>
                      </table>
                      <![endif]-->
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
        >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
            <![endif]-->
            <div style="background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                  <tr>
                    <td style="font-family:Lato, Helvetica, Arial, sans-serif;font-size: 16px;line-height:1;color:#222222;">Following plan have been subscribed for T2 Restaurant</td>
                  </tr>
                  <tr>
                    <td style="direction:ltr;font-size:0px;padding:0px;padding-top:5px;text-align:center;vertical-align:top;">
                      <!--[if mso | IE]>
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td
                            class="" style="vertical-align:top;width:600px;"
                            >
                            <![endif]-->
                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%">
                                        <tr>
                                          <td align="left" vertical-align="top" style="padding:5px 10px;background-color: #F0F8FF;">
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;">
                                              <strong>Summary</strong>
                                            </div>
                                          </td>
                                          <td align="right" style="padding: 5px 10px;background-color: #F0F8FF;"></td>
                                        </tr>
                                        <tr>
                                          <td align="left" vertical-align="top" style="padding:5px 15px;">
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;">
                                              1. Dastjar Base Package
                                            </div>
                                          </td>
                                          <td align="right" style="padding: 5px 15px;">$56.41</td>
                                        </tr>
                                        <tr>
                                          <td align="left" vertical-align="top" style="padding:5px 15px;">
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;">
                                              1. Dastjar Base Package
                                            </div>
                                          </td>
                                          <td align="right" style="padding: 5px 15px;">$56.41</td>
                                        </tr>
                                        <tr>
                                          <td align="left" vertical-align="top" style="padding:5px 15px;">
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;">
                                              1. Dastjar Base Package
                                            </div>
                                          </td>
                                          <td align="right" style="padding: 5px 15px;">$56.41</td>
                                        </tr>
                                        <tr>
                                          <td align="left" vertical-align="top" style="padding:5px 10px; background-color:#CCCD99;">
                                            <div style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;">
                                              Total
                                            </div>
                                          </td>
                                          <td align="right" style="padding:5px 10px;background-color: #CCCD99;">$100.41</td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if mso | IE]>
                          </td>
                        </tr>
                      </table>
                      <![endif]-->
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
        >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
            <![endif]-->
            <div style="background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                  <tr>
                    <td style="direction:ltr;font-size:0px;padding:50px 0;text-align:center;vertical-align:top;">
                      <!--[if mso | IE]>
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td
                            class="" style="vertical-align:top;width:200px;"
                            >
                            <![endif]-->
                            <div class="mj-column-per-33 outlook-group-fix text-center" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;padding-bottom: 10px;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="vertical-align:top;padding:0px; font-family:Lato, Helvetica, Arial, sans-serif;">
                                      <span style="font-size: 16px;word-break:break-word;">Service Provider Dastjar AB</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if mso | IE]>
                          </td>
                          <td
                            class="" style="vertical-align:top;width:200px;"
                            >
                            <![endif]-->
                            <div class="mj-column-per-33 outlook-group-fix text-center" style="font-size:11px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;padding-bottom: 10px;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="vertical-align:top;padding:0px;font-family:Lato, Helvetica, Arial, sans-serif;">
                                      info@dastjar.com <br>
                                      +46 76 0067125 <br>
                                      We always answer your questions.
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if mso | IE]>
                          </td>
                          <td
                            class="" style="vertical-align:top;width:200px;"
                            >
                            <![endif]-->
                            <div class="mj-column-per-33 outlook-group-fix text-center" style="font-size:11px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;padding-bottom: 10px;">
                              <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="vertical-align:top;padding:0px;font-family:Lato, Helvetica, Arial, sans-serif;">
                                      Corporation Number xxx-xxx-xxxx
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if mso | IE]>
                          </td>
                        </tr>
                      </table>
                      <![endif]-->
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <![endif]-->
    </div>
  </body>
</html>';


mail($to, $subject, $message, $headers);
?>