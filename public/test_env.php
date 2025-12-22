<?php
// load config so constants are defined
@include_once __DIR__ . '/../config/config.php';

echo 'SITE=' . (defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : 'MISSING') . "<br>";
echo 'SECRET=' . (defined('RECAPTCHA_SECRET') ? (RECAPTCHA_SECRET ? 'SET' : 'EMPTY') : 'MISSING') . "<br>";
echo 'ENFORCE=' . (defined('RECAPTCHA_ENFORCE') ? (RECAPTCHA_ENFORCE ? '1' : '0') : 'MISSING');