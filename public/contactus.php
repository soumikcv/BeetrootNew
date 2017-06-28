<?php
session_start();

require 'PHPMailer-master/PHPMailerAutoload.php';

$errors = false;
$success = false;

if ($_POST['name'] != "") {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
} else {
    $errors = "error";
}

if ($_POST['email'] != "") {
    $from = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
} else {

    $errors = "error";
}

if ($_POST['mobile'] != "") {
    $contact = filter_var($_POST['mobile'], FILTER_SANITIZE_STRING);
} else {
    $errors = "error";
}
if ($_POST['content'] != "") {
    //$msg1 = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    //$message= utf8_encode($msg1);
} else {
    $errors = "error";
}
$captcha = filter_var($_POST['captcha'], FILTER_SANITIZE_STRING);
if ($_SESSION['6_letters_code'] != $captcha) {
    $msg = "invalid captcha";
    $errors = "error";
}

if (!$errors) {
   
    
    $to = 'bineesh@beetroot.ae';
   
    $content = " Hi Administrator,<br><br>Following are the details of user tried to contact :<br><br>";
    $content.= " <table><tr><td>Name</td><td>:</td> <td>" . $name . "</td></tr>";
    $content.= " <tr><td>Email<td>:</td><td> " . $from . "</td></tr>";
    $content.= " <tr><td>Mobile<td>:</td><td>  " . $contact . "</td></tr>";        
    $content.= " <tr><td>Message<td>:</td><td>  " . $message. "</td></tr></table>";
    $content.= " Thank you.";
    
    $send_contact = sendMail($from, $name, $to, "Contact Us", $content);
  
    if ($send_contact) {
        $msg = "OK";
    } else {
        $msg = "sending failed";
    }
} else {
    if ($msg == "") {
        $msg = "sending failed";
    }
}



echo $msg;

exit;


function sendMail($from, $fromName = '', $to,$subject, $message) {
    iconv_set_encoding("internal_encoding", "UTF-8");
    $mail = new PHPMailer;

//    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 4; //To debug
    $mail->Host = 'techvante.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'info@techvante';                 // SMTP username
    $mail->Password = 'Te3HvAnt3#2016';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to



    $mail->setFrom($from, $fromName);
    $mail->addAddress($to);     // Add a recipient

    $mail->Subject = $subject;

    $mail->MsgHTML($message);
   
    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}