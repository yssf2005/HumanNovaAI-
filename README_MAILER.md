Composer and PHPMailer installation
==================================

If you want full SMTP support, install Composer and PHPMailer. Two options are shown below.

Option A — Install Composer (recommended)
- Download and run the Windows installer from https://getcomposer.org/Composer-Setup.exe
- After install, open a new PowerShell in the project folder and run:

```powershell
composer require phpmailer/phpmailer
```

If `composer` is not in your PATH but you have XAMPP PHP at `C:\xampp1\php\php.exe`, you can use the phar installer:

```powershell
# Download installer
"C:\\xampp1\\php\\php.exe" -r "copy('https://getcomposer.org/installer','composer-setup.php');"
# Run installer
"C:\\xampp1\\php\\php.exe" composer-setup.php
# Remove installer
"C:\\xampp1\\php\\php.exe" -r "unlink('composer-setup.php');"
# Install PHPMailer using the generated composer.phar
"C:\\xampp1\\php\\php.exe" composer.phar require phpmailer/phpmailer
```

After installing, the project will have `vendor/autoload.php`, and the `Mailer` service will automatically load it.

Option B — Manual install (quick alternative)
- Download PHPMailer from https://github.com/PHPMailer/PHPMailer/releases and extract into `app/Libraries/PHPMailer`.
- Include required files in `public/index.php` or before using the `Mailer` class, for example:

```php
require_once __DIR__ . '/../app/Libraries/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../app/Libraries/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../app/Libraries/PHPMailer/src/Exception.php';
```

Usage
-----
Call the helper:

```php
Mailer::send('user@example.com', 'Subject', '<p>HTML message</p>');
```

Configuration
-------------
Edit `config/config.php` to set `MAIL_DRIVER`, `MAIL_SMTP_HOST`, `MAIL_SMTP_USER`, etc.