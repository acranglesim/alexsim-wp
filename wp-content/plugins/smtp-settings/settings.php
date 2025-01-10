<?php
/**
 * Plugin Name: SMTP Settings
 * Plugin URI:
 * Description: SMTP override
 * Version: 2.5.4
 * Text Domain: settings
 */


add_action( 'phpmailer_init', 'custom_php_mailer_init' );
function custom_php_mailer_init( \PHPMailer\PHPMailer\PHPMailer $phpmailer ) {
    $phpmailer->Host = 'smtp.ionos.co.uk';
    $phpmailer->Port =465; // could be different
    $phpmailer->Username = 'system@alexandchelsea.co.uk'; // if required
    $phpmailer->Password = 'WxVvV&0ON3$j%P'; // if required
    $phpmailer->SMTPAuth = true; // if required
    $phpmailer->SMTPSecure = 'ssl'; // enable if required, 'tls' is another possible value

    $phpmailer->IsSMTP();
}