<?php



/* URL PROJECT */

define ('SITE_URL', 'http://gym.fitness5.in/Backend/index.php');

/* DATABASE CONFIGURATION */

$database = array(
'host' => "127.0.0.1",
'db' => "f5live",
'user' => "root",
'pass' => ""
);

$email_config = array(
'email_address' => 'EMAIL_ADDRESS_HERE',
'email_password' => 'PASSWORD_HERE',
'email_subject' => 'EMAIL_SUBJECT_HERE',
'email_name' => 'EMAIL_NAME_HERE',
'smtp_host' => 'EMAIL_HOST_HERE',
'smtp_port' => 'EMAIL_PORT_HERE',
'smtp_encrypt' => 'tls'
);

$items_config = array(
    
    'items_per_page' => '8',
    'images_folder' => 'images/'
);


?>