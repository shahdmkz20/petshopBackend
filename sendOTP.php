<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload file

// Function to send OTP to the specified email address
function sendOTP($email, $verificationCode) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'petshop1542024@gmail.com';             // SMTP username
        $mail->Password   = 'bxlmrmsyirxmdmla';                     // SMTP password (your Gmail password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('petshop1542024@gmail.com', 'Pet shop');     // Sender's email address and name
        $mail->addAddress($email);                                  // Recipient's email address

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Your verification code is: ' . $verificationCode;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $mail->send();
    
        return true; // Return true if email sent successfully
    } catch (Exception $e) {
        echo ''. $e->getMessage() .'';
        // Handle exception
        return false; // Return false if email sending failed
    }
} 