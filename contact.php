<?php



/*---require_once __DIR__ . '/../web/vendor/autoload.php';

echo "Autoload exists: ";
var_dump(file_exists(__DIR__ . '/../web/vendor/autoload.php'));

echo "<br>PHPMailer class: ";
var_dump(class_exists('PHPMailer\\PHPMailer\\PHPMailer'));

exit; --*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../web/app/config.php';
require_once __DIR__ . '/../web/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/* =========================
   SESSION SAFETY
========================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   ONLY POST ALLOWED
========================= */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit;
}

/* =========================
   HONEYPOT (ANTI-SPAM)
========================= */
if (!empty($_POST['website'] ?? '')) {
    exit("❌ Spam detected");
}

/* =========================
   RATE LIMIT
========================= */
if (!isset($_SESSION['last_submit'])) {
    $_SESSION['last_submit'] = 0;
}

if (time() - $_SESSION['last_submit'] < 10) {
    exit("❌ Please wait before sending again");
}

$_SESSION['last_submit'] = time();

/* =========================
   GET DATA
========================= */
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    exit("❌ All fields are required");
}

/* =========================
   SAVE TO DATABASE
========================= */
$stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");

if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $email, $message);

/* =========================
   EXECUTE
========================= */
if ($stmt->execute()) {


    /* =========================
       TELEGRAM SAFE SEND
    ========================= */
    $botToken = $_ENV['TELEGRAM_BOT_TOKEN'] ?? null;
    $chatID = $_ENV['TELEGRAM_CHAT_ID'] ?? null;

    if ($botToken && $chatID) {

        $website = $_SERVER['HTTP_HOST'];
        $text = "📩 New Contact Form Message\n\n"
            . "🌐 Source: $website\n"
            . "👤 Name: $name\n"
            . "📧 Email: $email\n"
            . "💬 Message: $message";

        file_get_contents(
            "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=" . urlencode($text)
        );
    }

    /* =========================
   AUTO REPLY EMAIL
========================= */

    try {

        $mail = new PHPMailer(true);

        /* =========================
   PANG DEBUG SA AUTO REPLY--> 
       $mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
========================= */


        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) $_ENV['SMTP_PORT'];

        $mail->setFrom(
            $_ENV['SMTP_USER'],
            $_ENV['SMTP_FROM_NAME']
        );

        // Send to the visitor
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Your Message Has Been Received";

        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        $mail->Body = "
        <div style='background:#f6f6f6;padding:30px 0;font-family:Arial,sans-serif;'>
        
          <div style='max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 8px 20px rgba(0,0,0,0.08)'>
        
            <!-- Header -->
            <div style='background:linear-gradient(135deg,#fe8d14,#ffb347);padding:25px;text-align:center;color:#fff;box-shadow:0 0 10px'>
              <h2 style='margin:0;font-size:22px;'>Thank You for Reaching Out!</h2>
              <p style='margin:5px 0 0;'>{$safeName} 😊</p>
            </div>
        
            <!-- Body -->
            <div style='padding:30px;color:#333;line-height:1.6;'>
        
              <h3 style='margin-top:0;'>Hi {$safeName} 👋</h3>
        
              <p>Thank you for contacting me. I’ve received your message and truly appreciate you taking the time to reach out.</p>
        
              <div style='background:#fff7ef;border-left:5px solid #fe8d14;padding:15px;margin:20px 0;border-radius:8px;'>
                ⏱ I'll get back to you as soon as possible, usually within <b>24 hours</b>.
              </div>
        
            <p>In the meantime, feel free to
              <a href='https://calendly.com/samiraomar/30min' style='color:#fe8d14;font-weight:bold;text-decoration:none;'>book a free discovery  call</a>
              — it's free and a great chance to chat about your project and see if we're a good fit.</p>

              <p>Looking forward to connecting with you!</p>
        
              <p style='margin-top:25px;'>Best regards,<br>
              <b>Samira Omar</b></p>
        
            </div>
        
            <!-- Footer -->
            <div style='background:linear-gradient(135deg,#fe8d14,#ffb347);padding:20px;text-align:center;font-size:12px;color:#fff;'>
              Building modern websites that help businesses grow.
            </div>
        
          </div>
        </div>
        ";

        $mail->send();

    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }

    echo "✅ Message sent successfully";

} else {
    echo "❌ Database error: " . $stmt->error;
}

$stmt->close();
$conn->close();