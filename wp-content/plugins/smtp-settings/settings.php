<?php

add_action( 'phpmailer_init', 'custom_php_mailer_init' );
function custom_php_mailer_init( PHPMailer $phpmailer ) {
    $phpmailer->Host = 'smtp.ionos.co.uk';
    $phpmailer->Port =465; // could be different
    $phpmailer->Username = 'system@alexandchelsea.co.uk'; // if required
    $phpmailer->Password = 'WxVvV&0ON3$j%P'; // if required
    $phpmailer->SMTPAuth = true; // if required
    $phpmailer->SMTPSecure = 'ssl'; // enable if required, 'tls' is another possible value

    $phpmailer->IsSMTP();
}