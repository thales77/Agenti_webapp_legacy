<?php

ini_set( "log_errors", true );
ini_set( "error_reporting", E_ALL );
ini_set( "error_log", "/error_log" );

date_default_timezone_set( "Europe/Rome" );
define( "APP_URL", "index.php" );
define( "DB_DSN", "mysql:host=localhost;dbname=Ferramenta" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "antipax0s" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "PASSWORD_EMAIL_FROM_NAME", "Sidercampania Professional srl" );
define( "PASSWORD_EMAIL_FROM_ADDRESS", "info@siderptofessional.com" );
define( "PASSWORD_EMAIL_SUBJECT", "La tua nuova password" );
define( "PASSWORD_EMAIL_APP_URL", "http://www.siderprofessional.com/riservata/" );
require( CLASS_PATH . "/User.php" );
require( CLASS_PATH . "/Client.php" );
require( CLASS_PATH . "/Item.php" );
require( CLASS_PATH . "/SalesHistory.php" );
require( CLASS_PATH . "/Log.php" );
?>