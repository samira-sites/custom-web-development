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
        $mail->Subject = "Thank you for contacting Samira Omar";

        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

        $mail->isHTML(true);
        $mail->Subject = "Thank you for contacting Samira Omar";
        
        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        
        $mail->Body = "
        <div style='background:#f3f4f6;padding:40px 0;font-family:Arial,sans-serif;'>
        
          <div style='max-width:600px;margin:0 auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 12px 35px rgba(0,0,0,0.12)'>
        
            <!-- Header -->
            <div style='
              background:linear-gradient(135deg,#ff8a00,#ffb347);
              padding:35px 25px;
              text-align:center;
              color:#fff;
            '>
        
              <div style='font-size:13px;letter-spacing:2px;opacity:0.9;margin-bottom:10px;'>
                AUTOMATED RESPONSE
              </div>
        
              <h1 style='margin:0;font-size:24px;letter-spacing:0.5px;'>
                Thank You for Reaching Out
              </h1>
        
              <p style='margin:10px 0 0;font-size:14px;opacity:0.95;'>
                I’ve received your message and will respond shortly
              </p>
        
            </div>
        
            <!-- Body -->
            <div style='padding:35px;color:#2b2b2b;line-height:1.7;'>
        
              <h3 style='margin-top:0;font-size:18px;'>Hello {$safeName} 👋</h3>
        
              <p style='font-size:14px;color:#555;'>
                Thank you for getting in touch. I appreciate your interest and I’ve successfully received your message.
                I’ll carefully review your request and get back to you as soon as possible.
              </p>
        
              <!-- Highlight Box -->
              <div style='
                background:linear-gradient(135deg,#fff7ed,#fff);
                border:1px solid #ffe0b2;
                border-left:5px solid #ff8a00;
                padding:18px;
                margin:25px 0;
                border-radius:10px;
              '>
                <p style='margin:0;font-size:14px;'>
                  ⏱ <b>Response time:</b> within 24 hours (usually much faster)
                </p>
              </div>
        
              <!-- CTA Box -->
              <div style='
                text-align:center;
                background:#f9fafb;
                padding:20px;
                border-radius:12px;
                margin:25px 0;
                border:1px solid #eee;
              '>
        
                <p style='margin:0 0 10px;font-size:13px;color:#666;'>
                  Need a faster response?
                </p>
        
                <a href='mailto:your@email.com' style='
                  display:inline-block;
                  padding:10px 18px;
                  background:#111;
                  color:#fff;
                  text-decoration:none;
                  border-radius:8px;
                  font-size:13px;
                '>
                  Reply Instantly
                </a>
        
              </div>
        
              <p style='margin-top:25px;font-size:14px;color:#555;'>
                Best regards,<br>
                <b style='color:#111;'>Samira Omar</b><br>
                <span style='font-size:13px;color:#777;'>Website Developer</span>
              </p>
        
            </div>
        
            <!-- Footer -->
            <div style='
              background:#0f172a;
              color:#cbd5e1;
              text-align:center;
              padding:18px;
              font-size:12px;
            '>
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