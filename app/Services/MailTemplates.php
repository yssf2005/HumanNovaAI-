<?php
namespace App\Services;

class MailTemplates
{
    /**
     * Return a professional HTML email for password reset.
     * @param string $recipientName
     * @param string $resetLink
     * @param int $hoursValid
     * @param string|null $appName
     * @return string
     */
    public static function resetPassword(string $recipientName, string $resetLink, int $hoursValid = 1, string $appName = null): string
    {
        $appName = $appName ?? (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Our App');
        $recipientNameEsc = htmlspecialchars($recipientName ?: '');
        $resetLinkEsc = htmlspecialchars($resetLink);
        $hours = (int)$hoursValid;

        return <<<HTML
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Reset your password</title>
  <style>
    body { background:#f4f6f8; color:#333; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; margin:0; padding:0; }
    .email-wrap { max-width:600px; margin:32px auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
    .header { background:linear-gradient(90deg,#4cc9f0,#7d84ff); padding:28px; color:#fff; text-align:center; }
    .header h1 { margin:0; font-size:20px; letter-spacing:0.4px; }
    .content { padding:28px; }
    .btn { display:inline-block; background:#1f6feb; color:#fff; padding:12px 22px; border-radius:6px; text-decoration:none; font-weight:600; }
    .muted { color:#657786; font-size:14px; }
    .footer { padding:20px; text-align:center; font-size:12px; color:#9aa4b2; }
    .card { background:#f8fbff; border:1px solid #eef6ff; padding:16px; border-radius:6px; margin-top:16px; }
    @media (max-width:480px){ .email-wrap{margin:12px} .content{padding:18px} }
  </style>
</head>
<body>
  <div class="email-wrap">
    <div class="header">
      <h1>{$appName}</h1>
    </div>
    <div class="content">
      <p class="muted">Bonjour {$recipientNameEsc},</p>

      <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte sur <strong>{$appName}</strong>.</p>

      <div class="card">
        <p style="margin:0 0 12px 0;">Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe. Ce lien expirera dans <strong>{$hours} heure(s)</strong>.</p>
        <p style="text-align:center; margin:16px 0 0 0;"><a href="{$resetLinkEsc}" class="btn">Réinitialiser mon mot de passe</a></p>
      </div>

      <p style="margin-top:18px;">Si le bouton ne fonctionne pas, copiez-collez ce lien dans votre navigateur :</p>
      <p class="muted"><a href="{$resetLinkEsc}">{$resetLinkEsc}</a></p>

      <p class="muted" style="margin-top:18px;">Si vous n'avez pas demandé cette réinitialisation, vous pouvez ignorer cet e-mail. Votre mot de passe restera inchangé.</p>

      <p style="margin-top:24px;">Cordialement,<br><strong>{$appName} — Équipe Support</strong></p>
    </div>
    <div class="footer">
      <div>{$appName} — Sécurité et confidentialité</div>
    </div>
  </div>
</body>
</html>
HTML;
    }

    public static function ideaApproved(string $recipientName, string $ideaTitle, string $appName = null): string
    {
        $appName = $appName ?? (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Our App');
        $recipient = htmlspecialchars($recipientName ?: '');
        $title = htmlspecialchars($ideaTitle);
        return "<p>Bonjour {$recipient},</p><p>Votre idée <strong>\"{$title}\"</strong> a été approuvée par l'équipe. Elle est maintenant visible sur {$appName}.</p><p>Merci pour votre contribution.</p>";
    }

    public static function investmentReceipt(string $recipientName, string $ideaTitle, float $amount, string $appName = null): string
    {
        $appName = $appName ?? (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Our App');
        $recipient = htmlspecialchars($recipientName ?: '');
        $title = htmlspecialchars($ideaTitle);
        $amt = number_format($amount, 2);
        return "<p>Bonjour {$recipient},</p><p>Merci pour votre investissement de <strong>{$amt} USD</strong> dans l'idée <strong>\"{$title}\"</strong> sur {$appName}.</p><p>Votre contribution aide à faire avancer ce projet.</p>";
    }

    public static function postApproved(string $recipientName, string $appName = null): string
    {
        $appName = $appName ?? (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Our App');
        $recipient = htmlspecialchars($recipientName ?: '');
        return "<p>Bonjour {$recipient},</p><p>Votre publication a été approuvée et est maintenant visible sur {$appName}.</p>";
    }

    public static function eventApproved(string $recipientName, string $eventTitle, string $appName = null): string
    {
        $appName = $appName ?? (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Our App');
        $recipient = htmlspecialchars($recipientName ?: '');
        $title = htmlspecialchars($eventTitle);
        return "<p>Bonjour {$recipient},</p><p>Votre événement <strong>\"{$title}\"</strong> a été approuvé par l'équipe et est maintenant publié sur {$appName}.</p>";
    }

    public static function eventParticipationReceipt(string $recipientName, string $eventTitle, string $eventDate = '', string $location = '', string $appName = null): string
    {
      $appName = $appName ?? (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Our App');
      $recipient = htmlspecialchars($recipientName ?: '');
      $title = htmlspecialchars($eventTitle);
      $date = htmlspecialchars($eventDate ?: '');
      $loc = htmlspecialchars($location ?: '');

      return "<p>Bonjour {$recipient},</p>"
        . "<p>Merci pour votre inscription à l'événement <strong>\"{$title}\"</strong> sur {$appName}.</p>"
        . ($date ? "<p>🗓️ Date: <strong>{$date}</strong></p>" : "")
        . ($loc ? "<p>📍 Lieu: <strong>{$loc}</strong></p>" : "")
        . "<p>Nous avons hâte de vous y voir.</p>";
    }

    public static function jobApproved(string $recipientName, string $jobTitle, string $appName = null): string
    {
        $appName = $appName ?? (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Our App');
        $recipient = htmlspecialchars($recipientName ?: '');
        $title = htmlspecialchars($jobTitle);
        return "<p>Bonjour {$recipient},</p><p>Votre offre d'emploi <strong>\"{$title}\"</strong> a été approuvée et est maintenant visible sur {$appName}.</p>";
    }
}
