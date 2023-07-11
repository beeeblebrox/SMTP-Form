# SMTP-Form
 Simple SMPT form based PHPMailer

## How to use
  Open *mail/send.php* and set it up:

1. **Email title**

  `$title = "Message from ...";`


2. **Sender settings:**

  `$mail->Host       = 'smtp.gmail.com';`

  `$mail->Username   = 'USERNAME@gmail.com';`

  `$mail->Password   = 'PASSWORD';`

  `$mail->setFrom('USERNAME@gmail.com', 'Message from ...');`

3. **Add recipients:**

  `$mail->addAddress('USERNAME@gmail.com');`

## Show errors

  Open *mail/send.php* and uncomment this:

  `$mail->SMTPDebug = 2;`