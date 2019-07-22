<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

<div class="sexyBeast"> 
        

<?php 

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'includes/config.php';




if(isset($_POST["email"])) {

    $emailTo = $_POST["email"];

    $code = uniqid(true);
    $query = mysqli_query($con, "INSERT INTO resetPasswords(code, email) VALUES('$code', '$emailTo')");
    if(!$query) {
        exit("Error dude");
    }

$mail = new PHPMailer(true);
   try {
        //Server settings
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'morsetunes@gmail.com';                     // SMTP username
        $mail->Password   = '12give!!!';                               // SMTP password
        $mail->SMTPSecure = 'tls';                                 // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('morsetunes@gmail.com', 'Beam');
        $mail->addAddress($emailTo);     // Add a recipiental
        $mail->addReplyTo('no-reply.morsetunes@gmail.com', 'No Reply');

        
        // Content
        $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . 
            "/resetPassword.php?code=$code";
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your password reset link';
        $mail->Body    = "<h1>You requested a password reset</h1>
                            Click <a href='$url'>this link</a> to do so";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Reset password link has been sent to your email, you sexy BEAST!';
    } catch (Exception $e) {
        echo "Password reset link could not be sent because of : {$mail->ErrorInfo}";
    }
    exit();

}


 ?>

       
</div>     


</body>
</html>

<link rel="stylesheet" type="text/css" href="assets/css/style.css">


  <div class="userDetails">
        <div class="container borderBottom">

        <form method="POST">
        
        <input type="text" name="email" placeholder=" Enter Your Email" autocomplete="off">
        <br>
        <button class="button">Reset Password</button>
        <h2>Place your user email in the space above to receive your reset password link</h2>
        </form>
        </div>
 </div>


 

 