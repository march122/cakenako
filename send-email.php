<!-- <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'C:\xampp\htdocs\Cake\PHPMailer-master/to/PHPMailer/src/Exception.php';
require 'C:\xampp\htdocs\Cake\PHPMailer-master/to/PHPMailer/src/PHPMailer.php';
require 'C:\xampp\htdocs\Cake\PHPMailer-master/to/PHPMailer/src/SMTP.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $subject = htmlspecialchars($_POST['subject']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['company_name']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'marchanthonydelapean@gmail.com'; // Your Gmail address
        $mail->Password = 'your-email-password'; // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom($email, $name);
        $mail->addAddress('marchantondelapena1@gmail.com'); // Your email address
        $mail->Subject = "Message from SweetCakes Website: $subject";
        $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

        $mail->send();
        echo "<script>
                alert('Your message has been sent successfully!');
                window.location.href = 'contact.php';
              </script>";
    } catch (Exception $e) {
        echo "Failed to send email: {$mail->ErrorInfo}";
    }
}
?> -->
