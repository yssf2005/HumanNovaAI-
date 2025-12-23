<?php
/*
 * Simple Mailer service.
 * - Uses PHPMailer (if installed via Composer) for SMTP or mail transport.
 * - Falls back to PHP `mail()` if PHPMailer is not available.
 *
 * Example:
 *   Mailer::send('user@example.com', 'Welcome', '<p>Hello</p>');
 */

class Mailer
{
    // Attempt to load Composer autoloader if available
    protected static function ensureAutoload()
    {
        $autoload = __DIR__ . '/../../vendor/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
        }
    }

    /**
     * Send an email.
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param bool $isHtml
     * @return bool
     */
    public static function send($to, $subject, $body, $isHtml = true)
    {
        // Try to ensure Composer autoloader is loaded so PHPMailer classes are available
        self::ensureAutoload();

        // Prefer PHPMailer if available
        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            try {
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

                if (defined('MAIL_DRIVER') && MAIL_DRIVER === 'smtp') {
                    $mail->isSMTP();
                    $mail->Host = MAIL_SMTP_HOST;
                    $mail->Port = MAIL_SMTP_PORT;
                    $mail->SMTPAuth = true;
                    $mail->Username = MAIL_SMTP_USER;
                    $mail->Password = MAIL_SMTP_PASS;
                    if (!empty(MAIL_SMTP_SECURE)) {
                        $mail->SMTPSecure = MAIL_SMTP_SECURE;
                    }
                } else {
                    // Use default mail transport
                    $mail->isMail();
                }

                $fromAddress = defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'no-reply@example.com';
                $fromName = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : '';

                $mail->setFrom($fromAddress, $fromName);
                $mail->addAddress($to);
                $mail->isHTML($isHtml);
                $mail->Subject = $subject;
                $mail->Body = $body;
                if ($isHtml) {
                    // Provide a plain-text alternative
                    $mail->AltBody = strip_tags($body);
                }

                return $mail->send();
            } catch (Exception $e) {
                return false;
            }
        }

        // Fallback to PHP mail()
        $headers = [];
        $fromAddress = defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'no-reply@example.com';
        $fromName = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : '';
        $headers[] = 'From: ' . ($fromName ? $fromName . ' <' . $fromAddress . '>' : $fromAddress);
        $headers[] = 'MIME-Version: 1.0';
        if ($isHtml) {
            $headers[] = 'Content-type: text/html; charset=utf-8';
        } else {
            $headers[] = 'Content-type: text/plain; charset=utf-8';
        }

        $headersStr = implode("\r\n", $headers);

        return mail($to, $subject, $body, $headersStr);
    }
}
