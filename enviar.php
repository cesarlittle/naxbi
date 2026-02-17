
<?php
require __DIR__ . '/../config.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {

    // 🔹 CONFIG SMTP HOSTINGER
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;

    $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);


    // 🔹 DESTINO
    $mail->addAddress('contacto@naxbi.com');

    // 🔹 PARA PODER RESPONDER AL CLIENTE
    if (!empty($_POST['email'])) {
    $mail->addReplyTo($_POST['email'], $_POST['nombre']);
}


    // 🔹 CONTENIDO
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo contacto desde la web NAXBI';

    $mail->Body = "
        <h2>Nuevo mensaje desde NAXBI</h2>

        <b>Nombre:</b> " . htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8') . " <br>
        <b>Email:</b> " . htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') . " <br>
        <b>Agencia:</b> " . htmlspecialchars($_POST['agencia'], ENT_QUOTES, 'UTF-8') . " <br>
        <b>Asunto:</b> " . htmlspecialchars($_POST['asunto'], ENT_QUOTES, 'UTF-8') . " <br>
        <b>Mensaje:</b><br> " . htmlspecialchars($_POST['mensaje'], ENT_QUOTES, 'UTF-8') . " <br>
    ";

    $mail->AltBody = "Nuevo mensaje desde la web";

    if ($mail->send()) {
        echo "OK";
    } else {
        echo $mail->ErrorInfo;
    }
    
    } catch (Exception $e) {
        echo "ERROR: {$mail->ErrorInfo}";
}
