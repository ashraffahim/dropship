<?php

// Date & Time
date_default_timezone_set('UTC');

// Database constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '646862');
define('DB_NAME', 'grap_db');
define('ROW_LIMIT', 20);

// Software
define('DS', DIRECTORY_SEPARATOR);
define('DOMAIN', 'http://menu');
define('BASEDIR', '');
define('DATA', 'http://dropship-ftp');
define('DATADIR', '..'.DS.'..'.DS.'dropship-seller'.DS.'data');
define('LOGO', 'http://dropship/assets/img/grap-logo.png');
define('SITENAME', '');
define('APP_VERSION', '1.0.0');

// User
define('SALES_TEL', '+971556314003');
define('SALES_EMAIL', 'sales@alghaim.com');
define('TECH_EMAIL', 'support@alghaim.com');

// Server
define('SMTP', 'mail.grap.store');
define('SMTP_PORT', '2525');

// Payment API Env Var
define('STRIPE_API_KEY', 'sk_test_51JGXp4IoGl18YWC8sqlP7TeCjGpezoYpn45HwDmSUWGmNLCeKG5EfdY2ZUYCQATLhovA4HuevEdSPH1Xp0yGhqFI00tEdFGqMx');
define('STRIPE_ENDPOINT_SECRET', 'whsec_66fbe7b4834241a1ec5e3faebcacb3f1b8e4e4d49f1474eef8b0c46fdc02c50f');

?>