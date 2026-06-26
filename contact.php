<?php



require_once __DIR__ . '/../web/vendor/autoload.php';

echo "Autoload exists: ";
var_dump(file_exists(__DIR__ . '/../web/vendor/autoload.php'));

echo "<br>PHPMailer class: ";
var_dump(class_exists('PHPMailer\\PHPMailer\\PHPMailer'));

exit;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../web/app/config.php';
require_once __DIR__ . '/../web/vendor/autoload.php';

var_dump(class_exists('PHPMailer\\PHPMailer\\PHPMailer'));
exit;

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

    $mail->Body = "
        <h2>Hello {$safeName}! 👋</h2>

        <p>Thank you for contacting me.</p>

        <p>I have received your message and will get back to you as soon as possible, usually within <strong>24 hours</strong>.</p>

        <h3>Your Message</h3>

        <blockquote style='border-left:4px solid #fe8d14;padding-left:15px;'>
            {$safeMessage}
        </blockquote>

        <p>Best regards,<br>
        <strong>Samira Omar</strong><br>
        Website Developer</p>
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