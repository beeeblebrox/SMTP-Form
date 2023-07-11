<?php
// phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// vars
$method = $_SERVER['REQUEST_METHOD'];

foreach ( $_POST as $key => $value ) {
  if ( $value != "" ) {
    $body .= '<tr><td>'. $key .':</td><td>' . $value . '</td></tr>';
  }
}

// message
$title = "Message from ...";
$body = '
<!--[if (gte mso 9)|(IE)]>
<table width="600" align="center"><tr><td style="padding-top:0; padding-bottom:0; padding-right:0; padding-left:0; margin:0px;">
<![endif]-->
<table align="center" cellspacing="0" cellpadding="5" border="2" bordercolor="#a8a8a8" style="width: 100%; max-width: 600px;">' . $body . '
</table>
<!--[if (gte mso 9)|(IE)]>
</td></tr></table><![endif]-->
';

// settings
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
  $mail->isSMTP();   
  $mail->CharSet = "UTF-8";
  $mail->SMTPAuth   = true;
  // $mail->SMTPDebug = 2; // show error
  $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};
  
  // account
  $mail->Host       = 'smtp.gmail.com'; // SMTP host (smtp.mail.ru, smtp.yandex.ru) 
  $mail->Username   = 'USERNAME@gmail.com'; // login
  $mail->Password   = 'PASSWORD'; // password
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;
  $mail->setFrom('USERNAME@gmail.com', 'Message from ...'); // sender
  
  // recipients
  $mail->addAddress('USERNAME@gmail.com');  
  // $mail->addAddress('USERNAME@gmail.com'); another one
  
  // attachment
  if (!empty($file['name'][0])) {
    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
      $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
      $filename = $file['name'][$ct];
      if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
        $mail->addAttachment($uploadfile, $filename);
        $rfile[] = "File $filename attached";
      } else {
        $rfile[] = "Failed to attach file $filename";
      }
    }   
  }

  // send
  $mail->isHTML(true);
  $mail->Subject = $title;
  $mail->Body = $body;    
  
  if ($mail->send()) {$result = "success";} 
  else {$result = "error";}
  
} catch (Exception $e) {
  $result = "error";
  $status = "Message was not sent. Error: {$mail->ErrorInfo}";
}

echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);