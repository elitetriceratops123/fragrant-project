<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

//Load Composer's autoloader
require 'vendor/autoload.php';

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zain";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['customer-email'];
    $phone = $_POST['customer-phone'];
    $address = $_POST['address'];
    
    // SQL query to insert data into the table
    $sql = "INSERT INTO customers (first_name, last_name, email, phone, address)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        
        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'za986137@gmail.com';               // SMTP username
            $mail->Password   = 'arqi kihe bwjh pfaf';                  // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('za986137@gmail.com', 'Fragrant');
            $mail->addAddress($email, $firstName . ' ' . $lastName);    // Add a recipient

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Thank you for registering';
            $mail->Body    = 'Dear ' . $firstName . ' ' . $lastName . ',<br><br>Thank you for registering. We have received your details and will get back to you soon.<br><br>Regards,<br>Perfume Store';
            $mail->AltBody = 'Dear ' . $firstName . ' ' . $lastName . ',\n\nThank you for registering. We have received your details and will get back to you soon.\n\nRegards,\nPerfume Store';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
